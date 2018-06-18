@extends('layouts.site')

@section('header')
    {!! $header !!}

@endsection


@section('content')

    <div class="payment">
        <div class="cart_payment">
            <div class="cart_payment_logo"><img src="{{asset('assets/images/cart.jpg')}}" alt=""></div>
            <h6>Оплата картой</h6>
            <div class="cart_payment_info"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut harum quae unde vel velit.</p></div></div>
        <div class="cash_payment">
            <div class="cash_payment_logo"><img src="{{asset('assets/images/cash.jpg')}}" alt=""></div>
            <h6>Оплата налом</h6>
            <div class="cash_payment_info"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi dicta distinctio dolor dolores dolorum, eius exercitationem magni nobis numquam quod recusandae sequi ullam vitae voluptatum!</p></div></div>
    </div>
    <div class="delivery">
        <div class="post_delivery">
            <div class="post_delivery_logo"><img src="{{asset('assets/images/post.png')}}" alt=""></div>
            <h6>Доставка почтой</h6>
            <div class="post_delivery_info"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque dolore, earum id magni quasi temporibus.</p></div>
        </div>
        <div class="courier_delivery">
            <div class="courier_delivery_logo"><img src="{{asset('assets/images/courier.png')}}" alt=""></div>
            <h6>Доставка курьером</h6>
            <div class="courier_delivery_info"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus, tempore!</p></div>
        </div>
        <div class="get_from_shop">
            <div class="get_from_shop_logo"><img src="{{asset('assets/images/shop.jpg')}}" alt=""></div>
            <h6>Забрать из магазина</h6>
            <div class="get_from_shop_info"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet consequatur cum dolore enim esse harum, id nesciunt nulla unde voluptates?</p></div>
        </div>
    </div>


@endsection


@section('footer')

    {!! $footer !!}

@endsection