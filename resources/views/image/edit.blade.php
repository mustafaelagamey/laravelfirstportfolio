@extends('custom.administration')
@section('beforeNav')
    <h1>
        Welcome in images control panel
    </h1>
@endsection
@section('administrationContent')


    @include('image.imageForm')
@endsection
