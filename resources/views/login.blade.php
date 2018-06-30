@extends('layouts.site')

@section('header')
    {!! $header !!}

@endsection


@section('content')

    <div class="container-login">
        <img src="{{asset('assets/images/men.png')}}">
        <form id="register" action="{{ url('/login') }}" method="post">
            <div class="dws-input">
                <input type="text" name="login"  placeholder="Введите login">
                @if ($errors->has('login'))
                    <span class="has-messages">
                        {{ $errors->first('login') }}
                    </span>
                @endif
            </div>
            <div id="pass" class="dws-input">
                <input type="password" name="password"  placeholder="Введите пароль">
                @if ($errors->has('password'))
                    <span class="has-messages">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>

            <input id="reg-submit" class="dws-submit" type="submit" name="submit" value="Войти">
            @csrf
        </form>

    </div>

@endsection


@section('footer')

    {!! $footer !!}

@endsection