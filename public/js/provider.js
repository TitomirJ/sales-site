(function($, undefined){
    $(function(){

        // удаление сотрудника и перенос товаров и заказов на другого работника
        $('.delete-manager').on('click', function (e) {
            e.preventDefault();
            var personnelId = $(this).attr('personnel-id');
            var action = $(this).attr('href');
            var countProducts = $(this).attr('count-products');
            var countOrders = $(this).attr('count-orders');

            $('#delete-personnel-form').attr('action', action);
            $('.count-products').html(countProducts);
            $('.count-orders').html(countProducts);

            $(".personnel-option").each(function(indx, element){
                $(element).css('display','block');
            });

            $(".personnel-option").each(function(indx, element){
                if($(element).val() == personnelId){
                    $(element).css('display','none');
                }
            });

            $('#modal-delete-manager').modal({
                keyboard: false,
                backdrop: false
            });
        });
        // (end)

        //Удаление товара
        $('body').on('click', '.delete-prod-but', function (e) {
            e.preventDefault();
            var idProduct = $(this).attr('data-id');
            var dataUrl = $(this).attr('data-url');
            var url = $(this).attr('href');
            var inProgress = false;
            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    data: {
                        product_id : idProduct
                    },
                    beforeSend: function () {
                        inProgress = true;
                        $('#overlay-loader').show();
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if(data.status == 'success'){
                            groupChangeRenderProductsPages(dataUrl, 1, 4);
                            groupChangeRenderProductsPages(dataUrl, 1, 1);
                            groupChangeRenderProductsPages(dataUrl, 1, 3);

                            $('#nomoder-item-'+data.productId).hide();
                            $.toaster({
                                message: "Товар успешно удален!",
                                title: '',
                                priority: 'success',
                                settings: {'timeout': 3000}
                            });
                        }else if(data.status == 'success'){
                            $.toaster({
                                message: "В доступе отказано!",
                                title: 'Sorry!',
                                priority: 'danger',
                                settings: {'timeout': 3000}
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
        //(end)Удаление товара

        // Групповое изменение товара поставщиком
        $('#table-all-product').on('click', '#click-all-products', function (e) {
            if($(this).prop("checked")){
                $('.form-check-input[form = action-form-all-product]').each(function(indx, element){
                    if(!$(element).prop("checked")){
                        $(element).click();
                    }
                });
            }else{
                $('.form-check-input[form = action-form-all-product]').each(function(indx, element){
                    if($(element).prop("checked")){
                        $(element).click();
                    }
                });
            }
        });
        $('#table-not-avil-product').on('click', '#click-all-notavail-products', function (e) {
            if($(this).prop("checked")){
                $('.form-check-input[form = action-form-not-avil-product]').each(function(indx, element){
                    if(!$(element).prop("checked")){
                        $(element).click();
                    }
                });
            }else{
                $('.form-check-input[form = action-form-not-avil-product]').each(function(indx, element){
                    if($(element).prop("checked")){
                        $(element).click();
                    }
                });
            }
        });
        $('#table-deleted-product').on('click', '#click-all-deleted-product', function (e) {
            if($(this).prop("checked")){
                $('.form-check-input[form = action-form-deleted-product]').each(function(indx, element){
                    if(!$(element).prop("checked")){
                        $(element).click();
                    }
                });
            }else{
                $('.form-check-input[form = action-form-deleted-product]').each(function(indx, element){
                    if($(element).prop("checked")){
                        $(element).click();
                    }
                });
            }
        });
        $('body').on('click', '.group-products-change-button', function (e) {
            e.preventDefault();
            var inProgress = false;
            var action = $(this).attr('data-action');
            var formId = $(this).attr('form');
            var form = $('#'+formId);
            var url = form.attr('action');
            var typePage = form.attr('type-page');
            var dataUrl = form.attr('data-url');
            var inputActionChange = form.children('input[name=action]').val(action);

            if(!inProgress) {
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
                        $('#overlay-loader').hide();
                        if(data == 'false'){
                            $.toaster({
                                message: "Не выбраны товары!",
                                title: 'Внимание!',
                                priority: 'warning',
                                settings: {'timeout': 3000}
                            });
                        }else if(data == 'all'){
                            var newType = 1;
                            var currentPage = $('.all-products-pagination').attr('all-product-current-page');
                            groupChangeRenderProductsPages(dataUrl, currentPage, newType);

                            if(action == 'group_product_from_all_products_delete'){
                                groupChangeRenderProductsPages(dataUrl, 1, 4);
                                groupChangeRenderProductsPages(dataUrl, 1, 3);
                                groupChangeRenderProductsPages(dataUrl, 1, 2);
                                $.toaster({
                                    message: "Товары успешно удалены!",
                                    title: 'OK!',
                                    priority: 'success',
                                    settings: {'timeout': 3000}
                                });
                                $('#overlay-loader').hide();
                            }else if(action == 'avail_to_not_avail'){
                                groupChangeRenderProductsPages(dataUrl, 1, 3);
                                $.toaster({
                                    message: "Товары успешно пререведены в статус: Не в наличии!",
                                    title: 'OK!',
                                    priority: 'success',
                                    settings: {'timeout': 3000}
                                });
                                $('#overlay-loader').hide();
                            }else if(action == 'group_product_from_all_products_to_market'){
                                $.toaster({
                                    message: "Товары отправлены на валидацию маркетплейсами!",
                                    title: 'OK!',
                                    priority: 'success',
                                    settings: {'timeout': 5000}
                                });
                                $('#overlay-loader').hide();
                            }
                        }else if(data == 'not-avail'){
                            var newType = 3;
                            var currentPage = $('.not-avil-products-pagination').attr('not-avail-product-current-page');
                            groupChangeRenderProductsPages(dataUrl, currentPage, newType);

                            if(action == 'group_product_from_not_avail_products_delete'){
                                groupChangeRenderProductsPages(dataUrl, 1, 4);
                                groupChangeRenderProductsPages(dataUrl, 1, 1);
                                groupChangeRenderProductsPages(dataUrl, 1, 2);
                                $.toaster({
                                    message: "Товары успешно удалены!",
                                    title: 'OK!',
                                    priority: 'success',
                                    settings: {'timeout': 3000}
                                });
                                $('#overlay-loader').hide();
                            }else if(action == 'group_product_from_not_avail_products_to_avail'){
                                groupChangeRenderProductsPages(dataUrl, 1, 1);
                                $.toaster({
                                    message: "Товары успешно пререведены в статус: В наличии!",
                                    title: 'OK!',
                                    priority: 'success',
                                    settings: {'timeout': 3000}
                                });
                                $('#overlay-loader').hide();
                            }
                        }else if(data == 'deleted'){
                            var newType = 4;
                            var currentPage = $('.deleted-products-pagination').attr('deleted-product-current-page');
                            groupChangeRenderProductsPages(dataUrl, currentPage, newType);
                            groupChangeRenderProductsPages(dataUrl, 1, 1);
                            groupChangeRenderProductsPages(dataUrl, 1, 3);
                            groupChangeRenderProductsPages(dataUrl, 1, 2);
                            $('#overlay-loader').hide();
                        }else{
                            $('#overlay-loader').hide();
                        }
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
        });


        function groupChangeRenderProductsPages(url, page, type){

            var inProgress = false;
            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    data: {
                        page : page,
                        type : type
                    },
                    beforeSend: function () {
                        inProgress = true;
                    },
                    success: function (data) {
                        if(type == 1){
                            $('#table-all-product').empty();
                            $('#table-all-product').html(data);
                        }else if(type == 2){
                            $('#all-recomended').empty();
                            $('#all-recomended').html(data);
                        }else if(type == 3){
                            $('#table-not-avil-product').empty();
                            $('#table-not-avil-product').html(data);
                        }else if(type == 4){
                            $('#table-deleted-product').empty();
                            $('#table-deleted-product').html(data);
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
        }
        // (end)Групповое изменение товара поставщиком



        //Изменение статуса товара
        $('body').on('click', '.change-status-avail', function(){
            var formBlog = $(this).parent().parent('.form-change-status-avail');
            var action = $(this).attr('action');
            var url = $(this).attr('myUrl');
            var obj = $(this).parents('.prod-tr-string');
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
        });
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


        // создание товара на странице поставщика

        //Подгрузка подкатегории при выборе категории товара (с индикацией подгрузки)
        //     $(document).ready(function(){
        //         if(window.location.pathname == '/company/products/create'){
        //             var url = $('.get-subcat-select').attr('myUrl');
        //             var catId = $('.get-subcat-select').val();
        //
        //             getSubcategoryProducts(url, catId);
        //         }
        //     });
        //
        //     $('.get-subcat-select').on('change', function (e){
        //         e.preventDefault();
        //         var url = $(this).attr('myUrl');
        //         var catId = $(this).val();
        //
        //         getSubcategoryProducts(url, catId);
        //     });
        //
        //     function getSubcategoryProducts(url, catId){
        //
        //         $('#product-create-subcat-spinner').show();
        //         $('#product-create-subcat-options-spinner').show();
        //         $('.render-inputs').empty();
        //         $('#subcategory-options').empty();
        //         $.ajax({
        //             method: 'get',
        //             url: url,
        //             data: { category_id: catId},
        //             success: function(data){
        //                 var obj = $.parseJSON(data);
        //                 var string = '';
        //                 if(obj.length == 0){
        //                     string ='';
        //                     $('#subcategory').html(string);
        //                 }else{
        //                     for (var i=0; i < obj.length; i++){
        //                         string +='<option value="'+obj[i]['id']+'">'+obj[i]['name']+'</option>';
        //                     }
        //                     $('#subcategory').html(string);
        //
        //                     loadOptionsFromSubcategory();
        //                 }
        //                 $('#product-create-subcat-spinner').hide();
        //                 $('#product-create-subcat-options-spinner').hide();
        //
        //             },
        //             error: function(data){
        //                 $('#product-create-subcat-spinner').hide();
        //                 $('#product-create-subcat-options-spinner').hide();
        //                 $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
        //             }
        //         });
        //     }

        //Проверка статуса маркетплейса товара при изменениии его поставщиком
        $('body').on('click', '.check-edit-product',function (e) {
            e.preventDefault();
            var inProgress = false;
            var url = $(this).data('check');
            var urlEdit = $(this).attr('myUrl');
            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    beforeSend: function () {
                        inProgress = true;
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        var status = data.status;
                        if(status == 'error'){
                            $.toaster({
                                message: "Ошибка сервера!",
                                title: 'Sorry!',
                                priority: 'danger',
                                settings: {'timeout': 3000}
                            });
                        }else if(status == 'false'){
                            $('.modal-edit-content').empty();
                            $('.modal-edit-content').html(data.render);
                            $('#check-edit-modal').modal({
                                keyboard: false,
                                backdrop: 'static'
                            });
                        }else if(status == 'true'){
                            document.location.href = urlEdit;
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

        $('.modal-edit-content').on('click', '.edit-modal-load-short-form', function (e) {
            e.preventDefault();
            var inProgress = false;
            var url = $(this).attr('data-url');
            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    beforeSend: function () {
                        inProgress = true;
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        var status = data.status;
                        if(status == 'error'){
                            $.toaster({
                                message: "Ошибка сервера!",
                                title: 'Sorry!',
                                priority: 'danger',
                                settings: {'timeout': 3000}
                            });
                        }else if(status == 'true'){
                            $('.modal-edit-content').empty();
                            $('.modal-edit-content').html(data.form);
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
        //(end)

        //change status order
        $('#orders-place').on('click', '.change-order-button', function (event) {
            event.preventDefault();

            var action = $(this).attr('data-action');
            var orderId = $(this).attr('data-order');

            var inProgress = false;
            var url = $(this).attr('href');
            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    data: {
                        action : action
                    },
                    beforeSend: function () {
                        inProgress = true;
                        $('#overlay-loader').show();
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if(data.status == 'error'){
                            $.toaster({
                                message: "Действие невозможно!",
                                title: '',
                                priority: 'danger',
                                settings: {'timeout': 3000}
                            });
                        }else if(data.status == 'success'){
                            $('.status-button-'+orderId).empty();
                            $('.status-button-'+orderId).html(data.render);
                            if(action == 1){
                                $.toaster({
                                    message: "Заказ выполнен, сделка закрыта!",
                                    title: '',
                                    priority: 'success',
                                    settings: {'timeout': 3000}
                                });
                            }else if(action == 2){
                                $.toaster({
                                    message: "Заказ успешно отменен!",
                                    title: '',
                                    priority: 'success',
                                    settings: {'timeout': 3000}
                                });

                            }else if(action == 3){
                                $.toaster({
                                    message: "Заказ отправлен заказчику!",
                                    title: '',
                                    priority: 'success',
                                    settings: {'timeout': 3000}
                                });

                            }else if(action == 4){
                                $.toaster({
                                    message: "Заказ проверен и отправлен в разкаботку!",
                                    title: '',
                                    priority: 'success',
                                    settings: {'timeout': 3000}
                                });
                            }
                        }else if(data.status == 'showModalForm'){
                            $('.modal-order-ttn-form').empty();
                            $('.modal-order-ttn-form').html(data.render);
                            $('#add-ttn-and-status').modal({
                                keyboard : false,
                                backdrop: 'static'
                            });
                        }else if(data.status == 'showModalForm2'){
                            $('.order-success-status-form').empty();
                            $('.order-success-status-form').html(data.render);
                            $('#order-success-status').modal({
                                keyboard : false,
                                backdrop: 'static'
                            });
                        }else if(data.status == 'showModalForm3'){
                            $('.order-cancel-status-form').empty();
                            $('.order-cancel-status-form').html(data.render);
                            $('#order-cancel-status').modal({
                                keyboard : false,
                                backdrop: 'static'
                            });
                        }else if(data.status == 'nochange'){
                            if(data.action == '1'){
                                $.toaster({
                                    message: "Заказ выполнен, статус изменить нельзя!",
                                    title: '',
                                    priority: 'warning',
                                    settings: {'timeout': 5000}
                                });
                            }else if(data.action == '2'){
                                $.toaster({
                                    message: "Заказ отменен, статус изменить нельзя!",
                                    title: '',
                                    priority: 'warning',
                                    settings: {'timeout': 5000}
                                });
                            }
                        }
                        $('#overlay-loader').hide();
                    }
                });
            }
        });

        $('body').on('click', '.com-ord-stat-b', function (e) {
            e.preventDefault();
            var inProgress = false;
            var form = $(this).parent('form');
            var url = form.attr('action');
            var orderId = form.attr('data-id');

            var cancelForm = false;
            if($(this).hasClass('status-order-form-button')){
                var cancelSelect = $('#status-select-cancel');
                var flag = cancelSelect.val();

                cancelSelect.removeClass('is-invalid');
                if(flag == 'false'){
                    cancelSelect.addClass('is-invalid');
                    cancelForm = true;
                    $.toaster({
                        message: "Не указана причина, отказа!",
                        title: 'Внимание!',
                        priority: 'warning',
                        settings: {'timeout': 5000}
                    });
                }
                var cancelTextarea = $('#status-textarea-cancel');
                cancelTextarea.removeClass('is-invalid');
                if(flag == 'price_changed' || flag == 'not_enough_fields' || flag == 'another'){
                    if(cancelTextarea.val() == ''){
                        cancelTextarea.addClass('is-invalid');
                        cancelForm = true;
                        $.toaster({
                            message: "Не указано описание причины!",
                            title: 'Внимание!',
                            priority: 'warning',
                            settings: {'timeout': 5000}
                        });
                    }
                }

            }

            if (!inProgress && !cancelForm) {
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
                        $('.status-button-'+orderId).empty();
                        $('.status-button-'+orderId).html(data.render);
                        if(data.action == 'del'){
                            $('#add-ttn-and-status').modal('hide');
                        }else if(data.action == 'confirm'){
                            $('#order-success-status').modal('hide');
                        }else if(data.action == 'cancel'){
                            $('#order-cancel-status').modal('hide');
                        }

                        $('#overlay-loader').hide();
                    }
                });
            }
        });
        //(end)

    });
})(jQuery);