(function($, undefined){
    $(function(){

         $('body').on('click', '.pagination a', function (e) {
             e.preventDefault();
             var url = $(this).attr('href');
             var type = $(this).parents(".pagination-wrapper").data('type');

             loadingTypeAdminUserPage(url, type);
             //console.log(type)
         });

         function loadingTypeAdminUserPage(url, type){
             var inProgress = false;

             if (!inProgress) {
                 $.ajax({
                     async: true,
                     method: 'get',
                     url: url,
                     data: {
                         type : type
                     },
                     beforeSend: function () {
                         inProgress = true;
                         $('#overlay-loader').show();
                     },
                     success: function (data) {
                         var data = JSON.parse(data);
                         if(data.status == 'success'){
                            $('#'+type+'-place').html(data.render);

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
         }



         $('.table-prom-cat').on('click', '.search-our-subcat', function (e) {
            e.preventDefault();

            var url = $(this).attr('href');
            var children = $(this).children('.toggle-siner');

            children.toggleClass('fa-spinner fa-spin fa-plus-square-o');

            $('.ajax-modal-body').empty();
            $('.ajax-modal-title').empty();
            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    beforeSend: function () {
                        inProgress = true;
                        $('#overlay-loader').show();
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if(data.status == 'success'){
                            $('.ajax-modal-title').html(data.title);
                            $('.ajax-modal-body').html(data.render);
                            $('#prom-cat-modal').modal({
                                keyboard: false,
                                backdrop: 'static'
                            });
                        }
                        children.toggleClass('fa-spinner fa-spin fa-plus-square-o');
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

        $('#prom-cat-modal').on('click', '.change-prom-cat', function (e) {
            e.preventDefault();

            var inProgress = false;
            var form = $($(this).data('form'));
            var url = form.attr('action');

            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'put',
                    url: url,
                    data: form.serialize(),
                    beforeSend: function () {
                        inProgress = true;
                        $('#overlay-loader').show();
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if(data.status == 'success'){

                            $.toaster({
                                message: data.msg,
                                title: '',
                                priority: 'success',
                                settings: {'timeout': 3000}
                            });
                            $('.item-cat-'+data.catId).html(data.render);
                            $('#prom-cat-modal').modal('hide');
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


        //копирование текста по клику в буфер обмена
        $('.copy-buffer').hover( function (){
            $(this).parent().find('.message-copy').fadeIn(100);
        }, function () {
            $(this).parent().find('.message-copy').fadeOut(100);
        });

        $('.copy-buffer').on('click', function (){
            $(this).siblings().fadeOut(100);
            var text = $(this).text();
            copy(text);
            $(this).append('<div class="message-copied position-absolute border-radius bg-success p-2 text-white w-100 f12" style="display: none;">Скопировано</div>');

            let a = $('table').find('.message-copied');
            a.show('100');

            setTimeout(function(){
                $('.message-copied').fadeOut();
                setTimeout(function(){
                    $('.message-copied').remove();
                }, 500);
            }, 500);
        });

        function copy(str){
            let tmp   = document.createElement('INPUT'),
                focus = document.activeElement;
            tmp.value = str;

            document.body.appendChild(tmp);
            tmp.select();
            document.execCommand('copy');
            document.body.removeChild(tmp);
            focus.focus();
        }

    });
})(jQuery);

