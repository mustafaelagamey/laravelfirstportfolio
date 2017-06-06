@extends('layouts.master')





@section('content')
    <div class="row">
        <div class="col-xs-6 col-sm-8 col-md-9 col-lg-10">
            @include('posts.latest')
        </div>
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
            @include('posts.recent')

        </div>
    </div>

@endsection