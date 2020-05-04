@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/admin/users/users.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center mt-5 mb-5">
                <div class="text-uppercase blue-d-t f30">
                    пользователи сайта
                </div>
            </div>

            <ul class="nav nav-pills flex-column flex-xl-row flex-nowrap nav-justified text-uppercase mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-guest-tab" data-toggle="pill" href="#pills-guest" role="tab" aria-controls="pills-guest" aria-selected="true">гости <span class="badge badge-pill badge-info">{{ $guests_count }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-provider-tab" data-toggle="pill" href="#pills-provider" role="tab" aria-controls="pills-provider" aria-selected="false">поставщики <span class="badge badge-pill badge-info">{{ $providers_count }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-personnel-tab" data-toggle="pill" href="#pills-personnel" role="tab" aria-controls="pills-personnel" aria-selected="false">персонал <span class="badge badge-pill badge-info">{{ $personnel_count }}</span></a>
            </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-guest" role="tabpanel" aria-labelledby="pills-guest-tab">
                    @include('admin.users.layouts.guest.guestBlock')
                </div>
                <div class="tab-pane fade" id="pills-provider" role="tabpanel" aria-labelledby="pills-provider-tab">
                    @include('admin.users.layouts.provider.providerBlock')
                </div>
                <div class="tab-pane fade" id="pills-personnel" role="tabpanel" aria-labelledby="pills-personnelt-tab">
                    @include('admin.users.layouts.personnel.personnelBlock')
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script2')
    <script src="{{ asset('js/pages/admin/user/all_users.js') }}"></script>
@endsection