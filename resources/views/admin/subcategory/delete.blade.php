@if($flag)
    <p class="w-100 text-center text-danger">Вы уверены что хотите удалить данную подкатегорию?<br> После удаления ее можно по желанию востановить.</p>
    <form id="delete-subcat" class="form-horizontal" method="POST" action="{{ asset('/admin/subcategories/'.$subcategory->id) }}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 delete-subcat-submit">
            удалить
        </button>

        <button type="button" class="btn btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">
            Отмена
        </button>

    </form>
@else
    <p class="w-100 text-center text-danger">Вы не можете удалить данную подкатегорию! <br> У данной подкатегории уже есть {{ $count_products }} шт. созданных товаров!</p>
    <button type="button" class="btn btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">
        закрыть
    </button>
@endif