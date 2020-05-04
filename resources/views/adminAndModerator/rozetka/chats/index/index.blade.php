@extends('admin.layouts.app')


@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/modules/checkbox.css') }}">

@endsection

@section('content')



    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
                <div class="text-uppercase blue-d-t">
                   Не распределенные чаты Розетки
                </div>
            </div>

            <div class="row mt-3" id="chart-block">
                <div class="col-12">

                    @include('adminAndModerator.rozetka.chats.index.layouts.tabs')

                    <div class="tab-content table-responsive scroll_wrap" >
                        <form action="{{ asset('admin/rozetka/actions/chats') }}" method="post" id="group-charts-actions">
                            {{ csrf_field() }}
                            <input type="hidden" name="action" value="" id="group-action-name">
                        </form>

                        <table  class="table position-relative scroll_me">
                            <thead>
                            <tr>
                                <th colspan="6" class="border-left border-top border-right border-bottom border-blue">
                                    <div class="d-flex justify-content-md-center justify-content-start p-2  text-nowrap dark-lin">

                                        <div class="input-group w-75">
                                            <label for="search-charts" class="text-info mt-2">Поиск по...</label>
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span id="drop-select-prot">
                                                            @if($type_subpage == 'orders')
                                                                номеру заказа
                                                            @elseif($type_subpage == 'other')
                                                                теме вопроса
                                                            @endif
                                                        </span><i class="fa fa-arrow-down ml-2" aria-hidden="true"></i></button>
                                                <div class="dropdown-menu">

                                                    @if($type_subpage == 'orders')
                                                        <a class="dropdown-item select-prot-search cursor-p " data-protocol="orders_ids" data-prew="номеру заказа">номеру заказа</a>
                                                    @elseif($type_subpage == 'other')
                                                        <a class="dropdown-item select-prot-search cursor-p " data-protocol="subject" data-prew="теме вопроса">теме вопроса</a>
                                                    @endif

                                                    <a class="dropdown-item select-prot-search cursor-p " data-protocol="user_fio" data-prew="ФИО отправителя">ФИО отправителя</a>
                                                    <a class="dropdown-item select-prot-search cursor-p " data-protocol="created_at" data-prew="дате отправки">дате отправки</a>
                                                </div>
                                            </div>
                                            <?
                                            $def_first_select = '';
                                            if($type_subpage == 'orders'){
                                                $def_first_select = "orders_ids";
                                            }elseif($type_subpage == 'other'){
                                                $def_first_select = "subject";
                                            }
                                            ?>
                                            <form class="form-control" action="{{ asset('admin/rozetka/chats') }}" method="get" id="search-form">
                                                <input type="hidden" name="search_protocol" value="{{ $def_first_select }}" id="search-protocol">
                                                <input type="text" class="form-control" aria-label="Поиск сообщения по параметрам" name="search_text" id="search-charts-text">
                                                <input type="hidden" name="page" value="1" id="search-f-page">
                                                <input type="hidden" name="type" value="{{ $type_subpage }}">
                                                <input type="hidden" name="sort_name" value="updated_at" id="search-f-s-name">
                                                <input type="hidden" name="sort_type" value="desc" id="search-f-s-type">
                                            </form>
                                        </div>

                                    </div>

                                    <div class="d-flex p-2 border-left border-top border-right border-bottom border-blue text-nowrap dark-lin">

                                        <span class="text-info mt-2 d-none d-md-block" style="font-size: 18px;">Действия с выбранными сообщениями:</span>
                                        <div class="w-100 d-flex justify-content-md-around justify-content-start">
                                            <button class="btn square_btn btn-light bg-white shadow-custom text-uppercase border-radius-50 ml-2 mr-2 group-button" form="group-charts-actions" data-action="1">Прочитаные</button>
                                            <button class="btn square_btn btn-light bg-white shadow-custom text-uppercase border-radius-50 ml-2 mr-2 group-button" form="group-charts-actions" data-action="0">не прочитаные</button>
                                        </div>

                                    </div>
                                </th>
                            </tr>
                            </thead>




                            @include('adminAndModerator.rozetka.chats.index.layouts.thead', ['type' => $type_subpage])

                            <tbody id="charts-place">

                            @include('adminAndModerator.rozetka.chats.index.layouts.chat_block', ['type' => $type_subpage, 'charts' => $charts])

                            </tbody>

                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="link-chat-to-com-modal" tabindex="-1" role="dialog" aria-labelledby="linkTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-center w-100 text-white" id="linkTitle">привязка чата</h5>
                </div>
                <div class="modal-body" id="link-modal-body"></div>
            </div>
        </div>
    </div>

@endsection

@section('script2')
    <script>

        $('.container-fluid').on('click', '.group-button', function (e) {
            e.preventDefault();
            var inProgress = false;
            var checkBoxFlag = false;
            $('#group-action-name').val($(this).data('action'));

            var form = $('#'+$(this).attr('form'));
            var method = form.attr('method');
            var data = form.serialize();
            var url = form.attr('action')+'?'+data;
            var checkBoxes = $('.form-check-input');

            checkBoxes.each(function (i, e) {
                if($(e).prop("checked")){
                    checkBoxFlag = true;
                }
            });

            if(checkBoxFlag) {
                if (!inProgress) {
                    $.ajax({
                        async: true,
                        method: method,
                        url: url,
                        beforeSend: function () {
                            inProgress = true;
                            $('#overlay-loader').show();
                        },
                        success: function (data) {
                            var data = $.parseJSON(data);
                            if (data.status == 'success') {
                                var renders = data.renderArray;

                                $.each(renders, function (i, val) {
                                    var item = $('#col-chart-' + val.id);
                                    item.html(val.content);
                                });
                                $('#click-all-charts').prop("checked", false);
                            } else if (data.status == 'danger') {
                                $.toaster({message: data.msg, title: '', priority: data.status, settings: {'timeout': 3000}});
                            }

                            $('#overlay-loader').hide();
                        },
                        error: function () {
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
            }else{
                $.toaster({message: 'Не выбран чат!', title: '', priority: 'danger', settings: {'timeout': 3000}});
            }
        });

        $('#chart-block').on('click', '#click-all-charts', function (e) {
            if($(this).prop("checked")){
                $('.form-check-input[form = group-charts-actions]').each(function(indx, element){
                    if(!$(element).prop("checked")){
                        $(element).click();
                    }
                });
            }else{
                $('.form-check-input[form = group-charts-actions]').each(function(indx, element){
                    if($(element).prop("checked")){
                        $(element).click();
                    }
                });
            }
        });

        $('.container-fluid').on('click', '.pagination li a', function (e) {
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
                        var data = $.parseJSON( data );
                        if(data.status == 'success'){
                            $('#charts-place').html(data.render);
                            $("html, body").animate({scrollTop:0}, 500, 'swing');
                        }else if(data.status == 'danger'){
                            $.toaster({ message : data.msg, title : '', priority : data.status, settings : {'timeout' : 3000} });
                        }
                        $('#click-all-charts').prop( "checked", false);
                        $('#overlay-loader').hide();
                    },
                    error: function(){
                        $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                        $('#overlay-loader').hide();
                    }
                });
            }
        });

        $('.container-fluid').on('click', '.sort-button', function (e) {
            e.preventDefault();

            var sortButtonsAll = $('.sort-button');
            var sortInd = $(this).children(".sort-ind").find('i');
            var thisIndex = $(this).index('.sort-button');
            //console.log($('.pagination-block').data('page'));
            sortButtonsAll.each(function (i, e) {
                if(thisIndex == i){
                    var step = $(e).data('step');
                    if(step == 0){
                        $(e).data('step', 'asc');
                        $(e).children(".sort-ind").find('i').removeClass('fa-sort fa-sort-desc').addClass('fa-sort-asc');
                        var sortStep = $(e).data('step');
                        var sortType = $(e).data('sort');
                        changeSortInputsAndSubmit(sortStep, sortType);

                    }else if(step == 'asc'){
                        $(e).data('step', 'desc');
                        $(e).children(".sort-ind").find('i').removeClass('fa-sort fa-sort-asc').addClass('fa-sort-desc');
                        var sortStep = $(e).data('step');
                        var sortType = $(e).data('sort');
                        changeSortInputsAndSubmit(sortStep, sortType);
                    }else if(step == 'desc'){
                        $(e).data('step', 'asc');
                        $(e).children(".sort-ind").find('i').removeClass('fa-sort-desc fa-sort').addClass('fa-sort-asc');
                        var sortStep = $(e).data('step');
                        var sortType = $(e).data('sort');
                        changeSortInputsAndSubmit(sortStep, sortType);
                    }
                }else{
                    $(e).data('step', 0);
                    $(e).children(".sort-ind").find('i').removeClass('fa-sort-asc fa-sort-desc').addClass('fa-sort');
                }
            });
        });

        function changeSortInputsAndSubmit(type, name){
            $('#search-f-s-name').val(name);
            $('#search-f-s-type').val(type);
            $('#search-f-page').val($('.pagination-block').data('page'));
            uploadSearchAndSortCharts();
        }

        $('.container-fluid').on('click', '.select-prot-search', function (e) {
            e.preventDefault();
            var protocol = $(this).data('protocol');
            var prew = $(this).data('prew');
            var inpSearchProtocol = $('#search-protocol');
            var butSelectProtocol = $('#drop-select-prot');
            var inpSearchText = $('#search-charts-text');



            inpSearchProtocol.val(protocol);
            butSelectProtocol.text(prew);
            $('#search-f-page').val(1);
            inpSearchText.val('');
        });

        $('.container-fluid').on('keyup', '#search-charts-text', function (e) {
            e.preventDefault();


            delay(function(){
                $('#search-f-page').val(1);
                uploadSearchAndSortCharts();
            }, 1000 );
        });

        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();

        function uploadSearchAndSortCharts() {
            var inProgress = false;
            var form = $('#search-form');

            var url = form.attr('action')+'?'+form.serialize();
            var method = form.attr('method');

            if(!inProgress){
                $.ajax({
                    async: true,
                    method: method,
                    url: url,
                    beforeSend: function() {
                        inProgress = true;
                        $('#overlay-loader').show();
                    },
                    success: function(data){
                        var data = $.parseJSON( data );
                        if(data.status == 'success'){
                            $('#charts-place').html(data.render);
                        }else if(data.status == 'danger'){
                            $.toaster({ message : data.msg, title : '', priority : data.status, settings : {'timeout' : 3000} });
                        }
                        $('#overlay-loader').hide();
                    },
                    error: function(){
                        $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                        $('#overlay-loader').hide();
                    }
                });
            }
        }

        $('.container-fluid').on('click', '.get-link-to-com-modal', function (e) {
            e.preventDefault();
            var inProgress = false;
            var url = $(this).data('url');

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
                        var data = $.parseJSON( data );
                        if(data.status == 'success'){
                            $('#link-modal-body').html(data.render);
                            $.toaster({ message : data.msg, title : '', priority : data.status, settings : {'timeout' : 3000} });
                            $('#link-chat-to-com-modal').modal({
                                backdrop : 'static',
                                keyboard : false
                            });
                        }else if(data.status == 'danger'){
                            $.toaster({ message : data.msg, title : '', priority : data.status, settings : {'timeout' : 3000} });
                        }

                        $('#overlay-loader').hide();
                    },
                    error: function(){
                        $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                        $('#overlay-loader').hide();
                    }
                });
            }
        });

        $('#link-chat-to-com-modal').on('click', '#submit-link-co-form', function (e) {
            e.preventDefault();
            var inProgress = false;
            var form = $('#link-co-form');
            var data = form.serialize();
            var url = form.attr('action')+'?'+data;

            if(!inProgress){
                $.ajax({
                    async: true,
                    method: 'post',
                    url: url,
                    beforeSend: function() {
                        inProgress = true;
                        $('#overlay-loader').show();
                    },
                    success: function(data){
                        var data = $.parseJSON( data );
                        console.log(data);
                        if(data.status == 'success'){
                            $('#col-chart-'+data.chartId).remove();
                            $.toaster({ message : data.msg, title : '', priority : data.status, settings : {'timeout' : 3000} });
                            $('#link-chat-to-com-modal').modal('hide');
                        }else if(data.status == 'danger'){
                            $.toaster({ message : data.msg, title : '', priority : data.status, settings : {'timeout' : 6000} });
                        }

                        $('#overlay-loader').hide();
                    },
                    error: function(){
                        $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                        $('#overlay-loader').hide();
                    }
                });
            }
        });
    </script>
@endsection
