@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/modules/checkbox.css') }}">
@endsection

@section('content')
    <?
    // удалить после правки категорий
            $check_array = $test_array;
    ?>
    <div class="content-wrapper">
        <div class="container-fluid">

          @include('/admin/layouts/navButtons')

          <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center mt-5 mb-5">
              <div class="text-uppercase blue-d-t f30">
                  категории
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
            <div class="row">
                <div class="col-12">

                    <div class="table-responsive scroll_wrap">
                        <table class="table text-center scroll_me">
                            <thead>
                                <tr class="tb-head text-uppercase blue-d-t text-center">
                                    <th scope="col" class="h-60">
                                        <div class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link text-nowrap">
                                          id
                                        </div>
                                    </th>
                                    <th scope="col" class="h-60">
                                        <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                                            Наименование
                                        </div>
                                    </th>
                                    <th scope="col" class="h-60">
                                        <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                         Тематика
                                        </div>
                                    </th>
                                    <th scope="col" class="h-60">
                                        <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                            Ко-во подкатегорий
                                        </div>
                                    </th>
                                    <th scope="col" class="h-60">
                                        <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                            Ко-во товаров
                                        </div>
                                    </th>
                                    <th scope="col" class="h-60">
                                        <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                          Комиссия
                                        </div>
                                    </th>

                                    <th scope="col" class="h-60">
                                        <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap radius-top-right border-right">
                                          Действия
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table-bg">
                            @forelse($categories as $category)
                                <tr class="text-center bor-bottom">
                                    <td class="font-weight-bold">
                                        @if(in_array($category->id, $check_array))
                                            <span class="badge badge-danger">{{$category->id}}</span>
                                        @else
                                            <span class="badge badge-success">{{$category->id}}</span>
                                        @endif
                                    </td>
                                    <td class="font-weight-bold"></a><a href="{{ asset('/admin/categories/'.$category->id) }}">{{$category->name}}</a></td>
                                    <td class="font-weight-bold"><a href="{{ asset('admin/themes/'.$category->themes[0]->id) }}">{{ $category->themes[0]->name }}</td>
                                    <td class="font-weight-bold">{{$category->subcategories->count()}}</td>
                                    
									<td class="font-weight-bold">
                                        <?php $prod = \DB::table('products')->where('category_id',$category->id)->count();  ?>                                
                                        {{$prod}}
                                          </td>
                                    <td class="font-weight-bold">{{$category->commission}} %</td>

                                    <td class="font-weight-bold">
                                        <a href="{{asset('/admin/categories/'.$category->id.'/edit')}}" class="text-warning mr-2 admin-edit-pr"  data-type="true" title="Редактировать категорию"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center font-weight-bold">Категории отсутствуют</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(Auth::user()->isAdmin())

                        <button type="button"  class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 admin-cr-pr" data-url="{{ asset('admin/categories/create') }}" data-theme-id="null">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            Добавить категорию
                        </button>
                    @endif
                    {{$categories->links()}}
                </div>
            </div>

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