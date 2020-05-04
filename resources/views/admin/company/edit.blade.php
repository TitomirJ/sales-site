@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    {{--<link rel="stylesheet" href="{{ asset('css/pages/admin/companies/show.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/pages/admin/companies/show.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modules/switchBtn.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modules/checkbox.css') }}">
    <link href="{{ asset('css/datapicker/datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('script1')
    <script src="{{ asset('js/datapicker/datepicker.min.js') }}"></script>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid mt-5">

            <h3 class="w-100 text-center mb-5">Редактирование и настройка компании "{{ $company->name }}"</h3>

            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link nav-link-edit @if($type == 'info')active @endif" href="{{ asset('admin/company/'.$company->id.'/edit?type=info') }}">Данные</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-edit @if($type == 'settings')active @endif" href="{{ asset('admin/company/'.$company->id.'/edit?type=settings') }}">Настройки</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-edit @if($type == 'transactions')active @endif" href="{{ asset('admin/company/'.$company->id.'/edit?type=transactions') }}">Транзакции</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-edit" href="#">Пусто</a>
                </li>
            </ul>

            <div class="row mt-3">
                <div class="col-12" id="settings-place">
                    {!! $render_block !!}
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="confirm-modal-store-transaction" tabindex="-1" role="dialog" aria-labelledby="confirm-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-center w-100" id="confirm-modal-title">Внимание!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center modal-body-content">
                    Вы уверены, что хотите выполнить это действие?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="confirm-success-button">применить</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">отменить</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script2')
    <script>
        (function($, undefined){
            $(function(){

                $(document).ready(function(){
                    $('.type-company-select2').select2();
                });

                $('.nav-link-edit').on('click', function (e) {
                    e.preventDefault();

                    $(".nav-link-edit").each(function(indx, element){
                        $(element).removeClass('active');
                    });

                    $(this).addClass('active');

                    loadCompanySettings($(this).attr('href'));
                });

                function loadCompanySettings(url) {

                    var inProgress = false;
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
                                $('#settings-place').html(data);
                                $('#overlay-loader').hide();
                                setLocation(url);
                            },
                            error: function(data){
                                $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                                $('#overlay-loader').hide();
                            }
                        });
                    }
                }

                $('body').on('change', '.load-type-company-form', function (e) {
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
                            },
                            success: function(data){
                                $('#type-company-form').html(data);
                            },
                            error: function(data){
                                $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                            }
                        });
                    }
                }

                $('body').on('click', '#update-company-submit-btn', function (e) {
                    e.preventDefault();
                    var flagCreateComForm = true;

                    var form = $('#'+$(this).attr('form'));

                    $(".legal-input").removeClass('is-invalid');
                    $('#info').css({'border-color':'green'});

                    $(".legal-input").each(function(indx, element){
                        var value = $(element).val();

                        if(value == '' || value == null){
                            flagCreateComForm = false;
                            $(element).addClass('is-invalid');

                            if($(element).attr('id') == 'info'){
                                $(element).css({'border-color':'red'});
                            }
                        }else{
                            $(element).addClass('is-valid');
                        }
                    });

                    if(!flagCreateComForm){
                        $.toaster({ message : "Поля формы обязательны для заполнения!", title : '', priority : 'danger', settings : {'timeout' : 3000} });
                    }else{
                        form.submit();
                    }
                });

                function setLocation(curLoc){
                    try {
                        history.pushState(null, null, curLoc);
                        return;
                    } catch(e) {}
                    location.hash = '#' + curLoc;
                }

                var typeForm = null;
                $('#settings-place').on('click', '.confirm-com-settings', function (e) {
                    e.preventDefault();
                    var type = $(this).attr('form');
                    var form = $('#'+type);
                    typeForm = type;
                    var text = '';

                    if(type == 'add-bal-company-form'){
                        text = 'Вы уверены, что хотите увеличить депозит этой компании?';
                    }else if(type == 'remove-bal-company-form'){
                        text = 'Вы уверены, что хотите уменьшить абонплату этой компании?';
                    }else if(type == 'add-ab-company-form'){
                        text = 'Вы уверены, что хотите увеличить абонплату этой компании?';
                    }else if(type == 'move-products-to-market-form'){
                        text = 'Вы уверены, что хотите принудительно отправить все товары этой компании на маркетплейсы?';
                    }else if(type == 'out-products-from-market-form'){
                        text = 'Вы уверены, что хотите принудительно вывести все товары этой компании из маркетплейсов?';
                    }else if(type == 'change-tariff-company-form'){
                        text = 'Вы уверены, что хотите изменить тарифный план этой компании?';
                    }

                    $('.modal-body-content').html(text);

                    $('#confirm-modal-store-transaction').modal();
                });

                $('#confirm-success-button').on('click', function (e) {
                    e.preventDefault();

                    $('#confirm-modal-store-transaction').modal('hide');
                    $('#'+typeForm).submit();
                });



            });
        })(jQuery);
    </script>
@endsection
