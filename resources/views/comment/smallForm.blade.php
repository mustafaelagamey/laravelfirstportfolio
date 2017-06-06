{!! Form::open(['route'=>'comment.store']) !!}
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

    <input type="hidden" name="commentable_id" id="" value="{{$commentableId}}">
    <input type="hidden" name="commentable_type" id="" value="{{$commentableType}}">




    <input type="text" class="form-control" placeholder="Post comment" name="subject" required value="{{ old('subject') }}">
    <span class="input-group-btn">
                    <button class="btn btn-success" type="submit">Post</button>
                </span>
</div><!-- /input-group -->
{!! Form::close() !!}
