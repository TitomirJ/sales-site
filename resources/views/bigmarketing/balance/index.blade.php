@extends('admin.layouts.app')

@section('stylesheets')
    @parent

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
                <div class="text-uppercase blue-d-t">
                    История транзакций BigMarketing <i class="fa fa-history text-primary ml-2" aria-hidden="true"></i>
                </div>
                <div>
                    Здравствуй, {{Auth::user()->name}}!<i class="fa fa-hand-peace-o ml-2" aria-hidden="true"></i>
                </div>
            </div>
            <div class="row mt-3">
                    <div class="col-12">

                        <div class="table-responsive scroll_wrap">

                            <table class="table position-relative scroll_me">

                                <thead>
                                <tr class="tb-head text-uppercase blue-d-t text-center">
                                    <th scope="col" class="h-60">
                                        <div class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link text-nowrap">
                                            дата
                                        </div>
                                    </th>
                                    <th scope="col" class="h-60">
                                        <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                                            ФИО
                                        </div>
                                    </th>
                                    <th scope="col" class="h-60">
                                        <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                                            Эл. адрес
                                        </div>
                                    </th>
                                    <th scope="col" class="h-60">
                                        <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                                            Телефон
                                        </div>
                                    </th>
                                    <th scope="col" class="h-60">
                                        <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                            сумма
                                        </div>
                                    </th>
                                    <th scope="col" class="h-60">
                                        <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                            валюта
                                        </div>
                                    </th>
                                    <th scope="col" class="h-60">
                                        <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap radius-top-right border-right">
                                            Назначение
                                        </div>
                                    </th>
                                </tr>
                                </thead>

                                <tbody class="table-bg">
                                @foreach($bm_transactions as $t)

                                    <tr class="text-center bor-bottom">
                                        <td class="font-weight-bold border-left">
                                            {{(new Date($t->created_at))->format('j F Y (H:i)')}}
                                        </td>
                                        <td class="font-weight-bold">
                                            {{ $t->name.' '.$t->surname }}
                                        </td>
                                        <td class="font-weight-bold">
                                            {{ $t->email }}
                                        </td>
                                        <td class="font-weight-bold">
                                            {{ $t->phone }}
                                        </td>
                                        <td class="font-weight-bold">
                                            {{ $t->amount.' '.$t->currency->short_name }}
                                        </td>
                                        <td class="font-weight-bold">
                                            {{ $t->currency->code }}
                                        </td>
                                        <td class="font-weight-bold border-right" style="width: 400px;">
                                            {{ $t->description }}
                                        </td>
                                    </tr>

                                @endforeach
                                <tr class="text-center bor-bottom">
                                    <td colspan="7" class="font-weight-bold">
                                        {{ $bm_transactions->links() }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script2')

@endsection
