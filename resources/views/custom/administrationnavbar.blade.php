<ul class="nav nav-tabs nav-justified">

    @if(\Illuminate\Support\Facades\Auth::user()->hasAccess(['post.read','post.create','post.edit','post.delete','post.deletePermanent','post.restore',]) )
        <li role="presentation"
            class="{{  strtok(Route::currentRouteName(),'.')=='post' && Route::currentRouteName() ? "active" : null}}">{!! Html::linkRoute('post.index', 'Posts Edit') !!}</li>
    @endif

    @if(\Illuminate\Support\Facades\Auth::user()->hasAccess(['image.read','image.create','image.edit','image.delete','image.deletePermanent','image.restore',]) )
        <li role="presentation"
            class="{{  strtok(Route::currentRouteName(),'.')=='image' ? "active" : null}}">{!! Html::linkRoute('image.index', 'Images Edit') !!}</li>
    @endif

    @if(\Illuminate\Support\Facades\Auth::user()->hasAccess(['user.read','user.create','user.edit','user.deactivate','user.activate',]) )
        <li role="presentation"
            class="{{  strtok(Route::currentRouteName(),'.')=='user' ? "active" : null}}">{!! Html::linkRoute('user.index', 'Users') !!}</li>
    @endif


    @if(\Illuminate\Support\Facades\Auth::user()->hasAccess(['comment.edit','comment.delete','comment.deletePermanent','comment.restore',]) )
        <li role="presentation"
            class="{{  strtok(Route::currentRouteName(),'.')=='comment' ? "active" : null}}">{!! Html::linkRoute('comment.index', 'Comments') !!}</li>
    @endif


    @if(\Illuminate\Support\Facades\Auth::user()->hasAccess(['tag.read','tag.create','tag.edit','tag.delete','tag.deletePermanent','tag.restore',]) )
        <li role="presentation"
            class="{{  strtok(Route::currentRouteName(),'.')=='tag' ? "active" : null}}">{!! Html::linkRoute('tag.index', 'Tags') !!}</li>
    @endif


    @if(\Illuminate\Support\Facades\Auth::user()->hasAccess(['log.read','log.delete','log.deletePermanent','log.restore',]) )
        <li role="presentation"
            class="{{  strtok(Route::currentRouteName(),'.')=='log' ? "active" : null}}">{!! Html::linkRoute('log.index', 'Logs') !!}</li>
    @endif


    <li class="{{strtok(Route::currentRouteName(),'.')=='role' ? "active" : null}}">{!! Html::linkRoute('role.index','Roles') !!}</li>
    <li class="{{strtok(Route::currentRouteName(),'.')=='privilege' ? "active" : null}}">{!! Html::linkRoute('privilege.index','Privileges') !!}</li>

</ul>
