(function($, undefined){
    $(function(){
        //ajax-self
        function ajaxSelf(m, u, callback) {
            var request = new XMLHttpRequest();
            request.open(m, u, true);
            request.setRequestHeader('Content-Type', 'application/json');
            request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    let data = JSON.parse(request.responseText);
                    callback(data);
                } else {
                    $.toaster({ message : 'Ошибка сервера!', title : '', priority : 'danger', settings : {'timeout' : 3000} });
                }
            };
            request.onerror = function() {
                $.toaster({ message : 'Ошибка сервера!', title : '', priority : 'danger', settings : {'timeout' : 3000} });
            };
            request.send();
        }

        //  product's tabs
        $('.products-tab').on('click', function (e) {
            e.preventDefault();
            let m = 'get';
            let u = $(this).attr('href');

            $('#overlay-loader').show();
            ajaxSelf(m, u, (data) => {
                if (data.status == 'success') {
                    $('.products-tab').removeClass('active');
                    $('.products-tab').each(function (i, e) {
                        let type = $(e).data('type');
                        if(type == data.typePage){$(e).addClass('active');}
                    });
                    $('#filter-place').html(data.filter);
                    $('#products-place').html(data.render);
                    initializeSelect2();
                    $('#overlay-loader').hide();
                }else if(data.status == 'error'){
                    $.toaster({ message : data.msg , title : '', priority : 'danger', settings : {'timeout' : 3000} });
                }else{
                    $.toaster({ message : 'Ошибка сервера!' , title : '', priority : 'danger', settings : {'timeout' : 3000} });
                }
            })
        });
        // pagination XMLRequest
        $('.container-fluid').on('click', '.pagination li a', function (e) {
            e.preventDefault();
            let m = 'get';
            let u = $(this).attr('href');
            $('.table-overlay-loader').show();
            ajaxSelf(m, u, (data) => {
                if (data.status == 'success') {
                    $('#products-place').html(data.render);
                }else if(data.status == 'error'){
                    $.toaster({ message : data.msg , title : '', priority : 'danger', settings : {'timeout' : 3000} });
                }else{
                    $.toaster({ message : 'Ошибка сервера!' , title : '', priority : 'danger', settings : {'timeout' : 3000} });
                }
                $('.table-overlay-loader').hide();
            })
        });

        $('#filter-place').on('click', '#test', function (e) {
            e.preventDefault();
            let form = $('#test-form');
            let d = form.serialize();
            let u = form.attr('action')+'?'+d;
            let m = form.attr('method');

            filter(m, u);
        });

        function filter(method, url) {
            $('.table-overlay-loader').show();
            ajaxSelf(method, url, (data) => {

                if (data.status == 'success') {
                    $('#products-place').html(data.render);
                }else if(data.status == 'error'){
                    $.toaster({ message : data.msg , title : '', priority : 'danger', settings : {'timeout' : 3000} });
                }else{
                    $.toaster({ message : 'Ошибка сервера!' , title : '', priority : 'danger', settings : {'timeout' : 3000} });
                }
                $('.table-overlay-loader').hide();
            })
        }

        $('#filter-place').on('keyup', '.search-products-moderator', function (e) {
            e.preventDefault();
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                return false;
            }
            var form = $(this).parents("form");
            var data = form.serialize();
            var url = form.attr('action')+'?'+data;
            var method = form.attr('method');
            delay(function(){
                filter(method, url);
            }, 500 );
        });

        $('#filter-place').on('change', '.search-products-moderator-c', function (e) {
            e.preventDefault();
            var form = $(this).parents("form");
            var data = form.serialize();
            var url = form.attr('action')+'?'+data;
            var method = form.attr('method');
            filter(method, url);
        });

        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();

        function initializeSelect2(){
            $('.company-select2').select2({
                placeholder: 'Компании не найдены',
            });
            $('.subcategory-select2').select2({
                placeholder: 'Подкатегории не найдены',
            });
            $('.status-remod-select2').select2();
        }

        $('.confirm-modal-form button').on('click', function (e) {
            e.preventDefault();

            var form = $(this).parents("form");
            var u = form.attr('action');
            var m = form.attr('method');
            $('#overlay-loader').show();
            ajaxSelf(m, u, (data) => {

                if (data.status == 'success') {
                    $('.chprice-tr-'+data.productId).remove();
                    $('#confirmModal').modal('hide');
                    $.toaster({ message : data.msg , title : '', priority : 'success', settings : {'timeout' : 3000} });
                }else if(data.status == 'error'){
                    $.toaster({ message : data.msg , title : '', priority : 'danger', settings : {'timeout' : 3000} });
                }else{
                    $.toaster({ message : 'Ошибка сервера!' , title : '', priority : 'danger', settings : {'timeout' : 3000} });
                }
                $('#overlay-loader').hide();
            })
        });

        initializeSelect2();

    });
})(jQuery);