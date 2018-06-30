@extends('layouts.site')

@section('header')
    {!! $header !!}

@endsection


@section('content')

    <div class="container-login">
        <img src="{{asset('assets/images/men.png')}}">
        <form id="register"  action="{{ url('/register') }}" method="post">

            <div class="dws-input">
                <input type="text" name="name" value="{{old('name')}}"  placeholder="Введите имя">
                @if ($errors->has('name'))
                    <span class="has-messages">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>
            <div  class="dws-input">
                <input type="text" name="last" value="{{old('last')}}"   placeholder="Введите фамилию">
                @if ($errors->has('last'))
                    <span class="has-messages">
                        {{ $errors->first('last') }}
                    </span>
                @endif
            </div>
            <div  class="dws-input">
                <input type="text" name="login" value="{{old('login')}}"   placeholder="Введите login">

                @if ($errors->has('login'))
                    <span class="has-messages">
                        {{ $errors->first('login') }}
                    </span>
                @endif
            </div>
            <div id="phone" class="dws-input">
                <input type="text" name="phone" value="{{old('phone')}}"   placeholder="Введите телефон">
                @if ($errors->has('phone'))
                    <span class="has-messages">
                        {{ $errors->first('phone') }}
                    </span>
                @endif
            </div>
            <div class="dws-input">
                <input type="text" name="address" value="{{old('address')}}"   placeholder="Введите адрес">
                @if ($errors->has('address'))
                    <span class="has-messages">
                        {{ $errors->first('address') }}
                    </span>
                @endif
            </div>

            <div class="dws-input ">
                <input   type="email" name="email" value="{{old('email')}}"   placeholder="Введите email">
                @if ($errors->has('email'))
                    <span class="has-messages">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
            <div class="dws-input">
                <input type="password" name="password"  placeholder="Введите пароль">
                @if ($errors->has('password'))
                    <span class="has-messages">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>
            <div class="dws-input">
                <input type="password" name="password_confirmation"  placeholder="Подтвердите пароль">
            </div>


            <input id="reg-submit" class="dws-submit" type="submit" name="submit" value="Регистрация">
            @csrf
        </form>

    </div>

@endsection


@section('footer')

    {!! $footer !!}

@endsection