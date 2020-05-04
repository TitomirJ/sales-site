(function($, undefined){
    $(function(){


        $('.table-prom-pro-all').on('click', '.search-our-subcat', function (e) {
            e.preventDefault();
            var inProgress = false;
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
                        $('#overlay-loader').hide();

                        if(data.status == 'success'){

                            $.toaster({
                                message: data.msg,
                                title: '',
                                priority: 'success',
                                settings: {'timeout': 3000}
                            });

                            $('#prom-cat-modal').modal('hide');

                            $('.ajax-modal-body').empty();
                            $('.ajax-modal-title').empty();

                            window.location.reload();
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

    });
})(jQuery);

