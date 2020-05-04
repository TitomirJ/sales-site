@if($type == 'ignor')
    <form action="{{ asset('admin/moderation/order/action') }}" method="POST" id="ignor-order">
        {{csrf_field()}}
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <input type="hidden" name="action" value="{{$type}}">
        <button type="submit" class="btn btn-form square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 submit-moder-ord" data-form="#ignor-order">Подтвердить</button>
        <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>
    </form>

@elseif($type == 'block')
    <form action="{{ asset('admin/moderation/order/action') }}" method="POST"  id="block-order">
        {{csrf_field()}}
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <input type="hidden" name="action" value="{{$type}}">
        <div class="form-group">
            <label for="short-error">Вид нарушения</label>
            <select class="form-control" id="short-error" name="short_error" id="">
                <option value="Нарушение 1">Нарушение 1</option>
                <option value="Нарушение 2">Нарушение 2</option>
            </select>
        </div>
        <div class="form-group">
            <label for="long-error">Описание нарушения</label>
            <textarea class="w-100" id="long-error" name="long_error" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-form btn-danger shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 submit-moder-ord" data-form="#block-order">Пожаловаться</button>
        <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>
    </form>
@elseif($type == 'restore')
    <form action="{{ asset('admin/moderation/order/action') }}" method="POST"  id="restore-order">
        {{csrf_field()}}
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <input type="hidden" name="action" value="{{$type}}">
        <button type="submit" class="btn btn-form btn-success shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 submit-moder-ord" data-form="#restore-order">Восстановить</button>
        <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>
    </form>
@elseif($type == 'restore-cancel')

    @if($order->marketplace_id == '2')

        <form action="{{ asset('admin/moderation/order/action') }}" method="POST"  id="restore-cancel-order">
            {{ csrf_field() }}

            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="action" value="{{$type}}">
            <div class="form-group">
                <label for="status-select-cancel">Причина отказа</label>
                <select class="form-control w-75 border-radius" name="cancellation_reason" id="status-select-cancel">
                    <option value="false">Выберите причину отказа...</option>
                    <option value="not_available">Нет в наличии</option>
                    <option value="price_changed">Цена была изменена</option>
                    <option value="buyers_request">Покупатель отказался</option>
                    <option value="not_enough_fields">Недостаточно данных</option>
                    <option value="duplicate">Дубликат заказа</option>
                    <option value="invalid_phone_number">Неправильный телефон заказчика</option>
                    <option value="less_than_minimal_price">Цена меньше указаной</option>
                    <option value="another">Другое</option>
                </select>
            </div>
            <div class="form-group" id="status-textarea-cancel-block" style="display: none;">
                <label for="status-textarea-cancel">Описание причины отказа</label>
                <textarea class="form-control" name="cancellation_text"  id="status-textarea-cancel"></textarea>
            </div>
            <button type="submit" class="btn btn-form btn-success shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 submit-moder-ord" data-form="#restore-cancel-order">Восстановить</button>
            <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>

        </form>

        <script>
            $('#status-select-cancel').select2({
                placeholder: 'Причины не найдены',
                dropdownParent: $("#moder-ord-modal")
            });
            $('#status-select-cancel').on('change', function (e) {
                e.preventDefault();
                var flag = $(this).val();
                if(flag == 'price_changed' || flag == 'not_enough_fields' || flag == 'another'){
                    $('#status-textarea-cancel-block').show();
                }else{
                    $('#status-textarea-cancel-block').hide();
                }
            });
        </script>

    @elseif($order->marketplace_id == '1')

        <form action="{{ asset('admin/moderation/order/action') }}" method="POST"  id="restore-cancel-order">
            {{ csrf_field() }}

            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="action" value="{{$type}}">
            <div class="form-group">
                <label for="status-select-cancel">Причина отказа</label>
                <select class="form-control w-100 border-radius select2-cancel-order-provider" name="cancellation_reason" id="status-select-cancel">

                        <option value="42">Нет в наличии</option>
                        <option value="18">Не удалось связаться с покупателем</option>
                        <option value="32">Отмена. Не устраивает разгруппировка заказа</option>
                        <option value="33">Отмена. Не устраивает стоимость доставки</option>
                        <option value="34">Отмена. Не устраивает перевозчик, способ доставки</option>
                        <option value="35">Отмена. Не устраивают сроки доставки</option>
                        <option value="36">Отмена. Клиент хочет оплату по безналу. У продавца нет такой возможности</option>
                        <option value="37">Отмена. Не устраивает предоплата</option>
                        <option value="38">Отмена. Не устраивает качество товара</option>
                        <option value="39">Отмена. Не подошли характеристики товара (цвет,размер)</option>
                        <option value="40"> Отмена. Клиент передумал</option>
                        <option value="41">Отмена. Купил на другом сайте</option>
                        <option value="43">Брак</option>

                </select>
            </div>
            <div class="form-group" id="status-textarea-cancel-block">
                <label for="status-textarea-cancel">Описание причины отказа</label>
                <textarea class="form-control textarea-autosize" name="cancellation_text"  id="status-textarea-cancel"></textarea>
            </div>
            <button type="submit" class="btn btn-form btn-success shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 submit-moder-ord" data-form="#restore-cancel-order">Восстановить</button>
            <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>

        </form>

        <script type="text/javascript">
            $('.select2-cancel-order-provider').select2({
                placeholder: 'Причины не найдены',
                dropdownParent: $("#moder-ord-modal")
            });
            autosize($('.textarea-autosize'));
        </script>

    @elseif($order->marketplace_id == '6')

        <form action="{{ asset('admin/moderation/order/action') }}" method="POST"  id="restore-cancel-order">
            {{ csrf_field() }}

            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="action" value="{{$type}}">
            <div class="form-group">
                <label for="status-select-cancel">Причина отказа</label>
                <select class="form-control w-100 border-radius select2-cancel-order-provider" name="cancellation_reason" id="status-select-cancel">
                    <option value="18">Не удалось связаться с покупателем</option>
                    <option value="17">Отмена. Не устраивает оплата</option>
                    <option value="20">Отмена. Не устраивает товар</option>
                    <option value="24">Отмена. Не устраивает доставка</option>
                    <option value="28">Некорректные контактные данные</option>
                    <option value="29">Отмена. Некорректная цена на сайте</option>
                    <option value="32">Отмена. Не устраивает разгруппировка заказа</option>
                    <option value="33">Отмена. Не устраивает стоимость доставки</option>
                    <option value="34">Отмена. Не устраивает перевозчик, способ доставки</option>
                    <option value="35">Отмена. Не устраивают сроки доставки</option>
                    <option value="36">Отмена. Клиент хочет оплату по безналу. У продавца нет такой возможности</option>
                    <option value="37">Отмена. Не устраивает предоплата</option>
                    <option value="38">Отмена. Не устраивает качество товара</option>
                    <option value="39">Отмена. Не подошли характеристики товара (цвет,размер)</option>
                    <option value="40"> Отмена. Клиент передумал</option>
                    <option value="41">Отмена. Купил на другом сайте</option>
                    <option value="42">Нет в наличии</option>
                    <option value="43">Брак</option>
                </select>
            </div>
            <div class="form-group" id="status-textarea-cancel-block">
                <label for="status-textarea-cancel">Описание причины отказа</label>
                <textarea class="form-control textarea-autosize" name="cancellation_text"  id="status-textarea-cancel"></textarea>
            </div>
            <button type="submit" class="btn btn-form btn-success shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 submit-moder-ord" data-form="#restore-cancel-order">Восстановить</button>
            <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>

        </form>

        <script type="text/javascript">
            $('.select2-cancel-order-provider').select2({
                placeholder: 'Причины не найдены',
                dropdownParent: $("#moder-ord-modal")
            });
            autosize($('.textarea-autosize'));
        </script>

    @endif

@elseif($type == 'cancel')

    @if($order->marketplace_id == '2')

        <form action="{{ asset('admin/moderation/order/action') }}" method="POST"  id="cancel-order">
            {{ csrf_field() }}

            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="action" value="{{$type}}">
            <div class="form-group">
                <label for="status-select-cancel">Причина отказа</label>
                <select class="form-control w-75 border-radius" name="cancellation_reason" id="status-select-cancel">
                    <option value="false">Выберите причину отказа...</option>
                    <option value="not_available">Нет в наличии</option>
                    <option value="price_changed">Цена была изменена</option>
                    <option value="buyers_request">Покупатель отказался</option>
                    <option value="not_enough_fields">Недостаточно данных</option>
                    <option value="duplicate">Дубликат заказа</option>
                    <option value="invalid_phone_number">Неправильный телефон заказчика</option>
                    <option value="less_than_minimal_price">Цена меньше указаной</option>
                    <option value="another">Другое</option>
                </select>
            </div>
            <div class="form-group" id="status-textarea-cancel-block" style="display: none;">
                <label for="status-textarea-cancel">Описание причины отказа</label>
                <textarea class="form-control" name="cancellation_text"  id="status-textarea-cancel"></textarea>
            </div>
            <button type="submit" class="btn btn-form btn-success shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 submit-moder-ord" data-form="#cancel-order">Восстановить</button>
            <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>

        </form>

        <script>
            $('#status-select-cancel').select2({
                placeholder: 'Причины не найдены',
                dropdownParent: $("#moder-ord-modal")
            });
            $('#status-select-cancel').on('change', function (e) {
                e.preventDefault();
                var flag = $(this).val();
                if(flag == 'price_changed' || flag == 'not_enough_fields' || flag == 'another'){
                    $('#status-textarea-cancel-block').show();
                }else{
                    $('#status-textarea-cancel-block').hide();
                }
            });
        </script>

    @elseif($order->marketplace_id == '1')

        <form action="{{ asset('admin/moderation/order/action') }}" method="POST"  id="cancel-order">
            {{ csrf_field() }}

            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="action" value="{{$type}}">
            <div class="form-group">
                <label for="status-select-cancel">Причина отказа</label>
                <select class="form-control w-100 border-radius select2-cancel-order-provider" name="cancellation_reason" id="status-select-cancel">

                    <option value="42">Нет в наличии</option>
                    <option value="18">Не удалось связаться с покупателем</option>
                    <option value="32">Отмена. Не устраивает разгруппировка заказа</option>
                    <option value="33">Отмена. Не устраивает стоимость доставки</option>
                    <option value="34">Отмена. Не устраивает перевозчик, способ доставки</option>
                    <option value="35">Отмена. Не устраивают сроки доставки</option>
                    <option value="36">Отмена. Клиент хочет оплату по безналу. У продавца нет такой возможности</option>
                    <option value="37">Отмена. Не устраивает предоплата</option>
                    <option value="38">Отмена. Не устраивает качество товара</option>
                    <option value="39">Отмена. Не подошли характеристики товара (цвет,размер)</option>
                    <option value="40"> Отмена. Клиент передумал</option>
                    <option value="41">Отмена. Купил на другом сайте</option>
                    <option value="43">Брак</option>

                </select>
            </div>
            <div class="form-group" id="status-textarea-cancel-block">
                <label for="status-textarea-cancel">Описание причины отказа</label>
                <textarea class="form-control textarea-autosize" name="cancellation_text"  id="status-textarea-cancel"></textarea>
            </div>
            <button type="submit" class="btn btn-form btn-success shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 submit-moder-ord" data-form="#cancel-order">Восстановить</button>
            <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>

        </form>

        <script type="text/javascript">
            $('.select2-cancel-order-provider').select2({
                placeholder: 'Причины не найдены',
                dropdownParent: $("#moder-ord-modal")
            });
            autosize($('.textarea-autosize'));
        </script>

    @elseif($order->marketplace_id == '6')

        <form action="{{ asset('admin/moderation/order/action') }}" method="POST"  id="cancel-order">
            {{ csrf_field() }}

            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="action" value="{{$type}}">
            <div class="form-group">
                <label for="status-select-cancel">Причина отказа</label>
                <select class="form-control w-100 border-radius select2-cancel-order-provider" name="cancellation_reason" id="status-select-cancel">
                    <option value="18">Не удалось связаться с покупателем</option>
                    <option value="17">Отмена. Не устраивает оплата</option>
                    <option value="20">Отмена. Не устраивает товар</option>
                    <option value="24">Отмена. Не устраивает доставка</option>
                    <option value="28">Некорректные контактные данные</option>
                    <option value="29">Отмена. Некорректная цена на сайте</option>
                    <option value="32">Отмена. Не устраивает разгруппировка заказа</option>
                    <option value="33">Отмена. Не устраивает стоимость доставки</option>
                    <option value="34">Отмена. Не устраивает перевозчик, способ доставки</option>
                    <option value="35">Отмена. Не устраивают сроки доставки</option>
                    <option value="36">Отмена. Клиент хочет оплату по безналу. У продавца нет такой возможности</option>
                    <option value="37">Отмена. Не устраивает предоплата</option>
                    <option value="38">Отмена. Не устраивает качество товара</option>
                    <option value="39">Отмена. Не подошли характеристики товара (цвет,размер)</option>
                    <option value="40"> Отмена. Клиент передумал</option>
                    <option value="41">Отмена. Купил на другом сайте</option>
                    <option value="42">Нет в наличии</option>
                    <option value="43">Брак</option>
                </select>
            </div>
            <div class="form-group" id="status-textarea-cancel-block">
                <label for="status-textarea-cancel">Описание причины отказа</label>
                <textarea class="form-control textarea-autosize" name="cancellation_text"  id="status-textarea-cancel"></textarea>
            </div>
            <button type="submit" class="btn btn-form btn-success shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 submit-moder-ord" data-form="#cancel-order">Восстановить</button>
            <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>

        </form>

        <script type="text/javascript">
            $('.select2-cancel-order-provider').select2({
                placeholder: 'Причины не найдены',
                dropdownParent: $("#moder-ord-modal")
            });
            autosize($('.textarea-autosize'));
        </script>

    @endif
@endif