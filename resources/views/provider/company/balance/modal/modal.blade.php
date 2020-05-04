<!-- Modal -->
<div class="modal fade" id="company-pay-modal" tabindex="-1" role="dialog" aria-labelledby="company-pay-modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content trans-bg border-0">
      <div class="modal-header align-items-center flex-column border-bottom-0 border-radius bg-white p-0 overflow-hidden shadow-custom">
        <h5 class="modal-title bg-grey-dark-modal w-100 text-center text-white p-2" >Выберите, что пополнить</h5>
        <div class="c-point w-100 text-center p-1 border-bottom select-pay-method-com" id="subscription" data-type="ab" data-url="{{ asset('/company/balance/get/select/pay') }}">Абонплата</div>
        <div class="c-point w-100 text-center p-1 select-pay-method-com" id="deposit" data-type="bal" data-url="{{ asset('/company/balance/get/select/pay') }}">Депозит</div>
      </div>

      <div class="modal-body border-radius bg-white p-0 pl-2 pr-2 mt-3 shadow-custom" id="com-bal-pay-sel">


      </div>
      <div class="modal-footer justify-content-center border-top-0">
        <button type="button" id="com-bal-but-next" class="text-uppercase shadow-custom text-white font-weight-bold circle-bg-blue-light border-radius-50 border-0 pt-2 pb-2 pl-3 pr-3" >
          далее
        </button>

      </div>
    </div>
  </div>
</div>
