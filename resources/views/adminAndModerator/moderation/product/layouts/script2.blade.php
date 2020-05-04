<script>
    $('.op-mod-suc').on('click', function (e) {
        e.preventDefault();
        $('#successModer').modal({
            keyboard: false,
            backdrop: 'static'
        });
    });
    $('.op-mod-war').on('click', function (e) {
        e.preventDefault();
        $('.long-error').removeClass('is-invalid');
        $('#invalidModer').modal({
            keyboard: false,
            backdrop: 'static'
        });
    });
    $('.op-mod-dan').on('click', function (e) {
        e.preventDefault();
        $('.long-error').removeClass('is-invalid');
        $('#blockModer').modal({
            keyboard: false,
            backdrop: 'static'
        });
    });

    $('.admin-mod-button').on('click', function (e) {
        e.preventDefault();
        var idForm = $(this).attr('form');
        var form = $('#'+idForm);
        var url = form.attr('action');
        var method = form.attr('method');
        var inProgress = false;
        if (!inProgress) {
            $.ajax({
                async: true,
                method: method,
                url: url,
                data: form.serialize(),
                beforeSend: function () {
                    inProgress = true;
                    $('#overlay-loader').show();
                },
                success: function (data) {
                    $('#overlay-loader').hide();
                    var data = JSON.parse(data);
                    if(data.status == 'validator'){
                        $('.long-error').removeClass('is-invalid');
                        var objectFails = data.fails;
                        Object.keys(objectFails).map(function(objectKey, index) {
                            var value = objectFails[objectKey];
                            $.toaster({
                                message: value[0],
                                title: 'Sorry!',
                                priority: 'danger',
                                settings: {'timeout': 3000}
                            });
                            if(objectKey == 'long_error'){
                                $('.long-error').addClass('is-invalid');
                            }
                        });
                    }else if(data.status == 'error'){
                        $.toaster({
                            message: data.msg,
                            title: 'Sorry!',
                            priority: 'danger',
                            settings: {'timeout': 3000}
                        });
                    }else if(data.status == 'success'){
                        $.toaster({
                            message: data.msg,
                            title: 'OK!',
                            priority: 'success',
                            settings: {'timeout': 3000}
                        });
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
</script>