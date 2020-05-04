@extends('admin.layouts.app')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="col-12 f30 mt-5 mb-5">
                <div class="text-uppercase blue-d-t">
                    модерация товаров
                </div>
            </div>


            <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="pills-all-tab" data-toggle="pill" href="#pills-all" role="tab" aria-controls="pills-all" aria-selected="true">
                        Все товары
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="pills-moderation-tab" data-toggle="pill" href="#pills-moderation" role="tab" aria-controls="pills-moderation" aria-selected="true">
                        На модерации
                        @if($array_count[0] > 0)
                        <i class="fa fa-exclamation-triangle text-warning" aria-hidden="true"></i>
                        @endif
                    </a>
                </li>
                @if(Auth::user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link" id="pills-chprice-tab" data-toggle="pill" href="#pills-chprice" role="tab" aria-controls="pills-chprice" aria-selected="false">
                            Изменена цена
                            @if($array_count[1] > 0)
                                <i class="fa fa-exclamation-triangle text-warning" aria-hidden="true"></i>
                            @endif
                        </a>
                    </li>
                @endif
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">

                    @include('adminAndModerator.moderation.product.index.layouts.filterFormAll')

                    <div class="products-container" style="position: relative;">
                        <div id="overlay-loader" class="table-overlay-loader" style="position: absolute">
                            <div id="loader"></div>
                        </div>
                        <div class="pills-all">
                            {!! $render_chprice_all !!}
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="pills-moderation" role="tabpanel" aria-labelledby="pills-moderation-tab">

                    @include('adminAndModerator.moderation.product.index.layouts.filterFormModer')

                    <div class="products-container" style="position: relative;">
                        <div id="overlay-loader" class="table-overlay-loader" style="position: absolute">
                            <div id="loader"></div>
                        </div>
                        <div class="pills-moderation">
                            {!! $render_moder_block !!}
                        </div>
                    </div>
                </div>
                @if(Auth::user()->isAdmin())
                    <div class="tab-pane fade" id="pills-chprice" role="tabpanel" aria-labelledby="pills-chprice-tab">
                    
                    @include('adminAndModerator.moderation.product.index.layouts.filterFormChprice')

                    <div class="products-container" style="position: relative;">
                        <div id="overlay-loader" class="table-overlay-loader" style="position: absolute">
                            <div id="loader"></div>
                        </div>
                        <div class="pills-chprice">
                            {!! $render_chprice_block !!}
                        </div>
                    </div>
                </div>
                @endif
            </div>


        </div>
    </div>

    <script>
        $('.container-fluid').on('click', '.pagination li a', function (e) {
            e.preventDefault();
            var inProgress = false;
            var url = $(this).attr('href');
            var type = $(this).parent().parent().parent('.products-pagination').data('type');

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
                        if(type == 1){
                            $('.pills-moderation').empty();
                            $('.pills-moderation').html(data);
                        }else if(type == 2){
                            $('.pills-chprice').empty();
                            $('.pills-chprice').html(data);
                        }else if(type == 3){
                            $('.pills-all').empty();
                            $('.pills-all').html(data);
                        }
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

        $('.search-products-moderator').on('keyup', function (e) {
            e.preventDefault();
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                return false;
            }
            var form = $(this).parents("form");
            var url = form.attr('action');
            var type = form.data('type');
            delay(function(){
                filterProductsModerator(form, url, type);
            }, 500 );
        });

        $('.search-products-moderator-c').on('change', function (e) {
            e.preventDefault();
            var form = $(this).parents("form");
            var url = form.attr('action');
            var type = form.data('type');
            filterProductsModerator(form, url, type);
        });

        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();

        function filterProductsModerator(form, url, type){
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
                        if(type == 1){
                            $('.pills-moderation').empty();
                            $('.pills-moderation').html(data);
                        }else if(type == 2){
                            $('.pills-chprice').empty();
                            $('.pills-chprice').html(data);
                        }else if(type == 3){
                            $('.pills-all').empty();
                            $('.pills-all').html(data);
                        }
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
