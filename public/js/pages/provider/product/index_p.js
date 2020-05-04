(function($, undefined){
    $(function(){

        $('body').on('click', '.pagination li a', function (e) {
            e.preventDefault();

            var url = $(this).attr('href');
            var type = $(this).parent().parent().parent('.container-fluid').attr('type');

            loadProductsTabsFromFilter(url, type, false);
        });

        $('.action-filter-product').on('keyup', function (e) {
            e.preventDefault();
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                return false;
            }
            var formId = $(this).attr("form");
            var form = $('#'+formId);
            var type = form.data('type');
            var url = form.attr('action');
            delay(function(){
                loadProductsTabsFromFilter(url, type, true, form);
            }, 1000 );
        });

        $('.action-filter-product-c').on('change', function (e) {
            e.preventDefault();
            var formId = $(this).attr("form");
            var form = $('#'+formId);
            var type = form.data('type');
            var url = form.attr('action');
            loadProductsTabsFromFilter(url, type, true, form);
        });

        $('.filter-select2').select2({
            placeholder: 'Данные не найдены',
        });

        function loadProductsTabsFromFilter(url, type, filter=false, form=null) {
            var inProgress = false;
            if(!inProgress){
                if(filter){
                    $.ajax({
                        async: true,
                        method: 'get',
                        url: url,
                        data: form.serialize(),
                        beforeSend: function() {
                            inProgress = true;
                            $('#overlay-loader').show();
                        },
                        success: function(data){

                            if(type == 1){
                                $('#table-all-product').empty();
                                $('#table-all-product').html(data);
                            }else if(type == 2) {
                                $('#all-recomended').empty();
                                $('#all-recomended').html(data);
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
                }else{
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
                            }else if(type == 2) {
                                $('#all-recomended').empty();
                                $('#all-recomended').html(data);
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


            }
        }

        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();


    });
})(jQuery);