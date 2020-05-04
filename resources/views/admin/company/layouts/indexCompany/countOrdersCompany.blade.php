@if(count($c->orders) > 0)
    <?
        $math_orders = $c->orders;
        $math_orders_counts = [0,0,0,0,0];
        foreach ($math_orders as $math_order){
            if($math_order->status == '0'){
                $math_orders_counts[0]++;
            }
            if($math_order->status == '1'){
                $math_orders_counts[3]++;
            }
            if($math_order->status == '2'){
                $math_orders_counts[4]++;
            }
            if($math_order->status == '3'){
                $math_orders_counts[2]++;
            }
            if($math_order->status == '4'){
                $math_orders_counts[1]++;
            }
        }
    ?>
    <div class="dropdown">
        <button class="btn-trans dropdown-toggle font-weight-bold" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{count($c->orders)}}<br>
            ( <span class="text-secondary">{{ $math_orders_counts[0] }}</span> -
            <span class="text-warning">{{ $math_orders_counts[1] }}</span> -
            <span class="text-primary">{{ $math_orders_counts[2] }}</span> -
            <span class="text-success">{{ $math_orders_counts[3] }}</span> -
            <span class="text-danger">{{ $math_orders_counts[4] }}</span> )
        </button>
        <div class="dropdown-menu border-radius border-0 shadow-custom">
            <a  class="dropdown-item font-weight-bold drop-menu-actions">Заказы "{{ $c->name }}":</a>
            <a  class="dropdown-item drop-menu-actions"><span class="badge badge-secondary">{{ $math_orders_counts[0] }}</span>  Новые</a>
            <a  class="dropdown-item drop-menu-actions"><span class="badge badge-warning">{{ $math_orders_counts[1] }}</span>  Провереные</a>
            <a  class="dropdown-item drop-menu-actions"><span class="badge badge-primary">{{ $math_orders_counts[2] }}</span>  Отправленые</a>
            <a  class="dropdown-item drop-menu-actions"><span class="badge badge-success">{{ $math_orders_counts[3] }}</span>  Выполненые</a>
            <a  class="dropdown-item drop-menu-actions"><span class="badge badge-danger">{{ $math_orders_counts[4] }}</span>  Отмененные</a>
        </div>
    </div>
@else
    {{count($c->orders)}}
@endif