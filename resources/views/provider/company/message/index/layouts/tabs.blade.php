<?  $request = \Request::all();
    $flag = 1;
    if(isset($request['type'])){
        if($request['type'] == 'orders'){
            $flag = 1;
        }elseif($request['type'] == 'products'){
            $flag = 2;
        }elseif($request['type'] == 'other'){
            $flag = 3;
        }
    }
?>
<ul class="nav nav-pills flex-column flex-xl-row flex-nowrap nav-justified text-uppercase mb-3" >
    <li class="nav-item ml-5 mr-5 border-bot radius-top-left radius-top-right">
        <a class="nav-link rounded-0 dark-link <?= ($flag == 1) ? 'active' : '' ?> text-nowrap font-weight-bold"  href="{{ asset('company/messages?type=orders') }}">
            заказы
            @if($counts_charts['orders'] > 0)
                <span class="badge badge-pill badge-danger">{{ $counts_charts['orders'] }}</span>
            @endif
        </a>
    </li>

    <li class="nav-item ml-5 mr-5 border-bot radius-top-left radius-top-right">
        <a class="nav-link rounded-0 dark-link <?= ($flag == 2) ? 'active' : '' ?> text-nowrap font-weight-bold" href="{{ asset('company/messages?type=products') }}">
            вопросы о товарах
            @if($counts_charts['products'] > 0)
                <span class="badge badge-pill badge-danger">{{ $counts_charts['products'] }}</span>
            @endif
        </a>
    </li>

    <li class="nav-item ml-5 mr-5 border-bot radius-top-left radius-top-right">
        <a class="nav-link rounded-0 dark-link <?= ($flag == 3) ? 'active' : '' ?> text-nowrap font-weight-bold" href="{{ asset('company/messages?type=other') }}">
            вопросы от покупателей
            @if($counts_charts['other'] > 0)
                <span class="badge badge-pill badge-danger">{{ $counts_charts['other'] }}</span>
            @endif
        </a>
    </li>
</ul>