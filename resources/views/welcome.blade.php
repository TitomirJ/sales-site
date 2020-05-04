@extends('layouts.app')

@section('content')
    <section>
        <div class="container mt-3">
            <div class="row pb-2">
                <div class="col-12 m-auto">
                    {{-- HEADER --}}
                    <div class="header d-flex justify-content-around align-items-center flex-column text-center text-secondary pb-4">

                        <h1>
                            Управление товарами и заказами на торговых площадках<br>
                            через единый кабинет для продавца
                        </h1>

                        <div class="img-wrapper mt-3 mb-3">
                            <img class="img-header rounded mx-auto d-block w-50" src="{{asset('/public/images/header.png')}}" alt="торговые площадки big sales">
                        </div>

                        <p class="font-s1">
                            Настрой интеграцию с ведущими маркетплейсами Украины в один клик
                        </p>

                        <a class="btn-custom btn btn-primary text-white text-uppercase font-weight-light" href="{{ asset('/company/reg') }}">ПОПРОБОВАТЬ</a>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="img-side position-relative">
        <img class="position-absolute bg-gray d-none d-lg-block" src="{{asset('/images/bg_gray.png')}}" alt="background">
    </div>


    <section class="after-reg scroll1-item">
        <div class="container">
            {{-- VIDEO PRESENTATION--}}
            <div class="row pt-2 pb-2 text-secondary">

                <div class="col-12">
                    <h2 class="mt-5 mb-5 text-center font-s2">После регистрации Вы получите</h2>
                </div>

                <div class="col-sm-12 col-md-6 order-2 order-sm-2 order-md-1 d-flex justify-content-center align-items-center">
                    <div class="video-wrapper">

                        <img class="position-absolute w-100" src="{{asset('/public/images/nout4.png')}}" alt="интеграция с маркетплейсами">

                        {{--youtube video--}}

                        <div class="video-block position-absolute">
                            <div class="embed-responsive embed-responsive-16by9">
                                <!-- <iframe width="100%" height="100%" class="embed-responsive-item" src="https://www.youtube.com/embed/QHwFcFxuTeg" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe> -->
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-12 col-md-6 order-1 order-sm-1 order-md-2 d-flex flex-column justify-content-center align-items-center pt-3 font-weight-normal">
                    <ul class="mt-3 font-s2">
                        <li class="bonus mb-3">Доступ в личный кабинет<br>с возможностью размещения товара на крупных товарных площадках</li>
                        <li class="bonus mb-3">Пошаговое обучение<br> и индивидуальную поддержку</li>
                        <li class="bonus mb-3">Возможность получать<br> и обрабатывать заказы<br> с   маркетплейсов</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <div class="img-side position-relative">
        <img class="position-absolute headphones d-none d-lg-block" src="{{asset('/images/gape.png')}}" alt="товары">
        <img class="position-absolute electronics d-none d-lg-block" src="{{asset('/images/electronics.png')}}" alt="електроника продажи">
    </div>

    <section class="advantages mt-5">
        <div class="container mt-5">

            {{-- ПЕРИМУЩЕСТВА --}}

            <div class="items row pt-2 pb-2">
                <div class="col-md-12 col-lg-4 d-flex justify-content-center align-items-center">
                    <div class="item item-change item-cirlce text-center text-white d-flex justify-content-center align-items-center flex-column p-4">
                        <div class="item-title font-weight-bold mb-2">
                            38 %<br>
                            Ежегодый рост
                        </div>
                        <div class="item-content">
                            Согласно исследованию Marketing Ukraine, продавцы, которые используют больше 5-ти торговых площадок, увеличили продажи почти в 2 раза
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 d-flex justify-content-center align-items-center">
                    <div class="item text-center text-secondary d-flex justify-content-center align-items-center flex-column p-4">
                        <div class="item-title font-weight-bold mb-2">
                            Высокий охват<br>вашего товара
                        </div>
                        <div class="item-content">
                            Ваш товар размещается на 7 крупных торговых площадках. Ежедневно на них заходит 5 млн. пользователей, (то есть ваших потенциальных покупателей)
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 d-flex justify-content-center align-items-center">
                    <div class="item text-center text-secondary d-flex justify-content-center align-items-center flex-column p-4"
                    style="padding-bottom: 3.4rem!important;">
                        <div class="item-title font-weight-bold mb-4">
                            Оплата <br>за выполненный заказ
                        </div>
                        <div class="item-content">
                            Вы оплачиваете комиссию только за выполненный заказ. Никаких скрытых платежей
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="bg-white">
        <div class="container mt-5">
            {{-- ПРЕИМУЩЕСТВА --}}
            <div class="row pt-2 pb-2">
                <div class="col-sm-12 col-md-6 order-2 order-sm-2 order-md-1 d-flex align-items-center">
                    <div class="img-wrapper">
                        <img class="img-header rounded mx-auto d-block w-100" src="{{asset('/public/images/nout2.png')}}" alt="продажа товаров на розетке Rozetka">
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 order-1 order-sm-1 order-md-2 text-secondary d-flex flex-column justify-content-start align-items-center pt-3 mt-3">
                    <h3 class="mb-3 text-center font-weight-normal font-s3">
                        Продавай свой товар<br>
                        на <span class="rozetka-green">Rozetka</span> и других<br>
                        крупных торговых площадках
                    </h3>
                    <p class="text-center mt-3 mb-5 item-content">
                        <span class="font-weight-bold text-primary">BigSales</span> позволяет Вам без особых усилий увеличить продажи,
                        интегрировав Ваши товары на все ведущие маркетплейсы.
                    </p>

                    <a href="#" id="start" class="btn btn-primary btn-custom action-reg-modal text-white text-uppercase text-center w-50 font-weight-light">Начать</a>

                </div>
            </div>
        </div>
    </section>

    <div class="img-side position-relative">
        <img class="position-absolute decoration decoration-right d-none d-lg-block" src="{{asset('/images/triangles.png')}}" alt="Декорация" height="253">
        <img class="position-absolute decoration decoration-left d-none d-lg-block" src="{{asset('/images/triangles.png')}}" alt="Декорация" height="253">
    </div>

    <section class="pt-5 bg-blue-custom">
        <div class="container">
            {{-- МАРКЕТПЛЕЙСЫ --}}
            <div class="row">
                <div class="col-12 pb-2">
                    <h3 class="text-center text-secondary font-weight-normal mb-5">
                        Независимо от размеров вашего бизнеса, у BigSales<br>
                        есть решение, которое поможет Вам продавать больше
                    </h3>
                    <div class="row justify-content-around mt-4 mb-4">
                        <div class="col-auto mb-3 text-center">
                            <img class="rounded-circle" src="{{asset('/public/images/rozetka.jpg')}}" alt="" width="130" height="130">
                        </div>
                        <div class="col-auto mb-3 text-center">
                            <img class="rounded-circle" src="{{asset('/public/images/allo.jpg')}}" alt="" width="130" height="130">
                        </div>
                        <div class="col-auto mb-3 text-center">
                            <img class="rounded-circle" src="{{asset('/public/images/olx.jpg')}}" alt="" width="130" height="130">
                        </div>
                        <div class="col-auto mb-3 text-center">
                            <img class="rounded-circle" src="{{asset('/public/images/privat.jpg')}}" alt="" width="130" height="130">
                        </div>
                        <div class="col-auto mb-3 text-center d-none d-lg-block">
                            <img class="rounded-circle" src="{{asset('/public/images/hotline.jpg')}}" alt="" width="130" height="130">
                        </div>
                    </div>
                    <div class="row justify-content-around d-none d-lg-flex">
                        <div class="col-auto mb-3 text-center">
                            <img class="rounded-circle" src="{{asset('/public/images/bigl.jpg')}}" alt="" width="130" height="130">
                        </div>
                        <div class="col-auto mb-3 text-center">
                            <img class="rounded-circle" src="{{asset('/public/images/modnakasta.jpg')}}" alt="" width="130" height="130">
                        </div>
                        <div class="col-auto mb-3 text-center">
                            <img class="rounded-circle" src="{{asset('/public/images/facebook-market.jpg')}}" alt="" width="130" height="130">
                        </div>
                        <div class="col-auto mb-3 text-center">
                            <img class="rounded-circle" src="{{asset('/public/images/prom.jpg')}}" alt="" width="130" height="130">
                        </div>
                        <div class="col-auto mb-3 text-center">
                            <img class="rounded-circle" src="{{asset('/public/images/allbiz.jpg')}}" alt="" width="130" height="130">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--<section class="bg-white">--}}
        {{--<div class="container">--}}
            {{-- Особенности --}}
            {{--<div class="row">--}}
                {{--<div class="col-12 col-md-6 p-5 text-secondary">--}}
                    {{--<h3 class="font-weight-bold">--}}
                        {{--Интернет магазины<br>--}}
                        {{--продают<br>--}}
                        {{--больше с <span class="text-primary">BigSales</span>--}}
                    {{--</h3>--}}
                    {{--<p class="font-weight-light font-s5">--}}
                        {{--Мы используем лидирующие<br>--}}
                        {{--торговые площадки для<br>--}}
                        {{--успешного достижение цели<br>--}}
                        {{--наших продавцов--}}
                    {{--</p>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}

    @isset($reviews)
        @if($reviews->count() >= 1)
            <!--<section class="mt-4 scroll3-item">
                <div class="container mt-5 pt-5">
                    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel" data-interval="5000">
                        <div class="d-none d-md-block mb-3 mt-5 pt-3 position-absolute" style="z-index: -1;">
                            <h3 class="font-weight-bold ">
                                Интернет магазины<br>
                                продают<br>
                                больше с BigSales
                            </h3>
                            <p class="font-weight-light pb-3" style="font-size: 1.3rem;">
                                Мы используем лидирующие<br>
                                торговые площадки для<br>
                                успешного достижения цели<br>
                                наших продавцов
                            </p>
                            <div class="img-wrapper">
                                <img src="{{asset('/public/images/quotes.png')}}" alt="quotes" height="70px">
                            </div>
                        </div>
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <?//@for($i=0; $i < $reviews->count(); $i++)?>
                            <?//@include('layouts.welcomeSliderItem')?>
                            <?//@endfor?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev"></a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next"></a>
                    </div>
                    {{-- Слайдер --}}
                    {{--<div id="carouselExampleControls" class="carousel slide text-secondary" data-ride="carousel">--}}
                        {{--<div class="carousel-inner">--}}

                        {{--</div>--}}
                        {{--<a class="carousel-control-prev d-none d-sm-flex" href="#carouselExampleControls" role="button" data-slide="prev">--}}
                            {{--<i class="fas fa-chevron-circle-up" style="color:  #000; transform: rotate(-90deg) scale(3);"></i>--}}
                            {{--<span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>--}}
                            {{--<span class="sr-only">Previous</span>--}}
                        {{--</a>--}}
                        {{--<a class="carousel-control-next d-none d-sm-flex" href="#carouselExampleControls" role="button" data-slide="next">--}}
                            {{--<i class="fas fa-chevron-circle-up" style="color:  #000; transform: rotate(90deg) scale(3);"></i>--}}
                            {{--<span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>--}}
                            {{--<span class="sr-only">Next</span>--}}
                        {{--</a>--}}
                    {{--</div>--}}
                </div>
            </section> -->
        @endif
    @endisset

    <div class="img-side position-relative scroll2-item">
        <img class="position-absolute decoration decoration-right-bottom d-none d-lg-block" src="{{asset('/images/triangles.png')}}" alt="Декорация" height="253">
    </div>

    <section >
        <div class="container">
            {{-- CALL TO ACTION --}}
            <div class="row info  align-items-center pt-5 pr-5 pb-5 pl-2 text-secondary">
                <div class="col-12 col-md-5">
                    <h3 style="font-size: 2rem;">
                        Мощное<br>
                        программное<br>
                        обеспечение для<br>
                        электронной<br>
                        коммерции, которое<br>
                        растет вместе с Вами<br>
                    </h3>
                </div>
                <div class="col-12 col-md-7 ">
                    <div class="bg-blue-custom h-100 p-4">
                        <h5 class="font-weight-bold ">Решения для быстрорастущих компаний</h5>
                        <ul class="pl-3">
                            <li class="font-weight-bold pt-4 pb-2">
                                Увеличьте продажи с помощью интеграции<br> с
                                Топовыми торговыми площадками
                            </li>
                            <p>
                                Лучшие инструменты для конверсии и маркетинга<br>
                                помогают нашим клиентам расширить<br>
                                свой бизнес почти в 2 раза
                            </p>
                            <li class="font-weight-bold pt-2 pb-2">
                                Все заказы с торговых площадок в едином кабинете
                            </li>
                            <p>
                                Вы потратите в 5 раз меньше времени на управление товарами и получение
                                заказов благодаря нашему облачному решению
                            </p>
                        </ul>
                        <div class="text-left pt-3">
                            <a href="#" class="action-reg-modal d-inline-block btn btn-primary btn-custom font-weight-light text-white text-uppercase">развивай свой бизнес</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection
