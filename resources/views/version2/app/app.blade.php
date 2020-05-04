<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title or $globalTitle }}</title>
    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('/images/favicon.ico') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    {{--Font Awesome--}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('/cssv2/main-panel/navbar.css')}}">
    <link rel="stylesheet" href="{{asset('/cssv2/main-panel/content.css')}}">
    <link rel="stylesheet" href="{{asset('/cssv2/main-panel/footer.css')}}">

    <link href="{{ asset('cssv2/main-styles/grid.css') }}" rel="stylesheet">
    <link href="{{ asset('cssv2/main-styles/colors.css') }}" rel="stylesheet">
    <link href="{{ asset('cssv2/main-styles/main.css') }}" rel="stylesheet">

    <?//подключение динамических стилей?>
    @section('stylesheets')
    @show

    <script src="{{ asset('js/jquery/jquery-3.2.1.min.js') }}"></script>

    @section('headjs')
    @show
</head>
<body>

<? //overlay loader ?>
{{--<div id="loader-container">--}}
    {{--<div id="loader">--}}
        {{--<div id="circles"></div>--}}
    {{--</div>--}}
    {{--<div id="loader-circle"></div>--}}
{{--</div>--}}




<? //Подключаем навигационную панель ?>
@section('navbar')
    @include('version2.app.navbar')
@show

<? // Подключаем инфо панель ?>
@include('modals.alerts')


@yield('content')



<!-- Scripts -->

{{--<script src="{{ asset('js/jquery/popper.min.js') }}"></script>--}}
{{--<script src="{{ asset('js/toster/jquery.toaster.js') }}"></script>--}}
{{--<script src="{{ asset('js/maskinput/maskinput.js') }}"></script>--}}
{{--<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>--}}
{{--<script src="{{ asset('js/tinymce/langs/ru.js') }}"></script>--}}
{{--<script src="{{ asset('js/tinymce/plugins/jbimages/plugin.min.js') }}"></script>--}}


<script src="{{ asset('jsv2/materialize/materialize.min.js') }}"></script>
<script src="{{ asset('jsv2/main-panel/main-panel.js') }}"></script>



<?//подключение динамических скриптов?>
@section('script')
    <script src="{{ asset('jsv2/components/dropdown/dropdown.js') }}"></script>
    <script src="{{ asset('jsv2/components/tabs.js') }}"></script>
@show
<script>
    (function($, undefined){
        $(function(){
            //кнопка возврата в оглавление (scroll button)

            $('.main').scroll(function() {

                var scrollDistance = $(this).scrollTop();
                if (scrollDistance > 100) {
                    $('.scroll-to-top').fadeIn();
                } else {
                    $('.scroll-to-top').fadeOut();
                }
            });

            $(".scroll-to-top").click(function() {
                $('.main').animate({
                    scrollTop: "0px"
                }, {
                    duration: 1000,
                    easing: "swing"
                });
            });

        });
    })(jQuery);
</script>
@yield('script2')

@section('footerjs')
@show

</body>
</html>
