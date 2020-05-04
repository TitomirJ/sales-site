@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <a class="back-to-login font-weight-light text-white btn square_btn shadow-custom text-uppercase border-radius-50 mt-3" onclick="javascript:history.back(); return false;">
                <i class="fa fa-angle-left"></i>
                Назад
            </a>
            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
                <div class="text-uppercase blue-d-t">
                    Податегория: <a href="{{asset('/admin/subcategories/'.$subcategory->id.'/edit')}}" class="text-warning mr-2 admin-edit-subcat" data-type="true" title="Редактировать подкатегорию">{{ $subcategory->name }}<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    @if($subcategory->deleted_at == null)
                    <a href="{{asset('/admin/check/subcategory/'.$subcategory->id)}}" class="text-danger mr-2 admin-delete-subcat" data-type="false" title="Удалить подкатегорию"><i class="fa fa-times" aria-hidden="true"></i></a>
                    @else
                        <a>(Удалено)</a>
                    @endif
                </div>
            </div>
            <div class="row mt-5 mb-5 bg-warning">
                <h4>Обновление и создание характеристик (Excel - файл)</h4>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ asset('admin/update/params/subcategory/'.$subcategory->id) }}"  enctype="multipart/form-data" method="POST" id="excel-params-subcat-update">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="excel-file">Выбирете файл(excel) с характеристиками Розетки</label>
                                    <input type="file" name="excel_file" id="excel-file"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn square_btn shadow-custom text-uppercase" id="update-subcat-form-button" form="excel-params-subcat-update">
                                обновить
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="text-uppercase blue-d-t">
                Категория: <a href="{{asset('/admin/categories/'.$subcategory->category->id )}}">{{ $subcategory->category->name }}</a>
            </div>
            <div class="text-uppercase blue-d-t">
                Комиссия: {{ $subcategory->commission }} %
            </div>

            <div class="table-responsive scroll-wrap">
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
                                наименование (параметра)
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                тип инпута
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap radius-top-right border-right">
                                значения
                            </div>
                        </th>
                    </tr>
                    </thead>

                    <tbody id="orders-place" class="table-bg">

                    @forelse($parametrs as $parametr)
                        <tr class="text-center bor-bottom" id="subcat-block-{{$parametr->id}}">
                            <td class="font-weight-bold">
                                {{$parametr->id}}
                            </td>
                            <td class="font-weight-bold">
                                {{$parametr->name}}
                            </td>
                            <td class="font-weight-bold">
                                {{$parametr->attr_type}}
                            </td>
                            <td class="font-weight-bold">
                                @forelse($parametr->values as $value)
                                    {!! $value->name.'<br>' !!}
                                @empty
                                    Значений по умолчанию нет
                                @endforelse
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center" >Параметры отсутствуют</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <div class="modal fade" id="confirm-modal-update-subcat" tabindex="-1" role="dialog" aria-labelledby="confirm-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-center w-100" id="confirm-modal-title">Внимание!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Вы уверены, что хотите выполнить это действие?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="confirm-success-button">применить</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">отменить</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script2')
    <script>
        (function($, undefined){
            $(function(){


                $('#update-subcat-form-button').on('click', function (e) {
                    e.preventDefault();
                    $('#confirm-modal-update-subcat').modal();
                });
                $('#confirm-success-button').on('click', function (e) {
                    e.preventDefault();
                    var form = $('#excel-params-subcat-update');
                    var dataForm = $('#excel-file').val();
                    if(dataForm != ''){
                        form.submit();
                    }else{
                        $.toaster({ message : "Не выбран файл для отправки!", title : '', priority : 'warning', settings : {'timeout' : 3000} });
                    }
                    $('#confirm-modal-update-subcat').modal('hide');
                });

            });
        })(jQuery);
    </script>
@endsection
