function ajax(url,data) {

   return JSON.parse( $.ajax({
        url: url,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        datatype: 'JSON',
       async: false,
            data: {data:data}

    }).responseText).success;


}


$('.single_content input[type=submit]').click(function (e) {

    e.preventDefault();
    var url=$(e.target).parent().attr('action');
    var data=$(e.target).siblings('input.number').val();
    if(ajax(url,data)){
        var count= $('.count-list').first();
        count.text(parseInt(count.text())+1);
        $(e.target).siblings('input.number').val(data);
        $('body').prepend('<div class="message"><p>Товар в корзине</p></div>');
        setTimeout(function () {
            $('.message').remove();
        },3000)
    }
})

$('.delete_item_btn').click(function (e) {
    e.preventDefault();
    var url=$(this).attr('action');

    var data='';
   if(ajax(url,data)){
       window.location.href = $('meta[name="site"]').attr('content');
   }

})

$('.add_to_wish').click(function (e) {
    e.preventDefault();
    var url=$(this).attr('href');
    if(ajax(url,'')){
        var count= $('.count-list').last();
        count.text(parseInt(count.text())+1);
        $('body').prepend('<div class="message"><p>Товар в избраном</p></div>');
        setTimeout(function () {
            $('.message').remove();
        },3000)
    }
})

$('.wish_btns .fa-heart').click(function (e) {
    e.preventDefault();
    var url=$(this).attr('href');
    if(ajax(url,'')){
        var count= $('.count-list').last();
        count.text(parseInt(count.text())-1);
    }
});

$('.wish_btns .fa-shopping-cart').click(function (e) {
    e.preventDefault();
    var url=$(this).attr('href');
    if(ajax(url,'')){
        var count= $('.count-list').first();
        count.text(parseInt(count.text())+1);
        $('body').prepend('<div class="message"><p>Товар в корзине</p></div>');
        setTimeout(function () {
            $('.message').remove();
        },3000)
    }
})

$('.filter input[type="submit"], .filter-checkbox').click(function(e){

    e.preventDefault();
    $('.filter_count').remove();
    var url=$(e.target).closest('form').attr('action');
    var arr=[];
    var type=false;
    var that=$(this);
    arr['id']=[];
    arr['min']=0;
    arr['max']=0;

        if($(e.target).closest('.filter-checkbox').length){
                var span=$(e.target).closest('.filter-checkbox').children();
                var value=span.last().text();
                var input=$(e.target).closest('.filter-checkbox').siblings('input');
                if(span.first().hasClass('checked')){
                    input.attr('checked',false);
                }else {
                    input.attr('checked',true);
                }
                input.val(value);
                span.first().toggleClass('checked')
            type=2;
        }else {
            type=1;
        }
    var data = $(e.target).closest('form').serializeArray();
   $.each( data,function ($index,$value) {
        if( $value.value != '0' && $value.name >0){
            arr['id'].push($value.name)
        }
       if($value.name == 'max'){
           arr['max']=$value.value;
       }
       if($value.name == 'min'){
           arr['min']=$value.value;
       }
    })

    $.ajax({
        url: url,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        datatype: 'JSON',
        async: false,
        data: {
            id: JSON.stringify(arr['id']),
            min: arr['min'],
            max: arr['max'],
            type: type
        },
        success:function (html) {
            if (type==1){
                $('.catalog_body_wrap .catalog_content').children().remove();
                $('.catalog_content .pagination-catalog').remove();
                $('.catalog_body_wrap .catalog_content').html(html);

                $("html, body").stop().animate({scrollTop:0}, 1000, 'swing');
            } else {
                that.closest('.filter>li').append(`<span class="filter_count">${html} товаров</span>`)
            }

        }
    })
})


$(".search").keyup(function () {
    var str=$(this).val();
    var url=$(this).closest('form').attr('action');
    var list=$(this).parent().siblings(".search_list").children('ol');
    list.children().remove();
    if (str.match(/[\S]{3}/gi)) {
        var data=ajax(url,str);

        list.append(data).css({"display":"block"});
    } else {
        $(".search_list ol").css({"display":"none"});
    }
});
$('.reviews').on('click','.comment_footer .reply',function(e){
    e.preventDefault();
    var currentCom=$(this).parents('.comment_block');
    var form=$('.comment_textarea');
    $(".commentlist .coment-reviews-form").slideUp(500,function(){$(this).remove()});
    form.fadeOut(500);
    form.find('[name="parent_id"]').val(currentCom[0].id);
    currentCom.append(form.find('.coment-reviews-form')[0].outerHTML);
    currentCom.find('.coment-reviews-form').slideDown(500);
})


$('.reviews').on('submit','form',function(e){
    e.preventDefault();
    var url=$(this).closest('form').attr('action');
    var commentParent=$(e.target).closest('li');
    var that=$(this);
    var text=$(this).children('textarea').val();
    var data=JSON.stringify($(this).serializeArray());
    if(text.length>1){
        $('body').prepend('<div class="message"><p>Комментарий добавлен</p></div>');

        $.ajax({
            url: url,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            datatype: 'JSON',
            data: {
              data: data
            },
            success:function (content) {
                if(content.success){
                    $('.message').remove();
                    if(content.parent_id>0){
                        commentParent.append('<ul class="children">'+content.success+'</ul>');
                        that.parent().slideUp(500,function(){$(this).remove()});
                        $('.comment_textarea').find('[name="parent_id"]').val(0);
                    }else {
                        $('.reviews .commentlist').last().after('<ul class="commentlist">'+content.success+'</ul>')
                    }

                    $('html, body').animate({
                        scrollTop: $('#'+content.id).offset().top-200
                    }, 2000);

                }else {
                    $('body').prepend('<div class="message"><p>Комментарий неможет быть пустым</p></div>');
                }
            }
        })

    }else {
        $('body').prepend('<div class="message"><p>Комментарий неможет быть пустым</p></div>');
    }
    setTimeout(function () {
        $('.message').remove();
    },2000)

    $('.comment_textarea').show();
})

$('body ').on('click','.clickLike',function (e) {
    var count= $(this).index();
    var url=$(this).parent().attr('href');

    var data=ajax(url,count);

    $(this).closest('.stars_block').children('.stars_bg').css({width: data.width*20+'%'});
})

$('body').on('click','.clickLikeComment',function (e) {
    var url=$(this).attr('href');
    var data=0;
    if ($(e.target).closest('.like').length){

        $(this).find('.dislike').css({
            border: "none"
        });
        $(this).find('.like').css({
            border: "1px solid black",
            'border-radius': '5px'
        });
        data=1;
    }
    if ($(e.target).closest('.dislike').length){
        $(this).find('.like').css({
            border: "none"
        });
        $(this).find('.dislike').css({
            border: "1px solid black",
            'border-radius': '5px'
        });
        data=-1;
    }
     var data=ajax(url,data);

    $(this).find('.sum').text(' '+data.count[0].like);
    $(this).find('.sum2').text(' '+-data.count[0].dislike);
})

$('body ').on('click','#acount-password input[type=submit]',function (e) {
    e.preventDefault();
    var url=$(this).parent().attr('action');
    var data=JSON.stringify($(this).parent().serializeArray());

    var result=ajax(url,data);
   if(!result){
       $('body').prepend(`<div class="message"><p>Пароль должен быть больше 6 символов</p></div>`);
   }else {
       $('body').prepend(`<div class="message"><p>Пароль изменен</p></div>`);
       $(this).siblings('.acount-input').children('input').val('');
   }

    setTimeout(function () {
        $('.message').remove();
    },2000)
})

$('#acount-avatar input[type=submit]').click(function (e) {
    e.preventDefault();
    var url=$(this).parent().attr('action');
    var file=$('#acount-avatar input[type=file]')[0].files;
    var data = new FormData();

    $.each(file, function(key, value)
    {
        data.append('image', value);
    });
   href=  JSON.parse($.ajax({
        url: url,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        cache: false,
        contentType: false,
        processData: false,
       async:false,
        type: 'POST',
        data: data
    }).responseText).href;

$('.acount-img img').attr('src',href);

})