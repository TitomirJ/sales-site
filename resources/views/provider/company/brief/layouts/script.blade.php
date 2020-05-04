<script>// Инициализация
    var datapicker = $('.datepicker-here').datepicker({
        range: true,
        toggleSelected: false,
        multipleDatesSeparator:' - ',
        dateFormat: 'dd.mm.yyyy',
        multipleDates: true,
        onSelect: function(formattedDate, date, inst){
            if($('.datepicker-here').val().length > 11){
                datapicker.blur();
                searchDataBrife();
            }
        }
    })

    // Доступ к экземпляру объекта
    $('.datepicker-here').data('datepicker')

    function searchDataBrife() {
        var inProgress = false;
        var url = $('#brife-search').attr('action');
        if (!inProgress) {
            $.ajax({
                async: true,
                method: 'get',
                url: url,
                data: {
                    "date": $('.datepicker-here').val()
                },
                beforeSend: function () {
                    inProgress = true;
                    $('#overlay-loader').show();
                },
                success: function (data) {

                    $('.brife-orders').empty();
                    $('.brife-orders').html(data[0]);
                    $('.brife-sum').empty();
                    $('.brife-sum').html(data[1]);
                    $('.brife-deleted').empty();
                    $('.brife-deleted').html(data[2]);
                    $('#pieChart').empty();
                    $('#pieChart').html(data[3]);
                    $('#statisticBlock').empty();
                    $('#statisticBlock').html(data[4]);
                    $('#personnelBlock').empty();
                    $('#personnelBlock').html(data[5]);
                    $('#overlay-loader').hide();
                    $.toaster({
                        message: "Данные за указаный период получены!",
                        title: 'OK!',
                        priority: 'success',
                        settings: {'timeout': 3000}
                    });
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
</script>