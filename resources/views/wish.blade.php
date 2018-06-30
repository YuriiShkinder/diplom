<div  class="container wish">
    <h2>Wishlist</h2>
    @if(!$cartItems->isEmpty())
        @foreach($cartItems as $item)
    <div class="cart_item">

        <div class="cart_item_img"><img src="{{Storage::disk('s3')->url($item->options->img)}}" alt=""></div>
        <div class="cart_item_info">
            <div class="cart_item_name"><p>{{$item->name}}</p></div>
            <div class="cart_item_price">
                <p>{{$item->price}}<span>грн</span></p>
                <div class="wish_btns">
                    <i href="{{route('removeWish',['article'=>$item->rowId])}}" class="fa fa-heart" title="Удалить из избранного ;("></i>
                    <i href="{{route('addCart',['article'=>$item->id])}}" class="fa fa-shopping-cart"  title="Добавить в корзину!"></i>
                </div>
            </div>
        </div>

    </div>

        @endforeach
    @else
        <h4>Пусто</h4>
    @endif
</div>