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
        <td  data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
            <div class="d-flex align-items-center justify-content-center text-center">
                @if($order->marketplace_id == '1')
                    {{ $order->	order_market_id }}
                @elseif($order->marketplace_id == '2')
                    {{ $order->market_id }}
                @else
                    Нет данных!
                @endif
            </div>
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

        <td>
            <div class="d-flex align-items-center justify-content-center h-100">
                @if($order->marketplace->id == '1')
                   <a style="cursor: pointer;" class="add-order-status-job" data-url="{{ asset('admin/order/'.$order->id.'/create/job/')}}" data-url2 ="{{asset('admin/order/'.$order->id.'/create/job/'.($order->marketplace_id == '1' ? $order->order_market_id :'')) }}" data-idmarket={{$order->marketplace_id}}>
                        <img src="{{asset($order->marketplace->image_path)}}" alt="{{$order->marketplace->name}}" width="100">
                    </a>
                @else
                    <img src="{{asset($order->marketplace->image_path)}}" alt="{{$order->marketplace->name}}" width="100">
                @endif
            </div>
        </td>

        <td class="font-weight-bold"  data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
            {{$order->total_sum}} грн.<br>
            {{$order->quantity}} шт.
        </td>


            <td class="font-weight-bold" data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
                {{$order->customer_name}}<br>
                {{$order->customer_phone}}<br>
                {{$order->customer_email}}<br>
                {{$order->customer_adress}}
            </td>

            <td class="status-button-{{$order->id}}">

                @include('admin.company.layouts.showCompany.dropdownStatusBtn')

            </td>

    </tr>

    <tr class="order-item-{{$order->id}}">
        <td colspan="7" class="p-0">
            <div id="collapse{{$order->id}}" class="collapse" aria-labelledby="heading{{$order->id}}" data-parent="#accordionExample">
                <div class="card-body">
                    @include('admin.company.layouts.showCompany.cardBodyOrder')
                </div>
            </div>
        </td>
    </tr>

@empty
    <tr class="bor-bottom">
        <td colspan="7" class="text-center">
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
    <td scope="col" colspan="7" class="text-center pagination-block" data-type="orders">{{ $orders->links() }}</td>
</tr>