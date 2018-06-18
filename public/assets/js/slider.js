
$(document).ready(function(){
var slides=$('.slides').children('.slide-item');
var widthItem=$('.container').width();
$('.slide-item').width(widthItem+'px');
var width=widthItem;
var countSlide=slides.length;
var offset=countSlide*width;
$('.slides').css('width',offset);

for (var i = 0; i <countSlide ; i++) {
  if(i==0){
      $('.slider-list').append('<li class="item-active"></li>');
  }else {
      $('.slider-list').append('<li></li>');
  }
}
offset=0;
currentSlide=0;

slideList=$('.slider-list').children('li');
function Interval(fn, time) {

    var timer = false;
    this.start = function () {
        if (!this.isRunning())
            timer = setInterval(fn, time);
    };
    this.stop = function () {
        clearInterval(timer);
        timer = false;
    };
    this.isRunning = function () {
        return timer !== false;
    };
}
function hideSpan(){
  if((countSlide-1)==currentSlide){
    $('#next').css('opacity',0);
  }else{
    $('#next').css('opacity',1);
  }
  if(currentSlide==0){
    $('#prev').css('opacity',0);
  }else{
    $('#prev').css('opacity',1);
  }
}
function autoSlider(){
if(offset< width*(countSlide-1)){
  offset+=width;
  currentSlide++;
}else {
  currentSlide=0;
  offset=0;
}
hideSpan();
$('.slider-list .item-active').removeClass('item-active');
$(slideList[currentSlide]).addClass('item-active');
$(".slider .slides").css("transform","translate3d(-"+offset+"px, 0px, 0px)");
}

var i = new Interval(autoSlider,3000);
i.start();
$('.slider').on('click','ul.slider-list li',function(){
$(this).siblings().removeClass('item-active') ;
$(this).addClass('item-active');
offset= width*$(this).index();
currentSlide=$(this).index();
$(".slider .slides").css("transform","translate3d(-"+offset+"px, 0px, 0px)");
});

$('#next').click(function(){
 if(offset< width*(countSlide-1)){
   offset += width;
   $(".slider .slides").css("transform","translate3d(-"+offset+"px, 0px, 0px)");
   $('.slider-list .item-active').removeClass('item-active');
   $(slideList[++currentSlide]).addClass('item-active');
 }
});

$('#prev').click(function(){
 if(offset > 0){
   offset -= width;
   $(".slider .slides").css("transform","translate3d(-"+offset+"px, 0px, 0px)");
   $('.slider-list .item-active').removeClass('item-active');
   $(slideList[--currentSlide]).addClass('item-active');
 }
});
$('.slider').on('click','.slider-list,#prev,#next',function(){
    hideSpan();
  if(i.isRunning()){
  i.stop();
  setTimeout(function(){
      i.start();
  },2000)
}
})
$(window).resize(function(){
  width=$('.container').width();
  offset=countSlide*width;
  $('.slides').css('width',offset);
  $(".slider .slides").css("transform","translate3d(-"+offset+"px, 0px, 0px)");
})
});
