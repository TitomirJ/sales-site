<form method="POST" action="{{ asset('admin/transactions/store/') }}" id="add-bal-company-form">
    {{ csrf_field() }}
    <input type="hidden" name="action" value="add_bal">
    <input type="hidden" name="company_id" value="{{ $company->id }}">
</form>

<form method="POST" action="{{ asset('admin/transactions/store/') }}" id="remove-bal-company-form">
    {{ csrf_field() }}
    <input type="hidden" name="action" value="remove_bal">
    <input type="hidden" name="company_id" value="{{ $company->id }}">
</form>

<form method="POST" action="{{ asset('admin/transactions/store/') }}" id="add-ab-company-form">
    {{ csrf_field() }}
    <input type="hidden" name="action" value="add_ab">
    <input type="hidden" name="company_id" value="{{ $company->id }}">
</form>

<form method="POST" action="{{ asset('admin/company/tariff/change') }}" id="change-tariff-company-form">
    {{ csrf_field() }}
    <input type="hidden" name="company_id" value="{{ $company->id }}">
</form>

<div class="row">
    <div class="col-md-6">Смена тарифного плана компании: <span class="text-danger">(В разработке, не трогать!!!)</span></div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-8">
                <div class="form-group">
                    <select class="form-control" name="tariff_plan" id="" form="change-tariff-company-form">
                        <option value="0" @if($company->tariff_plan == '0') selected @endif>С абонплатой +5%</option>
                        <option value="1" @if($company->tariff_plan == '1') selected @endif>С абонплатой +4%</option>
                        <option value="2" @if($company->tariff_plan == '2') selected @endif>С абонплатой +3%</option>
                        <option value="3" @if($company->tariff_plan == '3') selected @endif>С абонплатой +2%</option>
                        <option value="4" @if($company->tariff_plan == '4') selected @endif>С абонплатой +1%</option>
                        <option value="5" @if($company->tariff_plan == '5') selected @endif>С абонплатой +0%</option>
                        <option value="6" @if($company->tariff_plan == '6') selected @endif>Без абонплаты +5%</option>
                        <option value="7" @if($company->tariff_plan == '7') selected @endif>Без абонплаты +4%</option>
                        <option value="8" @if($company->tariff_plan == '8') selected @endif>Без абонплаты +3%</option>
                        <option value="9" @if($company->tariff_plan == '9') selected @endif>Без абонплаты +2%</option>
                        <option value="10" @if($company->tariff_plan == '10') selected @endif>Без абонплаты +1%</option>
                        <option value="11" @if($company->tariff_plan == '11') selected @endif>Без абонплаты +0%</option>
                    </select>
                </div>
            </div>
            <div class="col-4">
                <button id="" class="btn square_btn shadow-custom w-100 confirm-com-settings" type="submit" form="change-tariff-company-form">подтвердить</button>
            </div>
        </div>

    </div>
</div>

<div class="row">

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type-company">Пополнить депозит</label>
                    <input type="number" class="form-control" name="amount" step="any" min="0" form="add-bal-company-form" value="1000">
                    <button id="" class="btn btn-success shadow-custom w-100 mt-4 confirm-com-settings" type="submit" form="add-bal-company-form">+ увеличить</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type-company">Уменьшить депозит</label>
                    <input type="number" class="form-control" name="amount" step="any" min="0" form="remove-bal-company-form" value="1000">
                    <button id="" class="btn btn-danger shadow-custom w-100 mt-4 confirm-com-settings" type="submit" form="remove-bal-company-form">- уменьшить</button>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-5">
        <div class="form-group">
            <label for="type-company">Продлить абонплату</label>
            <select class="form-control" name="tarif_id" id="" form="add-ab-company-form">
                @foreach($tarif_ab as $tarif)
                    <option value="{{ $tarif->id }}">{{ $tarif->amount }} грн. ({{ $tarif->count_d }} дней)</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-1">
        <button id="" class="btn square_btn shadow-custom w-100 mt-4 confirm-com-settings" type="submit" form="add-ab-company-form">+</button>
    </div>

</div>


<div class="row bg-light border-radius border-2 border-blue mt-5">
    <h4 class="w-100 text-center">Транзакции компании "{{ $company->name }}"</h4>
    <div class="col-md-12">
        <div class="wrapper-table mt-2">
            <div class="header-table bg-white border text-uppercase border-blue d-flex justify-content-between position-relative p-3">
                <div>дата</div>
                <div>тип</div>
                <div>сумма</div>
            </div>
            <div class="content-table content-table-history table-bg-commision" id="transactions-place">
                @forelse($transactions as $t)

                    @if($t->type_transaction != 4)

                        @if($t->type_transaction == 0 || $t->type_transaction == 3)
                            <div class="item-table d-flex justify-content-between balance-border-botttom p-3 green-bg">
                                <div>{{$t->created_at}}</div>
                                <div class="abon-r text-nowrap">
                                    @if($t->type_transaction == 0)
                                        Пополнение депозита
                                    @elseif($t->type_transaction == 3)
                                        Абонплата
                                    @endif
                                </div>
                                <div>+{{$t->total_sum}} грн</div>
                            </div>

                        @elseif($t->type_transaction == 1)
                            <div class="item-table d-flex justify-content-between balance-border-botttom p-3 red-bg">
                                <div>{{$t->created_at}}</div>
                                <div class="depos-r text-nowrap">
                                    Комиссия за заказ
                                </div>
                                <div>-{{$t->total_sum}} грн</div>
                            </div>
                        @elseif($t->type_transaction == 5)
                            <div class="item-table d-flex justify-content-between balance-border-botttom p-3 red-bg">
                                <div>{{$t->created_at}}</div>
                                <div class="depos-r text-nowrap">
                                    Снижение депозита
                                </div>
                                <div>-{{$t->total_sum}} грн</div>
                            </div>
                        @elseif($t->type_transaction == 2)
                            <div class="item-table d-flex justify-content-between balance-border-botttom p-3 bg-silver">
                                <div>{{$t->created_at}}</div>
                                <div class="depos-r text-nowrap">Удаленная транзакция</div>
                                <div>({{$t->total_sum}} грн)</div>
                            </div>
                        @endif

                    @endif

                @empty
                    <div class="item-table d-flex justify-content-between balance-border-botttom p-3 green-bg">
                        <div class="text-center w-100">Транзакций нет</div>
                    </div>
                @endforelse
            </div>
        </div>





    </div>
</div>

<script>
    (function($, undefined){
        $(function(){



        });
    })(jQuery);
</script>