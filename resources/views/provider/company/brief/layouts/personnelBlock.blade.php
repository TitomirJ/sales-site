<div class="order-personel-title f14 text-uppercase text-white border-radius p-1 pl-2 pr-2 mb-2 shadow-custom bg-secondary">
    сделки по менеджерам
</div>

<div class="company-users">
    @foreach($company_users as $cu)
        <div class="d-flex justify-content-between align-items-center border-bottom pb-1">

            <div class="orders-left-wrap d-flex align-items-center">

                <div class="orders-text">
                    <div class="orders-name">
                        {{$cu -> getFullName()}}
                    </div>
                    <div class="orders-num--of-orders font-weight-bold">
                        <? $count_render = $cu->dinCountOrders($from, $to); ?>
                        @if($count_render >1)
                            {{$count_render}} сделки
                        @elseif($count_render == 0)
                            Сделок нет
                        @else
                            {{$count_render}} сделка
                        @endif
                    </div>
                </div>

            </div>

            <div class="orders-right-wrap">
                {{$cu ->dinTotalSaleSum($from, $to)}} грн
            </div>

        </div>
    @endforeach
</div>
