@if($article )

<main class="single_product">
    <div class="single_product_header">
        <div class="single_images">
            <ul class="single_images_list">
                @set($i,1)
                @foreach($article->img->colection as $item)
                <li class="single_img" id="{{$i++}}"><img src="{{Storage::disk('s3')->url($item)}}" alt=""></li>
                 @endforeach
            </ul>
        </div>
        <div class="single_content">
            <h2>{{$article->title}}</h2>
            <div class="price"><p>$ {{$article->price}} $</p></div>
            <div class="overview">
                <h5>Overview:</h5>
                <p> {{$article->desc}}</p>
            </div>
            <div class="add_wish">
                <a href="{{route('addWish',['article'=>$article->id])}}" class="add_to_wish"><i class="fa fa-heart"></i> Add to Wishlist</a>
            </div>
            <div class="quantity">
                <div class="cart_item_amount">

                    <form action="{{route('addProduct',['article'=>$article->id])}}" method="post">
                        <span class="minus">-</span>
                        <input type="text" value="1" class="number">
                        <span class="plus">+</span>
                        <input  type="submit" value="Add to Cart" >
                    </form>


                </div>
                {{--<a href="#" class="add_to">Add to Cart</a>--}}
            </div>
        </div>
    </div>
</main>
<div class="single_product_info">
    <div class="info_buttons">
        <div class="description_btn active">
            <p>Опис</p>
        </div>
        <div class="reviews_btn ">
            <p>Reviews</p>
        </div>
    </div>
    <div class="single_description">
        <p>{{$article->text}}</p>
    </div>
    <div class="reviews ">
        <ul class="commentlist">
        @if($comments)

            @foreach($comments as $parent_id=>$item)
                @if($parent_id !== 0)
                   @break
                @endif

                    @include('comment',['items'=>$item])
            @endforeach
            @else
            <p>Нет коментариев</p>
        @endif
        </ul>
        @auth()
            <div class="comment_textarea">
                <h6>Оставьте ваш отзыв, нам очень интересно(нет)</h6>
                <div class="coment-reviews-form">
                    <form  action="{{route('addComment')}}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <input type="hidden" name="article_id" value="{{$article->id}}">
                        <input type="hidden" name="parent_id" value="0">
                        <textarea name="text" class="textarea"></textarea>
                        <button type="submit" class="reply send-comment">Отправить <i class="fa fa-reply"></i></button>
                    </form>
                </div>

            </div>
        @else
           <div style="text-align: center; padding: 20px"><a     href="{{route('login')}}">Авторизуйтесь для написания комментариев</a></div>
            @endauth
    </div>
</div>
<div class="catalog_content">

    <div class="catalog_body">
        <div class="catalog_header">
            <h2>Рекомендовани товары</h2>
        </div>
        <div class="catalog_content">

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
                                <div class="stars_bg" style="width: {{$item->likes->avg('count')*20}}%"></div>
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


        </div>

        </div>
    </div>
</div>
    @else
    <p>Нет товаров</p>
@endif