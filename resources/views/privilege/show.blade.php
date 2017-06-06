@extends('custom.administration')


@section('administrationContent')


    <h2 class="text-left">{{ $privilege->name }} <span class="text-right" style="float: right">
                    {!! Html::linkRoute('privilege.edit','Edit',['id'=>$privilege->id],['class'=>'btn btn-success text-right']) !!}
                    </span>
    </h2>

    <h4>
        Roles responsible for accessing this privilege
    </h4>


    <ul>
        @foreach($privilege->roles as $role)
            <li>
                {{$role->name}}
            </li>
        @endforeach
    </ul>



@endsection
