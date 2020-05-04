(function($, undefined){
    $(function(){

        //ajax-self
        function ajaxSelf(m, u, d, callback) {
            var request = new XMLHttpRequest();
            request.open(m, u, true);
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
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
            request.send(d);
        }

        function ajax(options, callback) {
            $.ajax(options).done(function (data) {
                let response = JSON.parse(data);
                callback(response);
            }).fail(function () {
                $.toaster({ message : 'Ошибка сервера!', title : '', priority : 'danger', settings : {'timeout' : 3000} });
            });
        }
        //ajax-self(end)

        // pagination order index
        $('body').on('click', '.pagination li a', function (e) {
            e.preventDefault();

            var url = $(this).attr('href');
            var form = $('#filter-orders');

            filterIndexCompanyOrders(form, url);
        });
        // pagination order index (end)

        // filter order index
        $('.action-filter-company').on('keyup', function (e) {
            e.preventDefault();
            var keyCode = e.keyCode || e.which;

            if (keyCode === 13) {
                return false;
            }

            var formId = $(this).attr("form");
            var form = $('#'+formId);
            var url = form.attr('action');

            delay(function(){
                filterIndexCompanyOrders(form, url);
                console.log('test')
            }, 1000 );
        });

        $('.action-filter-ch-company').on('change', function (e) {
            e.preventDefault();

            var formId = $(this).attr("form");
            var form = $('#'+formId);
            var url = form.attr('action');

            filterIndexCompanyOrders(form, url);
        });

        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();

        var datapickerOrder = $('.dpk-order').datepicker({
            range: true,
            toggleSelected: false,
            multipleDatesSeparator:' - ',
            dateFormat: 'dd.mm.yyyy',
            multipleDates: true,
            onSelect: function(formattedDate, date, inst){
                if($('.dpk-order').val().length > 11){
                    datapickerOrder.blur();

                    var form = $('#filter-orders');
                    var url = form.attr('action');

                    filterIndexCompanyOrders(form, url);
                }
            }
        });

        function filterIndexCompanyOrders(form, url){
            var inProgress = false;

            if(!inProgress){
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    data: form.serialize(),
                    beforeSend: function() {
                        inProgress = true;
                        $('.table-overlay-loader').show();
                    },
                    success: function(data){
                        var data = JSON.parse(data);
                            $('#orders-place').html(data.render);
                            $('#in-count-ord').text(data.countOrders);
                        $('.table-overlay-loader').hide();
                    },
                    error: function(data){
                        $('.table-overlay-loader').hide();
                        $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                    }
                });
            }
        }
        // filter order index (end)

        // order change status - 20.02.2019
        $('#orders-place').on('click', '.change-o-status', function (e) {
            e.preventDefault();

            let action = $(this).data('action');
            let orderId = $(this).data('order');
            let url = $(this).data('url');
            let token = $('[name=csrf-token]').attr('content');
            let data = {
                _token: token,
                action: action
            };
            let params = $.param( data );

            $('#overlay-loader').show();
            ajax(options = {url:url, type: 'POST', data: params}, (data) => {
                if(data.status == 'success'){
                    if(data.action == 'modal'){
                        $.toaster({ message : data.msg, title : '', priority : 'success', settings : {'timeout' : 6000} });
                        $('#change-status-order-modal-title').text(data.title);
                        $('#change-status-order-modal-body').html(data.render);
                        $('#change-status-order-modal').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                    }
                }else if(data.status == 'error'){
                    $.toaster({ message : data.msg, title : '', priority : 'danger', settings : {'timeout' : 6000} });
                }
                $('#overlay-loader').hide();
            });
        });

        $('.modal-body').on('click', '.submit-c-status-form', function (e) {
            e.preventDefault();
            let f = $(this).closest('form');
            let i = f.find('input');

            if(validation(f, i)){
                changeOrderStatusTrait(f);
            }else{

            }
        });

        function validation(f, i){
            let flag = true;
            let textarea = f.find('textarea');
            i.each(function (i,e) {
                let t = $(e).attr('type');
                let v = $(e).val();
                let id = $(e).attr('id');
                if(t == 'radio' && id == 'delivery-m-np' && $(e).prop('checked') ){
                    let ttnInput = $('#'+$(e).data('type'));
                    let ttnInputValue = ttnInput.val();
                    ttnInput.removeClass('is-invalid');
                    if(!checkTTN(ttnInputValue)){
                        ttnInput.addClass('is-invalid');
                        $.toaster({ message : 'Не верно указан ТТН Новой Почты!', title : '', priority : 'danger', settings : {'timeout' : 6000} });
                        flag = false;
                    }
                }
            });

            if(textarea.length >=1){
                textarea.each(function (i,e) {
                    let v = $(e).val();
                    $(e).removeClass('is-invalid');
                    if(v == ''){
                        $(e).addClass('is-invalid');
                        $.toaster({ message : 'Укажите описание отмены заказа!', title : '', priority : 'danger', settings : {'timeout' : 6000} });
                        flag = false;
                    }
                });
            }
            return flag;
        }
        function checkTTN(ttn){
            let flag1 = ttn.match(/^\d+/);
            let flag2 = (ttn.length == 27);
            console.log(ttn.length)
            if(!flag1 || !flag2){
                return false;
            }
            return true;
        }
        function changeOrderStatusTrait(f){
            let params = f.serialize();
            let url = f.attr('action');
            let method = f.attr('method');

            $('#overlay-loader').show();
            ajax(options = {url:url, type: method, data: params}, (data) => {
                if(data.status == 'success'){
                    $('#change-status-order-modal').modal('hide');
                    $('.status-button-'+data.orderId).html(data.render);
                    $.toaster({ message : data.msg, title : '', priority : 'success', settings : {'timeout' : 6000} });
                }else if(data.status == 'error'){
                    $.toaster({ message : data.msg, title : '', priority : 'danger', settings : {'timeout' : 6000} });
                }
                $('#overlay-loader').hide();
            });
        }

        $('.modal-body').on('change', '.del-met-radio', function () {
            let inputs = $('.del-met-radio');

            inputs.each(function (i,e) {
                if($(e).prop('checked')){
                    let value = $(e).val();
                    if(value == 'Новая почта'){
                        $('#num-np-block').show();
                    }else{
                        $('#num-np-block').hide();
                    }
                }
            });
        });

        $('.modal-body').on('focus', '#num-np-block-value', function (e) {
             $(this).get(0).setSelectionRange(0,0);
        });
        // order change status (end)

        //actions order(end)
        $(document).ready(function(){
            $('.filter-select2').select2({
                placeholder: 'Данные не найдены',
            });
        });
    });
})(jQuery);

