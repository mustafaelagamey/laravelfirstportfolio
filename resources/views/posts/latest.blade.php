<h3>Latest Posts</h3>
<div class="row">

    @foreach($latestPosts as $post)
        <div class="col-xs-12 col-md-6 text-center">
            <div class=" " style=" margin: auto; height: 300px;width: 300px">
                <a href="{{route('image.display',['id'=>$post->image])}}">

                    <img src="/siteImages/{{ $post->image->name or 'siteImage.jpg'}}" alt="image"
                         style="width: 300px; height: 300px">
                </a>
            </div>
            <a href="{{route('post.display',['id'=>$post->id])}}">
                <h4 class="text-center">{{ substr($post->title,0,25).'...' }}</h4>
                @if(Auth::check())

                    <p>{{substr($post->subject,0,50).'...'}}</p>
                @endif
            </a>
        </div>

    @endforeach
</div>