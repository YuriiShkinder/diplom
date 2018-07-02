@if(empty($type))
    @if($articles && !$articles->isEmpty())

        @foreach($articles as $item)
            <div class="catalog_item">
                <div class="catalog_item_buttons">
                    <div class="check"><i class="fa fa-search"></i></div>
                    <div class="go_to"><a href="{{route('showArticle',['category'=>$item->category->alias,'article'=>$item->id])}}"><i class="fa fa-arrow-right"></i></a></div>
                </div>
                <div class="catalog_item_img">
                    <img src="{{Storage::disk('s3')->url($item->img->colection[rand(0,count($item->img->colection)-1)])}}" alt="{{$item->title}}">
                </div>
                <div class="catalog_item_info">
                    <div class="top">
                        <div class="name">
                            <span>{{$item->title}}</span>
                            <h6>{{str_limit($item->desc)}}</h6>
                        </div>
                    </div>
                    <div class="bot">
                        <div class="catalog_item_price">{{$item->price}}$</div>
                        <div class="stars_block">
                            <div class="stars_bg" style="width: {{$item->count*20}}%"></div>
                            <div class="stars_bg2"></div>
                            <div class="stars_bg3"></div>
                            <div href="{{route('likeArticle',['article'=>$item->id])}}" class="stars">
                                <div class="star {{Auth::user()? 'clickLike' : ''}}"></div>
                                <div class="star {{Auth::user()? 'clickLike' : ''}}"></div>
                                <div class="star {{Auth::user()? 'clickLike' : ''}}"></div>
                                <div class="star {{Auth::user()? 'clickLike' : ''}}"></div>
                                <div class="star {{Auth::user()? 'clickLike' : ''}}"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach

    @else
        <h3 style="padding: 50px 0; text-align: center;width: 100%;">Нет товаров</h3>
    @endif

@else
    @if($articles && !$articles->isEmpty())
            @foreach($articles as $article)
                <tr>
                    <td>
                        {{$article->id}}
                    </td>
                    <td>
                        <a href="#"> {{$article->title}}</a>
                    </td>
                    <td> {{$article->discount}}%</td>
                    <td> {{$article->price}}$</td>
                    <td> <p> {{str_limit($article->text,200)}}</p> </td>
                    <td> <img src="{{Storage::disk('s3')->url($article->img->colection[0])}}" alt=""> </td>
                    <td> {{$article->category->title}}</td>
                    <td > <a href="#">Удалить</a> </td>
                </tr>
            @endforeach
    @else
        <h3 style="padding: 50px 0; text-align: center;width: 100%;">Нет товаров</h3>
    @endif
@endif
