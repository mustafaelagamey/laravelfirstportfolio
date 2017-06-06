<?php

namespace App\Http\Controllers;

use App\Events\ExecutedAction;
use App\Image;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class postController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware('activation', ['except' => ['index']]);


        $privileges = [
//            'post.read'=>[],  // subscriber
//            'post.create'=>,  // creator
//            'post.edit'=>[''],   //editor
//            'post.delete'=>[], // admin
//            'post.deletePermanent'=>[], // main admin

            'post.read' => ['index'],
            'post.create' => ['create', 'store'],
            'post.edit' => ['edit', 'update'],
            'post.delete' => ['destroy'],
            'post.deletePermanent' => ['permanentDelete'],
            'post.restore' => ['restore'],

        ];

        foreach ($privileges as $key => $privilege) {
            $this->middleware('privilege:' . $key, ['only' => $privilege]);

        }


//        $this->middleware('privilege:user.read', ['only' => ['index']]);
//        $this->middleware('privilege:user.create', ['only' => ['create', 'store']]);
//        $this->middleware('privilege:user.deactivate', ['only' => ['deactivate' ]]);
//        $this->middleware('privilege:user.fullRead', ['only' => ['indexAdmin']]);
//        $this->middleware('privilege:user.edit', ['only' => ['edit', 'update']]);
//        $this->middleware('privilege:user.activate', ['only' => [ ]]);
//        $this->middleware('privilege:mainAdmin', ['only' => ['restore' ]]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        if (Auth::user()->hasAccess(['post.deletePermanent', 'post.restore']))
            return $this->indexAdmin();


        $posts = Post::paginate(20);


        return view('post.index', compact('posts'));
    }

    public function indexAdmin()
    {
        //

        $posts = Post::withTrashed()->get();


        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('post.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, ['title' => 'required|min:25', 'subject' => 'required|min:35', 'image' => 'image|max:100']);
        $post = new Post();
        $post->title = $request->title;
        $post->subject = $request->subject;
        $post->save();

        if ($request->hasFile('image')) {
            if (!is_null($request->image))
                ImageController::storePostImage($post,$request->image);
        }
        if ($request->has('tags')) {
            $tags = explode(' ', $request->tags);
            TagController::storeNewPostTags($tags, $post);
        }


        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $post));


        return Redirect::route('post.index');

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::with('comments.user')->findOrFail($id);
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::findOrFail($id);
        return view('post.edit', compact('post'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $this->validate($request, ['title' => 'required|min:25', 'subject' => 'required|min:35', 'image' => 'image|max:100']);
        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->subject = $request->subject;

        if ($request->hasFile('image')) {
            if (!is_null($request->image))
                ImageController::updatePostImage($post, $request->image);
        }

        $post->save();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $post));

        return Redirect::route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $post = Post::findOrFail($id);
        $post->delete();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $post));

        return Redirect::route('post.index');

    }

    public function permanentDelete($id)
    {

        //
        $post = Post::withTrashed()->findOrFail($id);

        $post->comments()->delete();
        $post->tags()->detach();

        //delete relation between post and image
        if (!is_null($post->image))
            $post->image->post()->dissociate()->save();

        ////// Manually delete relation between post and image
//        $relatedImage=$post->image;
//        $relatedImage->post_id=null;
//        $relatedImage->save();

        $post->forceDelete();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $post));
        return Redirect::route('post.index');
    }

    public function restore($id)
    {
        //
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $post));
        return Redirect::route('post.index');
    }
}
