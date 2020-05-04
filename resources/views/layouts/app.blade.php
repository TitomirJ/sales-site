<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title or $globalTitle }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,500,700,700i&amp;subset=cyrillic" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/images/favicon-32x32.png') }}">
    <!-- Styles -->
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('font-awesome/css/fontawesome-all.min.css')}}">
    <link href="{{ asset('css/master.css') }}" rel="stylesheet">
    <link href="{{ asset('css/panel-colors.css') }}" rel="stylesheet">

    <?//подключение динамических стилей?>
    @section('stylesheets')

    @show

    <script src="{{ asset('js/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
</head>
<body>
    <? //overlay loader ?>
    <div id="overlay-loader">
        <div id="loader"></div>
    </div>




    <? //Подключаем навигационную панель ?>
    @section('navbar')
        @include('layouts.navbar')
    @show

    <? // Подключаем инфо панель ?>
    @include('modals.alerts')


    @yield('content')

    <? // Scroll button up ?>
    @section('scrollButtonUp')
        @include('layouts.scrollButtonUp')
    @show

    <? // Подключаем футер ?>
    @section('footer')
        @include('layouts.footer')
    @show

    <? // Модальные окна ?>
    @section('modals')
        @include('modals.app.authModal')
        @include('modals.app.callBackModal')
    @show


    <!-- Scripts -->

    <script src="{{ asset('js/jquery/popper.min.js') }}"></script>
    <script src="{{ asset('js/toster/jquery.toaster.js') }}"></script>
    <script src="{{ asset('js/maskinput/maskinput.js') }}"></script>
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/tinymce/langs/ru.js') }}"></script>
    <script src="{{ asset('js/tinymce/plugins/jbimages/plugin.min.js') }}"></script>
    <script src="{{ asset('js/master.js') }}"></script>
    @yield('script2')

</body>
</html>
