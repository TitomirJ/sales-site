@extends('admin.layouts.app')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            @include('admin.layouts.breadcrumbs')
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ asset('/admin/parsing/rozet/subcat/options') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label style="font-size: 50px;" for="surname">Num option {{ session('option_id') ? session('option_id') : '' }}</label>
                                    <input class="form-control" id="surname" type="number" name="option_id" style="font-size: 50px;" value="{{ session('option_id') ? session('option_id') : '' }}" autofocus>
                                </div>
                                <button type="submit" class="on-overlay-loader btn btn-form btn-primary btn-lg w-100 mt-2 mb-3">Парсить данные</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>





@endsection
