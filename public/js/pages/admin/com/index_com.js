(function($, undefined){
    $(function(){

        $('#companies-place').on('click', '.pagination li a', function (e) {
            e.preventDefault();
            var inProgress = false;
            var url = $(this).attr('href');

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

                        $('#companies-place').html(data);
                        $("html, body").animate({scrollTop:0}, 500, 'swing');
                        $('#overlay-loader').hide();
                    },
                    error: function(data){
                        $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                        $('#overlay-loader').hide();
                    }
                });
            }
        });


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
                filterAdminCompaniesIndex(url, form);
            }, 500 );
        });

        $('.action-filter-company-c').on('change', function (e) {
            e.preventDefault();
            var formId = $(this).attr("form");
            var form = $('#'+formId);
            var url = form.attr('action');
            filterAdminCompaniesIndex(url, form);
        });

        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();

        function filterAdminCompaniesIndex(url, form){
            var inProgress = false;
            if(!inProgress){
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    data: form.serialize(),
                    beforeSend: function() {
                        inProgress = true;
                        $('.table-overlay-loader').show()
                    },
                    success: function(data){
                        $('#companies-place').html(data);
                        $('.table-overlay-loader').hide()
                    },
                    error: function(data){
                        $('.table-overlay-loader').hide()
                        $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                    }
                });
            }
        }

        $(document).ready(function(){
            $('.filter-select2').select2({
                placeholder: 'Данные не найдены',
            });
        });
    });
})(jQuery);

