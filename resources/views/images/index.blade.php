@extends('layouts.master')




@section('content')

    <h1>
        Welcome in images list
    </h1>
@include('custom.iamgesnavbar')
    <div class="row">

        @foreach($images as $image)

            <div class="col-xs-12 col-md-6 text-center">
                <a href="{{route('image.display',['id'=>$image->id])}}">

                    <img src="/siteImages/{{ $image->name or 'siteImage.jpg'}}" alt="image"
                         style="width: 300px; height: 300px">
                </a>
                <h3 class="text-center">{{ substr($image->title,0,25).'...' }}</h3>
                <p>{{substr($image->subject,0,50).'...'}}</p>
                {{--<h4>{{$image->post->title}}</h4>--}}
                @if($image->post !==null)
                    <a href="{{route('post.display',['id'=>$image->post])}}">

                        <h4>{{$image->post->title }}</h4>
                    </a>

                @else
                    <h4>{{ "Images Album"  }}</h4>

                @endif
            </div>
            <hr>

        @endforeach
    </div>
@endsection