@extends('custom.administration')
@section('beforeNav')
<h1>
    Welcome in privileges control panel
</h1>
@endsection
@section('administrationContent')




    <div class="row table-bordered">

        @foreach($privileges as $privilege)
            <div class="col-xs-12 text-left">
                <a href="{{route('privilege.show',['id'=>$privilege->id])}}">
                    <h4 class="text-left">{{$privilege->name}}</h4>
                </a>

                <p>Associated to :
                    @foreach($privilege->roles as $role)
                        <a href="{{route('role.show',['id'=>$role->id])}}">

                            <span class="badge">{{$role->name}}</span>
                        </a>

                    @endforeach
                    <span class="text-right" style="float: right">
                    {!! Html::linkRoute('privilege.edit','Edit',['id'=>$privilege->id],['class'=>'btn btn-success text-right']) !!}
                    </span>
                </p>


                <hr>
            </div>

        @endforeach
    </div>

    <hr>



@endsection
