@extends('layouts.app')

@section('navbar')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 order-2 order-md-1 p-0">
                @include('auth.layouts.blog')
            </div>
            <div class="col-12 col-md-6 order-1 order-md-2 pt-5 pb-5 d-flex justify-content-center flex-column align-items-center bg-dark" style="height: 100vh;">
                <div class="login-form-logo mb-5">
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
                <form class="form-horizontal w-75" method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="email" class="form-control" name="email" placeholder="E-Mail адрес" value="{{ $email or old('email') }}" required autofocus>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Пароль" required>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Повторите папроль" required>
                    </div>

                    <button type="submit" class="btn btn-form btn-primary btn-lg w-100 mt-2 mb-3">
                        Сменить пароль
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('footer')
@endsection
