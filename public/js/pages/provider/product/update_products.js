(function($, undefined){
    $(function(){


        /**
         * переводит чекбокс логистера в выключенное состояние при перезагрузке страницы
         */
        $(document).ready(function() {
            $('#upproform input:checkbox').prop('checked',false);
         });


        function ajax(u, m, d, callback) {

            $.ajax({url: u, method: m, processData: false, contentType: false, data: d, processData: false}).done(function (data) {
                callback(data);
            }).fail(function () {
                $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
            });

        }

        $('#up-pro-submit').on('click', function (e) {
            e.preventDefault();
            if( $('#upproform input:checkbox').prop('checked') ){
                if(!confirm('Товары не указанные в файле, будут выведены из маркета') ){
                        location.reload();
                }
            }

            $('#overlay-loader').show();

            //var form = e.target;
			var form = $('#upproform')[0];
            let u = form.action;
            let m = form.method;
            var d = new FormData(form);

            ajax(u, m, d, (data) => {
                data = JSON.parse(data);


                if(data.status == 'success'){
                    $('#ext-prod-stat').html(data.render);
                    $.toaster({ message : data.msg, title : '', priority : 'success', settings : {'timeout' : 6000} });
                } else if(data.status == 'validation'){
                    for (var i in data.errors) {
                        for (var j in data.errors[i]) {
                            $.toaster({ message : data.errors[i][j], title : '', priority : 'danger', settings : {'timeout' : 6000} });
                        }
                    }
                }else if(data.status == 'error'){
                    $.toaster({ message : data.msg, title : '', priority : 'danger', settings : {'timeout' : 6000} });
                }

                $('#overlay-loader').hide();
                if(data.logister == 'logister' && data.status == 'success'){

                    alert('перезаписано '+data.countnew+' товаров !\n\r Не совпадений : '+data.notreal);
                    //location.reload();
                    $('#upproform')[0].reset();
                }
            });
        });



        /**
         * управление чекбоксом логистера
         */
        $('#logister_btn').on('click', function(e){
            let el = $('#logister_btn');
            let boxcheck = $('#upproform input:checkbox');

            if( boxcheck.prop('checked') ){
                boxcheck.prop('checked',true);
                el.text( 'Логистер выключен');
                el.removeClass('btn-danger').addClass('btn-info');
            }else{
                boxcheck.prop('checked',false);
                el.text( 'Логистер включен');
                el.removeClass('btn-info').addClass('btn-danger');
            }
        })

    });
})(jQuery);