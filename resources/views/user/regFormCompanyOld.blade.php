@extends('provider.company.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-5">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">
                    <div class="panel panel-default">
                        <h2 class="text-center">Регистрация компании</h2>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="{{ asset('/company/create') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Название</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                </div>

                                <div class="form-group{{ $errors->has('legal_person') ? ' has-error' : '' }}">
                                    <label for="name">Юридические данные <br> <span class="text-danger" style="font-size: 12px;">*(для юр. лиц - юридические данные, для физ. лиц - паспортные данные и инд.код)</span></label>
                                    <input id="legal-person" type="text" class="form-control" name="legal_person" value="{{ old('legal_person') }}" required autofocus>
                                </div>

                                <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
                                    <label for="name">Ссылка</label>
                                    <input id="link" type="text" class="form-control" name="link" value="{{ old('link') }}" autofocus>
                                </div>

                                <div class="form-group{{ $errors->has('responsible') ? ' has-error' : '' }}">
                                    <label for="name">Ответсвтенный</label>
                                    <input id="responsible" type="text" class="form-control" name="responsible" value="{{ old('responsible') }}" required autofocus>
                                </div>

                                <div class="form-group{{ $errors->has('responsible_phone') ? ' has-error' : '' }}">
                                    <label for="name">Номер ответственного</label>
                                    <input id="responsible-phone" type="text" class="form-control mask-tel" name="responsible_phone" value="{{ old('responsible_phone') }}" required autofocus>
                                </div>

                                <div class="form-group{{ $errors->has('info') ? ' has-error' : '' }}">
                                    <label for="name">Информация о компании</label>
                                    <textarea id="info" type="text" class="form-control " name="info" value="{{ old('info') }}"> </textarea>
                                </div>

                                <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">
                                    Зарегистрировать
                                </button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
