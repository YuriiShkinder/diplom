<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/icons/heart.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}" type="text/css">
    <title>{{$title or 'ShellJee'}}</title>
</head>

<body>
<div id="p_prldr">
    <div class="prl prl1"></div>
    <div class="prl prl2"></div>
    <div class="wrap-prl">  </div>
</div>

@yield('header')
<div class="container">
    @yield('slider')

    @yield('content')
</div>
@yield('footer')


</body>
<script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/slider.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/my.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/rang.js')}}"></script>
</html>