@extends('layouts.site')

@section('header')
    {!! $header !!}

@endsection


@section('content')

    <main class="contact_us">

        <div class="contacts_body">
            <h6>Контакты</h6>
            <div class="adress"><i class="fa fa-map-marker"></i><p>Маршала Говорова 11-А, к.407м</p></div>
            <div class="number"><i class="fa fa-phone"></i><a href="tel:+380991116134">+380 99 111 61 34</a></div>
            <div class="mail"><i class="fa fa-envelope"></i><a href="mailto:top_site@ot.bogov.com">top_site@ot.bogov.com</a></div>
            <div class="contacts_info"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae deleniti mollitia nobis reprehenderit voluptates. Dolorem, fugit maiores. Commodi cumque eos est ipsa iure, officia perferendis quis ratione unde voluptatibus? Eligendi ipsam numquam ullam. Ad alias architecto autem consequuntur ea, error est expedita inventore ipsa mollitia sunt ullam unde ut voluptas.</p></div>
        </div>
        <div class="contacts_form">
            <h6>Оставьте свои данные, и мы свяжемся с вами</h6>
            <form action="">
                <label> Имя и фамилия
                    <i class="fa fa-user-circle-o form_icon"></i>
                    <input type="text" name="name" autocomplete="new-password">
                </label>
                <label> Email
                    <i class="fa fa-envelope form_icon"></i>
                    <input type="email" autocomplete="new-password">
                </label>
                <label for=""> Телефон
                    <i class="fa fa-phone-square form_icon"></i>
                    <input type="tel">
                </label>
                <label> Сообщение
                    <textarea></textarea>
                </label>
                <input type="submit">
            </form>
        </div>
    </main>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5498.18089328405!2d30.745443154013767!3d46.44690487785801!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c633e9d02a1f05%3A0x61705a7585cb6995!2z0JPRg9GA0YLQvtC20LjRgtC-0Log4oSWNCDQntCd0J_Qow!5e0!3m2!1sru!2sua!4v1527522603262" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>


@endsection


@section('footer')

    {!! $footer !!}

@endsection