<form action="{{ asset('company/change/status/order/'.$order->id) }}" method="POST" data-id="{{ $order->id }}">
    {{ csrf_field() }}
    <input type="hidden" name="action" value="5">
    <div class="form-group">
        <label for="code">Номер экспресс-накладной(Новая почта)*</label>
        <input type="number" class="form-control"  name="number" placeholder="Номер..."  autofocus required>
    </div>
    <button type="submit" class="btn btn-success com-ord-stat-b">Подтвердить</button>
</form>