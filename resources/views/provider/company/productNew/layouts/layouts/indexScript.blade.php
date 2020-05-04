<script>
    $('body').on('click', '.pagination li a', function (e) {
        e.preventDefault();
        var inProgress = false;
        var url = $(this).attr('href');
        var type = $(this).parent().parent().parent('.container-fluid').attr('type');

        if(!inProgress){
            $.ajax({
                async: true,
                method: 'get',
                url: url,
                beforeSend: function() {
                    inProgress = true;
                    $('#overlay-loader').show();
                },
                success: function(data){
                    if(type == 1){
                        $('#table-all-product').empty();
                        $('#table-all-product').html(data);
                    }else if(type == 3){
                        $('#table-not-avil-product').empty();
                        $('#table-not-avil-product').html(data);
                    }else if(type == 4){
                        $('#table-deleted-product').empty();
                        $('#table-deleted-product').html(data);
                    }
                    $('#overlay-loader').hide();
                },
                error: function(data){
                    $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                    $('#overlay-loader').hide();
                }
            });
        }
    });

    var modalConfirm = function(callback){
        var object = null;
        $(".confirm-modal-new").on("click", function(e){
            e.preventDefault();
            $("#confirm-modal-block").modal('show');
            object = $(this).data('form');
        });

        $("#modal-btn-yes").on("click", function(){
            callback([true, object]);
            $("#confirm-modal-block").modal('hide');

        });

        $("#modal-btn-no").on("click", function(){
            callback([false, object]);
            $("#confirm-modal-block").modal('hide');

        });
    };

    modalConfirm(function(confirm){
        if(confirm[0]){
            submitChengeAvailProduct(confirm[1]);
            //$('.'+confirm[1]).submit();
        }
    });



    function submitChengeAvailProduct(object){

        var formBlog = $('.'+object);
        var action = formBlog.attr('action');
        var url = formBlog.data('url');
        var obj = formBlog.parents('.prod-tr-string');
        var inProgress = false;
        if(!inProgress) {
            $.ajax({
                async: true,
                method: 'post',
                url: formBlog.attr('action'),
                data: formBlog.serialize(),
                beforeSend: function () {
                    inProgress = true;
                    $('#overlay-loader').show();
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.status == 'ok') {
                        $('#status-table-product-'+data.id).empty();
                        $('#status-table-product-'+data.id).html(data.render);
                        $.toaster({
                            message: "Статус товара изменен на: \'В наличии\'!",
                            title: 'OK!',
                            priority: 'success',
                            settings: {'timeout': 3000}
                        });
                    } else if (data.status == 'no') {
                        $('#status-table-product-'+data.id).empty();
                        $('#status-table-product-'+data.id).html(data.render);
                        $.toaster({
                            message: "Статус товара изменен на: \'Не в наличии\'!",
                            title: 'ОК!',
                            priority: 'warning',
                            settings: {'timeout': 3000}
                        });
                    }

                    if (action == 'reload-no-avail') {
                        reloadAllProductDiv(url)
                        reloadNoAvilDiv(url);
                    }else if(action == 'reload-all-products') {
                        obj.hide('fast', function() {
                            obj.remove();
                        });
                        reloadAllProductDiv(url);
                    }
                    $('#overlay-loader').hide();
                },
                error: function (data) {
                    $('#overlay-loader').hide();
                    $.toaster({
                        message: "Ошибка сервера!",
                        title: 'Sorry!',
                        priority: 'danger',
                        settings: {'timeout': 3000}
                    });
                }
            });
        }
    }
    

    function reloadNoAvilDiv(url) {
        var inProgress = false;
        if (!inProgress) {
            $.ajax({
                async: false,
                method: 'get',
                url: url,
                beforeSend: function () {
                    inProgress = true;
                },
                success: function (data) {
                    $('#table-not-avil-product').empty();
                    $('#table-not-avil-product').html(data);
                },
                error: function (data) {
                    console.log('Server error!');
                }
            });
        }
    }
    function reloadAllProductDiv(url) {
        var inProgress = false;
        if (!inProgress) {
            $.ajax({
                async: true,
                method: 'get',
                url: url,
                beforeSend: function () {
                    inProgress = true;
                },
                success: function (data) {
                    $('#table-all-product').empty();
                    $('#table-all-product').html(data);
                },
                error: function (data) {
                    console.log('Server error!');
                }
            });
        }
    }
    //Изменение статуса товара(end)
</script>