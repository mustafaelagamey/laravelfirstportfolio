@extends('custom.administration')
@section('beforeNav')
    <h1>
        Welcome in users control panel
    </h1>
@endsection
@section('administrationContent')


    @include('user.userForm')
@endsection
