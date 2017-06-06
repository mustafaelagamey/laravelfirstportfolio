<?php $updating = isset($image) ?>

{!! Form::open( ['id'=>'imageForm','method'=>$updating?'put':'image', 'route'=>$updating? ['image.update' , 'id'=>$image->id ]:'image.store' , 'files'=>true] ) !!}
{!! Form::close() !!}

<fieldset>
    @if(count($errors)>0)
        <div class="alert alert-warning">
            <ul>
                @foreach($errors->all() as $error)
                    <li>
                        {{$error}}
                    </li>
                @endforeach
            </ul>

        </div>

@endif
<!-- Form Name -->
    <legend>Form Name</legend>

    <!-- Text input-->
    <div class="form-group">
        <label class=" control-label" for="textinput">Title</label>
        <div>
            <input form="imageForm" id="textinput" name="title" type="text" placeholder="Enter Title"
                   class="form-control input-md" required=""
                   value="<?php
                   if ($updating) echo $image->title;
                   else {
                       $seed = str_split(' abcdefghijklmnopqrstuvwxyz '
                           . ' ABCDEFGHIJKLMNOPQRSTUVWXYZ '); // and any other characters
                       shuffle($seed); // probably optional since array_is randomized; this may be redundant
                       $rand = '';
                       foreach (array_rand($seed, 30) as $k) $rand .= $seed[$k];
                       echo $rand;
                   }
                   ?>"
            >

        </div>
    </div>

    <!-- tagging including  input-->
@if($updating)

    @include('tag.smallForm',['tagableId'=>$image->id ,'tagableType'=>get_class($image) ,])

@else
    @include('tag.newTagSmallForm',['formName'=>'postForm' ,])
@endif


<!-- Text input-->
    <div class="form-group">
        <label class=" control-label" for="image">Current Image</label>
        <br>
        <img id="image" src="/siteImages/{{ $image->name or 'siteImage.jpg'}}" alt="image">
    </div>

    <div class="form-group">
        <label class=" control-label" for="image">Select New Image</label>
        <div>
            <input form="imageForm" id="image" name="image" class="input-file input-md" type="file">
            <span class="help-block">100 kB image</span>
        </div>
    </div>


    <!-- Button -->
    <div class="form-group">
        <label class=" control-label" for=""></label>
        <div>

            @if($updating)
                <button form="imageForm" id="" name="" class="btn btn-success">Edit</button>
            @else
                <button form="imageForm" id="" name="" class="btn btn-primary">Create</button>

            @endif

        </div>
    </div>

    <h4>Related Post</h4>
    <p>
        @if($updating && $image->post)
            {!! Html::linkRoute('post.edit',$image->post->title,['id'=>$image->post->id]) !!}
        @else
        Image Album
        @endif
    </p>

</fieldset>



