@extends('admin.layouts.app')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid mt-5">



            <div class="row">
                <div class="col-12">
                    <h2 class="text-center">{{ $rozetka_subcat_name }} (Розетка)</h2>
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

                            @forelse($params_array as $parametr => $values)
                                <tr class="text-center bor-bottom">
                                    <td class="font-weight-bold">
                                        {{ $values[0]['id'] }}
                                    </td>
                                    <td class="font-weight-bold">
                                        @if(isset($array_check_param))
                                            @if(!in_array($values[0]['id'],$array_check_param))
                                                {{$parametr}} <span class="badge badge-success">NEW</span>
                                            @else
                                                {{$parametr}}
                                            @endif
                                        @else
                                            {{$parametr}}
                                        @endif

                                    </td>
                                    <td class="font-weight-bold">
                                        {{ $values[0]['attr_type'] }}
                                    </td>
                                    <td class="font-weight-bold">
                                        {{ $values[0]['id'] }}
                                    </td>
                                    <td class="font-weight-bold">

                                            @foreach($values as $value)
                                                @if($value['value_name'] == null)
                                                    значений по умолчанию нет
                                                @else
                                                    @if(isset($array_check_values))
                                                        @if(!in_array($value['value_id'] ,$array_check_values))
                                                            {!! $value['value_name'] !!} <span class="badge badge-success">NEW</span>  <br>
                                                        @else
                                                            {!! $value['value_name'] !!}   <br>
                                                        @endif
                                                    @else
                                                        {!! $value['value_name'] !!}   <br>
                                                    @endif
                                                @endif
                                            @endforeach


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
