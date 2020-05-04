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
