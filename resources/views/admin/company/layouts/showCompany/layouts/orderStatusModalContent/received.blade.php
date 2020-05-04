<h6 class="w-100 text-center mb-3"><i class="fa fa-info-circle text-info" aria-hidden="true"></i> Вы уверены, что хотите изменить статус заказа на "Выполнен"?</h6>
<form class="row mb-3" action="{{ asset('admin/company/order/'.$order->id.'/change-status') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="action" value="{{ $action }}">
    <input type="hidden" name="confirm" value="true">
    <div class="col-md-6">
        <button type="submit" class="btn btn-success shadow-custom text-uppercase border-radius-50 w-100 submit-c-status-form">Подтвердить</button>
    </div>
    <div class="col-md-6">
        <button type="button" class="btn btn-secondary shadow-custom text-uppercase border-radius-50 w-100" data-dismiss="modal">Отмена</button>
    </div>
</form>