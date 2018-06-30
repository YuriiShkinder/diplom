<header>
    <div class="wrap-header">
        <div class="top">
            <div class="logo">
                <ul class="logo-list">
                    <li>S</li>
                    <li>h</li>
                    <li>e</li>
                    <li>l</li>
                    <li>l</li>
                    <li>J</li>
                    <li>e</li>
                    <li>e</li>
                </ul>
            </div>

            <ul class="head-menu">
                <div class="search_button">
                    <form action="{{route('searchArticle')}}" method="post">
                        @csrf
                        <input type="search" class="search">
                        <i class="fa fa-search"></i>
                    </form>
                    <div class="search_list">
                        <ol>

                        </ol>
                    </div>
                </div>
                <li class="cart"><a href="{{route('cart')}}">Cart</a>  <span class="count-list">{{Cart::instance('cart')->count()}}</span></li>
                <li class="wishlist circle"> <a href="{{route('wish')}}">Wishlist</a> <span class="count-list">{{Cart::instance('wishlist')->content()->count()}}</span></li>
                <li class="account">
                    <span class="arrow"></span>
                    @guest
                        <ul>
                            <li> <a href="{{route('login')}}">Login</a> </li>
                            <li> <a href="{{route('register')}}">Register</a> </li>
                        </ul>
                        Login/Register
                    @else
                        <ul>
                            <li><a href="{{route('acount')}}">Acount</a></li>
                            <li> <a href="admin.html">Admin panel</a></li>
                            <li> <a href="{{url('/logout')}}">Logout</a></li>
                        </ul>
                        My Account
                    @endguest
                </li>
            </ul>
        </div>
        <ul class="middle">
            <li ><span id="shopCategory">Категории товаров</span>
                <span class="arrow"></span>
                <ul class="category" >
                    @if(!empty($menu))
                    @include('customMenu',['items'=>$menu->roots()])
                        @else
                        <li>Нет товаров</li>
                    @endif
                </ul>
            </li>
            <li class="{{Route::currentRouteName()=='home'? 'hoverMenu':''}}" > <a href='{{route('home')}}'>Home</a> </li>
            <li class="{{Route::currentRouteName()=='allArticles'? 'hoverMenu':''}}">  <a href="{{route('allArticles')}}">Все товары</a> </li>
            <li class="{{Route::currentRouteName()=='popularProducts'? 'hoverMenu':''}}">  <a href="{{route('popularProducts')}}">Popular Products</a> </li>
            <li class="{{Route::currentRouteName()=='bestSellers'? 'hoverMenu':''}}"> <a href="{{route('bestSellers')}}">Best Sellers</a> </li>
            <li class="{{Route::currentRouteName()=='about'? 'hoverMenu':''}}" > <a href="{{route('about')}}">Про нас</a> </li>
            <li class="{{Route::currentRouteName()=='delivery'? 'hoverMenu':''}}">  <a href="{{route('delivery')}}">Доставка и оплата</a> </li>
            <li class="{{Route::currentRouteName()=='contact'? 'hoverMenu':''}}"><a href="{{route('contact')}}">Контакты</a> </li>
            <ul class="menu-toggle">
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </ul>
        <ul class="right-menu">
            <li><div class="search_button">
                    <form action="{{route('searchArticle')}}" method="post">
                        <input type="search" class="search">
                        <i class="fa fa-search"></i>
                    </form>
                    <div class="search_list">
                        <ol>
                        </ol>
                    </div>
                </div></li>
            <li class="{{Route::currentRouteName()=='home'? 'admin-active':''}}" > <a href='{{route('home')}}'>Home</a> </li>
            <li class="{{Route::currentRouteName()=='allArticles'? 'admin-active':''}}">  <a href="{{route('allArticles')}}">Все товары</a> </li>
            <li class="{{Route::currentRouteName()=='popularProducts'? 'admin-active':''}}">  <a href="{{route('popularProducts')}}">Popular Products</a> </li>
            <li class="{{Route::currentRouteName()=='bestSellers'? 'admin-active':''}}"> <a href="{{route('bestSellers')}}">Best Sellers</a> </li>
            <li class="{{Route::currentRouteName()=='about'? 'admin-active':''}}" > <a href="{{route('about')}}">Про нас</a> </li>
            <li class="{{Route::currentRouteName()=='delivery'? 'admin-active':''}}">  <a href="{{route('delivery')}}">Доставка и оплата</a> </li>
            <li class="{{Route::currentRouteName()=='contact'? 'admin-active':''}}"><a href="{{route('contact')}}">Контакты</a> </li>
        </ul>
    </div>
</header>