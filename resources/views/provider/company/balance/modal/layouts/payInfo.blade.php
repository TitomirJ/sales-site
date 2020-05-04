Платильщик: {{$user->company->name}}<br>
Через кого: {{ $data['payeur_name'].' '.$data['payeur_surname'] }} <br>
Тип платежа:
@if($data['pay_type'] == 'ab')
    Абонплата
@elseif($data['pay_type'] == 'bal')
    Депозит
@endif <br>
Сумма: <span class="text-success">{{ $price }} грн</span><br>
Комиссия банка: <?echo "2.75%";?><br>
Дата создания: {{(new Date($time))->format('j F Y (H:i:s)')}} <br>