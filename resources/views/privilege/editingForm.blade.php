{!! Form::open( ['method'=>'put', 'route'=> ['privilege.update' , 'id'=>$privilege->id ] ] ) !!}

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
        <label class=" control-label" for="textinput">Name</label>
        <div>
            <input id="textinput" name="name" type="text" placeholder="Enter Title"
                   class="form-control input-md" required=""
                   value="{{$privilege->name}}"
            >
        </div>
    </div>


    <!-- Text input-->
    <div class="form-group">

        @foreach($roles as $role)
            <input id="{{$role->name}}" name="roles[]" type="checkbox" placeholder="Enter Title"
                   value="{{$role->id}}"
                    {{ in_array($role->id, array_map(function ($obj){return $obj->id;},$selectedRoles) ) ? "checked" :null}}
            >

            <label class=" control-label" for="{{$role->name}}">{{$role->name}}</label>
            <span>




            </span>
            <br>
        @endforeach
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

