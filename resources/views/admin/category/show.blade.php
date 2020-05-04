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

            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center mt-5 mb-5">
                <div class="text-uppercase f30  blue-d-t">
                    Категория: <a href="{{asset('/admin/categories/'.$category->id.'/edit')}}" class="text-warning admin-edit-pr" title="Редактировать категорию">{{ $category->name }} <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
                                наименование (подкатегории)
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

                    @forelse($subcategories as $subcategory)
                        <tr class="text-center bor-bottom" id="subcat-block-{{$subcategory->id}}">
                            <td class="font-weight-bold">
                                {{$subcategory->id}}
                            </td>
                            <td class="font-weight-bold">
                                <a href="{{ asset('admin/subcategories/'.$subcategory->id) }}">{{$subcategory->name}}</a>
                            </td>
                            <td class="font-weight-bold">
                                {{$subcategory->commission}} %
                            </td>
                            <td class="font-weight-bold">
                                {{$subcategory->products->count()}}
                            </td>
                            <td class="font-weight-bold">
                                <a href="{{asset('/admin/subcategories/'.$subcategory->id.'/edit')}}" class="text-warning mr-2 admin-edit-subcat" data-type="true" title="Редактировать подкатегорию"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                @if($subcategory->deleted_at == null)
                                    <a href="{{asset('/admin/check/subcategory/'.$subcategory->id)}}" class="text-danger mr-2 admin-delete-subcat" data-type="false" title="Удалить подкатегорию"><i class="fa fa-times" aria-hidden="true"></i></a>
                                @else
                                    <i class="fa fa-times text-success" aria-hidden="true"></i>
                                @endif                        </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" >Подкатегории отсутствуют</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>

                    @if(Auth::user()->isAdmin())
                        <form action="{{asset('/admin/api/rozetka/subcategory')}}" method="GET">
                            <button type="submit"  class="btn btn-primary btn-lg w-100 mt-2 mb-3">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Добавить подкатегорию
                            </button>
                        </form>
                    @endif
{{ $subcategories->links() }}
                </div>
@endsection


@section('script2')
    <script type="text/javascript">
        $('.select2-subcat').select2({
            placeholder: 'Подкатегории не найдены'
        });
    </script>
@endsection
