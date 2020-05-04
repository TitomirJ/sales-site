@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/welcomeAdmin/welcome.css') }}">
@endsection

@section('content')

    <div class="content-wrapper wrapper-welcome">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-md-6 mt-5 mt-md-0">
                    <div class="d-flex justify-content-center">
                        <div class="position-relative main-block-header" style="z-index:1;filter: blur(.5px);">
                            <img src="{{asset('/public/images/welcome-notebook.png')}}" class="w-100 " alt="main">

{{--                            <img src="{{asset('/public/images/bg-image-min.png')}}" class="w-100 d-block d-md-none" alt="">--}}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
                    <h1 class="text-white">BIG SALES</h1> <br> <br>
                    <img class="position-absolute" src="{{asset('/public/images/line-welc.png')}}" alt="">
                    <h5 class="text-white">Вы всего в нескольких шагах <br>
                        от увеличения потока заявок в ваш бизнес</h5>
                </div>
            </div>

            <div class="row pb-5 mb-5">
                <div class="col-12 col-md-4 d-flex justify-content-center mt-5 mt-md-0">
                    <a class="btn-welcome btn text-white" href="{{asset('/company/reg')}}">Создать<br> компанию</a>
                </div>
                <div class="col-12 col-md-4 d-flex justify-content-center mt-5 mt-md-0">
                    <a class="btn-welcome btn text-white" href="{{asset('/company/products/create')}}">Добавить<br>товар</a>
                </div>
                <div class="col-12 col-md-4 d-flex justify-content-center mt-5 mt-md-0">
                    <a class="btn-welcome btn text-white" href="https://bigsales.pro/company/reg">Увеличение<br>продаж</a>
                </div>
            </div>

        </div>
    </div>

@endsection
