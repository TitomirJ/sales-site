@extends('layouts.app')

@section('navbar')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 order-2 order-md-1 p-0 ">
                @include('auth.layouts.blog')
            </div>
            <div class="col-12 col-md-6 order-1 order-md-2 pt-5 pb-5 d-flex justify-content-center flex-column align-items-center" style="height: 100vh;">
                <div class="login-form-logo mb-5">
                  <a class="logo-big" href="https://bigsales.pro/company">
                      <div class="wrapper-logotip position-relative d-flex text-uppercase font-weight-bold">
                          <div class="white-block-logo bg-dark"></div>
                          <div class="big position-absolute text-white">big</div>
                          <div class="sales position-absolute text-dark">sales</div>
                      </div>
                      <div class="logo-subtext text-dark ff-comforta"> продажи и маркетинг в одном сервисе</div>
                  </a>
                </div>
                <div class="login-form-title mb-4 text-center">
                    <h2 class="text-dark">Войдите в учетную запись</h2>
                </div>
                <form method="POST" action="{{ route('login') }}" class="position-relative w-75">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <input type="email" class="form-control form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" aria-describedby="emailHelp" placeholder="Введите почту" name="email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control form-control-lg{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" placeholder="Введите пароль" name="password" required>
                    </div>

                    <a href="{{ asset('/password/reset') }}" class="forgot-password position-absolute">Забыли?</a>

                    <button type="submit" class="btn btn-form btn-primary btn-lg w-100 mt-2 mb-3">Войти</button>

                    <div class="form-check align-self-center">
                        <div class="row d-flex justify-content-between">
                            <div class="col-12 col-lg-6 d-flex justify-content-center">
                              <div class="wrapper-checkbox">
                                <input type="checkbox" name="remember" id="remember" class="css-checkbox form-check-input" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember" class="form-check-label text-nowrap css-label radGroup1 text-dark align-middle">Запомнить меня</label>
                              </div>
                            </div>
                            <a class="col-12 col-lg-6 d-inline-block action-reg-modal text-center light-link text-dark" href="">Регистрация</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    @if(session('actionRegFormModal'))
        <script>
            $( document ).ready(function(){
                $('#regModalWelcome').modal({
                    keyboard: false,
                    backdrop:'static'
                });
            });
        </script>
    @endif
@endsection

@section('footer')
@endsection

@section('script2')
    <script src="{{ asset('js/pages/auth/auth.js') }}"></script>

    <script>
        $('body').on('click', '#btn-registration', function(e) {
            e.preventDefault();
            if(!$("#agree").is(':checked')) {
                $('.agree-text').removeClass('d-none');
                $('.agree-text').addClass('d-block');
            }else{
                $('#formRegist').submit();
            }
        });
    </script>
@endsection

