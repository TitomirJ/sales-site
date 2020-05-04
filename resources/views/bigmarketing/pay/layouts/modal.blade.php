<div class="modal fade" id="pay-form-modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered border-radius-50" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title ajax-modalPay-title text-center w-100" id="modalTitle">Проверьте данные!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ajax-modalPay-body">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@if(session('result-liqpay'))
    <? $result = session('result-liqpay');?>
    <div class="modal fade" id="resault-form-modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered border-radius-50" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-center w-100" id="modalTitle">Результат платежа</h5>
                </div>
                <div class="modal-body">
                    @if($result->status == 'sandbox' || $result->status == 'success')
                        <div class="row">
                            <div class="col-12 text-center">Информация о платеже:</div>
                        </div>
                        <div class="row">
                            <div class="col-5 offset-1">
                                Статус платежа:
                            </div>
                            <div class="col-5 text-success">
                                {{ $result->status }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 offset-1">
                                Дата оплаты:
                            </div>
                            <div class="col-5">
                                {{ date('d-m-Y H:i:s', ($result->create_date/1000)) }}
                            </div>
                        </div>
                        @if(isset($result->sender_first_name) && isset($result->sender_last_name))
                            <div class="row">
                                <div class="col-5 offset-1">
                                    Плательщик:
                                </div>
                                <div class="col-5">
                                    {{ $result->sender_first_name }}&nbsp;&nbsp;{{ $result->sender_last_name }}
                                </div>
                            </div>
                        @elseif(isset($result->sender_first_name) && !isset($result->sender_last_name))
                            <div class="row">
                                <div class="col-5 offset-1">
                                    Плательщик:
                                </div>
                                <div class="col-5">
                                    {{ $result->sender_first_name }}&nbsp;&nbsp;
                                </div>
                            </div>
                        @elseif(!isset($result->sender_first_name) && isset($result->sender_last_name))
                            <div class="row">
                                <div class="col-5 offset-1">
                                    Плательщик:
                                </div>
                                <div class="col-5">
                                    &nbsp;&nbsp;{{ $result->sender_last_name }}
                                </div>
                            </div>
                        @else

                        @endif
                        <div class="row">
                            <div class="col-5 offset-1">
                                Способ оплаты:
                            </div>
                            <div class="col-5">
                                @if($result->paytype == 'privat24')
                                    Приват 24
                                @elseif($result->paytype == 'card')
                                    Карта
                                @elseif($result->paytype == 'liqpay')
                                    LiqPay
                                @elseif($result->paytype == 'masterpass')
                                    MasterPass
                                @else
                                    {{ $result->paytype }}
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 offset-1">
                                Валюта:
                            </div>
                            <div class="col-5">
                                {{ $result->currency }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 offset-1">
                                Сумма:
                            </div>
                            <div class="col-5">
                                {{ $result->amount }}&nbsp;грн.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 offset-1">
                                Комиссия банка:
                            </div>
                            <div class="col-5">
                                {{ $result->sender_commission }}&nbsp;грн.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 offset-1">
                                Номер транзакции:
                            </div>
                            <div class="col-5">
                                {{ $result->transaction_id }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 offset-1">
                                Назначение платежа:
                            </div>
                            <div class="col-5">
                                {{ $result->description }}
                            </div>
                        </div>

                    @elseif($result->status == 'failure')
                        <h5 class="w-100 text-danger text-center">Платеж не прошел
                            (
                            @if($result->err_code == 'cancel')
                                отменено пользователем
                            @else
                                {{ $result->err_description }}
                            @endif
                        )
                        </h5>
                        <div class="row">
                            <div class="col-12 text-center">Информация о платеже:</div>
                        </div>
                        <div class="row">
                            <div class="col-5 offset-1">
                                Дата оплаты:
                            </div>
                            <div class="col-5">
                                {{ date('d-m-Y H:i:s', ($result->create_date/1000)) }}
                            </div>
                        </div>
                        @if(isset($result->sender_first_name) && isset($result->sender_last_name))
                            <div class="row">
                                <div class="col-5 offset-1">
                                    Плательщик:
                                </div>
                                <div class="col-5">
                                    {{ $result->sender_first_name }}&nbsp;&nbsp;{{ $result->sender_last_name }}
                                </div>
                            </div>
                        @elseif(isset($result->sender_first_name) && !isset($result->sender_last_name))
                            <div class="row">
                                <div class="col-5 offset-1">
                                    Плательщик:
                                </div>
                                <div class="col-5">
                                    {{ $result->sender_first_name }}&nbsp;&nbsp;
                                </div>
                            </div>
                        @elseif(!isset($result->sender_first_name) && isset($result->sender_last_name))
                            <div class="row">
                                <div class="col-5 offset-1">
                                    Плательщик:
                                </div>
                                <div class="col-5">
                                    &nbsp;&nbsp;{{ $result->sender_last_name }}
                                </div>
                            </div>
                        @else

                        @endif
                        <div class="row">
                            <div class="col-5 offset-1">
                                Валюта:
                            </div>
                            <div class="col-5">
                                {{ $result->currency }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 offset-1">
                                Сумма:
                            </div>
                            <div class="col-5">
                                {{ $result->amount }}&nbsp;грн.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 offset-1">
                                Назначение платежа:
                            </div>
                            <div class="col-5">
                                {{ $result->description }}
                            </div>
                        </div>
                    @elseif($result->status == 'error')
                        <h5 class="w-100 text-danger text-center">Платеж не прошел из-за технической ошибки</h5>
                        <div class="row">
                            <div class="col-12 text-center">Описание ошибки:</div>
                        </div>
                        <div class="row">
                            <div class="col-4 offset-1">
                                Код ошибки:
                            </div>
                            <div class="col-6">
                                {{ $result->err_code }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 offset-1">
                                Описание ошибки:
                            </div>
                            <div class="col-6">
                                {{ $result->err_description }}
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#resault-form-modal').modal();
        });
    </script>
@endif