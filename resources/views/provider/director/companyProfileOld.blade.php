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
                    <h2 class="text-uppercase ml-3">Редактирование компании</h2>
                    <div class="dropdown-divider"></div>
                </div>
            </div>

            <div class="d-flex justify-content-center w-100">
                <div class="edit-content">
                    <div class="row">
                        <div class="col-12 p-3 bg-light border-radius border-2 border-blue">

                            <form action="{{ asset('/company/profile') }}" method="POST">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="name" class="col-12 text-uppercase font-weight-bold">Название</label>
                                    <input id="name" type="text" class="form-control border-radius {{ session('errorsArray.name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name')? old('name'): $company->name }}" required autofocus>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-12 text-uppercase font-weight-bold">Ссылка</label>
                                    <input id="link" type="text" class="form-control border-radius {{ session('errorsArray.link') ? ' is-invalid' : '' }}" name="link" value="{{ old('link')? old('link'): $company->link }}">
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-12 text-uppercase font-weight-bold">Ответственный за прием заказов</label>
                                    <input id="responsible" type="text" class="form-control border-radius {{ session('errorsArray.responsible') ? ' is-invalid' : '' }}" name="responsible" value="{{ old('responsible')? old('responsible'): $company->responsible }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-12 text-uppercase font-weight-bold">Номер телефона ответственного</label>
                                    <input id="responsible-phone" type="text" class="mask-tel form-control border-radius {{ session('errorsArray.responsible_phone') ? ' is-invalid' : '' }}" name="responsible_phone" value="{{ old('responsible_phone')? old('responsible_phone'): $company->responsible_phone }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-12 text-uppercase font-weight-bold">Юридическая информация</label>
                                    <textarea id="legal-info" type="text" class="form-control border-radius {{ session('errorsArray.legal_person') ? ' is-invalid' : '' }}" name="legal_person" style="min-height: 38px;"  >{{ session('old_legal_person')? session('old_legal_person'): $company->legal_person }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-12 text-uppercase font-weight-bold">Информация о компании</label>
                                    <textarea id="info" type="text" class="form-control border-radius {{ session('errorsArray.info') ? ' is-invalid' : '' }}" name="info" style="min-height: 38px;">{{ session('old_info') ? session('old_info'): $company->info }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-form square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">Сохранить данные</button>

                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
