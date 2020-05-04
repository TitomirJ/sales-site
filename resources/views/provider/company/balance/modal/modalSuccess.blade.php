<!-- Modal -->
<div class="modal fade" id="company-liqpay-modal-success" tabindex="-1" role="dialog" aria-labelledby="company-liqpay-modal-success-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content trans-bg border-0">

      <div class="modal-header align-items-center flex-column border-bottom-0 border-radius p-0 overflow-hidden shadow-custom">
        @if($result->status == 'sandbox' || $result->status == 'success')
          <h5 class="modal-title bg-grey-dark-modal w-100 text-center text-white p-2" id="company-liqpay-modal-success-title">Платеж проведен успешно!</h5>
        @elseif($result->status == 'failure')
          <h5 class="modal-title bg-warning w-100 text-center text-white p-2" id="company-liqpay-modal-success-title">Внимание</h5>
        @elseif($result->status == 'error')
          <h5 class="modal-title bg-danger w-100 text-center text-white p-2" id="company-liqpay-modal-success-title">Ошибка!</h5>
        @endif
      </div>

      <div class="modal-body border-radius shadow-custom bg-white p-3 mt-3">
        @if($result->status == 'sandbox' || $result->status == 'success')
          <div class="row">
            <div class="col-12 text-center">Информация о платеже:</div>
          </div>
          <div class="row">
            <div class="col-5 offset-1">
              Дата оплаты:
            </div>
            <div class="col-5">
              {{ date('d-m-Y H:i:s', ($result->create_date/1000)) }}
            </div>
          </div>
          @if(isset($result->sender_first_name) && isset($result->sender_last_name))
                  <div class="row">
                      <div class="col-5 offset-1">
                          Плательщик:
                      </div>
                      <div class="col-5">
                          {{ $result->sender_first_name }}&nbsp;&nbsp;{{ $result->sender_last_name }}
                      </div>
                  </div>
          @elseif(isset($result->sender_first_name) && !isset($result->sender_last_name))
                  <div class="row">
                      <div class="col-5 offset-1">
                          Плательщик:
                      </div>
                      <div class="col-5">
                          {{ $result->sender_first_name }}&nbsp;&nbsp;
                      </div>
                  </div>
          @elseif(!isset($result->sender_first_name) && isset($result->sender_last_name))
                  <div class="row">
                      <div class="col-5 offset-1">
                          Плательщик:
                      </div>
                      <div class="col-5">
                          &nbsp;&nbsp;{{ $result->sender_last_name }}
                      </div>
                  </div>
          @else

          @endif
          <div class="row">
            <div class="col-5 offset-1">
              Способ оплаты:
            </div>
            <div class="col-5">
              @if($result->paytype == 'privat24')
                Приват 24
              @elseif($result->paytype == 'card')
                Карта
              @elseif($result->paytype == 'liqpay')
                LiqPay
              @elseif($result->paytype == 'masterpass')
                MasterPass
              @else
                {{ $result->paytype }}
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-5 offset-1">
              Валюта:
            </div>
            <div class="col-5">
              {{ $result->currency }}
            </div>
          </div>
          <div class="row">
            <div class="col-5 offset-1">
              Сумма:
            </div>
            <div class="col-5">
              {{ $result->amount }}&nbsp;грн.
            </div>
          </div>
          <div class="row">
            <div class="col-5 offset-1">
              Комиссия банка:
            </div>
            <div class="col-5">
              {{ $result->sender_commission }}&nbsp;грн.
            </div>
          </div>
          <div class="row">
            <div class="col-5 offset-1">
              Номер заказа:
            </div>
            <div class="col-5">
              {{ $result->order_id }}
            </div>
          </div>
          <div class="row">
            <div class="col-5 offset-1">
              Номер транзакции:
            </div>
            <div class="col-5">
              {{ $result->transaction_id }}
            </div>
          </div>
          <div class="row">
            <div class="col-5 offset-1">
              Назначение платежа:
            </div>
            <div class="col-5">
              {{ $result->description }}
            </div>
          </div>

        @elseif($result->status == 'failure')
          <h5 class="w-100 text-danger text-center">Платеж не прошел
            (
            @if($result->err_code == 'cancel')
              отменено пользователем
            @else
              {{ $result->err_description }}
            @endif
        )
          </h5>
          <div class="row">
            <div class="col-12 text-center">Информация о платеже:</div>
          </div>
          <div class="row">
            <div class="col-5 offset-1">
              Дата оплаты:
            </div>
            <div class="col-5">
              {{ date('d-m-Y H:i:s', ($result->create_date/1000)) }}
            </div>
          </div>
              @if(isset($result->sender_first_name) && isset($result->sender_last_name))
                  <div class="row">
                      <div class="col-5 offset-1">
                          Плательщик:
                      </div>
                      <div class="col-5">
                          {{ $result->sender_first_name }}&nbsp;&nbsp;{{ $result->sender_last_name }}
                      </div>
                  </div>
              @elseif(isset($result->sender_first_name) && !isset($result->sender_last_name))
                  <div class="row">
                      <div class="col-5 offset-1">
                          Плательщик:
                      </div>
                      <div class="col-5">
                          {{ $result->sender_first_name }}&nbsp;&nbsp;
                      </div>
                  </div>
              @elseif(!isset($result->sender_first_name) && isset($result->sender_last_name))
                  <div class="row">
                      <div class="col-5 offset-1">
                          Плательщик:
                      </div>
                      <div class="col-5">
                          &nbsp;&nbsp;{{ $result->sender_last_name }}
                      </div>
                  </div>
              @else

              @endif
          <div class="row">
            <div class="col-5 offset-1">
              Валюта:
            </div>
            <div class="col-5">
              {{ $result->currency }}
            </div>
          </div>
          <div class="row">
            <div class="col-5 offset-1">
              Сумма:
            </div>
            <div class="col-5">
              {{ $result->amount }}&nbsp;грн.
            </div>
          </div>
          <div class="row">
            <div class="col-5 offset-1">
              Номер заказа:
            </div>
            <div class="col-5">
              {{ $result->order_id }}
            </div>
          </div>
          <div class="row">
            <div class="col-5 offset-1">
              Назначение платежа:
            </div>
            <div class="col-5">
              {{ $result->description }}
            </div>
          </div>
        @elseif($result->status == 'error')
          <h5 class="w-100 text-danger text-center">Платеж не прошел из-за технической ошибки</h5>
          <div class="row">
            <div class="col-12 text-center">Описание ошибки:</div>
          </div>
          <div class="row">
            <div class="col-4 offset-1">
              Код ошибки:
            </div>
            <div class="col-6">
              {{ $result->err_code }}
            </div>
          </div>
          <div class="row">
            <div class="col-4 offset-1">
              Описание ошибки:
            </div>
            <div class="col-6">
              {{ $result->err_description }}
            </div>
          </div>
        @endif
      </div>
      <div class="modal-footer justify-content-center border-top-0">
        <button type="button" class="text-uppercase shadow-custom text-white font-weight-bold circle-bg-blue-light border-radius-50 border-0 pt-2 pb-2 pl-3 pr-3"  data-dismiss="modal" >
          закрыть
        </button>
      </div>

    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        $('#company-liqpay-modal-success').modal({
            keyboard: false,
            backdrop: 'static'
        });
    });
</script>
