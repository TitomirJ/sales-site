@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center mt-5 mb-5">
                <div class="text-uppercase blue-d-t f20 w-100">
                    Компания: {{ $external->company->name }}
                </div>
            </div>

            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center mt-5 mb-5">
                <div class="text-uppercase blue-d-t f20 w-100 text-center">
                    @if(isset($type))
                        @if($type == 'all')
                            Все товары (YML файл № {{ $external->id }})
                        @elseif($type == 0)
                            Не привязаные товары (YML файл № {{ $external->id }})
                        @elseif($type == 1)
                            Привязаные товары (YML файл № {{ $external->id }})
                        @elseif($type == 2)
                            Провереные товары (YML файл № {{ $external->id }})
                        @elseif($type == 3)
                            Добавленные товары (YML файл № {{ $external->id }})
                        @elseif($type == 4)
                            Товары с ошибками (YML файл № {{ $external->id }})
                        @endif
                    @else
                        Все товары (YML файл № {{ $external->id }})
                    @endif
                </div>
            </div>


            @if(isset($type))
                @if($type == 'all')
                    @include('admin.prom.external.show.products.layouts.itemProductAll')
                @elseif($type == 0)
                    @include('admin.prom.external.show.products.layouts.itemProductNew')
                @elseif($type == 1)
                    @include('admin.prom.external.show.products.layouts.itemProductLink')
                @elseif($type == 2)
                    @include('admin.prom.external.show.products.layouts.itemProductChecked')
                @elseif($type == 3)
                    @include('admin.prom.external.show.products.layouts.itemProductCreated')
                @elseif($type == 4)
                    @include('admin.prom.external.show.products.layouts.itemProductErrors')
                @endif
            @else
                @include('admin.prom.external.show.products.layouts.itemProductAll')
            @endif

        </div>
    </div>
    

    @include('admin.prom.category.layouts.modals')

@endsection

@section('script2')
    <script src="{{ asset('js/pages/admin/prom/external_show_prod.js') }}"></script>
@endsection
