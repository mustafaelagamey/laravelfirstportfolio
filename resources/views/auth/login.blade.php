@extends('layouts.master')
@section('content')



    {!! Form::open(['route'=>'login' , 'style'=>'width:300px', 'class'=>' center-block']) !!}

    <fieldset class="center-block">
        <!-- Form Name -->
        <legend>Login</legend>
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
        <!-- Prepended text http://getbootstrap.com/components/#input-groups -->
        <div class="form-group ">
            <label class="control-label" for="email"></label>
            <div class="input-group">
                <span id="emailPrepend" class="input-group-addon">Email</span>
                <input id="email" name="email" class="form-control" placeholder="Enter your email" type="text"
                       required="">
            </div>
        </div>

        <!-- Prepended text http://getbootstrap.com/components/#input-groups -->
        <div class="form-group">
            <label class="control-label" for="password"></label>

            <div class="input-group">
                <span id="passwordPrepend" class="input-group-addon ">Password</span>
                <input id="password" name="password" class="form-control" placeholder="Enter your password"
                       type="text" required="">
            </div>
        </div>

        <!-- Button http://getbootstrap.com/css/#buttons -->
        <div class="form-group">
            <div class="text-right">
                <button type="submit" id="singlebutton" name="singlebutton" class="btn btn-default" aria-label="">
                    Submit
                </button>

                {!!  Html::linkRoute('registerForm' , 'Register', [],['class' => 'btn btn-default btn-info']) !!}

            </div>

        </div>


    </fieldset>
    {!! Form::close() !!}


@endsection