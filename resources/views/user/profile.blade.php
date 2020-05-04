@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="row">
            <div class="col-12">
                <h1 class="w-100 text-center">
                    Личный кабинет!
                </h1>
            </div>
        </div>
        <div class="row border-bottom">
            <div class="col-md-6 p-3 bg-light border-right">

                <h3 class="mb-3">Личные данные</h3>

                <form action="{{ asset('/change/profile') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" type="text" name="name" value="{{ old('name')? old('name'): Auth::user()->name }}">
                    </div>
                    <div class="form-group">
                        <label for="surname">Фамилия</label>
                        <input class="form-control {{ $errors->has('surname') ? ' is-invalid' : '' }}" id="surname" type="text" name="surname" value="{{ old('surname') ? old('surname') : Auth::user()->surname }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Почта</label>
                        <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" type="email" name="email" value="{{ old('email') ? old('email') : Auth::user()->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <input class="form-control mask-tel {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" type="tel" name="phone" value="{{ old('phone') ? old('phone') : Auth::user()->phone }}" required>
                    </div>
                    <div class="form-group">
                        <label for="Password">Для сохранения введите пароль</label>
                        <input class="form-control {{ session('password') ? session('password') : '' }}" id="Password" type="password"  name="password" value="{{ old('password')}}" required>
                    </div>

                    <button type="submit" class="btn btn-form square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">Сохранить данные</button>
                </form>

            </div>

            <div class="col-md-6 p-3 bg-light">

                <h3 class="mb-3">Сброс пароля</h3>

                <form action="{{ asset('/change/password') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="oldPassword">Старый пароль</label>
                        <input class="form-control {{ session('errorsArray.current_password') ? ' is-invalid' : '' }}" id="oldPassword" type="password" name="current_password" value="{{ old('current_password') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">Новый пароль</label>
                        <input class="form-control {{ ( (session('errorsArray.password')) || (session('errorsArray.password_confirmation'))) ? ' is-invalid' : '' }}" id="newPassword" type="password" name="password" value="{{ old('password') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Подтвердите пароль</label>
                        <input class="form-control {{ session('errorsArray.password_confirmation') ? ' is-invalid' : '' }}" id="confirmPassword" type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" required>
                    </div>

                    <button type="submit" class="btn btn-form square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">Изменить пароль</button>
                </form>

            </div>
        </div>
    </div>

@endsection
