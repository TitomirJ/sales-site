@extends('admin.layouts.app')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid mt-5">



            <div class="row">
                <div class="col-12">
                    <h2 class="text-center">{{$subcategory->name}} (BigSales)</h2>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
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
                                    <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                        ID Розетки
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

                            @forelse($subcategory->parametrs as $parametr)
                                <tr class="text-center bor-bottom">
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
                                        {{$parametr->rozet_id}}
                                    </td>
                                    <td class="font-weight-bold">
                                        @forelse($parametr->values as $value)
                                            {!! $value->name !!} <br>
                                        @empty
                                            Значений по умолчанию нет
                                        @endforelse
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center" >Параметры отсутствуют</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>





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
