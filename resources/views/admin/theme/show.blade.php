@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/modules/checkbox.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
          <a class="back-to-login font-weight-light text-white btn square_btn shadow-custom text-uppercase border-radius-50 mt-3" onclick="javascript:history.back(); return false;">
            <i class="fa fa-angle-left"></i>
              Назад
          </a>
            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center  mt-5 mb-5">
                  <div class="text-uppercase blue-d-t f30">
                    Тематика: {{ $theme->name }}
                  </div>
                  <form action="{{ asset('/admin/search/category') }}" method="GET" class="select-w">
                      <select class="select2-cat form-control" name="category_id">
                          @foreach($categories_all as $category)
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                          @endforeach
                      </select>
                      <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 w-100 mt-1">Поиск</button>
                  </form>
            </div>
            <div class="table-responsive scroll_wrap">
              <table class="table position-relative scroll_me">
                <thead>
                    <tr class="tb-head text-uppercase blue-d-t text-center">
                        <th scope="col" class="h-60">
                            <div class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link text-nowrap">
                              id
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                              наименование (категорий)
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                              комиссия
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                              товары(шт)
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap radius-top-right border-right">
                              действия
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody id="orders-place" class="table-bg">

                  @forelse($categories as $category)
                  <tr class="text-center bor-bottom">
                    <td class="font-weight-bold">
                      {{$category->id}}
                    </td>
                    <td class="font-weight-bold">
                      <a class="on-overlay-loader" href="{{ asset('admin/categories/'.$category->id) }}">{{$category->name}}</a>
                    </td>
                    <td class="font-weight-bold">
                      {{$category->commission}} %
                    </td>
                    <td class="font-weight-bold">
                      {{$category->products->count()}}
                    </td>
                    <td class="font-weight-bold">
                      <a href="{{asset('/admin/categories/'.$category->id.'/edit')}}" class="text-warning mr-2 admin-edit-pr" title="Редактировать категорию"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    </td>
                  </tr>
                  @empty
                      <tr>
                          <td colspan="6" class="text-center" >Категории отсутствуют</td>
                      </tr>
                  @endforelse

                </tbody>
              </table>
            </div>

            @if(Auth::user()->isAdmin())

                    <button type="button"  class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 admin-cr-pr" data-url="{{ asset('admin/categories/create') }}" data-theme-id="{{ $theme->id }}">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Добавить категорию
                    </button>

            @endif

            {{$categories->links()}}
        </div>
    </div>

@endsection

@section('script2')
    <script type="text/javascript">
        $('.select2-cat').select2({
            placeholder: 'Категории не найдены'
        });
    </script>
@endsection
