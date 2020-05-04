<h5 class="w-100 text-center">Вы подтверждаете, что товар доставлен?</h5>
<form action="{{ asset('company/change/status/order/'.$order->id) }}" method="POST" data-id="{{ $order->id }}">
    {{ csrf_field() }}
    <input type="hidden" name="action" value="6">

    <button type="submit" class="btn btn-success square_btn shadow-custom text-uppercase border-radius-50 com-ord-stat-b">Подтвердить</button>
    <button type="button" class="btn btn-secondary square_btn shadow-custom text-uppercase border-radius-50" data-dismiss="modal">Отмена</button>
</form>
