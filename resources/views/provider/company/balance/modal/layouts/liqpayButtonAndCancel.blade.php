{!! $formLiqPay !!}
<button type="button" class="text-uppercase shadow-custom text-white font-weight-bold bg-warning border-radius-50 border-0 pt-2 pb-2 pl-3 pr-3" data-url="{{ asset('company/balance/cancel/liqpay') }}" data-param="{{ Auth::user()->company->id }}" id="cansel-liqpay-button">
    отмена
</button>