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

    <link href="{{ asset('css/bootstrap/select2-bootstrap4.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    {{--<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">--}}


    <link href="{{ asset('css/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/panel-colors.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    @section('stylesheets')

    @show
    <?//подключение основных скриптов выше боди?>
    <script src="{{ asset('js/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/dropzone/dropzone.js') }}"></script>
    @yield('script1')



</head>
<body class="fixed-nav sticky-footer bg-dark sidenav-toggled" id="page-top">
<? //overlay loader ?>
<div id="overlay-loader">
<div id="loader"></div>
</div>


<? //Подключаем навигационную панель ?>
@section('navbar')
    @include('admin.layouts.navbar')
@show

<? // Подключаем инфо панель ?>
@include('modals.alerts')


@yield('content')

@yield('after_content')



<? // Подключаем футер ?>
@section('footer')
    @include('admin.layouts.footer')
@show


@section('modals')
    @include('admin.layouts.modals')
@show

@section('scrollButton')
    @include('admin.layouts.scrollButton')
@show

<?//подключение основных скриптов ниже боди?>
<script src="{{ asset('js/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/toster/jquery.toaster.js') }}"></script>
<script src="{{ asset('js/maskinput/maskinput.js') }}"></script>

<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('js/tinymce/langs/ru.js') }}"></script>
<script src="{{ asset('js/tinymce/plugins/jbimages/plugin.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="{{ asset('js/sb-admin.min.js') }}"></script>
<script src="{{ asset('js/master.js') }}"></script>
<script src="{{ asset('js/admin.js') }}"></script>
@yield('script2')




</body>
</html>
