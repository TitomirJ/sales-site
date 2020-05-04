@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{asset('/css/pages/admin/externals/externals.css')}}">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-4">
                <div class="text-uppercase blue-d-t">
                    XML Товары
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">

                    <div class="xml-item completed-orders border-radius orders-bg-dark-blue shadow-custom text-center mr-1 p-3 w-100">
                        <div class="completed-orders text-left f10 font-weight-bold text-uppercase">
                            не подготовленные ссылки
                        </div>
                        <div class="completed-order f72 text-white text-shadow">
                            <a href="{{ asset('admin/prom/externals') }}">{{ $not_upload_external_count }}</a>
                        </div>
                    </div>

                </div>


                <div class="col-12 col-md-6">

                    <div class="xml-item new-orders border-radius orders-bg-light-blue shadow-custom text-center w-100 p-3 w-100">
                        <div class="new-orders-title text-left f10 font-weight-bold text-uppercase">Не добаленные YML товары</div>
                        <div class="new-orders-count f72 text-white text-shadow">
                            <a href="{{ asset('admin/prom/products') }}">{{$count_products}}</a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center mt-5 mb-5">
                <div class="text-uppercase blue-d-t f20 w-100 text-center">
                    YML ссылки и файлы компаний
                </div>
            </div>

            <div class="table-responsive">
                <table class="table position-relative table-prom-externals">
                    <thead>
                    <tr class="tb-head text-uppercase blue-d-t text-center">
                        <th scope="col" class="h-60">
                            <div class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link text-nowrap">
                                id - файла
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                компания(id)
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                ссылка
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                статус
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap radius-top-right border-right">
                                создан
                            </div>
                        </th>

                    </tr>
                    </thead>

                    <tbody id="externals-place" class="table-bg">
                    @forelse($extenals as $ex)
                        <tr class="text-center">
                            <td>
                                {{ $ex->id }}
                            </td>
                            <td>
                                <a href="{{ asset('/admin/company/'.$ex -> company_id) }}">{{ $ex -> company -> name.' ('.$ex -> company_id.')' }}</a>
                            </td>
                            <td>
                                <a href="{{ $ex->unload_url  }}" target="_blank">ссылка</a>
                            </td>
                            <td>
                                @if($ex->is_unload == '0')
                                    <span class="text-danger">Не подготовлен</span>
                                @elseif($ex->is_unload == '2')
                                    <span class="text-warning">В работе</span>
                                @elseif($ex->is_unload == '1')
                                    <span class="text-success">Подготовлен</span>
                                @endif
                            </td>
                            <td>
                                {{ $ex->created_at }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Нет данных</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $extenals->links() }}
            </div>






        </div>
    </div>





    {{--@include('admin.prom.category.layouts.modals')--}}

@endsection

@section('script2')

@endsection

