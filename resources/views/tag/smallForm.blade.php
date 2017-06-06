{!! Form::open(['method'=>'post','route'=>'tag.store','id'=>'tags',]) !!}
{!! Form::close() !!}

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
<div class="col-md-10 input-group">

    <input form="tags"   type="hidden" name="tagable_id" id="" value="{{$tagableId}}">
    <input form="tags" type="hidden" name="tagable_type" id="" value="{{$tagableType}}">

    <input type="text" class="form-control" placeholder="Post tag" name="title" required form="tags" value="{{ old('title') }}">
    <span class="input-group-btn">
        <button id="" name="" class="btn btn-success" form="tags">Add tags</button>

    </span>

</div><!-- /input-group -->
<div class="form-group">
    <label class=" control-label" for="tag">Tags</label>
    <div>
        @if($updating)

           <?php
            if (isset($post))
                $tagable = $post;
            elseif (isset($image))
                $tagable = $image;
            else{
                $tagable = new stdClass();
                $tagable->tags = [];
            }
            ?>

            @foreach($tagable->tags  as $tag)
                <span>
                    {!! Html::linkRoute('tag.show',$tag->title,['id'=>"$tag->id"]) !!}
                    </span>
            @endforeach
        @endif
    </div>
</div>