@extends('layouts.master')
@section('content')


    <h4 class="text-center">{{ $post->title }}</h4>

    @if(\Illuminate\Support\Facades\Auth::check())
        <p class="text-left">{{$post->subject}}</p>
        <p>Post tags:
            <br>
            @forelse($post->tags as $tag)
                <span>
                {!! Html::linkRoute('tag.show',$tag->title,['id'=>$tag->id]) !!}
                </span>
            @empty
                <span>No tags for this post</span>
            @endforelse
        </p>

        <span>Post comments:

        <ul>

            @forelse($post->comments as $comment)
                <li>
                    <a>{{$comment->user->name}}:</a> {{$comment->subject}}
                </li>
            @empty
                <li>No comments for this image</li>
            @endforelse

            @include('comment.smallForm' , ['userId'=>Auth::user()->id ,'commentableId'=>$post->id ,'commentableType'=>get_class($post) ,])


        </ul>       <!-- Prepended text http://getbootstrap.com/components/#input-groups -->

        </span>
    @else
        <p>To show the subject you must login</p>
        {!! Html::linkRoute('loginForm','Login',[],['class'=>'btn btn-primary text-right']) !!}
    @endif



    <div class="row">

        <a href="{{route('image.display',['id'=>$post->image])}}">
            <img src="/siteImages/{{ $post->image->name or 'siteImage.jpg'}}" alt="image"
                 style="width: 300px; height: 300px">
        </a>
        @if($post->image)
            <p>Image tags:
                <br>
                @forelse($post->image->tags as $tag)
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
                    @if($post->image)
                        @forelse($post->image->comments as $comment)
                            <li>
                                <a>{{$comment->user->name}}:</a> {{$comment->subject}}
                            </li>
                        @empty
                            <li>No comments for this image</li>
                        @endforelse
                        @include('comment.smallForm' , ['commentableId'=>$post->image->id ,'commentableType'=>get_class($post->image) ,])
                    @else
                        <li>No image for this post</li>
                    @endif
                </ul>

            @else
                <p>To show the comments you must login</p>
                {!! Html::linkRoute('loginForm','Login',[],['class'=>'btn btn-primary text-right']) !!}
            @endif
        @endif

    </div>
@endsection
