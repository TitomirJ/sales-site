(function($, undefined){
    $(function(){


        $('.table-prom-externals').on('click', '.action-external', function (e) {
            e.preventDefault();
            var inProgress = false;
            var url = $(this).attr('href');
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
                            // $('#prom-external-modal').modal({
                            //     keyboard: false,
                            //     backdrop: 'static'
                            // });
                            $('#prom-external-modal').modal('show');
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

        $('#moder-ord-modal').on('click', '.submit-moder-ord', function (e) {
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

                            $.toaster({
                                message: data.msg,
                                title: '',
                                priority: 'success',
                                settings: {'timeout': 3000}
                            });
                            $('.order-item-'+data.orderId).remove();
                            $('#moder-ord-modal').modal('hide');
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

    });
})(jQuery);

