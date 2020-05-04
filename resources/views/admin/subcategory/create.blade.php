@extends('admin.layouts.app')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            @include('admin.layouts.breadcrumbs')

            <div class="row">
                <div class="col-12">
                    <h2 class="text-center">Создание новой подкатегории</h2>
                    <div class="dropdown-divider"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">

                    <form class="form-horizontal" method="POST" action="{{ asset('/admin/subcategories') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="category-id">Выбрать категорию</label>
                            <select class="form-control category-select2" id="category-id" name="category_id">
                                @forelse($categories as $category)
                                    <option value="{{ $category->id }}"
                                    @if(isset($selected_category_id))
                                        @if($selected_category_id == $category->id)
                                            selected
                                        @endif
                                    @endif
                                    >{{ $category->name }}</option>
                                @empty
                                    <option value="0">Категории отсутствуют</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Название подкатегории</label>
                            <input id="name" type="text" class="form-control{{ session('errorsArray.name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="commission">Размер комиссии</label>
                            <input id="commission" type="text" class="commission-mask form-control{{session('errorsArray.commission') ? ' is-invalid' : '' }}" name="commission" value="{{ old('commission') }}" required>
                        </div>

                        <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">
                            Добавить подкатегорию
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>


    <script>

    </script>


@endsection

@section('script2')
    <script>
        $(document).ready(function(){
            $('.category-select2').select2({
                placeholder: 'категории не найдены',
            });
        });
    </script>
@endsection
