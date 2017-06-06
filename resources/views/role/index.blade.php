@extends('custom.administration')
@section('beforeNav')
    <h1>
        Welcome in roles control panel
    </h1>

@endsection

@section('administrationContent')



    {!! Html::linkRoute('role.create', 'Create New' , [], ['class' => 'btn btn-primary ','style'=>"float: right; margin-top:10px; margin-bottom:10px" ]) !!}
    <div class="row table-bordered">

        @foreach($roles as $role)
            <div class="col-xs-12 text-left">
                <a href="{{route('role.show',['id'=>$role->id])}}">
                    <h4 class="text-left">{{$role->name}}</h4>
                </a>

                <p>Associated to :
                    @foreach($role->privileges as $privilege)
                        <a href="{{route('privilege.show',['id'=>$privilege->id])}}">

                            <span class="badge">{{$privilege->name}}</span>
                        </a>

                    @endforeach
                    <span class="text-right" style="float: right">
                    {!! Html::linkRoute('role.edit','Edit',['id'=>$role->id],['class'=>'btn btn-success text-right']) !!}
                    </span>
                </p>
                <hr>
            </div>

        @endforeach
    </div>


    <hr>



@endsection
