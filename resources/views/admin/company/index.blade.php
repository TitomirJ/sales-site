@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/admin/companies/company.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

          <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
              <div class="text-uppercase blue-d-t">
                  Компании
              </div>
          </div>

            <div class="row">
                <div class="col-12">
                    <h5>Выберите фильтры:</h5>
                </div>
                <form action="{{ asset('admin/filter/companies') }}" method="GET" id="company-filter"></form>
                <div class="col-12 col-md-3 mb-1 m-md-0">
                    <input type="text" name="name_like_percent" class="p-1 pl-2 w-100 action-filter-company" form="company-filter" placeholder="Введите название">
                </div>

                @if(Auth::user()->isAdmin())
                <div class="col-12 col-md-3 mb-1 m-md-0">
                    <input type="text" name="responsible_phone_like_percent" class="mask-tel action-filter-company p-1 pl-2 w-100" form="company-filter" autocomplete="off" placeholder="Введите номер">
                </div>
                @endif

                <div class="col-12 col-md-3 mb-1 m-md-0">
                    <select name="company_status_block" class="action-filter-company-c filter-select2" form="company-filter" id="">
                        <option value="all">Все</option>
                        <option value="active">Активна</option>
                        <option value="not_active">Не активна</option>
                        <option value="blocked">Заблокировна</option>
                    </select>
                </div>
                <div class="col-12 col-md-3 mb-1 m-md-0">
                    <select name="company_online" id="" class="action-filter-company-c filter-select2" form="company-filter">
                        <option value="all">Все</option>
                        <option value="online">Онлайн</option>
                        <option value="offline">Оффлайн</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    Всего компаний: {{ $count_companies }}
                </div>
            </div>

          <div class="row mt-3">
            <div class="col-12">
                <div id="overlay-loader" class="table-overlay-loader" style="position: absolute">
                    <div id="loader"></div>
                </div>
              <div class="table-responsive scroll_wrap">

                <table class="table position-relative scroll_me">

                  <thead>
                      <tr class="tb-head text-uppercase blue-d-t text-center">
                          <th scope="col" class="h-60">
                              <div class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link text-nowrap">
                                название
                              </div>
                          </th>
                          <th scope="col" class="h-60">
                              <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                      on-line
                              </div>
                          </th>

                          @if(Auth::user()->isAdmin())
                              <th scope="col" class="h-60">
                                  <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                      телефон
                                  </div>
                              </th>
                          @endif

                          <th scope="col" class="h-60">
                              <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                                  статус
                              </div>
                          </th>
                          <th scope="col" class="h-60">
                              <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                депозит
                              </div>
                          </th>
                          <th scope="col" class="h-60">
                              <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                кол-во товаров
                              </div>
                          </th>
                          @if(Auth::user()->isAdmin())
                              <th scope="col" class="h-60">
                                  <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                    кол-во заказов
                                  </div>
                              </th>
                              <th scope="col" class="h-60">
                                  <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap radius-top-right border-right">
                                    действия
                                  </div>
                              </th>
                          @else
                              <th scope="col" class="h-60">
                                  <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap radius-top-right border-right">
                                      кол-во заказов
                                  </div>
                              </th>
                          @endif
                      </tr>
                  </thead>

                  <tbody id="companies-place" class="table-bg">
                      @include('admin.company.layouts.indexCompany.itemCompany')
                  </tbody>

                </table>

              </div>

            </div>
          </div>

        </div>
    </div>

@endsection

@section('script2')
    <script src="{{ asset('js/pages/admin/com/index_com.js') }}"></script>
@endsection
