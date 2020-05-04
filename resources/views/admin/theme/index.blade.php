@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/adminThemes/adminThemes.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">

            @include('/admin/layouts/navButtons')

            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center mt-5 mb-5">
                  <div class="f30 text-uppercase blue-d-t">
                      Тематики (родительские категории)
                  </div>
                  <form action="{{ asset('/admin/search/theme') }}" method="GET" class="select-w">
                      <select class="select2-theme form-control" name="theme_id">
                          @foreach($themes_all as $theme)
                              <option value="{{ $theme->id }}">{{ $theme->name }}</option>
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
                                название тематики
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                                кол-во категорий
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                кол-во подкатегорий
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap radius-top-right border-right">
                                кол-во товаров
                            </div>
                        </th>
                        <!-- <th scope="col" class="h-60">
                          <div class="d-block h-100 p-3 border-top border-bottom border-blue  text-nowrap">
                              Действие
                          </div>
                        </th> -->
                    </tr>
                    </thead>

                    <tbody id="orders-place" class="table-bg">
                    @foreach($themes as $t)
                        <tr class="text-center bor-bottom">
                            <td class="font-weight-bold">
                                <a href="{{ asset('/admin/themes/'.$t->id) }}">{{$t->name}}</a>
                            </td>
                            <td class="font-weight-bold">
                                {{$t->categories->count()}}
                            </td>
                            <td class="font-weight-bold">
                                {{$count_subcat[$t->id]}}
                            </td>
                            <td class="font-weight-bold">
                                {{$count_products[$t->id]}}
                            </td>
                            <!-- <td class="font-weight-bold">
                              <a href="#" class="d-inline-flex link text-dark btn-edit" title="Редактировать тематику">
                                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                              </a>
                            </td> -->
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {{$themes->links()}}
            </div>

        </div>
    </div>






@endsection

@section('script2')
<script type="text/javascript">
    $('.select2-theme').select2({
        placeholder: 'Категории не найдены'
    });
</script>
@endsection
