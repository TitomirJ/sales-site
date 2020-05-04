(function($, undefined){
    $(function(){


        /**
         * меняет цвет блока с чекбоксом в зависимости от Вкл/Выкл
         * @param {node} elem
         * @param {bool} bool
         */
        function clons_changeColorBlock(elem,bool){
            if(bool){
                $('#wrap_'+$(elem).attr('value')).addClass('bg-danger');
            }else{
                $('#wrap_'+$(elem).attr('value')).removeClass('bg-danger');
            }
        }


        /**
         * изменение режима чекбоксов всех дубликатов компании
         * @param {node} elements
         * @param {bool} bool
         */
        function clons_changeModCheckboxs(elements,bool){

            $(elements).each(function(){
                $(this).prop('checked',bool);

                if(bool){
                    clons_changeColorBlock(this,true);
                }else{
                    clons_changeColorBlock(this,false);
                }
            })
        }



        /**
         * управление кнопками Выбрать все/Отменить все
         *
         */
        $('#all_select_clons .btn').on('click', function(e){

            let els = $('#clons_for_del .clons_item input:checkbox');

            if($(this).attr('name') == 'select_clons'){

                clons_changeModCheckboxs(els,true);

            }else if($(this).attr('name') == 'cancel_clons'){

                clons_changeModCheckboxs(els,false);

            }


        })


        /**
         * ручное включение-выключение чекбокса
         */
        $('#clons_for_del input:checkbox').each(function(){

            $(this).on('click',function(e){

                if( $(this).prop('checked') ){

                   clons_changeColorBlock(this,true);
                }else{

                    $(this).prop('checked', false);

                    clons_changeColorBlock(this,false);
                }

            })

        })



        /**
         * отправка формы после проверки на недопустимость выбора всех чекбоксов
         * и в отдельности всех чекбоксов одного товара
         */
        $('#btn_form_clons-del').on('click',function(e){
            e.preventDefault();
            let flag = true;

            // получаем все блоки с дублями и оригиналом
            let arr_blocks = $('.main_block_clon');

            $(arr_blocks).each(function(){

                //получает все чекбоксы в блоке товара
                let all_check = $('#'+$(this).attr('id') + ' input:checkbox');
                //получает все включенные чекбоксы товара
                let on_check = $('#'+$(this).attr('id') + ' input:checked');

                // проверка на недопустимость включения всех чекбоксов товара
                // нельзя удалить все (оригинал +дубли)
                if(all_check.length == on_check.length){

                    let node = $('#'+$(this).attr('id'));
                    //координаты для прокрутки страницы
                    let xy = node.offset();

                    //подсветка блока,прокрутка страницы,отключение чекбоксов товара...
                    $(node).addClass('bg-danger');

                    $('html').animate({
                        scrollTop:xy.top
                    },500);

                    $(node).on('click',function(e){
                        $(node).removeClass('bg-danger');

                    })

                    $(on_check).each(function(){
                        $(this).prop('checked',false);
                        clons_changeColorBlock(this,false);
                    })
                    flag = false;

                }else{


                }
            })

            //отправить в контроллер что бы удалить выбранные
            if(flag){

                let form = $('#clons_for_del');
            //console.log(form.serialize() ) ;

            //id для того чтобы после удаления перенаправить на другую страницу
            let idclon = $('#company_id_clon').val();
            //console.log(idclon);

            //собственно полетели в контроллер выбранные клоны
            $.ajax({
                type:'POST',
                url: '/admin/company/all_delclons',
                data: form.serialize(),

                success:function(result){

                    if(Array.isArray(result)){

                        alert('удалено '+ result.length);

                        $('#overlay-loader').show();

                        var url = "https://bigsales.pro/admin/company/"+idclon;
                        $(location).attr('href',url);

                    }else{

                        alert(result);
                    }


                }
            })



            }


        })











    });
})(jQuery);