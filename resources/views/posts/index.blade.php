@extends('layouts.master')




@section('content')

    <h1>
        Welcome in posts list.
    </h1>

    <div class="row">

        @foreach($posts as $post)

            <div class="col-xs-12 col-md-6 text-center">
                <a href="{{route('image.display',['id'=>$post->image])}}">

                    <img src="siteImages/{{ $post->image->name or 'siteImage.jpg'}}" alt="image"
                         style="width: 300px; height: 300px">
                </a>

                <a href="{{route('post.display',['id'=>$post->id])}}">
                    <h4 class="text-center">{{ substr($post->title,0,25).'...' }}</h4>
                    <p>{{substr($post->subject,0,50).'...'}}</p>
                </a>

            </div>

        @endforeach
    </div>
@endsection

