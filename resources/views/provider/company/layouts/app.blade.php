<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title or $globalTitle }}</title>

<?//подключение основных стилей?>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/images/favicon-32x32.png') }}">
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"  type="text/css">

<?//подключение динамических стилей?>
@section('stylesheets')
    <link href="{{ asset('css/bootstrap/select2-bootstrap4.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datapicker/datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/panel-colors.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
@show

<?//подключение основных скриптов выше боди?>
    <script src="{{ asset('js/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>

<?//подключение динамических скриптов выше боди?>
@section('scripts_top')
    <script src="{{ asset('js/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('js/datapicker/datepicker.min.js') }}"></script>
    <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
@show

<?//инициализация динамических скриптов и JS переменных в начале документа?>
@yield('script1')
</head>

<body class="fixed-nav sticky-footer dark-bg sidenav-toggled" id="page-top">

<? //overlay loader ?>
<div id="overlay-loader">
    <div id="loader"></div>
</div>

<? //Подключаем навигационную панель ?>
@section('navbar')
    @include('provider.company.layouts.navbar')
@show

<? // Подключаем инфо панель ?>
@include('modals.alerts')

<? // Подключаем уведомления о блокировках компании ?>
@include('provider.company.layouts.blockInfoContent')

<? // Динамический контент ?>
@yield('content')

<? // Подключаем футер ?>
@section('footer')
    @include('provider.company.layouts.footer')
@show

<? // Подключаем основные модальные окна ?>
@section('modals')
    @include('provider.company.layouts.modals')
@show

<? // Подключаем кнопку скрола в начало стр ?>
@section('scrollButton')
    @include('provider.company.layouts.scrollButton')
@show

<?//подключение основных скриптов ниже боди?>
    <script src="{{ asset('js/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/toster/jquery.toaster.js') }}"></script>
    <script src="{{ asset('js/maskinput/maskinput.js') }}"></script>

<?//подключение динамических скриптов ниже боди?>
@section('scripts_bottom')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/tinymce/langs/ru.js') }}"></script>
    <script src="{{ asset('js/tinymce/plugins/jbimages/plugin.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@show

<?//подключение основных скриптов ниже боди после динамических?>
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>
    <script src="{{ asset('js/master.js') }}"></script>
    <script src="{{ asset('js/provider.js') }}"></script>

<?//инициализация динамических скриптов и JS переменных в конце документа?>
@yield('script2')

<?//инициализация плагина jivosite в зависимости от существования сессии с ключом "jivosite"?>
@if(session('jivosite'))
    <script type='text/javascript'>
        (function(){ var widget_id = 'lzjmNdSYVz';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
    </script>
@endif
</body>
</html>
