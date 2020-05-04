(function($, undefined){
    $(function(){
        // Начало магической строчечки


/* Блок Меню */

//Линия бегущая по ховеру справа
    $('.menu-item').hover(function() {

        let y = this.getBoundingClientRect().top;

        $('.line-right').css({"top": y - 70});

    }, function() {
        $('.line-right').css({"top": "-100px"});
    });

/* ресайз для меню
   функция которая следит за изменениями экрана */
    function menuResize () {

        if ($(window).width() <= 500) {
            $('.nav-left').css({"left":"-52px"});
            $('.main-wrapper').css({"margin-left":"0!important"})
        };

        if ($(window).width() > 500) {
            $('.nav-left').css({"left":"0" , "width":"52px"})
            $('.main-wrapper').css({"margin-left":"52px"})
        };

        if ($(window).width() > 1200) {
            $('.nav-left').css({"left":"0" , "width":"180px"})
            $('.main-wrapper').css({"margin-left":"180px"})
        };

    };

// вызов функции изменения экрана
    window.addEventListener("resize", menuResize, false);

// открытие меню

//функция смены состояния стрелки
    function checkArrow() {
        if ($('.nav-left').hasClass('active-menu')) {
            $('.open-menu').css({'transform': 'rotateY(180deg)','color': '#209e91'});
        } else {
            $('.open-menu').css({'transform': 'rotateY(0deg)','color': '#fff'});
        }
    }

// Функция клик по кнопке открыть левое меню
    $('.open-menu').on('click', function() {

        if ($(window).width() <= 500) {
            if($('.nav-left').hasClass('active-menu')){
                $('.nav-left').removeClass('active-menu').css({"left":"-52px"});
            } else {
                $('.nav-left').addClass('active-menu').css({"left":"0"});
            }
        };

        if ($(window).width() > 500) {
            if($('.nav-left').hasClass('active-menu')){
                $('.nav-left').removeClass('active-menu').css({"width":"52px"});
                $('.main-wrapper').removeClass('main-wrapper_active-menu').css({"margin-left":"52px"});
            } else {
                $('.nav-left').addClass('active-menu').css({"width":"180px"});
                $('.main-wrapper').addClass('main-wrapper_active-menu');
            }
        };

        //вызов функции изменения стрелки
            checkArrow();

    });

//загрузка на разных разрешениях
    if ($(window).width() >= 1200) {
        $('.nav-left').addClass('active-menu').css({"width":"180px"});
        $('.main-wrapper').addClass('main-wrapper_active-menu');
    };

//вызов функции изменения стрелки при загрузке страницы
    checkArrow();


/* End Блок Меню */

/* preloader */
$('.open-loader').on('click', function () {
   $('.preloader-wrap').fadeToggle();
});
/* End preloader */

/* Зум изображения */
let flag = 1;
$('.img-zoom').on('click', function () {
    let t = $(this);

    if( flag == 2) {
        t.removeClass('zoomed');
        setTimeout(function(){
            t.removeClass('p-f');
        }, 250);

        flag--;
    } else if( flag == 1) {
        t.addClass('p-f zoomed');

        flag++;
    }
});

function nonActive () {
    $('.img-zoom').removeClass('zoomed');
    setTimeout(function(){
        $('.img-zoom').removeClass('p-f');
    }, 250);
}

$('.main').on('scroll', function () {
    nonActive();
});
/* End Зум изображения */

//инициализация компонентов Material
/* модалочка */
$(document).ready(function(){
    $('.modal').modal();
})
/* End модалочка */

/* Select */
$(document).ready(function(){
    $('select').formSelect();
});
/* End Select */

/* Collaps */
$(document).ready(function(){
    $('.collapsible').collapsible();
});
/* End Collaps */

$(document).ready(function(){
    $('.scrollspy').scrollSpy();
});


// Конец магической строчечки
    });
})(jQuery);