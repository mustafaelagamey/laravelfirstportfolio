<?php $updating = isset($post) ?>

{!! Form::open( ['id'=>'postForm','method'=>$updating?'put':'post', 'route'=>$updating? ['post.update' , 'id'=>$post->id ]:'post.store' , 'files'=>true] ) !!}
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
            <input form="postForm" id="textinput" name="title" type="text" placeholder="Enter Title"
                   class="form-control input-md" required=""
                   value="<?php
                   if ($updating) echo $post->title;
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


    <!-- Text input-->
    <div class="form-group">
        <label class=" control-label" for="subject">Subject</label>
        <div>
                <textarea form="postForm" id="subject" name="subject" type="text" placeholder="Enter subject"
                          class="form-control input-md" required="" rows="10"
                ><?php
                    if ($updating) echo $post->subject;
                    else {
                        $seed = str_split(' abcdefghijklmnopqrstuvwxyz '
                            . ' ABCDEFGHIJKLMNOPQRSTUVWXYZ '); // and any other characters
                        shuffle($seed); // probably optional since array_is randomized; this may be redundant
                        $rand = '';
                        foreach (array_rand($seed, 40) as $k) $rand .= $seed[$k];
                        echo $rand;
                    }
                    ?></textarea>
        </div>
    </div>


    <!-- tagging including  input-->
@if($updating)
    @include('tag.smallForm',['tagableId'=>$post->id ,'tagableType'=>get_class($post) ,])
@else
    @include('tag.newTagSmallForm',['formName'=>'postForm' ,])
@endif
<!-- Text input-->
    <div class="form-group">
        <label class=" control-label" for="image">Current Image</label>
        <br>
        <img id="image" src="/siteImages/{{ $post->image->name or 'siteImage.jpg'}}" alt="image">
    </div>


    <div class="form-group">
        <label class=" control-label" for="image">Select Image</label>
        <div>
            <input form="postForm" id="image" name="image" class="input-file input-md" type="file">
            <span class="help-block">100 kB image</span>

        </div>
    </div>

    <!-- Button -->
    <div class="form-group">
        <label class=" control-label" for=""></label>
        <div>

            @if($updating)
                <button id="" name="" class="btn btn-success" form="postForm">Edit</button>
            @else
                <button id="" name="" class="btn btn-primary" form="postForm">Create</button>

            @endif

        </div>
    </div>

</fieldset>




