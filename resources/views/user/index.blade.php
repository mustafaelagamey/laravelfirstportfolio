@extends('custom.administration')
@section('beforeNav')
    <h1>
        Welcome in users control panel
    </h1>
@endsection
@section('administrationContent')
    {!! Html::linkRoute('user.create', 'Create New' , [], ['class' => 'btn btn-primary ','style'=>"float: right; margin-top:10px; margin-bottom:10px" ]) !!}
    <div class="row table-bordered">

        @foreach($users as $user)
            <div class="col-xs-12 text-left">
                <h4 class="text-left">
                    {!! Html::linkRoute('user.show',$user->email,['id'=>$user->id]) !!}



                </h4>


                <p>{{$user->name}} <span class="badge">{{$user->role->name}}</span></p>


                <p class="text-right">
                    {!! Html::linkRoute('user.edit','Edit',['id'=>$user->id],['class'=>'btn btn-success text-right']) !!}

                    @if($user->activated)
                    {!! Html::linkRoute('user.deactivate','Deactivate',['id'=>$user->id],['class'=>'btn btn-warning text-right']) !!}
                    @else
                    {!! Html::linkRoute('user.activate','Activate',['id'=>$user->id],['class'=>'btn btn-info text-right']) !!}
                    @endif


                    @if($user->enabled)
                    {!! Html::linkRoute('user.disable','Disable',['id'=>$user->id],['class'=>'btn btn-danger text-right']) !!}
                    @else
                    {!! Html::linkRoute('user.enable','Enable',['id'=>$user->id],['class'=>'btn btn-info text-right']) !!}
                    @endif

                </p>

                <hr>
            </div>

        @endforeach
    </div>
@endsection
