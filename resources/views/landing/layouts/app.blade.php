<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('/css/landing/main.css')}}">
    <link rel="stylesheet" href="{{asset('/css/landing/grid.css')}}">
    <link rel="stylesheet" href="{{asset('/css/landing/reboot.css')}}">
    <link rel="stylesheet" href="{{asset('/cssv2/plugins/animate.css')}}">

    @section('stylesheets')

    @show

    <title>{{ $title or $globalTitle }}</title>

</head>


@section('body')
    <body class="ovrfl-x-h position-relative">
@show


<? //Подключаем навигационную панель ?>
@section('navbar')
    @include('landing.layouts.navbar')
@show

<? // Подключение тостов верстка?>
@include('landing.layouts.toast')

@yield('content')



<? // Подключаем футер ?>
@section('footer')
    @include('landing.layouts.footer')
@show




    <script src="{{asset('/js/jquery/jquery-3.2.1.min.js')}}"></script>

    <!-- maskinput -->
    <script src="{{asset('/js/maskinput/maskinput.js')}}"></script>

    <!-- my js -->
    <script src="{{asset('/js/landing/main.js')}}"></script>

    <!-- animated -->
    <script src="{{asset('/js/landing/wow.min.js')}}"></script>
    <script src="{{asset('/js/landing/rellax.js')}}"></script>
    <script>
        // Accepts any class name
        var rellax = new Rellax('.rellax');
    </script>
    <script>
        wow = new WOW(
            {
                boxClass:     'wow',
                animateClass: 'animated',
                offset:       0,
                mobile:       true,
                live:         true
            }
        )
        wow.init();
    </script>


    <? // Подключение условие тостов?>
    @include('landing.layouts.alerts')

    </body>
</html>
