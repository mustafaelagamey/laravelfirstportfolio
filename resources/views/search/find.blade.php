@extends('layouts.master')


@section('content')

    <h1>
        Welcome in Search system
    </h1>

    @include('search.searchForm')
    @if(isset($results))

        @foreach($results as $type=>$typeResults)
            <h4>{{ucfirst($type)}}:</h4>
            @forelse($typeResults as $typeResult)
                <h5>
                    {{--                    {!! Html::linkRoute("$type.display", $typeResult['title']),['id'=>$typeResult['id']] !!}--}}
                    <?php
                    echo $type;
                    switch ($type) {
                        case 'post':
                            $name = $typeResult->title;
                            break;
                        case 'image':
                            $name = $typeResult->title;
                            break;
                        case 'comment':
                            $name = $typeResult->subject;
                            break;
                        default:
                            $name = null;
                            break;
                    }
                    ?>
                    @if(Route::has("$type.display"))




                        {!! Html::linkRoute("$type.display",$name,['id'=>$typeResult->id]) !!}
                    @elseif(Route::has("$type.show"))
                        {!! Html::linkRoute("$type.show",$name,['id'=>$typeResult->id]) !!}
                    @else
                        {{$typeResult->title}}
                    @endif
                </h5>

            @empty
                <h5> No result for this section</h5>
            @endforelse
        @endforeach

    @endif




@endsection
