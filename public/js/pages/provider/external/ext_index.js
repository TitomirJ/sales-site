(function($, undefined){
    $(function(){


        $('body').on('click', '#open-ext-mod', function (e) {
            e.preventDefault();
            var inProgress = false;
            var url = $(this).data('url');
            var action = $(this).data('action');

            $('.ajax-modal-body').empty();
            $('.ajax-modal-title').empty();


            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    data:{
                        action : action
                    },
                    beforeSend: function () {
                        inProgress = true;
                        $('#overlay-loader').show();
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if(data.status == 'success'){
                            $('.ajax-modal-title').html(data.title);
                            $('.ajax-modal-body').html(data.render);
                            $('#prov-ext-create').modal({
                                keyboard: false,
                                backdrop: 'static'
                            });

                        }
                        $('#overlay-loader').hide();
                    },
                    error: function (data) {
                        $.toaster({
                            message: "Ошибка сервера!",
                            title: 'Sorry!',
                            priority: 'danger',
                            settings: {'timeout': 3000}
                        });
                        $('#overlay-loader').hide();
                    }
                });
            }
        });

        $('#prov-ext-create').on('click', '.create-link-ext', function (e) {
            e.preventDefault();
            var inProgress = false;
            var form = $($(this).data('form'));
            var url = form.attr('action');

            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'post',
                    url: url,
                    data: form.serialize(),
                    beforeSend: function () {
                        inProgress = true;
                        $('#overlay-loader').show();
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        $('#overlay-loader').hide();
                        if(data.status == 'success'){

                            $.toaster({
                                message: data.msg,
                                title: '',
                                priority: 'success',
                                settings: {'timeout': 3000}
                            });

                            $('#prov-ext-create').modal('hide');

                            window.location.reload();

                        }else if(data.status == 'danger'){

                            $.toaster({
                                message: data.msg,
                                title: '',
                                priority: 'danger',
                                settings: {'timeout': 8000}
                            });

                        }
                    },
                    error: function (data) {
                        $.toaster({
                            message: "Ошибка сервера!",
                            title: 'Sorry!',
                            priority: 'danger',
                            settings: {'timeout': 3000}
                        });
                        $('#overlay-loader').hide();
                    }
                });
            }
        });

        /**
 * отправка на сервер формы с загруженным пользователем файлом xml
 * работает для кнопки --загрузить XML--
 */
$('#prov-ext-create').on('click', '.create-link-extxml',function(e){
    e.preventDefault();
    var inProgress = false;
    var form = $($(this).data('form'));
    //console.log(form);
    var url = form.attr('action');
    var formData = new FormData($('#ext-link-formxml')[0]);



    if (!inProgress) {
        $.ajax({
            async: true,
            contentType: false,
            processData: false,
            method: 'post',
            dataType: 'JSON',
            url: url,
            data:formData,
            beforeSend: function () {
                inProgress = true;
                $('#overlay-loader').show();
            },
            success: function (data) {

                //var data = JSON.parse(data);

                $('#overlay-loader').hide();

                if(data.status == 'success'){

                    $.toaster({
                        message: data.msg,
                        title: '',
                        priority: 'success',
                        settings: {'timeout': 5000}
                    });

                    $('#prov-ext-create').modal('hide');

                    window.location.reload();

                }else if(data.status == 'danger'){

                    $.toaster({
                        message: data.msg,
                        title: '',
                        priority: 'danger',
                        settings: {'timeout': 8000}
                    });

                }
            },
            error: function (data) {
                $.toaster({
                    message: "Ошибка сервера!",
                    title: 'Sorry!',
                    priority: 'danger',
                    settings: {'timeout': 3000}
                });
                $('#overlay-loader').hide();
            }
        });
    }
});

		/**
         * управление настройками автообновления
         * выбор режимов. Включение или отключение автообновления
         * февраль2020г.
         */
        $('#autoupdate_btn input:checkbox').on('click',function(e){
            $('#overlay-loader').show();

            let form = $('#autoupdate_btn');
            $.ajax({
                url:'/company/product/autoupdate',
                type:'POST',
                data:form.serialize(),
                success: function(resault){
                    //console.log(resault);
                    $('#overlay-loader').hide();
                    if( resault != '' ){
                        $('#info_btn_autoupdate').removeClass('badge-success').addClass('badge-danger').text('Авто обновление включено');
                        $('#wrap_setting_autoupdate').html(resault);

                    }else{

                             $('#info_btn_autoupdate').removeClass('badge-danger').addClass('badge-success').text('Авто обновление выключено');
                             $('#wrap_setting_autoupdate').html('');

                     }
                }
            });

        })


        /**
         * настройки автообновления
         * выбор что обновлять и что делать с товарами которых нет в файле
         * графическое отображение выбора пользователем подсвечивание настройки
         */
        $('#wrap_setting_autoupdate').on('click','input[type=radio]',function(e){

            let elements = $(this).parent().parent();
            elements = $(elements).attr('id');

            //убирается фон у всех в этом блоке и устанавливается у того лэйбла по которому клик
            $('#'+elements+' label').each(function(){
               $(this).removeClass('badge-warning');
            })
            let parent_lab = $(this).parent();
           $(parent_lab).children('label').addClass('badge-warning');

           //убирается checked у всех в этом блоке и устанавливается у того инпута по которому клик
           $('#'+elements+' input[type=radio]').each(function(){
            $(this).removeAttr('checked');
            })
           $(this).attr('checked','checked');

        })


        $('#wrap_setting_autoupdate').on('click','button',function(e){
            $('#overlay-loader').show();
        })
		
		/**
         * скрытие и показ кнопки для бэкапа
         * автообновления (март2020)
         * (находится в provider-company-external-layouts-_info_apdates_xml.blade.php)
         */
        $('#title_backup').on('click',function(e){
            let el_backup = $('#bbackup');
            if(el_backup.css('display')!='block'){
                $('#title_backup').text('Скрыть кнопку');
            }else{
                $('#title_backup').text('Показать кнопку');
            }
            el_backup.toggle("slow");
            
        })


    });
})(jQuery);