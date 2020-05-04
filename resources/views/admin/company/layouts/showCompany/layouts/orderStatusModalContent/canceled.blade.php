<form class="row mb-3" action="{{ asset('admin/company/order/'.$order->id.'/change-status') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="confirm" value="true">


        <? $curren_array_rozet_statuses = [1, 26, 2, 3, 4, 5, 15, 45, 12, 39, 19];?>
    @if($market_id == '1')<?//Розетка?>

        @if($market_order_status != true)<?//?>
            <div class="col-12">
                <h6 class="w-100 text-center mb-3"><i class="fa fa-info-circle text-danger" aria-hidden="true"></i> Отменить текущий заказ невозможно. Свяжитесь с нашим оператором для решения текущей задачи.</h6>
            </div>
        @elseif(in_array($market_order_status, $curren_array_rozet_statuses))<?//для заказов со статусом Новый или Оброб. менеджером на Розетке?>

            <div class="col-12">
                <div class="form-group">
                    <input type="hidden" name="action" value="{{ $action }}">
                    <label for="cancel-type">Причина отмены:</label>
                    <select class="form-control cancel-s2" name="cancel_type" id="cancel-type">
                        @foreach($curent_st_roz as $i)
                            <option value="{{ $i['key'] }}">{{ $i['value'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="cancel-text">Описание отмены:</label>
                    <textarea name="cancel_text" class="form-control textarea-autosize" rows="3" id="cancel-text"></textarea>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <button type="submit" class="btn btn-success shadow-custom text-uppercase border-radius-50 w-100 submit-c-status-form">Подтвердить</button>
            </div>
            <div class="col-md-6 mt-3">
                <button type="button" class="btn btn-secondary shadow-custom text-uppercase border-radius-50 w-100" data-dismiss="modal">Отмена</button>
            </div>

        @else<?//?>

            <div class="col-12">
                <h6 class="w-100 text-center mb-3"><i class="fa fa-info-circle text-danger" aria-hidden="true"></i> Отменить текущий заказ невозможно. Свяжитесь с нашим оператором для решения текущей задачи.</h6>
            </div>

        @endif
    @else<?//Другие?>
        <input type="hidden" name="action" value="{{ $action }}">
        <div class="col-12">
            <div class="form-group">
                <label for="cancel-type">Причина отмены:</label>
                <select class="form-control cancel-s2" name="cancel_type" id="cancel-type">
                    @foreach( $curent_st_prom_and_other as $i)
                        <option value="{{ $i['key'] }}">{{ $i['value'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="cancel-text">Описание отмены:</label>
                <textarea name="cancel_text" class="form-control textarea-autosize" rows="3" id="cancel-text"></textarea>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <button type="submit" class="btn btn-success shadow-custom text-uppercase border-radius-50 w-100 submit-c-status-form">Подтвердить</button>
        </div>
        <div class="col-md-6 mt-3">
            <button type="button" class="btn btn-secondary shadow-custom text-uppercase border-radius-50 w-100" data-dismiss="modal">Отмена</button>
        </div>

    @endif
</form>

<script type="text/javascript">
    $('.cancel-s2').select2({
        placeholder: 'Тип отмены не найден',
        dropdownParent: $("#change-status-order-modal")
    });
    autosize($('.textarea-autosize'));
</script>