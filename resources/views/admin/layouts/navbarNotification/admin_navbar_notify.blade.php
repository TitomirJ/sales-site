@if(snake_case(class_basename($notification->type)) == 'order_shipped')
    <a class="dropdown-item" href="{{ asset('admin/notification/'.$notification->id.'/confirm') }}">
          <span class="text-success">
              <strong><i class="fa fa-cart-plus fa-fw"></i>Новый заказ</strong>

          </span>
        <span class="small float-right text-muted">{{(new Date($notification->data['replied_time']['date']))->diffForHumans()}}</span>
        <div class="dropdown-message w-100 small">Компания {{$notification->data['company_name']}} получила новый заказ.</div>
    </a>
    <div class="dropdown-divider"></div>
@elseif(snake_case(class_basename($notification->type)) == 'admin_transaction_shipped')
    @if($notification->data['transaction_type'] == '0')
        <a class="dropdown-item" href="{{ asset('admin/notification/'.$notification->id.'/confirm') }}">
              <span class="text-success">
                  <strong><i class="fa fa-money fa-fw"></i>Пополнен депозит на {{$notification->data['transaction_sum']}} грн.</strong>

              </span>
            <span class="small float-right text-muted">{{(new Date($notification->created_at))->diffForHumans()}}</span>
            <div class="dropdown-message w-100 small">Компания {{$notification->data['company_name']}} попополнила депозит.</div>
        </a>
        <div class="dropdown-divider"></div>
    @elseif($notification->data['transaction_type'] == '3')
        <a class="dropdown-item" href="{{ asset('admin/notification/'.$notification->id.'/confirm') }}">
              <span class="text-success">
                  <strong><i class="fa fa-money fa-fw"></i>Пополнен абонимент на {{$notification->data['transaction_sum']}} грн.</strong>

              </span>
            <span class="small float-right text-muted">{{(new Date($notification->created_at))->diffForHumans()}}</span>
            <div class="dropdown-message w-100 small">Компания {{$notification->data['company_name']}} попополнила абонимент.</div>
        </a>
        <div class="dropdown-divider"></div>
    @endif

@elseif(snake_case(class_basename($notification->type)) == 'admin_external_shipped')
    <a class="dropdown-item" href="{{ asset('admin/notification/'.$notification->id.'/confirm') }}">
              <span class="text-success">
                  <strong><i class="fa fa-money fa-fw"></i>Добавлена ссылка на XML товары</strong>

              </span>
        <span class="small float-right text-muted">{{(new Date($notification->created_at))->diffForHumans()}}</span>
        <div class="dropdown-message w-100 small">Компания {{$notification->data['company_name']}} загрузила XML!</div>
    </a>
    <div class="dropdown-divider"></div>
@elseif(snake_case(class_basename($notification->type)) == 'admin_company_aboniment_ended_shipped')
    <a class="dropdown-item" href="{{ asset('admin/notification/'.$notification->id.'/confirm') }}">
              <span class="text-warning">
                  <strong><i class="fa fa-clock-o"></i> Срок абонплаты меньше 12 часов</strong>

              </span>
        <span class="small float-right text-muted">{{(new Date($notification->created_at))->diffForHumans()}}</span>
        <div class="dropdown-message w-100 small">Компания "{{$notification->data['company_name']}}"</div>
    </a>
    <div class="dropdown-divider"></div>
@endif