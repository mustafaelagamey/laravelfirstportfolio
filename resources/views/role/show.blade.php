@extends('custom.administration')


@section('administrationContent')


    <h2 class="text-left">{{ $role->name }} <span class="text-right" style="float: right">
                    {!! Html::linkRoute('role.edit','Edit',['id'=>$role->id],['class'=>'btn btn-success text-right']) !!}
                    </span>
    </h2>

    <h4>
        Privileges for this role
    </h4>


    <ul>
        @foreach($role->privileges as $privilege)
            <li>
                {{$privilege->name}}
            </li>
        @endforeach
    </ul>

 <h4>
        Users of this role
    </h4>


    <ul>
        @foreach($role->users as $user)
            <li>
                {{$user->name}}
            </li>
        @endforeach
    </ul>



@endsection
