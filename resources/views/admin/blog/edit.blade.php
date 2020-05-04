@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/modules/chooseFileBtn.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modules/checkbox.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <h1 class="w-100 text-center">Редактировать новость</h1>
                </div>
            </div>
            
            <form method="POST" action="{{ asset('/admin/blog/update') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="form-group">
                            <h3>Выберите фон</h3>
                            <label class="file_upload">
                                <span class="button bg-primary">Заменить</span>
                                <mark class="mark-input-file">{{ asset($blog->image_path) }}</mark>
                                <input type="file" name="image_path" id="bg-image"  accept="image/jpeg,image/png,image/gif" >
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <h3>Краткое название новости</h3>
                            <input type="text"  class="form-control" name="label" value="{{ $blog->label }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <textarea class="mytextarea  d-none" name="text">{!! $blog->text !!}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="col-12 col-sm-6 wrapper-checkbox">
                            <input type="checkbox" name="block" value="1" id="remember" class="css-checkbox form-check-input" {{ ($blog->block == '1')? 'checked' : '' }}>
                            <label for="remember" class="form-check-label css-label radGroup1">В раздачу</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 w-100">Подтвердить изменения</button>
            </form>

        </div>
    </div>
@endsection
