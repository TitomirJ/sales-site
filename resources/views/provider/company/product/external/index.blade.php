@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/product/productsMain.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
                <div class="text-uppercase blue-d-t">
                    Обновление цены и наличия товара
                </div>

                <div class="d-flex align-items-center instruction">
                    <div class="dark-bg border-radius shadow-custom text-white pl-4 pr-4 pt-1 pb-1 mr-2 f13">
                        инструкция по <a href="{{asset('pdf/8. Update products.pdf')}}" target="_blank">Обновлению товаров</a>
                    </div>
                </div>
            </div>

            <div class="row mt-5 mb-5">

                <div class="col-12 mt-3 mb-3 border-radius p-1 pl-2 pr-2 shadow-custom">
                    <h4 class="w-100 text-center">Загрузить файл Excel</h4>
                     <form action="{{ asset('/company/update/products') }}" method="post" enctype="multipart/form-data" id="upproform">
                        {{ csrf_field() }}
                        <div class="group d-flex flex-wrap">
                            <input type="hidden" name="company_id" value="{{$company->id}}">
                        <input class="file btn btn-warning" type="file" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        <div class="box_logistor d-flex">
                            <label for="autoavailable" class=" btn btn-info m-2" id="logister_btn">Логистер выключен</label>
                        <input type="checkbox" id="autoavailable" name="logistor" style="display:none" autocomplete="off">
                       
                        </div>
                        <button class="btn btn-success ml-3" type="submit" id="up-pro-submit">Отправить</button>
                        </div>
                    </form>
                </div>

            </div>
            <div class="row" id="ext-prod-stat">
                @if($company->externalProduct != null)
                    @include('provider.company.product.external.layouts.statistic', ['externalProduct' => $company->externalProduct])
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script2')
    <script src="{{ asset('js/pages/provider/product/update_products.js') }}"></script>
@endsection