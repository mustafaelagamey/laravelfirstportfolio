<?php

namespace App\Http\Controllers;

use App\Image;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DisplayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['posts']]);
    }

    public function home()
    {
        //

        $recentPosts = Post::with('image', 'image.comments')->orderBy('id', 'desc')->limit(12)->get();
        $latestPosts = $recentPosts->take(6);

        return view('home', compact('latestPosts', 'recentPosts'));
    }

    public function posts()
    {
        //

        $posts = Post::with('image')->orderBy('id', 'desc')->paginate(20);
        return view('posts.index', compact('posts'));
    }

    public function postShow($id)
    {
        //
        $post = Post::with('comments.user', 'image.comments.user')->findOrFail($id);

        return view('post.show', compact('post'));
    }


    public function images($album = null)
    {
        //

        if (is_null($album))
            //get both of album and not album images
            $images = Image::with('post')->orderBy('id', 'desc')->paginate(20);
        elseif ($album )
            $images = Image::with('post')->where('post_id', null)->orderBy('id', 'desc')->paginate(20);
        elseif (!$album)
            $images = Image::with('post')->where('post_id','<>', 'null')->orderBy('id', 'desc')->paginate(20);

        return view('images.index', compact('images'));
    }

    public function albumImages()
    {
        //get album images
        return $this->images(true);
    }

    public function postsImages()
    {
        //get not album images
        return $this->images(false);
    }


    public function imageShow($id)
    {
        //
        $image = Image::with('post', 'comments.user')->findOrFail($id);
        return view('image.show', compact('image'));
    }


}
