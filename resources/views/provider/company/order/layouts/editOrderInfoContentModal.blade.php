<form action="{{ asset('company/orders/'.$order->id.'/update_order_info') }}" method="POST" id="update-order-pr-form">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="edit-order-cast-name">ФИО</label>
        <input type="text" class="form-control" id="edit-order-name" name="edit_order_cast_name" placeholder="ФИО заказчика" maxlength="190" value="{{ $order->customer_name }}">
    </div>
    <div class="form-group">
        <label for="edit-order-cast-email">Эл. почта</label>
        <input type="email" class="form-control" id="edit-order-cast-email" name="edit_order_cast_email" placeholder="Эл. почта заказчика" maxlength="190" value="{{ $order->customer_email }}">
    </div>
    <div class="form-group">
        <label for="edit-order-cast-phone">Контактные телефоны</label>
        <input type="text" class="form-control" id="edit-order-cast-phone" name="edit_order_cast_phone" placeholder="Контактные телефоны" maxlength="190" value="{{ $order->customer_phone }}">
    </div>
    <div class="form-group">
        <label for="edit-order-cast-adress">Адрес доставки</label>
        <input type="text" class="form-control" id="edit-order-cast-adress" name="edit_order_cast_adress" placeholder="Адрес доставки" maxlength="190" value="{{ $order->customer_adress }}">
    </div>
    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
</form>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
