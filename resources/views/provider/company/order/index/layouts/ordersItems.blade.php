@forelse($orders as $order)
    <tr class="c-pointer text-center bor-bottom order-item-{{$order->id}}">

        <td class="font-weight-bold"  data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
            <button class="btn btn-link" type="button" >
                {{$order->id}}
            </button><br>
            <div class="f13">
                {{(new Date($order->created_at))->format('j F Y (H:i:s)')}}
            </div>
        </td>

        <td class="font-weight-bold">
            {{$order->product->code}}
        </td>

        <?
        $g = json_decode($order->product->gallery);
        ?>

        <td  data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
            <div class="d-flex align-items-center justify-content-center text-left">
                <img src="{{$g[0]->public_path}}" alt="{{$order->name}}" width="80">
                <div class="pl-2 font-weight-bold">
                    {{$order->product->name}}
                </div>
            </div>
        </td>

        <td  data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
            <div class="d-flex align-items-center justify-content-center h-100">
                <img src="{{asset($order->marketplace->image_path)}}" alt="{{$order->marketplace->name}}" width="100">
            </div>
        </td>

        <td class="font-weight-bold"  data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
            {{$order->total_sum}} грн.<br>
            {{$order->quantity}} шт.
        </td>

        <td class="font-weight-bold"  data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
            {{$order->product->subcategory->commission}} %<br>
            {{$order->commission_sum}} грн.
        </td>

        @if($company->block_new == '1' || $company->block_bal == '1')
            @if($company->block_new == 1)

                <td class="font-weight-bold"  data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
                    Вы находитесь в тестовом периоде<br>
                    Информация недосутпна
                </td>
                <td class="status-button-{{$order->id}} font-weight-bold" data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
                    Вы находитесь в тестовом периоде<br>
                    Информация недосутпна
                </td>

            @elseif($company->block_bal == 1)

                <td class="font-weight-bold" data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
                    Ваш баланс ниже лимита<br>
                    Информация недосутпна
                </td>
                <td class="status-button-{{$order->id}} font-weight-bold" data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
                    Ваш баланс ниже лимита<br>
                    Информация недосутпна
                </td>

            @elseif($company->block_new == 1 && $company->block_bal == 1)

                <td class="font-weight-bold" data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
                    Вы находитесь в тестовом периоде<br>
                    Ваш баланс ниже лимита<br>
                    Информация недосутпна
                </td>
                <td class="status-button-{{$order->id}} font-weight-bold" data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
                    Вы находитесь в тестовом периоде<br>
                    Ваш баланс ниже лимита<br>
                    Информация недосутпна
                </td>
            @endif
        @else
            <td class="font-weight-bold" data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
                {{$order->customer_name}}<br>
                {{$order->customer_phone}}<br>
                {{$order->customer_email}}<br>
                {{$order->customer_adress}}
            </td>
            <td class="status-button-{{$order->id}}">
                @include('provider.company.order.index.layouts.dropdownStatusButton')
            </td>
        @endif

    </tr>

    <tr class="order-item-{{$order->id}}">
        <td colspan="8" class="p-0">
            <div id="collapse{{$order->id}}" class="collapse" aria-labelledby="heading{{$order->id}}" data-parent="#accordionExample">
                <div class="card-body">
                    @include('provider.company.order.index.layouts.cartOrderBoby')
                </div>
            </div>
        </td>
    </tr>

@empty
    <tr class="bor-bottom">
        <td colspan="8" class="text-center">
            <div class="d-flex align-items-center justify-content-center">
                <div class="mr-4">
                    Нет заказов
                </div>

                <i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i>
            </div>
        </td>
    </tr>
@endforelse

<tr>
    <td colspan="8" class="p-0 orders-page-pagination-block">
        {{$orders->links()}}
    </td>
</tr>
<script>
    var pageOrder = <?echo $orders->currentPage(); ?>;
</script>
