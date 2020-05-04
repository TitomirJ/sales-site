<td scope="col" class="text-center align-middle">
    <div class="wrapper-checkbox">
        <input type="checkbox" name="chart_id[]" value="{{$chart->id}}" id="true-{{$chart->id}}" class="css-checkbox form-check-input" form="group-charts-actions">
        <label for="true-{{$chart->id}}" class="form-check-label css-label"></label>
    </div>
</td>

<td scope="col" class="text-center align-middle">
    @if($chart->read_market == '0')
        <span class="badge badge-pill badge-danger">Не прочитано!</span>
    @else
        <span class="badge badge-pill badge-success">Прочитано!</span>
    @endif
</td>

<td scope="col" class="text-center align-middle">



    @if($type_subpage == 'orders')
        <?
        $orders_ids_array = json_decode($chart->orders_ids);
        $orders_ids_string = implode(", ", $orders_ids_array);
        ?>
        Заказ № {{ $orders_ids_string }}
    @elseif($type_subpage == 'products')
        <a href="{{ asset('company/products/'.$chart->product->id) }}" target="_blank">{{ $chart->subject }}</a>
    @else
        {{ $chart->subject }}
    @endif
</td>
<td scope="col" class="text-center align-middle">
    {{ $chart->user_fio }}
</td>
<td scope="col" class="text-center align-middle">
    {{ $chart->created_at }}
</td>
<td scope="col" class="text-center align-middle">
    <a href="{{ asset('company/messages/'.$chart->id) }}" target="_blank"><i class="fa fa-comments fa-2x text-warning" aria-hidden="true"></i></a>
</td>