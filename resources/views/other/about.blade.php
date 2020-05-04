@extends('landing.layouts.app')

@section('stylesheets')
    <link rel="stylesheet" href="{{asset('/css/landing/about.css')}}">
@endsection

@section('body')
    <body class="p-rel about-section">
@endsection

@section('navbar')

@endsection

@section('content')

    <div class="container">

        <div class="row j-c-c j-c-md-e">
            <div class="col-12 pt-3">
                <img src="{{asset('/images/landing/BigSales.png')}}" class="logo-a" alt="logo Big Sales">
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h1 class="mt-5 mb-3">О нас</h1>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <div class="about-wrap">
                    <div class="about-text bg-white p-2 p-md-5">
                        Чуть более трех лет назад мы основали интернет-магазин по продаже электроники и бытовой техники.
                        Мы начали активно размещать товары на крупных торговых маркетплейсах, но столкнулись со сложностями в обработке заказов и большой стоимостью оплаты услуг на каждой торговой площадке. Такого инструмента, который объединял бы все торговые площадки не существует, поэтому мы создали его первоначально для себя. Вскоре мы поняли, что большинство других магазинов так же нуждаются в нашей разработке. Так появилась идея создать Big Sales – платформу для создания своего розничного бизнеса и потока заявок в одном месте.
                        Мы фокусируемся на том, чтобы сделать интернет торговлю лучше для всех, поэтому компании могут сосредоточиться на том, что они делают лучше всего: создавать и продавать свою продукцию. Сегодня продавцы используют нашу платформу для управления каждым аспектом своего бизнеса - от продуктов до заказов клиентов.
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 d-flex justify-content-end mb-3">
                <a href="https://bigsales.pro/" class="btn btn-full text-u pb-1 d-flex justify-content-center align-items-center pr-4 pl-4">на главную</a>
            </div>
        </div>

        <div class="row pb-5">
            <div class="col-12">
                <div class="d-flex justify-content-start pt-1 pb-1">
                    <a href="https://www.facebook.com/bigsalespro" class="foo-icon foo-icon-face d-flex justify-content-center align-items-center mr-md-3 ml-md-3 mr-1 ml-1 wow fadeInLeft" data-wow-duration=".7s" data-wow-offset="5">
                        <svg aria-hidden="true" data-prefix="fab" data-icon="facebook-f" class="svg-inline--fa fa-facebook-f fa-w-9" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 264 512"><path fill="currentColor" d="M76.7 512V283H0v-91h76.7v-71.7C76.7 42.4 124.3 0 193.8 0c33.3 0 61.9 2.5 70.2 3.6V85h-48.2c-37.8 0-45.1 18-45.1 44.3V192H256l-11.7 91h-73.6v229"></path></svg>
                    </a>

                    <a href="https://www.instagram.com/_bigsales.pro_/?hl=ru" class="foo-icon foo-icon-inst d-flex justify-content-center align-items-center mr-md-3 ml-md-3 mr-1 ml-1 wow fadeInUp" data-wow-duration=".7s" data-wow-offset="5">
                        <svg aria-hidden="true" data-prefix="fab" data-icon="instagram" class="svg-inline--fa fa-instagram fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>
                    </a>
                </div>
            </div>
        </div>

    </div>


@endsection

@section('footer')
@endsection