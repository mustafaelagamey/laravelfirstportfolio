<?php

namespace App\Http\Controllers;

use App\Events\ExecutedAction;
use App\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Mockery\Exception;
use Psy\Util\Str;

class TagController extends Controller
{

    function __construct()
    {


        $privileges = [
//            'post.read'=>[],  // subscriber
//            'post.create'=>,  // creator
//            'post.edit'=>[''],   //editor
//            'post.delete'=>[], // admin
//            'post.deletePermanent'=>[], // main admin

            'tag.read' => ['index'],
            'tag.create' => ['create', 'store'],
            'tag.edit' => ['edit', 'update'],
            'tag.delete' => ['destroy'],
            'tag.deletePermanent' => ['permanentDelete'],
            'tag.restore' => ['restore'],

        ];

        foreach ($privileges as $key => $privilege) {
            $this->middleware('privilege:' . $key, ['only' => $privilege]);

        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $withTrashed = Auth::user()->hasAccess(['tag.deletePermanent', 'tag.restore']);

        $tags = Tag::with('user', 'posts', 'images')->orderBy('id', 'desc')->paginate(20);
        if ($withTrashed)
            $tags = Tag::with('user', 'posts', 'images')->withTrashed()->orderBy('id', 'desc')->paginate(200);

        return view('tag.index', compact('tags', compact('withTrashed')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

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
        $this->validate($request, ['title' => 'required|max:15|min:3|regex:/\A[0-z]{3,} .+/', 'tagable_id' => 'required', 'tagable_type' => 'required']);
        try {
            $tagable = $request->tagable_type::findOrFail($request->tagable_id);
            $tagTitle = $request->title;
            $tagTitle = strtolower($tagTitle);
            $tagTitle = Str::words($tagTitle, 1,  '');
            $tag = Tag::whereTitle($tagTitle)->get()->first();
            if (is_null($tag)) {
                $tag = new Tag();
                $tag->title = $tagTitle;
                $tag->user()->associate(Auth::user());
            }
            $tagable->tags()->save($tag);
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }

        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $tag));

        return Redirect::back();

    }

    public function storePostTags(Request $request)
    {
        //
        $this->validate($request, ['title' => 'required|max:15|min:3|unique:tags|regex:/\A[0-z]{3,} .+/', 'tagable_id' => 'required', 'tagable_type' => 'required']);
        try {
            $tagable = $request->tagable_type::findOrFail($request->tagable_id);


            $tagTitle = $request->title;
            $tagTitle = strtolower($tagTitle);
            $tag = Tag::whereTitle($tagTitle)->get()->first();
            if (is_null($tag)) {
                $tag = new Tag();
                $tag->title = $tagTitle;
                $tag->user()->associate(Auth::user());
            }


            $tagable->tags()->save($tag);


            event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $tag));
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }

        return Redirect::back();
    }

    public static function storeNewPostTags(array $tags, Model $tagable)
    {
        //
        foreach ($tags as $tag) {

            $tagTitle = $tag;
            $tagTitle = strtolower($tagTitle);
            $tag = Tag::whereTitle($tagTitle)->get()->first();
            if (is_null($tag)) {
                $tag = new Tag();
                $tag->title = $tagTitle;
                $tag->user()->associate(Auth::user());


            }
            $tagable->tags()->save($tag);
            event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $tag));
        }
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
        $tag = Tag::with('posts', 'images', 'user')->findOrFail($id);
        return view('tag.show', compact('tag'));
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
        $tag = Tag::findOrFail($id);
        return view('tag.edit', compact('tag'));
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
        $this->validate($request, ['title' => 'required|max:15|unique:tags|regex:/\A[0-z]{3,} .+/']);


        $tag = Tag::findOrFail($id);
        $tag->title = explode(' ', $request->title)[0];
        $tag->save();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $tag));

        return Redirect::route('tag.index');
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
        $tag = Tag::findOrFail($id);
        $tag->delete();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $tag));

        return Redirect::route('tag.index');
    }

    public function permanentDelete($id)
    {
        //
        $tag = Tag::withTrashed()->findOrFail($id);
        $tag->posts()->detach();
        $tag->images()->detach();

        $tag->forceDelete();

        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $tag));

        return Redirect::route('tag.index');

    }

    public function restore($id)
    {
        //
        $tag = Tag::withTrashed()->findOrFail($id);
        $tag->restore();

        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $tag));

        return Redirect::route('tag.index');

    }


}
