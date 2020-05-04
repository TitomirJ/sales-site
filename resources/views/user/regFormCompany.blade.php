@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/userProfile/userProfile.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-5">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">

                    <h2 class="text-center">Регистрация компании</h2>

                    <form class="form-horizontal" method="POST" action="{{ asset('/company/create') }}" id="reg-company-form">
                        {{ csrf_field() }}
                    </form>

                    <ul class="nav nav-pills  nav-justified mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-info-tab" data-toggle="pill" href="#pills-info" role="tab" aria-controls="pills-info" aria-selected="true">Общая информация</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-legal-tab" data-toggle="pill" href="#pills-legal" role="tab" aria-controls="pills-legal" aria-selected="false">Юридические данные</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-info" role="tabpanel" aria-labelledby="pills-info-tab">
                            <div class="row">
                                <div class="col-12 p-3 bg-light border-radius border-2 border-blue">
                                    <div class="form-group">
                                        <label for="name">Название *</label>
                                        <input id="name" type="text" class="legal-input form-control" name="name" form="reg-company-form" autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Ссылка</label>
                                        <input id="link" type="text" class="form-control" name="link" form="reg-company-form" autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Ответсвтенный *</label>
                                        <input id="responsible" type="text" class="legal-input form-control" name="responsible" form="reg-company-form" autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Номер ответственного *</label>
                                        <input id="responsible-phone" type="text" class="legal-input form-control mask-tel" name="responsible_phone" form="reg-company-form" autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Информация о компании *</label>
                                        <textarea id="info" type="text" class="legal-input form-control" name="info" form="reg-company-form"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-legal" role="tabpanel" aria-labelledby="pills-legal-tab">
                            <div class="row">
                                <div class="col-12 p-3 bg-light border-radius border-2 border-blue" style="position: relative;">

                                    <div id="overlay-loader" class="overlay-type-company" style="position: absolute;">
                                        <div id="loader"></div>
                                    </div>

                                    <div id="selector-type-company">
                                        <div class="form-group">
                                            <label for="type-company"></label>
                                            <select class="legal-input form-control type-company-select2 load-type-company-form" name="type_company" id="type-company" data-url="{{ asset('company/type/form') }}" form="reg-company-form">
                                                <option value="0" selected>Юридическое лицо</option>
                                                <option value="1">Физическое лицо предприниматель (ФОП)</option>
                                                <option value="2">Физическое лицо</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div id="type-company-form">

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="create-company-submit-btn" class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" type="submit" form="reg-company-form">Зарегистрировать</button>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('script2')
    <script>
        (function($, undefined){
            $(function(){

                const selectTypeCompany = $('.load-type-company-form');

                $(document).ready(function(){
                    $('.type-company-select2').select2();

                    loadTypeCompanyForm(selectTypeCompany.data('url'), 0);
                });

                $('.load-type-company-form').on('change', function (e) {
                    e.preventDefault();
                    var type = $(this).val();
                    var url = $(this).data('url');
                    loadTypeCompanyForm(url, type);
                });

                function loadTypeCompanyForm(url, type) {
                    var inProgress = false;
                    if(!inProgress){
                        $.ajax({
                            async: true,
                            method: 'get',
                            url: url,
                            data: {
                                type_company : type
                            },
                            beforeSend: function() {
                                inProgress = true;
                                $('.overlay-type-company').show();
                            },
                            success: function(data){
                                $('#type-company-form').html(data);
                                $('.overlay-type-company').hide();
                            },
                            error: function(data){
                                $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                                $('.overlay-type-company').hide();
                            }
                        });
                    }
                }



                $('#create-company-submit-btn').on('click', function (e) {
                    e.preventDefault();
                    var flagCreateComForm = true;
                    var elemToClick = null;
                    var form = $('#'+$(this).attr('form'));

                    $(".legal-input").removeClass('is-invalid');
                    $('#info').css({'border-color':'green'});

                    $(".legal-input").each(function(indx, element){
                        var value = $(element).val();

                        if(value == '' || value == null){
                            flagCreateComForm = false;
                            $(element).addClass('is-invalid');
                            elemToClick = $(element);

                            if($(element).attr('id') == 'info'){
                                $(element).css({'border-color':'red'});
                            }
                        }
                    });

                    if(!flagCreateComForm){
                        $('#'+elemToClick.parents('.tab-pane').attr('id')+'-tab').click();
                        $.toaster({ message : "Поля формы обязательны для заполнения!", title : '', priority : 'danger', settings : {'timeout' : 3000} });
                    }else{
                        form.submit();
                    }
                });


            });
        })(jQuery);
    </script>
@endsection