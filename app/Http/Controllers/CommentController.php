<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Events\ExecutedAction;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Mockery\Exception;

class CommentController extends Controller
{
    function __construct()
    {


        $privileges = [
//            'post.read'=>[],  // subscriber
//            'post.create'=>,  // creator
//            'post.edit'=>[''],   //editor
//            'post.delete'=>[], // admin
//            'post.deletePermanent'=>[], // main admin

            'comment.read' => ['index'],
            'comment.create' => ['create', 'store'],
            'comment.edit' => ['edit', 'update'],
            'comment.delete' => ['destroy'],
            'comment.deletePermanent' => ['permanentDelete'],
            'comment.restore' => ['restore'],

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
    public function index($commentable = null)
    {
        //
        $withTrashed = Auth::user()->hasAccess(['comment.deletePermanent', 'comment.restore']);


        if (!is_null($commentable)) {
            if ($withTrashed)
                $comments = Comment::where('commentable_type', 'App\\' . ucfirst(strtolower($commentable)))->with('user', 'commentable')->withTrashed()->orderBy('id', 'desc')->paginate(200);
            else
                $comments = Comment::where('commentable_type', 'App\\' . ucfirst(strtolower($commentable)))->with('user', 'commentable')->orderBy('id', 'desc')->paginate(20);
//


       /* if ($commentable === 'post') {
            $comments = Comment::with('user', 'commentable')->where('commentable_type', '\App\Post')->orderBy('id', 'desc')->paginate(20);
            if ($withTrashed)
                $comments = Comment::where('commentable_type', 'App\Post')->with('user', 'commentable')->withTrashed()->orderBy('id', 'desc')->paginate(200);
        } elseif ($commentable === 'image') {
            $comments = Comment::with('user', 'commentable')->where('commentable_type', '\App\Image')->orderBy('id', 'desc')->paginate(20);
            if ($withTrashed)
                $comments = Comment::where('commentable_type', 'App\Image')->with('user', 'commentable')->withTrashed()->orderBy('id', 'desc')->paginate(200);*/

        } else {
            $comments = Comment::with('user', 'commentable')->orderBy('id', 'desc')->paginate(20);
            if ($withTrashed)
                $comments = Comment::with('user', 'commentable')->withTrashed()->orderBy('id', 'desc')->paginate(200);
        }
        return view('comment.index', compact('comments', compact('withTrashed')));


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
        $this->validate($request, ['subject' => 'required|min:15', 'commentable_id' => 'required', 'commentable_type' => 'required']);
        try {


            $commentable = $request->commentable_type::findOrFail($request->commentable_id);
            $comment = new Comment();
            $comment->subject = $request->subject;
            $comment->user()->associate(Auth::user());
            $commentable->comments()->save($comment);

            event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $comment));

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }

        return Redirect::back();

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
        $comment = Comment::findOrFail($id);
        return view('comment.edit', compact('comment'));
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
        $this->validate($request, ['subject' => 'required|min:15']);
        $comment = Comment::findOrFail($id);
        $comment->subject = $request->subject;
        $comment->save();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $comment));

        return Redirect::route('comment.index');


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
        $destroyedComment = Comment::findOrFail($id);
        $destroyedComment->delete();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $destroyedComment));

        return Redirect::route('comment.index');

    }

    public function permanentDelete($id)
    {

        //
        $deletedComment = Comment::withTrashed()->findOrFail($id);
        $deletedComment->forceDelete();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $deletedComment));
        return Redirect::route('comment.index');

    }

    public function restore($id)
    {

        //
        $restoredComment = Comment::withTrashed()->findOrFail($id);
        $restoredComment->restore();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $restoredComment));
        return Redirect::route('comment.index');

    }

}
