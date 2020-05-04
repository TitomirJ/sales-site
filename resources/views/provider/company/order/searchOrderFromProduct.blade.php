@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/orders/orders.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
                <div class="text-uppercase blue-d-t">
                    Заказы по ({{$check_product->name}})
                </div>

                <a href="#" class="d-flex align-items-center">
                    <div class="dark-bg border-radius shadow-custom text-white pl-4 pr-4 pt-1 pb-1 mr-2 f13">
                        инструкция по работе с заказами
                    </div>
                    <i class="fa fa-youtube-play mr-2 blue-d-t red-hover" aria-hidden="true" style="font-size: 30px;"></i>
                </a>
            </div>


            <div class="subtab d-flex flex-column flex-sm-row justify-content-between align-items-center font-weight-bold text-uppercase blue-d-t p-2">
                <div class="ml-md-5">
                    {{'Все заказы: '. $orders_count}}
                </div>

                <div class="dropdown">
                    <button class="btn dropdown-toggle text-uppercase trans-bg font-weight-bold" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        посмотреть <i class="fa fa-angle-down ml-2" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu border-radius border-0 shadow-custom" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item drop-menu-actions pr-orders-pagin-ch" href="{{ asset('/company/orders') }}" data-sort="10">10</a>
                        <a class="dropdown-item drop-menu-actions pr-orders-pagin-ch" href="{{ asset('/company/orders') }}" data-sort="100">100</a>
                    </div>
                </div>

            </div>

            <table class="table table-responsive-xl position-relative">
                <thead>
                    <tr class="tb-head text-uppercase blue-d-t text-center">
                        <th scope="col" class="h-60">
                            <a href="#" class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link">
                                <div class="d-flex align-items-center order-hovered-date">
                                    <span class="" style="">№ заказа/дата</span>
                                    <i class="fa fa-angle-down ml-2" aria-hidden="true"></i>
                                </div>

                                <input type="text" class="datepicker-here d-none dark-bg shadow-custom-inset shadow-custom border-radius data-input text-white pl-1" name="q" style="border-radius: 10px; display: none; background: gray; color:white; height: 23px; width: 165px; font-size: 14px;" autofocus/>
                            </a>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue">
                                название
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link">

                                <div class="dropdown">
                                    <button class="btn-trans dropdown-toggle d-flex align-items-center font-weight-bold text-uppercase" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        маркетплейс <i class="fa fa-angle-down ml-2" aria-hidden="true"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-cust border-radius border-0 text-capitalize shadow-custom" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ asset('/company/orders') }}" class="dropdown-item font-weight-bold drop-menu-actions orders-market-sort" data-sort="all">
                                            Все
                                        </a>
                                        @foreach($marketplaces as $m)
                                            <a class="dropdown-item font-weight-bold drop-menu-actions orders-market-sort" href="{{ asset('/company/orders') }}" data-sort="{{ $m->id }}">
                                                {{$m->name}}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block h-100 p-3 border-top border-bottom border-blue">
                                сумма
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block h-100 p-3 border-top border-bottom border-blue">
                                комиссия
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block h-100 p-3 border-top border-bottom border-blue">
                                клиент
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block h-100 p-3 border-top border-bottom border-blue radius-top-right border-right">
                                <div class="dropdown">
                                    <button class="btn-trans dropdown-toggle d-flex align-items-center font-weight-bold text-uppercase" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        статус <i class="fa fa-angle-down ml-2" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-cust border-radius border-0 text-lowercase shadow-custom" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ asset('/company/orders') }}" class="dropdown-item font-weight-bold drop-menu-actions order-status-sort" data-sort="all">
                                            Все
                                        </a>
                                        <a class="dropdown-item font-weight-bold drop-menu-actions order-status-sort" href="{{ asset('/company/orders') }}" data-sort="0">
                                            <i class="fa fa-shopping-basket text-muted" aria-hidden="true"></i>
                                            новый
                                        </a>
                                        <a class="dropdown-item font-weight-bold drop-menu-actions order-status-sort" href="{{ asset('/company/orders') }}" data-sort="4">
                                            <i class="fa fa-shopping-basket text-warning" aria-hidden="true"></i>
                                            проверен
                                        </a>
                                        <a class="dropdown-item font-weight-bold drop-menu-actions order-status-sort" href="{{ asset('/company/orders') }}" data-sort="3">
                                            <i class="fa fa-shopping-basket text-primary" aria-hidden="true"></i>
                                            отправлен
                                        </a>
                                        <a class="dropdown-item font-weight-bold drop-menu-actions order-status-sort" href="{{ asset('/company/orders') }}" data-sort="1">
                                            <i class="fa fa-shopping-basket green-text" aria-hidden="true"></i>
                                            выполнен
                                        </a>
                                        <a class="dropdown-item font-weight-bold drop-menu-actions order-status-sort" href="{{ asset('/company/orders') }}" data-sort="2">
                                            <i class="fa fa-shopping-basket text-danger" aria-hidden="true"></i>
                                            отменен
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody id="orders-place" class="table-bg">
                @include('provider.company.order.layouts.ordersItems')
                </tbody>

            </table>

            <br>

        </div>
    </div>
    <?//modals?>
    <div class="modal fade" id="add-ttn-and-status" tabindex="-1" role="dialog" aria-labelledby="add-ttn-and-status" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add-ttn-and-status-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-order-ttn-form">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script2')
    @include('provider.company.order.layouts.orderScript2')
@endsection
