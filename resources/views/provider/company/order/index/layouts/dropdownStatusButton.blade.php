<div class="dropdown">
    <button class="btn-trans dropdown-toggle f20" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        @if($order->status == '0')
            <i class="fa fa-shopping-basket text-muted" aria-hidden="true"></i>&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i>
            <div class="font-weight-bold f16">новый</div>
        @elseif($order->status == '1')
            <i class="fa fa-shopping-basket green-text" aria-hidden="true"></i>
            <div class="font-weight-bold f16">выполнен</div>
        @elseif($order->status == '2')
            <i class="fa fa-shopping-basket text-danger" aria-hidden="true"></i>
            <div class="font-weight-bold f16">отменен</div>
        @elseif($order->status == '3')
            <i class="fa fa-shopping-basket text-primary" aria-hidden="true"></i>&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i>
            <div class="font-weight-bold f16">отправлен</div>
        @elseif($order->status == '4')
            <i class="fa fa-shopping-basket text-warning" aria-hidden="true"></i>&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i>
            <div class="font-weight-bold f16">проверен</div>
        @endif
    </button>

    @if($order->status == '0')
        <div class="dropdown-menu dropdown-cust border-radius border-0 text-lowercase shadow-custom" aria-labelledby="dropdownMenuButton" x-placement="top-start">
            <a data-url="{{ asset('company/edit/status/order/'.$order->id) }}" data-action="newToConfirm" data-order="{{ $order->id }}" class="dropdown-item font-weight-bold drop-menu-actions change-o-status">
                <i class="fa fa-shopping-basket text-warning" aria-hidden="true"></i>
                Проверен
            </a>
            <a data-url="{{ asset('company/edit/status/order/'.$order->id) }}" data-action="newToSend" data-order="{{ $order->id }}" class="dropdown-item font-weight-bold drop-menu-actions change-o-status">
                <i class="fa fa-shopping-basket text-primary" aria-hidden="true"></i>
                Отправлен
            </a>
            <a data-url="{{ asset('company/edit/status/order/'.$order->id) }}" data-action="newToReceived" data-order="{{ $order->id }}" class="dropdown-item font-weight-bold drop-menu-actions change-o-status" >
                <i class="fa fa-shopping-basket green-text" aria-hidden="true"></i>
                выполнен
            </a>
            <a data-url="{{ asset('company/edit/status/order/'.$order->id) }}" data-action="newToCanceled" data-order="{{ $order->id }}" class="dropdown-item font-weight-bold drop-menu-actions change-o-status">
                <i class="fa fa-shopping-basket text-danger" aria-hidden="true"></i>
                Отменен
            </a>
        </div>
    @elseif($order->status == '3')
        <div class="dropdown-menu dropdown-cust border-radius border-0 text-lowercase shadow-custom" aria-labelledby="dropdownMenuButton" x-placement="top-start">
            <a data-url="{{ asset('company/edit/status/order/'.$order->id) }}" data-action="sendToReceived" data-order="{{ $order->id }}" class="dropdown-item font-weight-bold drop-menu-actions change-o-status" >
                <i class="fa fa-shopping-basket green-text" aria-hidden="true"></i>
                выполнен
            </a>
            <a data-url="{{ asset('company/edit/status/order/'.$order->id) }}" data-action="sendToCanceled" data-order="{{ $order->id }}" class="dropdown-item font-weight-bold drop-menu-actions change-o-status">
                <i class="fa fa-shopping-basket text-danger" aria-hidden="true"></i>
                Отменен
            </a>
        </div>
    @elseif($order->status == '4')
        <div class="dropdown-menu dropdown-cust border-radius border-0 text-lowercase shadow-custom" aria-labelledby="dropdownMenuButton" x-placement="top-start">
            <a data-url="{{ asset('company/edit/status/order/'.$order->id) }}" data-action="confirmToSend" data-order="{{ $order->id }}" class="dropdown-item font-weight-bold drop-menu-actions change-o-status">
                <i class="fa fa-shopping-basket text-primary" aria-hidden="true"></i>
                Отправлен
            </a>
            <a data-url="{{ asset('company/edit/status/order/'.$order->id) }}" data-action="confirmToReceived" data-order="{{ $order->id }}" class="dropdown-item font-weight-bold drop-menu-actions change-o-status" >
                <i class="fa fa-shopping-basket green-text" aria-hidden="true"></i>
                выполнен
            </a>
            <a data-url="{{ asset('company/edit/status/order/'.$order->id) }}" data-action="confirmToCanceled" data-order="{{ $order->id }}" class="dropdown-item font-weight-bold drop-menu-actions change-o-status">
                <i class="fa fa-shopping-basket text-danger" aria-hidden="true"></i>
                Отменен
            </a>
        </div>
    @endif


</div>
