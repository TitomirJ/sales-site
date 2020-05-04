@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center mt-5 mb-5">
                <div class="text-uppercase blue-d-t f20 w-100 text-center">
                    Ссылки ЮМЛ файлов для итеграции
                </div>
            </div>

            <div class="table-responsive">
                <table class="table position-relative table-prom-externals">
                    <thead>
                    <tr class="tb-head text-uppercase blue-d-t text-center">
                        <th scope="col" class="h-60">
                            <div class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link text-nowrap">
                                id
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                                компания
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                создан
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                статус
                            </div>
                        </th>
                        <th scope="col" class="h-60">
                            <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap radius-top-right border-right">
                                действия
                            </div>
                        </th>
                    </tr>
                    </thead>

                    <tbody id="externals-place" class="table-bg">

                    @forelse($externals as $external)
                        <tr class="text-center bor-bottom item-ext-{{ $external->id }}">
                            @include('admin.prom.external.layouts.itemExternal')
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center" >ссылки отсутствуют</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>

                {{ $externals->links() }}
            </div>

        </div>
    </div>





    @include('admin.prom.external.layouts.modals')

@endsection

@section('script2')
    <script src="{{ asset('js/pages/admin/prom/external_index.js') }}"></script>
@endsection
