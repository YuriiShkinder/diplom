@if($sliders&&!$sliders->isEmpty())
<div class="slider">
    <div class="slides">
        @foreach($sliders as $item)
        <div class="slide-item ">
            <img src="{{asset('assets/images/products/'.$item->img->path)}}" alt="{{$item->title}}">
            <div class="slide-content">
                <p>Бесплатная доставка</p>
                <h1>{{$item->title}}</h1>
                <a href="/">К товару</a>

            </div>
        </div>
        @endforeach

    </div>
    <ul class="slider-list">  </ul>
    <div class="slide-nav">
        <span id="prev" class="prev"></span>
        <span id="next" class="next"></span>
    </div>

</div>

    @endif