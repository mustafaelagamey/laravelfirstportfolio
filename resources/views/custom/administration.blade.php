@extends('layouts.master')

@section('content')
    <h3>Welcome in administration area</h3>

    @yield('beforeNav')
    @include('custom.administrationnavbar')

    @yield('administrationContent' )


@endsection
