<div class="dropdown">
    <button class="btn-trans dropdown-toggle f36" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
    </button>
    <div class="dropdown-menu border-radius border-0 text-lowercase shadow-custom">
        @if(!isset($cancel_data->type))
            <a href="{{ asset('admin/moderation/order/'.$order->id.'/show/modal') }}" data-type="restore" class="dropdown-item font-weight-bold drop-menu-actions show-moder-ord">востановить</a>
            <a href="{{ asset('admin/moderation/order/'.$order->id.'/show/modal') }}" data-type="cancel" class="dropdown-item font-weight-bold drop-menu-actions show-moder-ord">отменить</a>
        @endif
        <a href="{{ asset('admin/moderation/order/'.$order->id.'/show/modal') }}" data-type="ignor" class="dropdown-item font-weight-bold drop-menu-actions show-moder-ord">игнорировать</a>
        <a href="{{ asset('admin/moderation/order/'.$order->id.'/show/modal') }}" data-type="block" class="dropdown-item font-weight-bold drop-menu-actions show-moder-ord">заблокировать</a>
    </div>

</div>
