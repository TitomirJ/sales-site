@extends('provider.company.layouts.app')

@section('stylesheets')
@parent
<link rel="stylesheet" href="{{ asset('css/pages/orders/orders.css') }}">
@endsection

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
            <div class="text-uppercase blue-d-t" id="test-new">
                Заказы
            </div>

            <div class="d-flex align-items-center instruction">
                <div class="dark-bg border-radius shadow-custom text-white pl-4 pr-4 pt-1 pb-1 mr-2 f13">
                    инструкция по <a href="{{asset('pdf/5.Work with orders.pdf')}}" target="_blank">работе с заказами</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h5>Выберите фильтры:</h5>
            </div>
        </div>

        <div class="row">
            <form action="{{ asset('company/filter/orders') }}" id="filter-orders"></form>
            <div class="col-12 col-md-4">
                <input type="number" name="order_id_equally" step="1" min="0" class="w-100 p-1 mb-1 noscroll quantity action-filter-company" placeholder="Номер заказа" form="filter-orders">
            </div>

            <div class="col-12 col-md-4">
                <input type="text" name="order_dpk_interval_create" class="w-100 p-1 mb-1 dpk-order" placeholder="Выберите даты" form="filter-orders">
            </div>

            <div class="col-12 col-md-4">
                <input type="text" name="name_like_percent" class="w-100 p-1 mb-1 action-filter-company" placeholder="Наименование товара" form="filter-orders">
            </div>

            <div class="col-12 col-md-4">
                <input type="number" name="total_sum_equally" step="any" min="0" class="w-100 p-1 mb-1 noscroll quantity action-filter-company" placeholder="Сумма" form="filter-orders">
            </div>

            <div class="col-12 col-md-4">
                <input type="text" name="customer_name_like_percent"  class="w-100 p-1 mb-1 action-filter-company" placeholder="ФИО заказчика" form="filter-orders">
            </div>

            <div class="col-12 col-md-4">
                <input type="text" name="customer_email_like_percent" class="w-100 p-1 mb-1 action-filter-company" placeholder="Почта заказчика" form="filter-orders">
            </div>

            <div class="col-12 col-md-4">
                <input type="text" name="customer_phone_like_percent" class="w-100 p-1 mb-1 action-filter-company" placeholder="Телефон заказчика" form="filter-orders">
            </div>

            <div class="col-12 col-md-4">
                <select name="marketplace_id_equally" class="filter-select2 mb-1 action-filter-ch-company" form="filter-orders">
                    <option value="all">Все маркетплейсы</option>
                    @foreach($marketplaces as $marketplace)
                    @if($marketplace->status == '1')
                    <option value="{{ $marketplace->id }}">{{ $marketplace->name }}</option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-4">
                <select name="status_equally" class="filter-select2 mb-1 action-filter-ch-company" form="filter-orders">
                    <option value="all">Все статусы</option>
                    <option value="0">Новый</option>
                    <option value="4">Проверен</option>
                    <option value="3">Отправлен</option>
                    <option value="1">Выполнен</option>
                    <option value="2">Отменен</option>
                </select>
            </div>

        </div>

        {{-- Header of table--}}
        <div class="subtab d-flex flex-column flex-sm-row justify-content-between align-items-center font-weight-bold text-uppercase blue-d-t p-2">
            <div class="ml-md-5 ">
                <span>Все заказы: <span id="in-count-ord">{{$orders_count}}</span></span>
            </div>

            <div class="d-flex align-items-center">
                <div>Посмотреть</div>
                <label class="m-0" style="width: 100px;">
                    <select class="pr-3 text-uppercase filter-select2 action-filter-ch-company" name="p_ord_index" form="filter-orders">
                        <option value="100" @if($pagination == 100) selected  @endif>100</option>
                        <option value="10" @if($pagination == 10) selected  @endif>10</option>
                    </select>
                </label>
            </div>

        </div>
        <div style="position: relative;">
            <div id="overlay-loader" class="table-overlay-loader" style="position: absolute">
                <div id="loader"></div>
            </div>
            <table class="table table-responsive-xl position-relative">
                <thead>
                <tr class="tb-head text-uppercase blue-d-t text-center">
                    <th scope="col" class="h-60">
                        <div class="d-block p-3 h-100 border-top border-bottom border-left border-blue radius-top-left">
                            № заказа/дата
                        </div>
                    </th>
                    <th scope="col" class="h-60">
                        <div class="d-block p-3 h-100 border-top border-bottom border-blue">
                            артикул
                        </div>
                    </th>
                    <th scope="col" class="h-60">
                        <div class="d-block p-3 h-100 border-top border-bottom border-blue">
                            название
                        </div>
                    </th>
                    <th scope="col" class="h-60">
                        <div class="d-block p-3 h-100 border-top border-bottom border-blue">
                            маркетплейс
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
                            статус
                        </div>
                    </th>
                </tr>
                </thead>

                <tbody id="orders-place" class="table-bg">
                @include('provider.company.order.index.layouts.ordersItems')
                </tbody>

            </table>
        </div>
        <br>

    </div>
</div>
<?//modals?>
<div class="modal fade" id="change-status-order-modal" tabindex="-1" role="dialog" aria-labelledby="add-ttn-and-status" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title w-100 text-center text-white" id="change-status-order-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="change-status-order-modal-body"></div>
        </div>
    </div>
</div>

@endsection

@section('script2')
{{--@include('provider.company.order.layouts.orderScript2')--}}
<? $random_num = rand ( 1111111, 9999999 );?>
<script src="{{ asset('/js/pages/provider/order/ord_index.js?v='.$random_num) }}"></script>
@endsection
