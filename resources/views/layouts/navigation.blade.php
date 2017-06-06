<div>


    <ul class="nav nav-pills">


        <li role="presentation"
            class="{{  Route::currentRouteName()=='home' ? "active" : null}}">{!! Html::linkRoute('home', 'Home') !!}</li>

        @if(Auth::check())
            <?php $user = Auth::user() ?>


            <li role="presentation"
                class="{{  in_array(Route::currentRouteName(),['posts','post.display'] )? "active" : null }}">{!! Html::linkRoute('posts', 'Posts') !!}</li>
            <li role="presentation"
                class="{{  in_array(Route::currentRouteName(),['images.all','images.posts','images.album','image.display']) ? "active" : null}}">{!! Html::linkRoute('images.all', 'Images') !!}</li>

            @if($user->hasAccess(['privilege.edit','role.edit',]) )
                <li role="presentation"
                    class="{{
                     in_array(strtok(Route::currentRouteName(),'.'),['administration','privilege','role','post','image','user','comment','tag','log'] )
                     && !in_array(Route::currentRouteName(),['post.display','image.display'])
                     ? "active" : null

                     }}">{!! Html::linkRoute('administration.all', 'Administration') !!}</li>
            @endif

            {{--@endif--}}
            <li role="presentation" style="background-color: #9bc342;">{!! Html::linkRoute('logout', 'Logout') !!}</li>
        @else
            <li role="presentation"
                class="{{  Route::currentRouteName()=='loginForm' ? "active" : null}}">{!! Html::linkRoute('loginForm', 'Login') !!}</li>
        @endif
        <li role="presentation"
            class="{{  in_array(Route::currentRouteName(),['search.find']) ? "active" : null}}">{!! Html::linkRoute('search.find', 'Search') !!}</li>
    </ul>
</div>
<hr>
