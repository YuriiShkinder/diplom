$(window).on('load', function () {
    var preloader = $('#p_prldr');
    // preloader.delay(500).fadeOut('slow');
    $('.wrap-prl').fadeOut(400,function(){
      $('.prl').animate({
        opacity:0,
        width:0
      },{
        complete:function(){
          preloader.hide();
        },
        duration:1000
      })
    });

  })
$(document).ready(function(){
    var logoo = $('.logo-list li');
    var i=0;
    logoo.each(function () {
      var ind=$(this).index()+1;
      if(ind<=3){
        $(this).css('transform','translateX('+(-(4-ind)*180)+'px)');
      }
      if(ind>5){
        $(this).css('transform','translateX('+((ind-5)*50)+'px)');
      }
    })
  logoanimate=setInterval(function () {
    if (i< logoo.length) {
      $(logoo[i++]).css({'transform':'translateY(0px)',opacity:1});
    }else {
      clearInterval(logoanimate);
    }
  },300)
  $('.logo-list li').mouseover(function(){
    var x=Math.random()*20-10;
    var y=Math.random()*20-10;
    $(this).css('transform','translate('+(x*10)+'px,'+(y*10)+'px)');
  })
  $('.logo-list').mouseleave(function(){
    logoo.each(function () {
    $(this).css('transform','translate(0px)');
    })
  })
 setTimeout(function(){
   i=0;
   k=0;
   setInterval(function(){
     if (i< logoo.length && k==0) {
       $(logoo[i++]).css('transform','translateY(2px)');
     }else {
       k=1;
       if(i<0){
         k=0;
         i=0;
         $(logoo[0]).css('transform','translateY(-2px)');
       }else{
         $(logoo[i--]).css('transform','translateY(-2px)');
       }
     }
   },100)
 },3000)
 $(document).click(function (e) {
   if( $(e.target).closest('.menu-toggle').length ){
     if(!$('.right-menu').hasClass('right-animation')){
         $('.right-menu').addClass('right-animation');
         $(".menu-toggle li:first-child").css({"opacity":"0"});
         $(".menu-toggle li:last-child").css({"top" : "calc(50% + 0px)" , "transform" : "rotate(-45deg)"});
         $(".menu-toggle li:nth-child(2)").css({"transform" : "rotate(45deg)"});
     }else {
        $('.right-menu').removeClass('right-animation');
        $(".menu-toggle li:first-child").css({"opacity":"1"});
        $(".menu-toggle li:last-child").css({"top" : "calc(50% + 9px)" , "transform" : "rotate(0)"});
        $(".menu-toggle li:nth-child(2)").css({"transform" : "rotate(0)"});
     }
   }else {
     if(!$(e.target).closest('.right-menu').length){
       $('.right-menu').removeClass('right-animation');
       $(".menu-toggle li:first-child").css({"opacity":"1"});
       $(".menu-toggle li:last-child").css({"top" : "calc(50% + 9px)" , "transform" : "rotate(0)"});
       $(".menu-toggle li:nth-child(2)").css({"transform" : "rotate(0)"});
     }

   }
     if(!($(e.target).closest(".search_button").length)) {
         $(".search").css({"width":"0","opacity":"0","border-bottom":"1px solid transparent"});
         $(".search").blur();
         $(".search_button form").css({"margin-right":"15px"});
         $(".search_list ol").css({"display":"none"});
         $(".search").val('');
     }
 });


 $(".search").keyup(function () {
     if ($(this).val().match(/[\S]{3}/gi)) {
        $(this).parent().siblings(".search_list").children('ol').css({"display":"block"});
     } else {
         $(".search_list ol").css({"display":"none"});
     }
 });

 $(".search_button").click(function () {
     $(this).css({"border-radius":"2px","width":"auto"});
    $(this).find(".search").css({"width":"130px","opacity":"1","border-bottom":"1px solid #fff"});
     $(this).find(".search").focus();
    $(this).children("form").css({"margin-right":"0"})
 });

 //валідація форми реєстрації
 // валідація {required,min,max,email,confirm.phone}
 class Validator {
    constructor(form,rules,message) {
    this.errors=[];
    this.message=message;
    this.form = form;
    this.rules=  this.parsRules(rules);
    this.validate();

    }
    checkErrors(){
      this.form.find('input').removeClass('has-error');
      this.form.find('input').siblings('span').remove();
      if(!$.isEmptyObject(this.errors)){

        for (var nameInput in this.errors) {
          var input=  this.form.find('input[name='+nameInput+']');
        var message='';
          for (var i=0 ;i< this.errors[nameInput].length; i++) {
            for (var rules in this.errors[nameInput][i]) {
                message+=this.message[rules]+'<br>';
              if(this.rules[nameInput][i] instanceof Object){
                 var reg=':'+rules;
                 message=message.replace(reg,this.rules[nameInput][i][rules]);
              }
            }
          }
          var htmlError='<span class="has-messages">'+message+'</span>';
          input.addClass('has-error');
          input.parent().append(htmlError);
        }
        setTimeout(function(){
          $('.has-messages').fadeOut(500);
        },10000)
        return false;
      }
      return true;
    }
    inputError(nameRul,nameInput,isHas){
      var objError=[];
      objError[nameRul]=isHas;
      if(this.errors[nameInput]){
          this.errors[nameInput].push(objError);
      }else {
          this.errors[nameInput]=[objError];
      }
      objError=[];
    }
    vlalidateInput(input,nameInput){
      var rules=this.rules[nameInput];

      for (var i = 0; i <rules.length; i++) {
        var rul=rules[i];
        var nameRul='';
        var valueRul=0;
        var value=$(input).val();
        var objError=[];
        if(rul instanceof Object){
          for (var key in rul) {
            nameRul=key;
            valueRul=rul[key];
          }
        }else {
          nameRul=rul;

        }
        switch (nameRul) {
          case 'required':
              if(value == ''){
              this.inputError(nameRul,nameInput,false);
              }
          break;
          case 'phone':
          var reg= /^\+380[0-9]{7}/i;
          if(!reg.test(String(value))){
          this.inputError(nameRul,nameInput,false);
          }
          break;

          case 'min':
                if(value.length < valueRul){
                this.inputError(nameRul,nameInput,false);
                }
          break;

          case 'max':
                if(value.length > valueRul){
                this.inputError(nameRul,nameInput,false);
                }
          break;

          case 'email':
              var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(!re.test(String(value))){
                this.inputError(nameRul,nameInput,false);
                }
          break;

          case 'confirm':
              if(value =='' || value != this.form.find('input[name="password"]').val()){
                this.inputError(nameRul,nameInput,false);
                }
          break;
          default:
            this.inputError(nameRul,nameInput,false);
        }
      }
    }

    validate(){
     var input=this.form.find('input:not("input[type=submit]")');
      for (var i = 0; i < input.length; i++) {
          var rules=this.rules[$(input[i]).attr('name')];
          if(rules){
              this.vlalidateInput(input[i],$(input[i]).attr('name'));
          }
      }
    }

    parsRules(rules){
        var patt = /:/;
        for(var key in rules){
          var arr = rules[key].split('|');
          var rul=[];
          for(var i=0;i<arr.length;i++){
            if(patt.test(arr[i])){
              var item=arr[i].split(':');
              var obj=[];
             obj[item[0]]= item[1];
             rul.push(obj);
            }else{
                rul.push(arr[i]);
            }
          }
          rules[key]=rul;
        }
        return rules;
    }
  }
 $('#reg-submit').click(function (event) {

   var rules={
     'name':'required|min:2',
     'last':'required|min:2',
     'email':'email',
     'phone':'phone',
     'password':'required|min:6',
     'confirm':'confirm:password'
   };
   var message={
     'required':'Поле обязательно к заполнению!',
     'email':'Поле должно быть формата test@test.com',
     'phone':'Поле должно быть формата +380686873719',
     'min':'Поле должно быть не меньше :min символов',
     'confirm':'Поле должно равним :confirm',
     'max':'Поле должно быть не меньше :max символов',
   }
 var validator =  new Validator($('#register'),rules,message);

 return validator.checkErrors();
 })
 $('.dws-input').on('click','.has-messages',function () {
   $(this).hide();
 })




var imgSrc=false;
  var modalCurrentImg=0;
  function modalFoto(e,thais){
    imgSrc={
      'imgSrc':$(e.target).attr('src'),
      'collectionImg':thais.find('img')
    }
    for (var i = 0; i < imgSrc.collectionImg.length; i++) {

      if($(imgSrc.collectionImg[i]).attr('current')){
        modalCurrentImg=i;
        $(imgSrc.collectionImg[i]).attr('current','');
      }
    }

  }
$('.collection-img').on({
  mouseenter:function(e){
    if($(e.target).is('img')){
    $(e.target).attr('current',1);
    modalFoto(e,$(this));

    }
    $(this).find('.cube').css({'animation-play-state':'paused'});
  },
  mouseleave:function(){
    $(this).find('.cube').css({'animation-play-state':'running'});
  }
});
  $('.lock').click(function(event){
    if(imgSrc.imgSrc){
      var html='<div class="modal-foto"><div class="wrap-foto"><div class="foto"><div class="slide-nav"><span  class="prev"></span><span class="next"></span></div><img src="'+imgSrc.imgSrc+'" ></div>  <span class="close"></span>  </div>  </div>';
      $('body').append(html);
      imgSrc.imgSrc='';
    }
  })
$(".single_images_list").click(function (e) {
  if($(e.target).is('img')){
  $(e.target).attr('current',1);
    modalFoto(e,$(this));
    if(imgSrc.imgSrc){
      var html='<div class="modal-foto"><div class="wrap-foto"><div class="foto"><div class="slide-nav"><span  class="prev"></span><span class="next"></span></div><img src="'+imgSrc.imgSrc+'" ></div>  <span class="close"></span>  </div>  </div>';
      $('body').append(html);
      imgSrc.imgSrc='';
    }
}
});
$('.check').click(function(e){
    var img=$(this).parent().siblings('.catalog_item_img').children('img');
    if(img.length){
      var html='<div class="modal-foto"><div class="wrap-foto"><div class="foto"><img src="'+img.attr('src')+'" ></div>  <span class="close"></span>  </div>  </div>';
      $('body').append(html);
    }
})
$(document).on('click','.modal-foto',function (event) {
  var modalFoto=$('.modal-foto .foto img');
  if($(event.target).hasClass('prev')){
    modalCurrentImg==0? modalCurrentImg=3:modalCurrentImg--;
    modalFoto.fadeOut(500,function(){
      modalFoto.attr('src',$(imgSrc.collectionImg[modalCurrentImg]).attr('src')).fadeIn(500);
    })
  }
  if($(event.target).hasClass('next')){
    modalCurrentImg==3? modalCurrentImg=0:modalCurrentImg++;
    modalFoto.fadeOut(500,function(){
      modalFoto.attr('src',$(imgSrc.collectionImg[modalCurrentImg]).attr('src')).fadeIn(500);
    })
  }

})
$(document).on('click','.modal-foto .close',function (event) {
    $('.modal-foto').css({transform:'scale(0)'});
    setTimeout(function () {
          $('.modal-foto').remove();
    },1000)
})
$(document).on('click','.modal-admin .close',function (event) {
  $('.modal-admin').css('display','none');
})
$('.modal-submit').click(function(e){
  e.preventDefault();
  $('.modal-admin').css('display','flex');
})

  $('.account').mouseover(function(){
    $('.account .arrow').css({transform:'rotateX(180deg)'})
    $(this).children('ul').stop(true, false).slideDown();
  })
  $('.account').mouseleave(function(){
    $('.account .arrow').css({transform:'rotateX(0deg)'})
    $(this).children('ul').slideUp();
  })
  $('.acount-list li').click(function (event) {
    var id=$(this).attr('data-block');
    var selector_id='#'+id;
    event.preventDefault();
      $(this).siblings('.current-acount-menu').removeClass('current-acount-menu');
      $(this).addClass('current-acount-menu');
      $(selector_id).siblings(":not(:hidden)").fadeOut(200,function(){
        switch (id) {
          case 'acount-contact':
            $(selector_id).fadeIn(500);
            break;
            case 'reviews':
            $(selector_id).fadeIn(500);
              break;
              case 'acount-order':
              $(selector_id).fadeIn(500);
                break;
                case 'acount-password':
                $(selector_id).fadeIn(500);
                  break;
          default:

        }
      })
  })
  $('#admin li').click(function () {
    var admin=  $(this).children('.admin-content');
     $(this).siblings().children('a').removeClass('admin-active');
     $(this).children('a').addClass('admin-active');
     $(this).siblings().find('.admin-content:not(:hidden)').slideUp(400,function(){
      admin.slideDown(500);
    });
  })
  $('.modal-admin').click(function(e){
    var targetElem= $(e.target).closest('.input-prepend');
    var placeholder=$(e.target).attr('placeholder');
       $(e.target).siblings().filter('span').css('color','green');
       $(e.target).attr('placeholder','');
    if(targetElem.length &&  placeholder){
       targetElem.siblings('label').append('<span style="display:none;">'+placeholder+'</span>');
       targetElem.siblings('label').children().fadeIn();
    }
  })
  $('.input-prepend').on('blur','input , textarea',function (e) {
      $(this).siblings('span').css('color','black');
      if(!$(this).val()){
        var span=$(this).parent().parent().find('span');
        var placeholder=$(this).parent().parent().find('span').first();
        $(this).attr('placeholder',placeholder.text());
        placeholder.remove();
      }
  })
  $('.filter-checkbox').click(function(){
    var span=$(this).children();
    var value=span.last().text();
    var input=$(this).siblings('input');
    if(span.first().hasClass('checked')){
     input.attr('checked',false);
   }else {
      input.attr('checked',true);
   }
    input.val(value);
    span.first().toggleClass('checked')
  })
  $('.filter input[type="submit"]').click(function(e){
    e.preventDefault();
    console.log(111);
  })

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

  var currentSlideCube=1;
function animateSlideCube() {
    var productTovar=$('#fashion .product-tovar');
    var slide=arguments[0] ? arguments[0]  : currentSlideCube ;
    var rotate=slide*(-90);
    productTovar.siblings('.active-tovar').removeClass('active-tovar');
    $(productTovar[slide]).addClass('active-tovar');
    $('.cube-slide').stop(1, 0).animate(
      {
        'myTransform':rotate
      },
      {
        start:function(){
          $(this).children('.hide').removeClass('hide');
          $(this).children().fadeIn(300);
        },
        step:function(now,fx){
          var myTransform=$(this).attr('myTransform') || 0;
          if(rotate < myTransform ){
            if(now <=(rotate+10)){
              $(this).children(':not([slide-number="'+slide+'"])').fadeOut(200);
            }
          }else {
            if(rotate-now<=10){
              $(this).children(':not([slide-number="'+slide+'"])').fadeOut(200);
            }
          }
          $(this).css("transform","rotateY("+now+"deg)");
        },
        complete:function(){
          $(this).attr('myTransform',rotate);
        },
        duration:2000
      }, 'linear'
    );
    currentSlideCube==3 ? currentSlideCube=0 : currentSlideCube++;
  }
var autoCube= new Interval(animateSlideCube,3000);
  autoCube.start();
$('.product-tovar').click(function(){
  if(autoCube.isRunning()){
    ($(this).index()==3) ? currentSlideCube=-1 : currentSlideCube=$(this).index();
    autoCube.stop();
    setTimeout(function(){
      autoCube.start();
    },3000);
  }
      animateSlideCube($(this).index());

})

$('.products-slider').on({
  mouseenter:function(){
    if(autoCube.isRunning()){
      autoCube.stop();
    }
  },
  mouseleave:function(){
    if(!autoCube.isRunning()){
      autoCube.start();
    }
  }
});

$(".description_btn").click(function () {
    $(".reviews").slideUp(300,function () {
        $(".single_description").slideDown(300);
    });
    if ($(this).hasClass("active")) {

    } else {
        $(this).addClass("active");
        $(".reviews_btn").removeClass("active");
    }
});
$(".reviews_btn").click(function () {
    $(".single_description").slideUp(300,function () {
        $(".reviews").slideDown(300);
    });
    if ($(this).hasClass("active")) {

    } else {
        $(this).addClass("active");
        $(".description_btn").removeClass("active");
    }
});
var r = Math.random();
var rand = Math.floor(r * 4 + 1);
$(".single_img:nth-child("+ rand +")").css({"max-width":"350px"});
$(".single_img").hover(
    function () {
        $(".single_img").css({"max-width":"60px"});
        $(this).css({"max-width":"350px"});
    },
    function (even) {
        var e = even.target;
        $(".single_img").css({"max-width":"60px"});
        $(e).parent("li").css({"max-width":"350px"})
    }
)

$('.comment_block .reply').click(function(e){
  e.preventDefault();
  var currentCom=$(this).parents('.comment_block');
  var form=$('.comment_textarea');
  $(".commentlist .coment-reviews-form").slideUp(500,function(){$(this).remove()});
  form.fadeOut(500);
  form.find('[name="parent_id"]').val(currentCom[0].id);
  currentCom.append(form.find('.coment-reviews-form')[0].outerHTML);
  currentCom.find('.coment-reviews-form').slideDown(500);
})
  $('.comment_block').on('submit','form',function(e){
    e.preventDefault();
    var text=$(this).children('textarea').val();
    var currentCom=$(this).parents('.comment_block');
    var form=$('.comment_textarea');
    var button= $(this).children('.send-comment');
    if(text.length>2){
      $('body').append('<div class="modal-comment"> <p>ok</p></div>');
    }else {
      $('body').append('<div class="modal-comment"> <p>error</p></div>');
    }
    $(this).parent().slideUp(500,function(){$(this).remove()});
    form.show();
    setTimeout(function(){
      $(".modal-comment").hide(500);
    },3000)
  })

      $(".star").hover(
          function () {
              var ind = $(this).index() + 1;
              var wid = $(this).width();
              var hoverWidth = ind * wid;
              $(this).parent().siblings(".stars_bg3").css({"width":hoverWidth + 'px'});
          },
          function () {
              $(".stars_bg3").css({"width":"0"})
          }
      )

      var filter = 1;
      $(".filter_btn").click(function () {

          if(filter == 1) {
              $("aside").stop().slideDown(300);
              $(".filters_underline").css({"width":"105%"});
              $(".filter_burger").css({"transform":"rotate(-270deg)","top":"-5px"});
              $("#burger_item1").css({"width":"13px","transform":"rotate(21deg)","top":"7px"});
              $("#burger_item2").css({"width":"22px"});
              $("#burger_item3").css({"width":"13px","transform":"rotate(-21deg)","top":"11px"});
              filter = 2;
          } else {
              $("aside").stop().slideUp(300);
              $(".filters_underline").css({"width":"0%"});
              $(".filter_burger").css({"transform":"rotate(0)","top":"0"})
              $("#burger_item1").css({"width":"30px","transform":"rotate(0)","top":"3px"});
              $("#burger_item2").css({"width":"30px"});
              $("#burger_item3").css({"width":"30px","transform":"rotate(0deg)","top":"15px"});
              filter = 1;
          }
      })

      var test = new cartPrices().run();

      $(".number").keyup(
          function (e) {
              test.checkVal(e,this);
      });

      $(".minus").click(function (e) {
          test.clicks(e,this,0);
      });

      $(".plus").click(function (e) {
          test.clicks(e,this,1);
      });


     function cartPrices() {
          this.totalSum = 0;
          this.currentVal = 0;
          this.run = function () {
            if( !$(".cart_item_sum").length){
              return ;
            }
              var cartItem = $(".cart_item");
              var cartLen = $(".cart_item").length;
              for(var i = 0; i < cartLen; i++) {
                  this.addSum($(cartItem[i]));
              }
              this.allSum();
              return this;
          };

          this.clicks = function (event,that,check) {
              var target = $(event.target).closest('.cart_item');
              var minus = $(target).find(".minus");
              var value = $(target).find("form input");
              if (check) {
                  if(value.val() < 1000) {
                              value.val(+value.val() +  1);
                          }
              } else {
                  if(value.val() > 1) {
                      value.val(value.val() - 1)
                  }
              }
              if(value.val() == 1) {
                  minus.css({"color":"#999","cursor":"default"});
              } else {
                  minus.css({"color":"#000","cursor":"pointer"});
              }
              this.addSum(target);
              this.allSum();
          };

          this.checkVal = function (event,that) {
              if (!$(that).val().match(/\D+/) && !$(that).val().match(/[\S]{4}/)) {
                  var target = $(event.target).closest('.cart_item');
                  this.currentVal = $(that).val();
                  this.addSum(target);
                  this.allSum();
              } else {
                  $(that).val(this.currentVal);
              }
          };

          this.allSum = function () {
              var all_sum = $('.all_sum');
                  var priceSum = 0;
                  var single_price = $('.cart_item_sum p');
                  for (var i = 0; i < single_price.length; i++) {
                      var priceItem = $(single_price[i]).text().match(/[\d+\s?]+/).toString();
                      priceSum +=parseInt(priceItem.match(/\d+/g).join(""));
                  }
                  this.reversePrice(priceSum.toString());
                  all_sum[0].innerHTML = this.totalSum + " <span> грн </span>";
          };

          this.reversePrice = function (countStr) {
              var char=1;
              var str='';
              if(countStr.length>3){
                  for (var i=countStr.length-1; i>=0;i-- ) {
                      str+=countStr[i];
                      if(char==3){
                          str+=' ';
                          char=0;
                      }
                      char++;
                      this.totalSum = str.split('').reverse().join('');
                  }
              } else {
                  this.totalSum = countStr;
              }
          };

          this.addSum = function (target) {
              var price = $(target).find(".cart_item_price p").text().match(/[\d+\s?]+/).toString();
              var sum = $(target).find(".cart_item_sum p");
              var count = parseInt(price.match(/\d+/g).join('')) * $(target).find("form .number").val();
              var countStr = count.toString();

              this.reversePrice(countStr);
              $(sum)[0].innerHTML = this.totalSum + " <span> грн </span>";
          }
      }

      $('.wish_btns .fa-heart').click(function(){

        $(this).closest('.cart_item').fadeOut(1000);
      })
  })
