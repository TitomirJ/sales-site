@if($type_modal == 'LiqPay_form')
    <h4 class="w-100 text-center text-info">Данные платежа</h4>
    <p>Имя плательщика: {{ $bm_transaction->name }}</p>
    <p>Фамилия плательщика: {{ $bm_transaction->surname }}</p>
    <p>Почта плательщика: {{ $bm_transaction->email }}</p>
    <p>Телефон плательщика: {{ $bm_transaction->phone }}</p>
    <p>Валюта: {{ $bm_transaction->currency->code }} ({{ $bm_transaction->currency->name }})</p>
    <p>Сумма: {{ $bm_transaction->amount }}</p>
    <p>Комиссия банка: <?echo ($bm_transaction->amount*0.03);?> </p>
    <p>Дата создания: {{(new Date($bm_transaction->created_at))->format('j F Y (H:i:s)')}}</p>
    <p>Назначение платежа: {{ $bm_transaction->description }}</p>


    {!! $liq_pay_bytton !!}
@endif