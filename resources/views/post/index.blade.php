@extends('custom.administration')
@section('beforeNav')
    <h1>
        Welcome in posts control panel
    </h1>

@endsection
@section('administrationContent')
    {!! Html::linkRoute('post.create', 'Create New' , [], ['class' => 'btn btn-primary ','style'=>"float: right; margin-top:10px; margin-bottom:10px" ]) !!}
    <div class="row table-bordered">

        @foreach($posts as $post)
            <div class="col-xs-12 text-left">
                <h4 class="text-left">
                    {!! Html::linkRoute('post.display',$post->title,['id'=>$post->id]) !!}
                </h4>
                <p>{{$post->subject}}</p>
                <p><span style="font-weight: bold">Image:</span>
                    @if($post->image)
                        {!! Html::linkRoute('image.display',$post->image->title,['id'=>$post->image->id]) !!}
                    @else
                        No image for this post
                    @endif
                </p>
                {!! Form::open(['method'=>'delete' , 'route'=>['post.destroy' , 'id'=>$post->id ]  , 'id'=>'form_'.$post->id]) !!}
                {!! Form::close() !!}
                <p class="text-right">
                    {!! Html::linkRoute('post.edit','Edit',['id'=>$post->id],['class'=>'btn btn-success text-right']) !!}

                    @if(!$post->trashed())
                        {!! Form::submit('Delete',['class'=>'btn btn-danger text-right','form'=>'form_'.$post->id]) !!}
                    @else
                        {!! Form::submit('Permanent Delete',['class'=>'btn btn-danger text-right','form'=>'form_'.$post->id,  'formaction'=>URL::route('post.permanentDelete', ['id'=>$post->id])]) !!}

                        {!! Html::linkRoute('post.restore','Restore',['id'=>$post->id],['class'=>'btn btn-info text-right']) !!}
                    @endif

                </p>

                <hr>
            </div>

        @endforeach
    </div>
@endsection
