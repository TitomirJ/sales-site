@extends('version2.app.app')

@section('stylesheets')
    @parent

    <?//components?>
    <link rel="stylesheet" href="{{asset('/cssv2/components/tabs.css')}}">
    <link href="{{ asset('cssv2/components/dropdown.css') }}" rel="stylesheet">
    <link href="{{ asset('cssv2/components/switch.css') }}" rel="stylesheet">
    <link href="{{ asset('cssv2/components/checkbox.css') }}" rel="stylesheet">
    <link href="{{ asset('cssv2/components/toast.css') }}" rel="stylesheet">
    <link href="{{ asset('cssv2/components/buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('cssv2/components/modal.css') }}" rel="stylesheet">
    <link href="{{ asset('cssv2/components/inputs.css') }}" rel="stylesheet">
    <link href="{{ asset('cssv2/components/accordion.css') }}" rel="stylesheet">
    <link href="{{ asset('cssv2/components/table.css') }}" rel="stylesheet">
    <link href="{{ asset('cssv2/plugins/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('cssv2/components/notifications.css') }}" rel="stylesheet">


@endsection

@section('headjs')
    <?//Chartist.js?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.0/chartist.min.js"></script>

    <?//ChartJs?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
@endsection


@section('content')
    <div class="main">
        <div class="main-wrapper" id="page-top">
            <div class="main-content p-1">
                <div class="container">

                    {{--Products--}}
                    @include('version2.layouts.products')

                    {{--Balance--}}
                    @include('version2.layouts.balance')

                    {{--Company Profile--}}
                    @include('version2.layouts.companyProfile')

                    {{--User Profile--}}
                    @include('version2.layouts.userProfile')

                    {{--Dashboard--}}
                    @include('version2.layouts.dashboard')

                    {{--All Components--}}
                    @include('version2.layouts.components')

                    {{--Footer--}}
                    @include('version2.app.footer')

                </div>
            </div>
        </div>
    </div>

    <? // Scroll button up ?>
    <a class="scroll-to-top-btn rounded p-f scroll-to-top" href="#page-top" style="display: none">
        <i class="fa fa-angle-up"></i>
    </a>

@endsection

@section('script2')
    @include('provider.company.productNew.layouts.layouts.indexScript')
@endsection
