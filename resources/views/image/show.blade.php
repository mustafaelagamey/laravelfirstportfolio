@extends('layouts.master')
@section('content')

    <h4 class="text-center">{{ $image->title }}</h4>
    <div class="row">
        <img src="/siteImages/{{ $image->name or 'siteImage.jpg'}}" alt="image" style="width: 300px; height: 300px">
        <h4>Post:
            @if($image->post !==null)
                <a href="{{route('post.show',['id'=>$image->post])}}">
                    {{$image->post->title }}
                </a>
            @else
                Images Album
            @endif
        </h4>

        <p>Image tags:
            <br>
            @forelse($image->tags as $tag)
                <span>
                {!! Html::linkRoute('tag.show',$tag->title,['id'=>$tag->id]) !!}
                </span>
            @empty
                <span>No tags for this image</span>
            @endforelse
        </p>


        <p>Image comments:
        @if(\Illuminate\Support\Facades\Auth::check())

            <ul>
                @foreach($image->comments as $comment)
                    <li>
                        <a>{{$comment->user->name}}:</a> {{$comment->subject}}
                    </li>
                @endforeach
            </ul>
        @else
            <p>To show the comments you must login</p>
            {!! Html::linkRoute('loginForm','Login',[],['class'=>'btn btn-primary text-right']) !!}
        @endif

    </div>

@endsection