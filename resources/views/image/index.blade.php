@extends('custom.administration')
@section('beforeNav')
    <h1>
        Welcome in Images control panel
    </h1>

@endsection
@section('administrationContent')


    {!! Html::linkRoute('image.create', 'Create New' , [], ['class' => 'btn btn-primary ','style'=>"float: right; margin-top:10px; margin-bottom:10px" ]) !!}


    <div class="row table-bordered">

        @foreach($images as $image)
            <div class="col-sm-6 col-xs-12 text-left">
                <a href="{{route('image.display',['id'=>$image->id])}}">

                <img src="/siteImages/{{ $image->name or 'siteImage.jpg'}}" alt="image" style="width: 300px; height: 300px">
                </a>
                <p class="text-right">
                    {!! Html::linkRoute('image.edit','Edit',['id'=>$image->id],['class'=>'btn btn-success text-right']) !!}

                    @if(!$image->trashed())
                        {!! Form::submit('Delete',['class'=>'btn btn-danger text-right','form'=>'form_'.$image->id]) !!}
                    @else
                        {!! Form::submit('Permanent Delete',['class'=>'btn btn-danger text-right','form'=>'form_'.$image->id, 'formaction'=>URL::route('image.permanentDelete', ['id'=>$image->id])]) !!}

                        {!! Html::linkRoute('image.restore','Restore',['id'=>$image->id],['class'=>'btn btn-info text-right']) !!}
                    @endif

                </p>

                <h3 class="text-left">{{$image->title}}</h3>
                {!! Form::open(['method'=>'delete' , 'route'=>['image.destroy' , 'id'=>$image->id ]  , 'id'=>'form_'.$image->id]) !!}
                {!! Form::close() !!}



                <h4>Post:
                    @if($image->post !==null)
                        {!! Html::linkRoute('post.display',$image->post->title,['id'=>$image->post->id]) !!}


                    @else
                        Images Album
                    @endif
                </h4>


                <hr>
            </div>

        @endforeach
    </div>
@endsection
