@foreach($items as $item)
<li >

    @if($item->hasChildren())
        {{$item->title}}
        <ul class="sub-category">
            @include('customMenu',['items'=>$item->children()])
        </ul>
        @else
        <a href="{{$item->url()}}">{{$item->title}}</a>
    @endif

</li>
@endforeach
