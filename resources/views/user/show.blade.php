@extends('layouts.master')
@section('content')


    <h2 class="text-left">{{ $user->email }}</h2>
    <h3 class="text-left">{{ $user->name }}</h3>

    @if(\Illuminate\Support\Facades\Auth::check())

        <h4 class="text-left">{{$user->role->name}}</h4>
        <div>User written posts:
            <ul>
                @forelse($user->writtenPosts as $post)
                    <li>
                        {!! Html::linkRoute('post.show',$post->title,['id'=>$post->id]) !!}
                    </li>
                @empty
                    <li>No written for this user</li>
                @endforelse
            </ul>
        </div>
        <div>User updated posts:

            <ul>
                @forelse($user->updatedPosts as $post)
                    <li>
                        {!! Html::linkRoute('post.show',$post->title,['id'=>$post->id]) !!}
                    </li>
                @empty
                    <li>No updated for this user</li>
                @endforelse
            </ul>
        </div>

        <p>User uploaded images:
            <br>
            @forelse($user->uploadedImages as $image)

                <span>
                    <a href="{{route('image.display', ['id'=>$image->id])}}">{!!  Html::image("/siteImages/".$image->name, 'image',['style'=>"width: 100px; height: 100px;"]) !!}</a>
                </span>
            @empty
                <span>No uploaded images for this user</span>
            @endforelse
        </p>


        <span>User comments:</span>

        <ul>

            @forelse($user->comments as $comment)
                <li>
                    {{$comment->subject}}
                    {!! Html::linkRoute(    strtolower(explode('\\',get_class($comment->commentable))[1]).'.display',$comment->commentable->title,['id'=>$comment->commentable->id]) !!}
                </li>
            @empty
                <li>No comments for this user</li>
            @endforelse

        </ul>       <!-- Prepended text http://getbootstrap.com/components/#input-groups -->

        <p>User tags:
            <br>
            @forelse($user->tags as $tag)
                <span>
                {!! Html::linkRoute('tag.show',$tag->title,['id'=>$tag->id]) !!}
                </span>
            @empty
                <span>No tags for this user</span>
            @endforelse
        </p>






        {{--
        add the user events here
        --}}
    @else
        <p>To show the details you must login</p>
        {!! Html::linkRoute('loginForm','Login',[],['class'=>'btn btn-primary text-right']) !!}
    @endif

@endsection
