@if($order->status == '0')
    <div class="dropdown">
        <button class="btn-trans dropdown-toggle f20" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-shopping-basket text-muted" aria-hidden="true"></i>&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i>
            <div class="font-weight-bold f16">новый</div>
        </button>
        <div class="dropdown-menu dropdown-cust border-radius border-0 text-lowercase shadow-custom" aria-labelledby="dropdownMenuButton" x-placement="top-start">
            <a href="" data-type="link" class="dropdown-item font-weight-bold drop-menu-actions c-ord-s-admin-btn">
                <i class="fa fa-shopping-basket text-warning" aria-hidden="true"></i>
                проверен
            </a>
            <a href="" data-type="link" class="dropdown-item font-weight-bold drop-menu-actions c-ord-s-admin-btn">
                <i class="fa fa-shopping-basket text-primary" aria-hidden="true"></i>
                отправлен
            </a>
            <a href="" data-type="link" class="dropdown-item font-weight-bold drop-menu-actions c-ord-s-admin-btn">
                <i class="fa fa-shopping-basket text-success" aria-hidden="true"></i>
                выполнен
            </a>
            <a href="" data-type="link" class="dropdown-item font-weight-bold drop-menu-actions c-ord-s-admin-btn">
                <i class="fa fa-shopping-basket text-danger" aria-hidden="true"></i>
                отменен
            </a>
        </div>
    </div>
@elseif($order->status == '4')
    <div class="dropdown">
        <button class="btn-trans dropdown-toggle f20" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-shopping-basket text-warning" aria-hidden="true"></i>&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i>
            <div class="font-weight-bold f16">проверен</div>
        </button>
        <div class="dropdown-menu dropdown-cust border-radius border-0 text-lowercase shadow-custom" aria-labelledby="dropdownMenuButton" x-placement="top-start">
            <a href="" data-type="link" class="dropdown-item font-weight-bold drop-menu-actions c-ord-s-admin-btn">
                <i class="fa fa-shopping-basket text-primary" aria-hidden="true"></i>
                отправлен
            </a>
            <a href="" data-type="link" class="dropdown-item font-weight-bold drop-menu-actions c-ord-s-admin-btn">
                <i class="fa fa-shopping-basket text-success" aria-hidden="true"></i>
                выполнен
            </a>
            <a href="" data-type="link" class="dropdown-item font-weight-bold drop-menu-actions c-ord-s-admin-btn">
                <i class="fa fa-shopping-basket text-danger" aria-hidden="true"></i>
                отменен
            </a>
        </div>
    </div>
@elseif($order->status == '3')
    <div class="dropdown">
        <button class="btn-trans dropdown-toggle f20" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-shopping-basket text-primary" aria-hidden="true"></i>&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i>
            <div class="font-weight-bold f16">отправлен</div>
        </button>
        <div class="dropdown-menu dropdown-cust border-radius border-0 text-lowercase shadow-custom" aria-labelledby="dropdownMenuButton" x-placement="top-start">
            <a href="" data-type="link" class="dropdown-item font-weight-bold drop-menu-actions c-ord-s-admin-btn">
                <i class="fa fa-shopping-basket text-success" aria-hidden="true"></i>
                выполнен
            </a>
            <a href="" data-type="link" class="dropdown-item font-weight-bold drop-menu-actions c-ord-s-admin-btn">
                <i class="fa fa-shopping-basket text-danger" aria-hidden="true"></i>
                отменен
            </a>
        </div>
    </div>
@elseif($order->status == '2')
    <i class="fa fa-shopping-basket text-danger" aria-hidden="true"></i>
    <div class="font-weight-bold f16">отменен</div>
@elseif($order->status == '1')
    <i class="fa fa-shopping-basket green-text" aria-hidden="true"></i>
    <div class="font-weight-bold f16">выполнен</div>
@endif
