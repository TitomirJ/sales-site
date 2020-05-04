(function($, undefined){
    $(function(){

        $('.admin-moder-com-button').on('click', function (e) {
            e.preventDefault();
            var inProgress = false;
            var url = $(this).attr('href');
            var type = $(this).data('type');
            var warning = $(this).data('warning');
            $('.moder-com-modal-body').empty();
            $('.ajax-modal-title').empty();
            //$('#com-admin-modal').modal('show');
            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    data: {
                        type : type,
                        warning : warning
                    },
                    beforeSend: function () {
                        inProgress = true;
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if(data.status == 'success'){
                            $('.ajax-modal-title').html(data.title);
                            $('.moder-com-modal-body').html(data.render);
                            $('#com-admin-modal').modal({
                                keyboard: false,
                                backdrop: 'static'
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
                    }
                });
            }
        });

        $('#com-admin-modal').on('click', '.submit-moder-com', function (e) {
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
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if(data.status == 'success'){
                            if(data.action == 'ignor'){
                                $('.block-war-class-'+data.warningId).remove();
                            }else if(data.action == 'block'){
                                $('.block-com-class-'+data.companyId).remove();
                            }
                            $.toaster({
                                message: data.msg,
                                title: '',
                                priority: 'success',
                                settings: {'timeout': 3000}
                            });
                            $('#com-admin-modal').modal('hide');
                        }
                    },
                    error: function (data) {
                        $.toaster({
                            message: "Ошибка сервера!",
                            title: 'Sorry!',
                            priority: 'danger',
                            settings: {'timeout': 3000}
                        });
                        $('#com-admin-modal').modal('hide');
                    }
                });
            }
        });






    });
})(jQuery);

