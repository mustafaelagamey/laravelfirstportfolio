@extends('custom.administration')
@section('beforeNav')
    <h1>
        Welcome in comments control panel
    </h1>

@endsection
@section('administrationContent')
    <h4>See comments for :
        {!! Html::linkRoute('comment.typeSelect','Posts',['type'=>'post']) !!} ||
        {!! Html::linkRoute('comment.typeSelect','Images',['type'=>'image']) !!} ||
        {!! Html::linkRoute('comment.index','Anywhere') !!}
    </h4>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Comment</th>
                <th>Place</th>
                <th>Commenter</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
                {!! Form::open(['method'=>'delete' , 'route'=>['comment.destroy' , 'id'=>$comment->id ]  , 'id'=>'form_'.$comment->id]) !!}

                {!! Form::close() !!}
                <tr>
                    <td>{{$comment->subject}} </td>


                    {{--php getting the type of commentable--}}
                    {{--*/$commentableType = explode( '\\' , get_class( $comment->commentable  )  )[count(explode( '\\' , get_class( $comment->commentable  )  ))-1] /*--}}
                    <td>
                        @if($comment->commentable)
                        {{$commentableType}}:
                            {!! Html::linkRoute($comment->commentable->modelRoute().'.show' , explode('\\',$comment->commentable_type)[1] ,['id'=>$comment->commentable->id] ) !!}
                        @else
                            {{explode('\\',$comment->commentable_type)[1]}}: Trashed comment of id : {{$comment->id}}
                        @endif
                    </td>
                    <td>{{$comment->user->email}}</td>
                    <td>
                        {!! Html::linkRoute('comment.edit','Edit',['id'=>$comment->id],['class'=>'btn btn-success ']) !!}

                        @if(!$comment->trashed())
                            {!! Form::submit('Delete',['class'=>'btn btn-danger ','form'=>'form_'.$comment->id]) !!}
                        @else
                            {!! Form::submit('Permanent Delete',['class'=>'btn btn-danger ','form'=>'form_'.$comment->id, 'formaction'=>URL::route('comment.permanentDelete', ['id'=>$comment->id])]) !!}

                            {!! Html::linkRoute('comment.restore','Restore',['id'=>$comment->id],['class'=>'btn btn-info ']) !!}
                        @endif</td>

                </tr>
            @endforeach

        </tbody>
    </table>




@endsection
