@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/modules/checkbox.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            {{ $order }}
        </div>
    </div>
@endsection

@section('after_content')
    @include('adminAndModerator.moderation.order.layouts.modals')
@endsection

@section('script2')
    <script src="{{ asset('js/pages/admin/mod/ord/mod_ord.js') }}"></script>
@endsection

