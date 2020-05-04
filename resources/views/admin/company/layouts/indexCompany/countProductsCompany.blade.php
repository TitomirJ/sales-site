@if(count($c->products) > 0)
    <?
        $math_products = $c->products;
        $math_conts = [0,0,0,0];
        foreach($math_products as $math_product){
            if($math_product->status_moderation == '0' && $math_product->deleted_at == null){
                $math_conts[0]++;
            }
            if($math_product->status_moderation == '1' && $math_product->deleted_at == null){
                $math_conts[1]++;
            }
            if($math_product->status_moderation == '2' && $math_product->deleted_at == null){
                $math_conts[2]++;
            }
            if($math_product->status_moderation == '3' && $math_product->deleted_at == null){
                $math_conts[3]++;
            }
        }

    ?>
    <div class="dropdown">
        <button class="btn-trans dropdown-toggle font-weight-bold" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{count($c->products)}}<br>
                ( <span class="text-secondary">{{$math_conts[0]}}</span> -
                <span class="text-success">{{$math_conts[1]}}</span> -
                <span class="text-warning">{{$math_conts[2]}}</span> -
                <span class="text-danger">{{$math_conts[3]}}</span> )
        </button>
        <div class="dropdown-menu border-radius border-0 shadow-custom">
            <a  class="dropdown-item font-weight-bold drop-menu-actions">Товары "{{ $c->name }}":</a>
            <a  class="dropdown-item drop-menu-actions"><span class="badge badge-secondary">{{$math_conts[0]}}</span>  На модерации</a>
            <a  class="dropdown-item drop-menu-actions"><span class="badge badge-success">{{$math_conts[1]}}</span>  Прошли модерацию</a>
            <a  class="dropdown-item drop-menu-actions"><span class="badge badge-warning">{{$math_conts[2]}}</span>  Возвращены компании</a>
            <a  class="dropdown-item drop-menu-actions"><span class="badge badge-danger">{{$math_conts[3]}}</span>  Заблокированы</a>
        </div>
    </div>
@else
    {{count($c->products)}}
@endif