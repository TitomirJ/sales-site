@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/modules/checkbox.css') }}">
@endsection

@section('script1')
    <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="col-12 f30 mt-5 mb-5">
                <div class="text-uppercase blue-d-t">
                    отмененные заказы ({{ $orders_count }})
                </div>
            </div>

            <div class="table-responsive">
                <table class="table position-relative">
                    <thead>
                    <tr class="tb-head text-uppercase blue-d-t text-center">
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue border-left">
                                компания
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue">
                                №(дата)
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue">
                                наименование
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue">
                                причина(отказа)
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
                                клиент
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 radius-right dark-link border-top border-bottom border-right border-blue">
                                Действие
                            </div>
                        </th>
                    </tr>
                    </thead>

                    <tbody id="orders-place" class="table-bg">
                    @include('adminAndModerator.moderation.order.layouts.itemsOrders')
                    </tbody>

                </table>
            </div>


        </div>
    </div>
@endsection

@section('after_content')
    @include('adminAndModerator.moderation.order.layouts.modals')
@endsection

@section('script2')
    <script src="{{ asset('js/pages/admin/mod/ord/mod_ord.js') }}"></script>
@endsection

