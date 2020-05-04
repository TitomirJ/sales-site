(function($, undefined){
    $(function(){
        //ajax-self
        function ajaxSelf(m, u, d, callback) {
            var request = new XMLHttpRequest();
            request.open(m, u, true);
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    let data = JSON.parse(request.responseText);
                    callback(data);
                } else {
                    $.toaster({ message : 'Ошибка сервера!', title : '', priority : 'danger', settings : {'timeout' : 3000} });
                }
            };
            request.onerror = function() {
                $.toaster({ message : 'Ошибка сервера!', title : '', priority : 'danger', settings : {'timeout' : 3000} });
            };
            request.send(d);
        }

        function ajax(options, callback) {
            $.ajax(options).done(function (data) {
                callback(data);
            }).fail(function () {
                $.toaster({ message : 'Ошибка сервера!', title : '', priority : 'danger', settings : {'timeout' : 3000} });
            });
        }
        //ajax-self(end)

        //скрол перетягиванием таблиц
        var clicked = false, base = 0, base_scroll = 0;
        $('.scroll_me').on({
            mousemove: function(e) {
                clicked && function(xAxis) {
                    var _this = $(this);
                    $('.scroll_wrap').scrollLeft( base_scroll + base - xAxis )
                }.call($(this), e.pageX);
            },
            mousedown: function(e) {
                clicked = true;
                base = e.pageX;
                base_scroll = $('.scroll_wrap').scrollLeft()
            },
            mouseup: function(e) {
                clicked = false;
            }
        })
        //end скрол перетягиванием таблиц

        //    test scripts
        $('#bg-image').on('change', function () {
            $('.mark-input-file').text($(this).val());
        });

        //кнопка далее в товарах, переход на следуйщую вкладку после проверки данных
        $('.create-p-next').on('click', function (e) {
          e.preventDefault();
          var a = $(this).attr('data-action');

          if(a == 1) {
            if (chackProductFormStep1()) {
              $('#desc-tab').click();
            }else {
              $('#category-tab').click();
            }
          }else if(a == 2) {
            if (chackProductFormStep2()) {
              $('#category-tab').click();
            }else {
              $('#price-tab').click();
            }
          }else if(a == 3) {
            if (chackProductFormStep3()) {
              $('#price-tab').click();
            }else {
              $('#images-tab').click();
            }
          }

        });



        //event resize window of browser
            //change body class after resize window
            // $( document ).ready(function() {
            //     let win_width = $(window).width();
            //     let win_flag = $("body").hasClass("sidenav-toggled");
            //     // console.log(win_width);
            //     if(win_width >= 987 && !win_flag){
            //         changeBodyClassAfterResizeWindow(false)
            //     }else if(win_width < 987 && win_flag){
            //         changeBodyClassAfterResizeWindow(true)
            //     }
            // });
            //
            // window.onresize = function(e) {
            //     let win_width = $(window).width();
            //     let win_flag = $("body").hasClass("sidenav-toggled");
            //     // console.log(win_width);
            //     if(win_width >= 987 && !win_flag){
            //         changeBodyClassAfterResizeWindow(false)
            //     }else if(win_width < 987 && win_flag){
            //         changeBodyClassAfterResizeWindow(true)
            //     }
            // };
            //
            // function changeBodyClassAfterResizeWindow(flag){
            //     if(flag){
            //         $('body').removeClass('sidenav-toggled');
            //     }else{
            //         $('body').addClass('sidenav-toggled');
            //     }
            // }
            //
        //event resize window of browser(end)
        //overlay loader(on)
        // $('.on-overlay-loader').on('click', function (e) {
        //     $('#overlay-loader').show();
        // });


        //overlay loader(on)(end)

        // Masks for num inputs
            // phone input
            $(".mask-tel").mask("+38 (999) 999-99-99");
            $(".mask-tel-multi").mask("+99 (999) 999-99-99");
            // sale input
            $(".commission-mask").mask("99");
        // Masks for num inputs(end)


            //Open callBack modal
            $('.action-callBack-modal').on('click', function (e) {
                e.preventDefault();
                $('#callBackModal').modal({
                    keyboard: false,
                    backdrop: false,
                    focus: false
                });
            });
        // Ation for modals windows (end)

        //Blog tine mce
        tinymce.init({
            selector: '.mytextarea',
            language: 'ru',
            theme: 'modern',
            height: 300,
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking',
                'save table contextmenu directionality template paste textcolor'
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor'
        });
        //Blog tine mce  (end)

        //кнопка возврата в оглавление (scroll button)
        $(document).ready(function(){
            $(window).on('scroll', function() {
                //console.log(document.documentElement.scrollTop);
                var button =  document.getElementById("scroll-up-button");

                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                    if($('#scroll-up-button').css('display') == 'none'){
                        $('#scroll-up-button').css({'display' : 'block'});
                        $('#scroll-up-button').stop().animate({opacity: 0.7}, 800);
                    }
                } else {
                    if($('#scroll-up-button').css('display') == 'block'){
                        $('#scroll-up-button').stop().animate({opacity: 0}, 800, function () {
                            $('#scroll-up-button').css({'display' : 'none', 'opacity': 0});
                        });
                    }
                }
            });


        });

        $('#scroll-up-button').on('click', function(){
            $('html, body').animate({scrollTop: 0},800);
            return false;
        });

        $('.scroll-base').on('click', function(){
            var item = $(this).attr('myattr');
            var position  = $('.'+item).offset();

            $('html, body').animate({scrollTop: position['top']},800);
            return false;
        });
        //кнопка возврата в оглавление (scroll button)  (end)

        // Модальное окно подтверждения
        $(document).on('click','.confirm-modal', function(e){
            e.preventDefault();

            var action = $(this).attr('href');
            $('.confirm-modal-form').attr('action', action);
            var text = $(this).attr('text');
            $('.confirm-modal-info').text(text);
            $('#confirmModal').modal({
                keyboard: false,
                backdrop: false
            });
        });
        // Модальное окно подтверждения (end)

        //Изменение статуса новости
        $('.blog-checkbox').on('click', function(){
          var formBlog = $(this).parent().parent('.change-status-blog');

            $.ajax({
                method: 'post',
                url: formBlog.attr('action'),
                data: formBlog.serialize(),
                //dataType: "json",
                success: function(data){
                    if(data == 'ok'){
                        $.toaster({ message : "Новость запущена!", title : 'OK!', priority : 'success', settings : {'timeout' : 3000} });
                    }else if(data == 'no'){
                        $.toaster({ message : "Новость отключена!", title : 'ОК!', priority : 'warning', settings : {'timeout' : 3000} });
                    }
                },
                error: function(data){
                    $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                }
            });
        });
        //Изменение статуса новости (end)

        //Изменение статуса отзыва
        $('.review-checkbox').on('click', function(){
            var formBlog = $(this).parent().parent('.change-status-review');

            $.ajax({
                method: 'post',
                url: formBlog.attr('action'),
                data: formBlog.serialize(),
                //dataType: "json",
                success: function(data){
                    if(data == 'ok'){
                        $.toaster({ message : "Отзыв запущен!", title : 'OK!', priority : 'success', settings : {'timeout' : 3000} });
                    }else if(data == 'no'){
                        $.toaster({ message : "Отзыв отключен!", title : 'ОК!', priority : 'warning', settings : {'timeout' : 3000} });
                    }
                },
                error: function(data){
                    $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                }
            });
        });
        //Изменение статуса отзыва (end)

        //Изменение пагинации пользователя
        $('.change-pag-set-user').on('change', function (e) {
            e.preventDefault();
            var formBlog = $(this).parent('form');
            var pag = $(this).val();
            $.ajax({
                async: true,
                method: 'post',
                url: formBlog.attr('action'),
                data: formBlog.serialize(),
                //dataType: "json",
                success: function(data){

                    location.reload();
                },
                error: function(data){
                    $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                }
            });
        });
        //Изменение пагинации пользователя

        //селект2 для селектов
        $(document).ready(function(){
            $('.select-1').select2({
                placeholder: 'Подкатегории не найдены',
              //  theme: "bootstrap4",
            });
            $('.edit-select-input').select2({
                placeholder: 'Значения не найдены',
              //  theme: "bootstrap4",
            });
            $('.select-2').select2({
                placeholder: 'Опции не найдены',
              //  theme: "bootstrap4",
            });
            $('.select-3').select2({
                placeholder: 'Категории не найдены',
              //  theme: "bootstrap4",
            });
            $('.s-sub-opt').select2({
                placeholder: 'Характеристики не найдены',

            });
        });

        //подгрузка опций подкатегории
        var productCommission = 0;
        $(document).ready(function(){
            if(window.location.pathname == '/company/products/create'){
                loadOptionsFromSubcategory()
            }

            productCommission = $('.get-subcat-options-select').find(':selected').data('commission');
        });
        $('.get-subcat-options-select').on('change', function (e) {
            e.preventDefault();
            $('.render-inputs').empty(); //удаление характеристик товара при смене подкатегории
            $('#subcategory-options').empty();
            $('#product-create-subcat-options-spinner').show();
            loadOptionsFromSubcategory();
            productCommission = $('.get-subcat-options-select').find(':selected').data('commission');
            //console.log(productCommission);
        });

        // функция подгрузка опций подкатегории
        function loadOptionsFromSubcategory(){

            var url = $('.get-subcat-options-select').attr('myUrl');
            var subcatId = $('.get-subcat-options-select').val();
            productCommission = $('.get-subcat-options-select').find(':selected').data('commission');
            console.log(productCommission);
            if(subcatId != 'false'){
                $.ajax({
                    method: 'get',
                    url: url,
                    data: { subcategory_id: subcatId},
                    success: function(data){

                        var obj = $.parseJSON(data);
                        var string = '';
                        if(obj.length == 0){
                            string ='';
                            $('#subcategory-options').html(string);
                        }else{
                            for (var i=0; i < obj.length; i++){
                                string +='<option value="'+obj[i]['id']+'">'+obj[i]['name']+'</option>';
                            }
                            $('#subcategory-options').html(string);
                        }
                        $('#product-create-subcat-options-spinner').hide();

                    },
                    error: function(data){
                        $('#product-create-subcat-options-spinner').hide();
                        $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                    }
                });
            }
        }

        //подгрузка параметров опций
        $('.select-subcat-option').on('click', function (e) {
            var url = $('.select-render-inputs').attr('myUrl');
            var parId = $('.select-render-inputs').val();
            var flag = true;

            if((parId == '') || (parId == null) ){
                $.toaster({ message : "Не выбрана опция товара!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
            }else{
                $('.option-item').each(function(indx, element){
                    if($(element).attr('data-option-item') == parId){
                        flag = false;
                    }
                });

                if(flag){
                    $.ajax({
                        method: 'get',
                        url: url,
                        data: { parametr_id: parId},
                        success: function(data){
                            $('#overlay-loader').hide();
                            if(data == 'false'){
                                $.toaster({ message : "Данная опция не доступна!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                            }else{
                                $('.render-inputs').prepend(data);
                            }
                        },
                        error: function(data){
                            $('#overlay-loader').hide();
                            $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                        }
                    });
                }else{
                    $('#overlay-loader').hide();
                    $.toaster({ message : "Такая опция уже добавлена!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                }
            }


        });

        //добавдение своих опций товара
        $('.create-your-self-input').on('click', function (e) {
            e.preventDefault();

            var url = $(this).attr('myUrl');
            var key = $('#your-self-key').val();
            var value = $('#your-self-value').val();

            var flag = true;

            $('.option-item').each(function(indx, element){
                if($(element).attr('data-option') == key){
                    flag = false;
                }
            });

            if(flag){
                if((key == '') || (value=='')){

                    $.toaster({ message : "При создании своей опции оба поля должны быть заполнены!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                    $('#overlay-loader').hide();
                }else{
                    $.ajax({
                        method: 'get',
                        url: url,
                        data: {
                            your_self_key: key,
                            your_self_value: value
                        },
                        success: function(data){

                            if(data == 'false'){
                                $.toaster({ message : "Данная опция не доступна!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                            }else{
                                $('.render-inputs').prepend(data);
                            }
                            $('#overlay-loader').hide();
                        },
                        error: function(data){
                            $('#overlay-loader').hide();
                            $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                        }
                    });
                }
            }else{
                $.toaster({ message : "Такая опция уже есть, для передачи большего количества значений укажите их через запятую!", title : 'Внимание!', priority : 'warning', settings : {'timeout' : 6000} });
                $('#overlay-loader').hide();
            }


        });
        //Проверка заполнения цен на товар
        $('.check-price').on('blur', function(){
            var value = $(this).val();
            if(value === ''){
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
                $.toaster({ message : "Только числовое значение!", title : 'Внимание!', priority : 'danger', settings : {'timeout' : 5000} });
            }else{
                $(this).val(Math.round10(value, -2));
                $(this).removeClass('is-invalid');
                $(this).addClass('is-valid');
            }
        });

        //проверка и валидация формы создания товара
        $('.provider-create-product').on('click', function (e) {
            e.preventDefault();
            if(chackProductFormStep1()){
                $('#desc-tab').click();
            }else if(chackProductFormStep2()){
                $('#category-tab').click();
            }else if(chackProductFormStep3()){
                $('#price-tab').click();
            }else if(chackProductFormStep4()){
                $('#images-tab').click();
            }else{
                $('.form-product').submit();
            }

        });

        //этап 1
        function chackProductFormStep1() {
            var flag1=true;
            var flag2=true;
            var flag3=true;
            var flag4=true;
            var name = $('#name').val();
            var code = $('#code').val();
            var brand = $('#brand').val();
            var desc = $('#product-desc').val();

            $('#name').removeClass('is-invalid');
            if(name.length >500 || name.length < 3){
                $.toaster({ message : "Найменование товара больше 5 символов или меньше 500 сиволов!", title : 'Внимание!', priority : 'danger', settings : {'timeout' : 5000} });
                $('#name').addClass('is-invalid');
                flag1=false;
            }

            $('#brand').removeClass('is-invalid');
            if(brand.length >100 || brand.length <= 1){
                $.toaster({ message : "Найменование бренда больше 1 символа или меньше 100 сиволов!", title : 'Внимание!', priority : 'danger', settings : {'timeout' : 5000} });
                $('#brand').addClass('is-invalid');
                flag3=false;
            }

            $('#product-desc').removeClass('is-invalid');
            if(desc == ''){
                $.toaster({ message : "Описание товара обязательно для заполнения!", title : 'Внимание!', priority : 'danger', settings : {'timeout' : 5000} });
                $('#product-desc').addClass('is-invalid');
                flag4=false;
            }

            $('#code').removeClass('is-invalid');
            if(code.length >30 || code.length < 1){
                $.toaster({ message : "Артикул товара больше 1 символа или меньше 30 сиволов!", title : 'Внимание!', priority : 'danger', settings : {'timeout' : 5000} });
                $('#code').addClass('is-invalid');
                flag2=false;
            }else{
                var url = $('#code').attr('myUrl');
                var productID = $('#code').attr('product-id');
                $.ajax({
                    async: false,
                    method: 'get',
                    url: url,
                    data: {
                        product_code: code,
                        product_id: productID,
                    },
                    success: function(data){
                        if(data == 'false'){
                            $.toaster({ message : "Товар с таким артикулом уже есть в базе данных!", title : 'Внимание!', priority : 'danger', settings : {'timeout' : 5000} });
                            $('#code').addClass('is-invalid');
                            flag2=false;
                        }
                    },
                    error: function(data){}
                });
            }



            if(flag1 && flag2 && flag3 && flag4){
                return false;
            }else{
                return true;
            }
        }

        //этап 2
        function chackProductFormStep2() {
            var flag1=true;
            var flag2=true;

            var subcategory = $('#subcategory').val();

            $('#subcategory').next('.select2').children('.selection').children('.select2-selection').css('border-color', '#ced4da');
            if(subcategory == 'false'){
                $.toaster({ message : "Не выбрана подкатегория товара!", title : 'Внимание!', priority : 'danger', settings : {'timeout' : 5000} })
                $('#subcategory').next('.select2').children('.selection').children('.select2-selection').css('border-color', 'red');
                flag1=false;
            }

            if(flag1 && flag2){
                return false;
            }else{
                return true;
            }

        }

        //этап 3
        function chackProductFormStep3() {
            var flag1=true;


            var price = $('#product-price').val();

            $('.form-price').removeClass('is-invalid');
            if(price == '' || price == null){
                $.toaster({ message : "Не указана цена товара!", title : 'Внимание!', priority : 'danger', settings : {'timeout' : 5000} })
                $('.form-price').addClass('is-invalid');
                flag1=false;
            }

            if(flag1){
                return false;
            }else{
                return true;
            }

        }

        //этап 4
        function chackProductFormStep4() {
            var flag1=true;
            var image = $('#product-gallery').val();

            $('.dropzone').css('border-color', '#0087F7');
            if(image == '' || image == null){
                $.toaster({ message : "Не выбраны изображения товара!", title : 'Внимание!', priority : 'danger', settings : {'timeout' : 5000} });
                $('.dropzone').css('border-color', 'red');
                flag1=false;
            }else{
                var result = image.split(',');
                if(result.length < 1 || result.length > 8){
                    $.toaster({ message : "Количество изображений, должно быть, больше 1 и меньше 8!", title : 'Внимание!', priority : 'danger', settings : {'timeout' : 5000} });
                    $('.dropzone').css('border-color', 'red');
                    flag1=false;
                }else{
                    flag1=true;
                }
            }

            if(flag1){
                return false;
            }else{
                return true;
            }

        }
        //(end) проверка и валидация формы создания товара

        //(end)  создание товара на странице поставщика


        $(document).ready(function() {
            let price = $('#product-price').val();

            if(price != "" &&  productCommission != undefined) {
                countCom(price, productCommission);
            }else{
                $('#komission').html('Не выбрана категория товара!');
            }
        });

        $('#product-price').keyup(function(){
            let price = $('#product-price').val();
            countCom(price, productCommission);
        });

        $('.get-subcat-options-select').on('change', function () {
            let price = $('#product-price').val();
            countCom(price, productCommission);
        });


        function countCom (price , commission) {
            if(price != "" && commission != undefined) {
                let newPrice = (price/100)*productCommission;
                newPrice = newPrice.toString().substr(0,7);//превращает значение в строку и обрезает
                //console.log(newPrice);

                $('#komission').html(Комиссия: ${newPrice} грн);
            }else{
                if(price == "" && commission == undefined) {
                    $('#komission').html('Не выбрана категория и не указана цена товара');
                }else if(price == "") {
                    $('#komission').html('Неуказана цена товара!');
                }else if(commission == undefined) {
                    $('#komission').html('Не выбрана категория товара!');
                }
            }
        }

        //функция замыкание для округления и проверки числовых данных
        (function() {
            /**
             * Корректировка округления десятичных дробей.
             *
             * @param {String}  type  Тип корректировки.
             * @param {Number}  value Число.
             * @param {Integer} exp   Показатель степени (десятичный логарифм основания корректировки).
             * @returns {Number} Скорректированное значение.
             */
            function decimalAdjust(type, value, exp) {
                // Если степень не определена, либо равна нулю...
                if (typeof exp === 'undefined' || +exp === 0) {
                    return Math[type](value);
                }
                value = +value;
                exp = +exp;
                // Если значение не является числом, либо степень не является целым числом...
                if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
                    return NaN;
                }
                // Сдвиг разрядов
                value = value.toString().split('e');
                value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
                // Обратный сдвиг
                value = value.toString().split('e');
                return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
            }

            // Десятичное округление к ближайшему
            if (!Math.round10) {
                Math.round10 = function(value, exp) {
                    return decimalAdjust('round', value, exp);
                };
            }
            // Десятичное округление вниз
            if (!Math.floor10) {
                Math.floor10 = function(value, exp) {
                    return decimalAdjust('floor', value, exp);
                };
            }
            // Десятичное округление вверх
            if (!Math.ceil10) {
                Math.ceil10 = function(value, exp) {
                    return decimalAdjust('ceil', value, exp);
                };
            }
        })();
        //end функция замыкание для округления и проверки числовых данных

		/**
         * проверка чтобы промо цена не была
         * больше цены (апрель2020)
         */
        $('#price_promo').on('blur',function(e){
            let price = $('#product-price').val();
            let promo = $('#price_promo').val();
            if(promo > price){
                $.toaster({ message : "Промо больше цены!", title : 'Внимание!', priority : 'danger', settings : {'timeout' : 5000} });
                $('#price_promo').val(null);
            }
        });

    });
})(jQuery);