@if($c->balance_sum > $c->balance_limit)
    <span class="text-success">{{$c->balance_sum}}</span>
@else
    <span class="text-danger">{{$c->balance_sum}}</span>
@endif