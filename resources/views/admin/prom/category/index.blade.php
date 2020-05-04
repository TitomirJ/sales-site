@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center mt-5 mb-5">
                <div class="text-uppercase blue-d-t f30">
                    подкатегории XML  ссылок
                </div>

            </div>
            <div class="table-responsive">
                <table class="table position-relative table-prom-cat">
                    <thead>
                    <tr class="tb-head text-uppercase blue-d-t text-center">
                        <th scope="col" class="h-60">
                            <div class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link text-nowrap">
                                id
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block h-100 p-3  border-top border-bottom border-blue text-nowrap dark-link text-nowrap">
                                компания
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                                наименование (категории)
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                ко-во товаров
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap radius-top-right border-right">
                                привязать
                            </div>
                        </th>
                    </tr>
                    </thead>

                    <tbody id="orders-place" class="table-bg">

                    @forelse($prom_cats as $prom_cat)
                        <tr class="text-center bor-bottom item-cat-{{ $prom_cat->id }}">
                            @include('admin.prom.category.layouts.itemPromCat')
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center" >категории отсутствуют</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
                {{ $prom_cats->links() }}
            </div>


        </div>
    </div>





@include('admin.prom.category.layouts.modals')

@endsection

@section('script2')
    <script src="{{ asset('js/pages/admin/prom/index_cat.js') }}"></script>
@endsection
