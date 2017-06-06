@extends('custom.administration')
@section('beforeNav')
    <h1>
        Welcome in logs control panel
    </h1>

@endsection
@section('administrationContent')
    <h4>See logs for :
        @foreach(['post','image','comment','tag','user','role','privilege','log'] as $item)
            {!! Html::linkRoute('log.typeSelect',ucfirst($item),['type'=>$item]) !!} ||
        @endforeach
        {!! Html::linkRoute('log.index','Anywhere') !!}
    </h4>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>User</th>
                <th>Make</th>
                <th>On</th>
                <th>Date</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                {!! Form::open(['method'=>'delete' , 'route'=>['log.destroy' , 'id'=>$log->id ]  , 'id'=>'form_'.$log->id]) !!}
                {!! Form::close() !!}
                <tr>
                    {{--php getting the type of logable--}}
                    {{--*/$logableType = explode( '\\' , get_class( $log->logable  )  )[count(explode( '\\' , get_class( $log->logable  )  ))-1] /*--}}
                    {{--<td>{{$logableType}}: {!! Html::linkRoute(strtolower($logableType).'.display',$log->logable->title,['id'=>$log->logable->id]) !!}</td>--}}
                    <td>{{$log->user->email}}</td>
                    <td>{{$log->name}}</td>

                    <td>
                        @if($log->logable)
                            {!! Html::linkRoute($log->logable->modelRoute().'.show' , explode('\\',$log->logable_type)[1] ,['id'=>$log->logable->id] ) !!}
                        @else
                            {{'Deleted '.explode('\\',$log->logable_type)[1].' of id: ' .$log->logable_id}}
                        @endif
                    </td>
                    <td>
                        {{$log->created_at}}
                    </td>
                    <td>
                        @if(!$log->trashed())
                            {!! Form::submit('Delete',['class'=>'btn btn-danger ','form'=>'form_'.$log->id]) !!}
                        @else
                            {!! Form::submit('Permanent Delete',['class'=>'btn btn-danger ','form'=>'form_'.$log->id, 'formaction'=>URL::route('log.permanentDelete', ['id'=>$log->id])]) !!}

                            {!! Html::linkRoute('log.restore','Restore',['id'=>$log->id],['class'=>'btn btn-info ']) !!}
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>




@endsection
