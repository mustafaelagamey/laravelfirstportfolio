@extends('custom.administration')
@section('beforeNav')
    <h1>
        Welcome in tags control panel
    </h1>

@endsection
@section('administrationContent')
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Tag</th>
                <th>Tagger</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tags as $tag)
                {!! Form::open(['method'=>'delete' , 'route'=>['tag.destroy' , 'id'=>$tag->id ]  , 'id'=>'form_'.$tag->id]) !!}

                {!! Form::close() !!}
                <tr>
                    <td>
                        {!! Html::linkRoute('tag.show',$tag->title,['id'=>$tag->id]) !!}
                    </td>
                    <td>{{$tag->user->email}}</td>
                    <td>
                        {!! Html::linkRoute('tag.edit','Edit',['id'=>$tag->id],['class'=>'btn btn-success ']) !!}

                        @if(!$tag->trashed())
                            {!! Form::submit('Delete',['class'=>'btn btn-danger ','form'=>'form_'.$tag->id]) !!}
                        @else
                            {!! Form::submit('Permanent Delete',['class'=>'btn btn-danger ','form'=>'form_'.$tag->id, 'formaction'=>URL::route('tag.permanentDelete', ['id'=>$tag->id])]) !!}

                            {!! Html::linkRoute('tag.restore','Restore',['id'=>$tag->id],['class'=>'btn btn-info ']) !!}
                        @endif</td>

                </tr>
            @endforeach

        </tbody>
    </table>




@endsection
