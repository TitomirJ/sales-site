@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/brief/brief.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
                <div class="text-uppercase blue-d-t">
                    Сводка
                </div>

                <div class="d-flex align-items-end flex-column">
                    <div class="d-flex align-items-center instruction">
                        <div class="dark-bg border-radius shadow-custom text-white pl-4 pr-4 pt-1 pb-1 f13">
                            инструкция по <a href="{{asset('pdf/7.Personal.pdf')}}" target="_blank">работе с сотрудниками компании</a>
                        </div>
                    </div>
                    <form action="{{ asset('/company') }}" id="brife-search" method="GET">
                        <input type="text" class="datepicker-here caret-color data-input shadow-custom-inset dark-bg border-radius pl-2 text-white f20" placeholder="Выберите период" name="date" autocomplete="off" />
                    </form>
                </div>
            </div>

            <div class="row">

              <div class="d-flex justify-content-around w-100 mb-5 pb-5 position-relative">
                  
                <div class="position-relative z-index-10">
                  <div class="breif-item circle circle-1 circle-bg-blue-dark rounded-circle d-flex align-items-center justify-content-center f36 text-shadow"><span class="brife-orders text-white">{{ $count_orders }}</span></div>
                </div>

                <div class="decoration-wrapper decoration-left position-absolute">
                  <div class="clip-block-top decoration-clip rounded-circle z-index-10 position-relative"></div>

                  <div class="main-block-decoration main-block-decoration-left"></div>

                  <div class="clip-block-bottom decoration-clip rounded-circle z-index-10 position-relative"></div>
                </div>

                <div class="position-relative z-index-10">
                  <div class="breif-item circle circle-2 circle-bg-blue-lighter rounded-circle d-flex align-items-center justify-content-center f36 text-shadow brife-sum">{{ $sum_ended_orders }}</div>
                </div>

                <div class="decoration-wrapper decoration-right position-absolute">
                  <div class="clip-block-top decoration-clip rounded-circle z-index-10 position-relative"></div>

                  <div class="main-block-decoration main-block-decoration-right"></div>

                  <div class="clip-block-bottom decoration-clip rounded-circle z-index-10 position-relative"></div>
                </div>

                <div class="position-relative z-index-10">
                  <div class="breif-item circle circle-3 circle-bg-blue-light rounded-circle d-flex align-items-center justify-content-center f36 text-shadow"><span class="brife-deleted text-white">{{ $count_deleted_orders }}</span></div>
                </div>

              </div>
            </div>


            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="row">
                        <div class="col-12 col-md-6" id="pieChart">
                            @include('provider.company.brief.layouts.pieChart')
                        </div>
                        <div class="col-12 col-md-6 mt-3 m-md-0" id="statisticBlock">
                            @include('provider.company.brief.layouts.statisticBlock')
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 mt-3 mt-xl-0" id="personnelBlock">
                    @include('provider.company.brief.layouts.personnelBlock')
                </div>
                <div class="col-12 mt-3">
                    @include('provider.company.brief.layouts.products')
                </div>
            </div>

        </div>
    </div>

    
    @include('provider.company.brief.layouts.scriptAnimate')

    @include('provider.company.brief.layouts.script')

@endsection
