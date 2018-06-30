
@if($articles &&  $articles->isEmpty() && $categories && $categories->isEmpty())
    <li>Ничего не найдено</li>

    @endif

    @if($articles && !$articles->isEmpty())
        @foreach($articles as $item)
            <li><a href="{{route('showArticle',['category'=>$item->category->alias,'article'=>$item->id])}}">{{$item->title}}</a></li>
            @endforeach
    @endif

    @if($categories && !$categories->isEmpty())
        @foreach($categories as $category)
            @foreach($category->articles as $item)

                <li><a href="{{route('showArticle',['category'=>$item->category->alias,'article'=>$item->id])}}">{{$item->title}}</a></li>

            @endforeach
        @endforeach
    @endif
