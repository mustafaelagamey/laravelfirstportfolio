
{!! Form::open( ['method'=>'put', 'route'=> ['comment.update' , 'id'=>$comment->id ] ] ) !!}

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
        <label class=" control-label" for="subject">Title</label>
        <div>
            <input id="subject" name="subject" type="text" placeholder="Enter Title"
                   class="form-control input-md" required=""
                   value="{{$comment->subject}}"
            >

        </div>
    </div>




    <!-- Button -->
    <div class="form-group">
        <label class=" control-label" for=""></label>
        <div>

                <button id="" name="" class="btn btn-success">Edit</button>


        </div>
    </div>

</fieldset>


{!! Form::close() !!}

