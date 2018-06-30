



<h2>Cart</h2>
@if(!$cartItems->isEmpty())
@foreach($cartItems as $item)

<div class="cart_item">
    <div action="{{route('removeProduct',['article'=>$item->rowId])}}" class="delete_item_btn"><i class="fa fa-window-close"></i></div>
    <div class="cart_item_img"><img src="{{Storage::disk('s3')->url($item->options->img)}}" alt=""></div>
    <div class="cart_item_info">
        <div class="cart_item_name"><p>{{$item->name}}</p></div>
        <div class="cart_item_price"><p>{{$item->price}}  <span>грн</span></p></div>
    </div>
    <div class="cart_item_amount">

        <form action="{{route('updateProduct',['article'=>$item->rowId])}}" method="post">
            <span class="minus">-</span>
            <input type="text" value="{{$item->qty}}" class="number">
            <span class="plus">+</span>
        </form>

    </div>
    <div class="cart_item_sum">
        <span class="cart_sum">Сумма</span>
        <p></p>
    </div>
</div>
@endforeach
<div class="cart_ready">
    <div class="cart_ready_content">
        <div class="total_sum"><p class="total">Итого:</p><p class="all_sum"></p></div>
        <div class="ready_button"><button class="ready">Оформить покупку</button></div>
    </div>
</div>
    @else
    <h4>Корзина пустая</h4>
    @endif