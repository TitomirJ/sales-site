@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/balance/balance.css') }}">
@endsection



@section('content')

    <div class="content-wrapper">
        <div class="container">

          <div class="row mt-5 justify-content-end">
              <div class="d-flex align-items-center instruction">
                  <div class="dark-bg border-radius shadow-custom text-white pl-4 pr-4 pt-1 pb-1 mr-2 f13">
                      инструкция по <a href="{{asset('pdf/6.Balance.pdf')}}" target="_blank">работе с балансом</a>
                  </div>
              </div>
          </div>

          <div class="row mb-5 mt-5">
            <div class="col-12 col-md-6 f18">
              <div>Депозит № {{$company-> id}}  <a href="" class="text-info togle-block-info" data-item="bal" title="Подробнее"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></div>
              <div class="f20 font-weight-bold">{{$company-> name}}</div>
            </div>
            <div class="col-12 col-md-6 f30 d-flex align-items-md-center justify-content-start justify-content-md-end font-weight-bold">
              @if($company -> balance_sum < $company -> balance_limit)
                <span class="text-danger">{{$company -> balance_sum}} грн</span>
              @else
                <span class="text-success">{{$company -> balance_sum}} грн</span>
              @endif
            </div>
          </div>
          <?//условие или баланс равен нулю?>
          @if($company -> balance_sum < 0 || $company -> balance_sum == 0 )
          <div class="row">
            <div class="col-12">
              <div class="alert alert-danger text-right" id="alert-balance" role="alert" style="display:none">
                Средства на балансе закончились! Функционал сайта ограничен. Пополните баланс.
              </div>
            </div>
          </div>
          @elseif($company -> balance_sum < $company -> balance_limit)
          <div class="row">
            <div class="col-12">
              <div class="alert alert-warning text-right" id="alert-balance" role="alert" style="display:none">
                Ув. Клиент, средства на балансе заканчиваются! Пополните баланс.
              </div>
            </div>
          </div>
          @endif

          <div class="row  d-none  block-info-bal">
            <div class="col-12 border-radius bg-white border-grey border shadow-custom p-3 mb-2">
              <div class="w-100 d-flex justify-content-between">
                <h2>Депозит</h2>
              </div>
              <p>
                Депозит - это сумма, с которой взымаеться комиссия за продажу каждого товара с помощью сайта <a href="https://bigsales.pro/">bigsales.pro</a>.
              <br>
                Минимальный остаток на депозите {{ $company->balance_limit }} грн.
              <br>
                В случае, если сумма депозита компании ниже установленного лимита, товары пользователя не будут отображаться на маркетплейсах.
              <br>
                Минимальная сумма пополнения депозита составляет 1000 грн.
              </p>
            </div>
          </div>

          <div class="row">
            <div class="border-radius bg-white w-100 border-grey border p-3 shadow-custom d-flex justify-content-between align-items-md-center flex-column flex-md-row">
                <?
                    $date_now = time();
                    $date_aboniment = strtotime($company->ab_to);
                    $flag = true;
                    $flag_notification = false;
                    if($date_aboniment >= $date_now){
                        $res = $date_aboniment-$date_now;
                        if($res < 86400){
                            $flag_notification = true;
                        }
                    }else{
                        $flag = false;
                    }

                    $return_date = date('Y-m-d', $date_aboniment);
                ?>
              <div>
                <div class="f20 font-weight-bold">Абонплата: <a href="" class="text-info togle-block-info" data-item="ab" title="Подробнее"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></div>
                @if($flag)
                    <div>срок истекает: {{(new Date($return_date))->format('j F Y')}}г.
                    @if($flag_notification)
                        <span  class="text-danger"> Внимание! До блокировки кабинета менее суток!</span>
                    @endif
                    </div>
                @else
                    <div class="text-danger">срок истек: {{(new Date($return_date))->format('j F Y')}}г.</div>
                @endif
              </div>

              <div>
                <button type="button" class="show-pay-form text-uppercase text-white font-weight-bold circle-bg-blue-light border-radius-50 border-0 pt-2 pb-2 pl-3 pr-3" myUrl="{{asset('/balance/get/select/pay')}}">
                  пополнить
                </button>
                @include("provider.company.balance.modal.modal")
                @include("provider.company.balance.modal.modal2")
                @if(isset($result))
                    @include("provider.company.balance.modal.modalSuccess")
                @endif
              </div>

            </div>
          </div>

          <div class="row d-none block-info-ab">
              <div class="col-12 border-radius bg-white border-grey border shadow-custom p-3 mt-2">
                <div class="w-100 d-flex justify-content-between">
                  <h2>Абонплата</h2>
                </div>
                <p>
                  Пользовательский взнос за возможность использования сайта. Стоимость улуги 17 грн/день.
                  Оплата производиться покавартально минимум 1500 грн - 90 дней.
                  В случае завершения срока действия абонлпаты , учетная запись блокируеться, а товары выводятся с маркетплейсов до следуйщего пополнения.
                </p>

                <div>
                  <h2>Тарифы:</h2>
                  <ul>
                    <li>1500грн - 90 дней абонлпаты</li>
                    <li>3000грн - 180 дней абонлпаты</li>
                    <li>6000грн - 365 дней абонлпаты</li>
                  </ul>
                </div>
              </div>
          </div>

          <nav class="mt-2">
            <div class="nav nav-tabs justify-content-between text-uppercase border-bottom-0" id="nav-tab" role="tablist">
              <a class="nav-item nav-link border-0 blue-d-t active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Коммисии</a>
              <a class="nav-item nav-link border-0 blue-d-t" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Истории платежей</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
              <div class="wrapper-table mt-2">
                <div class="header-table bg-white border text-uppercase border-blue d-flex justify-content-between position-relative p-3">
                  <div>Категории</div>
                  <div>Комиссия %</div>
                </div>
                <div class="content-table table-bg-commision pt-3">
                <?
                $check_cat = [];
                ?>
                  @forelse ($products as $p)
                      @if(!in_array($p->subcategory->id, $check_cat))
                          <div class="item-table d-flex justify-content-between bor-bottom p-3">
                            <div class="text-capitalize">{{$p->subcategory->name}}</div>
                            <div>{{$p->subcategory->commission}}%</div>
                          </div>
                      @endif
                    <? array_push($check_cat, $p->subcategory->id); ?>
                  @empty
                  <div class="item-table d-flex justify-content-between bor-bottom p-3">
                    <div class="text-center">Товары отсутствуют</div>
                  </div>
                  @endforelse
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
              <div class="wrapper-table mt-2">
                <div class="header-table bg-white border text-uppercase border-blue d-flex justify-content-between position-relative p-3">
                  <div>дата</div>
                  <div>назначение</div>
                  <div>сумма</div>
                </div>
                <div class="content-table content-table-history table-bg-commision">
                  @forelse($transactions as $t)
                    @if($t->type_transaction == '3')
                    <div class="item-table d-flex justify-content-between balance-border-botttom p-3 green-bg">
                      <div>{{$t->created_at}}</div>
                      <div class="text-capitalize mr-5">Абонплата</div>
                      <div>+{{$t->total_sum}} грн</div>
                    </div>
                    @elseif($t->type_transaction == '0')
                      <div class="item-table d-flex justify-content-between balance-border-botttom p-3 green-bg">
                        <div>{{$t->created_at}}</div>
                        <div class="text-capitalize mr-5 pr-4">Пополнение баланса</div>
                        <div>+{{$t->total_sum}} грн</div>
                      </div>
                    @elseif($t->type_transaction == '1')
                    <div class="item-table d-flex justify-content-between balance-border-botttom p-3 red-bg">
                      <div>{{$t->created_at}}</div>
                      <div class="text-capitalize mr-5 pr-3">Комиссия: заказ № {{$t->order_id}}</div>
                      <div>{{'- '.$t->total_sum}} грн</div>
                    </div>
                    @elseif($t->type_transaction == '5')
                      <div class="item-table d-flex justify-content-between balance-border-botttom p-3 red-bg">
                        <div>{{$t->created_at}}</div>
                        <div class="text-capitalize mr-5 pr-3">снижение депозита</div>
                        <div>{{'- '.$t->total_sum}} грн</div>
                      </div>
                    @endif
                  @empty
                  @endforelse
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

@endsection



@section('script2')
    <script type="text/javascript" src="{{ asset('js/pages/provider/balance/balance_index.js') }}"></script>
@endsection
