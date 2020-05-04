(function($, undefined){
    $(function(){

        $('.select2-products').select2({
            placeholder: 'Товары не найдены'
        });
        $('.select2-marketplaces').select2({
            placeholder: 'Маркетплейсы не найдены'
        });

        $( document ).ready(function(){
            var productSelect = $('#product-id');
            var productId = productSelect.val();
            var url = productSelect.data('url')+'/'+productId;

            loadInfoPanel(url);
        });

        $('#admin-create-new-order-form').on('change', '#product-id', function (e) {
            e.preventDefault();

            var productSelect = $('#product-id');
            var productId = productSelect.val();
            var url = productSelect.data('url')+'/'+productId;

            loadInfoPanel(url);
        });

        function loadInfoPanel(url) {
                var inProgress = false;

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
                                $('.product-info').html(data.render);
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
        }

        $('.submit-new-order').on('click', function (e) {
            e.preventDefault();
            var resault = confirm("Вы уверены, что хотите создать заказ?");
            if (resault){
                $('#admin-create-new-order-form').submit();
            }
        });
    });
})(jQuery);

