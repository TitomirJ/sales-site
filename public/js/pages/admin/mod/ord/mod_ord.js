(function($, undefined){
    $(function(){

    $('.show-moder-ord').on('click', function (e) {
        e.preventDefault();
        var inProgress = false;
        var url = $(this).attr('href');
        var type = $(this).data('type');
        $('.moder-ord-modal-body').empty();
        $('.ajax-modal-title').empty();
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
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    if(data.status == 'success'){
                        $('.ajax-modal-title').html(data.title);
                        $('.moder-ord-modal-body').html(data.render);
                        $('#moder-ord-modal').modal({
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

