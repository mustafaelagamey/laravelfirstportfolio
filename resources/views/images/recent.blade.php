<h3>Recent Posts</h3>
<div class="row">

    @foreach($recentPosts as $post)
        <div class="col-xs-12">
            <a href="{{route('post.show',['id'=>$post->id])}}">
                <h4 class="text-center">{{ substr($post->title,0,25).'...' }}</h4>
                @if(Auth::check())
                    <p>{{substr($post->subject,0,50).'...'}}</p>
                @endif
            </a>
        </div>

    @endforeach
</div>