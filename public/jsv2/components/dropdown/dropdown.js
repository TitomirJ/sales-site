$('.dropdown-btn').on('click', function () {
    // находим кнопку на которую нажали
    let btn = $(this);
    // находим дропдаун
    let d = $(this).siblings(".dropdown");
    // берем высоту элемента на который нажали
    let h = $(this).innerHeight();

    // инициализируем переменные для разных анимаций
    let fr = 'fade_r'; let f = 'fade';

    // анимация для FadeRight
    // появление дропдауна справа
    if ( d.hasClass(fr) ) {
        let hide = 'fadeOutRight';
        let show = 'fadeInRight';

        if(d.hasClass(hide)){
            d.removeClass(hide).addClass(show).css({'visibility':'visible'});
        }
        else if (d.hasClass(show)){
            d.removeClass(show).addClass(hide).css({"top":h,'visibility':'hidden'});
        }
        else d.addClass(show).css({'visibility':'visible'});

        focOut(hide, show);
    }

    // анимация для Fade
    // появление дропдауна сменой прозрачности
    if ( d.hasClass(f) ) {
        let hide = 'fadeOut';
        let show = 'fadeIn';

        if(d.hasClass(hide)){
            d.removeClass(hide).addClass(show).css({'visibility':'visible'});
        }
        else if (d.hasClass(show)){
            d.removeClass(show).addClass(hide).css({"top":h,'visibility':'hidden'});
        }
        else d.addClass(show).css({'visibility':'visible'});

        focOut(hide, show);
    }

    // функция при расфокусировке закрывается
    function focOut(hide, show) {
        if(btn.focusout(function() {
            d.removeClass(show).addClass(hide).css({'visibility':'hidden'});
        }));
    }

    return false
});