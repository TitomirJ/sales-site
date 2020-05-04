@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/modules/switchBtn.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modules/checkbox.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/product/productsMain.css') }}">
@endsection

@section('script1')

@endsection


@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
                <div class="text-uppercase blue-d-t">
                    Товары
                </div>

                <a href="#" class="d-flex align-items-center">
                    <div class="dark-bg border-radius shadow-custom text-white pl-4 pr-4 pt-1 pb-1 mr-2 f13">
                        инструкция по работе с товаром
                    </div>
                    <i class="fa fa-youtube-play mr-2 blue-d-t red-hover" aria-hidden="true" style="font-size: 30px;"></i>
                </a>
            </div>

            <div class="row">
                <div class="col-12">

                    <ul class="nav nav-pills flex-column flex-xl-row flex-nowrap nav-justified text-uppercase mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item products-tab ml-5 mr-5 border-bot radius-top-left radius-top-right">
                            <a class="nav-link rounded-0 dark-link active text-nowrap font-weight-bold" id="pills-all-products-tab" data-toggle="pill" href="#pills-all-products" role="tab" aria-controls="pills-all-products" aria-selected="true">Все товары</a>
                        </li>
                        <li class="nav-item products-tab ml-5 mr-5 border-bot radius-top-left radius-top-right">
                            <a class="nav-link rounded-0 dark-link text-nowrap font-weight-bold" id="pills-recomended-tab" data-toggle="pill" href="#pills-recomended" role="tab" aria-controls="pills-recomended" aria-selected="false">Не прошли модерацию
                                @if(count($products_nomoder) > 0)
                                    <span class="badge badge-pill badge-danger">{{ count($all_products_nomoder) }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item products-tab ml-5 mr-5 border-bot radius-top-left radius-top-right">
                            <a class="nav-link rounded-0 dark-link text-nowrap font-weight-bold" id="pills-no-available-tab" data-toggle="pill" href="#pills-no-available" role="tab" aria-controls="pills-no-available" aria-selected="false">Нет в наличии</a>
                        </li>
                        <li class="nav-item products-tab ml-5 mr-5 border-bot radius-top-left radius-top-right">
                            <a class="nav-link rounded-0 dark-link text-nowrap font-weight-bold" id="pills-deleted-tab" data-toggle="pill" href="#pills-deleted" role="tab" aria-controls="pills-deleted" aria-selected="false">Удаленные товары</a>
                        </li>
                    </ul>
                    @if(count($products_nomoder) > 0)
                        <div class="alert alert-warning" role="alert">
                            У вас есть товары которые не прошли модерацию
                        </div>
                    @endif


                    <div class="tab-content" id="pills-tabContent">

                        {{--Все товары--}}
                        <div class="tab-pane fade show active" id="pills-all-products" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="row">
                                <div class="col-12">
                                    Всего товаров: {{ $count_products[0][0] }}, на странице: {{ $count_products[0][1] }}
                                </div>
                            </div>
                            <div class="table-responsive scroll_wrap">
                                <table class="table position-relative scroll_me">
                                    <thead>
                                    <tr class="tb-head text-uppercase blue-d-t text-center">
                                        <th colspan="7" scope="col">
                                            <div class="d-flex p-2 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link">
                                                {{--<form action="{{ asset('company/products/create') }}" method="GET">--}}
                                                {{--<button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 h-100 ml-2 mr-2">Добавить</button>--}}
                                                {{--</form>--}}
                                                {{--<form action="{{ asset('company/externals') }}" method="GET">--}}
                                                {{--<button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 h-100 ml-2 mr-2">импортировать</button>--}}
                                                {{--</form>--}}
                                                <div class="dropdown">
                                                    <button class="btn square_btn shadow-custom text-uppercase border-radius-50 ml-2 mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        добавить
                                                    </button>
                                                    <div class="dropdown-menu border-radius border-0 shadow-custom" aria-labelledby="dropdownMenuButton" style="text-transform: none!important">
                                                        <a class="dropdown-item font-weight-bold drop-menu-actions" href="{{ asset('company/products/create') }}">Создать товар</a>
                                                        <a class="dropdown-item font-weight-bold drop-menu-actions" href="{{ asset('company/externals') }}">Импортировать товары (XML/YML)</a>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn square_btn btn-light bg-white shadow-custom text-uppercase border-radius-50 ml-2 mr-2 group-products-change-button" form="action-form-all-product" data-action="avail_to_not_avail">Нет в наличии</button>
                                                <button type="submit" class="btn square_btn btn-light bg-white shadow-custom text-uppercase border-radius-50 ml-2 mr-2 group-products-change-button" form="action-form-all-product" data-action="group_product_from_all_products_delete">удалить</button>



                                            </div>
                                        </th>
                                        <th scope="col">
                                            <div class="d-block p-2 radius-top-right border-top border-bottom border-right border-blue text-nowrap h-60">
                                            @include("provider.company.product.layouts.layouts.pagSelectProduct")

                                            <!-- новый селект без функционала -->


                                                <!-- новый селект без функционала -->
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <thead>
                                    <tr class="tb-head text-uppercase blue-d-t text-center">
                                        <th colspan="8" scope="col">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5>Выберите фильтры:</h5>
                                                </div>
                                            </div>
                                            <div class="d-flex p-2 border-left border-top border-right border-bottom border-blue text-nowrap dark-link">

                                                <form action="{{ asset('company/filter/products/1') }}" method="GET" data-type="1" id="filter-all-products"></form>

                                                <input type="hidden" name="type" value="1" form="filter-all-products">
                                                <input type="text" name="code_like_persent" class="w-100 p-1 mb-1 noscroll quantity action-filter-product" placeholder="Артикул товара" form="filter-all-products">


                                                <input type="text" name="name_like_persent" class="w-100 p-1 mb-1 action-filter-product" placeholder="Название товара" form="filter-all-products">


                                                <select name="subcategory_id" id="" class="filter-select2 mb-1 action-filter-product-c" form="filter-all-products">
                                                    <option value="all">Все категории</option>
                                                    @foreach($array_subcats as $key => $velue)
                                                        <option value="{{ $key }}">{{ $velue }}</option>
                                                    @endforeach
                                                </select>
                                                <select name="status_moderation_equally" id="" class="filter-select2 mb-1 action-filter-product-c" form="filter-all-products">
                                                    <option value="all">Все статусы</option>
                                                    <option value="0">На модерации</option>
                                                    <option value="1">Отправлен на маркетплейс</option>
                                                    <option value="2">Невалидный контент</option>
                                                    <option value="3">Заблокированый товар</option>
                                                    <option value="deleted">Удален</option>
                                                </select>


                                                <input type="number" step="any" min="0" name="price_like" class="w-100 p-1 mb-1 noscroll action-filter-product" placeholder="Цена" form="filter-all-products">


                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="table-all-product" class="table-bg">
                                    {!! $render_products !!}
                                    </tbody>
                                </table>
                            </div>

                            <form action="{{ asset('company/products/group/actions') }}" id="action-form-all-product" method="POST" type-page="all" data-url="{{ asset('/company/products') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="type" value="1">
                                <input type="hidden" name="action" value="false">
                            </form>
                        </div>

                        {{--не прошли модерацию--}}
                        <div class="tab-pane fade" id="pills-recomended" role="tabpanel" aria-labelledby="pills-profile-tab">

                            <div class="row">
                                <div class="col-12">
                                    Всего товаров: {{ $count_products[1][0] }}, на странице: {{ $count_products[1][1] }}
                                </div>
                            </div>
                            <div class="table-responsive scroll_wrap">
                                <table class="table position-relative scroll_me">
                                    <thead>
                                    <tr class="tb-head text-uppercase blue-d-t text-center">
                                        <th colspan="6" scope="col">
                                            <div class="d-flex p-2 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link h-60">

                                            </div>
                                        </th>
                                        <th scope="col">
                                            <div class="d-block p-2 radius-top-right border-top border-bottom border-right border-blue text-nowrap h-60">
                                                @include("provider.company.product.layouts.layouts.pagSelectProduct")
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>


                                    <tbody id="all-recomended" class="table-bg">
                                    @include("provider.company.product.layouts.recomended")
                                    </tbody>

                                </table>
                            </div>


                        </div>

                        {{--нет в наличии--}}
                        <div class="tab-pane fade" id="pills-no-available" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <div class="row">
                                <div class="col-12">
                                    Всего товаров: {{ $count_products[2][0] }}, на странице: {{ $count_products[2][1] }}
                                </div>
                            </div>
                            <div class="table-responsive scroll_wrap">
                                <table class="table position-relative scroll_me">
                                    <thead>
                                    <tr class="tb-head text-uppercase blue-d-t text-center">
                                        <th colspan="7" scope="col">
                                            <div class="d-flex p-2 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link">
                                                <div class="dropdown">
                                                    <button class="btn square_btn shadow-custom text-uppercase border-radius-50 ml-2 mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        добавить
                                                    </button>
                                                    <div class="dropdown-menu border-radius border-0 text-lowercase shadow-custom" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item font-weight-bold drop-menu-actions" href="{{ asset('company/products/create') }}">создать товар</a>
                                                        <a class="dropdown-item font-weight-bold drop-menu-actions" href="{{ asset('company/externals') }}">импортировать товары</a>
                                                    </div>
                                                </div>
                                                <form action="{{ asset('company/products/create') }}" method="GET">
                                                    <button type="submit" class="btn  square_btn shadow-custom text-uppercase border-radius-50 ml-2 mr-2 group-products-change-button" form="action-form-not-avil-product" data-action="group_product_from_not_avail_products_to_avail">в наличии</button>
                                                    <button type="submit" class="btn  square_btn shadow-custom text-uppercase border-radius-50 ml-2 mr-2 group-products-change-button" form="action-form-not-avil-product" data-action="group_product_from_not_avail_products_delete">удалить</button>
                                                </form>

                                            </div>
                                        </th>
                                        <th scope="col">
                                            <div class="d-block p-2 radius-top-right border-top border-bottom border-right border-blue text-nowrap h-60">
                                                @include("provider.company.product.layouts.layouts.pagSelectProduct")
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>


                                    <tbody id="table-not-avil-product" class="table-bg">
                                    {!! $render_not_av_products !!}
                                    </tbody>

                                </table>
                            </div>
                            <form action="{{ asset('company/products/group/actions') }}" id="action-form-not-avil-product" method="POST" type-page="not-avail" data-url="{{ asset('/company/products') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="type" value="3">
                                <input type="hidden" name="action" value="false">
                            </form>
                        </div>

                        {{--Удаленные товары--}}
                        <div class="tab-pane fade" id="pills-deleted" role="tabpanel" aria-labelledby="pills-deleted-tab">

                            <div class="row">
                                <div class="col-12">
                                    Всего товаров: {{ $count_products[3][0] }}, на странице: {{ $count_products[3][1] }}
                                </div>
                            </div>
                            <div class="table-responsive scroll_wrap">
                                <table class="table position-relative scroll_me">
                                    <thead>
                                    <tr class="tb-head text-uppercase blue-d-t text-center">
                                        <th colspan="7" scope="col">
                                            <div class="d-flex p-2 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link">
                                                {{--<div class="dropdown">--}}
                                                {{--<button class="btn square_btn shadow-custom text-uppercase border-radius-50 ml-2 mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                                {{--добавить--}}
                                                {{--</button>--}}
                                                {{--<div class="dropdown-menu border-radius border-0 text-lowercase shadow-custom" aria-labelledby="dropdownMenuButton">--}}
                                                {{--<a class="dropdown-item font-weight-bold drop-menu-actions" href="{{ asset('company/products/create') }}">создать товар</a>--}}
                                                {{--<a class="dropdown-item font-weight-bold drop-menu-actions" href="{{ asset('company/externals') }}">импортировать товары</a>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                <form action="{{ asset('company/products/create') }}" method="GET">
                                                    <button type="button" class="btn square_btn shadow-custom text-uppercase border-radius-50 ml-2 mr-2 group-products-change-button" form="action-form-deleted-product" data-action="group_deleted_product_to_restore">Востановить</button>
                                                </form>
                                            </div>
                                        </th>
                                        <th scope="col">
                                            <div class="d-block p-2 radius-top-right border-top border-bottom border-right border-blue text-nowrap h-60">
                                                @include("provider.company.product.layouts.layouts.pagSelectProduct")
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody id="table-deleted-product" class="table-bg">
                                    {!! $render_deleted_products !!}
                                    </tbody>

                                </table>
                            </div>
                            <form action="{{ asset('company/products/group/actions') }}" id="action-form-deleted-product" method="POST" type-page="deleted" data-url="{{ asset('/company/products') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="type" value="4">
                                <input type="hidden" name="action" value="false">
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('provider.company.modals.editProductModal')

@endsection

@section('script2')
    <script src="{{ asset('js/pages/provider/product/index_p.js') }}"></script>
@endsection
