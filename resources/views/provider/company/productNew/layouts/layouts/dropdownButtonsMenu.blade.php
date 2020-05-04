<div class="dropdown">
    <button class="btn-trans dropdown-toggle f36" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
    </button>
    <div class="dropdown-menu border-radius border-0 text-lowercase shadow-custom">
        @if($p->status_moderation == '2')
            <a href="{{ asset('company/products/'.$p->id) }}" class="dropdown-item font-weight-bold drop-menu-actions">Посмотреть</a>
            <a href="{{ asset('company/orders/product/'.$p->id.'') }}" class="dropdown-item font-weight-bold drop-menu-actions">заказы по товару <span class="badge badge-pill badge-info">{{ $p->orders->count() }}</span></a>
            @if($p->deleted_at == null)
                <a class="check-edit-product dropdown-item font-weight-bold drop-menu-actions" href="{{ asset('company/check/edit/product/'.$p->id) }}" myUrl="{{ asset('company/products/'.$p->id.'/edit') }}">Редактировать</a>
                <a class="dropdown-item font-weight-bold drop-menu-actions delete-prod-but" href="{{ asset('company/product/delete') }}" data-id="{{ $p->id }}" data-url="{{ asset('/company/products') }}">Удалить</a>
            @endif
        @elseif($p->status_moderation == '3')
            <a href="{{ asset('company/products/'.$p->id) }}" class="dropdown-item font-weight-bold drop-menu-actions">Посмотреть</a>
        @else
            <a href="{{ asset('company/products/'.$p->id) }}" class="dropdown-item font-weight-bold drop-menu-actions">Посмотреть</a>
            <a href="{{ asset('company/orders/product/'.$p->id.'') }}" class="dropdown-item font-weight-bold drop-menu-actions">заказы по товару <span class="badge badge-pill badge-info">{{ $p->orders->count() }}</span></a>

            @if($p->deleted_at == null)
            <a class="check-edit-product dropdown-item font-weight-bold drop-menu-actions" href="{{ asset('company/check/edit/product/'.$p->id) }}" myUrl="{{ asset('company/products/'.$p->id.'/edit') }}">Редактировать</a>
            <a href="{{ asset('company/products/'.$p->id.'/clone') }}" class="dropdown-item font-weight-bold drop-menu-actions">Клонировать</a>
            <a class="dropdown-item font-weight-bold drop-menu-actions delete-prod-but" href="{{ asset('company/product/delete') }}" data-id="{{ $p->id }}" data-url="{{ asset('/company/products') }}">Удалить</a>
            @endif
        @endif
    </div>
</div>
