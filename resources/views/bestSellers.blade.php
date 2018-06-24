@if($articles && !$articles->isEmpty())
    <div class="catalog_content">
        <aside>
            <form action="#" method="post">
                <ul class="filter">
                    @if($categoryFilter)
                        @foreach($categoryFilter as $item)
                            @if($item->parent_id==0)
                                <li>
                                    @if(Route::currentRouteName()=='categoryArticle')
                                        @set($parrent,$item)
                                        @set($current,Route::getCurrentRoute()->parameters['category']->id)
                                    @endif

                                    <p>{{$item->title}}</p>
                                    <ul class="subfilter">
                                        @foreach($categoryFilter->where('parent_id',$item->id) as $sub)

                                            <li>
                                                <div class="filter-checkbox">
                                                    <span class="{{isset($current) && $sub->id==$current?'checked':''}}"></span>
                                                    <span>{{$sub->title}}</span>
                                                </div>
                                                <input checked="{{isset($current) && $sub->id==$current?'checked':''}}" type="checkbox" name="{{$item->id}}[]" value="{{$item->id}}">
                                            </li>

                                        @endforeach
                                    </ul>


                                </li>
                            @endif
                        @endforeach
                    @endif
                    <li>
                        <p>Price</p>
                        <div class="price_filter">
                            <div id="range">
                                <div class="range-input">
                                    <input data='min' type="text" name="min" value="0">
                                    <span>-</span>
                                    <input data='max'  type="text" name="max" value="{{$articles->max('price')}}">
                                </div>

                                <div id="first-range">
                                    <div id="middle-range">
                                        <div id="left-val"></div>
                                        <div id="right-val"></div>

                                    </div>
                                    <span>0</span>
                                    <span>{{$articles->max('price')}}</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><input type="submit" name="" value="Применить"></li>
                </ul>
            </form>

        </aside>
        <div class="catalog_body_wrap">
            <div class="catalog_body">
                <div class="catalog_header">
                    <h2>Top скидки  {{isset($parrent) ? 'категории -'.$parrent->title: ''}} </h2> <div class="filter_btn">
                        <p class="filters">Фильтры  <span class="filters_underline"></span></p>
                        <ul class="filter_burger">
                            <li class="burger_item" id="burger_item1"></li>
                            <li class="burger_item" id="burger_item2"></li>
                            <li class="burger_item" id="burger_item3"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="products-item">

                @if($articles && !$articles->isEmpty())

                        @foreach($articles as $item)
                            <div class="product_item">
                                @if($item->discount)
                                    <div class="discount">
                                        <p>{{$item->discount}}% OFF</p>
                                    </div>
                                @endif
                                <div class="product_img"><img src="{{Storage::disk('s3')->url($item->img->colection[rand(0,count($item->img->colection)-1)])}}" alt="{{$item->title}}"></div>
                                <div class="product_info">
                                    <p>{{$item->title}}</p>
                                </div>
                                <div class="product_price">
                                    @if($item->discount)
                                    <div class="full">
                                        <p>${{$item->price-$item->price*$item->discount/100}}</p>
                                    </div>
                                    @endif
                                        <div class="off">
                                            <p>${{$item->price}}</p>
                                        </div>

                                </div>
                                <a href="single.html" class="more">Больше <i class="fa fa-arrow-circle-o-right"></i></a>
                            </div>
                        @endforeach
                @endif

            </div>
        </div>
    </div>

    @if($articles instanceof \Illuminate\Pagination\LengthAwarePaginator)
    @if( $articles->lastPage() >= 3)
        <ul class="pagination pagination-catalog">
            @if ($articles->currentPage() !== 1)
                <li> <a class="first-page"  href="{{ $articles->url(($articles->currentPage()-1)) }}"></a></li>
            @endif

            @if ($articles->currentPage() == 1)
                <li> <a class="admin-active">{{ 1 }}</a></li>
            @else
                <a href="{{ $articles->url(1) }}">1</a>
            @endif

            <li id="pagination-page"><a href="#">...</a>
                <ul class="subpagin">
                    @for ($i = 2; $i < $articles->lastPage(); $i++)

                        @if ($articles->currentPage() == $i)
                            <li> <a class="admin-active">{{ $i }}</a></li>
                        @else
                            <li> <a href="{{ $articles->url($i) }}">{{ $i }}</a></li>
                        @endif

                    @endfor
                </ul>
            </li>

            @if ($articles->currentPage() == $articles->lastPage()-1)
                <li> <a class="admin-active">{{ $articles->lastPage()-1}}</a></li>
            @else
                <a href="{{ $articles->url($articles->lastPage()-1) }}">{{$articles->lastPage()-1}}</a>
            @endif
            @if ($articles->currentPage() == $articles->lastPage())
                <li>  <a class="admin-active">{{ $articles->lastPage() }}</a></li>
            @else
                <li> <a class="last-page" href="{{ $articles->url( $articles->lastPage()) }}"></a></li>
            @endif

        </ul>
    @elseif($articles->lastPage() >1 && $articles->lastPage() < 4)
        <ul class="pagination pagination-catalog">
            @if ($articles->currentPage() !== 1)
                <li> <a class="first-page"  href="{{ $articles->url(($articles->currentPage()-1)) }}"></a></li>
            @endif

            @if ($articles->currentPage() == 1)
                <li> <a class="admin-active">{{ 1 }}</a></li>
            @else
                <a href="{{ $articles->url(1) }}">1</a>
            @endif

            @if ($articles->currentPage() == 2)
                <li> <a class="admin-active">{{ 2 }}</a></li>
            @else
                <a href="{{ $articles->url(1) }}">2</a>
            @endif
            @if ($articles->currentPage() == $articles->lastPage())
                <li>  <a class="admin-active">{{ $articles->lastPage() }}</a></li>
            @else
                <li> <a class="last-page" href="{{ $articles->url( $articles->lastPage()) }}"></a></li>
            @endif

        </ul>
    @endif
        @endif
@else
    <p>Нет товаров</p>
@endif