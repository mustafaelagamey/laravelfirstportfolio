<?php $updating = isset($user) ?>

{!! Form::open( ['method'=>$updating?'put':'post', 'route'=>$updating? ['user.update' , 'id'=>$user->id ]:'user.store' ] ) !!}

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
        <label class=" control-label" for="textinput">Email</label>
        <div>
            <input id="textinput" name="email" type="text" placeholder="Enter Email"
                   class="form-control input-md" required=""
                   value="<?php
                   if ($updating) echo $user->email;?>"
            >

        </div>
    </div>


    <!-- Text input-->
    <div class="form-group">
        <label class=" control-label" for="subject">Nickname</label>
        <div>
            <input id="subject" name="name" type="text" placeholder="Enter Nickname"
                   class="form-control input-md" required="" rows="10"
                   value="<?php if ($updating) echo $user->name ?>"

            >
        </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
        <label class=" control-label" for="password">Password</label>
        <div>
            <input id="password" name="password" type="text" placeholder="Enter New Password"
                   class="form-control input-md" rows="10">
        </div>
    </div>


@if($updating && Auth::user()->hasAccess('privilege.edit'))
    <!-- Fuel UX Select http://getfuelux.com/javascript.html#selectlist -->
        <div class="form-group">
            <label class="label label-default" for="sel1" style="font-size: 15px">Select role:</label>
            <select class="form-control" id="sel1" name="role">

                @foreach(\App\Role::all() as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                @endforeach
            </select>
        </div>

@endif


<!-- Button -->
    <div class="form-group">
        <label class=" control-label" for=""></label>
        <div>

            @if($updating)
                <button id="" name="" class="btn btn-success">Edit</button>
            @else
                <button id="" name="" class="btn btn-primary">Create</button>

            @endif

        </div>
    </div>


</fieldset>


{!! Form::close() !!}

