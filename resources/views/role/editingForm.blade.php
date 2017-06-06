{{--
{!! Form::open( ['method'=>'put', 'route'=> ['role.update' , 'id'=>$role->id ] ] ) !!}

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
                   value="{{$role->name}}"
            >
        </div>
    </div>


    <!-- Text input-->
    <div class="form-group">

        @foreach($privileges as $privilege)
            <input id="{{$privilege->name}}" name="privileges[]" type="checkbox" placeholder="Enter Title"
                   value="{{$privilege->id}}"
                    {{ in_array($privilege->id, array_map(function ($obj){return $obj->id;},$selectedPrivileges) ) ? "checked" :null}}
            >

            <label class=" control-label" for="{{$privilege->name}}">{{$privilege->name}}</label>
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
--}}

<?php $updating = isset($role) ?>

{!! Form::open( ['method'=>$updating?'put':'role', 'route'=>$updating? ['role.update' , 'id'=>$role->id ]:'role.store' , 'files'=>true] ) !!}

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
                   value="@if($updating) {{$role->name}} @endif"
            >
        </div>
    </div>


    <!-- Text input-->
    <div class="form-group">

        @foreach($privileges as $privilege)
            <input id="{{$privilege->name}}" name="privileges[]" type="checkbox" placeholder="Enter Title"
                   value="{{$privilege->id}}"
            @if($updating)
                {{ in_array($privilege->id, array_map(function ($obj){return $obj->id;},$selectedPrivileges) ) ? "checked" :null}}
                    @endif

            >

            <label class=" control-label" for="{{$privilege->name}}">{{$privilege->name}}</label>

            <br>
        @endforeach
    </div>

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


@if($updating)
<ul>
    @foreach( $role->users as $user)
     <li><a href="{{route('user.edit',['id'=>$user->id])}}">{{$user->email}}</a></li>
    @endforeach
</ul>
@endif






{!! Form::close() !!}

