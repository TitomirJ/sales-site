<div class="dropdown">
    <button class="btn-trans dropdown-toggle f36" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
    </button>
    <div class="dropdown-menu border-radius border-0 text-lowercase shadow-custom">
      <a href="{{asset('/admin/company/'.$c->id)}}" class="dropdown-item font-weight-bold drop-menu-actions">Посмотреть</a>
      <a class="dropdown-item font-weight-bold drop-menu-actions" href="{{ asset('/admin/company/'.$c->id.'/edit?type=info') }}">Редактировать</a>
      <a href="{{asset('/admin/delete/company/'.$c->id)}}" class="dropdown-item font-weight-bold drop-menu-actions confirm-modal" text="Вы уверны, что хотите удалить компанию? После удаления ее нельзя востановить, все данные о пользователях, товары, заказы, транзакции и все что связано с этой комапнией будет удалено безвозвратно!">Удалить</a>
    </div>
</div>
