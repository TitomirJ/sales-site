@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/admin/companies/company.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
                <div class="text-uppercase blue-d-t">
                    Нарушения на расмотрении
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
                                        компания
                                    </div>
                                </th>
                                <th scope="col" class="h-60">
                                    <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                        ответственый
                                    </div>
                                </th>
                                <th scope="col" class="h-60">
                                    <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                        вид нарушения
                                    </div>
                                </th>
                                <th scope="col" class="h-60">
                                    <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                        обьект нарушения
                                    </div>
                                </th>

                                <th scope="col" class="h-60">
                                    <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                        инспектировал
                                    </div>
                                </th>
                                <th scope="col" class="h-60">
                                    <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap radius-top-right border-right">
                                        действия
                                    </div>
                                </th>
                            </tr>
                            </thead>

                            <tbody id="orders-place" class="table-bg">
                            @foreach($warnings as $warning)
                                <tr class="text-center bor-bottom block-com-class-{{$warning->company->id}} block-war-class-{{$warning->id}}">
                                    <td class="font-weight-bold border-left">
                                        <a href="{{ asset('admin/company/'.$warning->company->id) }}">{{ $warning->company->name }}</a>
                                    </td>
                                    <td class="font-weight-bold">
                                        {{ $warning->company->responsible }}<br>
                                        тел. {{ $warning->company->responsible_phone }}
                                    </td>
                                    <td class="font-weight-bold">
                                        @if($warning->type_warning == '0')
                                            <?
                                            $text_error = json_decode($warning->product->data_error);
                                            ?>
                                            Замечание к товару<br>
                                            ({{ $text_error->short_error }})
                                        @elseif($warning->type_warning == '1')
                                            <?
                                            $text_error = json_decode($warning->order->data_error);
                                            ?>
                                            Замечание к заказу<br>
                                            ({{ $text_error->short_error }})
                                        @endif
                                    </td>
                                    <td class="font-weight-bold">
                                        @if($warning->type_warning == '0')
                                            <a href="{{ asset('admin/moderation/products/'.$warning->product_id) }}">{{ $warning->product->name }}</a>
                                        @elseif($warning->type_warning == '1')
                                            <a href="{{ asset('admin/moderation/orders/'.$warning->order_id) }}">Замечание к заказу # {{ $warning->order->id }}</a>
                                        @endif
                                    </td>
                                    <td class="font-weight-bold">
                                        {{ $warning->inspector->getFullName() }}<br>
                                        тел. {{ $warning->inspector->phone }}
                                    </td>
                                    <td class="font-weight-bold border-right">
                                        @include('admin.company.layouts.warningCompany.actionButtons')
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>

                    </div>
                    {{$warnings->links()}}
                </div>
            </div>

        </div>
    </div>
    @include('admin.company.layouts.warningCompany.modals')
@endsection

@section('script2')
    <script src="{{ asset('js/pages/admin/mod/com/mod_com.js') }}"></script>
@endsection