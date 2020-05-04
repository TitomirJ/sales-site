@extends('admin.layouts.app')


@section('script2')
    <script src="{{ asset('/js/pages/admin/mod/prod/prod_index.js') }}"></script>
@endsection

@section('content')



    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="col-12 f30 mt-5 mb-5">
                <div class="text-uppercase blue-d-t">
                    модерация товаров
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills nav-justified mb-3">
                        <li class="nav-item">
                            <a href="{{ asset('/admin/moderation/products?type=all') }}" data-type="all" class="nav-link products-tab <?= ($type_page == 'all') ? 'active' : ''?>" rel="nofollow">
                                Все товары
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/admin/moderation/products?type=moderation') }}" data-type="moderation" class="nav-link products-tab <?= ($type_page == 'moderation') ? 'active' : ''?>" rel="nofollow">
                                На модерации
                            </a>
                        </li>

                        @if(Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a href="{{ asset('/admin/moderation/products?type=chprice') }}" data-type="chprice" class="nav-link products-tab <?= ($type_page == 'chprice') ? 'active' : ''?>" rel="nofollow">
                                    Изменена цена
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>


            <div class="row  mt-3">
                <div class="col-12 mb-3" id="filter-place">
                    {!! $render_filter !!}
                </div>
                <div class="col-12 mb-3" style="position: relative;">
                    <div id="overlay-loader" class="table-overlay-loader" style="position: absolute">
                        <div id="loader"></div>
                    </div>
                    <div class="row" id="products-place">
                        {!! $render_products !!}
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script>

        {{--$('.container-fluid').on('click', '.pagination li a', function (e) {--}}
            {{--e.preventDefault();--}}
            {{--var inProgress = false;--}}
            {{--var url = $(this).attr('href');--}}
            {{--var type = $(this).parent().parent().parent('.products-pagination').data('type');--}}

            {{--if(!inProgress){--}}
                {{--$.ajax({--}}
                    {{--async: true,--}}
                    {{--method: 'get',--}}
                    {{--url: url,--}}
                    {{--beforeSend: function() {--}}
                        {{--inProgress = true;--}}
                        {{--$('#overlay-loader').show();--}}
                    {{--},--}}
                    {{--success: function(data){--}}
                        {{--if(type == 1){--}}
                            {{--$('.pills-moderation').empty();--}}
                            {{--$('.pills-moderation').html(data);--}}
                        {{--}else if(type == 2){--}}
                            {{--$('.pills-chprice').empty();--}}
                            {{--$('.pills-chprice').html(data);--}}
                        {{--}else if(type == 3){--}}
                            {{--$('.pills-all').empty();--}}
                            {{--$('.pills-all').html(data);--}}
                        {{--}--}}
                        {{--$("html, body").animate({scrollTop:0}, 500, 'swing');--}}
                        {{--$('#overlay-loader').hide();--}}
                    {{--},--}}
                    {{--error: function(data){--}}
                        {{--$.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });--}}
                        {{--$('#overlay-loader').hide();--}}
                    {{--}--}}
                {{--});--}}
            {{--}--}}
        {{--});--}}

        {{--$('.search-products-moderator').on('keyup', function (e) {--}}
            {{--e.preventDefault();--}}
            {{--var keyCode = e.keyCode || e.which;--}}
            {{--if (keyCode === 13) {--}}
                {{--return false;--}}
            {{--}--}}
            {{--var form = $(this).parents("form");--}}
            {{--var url = form.attr('action');--}}
            {{--var type = form.data('type');--}}
            {{--delay(function(){--}}
                {{--filterProductsModerator(form, url, type);--}}
            {{--}, 500 );--}}
        {{--});--}}

        {{--$('.search-products-moderator-c').on('change', function (e) {--}}
            {{--e.preventDefault();--}}
            {{--var form = $(this).parents("form");--}}
            {{--var url = form.attr('action');--}}
            {{--var type = form.data('type');--}}
            {{--filterProductsModerator(form, url, type);--}}
        {{--});--}}

        {{--var delay = (function(){--}}
            {{--var timer = 0;--}}
            {{--return function(callback, ms){--}}
                {{--clearTimeout (timer);--}}
                {{--timer = setTimeout(callback, ms);--}}
            {{--};--}}
        {{--})();--}}

        {{--function filterProductsModerator(form, url, type){--}}
            {{--var inProgress = false;--}}

            {{--if(!inProgress){--}}
                {{--$.ajax({--}}
                    {{--async: true,--}}
                    {{--method: 'get',--}}
                    {{--url: url,--}}
                    {{--data: form.serialize(),--}}
                    {{--beforeSend: function() {--}}
                        {{--inProgress = true;--}}
                        {{--$('.table-overlay-loader').show()--}}
                    {{--},--}}
                    {{--success: function(data){--}}
                        {{--if(type == 1){--}}
                            {{--$('.pills-moderation').empty();--}}
                            {{--$('.pills-moderation').html(data);--}}
                        {{--}else if(type == 2){--}}
                            {{--$('.pills-chprice').empty();--}}
                            {{--$('.pills-chprice').html(data);--}}
                        {{--}else if(type == 3){--}}
                            {{--$('.pills-all').empty();--}}
                            {{--$('.pills-all').html(data);--}}
                        {{--}--}}
                        {{--$('.table-overlay-loader').hide()--}}
                    {{--},--}}
                    {{--error: function(data){--}}
                        {{--$('.table-overlay-loader').hide()--}}
                        {{--$.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });--}}
                    {{--}--}}
                {{--});--}}
            {{--}--}}
        {{--}--}}

        $(document).ready(function(){
            $('.company-select2').select2({
                placeholder: 'Компании не найдены',
            });
            $('.subcategory-select2').select2({
                placeholder: 'Подкатегории не найдены',
            });
            $('.status-remod-select2').select2();
        });
    </script>

@endsection
