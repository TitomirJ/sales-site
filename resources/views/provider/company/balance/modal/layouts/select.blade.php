<form id="company-balance-pay-select-sum" action="{{ asset('company/balance/get/liqpay/form') }}" method="POST" >
  {{ csrf_field() }}
  <input type="hidden" name="company_id" value="{{ $user->company->id }}">
  <input type="hidden" name="payeur_name" value="{{ $user->name }}">
  <input type="hidden" name="payeur_surname" value="{{ $user->surname }}">
  <input type="hidden" name="pay_type" value="{{ $type }}">
  <input type="hidden" id="input-key" name="key" value="">
  <div class="input-group">
    <div class="input-group-prepend">
      <label class="input-group-text trans-bg border-0" for="inputGroupSelect01">Сумма:</label>
    </div>
    <select class="custom-select mr-3 border-0" name="tariff" id="inputGroupSelect01">
        @foreach($select as $s)
          <option value="{{ $s->id }}">{{ $s->amount }} грн.     @if($type == 'ab')({{ $s->count_d.' дней абонплаты' }})@endif</option>
        @endforeach
    </select>
  </div>
</form>
