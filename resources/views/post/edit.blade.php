@extends('custom.administration')
@section('beforeNav')
    <h1>
        Welcome in posts control panel
    </h1>
@endsection
@section('administrationContent')


    @include('post.postForm')
@endsection
