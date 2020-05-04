@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent

@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-12">
                    <h1 class="w-100 text-center">
                        Оплата средств
                    </h1>
                </div>
            </div>
            <form id="pay-form" action="{{ asset('bigmarketing/pay') }}" method="POST">

                <div class="row border-bottom">
                    <div class="col-md-6 p-3 bg-light border-right">

                        <h3 class="mb-3 w-100 text-center">Данные платежа</h3>


                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Имя плательщика *</label>
                            <input class="form-control" id="name" type="text" name="name" value="">
                        </div>
                        <div class="form-group">
                            <label for="surname">Фамилия плательщика *</label>
                            <input class="form-control" id="surname" type="text" name="surname" value="">
                        </div>
                        <div class="form-group">
                            <label for="email">Почта плательщика</label>
                            <input class="form-control" id="email" type="email" name="email" value="" >
                        </div>
                        <div class="form-group">
                            <label for="phone">Телефон плательщика *</label>
                            <input class="form-control" id="phone" type="tel" name="phone" value="" >
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="amount">Сумма *</label>
                                    <input class="form-control" id="amount" type="number" step="any" min="0"  name="amount" value="" >
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="currency-id">Валюта *</label>
                                    <select class="form-control currency-select2"  name="currency_id" id="currency-id">
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->id }}">{{ '('.$currency->code.') '.$currency->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Назначение платежа *</label>
                            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                        </div>

                    </div>

                    <div class="col-md-6 p-3 bg-light">

                        <h3 class="mb-3 w-100 text-center">Информация</h3>



                    </div>
                </div>
                <button type="submit" class="btn btn-form square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" id="submit-pay-form">Подготовить платеж</button>
            </form>
        </div>
    </div>

    @include('bigmarketing.pay.layouts.modal')

@endsection

@section('script2')
    <script>
        (function($, undefined){
            $(function(){

                $(document).ready(function(){
                    $('.currency-select2').select2();
                });

                $('#submit-pay-form').on('click', function (e) {
                    e.preventDefault();

                    var form = $('#pay-form');
                    var url = form.attr('action');
                    var inProgress = false;

                    if (!inProgress) {
                        $.ajax({
                            async: true,
                            method: 'post',
                            url: url,
                            data: form.serialize(),
                            beforeSend: function () {
                                inProgress = true;
                            },
                            success: function (data) {
                                var data = JSON.parse(data);
                               // console.log(data)
                                if(data.status == 'success'){
                                    $('.ajax-modalPay-body').html(data.render);
                                    $('#pay-form-modal').modal();
                                }else if(data.status == 'error'){
                                    validationForm(data.errors);
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
                
                function validationForm(object) {
                    $(".form-control").each(function(){
                        $(this).removeClass('is-invalid');
                    });
                    $.each(object, function (key,val) {
                        $('#'+key).addClass('is-invalid');
                        $.each(this, function (k,v) {
                            $.toaster({
                                message: v+"!",
                                title: '',
                                priority: 'danger',
                                settings: {'timeout': 3000}
                            });
                        });
                    });
                }

            });
        })(jQuery);
    </script>
@endsection
