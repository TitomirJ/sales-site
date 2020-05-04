<div class="dropdown">
    <button class="btn-trans dropdown-toggle f36" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
    </button>
    <div class="dropdown-menu border-radius border-0 text-lowercase">
        @if($p->status_moderation != '2')
            <a href="" class="dropdown-item font-weight-bold drop-menu-actions">Посмотреть</a>
            @if($p->deleted_at == null)
            <a class="check-edit-product dropdown-item font-weight-bold drop-menu-actions" href="" myUrl="">Редактировать</a>
            <a href="" class="dropdown-item font-weight-bold drop-menu-actions">Клонировать</a>
            @endif
            <a href="" class="dropdown-item font-weight-bold drop-menu-actions">заказы по товару <span class="badge badge-pill badge-info">{{ $p->orders->count() }}</span></a>
        @else
            <a href="" class="dropdown-item font-weight-bold drop-menu-actions">Посмотреть</a>
            <a class="check-edit-product dropdown-item font-weight-bold drop-menu-actions" href="" myUrl="">Редактировать</a>
            <a class="dropdown-item font-weight-bold drop-menu-actions delete-prod-but" href="" data-id="" data-url="">Удалить</a>
        @endif
    </div>
</div>
