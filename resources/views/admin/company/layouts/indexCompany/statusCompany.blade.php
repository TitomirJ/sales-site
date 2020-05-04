@if($c->blocked == '1')
    <span class="badge badge-pill badge-danger">заблокирована</span>
@elseif($c->block_ab == '0' && $c->block_bal == '0' && $c->block_new == '0' && $c->blocked == '0')
    <span class="badge badge-pill badge-success">Активна</span>
@else
    <span class="badge badge-pill badge-warning">Не активна</span>
@endif