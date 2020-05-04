@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/userProfile/userProfile.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <h2 class="text-center">Регистрация сотрудника</h2>
                    <div class="dropdown-divider"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 p-3 bg-light border-radius border-2 border-blue">

                  <form class="form-horizontal" method="POST" action="{{ asset('/admin/personnel/store') }}">
                      {{ csrf_field() }}

                      <div class="form-group">
                          <label for="name" class="col-12 text-uppercase font-weight-bold">Имя</label>
                          <input id="name" type="text" class="border-radius form-control{{ session('errorsArray.name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                      </div>

                      <div class="form-group">
                          <label for="surname" class="col-12 text-uppercase font-weight-bold">Фамилия</label>
                          <input id="surname" type="text" class="border-radius form-control{{session('errorsArray.surname') ? ' is-invalid' : '' }}" name="surname" value="{{ old('surname') }}" required>
                      </div>

                      <div class="form-group">
                          <label for="email" class="col-12 text-uppercase font-weight-bold">E-Mail</label>
                          <input id="email" type="email" class="border-radius form-control{{ session('errorsArray.email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                      </div>

                      <div class="form-group">
                          <label for="email" class="col-12 text-uppercase font-weight-bold">Телефон</label>
                          <input id="phone" type="text" class="border-radius mask-tel form-control{{ session('errorsArray.phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}">
                      </div>

                      <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">
                          Добавить
                      </button>

                  </form>

                </div>
              </div>


        </div>
    </div>





@endsection
