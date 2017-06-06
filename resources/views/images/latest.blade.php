<h3>Latest Posts</h3>
<div class="row">

    @foreach($latestPosts as $post)
        <div class="col-xs-12 col-md-6 text-center">
            <a href="{{route('post.show',['id'=>$post->id])}}">
                <div class=" " style=" margin: auto; height: 300px;width: 300px">
                    <img src="siteImages/{{ $post->image or 'siteImage.jpg'}}" alt="image"
                         style="width: 300px; height: 300px">
                </div>
                <h4 class="text-center">{{ substr($post->title,0,25).'...' }}</h4>
                @if(Auth::check())

                    <p>{{substr($post->subject,0,50).'...'}}</p>
                @endif
            </a>
        </div>

    @endforeach
</div>