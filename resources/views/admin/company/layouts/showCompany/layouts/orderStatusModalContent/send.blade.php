<h6 class="w-100 text-center mb-3"><i class="fa fa-info-circle text-info" aria-hidden="true"></i>Обязательно выберите способ доставки</h6>
<form action="{{ asset('admin/company/order/'.$order->id.'/change-status') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="action" value="{{ $action }}">
    <input type="hidden" name="confirm" value="true">

    <div class="row">
        <div class="col-12">

        </div>
        <?
            $array_del_mathods = ['Нова пошта', 'Новая Почта', 'Нова Пошта', 'Новая почта'];
            $flag = in_array($order->delivery_method, $array_del_mathods);
        ?>
        <div class="col-md-10 offset-md-1">

            <div class="custom-control custom-radio custom-control-block">
                <input type="radio" id="delivery-m-np" name="delivery_method" class="custom-control-input del-met-radio" data-type="num-np-block-value" <?= ($flag)? 'checked' : '' ?> value="Новая почта">
                <label class="custom-control-label" for="delivery-m-np">&nbsp;&nbsp;&nbsp;Новая почта</label>
            </div>
            <div class="form-group" id="num-np-block" style="display: <?= ($flag)? 'block' : 'none'?>;">
                <input type="text" id="num-np-block-value" name="ttn" class="form-control text-center text-primary" autocomplete="off" placeholder="ТТН Новой почты..." style="font-size: 20px;">
            </div>

            <div class="custom-control custom-radio custom-control-block">
                <input type="radio" id="delivery-m-up" name="delivery_method" class="custom-control-input del-met-radio" data-type="num-up-block-value" value="УкрПочта">
                <label class="custom-control-label" for="delivery-m-up">&nbsp;&nbsp; УкрПочта</label>
            </div>
            <div class="form-group" id="num-up-block" style="display: none;">
                <input type="text" id="num-up-block-value" name="code_up" class="form-control text-center text-primary" autocomplete="off" placeholder="Код посылки УкрПочты..." style="font-size: 20px;">
            </div>

            <div class="custom-control custom-radio custom-control-block">
                <input type="radio" id="delivery-m-kur" name="delivery_method" class="custom-control-input del-met-radio" <?= (!$flag)? 'checked' : '' ?> value="Курьером">
                <label class="custom-control-label" for="delivery-m-kur">&nbsp;&nbsp;&nbsp;Курьером</label>
            </div>
            <div class="custom-control custom-radio custom-control-block">
                <input type="radio" id="delivery-m-your" name="delivery_method" class="custom-control-input del-met-radio" value="Самовывоз">
                <label class="custom-control-label" for="delivery-m-your">&nbsp;&nbsp;&nbsp;Самовывоз</label>
            </div>
        </div>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col-md-6">
            <button type="submit" class="btn btn-success shadow-custom text-uppercase border-radius-50 w-100 submit-c-status-form">Подтвердить</button>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-secondary shadow-custom text-uppercase border-radius-50 w-100" data-dismiss="modal">Отмена</button>
        </div>
    </div>
</form>
<script>
    $("#num-np-block-value").mask("9 9 9 9 9 9 9 9 9 9 9 9 9 9");
</script>