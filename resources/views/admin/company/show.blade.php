@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/admin/companies/show.css') }}">
    <link href="{{ asset('css/datapicker/datepicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/modules/switchBtn.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modules/checkbox.css') }}">
@endsection

@section('script1')
    <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
    <script src="{{ asset('js/datapicker/datepicker.min.js') }}"></script>
@endsection

@section('content')
  <div class="content-wrapper">
      <div class="container-fluid">

          <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
              <div class="text-uppercase blue-d-t">
                  Компания
                  @if(Auth::user()->isAdmin())
                      <a class="d-block-inline text-warning" href="{{ asset('/admin/company/'.$company->id.'/edit?type=info') }}" title="Редактировать компанию">
                          <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                      </a>
                  @endif
              </div>
          </div>

          @if(Auth::user()->isSuperAdmin())
              <a href="{{ asset('admin/delete/forse/products/'.$company->id) }}" text="Данное действие приведет к полному удалению всех товаров компании без возможности востановить. Нет защиты от сохранения заказов по товарам, нужно доделать!" class="btn btn-danger confirm-modal">Очистить товары компании</a>
          @endif

          <div class="row font-weight-bold">
            <div class="col-12 col-md-4 d-flex flex-column align-items-center justify-content-center">
              <div class="f30">Название</div>
              <div>{{$company->name}}</div>
            </div>
            <div class="col-12 col-md-4 d-flex flex-column align-items-center justify-content-center">
              <div class="f30">Депозит
                  @if(Auth::user()->isAdmin())
                      <a href="{{ asset('admin/company/'.$company->id.'/recalculation/balance') }}">
                          <i class="fa fa-refresh text-success" aria-hidden="true"></i>
                      </a>
                  @endif
              </div>
              @if($company->balance_sum < $company->balance_limit)
                <div class="text-danger">{{$company->balance_sum}} грн</div>
                @else
                <div class="text-success">{{$company->balance_sum}} грн</div>
              @endif
            </div>
            <div class="col-12 col-md-4 d-flex flex-column align-items-center justify-content-center">
              <div class="f30">Статус</div>
              @if($company->blocked == '1')
                <span class="badge badge-pill badge-danger">заблокирована</span>
                @elseif($company->block_ab == '0' && $company->block_bal == '0' && $company->block_new == '0' && $company->blocked == '0')
                <span class="badge badge-pill badge-success">Активна</span>
                @else
                <span class="badge badge-pill badge-warning">Не активна</span>
              @endif
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-12 mt-2">
              <div class="f30 font-weight-bold">
                Общая информация:
              </div>
            </div>
              <div class="col-12 mt-2">
                  <div>Дата регистрации: {{(new Date($company->created_at))->format('j F Y')}} г.</div>
              </div>
              <div class="col-12 mt-2">
                  <div>
                      @if($company->block_new == '1')
                          Дата окончания пробного периода: {{(new Date($company->ab_to))->format('j F Y')}} г.
                      @elseif($company->block_new == '0')
                          Дата окончания абонплаты: {{(new Date($company->ab_to))->format('j F Y')}} г.
                      @endif
                  </div>
              </div>
          <div class="col-12 mt-2">
              <div>Юридические данные: {{$company->legal_person}}</div>
          </div>
            <div class="col-12 mt-2">
              <div>Ссылка на сайт: <a href="{{url('//'.$company->link)}}">{{$company->link}}</a></div>
            </div>
            <div class="col-12 mt-2">
              <div>Ответственное лицо: {{$company->responsible}}</div>

            </div>
              @if(Auth::user()->isAdmin())
                <div class="col-12 mt-2">
                  <div>Номер ответственного: <a href="tel:{{$company->responsible_phone}}">{{$company->responsible_phone}}</a></div>
                </div>
              @endif
            <div class="col-12 mt-2">
              <div>Про компанию:</div>
                <a class="btn square_btn shadow-custom text-uppercase border-radius-50" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Подробнее
                </a>
            </div>
            <div class="col-12 mt-2">
                <div class="collapse" id="collapseExample">
                    <div class="card card-body border-radius shadow-custom">
                        {!! nl2br(htmlspecialchars($company->info)) !!}
                    </div>
                </div>
            </div>
          </div>

          <div class="row mt-3" id="tabs-block">

            <div class="col-12">

              <ul class="nav nav-pills flex-column flex-xl-row flex-nowrap nav-justified text-uppercase mb-3" id="pills-tab" role="tablist">
                  @if(Auth::user()->isAdmin())
                      <li class="nav-item products-tab ml-5 mr-5 border-bot radius-top-left radius-top-right">
                          <a class="nav-link rounded-0 dark-link text-nowrap font-weight-bold" id="pills-transactions-tab" data-toggle="pill" href="#pills-transactions" role="tab" aria-controls="pills-transactions" aria-selected="true">транзакции</a>
                      </li>
                  @endif
                  <li class="nav-item products-tab ml-5 mr-5 border-bot radius-top-left radius-top-right">
                      <a class="nav-link rounded-0 dark-link active text-nowrap font-weight-bold" id="pills-products-tab" data-toggle="pill" href="#pills-products" role="tab" aria-controls="pills-products" aria-selected="false">товары</a>
                  </li>
                  @if(Auth::user()->isAdmin())
                      <li class="nav-item products-tab ml-5 mr-5 border-bot radius-top-left radius-top-right">
                          <a class="nav-link rounded-0 dark-link text-nowrap font-weight-bold" id="pills-orders-tab" data-toggle="pill" href="#pills-orders" role="tab" aria-controls="pills-orders" aria-selected="false">заказы</a>
                      </li>
                  @endif
              </ul>

              <div class="tab-content" id="pills-tabContent">
                  @if(Auth::user()->isAdmin())
                  <div class="tab-pane fade" id="pills-transactions" role="tabpanel" aria-labelledby="pills-home-tab">

                      <div>
                          <div id="overlay-loader" class="table-overlay-loader" style="position: absolute">
                              <div id="loader"></div>
                          </div>
                          <h5>Выберите фильтры:</h5>
                          <div class="row">
                              <form action="{{ asset('admin/company/'.$company->id.'/filter/transactions') }}" id="filter-transactions"></form>
                              <div class="col-12 col-md-6 d-flex justify-content-center">
                                  <input type="text" placeholder="Выберите даты" name="transaction_dpk_interval" class="w-100 p-1 pl-2 dpk-transactions" form="filter-transactions">
                              </div>
                              <div class="col-12 col-md-6 d-flex justify-content-center mt-1 mb-1 m-md-0">
                                  <select name="type_transaction" id="" class="filter-select2 h-100 action-filter-company" form="filter-transactions">
                                      <option value="all">Все виды транзакций</option>
                                      <option value="3">Пополнение абонплаты</option>
                                      <option value="0">Пополнение депозита</option>
                                      <option value="1">Комиссия за заказ</option>
                                      <option value="2">Удаленная транзакция</option>
                                  </select>
                              </div>

                          </div>
                      </div>

                      <div class="wrapper-table mt-2">
                          <div class="header-table bg-white border text-uppercase border-blue d-flex justify-content-between position-relative p-3">
                            <div>дата</div>
                            <div>тип</div>
                            <div>сумма</div>
                          </div>
                          <div class="content-table content-table-history table-bg-commision" id="transactions-place">
                            @include('admin.company.layouts.showCompany.transactionsCompany')
                          </div>
                      </div>
                  </div>
                    @endif
                  <div class="tab-pane fade show active" id="pills-products" role="tabpanel" aria-labelledby="pills-profile-tab">
                      <div class="row">
                          <div class="col-12">
                              <h5>Выберите фильтры:</h5>
                          </div>
                      </div>

                      <div class="row">
                          <form action="{{ asset('admin/company/'.$company->id.'/filter/products') }}" id="filter-products"></form>
                          <div class="col-12 col-md-3">
                              <input type="number" name="product_id" class="w-100 p-1 mb-1 noscroll quantity action-filter-company" placeholder="Id" form="filter-products">
                          </div>
                          <div class="col-12 col-md-3">
                              <input type="text" name="name_like_persent" class="w-100 p-1 mb-1 action-filter-company" placeholder="Наименование" form="filter-products">
                          </div>
                          <div class="col-12 col-md-3">
                              <?
                                  $array_subcats = [];
                                  foreach ($all_company_products as $product){
                                      if(!array_key_exists($product->subcategory_id, $array_subcats)){
                                          $array_subcats[$product->subcategory_id] = $product->subcategory->name;
                                      }
                                  }
                              ?>
                              <select name="subcategory_id" id="" class="filter-select2 mb-1 action-filter-company" form="filter-products">
                                  <option value="all">Все категории</option>
                                  @foreach($array_subcats as $key => $velue)
                                      <option value="{{ $key }}">{{ $velue }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-12 col-md-3">
                              <input type="number" step="any" min="0" name="price_like" class="w-100 p-1 mb-1 noscroll action-filter-company" placeholder="Цена" form="filter-products">
                          </div>
                      </div>

                      <div class="row justify-content-center">
                          <div class="col-12 col-md-3">
                              <input type="number" step="any" min="0" name="product_subcat_commission_like" class="w-100 p-1 mb-1 noscroll quantity action-filter-company" placeholder="Комиссия" form="filter-products">
                          </div>

                          <div class="col-12 col-md-3">
                              <select name="status_moderation_equally" id="" class="filter-select2 mb-1 action-filter-company" form="filter-products">
                                  <option value="all">Все статусы</option>
                                  <option value="0">На модерации</option>
                                  <option value="1">Отправлен на маркетплейс</option>
                                  <option value="2">Невалидный контент</option>
                                  <option value="3">Заблокированый товар</option>
                                  <option value="deleted">Удален</option>
                              </select>
                          </div>
                          <div class="col-12 col-md-3">
                              <input type="text" placeholder="Выберите даты" name="product_dpk_interval_create" class="w-100 p-1 pl-2 dpk-product" form="filter-products">
                          </div>
                      </div>

                      <div class="table-responsive scroll_wrap">
                          <div id="overlay-loader" class="table-overlay-loader" style="position: absolute">
                              <div id="loader"></div>
                          </div>
                          <table class="table position-relative scroll_me">
                              <thead>
                              <tr class="tb-head text-uppercase blue-d-t text-center">
                                  <th colspan="12" scope="col">
                                      <div class="d-flex p-2 radius-top-left border-left border-top border-bottom radius-top-right border-blue border-right text-nowrap dark-link h-60">
                                          <div class="dropdown">
                                              <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  изменить
                                              </button>
                                              <div class="dropdown-menu border-radius border-0 text-lowercase shadow-custom">
                                                  <a href="" class="dropdown-item font-weight-bold drop-menu-actions group-actions-p" data-action="to_avail">в наличии</a>
                                                  <a href="" class="dropdown-item font-weight-bold drop-menu-actions group-actions-p" data-action="to_notavail">не в наличии</a>
                                              </div>

                                              <button class="btn btn-info" id="group-ch-mar-btn">
                                                  выбрать маркетплесы
                                              </button>
                                          </div>
										   {{-- кнопка для поиска дубликатов --}}
                                          @if(Auth::user()->isSuperAdmin())

                                          <div class="moderButton ml-auto d-flex">
                                            <div class="wrap_clons mr-2">
                                                <a href="{{url('/admin/company/'.$company->id.'/del_clons')}}" class="btn btn-info" id="dublicats_btn">Дубликаты</a>
                                              </div>

                                          </div>
                                          @endif

                                      </div>
                                  </th>
                              </tr>
                              </thead>

                              <tbody class="table-bg">
                                  <tr class="font-weight-bold bor-bottom">
                                      <td scope="col" class="align-middle">
                                          <div class="d-block text-center text-uppercase text-nowrap">
                                              <div class="wrapper-checkbox">
                                                  <input type="checkbox" class="css-checkbox" id="click-all-products">
                                                  <label for="click-all-products" class="css-label radGroup1"></label>
                                              </div>
                                          </div>
                                      </td>
                                      <td scope="col" class="align-middle">
                                          <div class="d-block text-center text-uppercase text-nowrap">
                                              ID
                                          </div>
                                      </td>

                                      <td scope="col" class="align-middle">
                                          <div class="d-block text-center text-uppercase text-nowrap">
                                              фото
                                          </div>
                                      </td>

                                      <td scope="col" class="align-middle">
                                          <div class="d-block text-center text-uppercase text-nowrap">
                                              наименование
                                          </div>
                                      </td>

                                      <td scope="col" class="align-middle">
                                          <div class="d-block text-center text-uppercase text-nowrap">
                                              ссылки
                                          </div>
                                      </td>

                                      <td scope="col" class="align-middle">
                                          <div class="d-block text-center text-uppercase text-nowrap">
                                              категория
                                          </div>
                                      </td>

                                      <td scope="col" class="align-middle">
                                          <div class="d-block text-center text-uppercase text-nowrap">
                                              цена
                                          </div>
                                      </td>

                                      <td scope="col" class="align-middle">
                                          <div class="d-block text-center text-uppercase text-nowrap">
                                              комиссия
                                          </div>
                                      </td>

                                      <td scope="col" class="align-middle">
                                          <div class="d-block text-center text-uppercase text-nowrap">
                                              наличие
                                          </div>
                                      </td>

                                      <td scope="col" class="align-middle">
                                          <div class="d-block text-center text-uppercase text-nowrap">
                                              статус
                                          </div>
                                      </td>
                                      <td scope="col" class="align-middle">
                                          <div class="d-block text-center text-uppercase text-nowrap">
                                              маркеты
                                          </div>
                                      </td>
                                      <td scope="col" class="align-middle">
                                          <div class="d-block text-center text-uppercase text-nowrap">
                                              изменен
                                          </div>
                                      </td>
                                      <td scope="col" class="align-middle">
                                          <div class="d-block text-center text-uppercase text-nowrap">
                                              кол-во заказов
                                          </div>
                                      </td>
                                  </tr>
                              </tbody>
                              <form class="form-change-status-avail" action="{{ asset('admin/product/group/actions') }}" method="POST" id="group-product-actions">
                                  {{ csrf_field() }}
                              </form>
                              <tbody class="table-bg" id="products-place">
                                @include('admin.company.layouts.showCompany.products')
                              </tbody>
                            </table>
                    </div>
                  </div>
                  @if(Auth::user()->isAdmin())
                  <div class="tab-pane fade" id="pills-orders" role="tabpanel" aria-labelledby="pills-contact-tab">
                      <div class="row">
                          <div class="col-12">
                              <h5>Выберите фильтры:</h5>
                          </div>
                      </div>

                      <div class="row">
                          <form action="{{ asset('admin/company/'.$company->id.'/filter/orders') }}" id="filter-orders"></form>
                          <div class="col-12 col-md-4">
                              <input type="number" name="order_id_equally" step="1" min="0" class="w-100 p-1 mb-1 noscroll quantity action-filter-company" placeholder="Номер заказа" form="filter-orders">
                          </div>

                          <div class="col-12 col-md-4">
                              <input type="text" name="order_dpk_interval_create" class="w-100 p-1 mb-1 dpk-order" placeholder="Выберите даты" form="filter-orders">
                          </div>

                          <div class="col-12 col-md-4">
                              <input type="text" name="name_like_percent" class="w-100 p-1 mb-1 action-filter-company" placeholder="Наименование товара" form="filter-orders">
                          </div>

                          <div class="col-12 col-md-4">
                              <input type="number" name="total_sum_equally" step="any" min="0" class="w-100 p-1 mb-1 noscroll quantity action-filter-company" placeholder="Сумма" form="filter-orders">
                          </div>

                          <div class="col-12 col-md-4">
                              <input type="text" name="customer_name_like_percent"  class="w-100 p-1 mb-1 action-filter-company" placeholder="ФИО заказчика" form="filter-orders">
                          </div>

                          <div class="col-12 col-md-4">
                              <input type="text" name="customer_email_like_percent" class="w-100 p-1 mb-1 action-filter-company" placeholder="Почта заказчика" form="filter-orders">
                          </div>

                          <div class="col-12 col-md-4">
                              <input type="text" name="customer_phone_like_percent" class="w-100 p-1 mb-1 action-filter-company" placeholder="Телефон заказчика" form="filter-orders">
                          </div>

                          <div class="col-12 col-md-4">
                              <select name="marketplace_id_equally" class="filter-select2 mb-1 action-filter-company" form="filter-orders">
                                  <option value="all">Все маркетплейсы</option>
                                  @foreach($marketplaces as $marketplace)
                                  <option value="{{ $marketplace->id }}">{{ $marketplace->name }}</option>
                                  @endforeach
                              </select>
                          </div>

                          <div class="col-12 col-md-4">
                              <select name="status_equally" class="filter-select2 mb-1 action-filter-company" form="filter-orders">
                                  <option value="all">Все статусы</option>
                                  <option value="0">Новый</option>
                                  <option value="4">Проверен</option>
                                  <option value="3">Отправлен</option>
                                  <option value="1">Выполнен</option>
                                  <option value="2">Отменен</option>
                              </select>
                          </div>

                      </div>

                      <div class="table-responsive scroll_wrap">
                          <div id="overlay-loader" class="table-overlay-loader" style="position: absolute">
                              <div id="loader"></div>
                          </div>
                          <table class="table position-relative">
                              <thead>
                                  <tr class="tb-head text-uppercase blue-d-t text-center">
                                      <th scope="col" class="h-60">
                                          <div class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link">
                                              <div class="d-flex align-items-center">
                                                  <span class="" style="">№ заказа/дата</span>
                                              </div>
                                          </div>
                                      </th>
                                      <th scope="col" class="h-60">
                                          <div class="d-block p-3 h-100 border-top border-bottom border-blue">
                                              #маркет
                                          </div>
                                      </th>
                                      <th scope="col" class="h-60">
                                          <div class="d-block p-3 h-100 border-top border-bottom border-blue">
                                              название
                                          </div>
                                      </th>
                                      <th scope="col" class="h-60">
                                          <div class="d-block p-3 h-100 border-top border-bottom border-blue">
                                              маркетплейс
                                          </div>
                                      </th>
                                      <th scope="col" class="h-60">
                                          <div class="d-block h-100 p-3 border-top border-bottom border-blue">
                                              сумма
                                          </div>
                                      </th>
                                      <th scope="col" class="h-60">
                                          <div class="d-block h-100 p-3 border-top border-bottom border-blue">
                                              клиент
                                          </div>
                                      </th>
                                      <th scope="col" class="h-60">
                                          <div class="d-block h-100 p-3 border-top border-bottom border-blue radius-top-right border-right">
                                              статус
                                          </div>
                                      </th>
                                  </tr>
                              </thead>

                              <tbody id="orders-place" class="table-bg">
                                @include('admin.company.layouts.showCompany.orders')
                              </tbody>
                          </table>
                      </div>
                  </div>
                    @endif
              </div>

            </div>
          </div>

          @include('admin.company.layouts.showCompany.layouts.adminChengeOrderStatusModal')
          @include('admin.company.layouts.showCompany.layouts.adminChengeMarketModal')
    </div>
  </div>
  <script>
      (function($, undefined){
          $(function(){

              $('body').on('click', '.pagination li a', function (e) {
                  e.preventDefault();
                  var inProgress = false;
                  var url = $(this).attr('href');
                  var type = $(this).parents('.pagination-block').data('type');

                  if(!inProgress){
                      $.ajax({
                          async: true,
                          method: 'get',
                          url: url,
                          beforeSend: function() {
                              inProgress = true;
                              $('#overlay-loader').show();
                          },
                          success: function(data){
                              if(type == 'products') {
                                  $('#products-place').html(data);
                              }else if(type == 'orders') {
                                  $('#orders-place').html(data);
                              }

                              var offset = $('#tabs-block').offset();
                              $("html, body").animate({scrollTop: (offset.top-100) }, 500, 'swing');
                              $('#overlay-loader').hide();
                          },
                          error: function(data){
                              $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                              $('#overlay-loader').hide();
                          }
                      });
                  }
              });

              $('.action-filter-company').on('keyup change', function (e) {
                  e.preventDefault();
                  var keyCode = e.keyCode || e.which;

                  if (keyCode === 13) {
                      return false;
                  }

                  var formId = $(this).attr("form");
                  var form = $('#'+formId);
                  var url = form.attr('action');

                  if(e.type = 'keyup'){
                      delay(function(){
                          filtersCompanyShow(formId, form, url);
                      }, 1000 );
                  }else{
                      filtersCompanyShow(formId, form, url);
                  }
              });

              var delay = (function(){
                  var timer = 0;
                  return function(callback, ms){
                      clearTimeout (timer);
                      timer = setTimeout(callback, ms);
                  };
              })();


              $(document).ready(function(){
                  $('.filter-select2').select2({
                      placeholder: 'Данные не найдены',
                  });
              });

              var datapickerTransactions = $('.dpk-transactions').datepicker({
                  range: true,
                  toggleSelected: false,
                  multipleDatesSeparator:' - ',
                  dateFormat: 'dd.mm.yyyy',
                  multipleDates: true,
                  onSelect: function(formattedDate, date, inst){
                      if($('.dpk-transactions').val().length > 11){
                          datapickerTransactions.blur();

                          var formId = $('#filter-transactions').attr("id");
                          var form = $('#'+formId);
                          var url = form.attr('action');

                          filtersCompanyShow(formId, form, url);
                      }
                  }
              });

              var datapickerProduct = $('.dpk-product').datepicker({
                  range: true,
                  toggleSelected: false,
                  multipleDatesSeparator:' - ',
                  dateFormat: 'dd.mm.yyyy',
                  multipleDates: true,
                  onSelect: function(formattedDate, date, inst){
                      if($('.dpk-product').val().length > 11){
                          datapickerProduct.blur();

                          var formId = $('#filter-products').attr("id");
                          var form = $('#'+formId);
                          var url = form.attr('action');

                          filtersCompanyShow(formId, form, url);
                      }
                  }
              });

              var datapickerOrder = $('.dpk-order').datepicker({
                  range: true,
                  toggleSelected: false,
                  multipleDatesSeparator:' - ',
                  dateFormat: 'dd.mm.yyyy',
                  multipleDates: true,
                  onSelect: function(formattedDate, date, inst){
                      if($('.dpk-order').val().length > 11){
                          datapickerOrder.blur();

                          var formId = $('#filter-orders').attr("id");
                          var form = $('#'+formId);
                          var url = form.attr('action');

                          filtersCompanyShow(formId, form, url);
                      }
                  }
              });


              function filtersCompanyShow(formId, form, url) {

                  var inProgress = false;

                  if(!inProgress){
                      $.ajax({
                          async: true,
                          method: 'get',
                          url: url,
                          data: form.serialize(),
                          beforeSend: function() {
                              inProgress = true;
                              $('.table-overlay-loader').show()
                          },
                          success: function(data){
                              if(formId == 'filter-transactions'){
                                  $('#transactions-place').html(data);
                              }else if(formId == 'filter-products'){
                                  $('#products-place').html(data);
                              }else if(formId == 'filter-orders'){
                                  $('#orders-place').html(data);
                              }

                              $('.table-overlay-loader').hide()
                          },
                          error: function(data){
                              $('.table-overlay-loader').hide()
                              $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                          }
                      });
                  }
              };

              document.addEventListener("mousewheel", function(event){
                  if(document.activeElement.type === "number" &&
                      document.activeElement.classList.contains("noscroll"))
                  {
                      document.activeElement.blur();
                  }
              });



              // $('body').on('click', '.c-ord-s-admin-btn', function (e) {
              //     e.preventDefault();
              //     var typeSubmit = $(this).data('type');
              //     var inProgress = false;
              //     var url = '';
              //      // console.log(typeSubmit);
              //     if(!inProgress){
              //         if(typeSubmit == 'link'){
              //             url = $(this).attr('href');
              //             $.ajax({
              //                 async: true,
              //                 method: 'get',
              //                 url: url,
              //                 beforeSend: function() {
              //                     inProgress = true;
              //                     $('.table-overlay-loader').show()
              //                 },
              //                 success: function(data){
              //                     var data = JSON.parse(data);
              //                     chengeStatusOrderAdmin(data);
              //                     $('.table-overlay-loader').hide()
              //                 },
              //                 error: function(data){
              //                     $('.table-overlay-loader').hide()
              //                     $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
              //                 }
              //             });
              //         }else if(typeSubmit == 'form'){
              //             var form = $(this).parent('form');
              //             url = form.attr('action');
              //
              //             $.ajax({
              //                 async: true,
              //                 method: 'post',
              //                 url: url,
              //                 data: form.serialize(),
              //                 beforeSend: function() {
              //                     inProgress = true;
              //                     $('.table-overlay-loader').show()
              //                 },
              //                 success: function(data){
              //                     var data = JSON.parse(data);
              //                     chengeStatusOrderAdmin(data);
              //                     $('.table-overlay-loader').hide()
              //                 },
              //                 error: function(data){
              //                     $('.table-overlay-loader').hide()
              //                     $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
              //                 }
              //             });
              //         }
              //     }
              // });
              //
              // function chengeStatusOrderAdmin(data) {
              //     if(data.status == 'success'){
              //         $('.status-button-'+data.orderId).html(data.render);
              //         if(data.action == 'confirm'){
              //             $.toaster({ message : "Заказ №"+data.orderId+" подвержден!", title : 'Ok!', priority : 'info', settings : {'timeout' : 3000} });
              //         }else if(data.action == 'shipped-modal'){
              //             $('.admin-status-c-body').html(data.modalBody);
              //             $('#shipped-modal-title').html(data.modalTitle);
              //             $('#shipped-modal').modal({backdrop: 'static'});
              //             $.toaster({ message : "Укажите ТТН Новой Почты!", title : 'Info!', priority : 'info', settings : {'timeout' : 3000} });
              //         }else if(data.action == 'shipped-without-ttn'){
              //             $.toaster({ message : "Заказ №"+data.orderId+" отправлен!", title : 'Ok!', priority : 'info', settings : {'timeout' : 3000} });
              //         }else if(data.action == 'shipped'){
              //             $.toaster({ message : "Заказ №"+data.orderId+" отправлен!", title : 'Ok!', priority : 'info', settings : {'timeout' : 3000} });
              //             $('#shipped-modal').modal('hide');
              //         }else if(data.action == 'fulfilled-modal'){
              //             $('.admin-status-c-body').html(data.modalBody);
              //             $('#shipped-modal-title').html(data.modalTitle);
              //             $('#shipped-modal').modal({backdrop: 'static'});
              //         }else if(data.action == 'fulfilled'){
              //             $.toaster({ message : "Заказ №"+data.orderId+" выполнен!", title : 'Ok!', priority : 'info', settings : {'timeout' : 3000} });
              //             $('#shipped-modal').modal('hide');
              //         }else if(data.action == 'canceled-modal'){
              //             $('.admin-status-c-body').html(data.modalBody);
              //             $('#shipped-modal-title').html(data.modalTitle);
              //             $('#shipped-modal').modal({backdrop: 'static'});
              //         }else if(data.action == 'canceled'){
              //             $.toaster({ message : "Заказ №"+data.orderId+" отменен!", title : 'Ok!', priority : 'info', settings : {'timeout' : 3000} });
              //             $('#shipped-modal').modal('hide');
              //         }else{
              //             $.toaster({ message : "test", title : 'Ok!', priority : 'info', settings : {'timeout' : 3000} });
              //         }
              //
              //     }else if(data.status == 'error'){
              //         $.toaster({ message : "Не допустимое действие!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
              //     }
              // }

              // изменение статуса наличия товара


              // Групповое изменение товара амином
              $('#click-all-products').on('click', function (e) {
                  if($(this).prop("checked")){
                      $('.form-check-input[form = group-product-actions]').each(function(indx, element){
                          if(!$(element).prop("checked")){
                              $(element).click();
                          }
                      });
                  }else{
                      $('.form-check-input[form = group-product-actions]').each(function(indx, element){
                          if($(element).prop("checked")){
                              $(element).click();
                          }
                      });
                  }
              });

              function ajax(options, callback) {

                  $.ajax(options).done(function (data) {
                      callback(data);
                  }).fail(function () {
                      $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                  });

              }

              $('body').on('click', '.change-avail-btn', function (e) {
                  let f = $(this).closest('form');
                  let u = f.attr('action');
                  let m = f.attr('method');
                  ajax(options = {url: u, type: m, data: f.serialize()}, (data) => {
                      var data = JSON.parse(data);
                      if(data.action == 'to_avail'){
                          $.toaster({ message : "Товар: "+data.pName+" переведен в статус \"В наличии\"", title : '', priority : 'info', settings : {'timeout' : 3000} });
                      }else if(data.action == 'to_noavail'){
                          $.toaster({ message : "Товар: "+data.pName+" переведен в статус \"Не в наличии\"", title : '', priority : 'info', settings : {'timeout' : 3000} });
                      }
                  });
              });

              $('.group-actions-p').on('click', function (e) {
                  e.preventDefault();
                  let a = $(this).data('action');
                  let f = $('#group-product-actions');
                  let u = f.attr('action');
                  let m = f.attr('method');
                  $('.table-overlay-loader').show();


                  ajax(options = {url: u, type: m, data: f.serialize()+'&g_action='+a}, (data) => {
                      var data = JSON.parse(data);

                      if(data.action == 'to_avail'){
                          if(data.status == 'fail'){
                              $.toaster({ message : data.msg, title : '', priority : 'danger', settings : {'timeout' : 3000} });
                          }else{
                              $.each(data.pIds, function (i, value) {
                                  $('#prop-p-checkbox-'+value).prop({"checked":true});
                              });
                              $.toaster({ message : "Группа товаров переведена в статус \"В наличии\"", title : '', priority : 'info', settings : {'timeout' : 3000} });
                          }
                      }else if(data.action == 'to_noavail'){
                          if(data.status == 'fail'){
                              $.toaster({ message : data.msg, title : '', priority : 'danger', settings : {'timeout' : 3000} });
                          }else{
                              $.each(data.pIds, function (i, value) {
                                  $('#prop-p-checkbox-'+value).prop({"checked":false});
                              });
                              $.toaster({ message : "Группа товаров переведена в статус \"Не в наличии\"", title : '', priority : 'info', settings : {'timeout' : 3000} });
                          }
                      }else if(data.action == 'chmarket'){
                          if(data.status == 'success'){

                              $.each(data.pIds, function (i, value) {
                                    if(data.markets.rozetka){
                                        $('.badge-r-'+value).show();
                                    }else{
                                        $('.badge-r-'+value).hide();
                                    }
                                    if(data.markets.prom){
                                        $('.badge-p-'+value).show();
                                    }else{
                                        $('.badge-p-'+value).hide();
                                    }
                                    if(data.markets.zakupka){
                                        $('.badge-z-'+value).show();
                                    }else{
                                        $('.badge-z-'+value).hide();
                                    }
                                  });
                              $.toaster({ message : "Группа товаров успешно сменила маркетплейсы!", title : '', priority : 'info', settings : {'timeout' : 3000} });
                          }else if(data.status == 'fail'){
                              $.toaster({ message : data.msg, title : '', priority : 'danger', settings : {'timeout' : 3000} });
                          }
                          $('#change-market-modal').modal('hide');
                      }

                      $('.table-overlay-loader').hide();
                  });

              });

              $('#group-ch-mar-btn').on('click', function (e) {
                  $('#change-market-modal').modal({
                      backdrop: 'static',
                      keyboard: false
                  });
              });

              //изменение статуса заказа 04.03.2019
              $('#orders-place').on('click', '.change-o-status', function (e) {
                  e.preventDefault();

                  let action = $(this).data('action');
                  let orderId = $(this).data('order');
                  let url = $(this).data('url');
                  let token = $('[name=csrf-token]').attr('content');
                  let data = {
                      _token: token,
                      action: action
                  };
                  let params = $.param( data );

                  $('#overlay-loader').show();
                  ajax(options = {url:url, type: 'POST', data: params}, (data) => {
                      data = JSON.parse(data);
                      if(data.status == 'success'){
                          if(data.action == 'modal'){
                              $.toaster({ message : data.msg, title : '', priority : 'success', settings : {'timeout' : 6000} });
                              $('#change-status-order-modal-title').text(data.title);
                              $('#change-status-order-modal-body').html(data.render);
                              $('#change-status-order-modal').modal({
                                  backdrop: 'static',
                                  keyboard: false
                              });
                          }
                      }else if(data.status == 'error'){
                          $.toaster({ message : data.msg, title : '', priority : 'danger', settings : {'timeout' : 6000} });
                      }
                      $('#overlay-loader').hide();
                  });
              });

              $('.modal-body').on('click', '.submit-c-status-form', function (e) {
                  e.preventDefault();
                  let f = $(this).closest('form');
                  let i = f.find('input');

                  if(validation(f, i)){
                      changeOrderStatusTrait(f);
                  }else{

                  }
              });

              function validation(f, i){
                  let flag = true;
                  let textarea = f.find('textarea');
                  i.each(function (i,e) {
                      let t = $(e).attr('type');
                      let v = $(e).val();
                      let id = $(e).attr('id');
                      if(t == 'radio' && id == 'delivery-m-np' && $(e).prop('checked') ){
                          let ttnInput = $('#'+$(e).data('type'));
                          let ttnInputValue = ttnInput.val();
                          ttnInput.removeClass('is-invalid');
                          if(!checkTTN(ttnInputValue)){
                              ttnInput.addClass('is-invalid');
                              $.toaster({ message : 'Не верно указан ТТН Новой Почты!', title : '', priority : 'danger', settings : {'timeout' : 6000} });
                              flag = false;
                          }
                      }else if(t == 'radio' && id == 'delivery-m-up' && $(e).prop('checked')){
                          let codeUpInput = $('#'+$(e).data('type'));
                          let codeUpInputValue = codeUpInput.val();
                          if(codeUpInputValue == ''){
                              codeUpInput.addClass('is-invalid');
                              $.toaster({ message : 'Не указан код посылки УкрПочты!', title : '', priority : 'danger', settings : {'timeout' : 6000} });
                              flag = false;
                          }
                      }
                  });

                  if(textarea.length >=1){
                      textarea.each(function (i,e) {
                          let v = $(e).val();
                          $(e).removeClass('is-invalid');
                          if(v == ''){
                              $(e).addClass('is-invalid');
                              $.toaster({ message : 'Укажите описание отмены заказа!', title : '', priority : 'danger', settings : {'timeout' : 6000} });
                              flag = false;
                          }
                      });
                  }
                  return flag;
              }
              function checkTTN(ttn){
                  let flag1 = ttn.match(/^\d+/);
                  let flag2 = (ttn.length == 27);
                  if(!flag1 || !flag2){
                      return false;
                  }
                  return true;
              }
              function changeOrderStatusTrait(f){
                  let params = f.serialize();
                  let url = f.attr('action');
                  let method = f.attr('method');

                  $('#overlay-loader').show();
                  ajax(options = {url:url, type: method, data: params}, (data) => {
                      data = JSON.parse(data);
                      console.log(data);
                      if(data.status == 'success'){
                          $('#change-status-order-modal').modal('hide');
                          $('.status-button-'+data.orderId).html(data.render);
                          $.toaster({ message : data.msg, title : '', priority : 'success', settings : {'timeout' : 6000} });
                      }else if(data.status == 'error'){
                          $.toaster({ message : data.msg, title : '', priority : 'danger', settings : {'timeout' : 6000} });
                      }
                      $('#overlay-loader').hide();
                  });
              }

              $('.modal-body').on('change', '.del-met-radio', function () {
                  let inputs = $('.del-met-radio');

                  inputs.each(function (i,e) {
                      if($(e).prop('checked')){
                          let value = $(e).val();
                          if(value == 'Новая почта'){
                              $('#num-np-block').show();
                              $('#num-up-block').hide();
                          }else if(value == 'УкрПочта'){
                              $('#num-up-block').show();
                              $('#num-np-block').hide();
                          }else{
                              $('#num-np-block,#num-up-block').hide();
                          }
                      }
                  });
              });

              $('.modal-body').on('focus', '#num-np-block-value', function (e) {
                   $(this).get(0).setSelectionRange(0,0);
              });

              $('body').on('click', '.add-order-status-job', function(e){
				 //-----------------------------------------------
                  let market = $(this).data('idmarket');
                 let url = '';
                  if(market == '1'){
                      url = $(this).data('url2');
                      
                  }else{
                   //--------------------------------------------   
                    url = $(this).data('url');  
                  }
				  
                  if(confirm('Создать задачу для проверки статуса заказа?')){
                      ajax(options = {url:url, type: 'get'}, (data) => {
                          data = JSON.parse(data);
                          if(data.status == 'success'){
                              $.toaster({ message : data.msg, title : '', priority : 'success', settings : {'timeout' : 6000} });
                          }else if(data.status == 'error'){
                              $.toaster({ message : data.msg, title : '', priority : 'danger', settings : {'timeout' : 6000} });
                          }
						   $('#overlay-loader').hide();
                       
                        alert(data);
                        location.reload();
                      });
                  }
              });


			  $('#dublicats_btn').on('click',function(e){
                  $('#overlay-loader').show();
              });


          });
      })(jQuery);
  </script>
@endsection