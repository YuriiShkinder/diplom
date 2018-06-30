@extends('layouts.site')

@section('header')
    {!! $header !!}

@endsection



@section('content')
    <div class="error">
    <h1 >ERROR 404</h1>

    <a  href="{{ route('home') }}">Home</a>
    </div>
@endsection


