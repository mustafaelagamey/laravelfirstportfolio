@extends('layouts.master')
@section('content')
    <h3 class="text-left">Tag name: {{$tag->title}}</h3>
    <h5 class="text-left">Tagged Posts:</h5>
    <ul>
        @forelse($tag->posts as $post)
            <li>
                {!! Html::linkRoute('post.display',$post->title,['id'=>$post->id]) !!}
            </li>
        @empty
            <li>No posts for this tag</li>
        @endforelse
    </ul>       <!-- Prepended text http://getbootstrap.com/components/#input-groups -->
    <h4 class="text-left">Tagged Images:</h4>
    <ul>

        @forelse($tag->images as $image)
            <li>
                {!! Html::linkRoute('image.display',$image->title,['id'=>$image->id]) !!}
            </li>
        @empty
            <li>No images for this tag</li>
        @endforelse
    </ul>       <!-- Prepended text http://getbootstrap.com/components/#input-groups -->
@endsection
