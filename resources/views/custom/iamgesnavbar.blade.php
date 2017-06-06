<ul class="nav nav-tabs nav-justified">
    <li role="presentation"
        class="{{  Route::currentRouteName()=='images.all' ? "active" : null}}">{!! Html::linkRoute('images.all', 'All images') !!}</li>
    <li role="presentation"
        class="{{  Route::currentRouteName()=='images.album' ? "active" : null}}">{!! Html::linkRoute('images.album', 'Album images') !!}</li>
    <li role="presentation"
        class="{{  Route::currentRouteName()=='images.posts' ? "active" : null}}">{!! Html::linkRoute('images.posts', 'Posts images') !!}</li>
</ul>
