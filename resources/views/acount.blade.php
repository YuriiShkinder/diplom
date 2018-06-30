@if (count($errors) > 0)
        <div class="message">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
        </div>
    <script>
        setTimeout(function () {
            $('.message').remove();
        },5000)
    </script>
@endif


@if (session('status'))
        <div class="message"><p>{{ session('status') }}</p></div>
        <script>
            setTimeout(function () {
                $('.message').remove();
            },5000)
        </script>
@endif



<div class="acount">
    <h3>Личный кабинет</h3>
    <div class="acount-content">
        <div class="acount-menu">
            <div class="acount-img">
                <img src="{{ Storage::disk('s3')->exists($user->img) ? Storage::disk('s3')->url($user->img) : $user->img }}" alt="gggg">
            </div>
            <ul class="acount-list">
                <li class="current-acount-menu" data-block="acount-contact"><a href="#">Личные данные</a></li>
                <li data-block="reviews"><a href="#">Мои отзывы</a></li>
                <li data-block="acount-order"><a href="#">Мои заказы</a></li>
                <li data-block="acount-password"><a href="#">Смена пароля</a></li>
                <li data-block="acount-avatar"><a href="#">Смена фото</a></li>
            </ul>
        </div>
        <div class="acount-data">

            <div id="acount-contact" >
                <h4>Контактые данные</h4>
                <form class="acount-form" action="{{route('acountEdit')}}" method="post">
                    @csrf
                    <div class="acount-input">
                        <label for="acount-name" >Имя*:</label><br>
                        <input id="acount-name" type="text" name="name" value="{{$user->name}}">
                    </div>
                    <div class="acount-input">
                        <label for="acount-last" >Фамилия*:</label><br>
                        <input id="acount-last" type="text" name="last" value="{{$user->last}}">
                    </div>
                    <div class="acount-input">
                        <label for="acount-city" >Город*:</label><br>
                        <input id="acount-city" type="text" name="address" value="{{$user->address}}">
                    </div>
                    <div class="acount-input">
                        <label for="acount-email" >Email*:</label><br>
                        <input id="acount-email" type="email" name="email" value="{{$user->email}}">
                    </div>
                    <div class="acount-input">
                        <label for="acount-phone" >Телефон*:</label><br>
                        <input id="acount-phone" type="text" name="phone" value="{{$user->phone}}">
                    </div>
                    <input type="submit"  value="Сохранить">
                </form>
            </div>

            <div id="reviews" >
                <h4>Мои отзывы</h4>
                @if($comments && !$comments->isEmpty())
                @foreach($comments as $article=>$comment)

                <div class="reviews-acount">
                    <div class="acount-product">
                        <div>
                            <img src="{{Storage::disk('s3')->url(json_decode($comment[0]->article->img)->colection[0])}}" alt="">
                        </div>
                        <p>Lorem ipsum dolor sit amet</p>
                        <a href="{{route('showArticle',['category'=>$comment[0]->article->category->alias,'article'=>$comment[0]->article->id])}}">К товару</a>
                    </div>
                    <div class="acount-reviews">
                        @foreach($comment as $item)
                        <div class="acount-reviews-content">
                            <p>{{$item->text}}</p>
                            <div class="reviews-date">
                                <span>{{is_object($item->created_at) ? $item->created_at->format('F d, Y  \a\t H:i') : '' }}</span>
                                <div>
                                    <i class="fa fa-thumbs-o-up" aria-hidden="true">{{$item->likes()->where('like','1')->get()->count()}}</i>
                                    <i class="fa fa-thumbs-o-down" aria-hidden="true">{{$item->likes()->where('like','-1')->get()->count()}}</i>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                @endforeach
                @else
                    <h4>Нет комментариев</h4>
                @endif
            </div>

            <div id="acount-order">
                <h4>Мои заказы</h4>
                @if($user->orders && !$user->orders->isEmpty() )
                <table>
                    <tr>
                        <td style="width:30%;">Продукт</td>
                        <td  style="width:20%;">Количество</td>
                        <td  style="width:20%;">Цена</td>
                        <td  style="width:30%;">Дата</td>
                    </tr>
                @foreach($user->orders as $order)
                    <tr>
                        <td>
                            <img src="{{Storage::disk('s3')->url(json_decode($order->article->img)->colection[0])}}" alt="">
                            <p>{{$order->article->title}}</p>
                            <a href="{{route('showArticle',['category'=>$order->article->category->alias,'article'=>$order->article->id])}}">К товару</a>
                        </td>
                        <td>{{$order->count}}</td>
                        <td>{{$order->count*$order->article->price}}$</td>
                        <td ><span>{{is_object($item->created_at) ? $item->created_at->format('F d, Y  \a\t H:i') : '' }}</span></td>
                    </tr>
                @endforeach

                </table>
                @else
                    <h4>Вы ничего не покупали</h4>
                @endif
            </div>

            <div id='acount-password' >
                <h4>Смена пароля</h4>
                <form class="acount-form" action="{{route('editPass')}}" method="post">
                    @csrf
                    <div class="acount-input">
                        <label for="acount-pass" >Password*:</label><br>
                        <input id="acount-pass" type="password" name="password" placeholder="Ваш новый пароль" value="">
                    </div>
                    <input type="submit"  value="Сохранить">
                </form>
            </div>
            <div id="acount-avatar" >
                <h4>Смена фото</h4>
                <form class="acount-form" action="{{route('editFoto')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="acount-foto">
                        <img height="200" src="{{Storage::disk('s3')->exists($user->img) ? Storage::disk('s3')->url($user->img) : $user->img }}" alt="foto">
                    </div>
                    <div class="file_upload">
                        <button type="button">Выбрать</button>
                        <div>Файл не выбран</div>
                        <input type="file" name="file">
                    </div>

                    <input type="submit"  value="Сохранить">
                </form>
            </div>
        </div>
    </div>

</div>