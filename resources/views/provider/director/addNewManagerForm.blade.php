@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/userProfile/userProfile.css') }}">
@endsection


@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

          <div class="row flex-column mt-5 mb-5">
              <div class="col-12">
                  <h2 class="text-uppercase ml-3">Регистрация сотрудника</h2>
                  <div class="dropdown-divider"></div>
              </div>
          </div>

            <div class="d-flex justify-content-center w-100">
              <div class="edit-content">
                <div class="row">
                    <div class="col-12 p-3 bg-light border-radius border-2 border-blue">

                      <form class="form-horizontal" method="POST" action="{{ asset('/company/add/manager') }}">
                          {{ csrf_field() }}

                          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                              <label for="name" class="col-12 text-uppercase font-weight-bold">Имя</label>
                              <input id="name" type="text" class="form-control border-radius" name="name" value="{{ old('name') }}" required autofocus>
                          </div>

                          <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
                              <label for="surname" class="col-12 text-uppercase font-weight-bold">Фамилия</label>
                              <input id="surname" type="text" class="form-control border-radius" name="surname" value="{{ old('surname') }}" required autofocus>
                          </div>

                          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                              <label for="email" class="col-12 text-uppercase font-weight-bold">E-Mail</label>
                              <input id="email" type="email" class="form-control border-radius" name="email" value="{{ old('email') }}" required>
                          </div>

                          <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                              <label for="email" class="col-12 text-uppercase font-weight-bold">Телефон</label>
                              <input id="phone" type="text" class="mask-tel form-control border-radius" name="phone" value="{{ old('phone') }}">
                          </div>

                          <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">
                              Добавить
                          </button>

                      </form>

                    </div>
                </div>
              </div>

          </div>

        </div>
    </div>

@endsection
