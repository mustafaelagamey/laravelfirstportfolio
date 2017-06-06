{!! Form::open( [ 'route'=> ['search.find'] ] ) !!}

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
        <label class=" control-label" for="textinput">Search text : </label>
        <div>
            <input id="textinput" name="searchText" type="text" placeholder="Enter text"
                   class="form-control input-md" required=""
            >
        </div>
    </div>


    <!-- Text input-->
    <div class="form-group">
        @foreach(['post','image','comment','tag','user','role','privilege','log'] as $place)
            <label class=" checkbox-inline" for="{{$place}}">
                <input id="{{$place}}" name="places[]" type="checkbox"  placeholder="Enter Title"
                       value="{{$place}}">
                {{ucfirst($place)}}
            </label>
            <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
        @endforeach
        <label class=" checkbox-inline" for="everywhere">
            <input id="everywhere" name="places" type="checkbox" class="checkbox" placeholder="Enter Title"
                   value="everywhere" checked>Everywhere
        </label>
    </div>


    <!-- Button -->
    <div class="form-group">
        <label class=" control-label" for=""></label>
        <div>
            <button id="" name="" class="btn btn-success">Search</button>
        </div>
    </div>

</fieldset>


{!! Form::close() !!}

