@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center mt-5 mb-5">
                <div class="text-uppercase blue-d-t f20 w-100 text-center">
                    Не созданные товары
                </div>
            </div>

            <table class="table position-relative table-responsive-xl table-prom-pro-all">
                <thead>
                <tr class="tb-head text-uppercase blue-d-t text-center">
                    <th scope="col" class="h-60">
                        <div class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link text-nowrap">
                            компания
                        </div>
                    </th>
                    <th scope="col" class="h-60">
                        <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                            изображения
                        </div>
                    </th>
                    <th scope="col" class="h-60">
                        <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                            найменование
                        </div>
                    </th>
                    <th scope="col" class="h-60">
                        <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                            категория(YML)
                        </div>
                    </th>
                    <th scope="col" class="h-60">
                        <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                            категория(BigSales)
                        </div>
                    </th>
                    <th scope="col" class="h-60">
                        <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                            ошибки
                        </div>
                    </th>
                    <th scope="col" class="h-60">
                        <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap radius-top-right border-right">
                            статус
                        </div>
                    </th>
                </tr>
                </thead>

                <tbody id="product-place" class="table-bg">

                @forelse($products as $product)
                    <tr class="text-center bor-bottom item-product-{{ $product->id }}">
                        @include('admin.prom.products.layouts.itemProduct')
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="text-center" >ссылки отсутствуют</td>
                    </tr>
                @endforelse

                </tbody>
            </table>
            {{ $products->links() }}

        </div>
    </div>





    @include('admin.prom.category.layouts.modals')

@endsection

@section('script2')
    <script src="{{ asset('js/pages/admin/prom/external_show_prod.js') }}"></script>
@endsection
