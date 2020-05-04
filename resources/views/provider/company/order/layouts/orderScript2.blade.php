<script>
    (function($, undefined){
        $(function(){
            var dataSortOrder = '';
            var idMarketOrder = 'all';
            var statusSortOrder = 'all';
            var prOrderPagination = <?=$pagination;?>;

            var datapicker = $('.datepicker-here').datepicker({
                range: true,
                toggleSelected: false,
                multipleDatesSeparator:' - ',
                dateFormat: 'dd.mm.yyyy',
                multipleDates: true,
                onSelect: function(formattedDate, date, inst){
                    if($('.datepicker-here').val().length > 11){
                        datapicker.blur();
                        $('.order-hovered-date').toggleClass('d-none d-flex');
                        $('.datepicker-here').toggleClass('d-none d-block');
                        dataSort = formattedDate;

                        var url = window.location.href.split('?')[0];
                        dataSortOrder = dataSort;
                        var datesOrder = dataSortOrder;
                        var marketpalce = idMarketOrder;
                        var statusOrder = statusSortOrder;
                        var p =  prOrderPagination;

                        sortOrderPage(p, url, 1, datesOrder, marketpalce, statusOrder);
                    }
                }
            })

            // Доступ к экземпляру объекта
            $('.datepicker-here').data('datepicker')
            $('.order-hovered-date').on('click', function (e) {
                e.preventDefault();
                datapicker.show();
                $('.order-hovered-date').toggleClass('d-none d-flex');
                $('.datepicker-here').toggleClass('d-none d-block');

            });

            //Сортировка заказов

            $('body').on('click', '.orders-page-pagination-block ul li a', function (e) {
                e.preventDefault();
                var url = window.location.href.split('?')[0];
                var fullUrl = $(this).attr('href');
                var arrayString = fullUrl.split('page=');
                var pagination = arrayString[1];
                var datesOrder = dataSortOrder;
                var marketpalce = idMarketOrder;
                var statusOrder = statusSortOrder;
                var p =  prOrderPagination;


                sortOrderPage(p, url, pagination, datesOrder, marketpalce, statusOrder)
            });

            $('.order-status-sort').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var datesOrder = dataSortOrder;
                var marketpalce = idMarketOrder;
                statusSortOrder = $(this).attr('data-sort');
                var statusOrder = statusSortOrder;
                var p =  prOrderPagination;
                sortOrderPage(p, url, 1, datesOrder, marketpalce, statusOrder)
            });

            $('.orders-market-sort').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var datesOrder = dataSortOrder;
                idMarketOrder = $(this).attr('data-sort');
                var marketpalce = idMarketOrder;
                var statusOrder = statusSortOrder;
                var p =  prOrderPagination;
                sortOrderPage(p, url, 1, datesOrder, marketpalce, statusOrder)
            });


            $('.pr-orders-pagin-ch').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var datesOrder = dataSortOrder;
                prOrderPagination = $(this).attr('data-sort');
                var marketpalce = idMarketOrder;
                var statusOrder = statusSortOrder;
                var p =  prOrderPagination;
                sortOrderPage(p, url, 1, datesOrder, marketpalce, statusOrder)
            });

            function sortOrderPage(type, url, page, dates, market, status) {
                var inProgress = false;
                if(!inProgress) {
                    $.ajax({
                        async: true,
                        method: 'get',
                        url: url,
                        data: {
                            page : page,
                            type : type,
                            dates : dates,
                            market : market,
                            status : status
                        },
                        beforeSend: function () {
                            inProgress = true;
                            $('#overlay-loader').show();
                        },
                        success: function (data) {
                            var data = JSON.parse(data);
                            $('#orders-place').empty();
                            $('#orders-place').html(data.render);
                            $('#overlay-loader').hide();
                        },
                        error: function (data) {
                            $('#overlay-loader').hide();
                        }
                    });
                }

            }



        });
    })(jQuery);
</script>