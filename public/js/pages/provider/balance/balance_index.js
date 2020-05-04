(function($, undefined){
    $(function(){

        $(document).ready(function() {
            //пояление сообщения-предупреждения
            $('#alert-balance').slideDown(400);
        });

        //подсветка выбранного способа оплаты
        $('#subscription').on('click', function() {
            $('#subscription').addClass('active-pay');
            $('#deposit').removeClass('active-pay');
        });
        $('#deposit').on('click', function() {
            $('#deposit').addClass('active-pay');
            $('#subscription').removeClass('active-pay');
        });

        $('.show-pay-form').on('click', function (e) {
            e.preventDefault();
            $('#subscription').removeClass('active-pay');
            $('#deposit').removeClass('active-pay');
            $('#com-bal-pay-sel').empty();
            $('#com-bal-but-next').hide();
            $('#company-pay-modal').modal();
        });

        $('.select-pay-method-com').on('click', function (e) {
            e.preventDefault();
            var type = $(this).attr('data-type');
            var url = $(this).attr('data-url');
            loadSelectTypePay(type, url);
        });

        function loadSelectTypePay(type, url){
            var inProgress = false;
            if(!inProgress) {
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    data: {
                        type : type
                    },
                    beforeSend: function () {
                        inProgress = true;
                        $('#overlay-loader').show();
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        $('#com-bal-pay-sel').empty();
                        $('#com-bal-but-next').show();
                        $('#com-bal-pay-sel').html(data.render);
                        $('#overlay-loader').hide();
                    },
                    error: function (data) {
                        $('#overlay-loader').hide();
                    }
                });
            }

        }

        $('#com-bal-but-next').on('click', function (e) {
            e.preventDefault();
            var form = $('#company-balance-pay-select-sum');
            var url = $('#company-balance-pay-select-sum').attr('action');
            $('#company-pay-modal').modal('hide');
            loadLiqpayFormWithInfo(url, form);
        });

        function loadLiqpayFormWithInfo(url, form) {
            var inProgress = false;
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
                        var data = JSON.parse(data);
                        $('#bal-liqpay-body-block').empty();
                        $('#bal-liqpay-footer-block').empty();
                        $('#bal-liqpay-body-block').html(data.render_body);
                        $('#bal-liqpay-footer-block').html(data.render_footer);
                        $('#company-liqpay-modal').modal({
                            keyboard: false,
                            backdrop: 'static'
                        });
                        $('#overlay-loader').hide();
                    },
                    error: function (data) {
                        $('#overlay-loader').hide();
                    }
                });
            }
        }

        $('#bal-liqpay-footer-block').on('click', '#cansel-liqpay-button', function (e) {
            e.preventDefault();
            $('#company-liqpay-modal').modal('hide');
        });

        $('.togle-block-info').on('click', function (e) {
            e.preventDefault();
            var item = $(this).data('item');
            $('.block-info-'+item).toggleClass("d-none");
        });

    });
})(jQuery);