@extends('layouts.app')

@section('navbar')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 order-2 order-md-1 p-0" >
                @include('auth.layouts.blog')
            </div>
            <div class="col-12 col-md-6 order-1 order-md-2 pt-5 pb-5 d-flex justify-content-center flex-column align-items-center bg-dark" style="height: 100vh;">
                <div class="login-form-logo mb-5">
                    <a class="position-absolute back-to-login font-weight-light text-white" onclick="javascript:history.back(); return false;">
                        <i class="fas fa-angle-left"></i>
                        Назад
                    </a>
                    <a class="logo-big" href="https://bigsales.pro/company">
                        <div class="wrapper-logotip position-relative d-flex text-uppercase font-weight-bold">
                            <div class="white-block-logo bg-white"></div>
                            <div class="big position-absolute">big</div>
                            <div class="sales position-absolute text-white">sales</div>
                        </div>
                        <div class="logo-subtext text-white ff-comforta"> продажи и маркетинг в одном сервисе</div>
                    </a>
                </div>
                <div class="login-form-title mb-4 text-center">
                    <h2 class="text-white">Сброс пароля</h2>
                </div>
                <form method="POST" action="{{ route('password.email') }}" class="w-75">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="email" class="form-control form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" placeholder="Enter email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <button type="submit" class="btn btn-form btn-primary btn-lg w-100" style="font-size: 1rem;">
                        Сбросить пароль
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection
