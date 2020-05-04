@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">

          @include('/admin/layouts/navButtons')

            <?
            //проверка конфликтующих подкатегорий
                $check_array = $test_array;
            ?>
            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center mt-5 mb-5">
                <div class="text-uppercase blue-d-t f30">
                    подкатегории
                </div>
                <form action="{{ asset('/admin/search/subcategory') }}" method="GET" class="select-w">
                    <select class="select2-subcat form-control" name="subcategory_id">
                        @foreach($subcategories_all as $subcategory)
                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 w-100 mt-1">Поиск</button>
                </form>
            </div>
            <table class="table position-relative table-responsive-xl">
                <thead>
                <tr class="tb-head text-uppercase blue-d-t text-center">
                    <th scope="col" class="h-60">
                        <div class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link text-nowrap">
                            id
                        </div>
                    </th>
                    <th scope="col" class="h-60">
                        <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                            наименование (подкатегории)
                        </div>
                    </th>
                    <th scope="col" class="h-60">
                        <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                            категория
                        </div>
                    </th>
                    <th scope="col" class="h-60">
                        <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                            комиссия
                        </div>
                    </th>
                    <th scope="col" class="h-60">
                        <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                            ко-во опций
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

                @forelse($subcategories as $subcategory)
                    <tr class="text-center bor-bottom" id="subcat-block-{{$subcategory->id}}">
                        <td class="font-weight-bold">
                            @if(in_array($subcategory->id, $check_array) && $subcategory->products->count() > 0)
                                <span class="badge badge-danger">{{$subcategory->id}}</span>
                            @else
                                <span class="badge badge-success">{{$subcategory->id}}</span>
                            @endif
                        </td>
                        <td class="font-weight-bold">
                            <a href="{{ asset('admin/subcategories/'.$subcategory->id) }}">{{$subcategory->name}}</a>
                        </td>
                        <td class="font-weight-bold">
                            <a href="{{ asset('admin/categories/'.$subcategory->category->id) }}">{{$subcategory->category->name}}</a>
                        </td>
                        <td class="font-weight-bold">
                            {{$subcategory->commission}} %
                        </td>
                        <td class="font-weight-bold">
                            {{$subcategory->parametrs->count()}}
                        </td>
                        <td class="font-weight-bold">
                            {{$subcategory->products->count()}}
                        </td>
                        <td class="font-weight-bold">
                            <a href="{{asset('/admin/subcategories/'.$subcategory->id.'/edit')}}" class="text-warning mr-2 admin-edit-subcat" data-type="false" title="Редактировать подкатегорию"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            @if($subcategory->deleted_at == null)
                            <a href="{{asset('/admin/check/subcategory/'.$subcategory->id)}}" class="text-danger mr-2 admin-delete-subcat" data-type="false" title="Удалить подкатегорию"><i class="fa fa-times" aria-hidden="true"></i></a>
                            @else
                                <i class="fa fa-times text-success" aria-hidden="true"></i>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" >Подкатегории отсутствуют</td>
                    </tr>
                @endforelse

                </tbody>
            </table>
            @if(Auth::user()->isAdmin())
                <form action="{{ asset('/admin/api/rozetka/subcategory') }}" method="GET">
                    <button type="submit"  class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 ">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Добавить подкатегорию
                    </button>
                </form>
            @endif
            {{ $subcategories->links() }}
        </div>
    </div>






@endsection

@section('script2')
    <script type="text/javascript">
        $('.select2-subcat').select2({
            placeholder: 'Подкатегории не найдены'
        });
    </script>
@endsection
