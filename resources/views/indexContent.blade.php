<div class="products">
    <div class="products-info">
        <h3>Best Sellers</h3>
        <a href="{{route('bestSellers')}}">Больше</a>
    </div>
    @if($bestSellers && !$bestSellers->isEmpty())
    <div class="products-item">
        @foreach($bestSellers as $item)
        <div class="product_item">
            @if($item->discount)
            <div class="discount">
                <p>{{$item->discount}}% OFF</p>
            </div>
            @endif
            <div class="product_img"><img src="{{asset('assets/images/products/'.$item->img->path)}}" alt="{{$item->title}}"></div>
            <div class="product_info">
                <p>{{$item->title}}</p>
            </div>
            <div class="product_price">
                <div class="full">
                    <p>${{$item->price}}</p>
                </div>
                @if($item->discount)
                <div class="off">
                    <p>${{$item->price-$item->price*$item->discount/100}}</p>
                </div>
                @endif
            </div>
            <a href="single.html" class="more">Больше <i class="fa fa-arrow-circle-o-right"></i></a>
        </div>
   @endforeach
    </div>
    @else
        <p>Нет товаров</p>
    @endif
</div>



<div id="fashion" class="products">
    <div class="products-info">
        <h3>Popular Products</h3>
        <a href="{{route('popularProducts')}}">Больше</a>
    </div>
    @if($manyLikes && !$manyLikes->isEmpty())
        @set($i,0)
        @set($curent,'front-slide')

    <div class="products-item">
        <div class="products-slider">
            <div class="product-slide">
                <div class="cube-slide">
                    @foreach($manyLikes as $item)
                        @switch($i)
                            @case(0)
                            @set($curent,'front-slide')

                            @break

                            @case(1)
                            @set($curent,'back-slide hide')

                            @break

                            @case(2)
                            @set($curent,'left-slide')

                            @break

                            @case(3)
                            @set($curent,'right-slide')

                            @break

                            @default
                            @set($curent,'')
                        @endswitch
                    <div slide-number="{{$i}}"  class="side-slide {{$curent}}">
                        <div class="slide-row">
                            <div class="product-slide-info">
                                @if($item->discount)
                                <span class="product-sale">{{$item->discount}}% off</span>
                                @endif
                                <p>{{$item->title}}</p>
                            </div>
                            <div class="product-slide-info">
                                <img src="{{asset('assets/images/products/'.$item->img->path)}}" alt="{{$item->title}}">
                            </div>
                        </div>
                        <div class="slide-row">
                            <div class="product-slide-info">
                                <div class="price-sale">
                                    @if($item->discount)
                                        <p class="sale">${{$item->price-$item->price*$item->discount/100}}</p>
                                    @endif
                                    <p>${{$item->price}}</p>
                                </div>
                            </div>
                            <div class="product-slide-info">
                                <button class="button9" type="button" name="button9">К товару </button>
                            </div>
                        </div>
                    </div>
                    @set($i,$i+1)
                    @endforeach

                </div>
            </div>


            <ul class="slider-mark"> </ul>

        </div>
        <div class="product-item">
            @foreach($manyLikes as $item)

            <div class="product-tovar active-tovar">
                @if($item->discount)
                <span class="product-sale">{{$item->discount}}% off</span>
                @endif
                <img src="{{asset('assets/images/products/'.$item->img->path)}}" alt="{{$item->title}}">
                <p>{{$item->title}}</p>
            </div>

            @endforeach
        </div>
    </div>
        @else
        <p>Нет товаров</p>
    @endif
</div>

<div class="products">
    <div class="products-info">
        <h3>Top comments</h3>
        <a href="{{route('popularProducts')}}">Больше</a>
    </div>
    @if($topComments && !$topComments->isEmpty())
        @set($i,0)
        @set($curent,'front-slide')
    <div class="collections">
        @foreach($topComments as $item)

            <div class="collection-items">
                <div class="collection-img">
                    <span class="lock"></span>
                    <div class="cube">
                        <div class="side front">
                            <img src="{{asset('assets/images/products/'.$item->article->img->colection[$i++])}}" alt="{{$item->article->title}}">
                        </div>
                        <div class="side back">
                            <img src="{{asset('assets/images/products/'.$item->article->img->colection[$i++])}}" alt="{{$item->article->title}}">
                        </div>
                        <div class="side left">
                            <img src="{{asset('assets/images/products/'.$item->article->img->colection[$i++])}}" alt="{{$item->article->title}}">
                        </div>
                        <div class="side right">
                            <img src="{{asset('assets/images/products/'.$item->article->img->colection[$i++])}}" alt="{{$item->article->title}}">
                        </div>
                    </div>

                </div>
                <h3>{{$item->article->title}}</h3>
                <p>{{str_limit($item->article->desc)}}</p>
                <div class="btn-wrap">
                    <div class="btn">
                        <span>${{$item->article->price}}</span>
                        <a href="single.html">К товару????</a>
                        <div class="btn-img">
                            <img src="{{asset('assets/icon.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
                @set($i,0)
        @endforeach

    </div>
    @else
        <p>Нет товаров</p>
    @endif
</div>