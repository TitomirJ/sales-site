@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/userProfile/userProfile.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row flex-column">
                <div class="col-12 text-uppercase mt-5 ml-3">
                    <h2>Редактирование профиля</h2>
                </div>
            </div>

            <div class="row">
              <div class="col-12 d-flex flex-column align-items-center">
                <nav class="mt-5">
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link border-0 blue-d-t text-uppercase mr-md-5 active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">личные данные</a>
                    <a class="nav-item nav-link border-0 blue-d-t text-uppercase ml-md-5" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">сброс пароля</a>
                  </div>
                </nav>
                <div class="tab-content edit-content" id="nav-tabContent">

                  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">

                      <div class="col-12 p-3 bg-light border-radius border-2 border-blue">

                          <form action="{{ asset('/change/profile') }}" method="POST">
                              {{ csrf_field() }}
                              <div class="form-group">
                                  <label for="name" class="text-uppercase font-weight-bold">Имя</label>
                                  <input class="form-control border-radius {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" type="text" name="name" value="{{ old('name')? old('name'): Auth::user()->name }}">
                              </div>
                              <div class="form-group">
                                  <label for="surname" class="text-uppercase font-weight-bold">Фамилия</label>
                                  <input class="form-control border-radius {{ $errors->has('surname') ? ' is-invalid' : '' }}" id="surname" type="text" name="surname" value="{{ old('surname') ? old('surname') : Auth::user()->surname }}">
                              </div>
                              <div class="form-group">
                                  <label for="email" class="text-uppercase font-weight-bold">Почта</label>
                                  <input class="form-control border-radius {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" type="email" name="email" value="{{ old('email') ? old('email') : Auth::user()->email }}" required>
                              </div>
                              <div class="form-group">
                                  <label for="phone" class="text-uppercase font-weight-bold">Телефон</label>
                                  <input class="form-control border-radius mask-tel {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" type="tel" name="phone" value="{{ old('phone') ? old('phone') : Auth::user()->phone }}" required>
                              </div>
                              <div class="form-group">
                                  <label for="Password" class="text-uppercase font-weight-bold">Для сохранения введите пароль</label>
                                  <input class="form-control border-radius {{ session('password') ? session('password') : '' }}" id="Password" type="password"  name="password" value="{{ old('password')}}" required>
                              </div>

                              <button type="submit" class="btn btn-form square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">Сохранить данные</button>
                          </form>

                      </div>

                    </div>
                  </div>

                  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="row">

                      <div class="col-12 p-3 bg-light border-radius border-2 border-blue">

                          <form action="{{ asset('/change/password') }}" method="POST">
                              {{ csrf_field() }}
                              <div class="form-group">
                                  <label for="oldPassword" class="text-uppercase font-weight-bold">Старый пароль</label>
                                  <input class="form-control border-radius {{ session('errorsArray.current_password') ? ' is-invalid' : '' }}" id="oldPassword" type="password" name="current_password" value="{{ old('current_password') }}" required>
                              </div>
                              <div class="form-group">
                                  <label for="newPassword" class="text-uppercase font-weight-bold">Новый пароль</label>
                                  <input class="form-control border-radius {{ ( (session('errorsArray.password')) || (session('errorsArray.password_confirmation'))) ? ' is-invalid' : '' }}" id="newPassword" type="password" name="password" value="{{ old('password') }}" required>
                              </div>
                              <div class="form-group">
                                  <label for="confirmPassword" class="text-uppercase font-weight-bold">Подтвердите пароль</label>
                                  <input class="form-control border-radius {{ session('errorsArray.password_confirmation') ? ' is-invalid' : '' }}" id="confirmPassword" type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" required>
                              </div>

                              <button type="submit" class="btn btn-form square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">Изменить пароль</button>
                          </form>

                      </div>

                    </div>
                  </div>

                </div>
              </div>
            </div>

        </div>
    </div>

@endsection
