<!-- Modal -->
<div class="modal fade" id="successModer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 border-radius decoration-clip shadow-custom ovrfl-h">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="exampleModalLabel">Прошел модерацию</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Вы уверены что товар прошел модерацию? После подтверждения товар будет отправлен на маретплейсы.
        <form class="" action="{{ asset('admin/success/product') }}" method="post" id="confirmModalProduct">
          {{ csrf_field() }}
          <input type="hidden" name="product_id" value="{{$product->id}}">
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-form square_btn shadow-custom text-uppercase border-radius-50 admin-mod-button" form="confirmModalProduct">Подтвердить</button>
        <button type="button" class="btn btn-form square_btn shadow-custom text-uppercase border-radius-50" data-dismiss="modal">Отмена</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal invalid-->
<div class="modal fade" id="invalidModer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 border-radius decoration-clip shadow-custom ovrfl-h">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="exampleModalLabel">Невалидный контент</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Укажите в чем именно заключается ошибка.

        <form class="" action="{{ asset('admin/warning/product') }}" method="post" id="confirmModalInvalid">
          {{ csrf_field() }}
          <select class="form-control" name="short_error">
            <option value="Название">Название</option>
            <option value="Фото">Фото</option>
            <option value="Описание">Описание</option>
            <option value="Характеристики">Характеристики</option>
            <option value="Подкатегория">Подкатегория</option>
            <option value="Бренд">Бренд</option>
            <option value="Другое">Другое</option>
          </select>
          Развернутый ответ о ошибках допущеных при содании товара(будет видно при редактировании)
          <textarea name="long_error" class="form-control textarea-custom w-100 mt-2 long-error" maxlength="1500"></textarea>

          <input type="hidden" name="product_id" value="{{ $product->id }}">
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-form square_btn shadow-custom text-uppercase border-radius-50 admin-mod-button" form="confirmModalInvalid">Подтвердить</button>
        <button type="button" class="btn btn-form square_btn shadow-custom text-uppercase border-radius-50" data-dismiss="modal">Отмена</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal block-->
<div class="modal fade" id="blockModer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 border-radius decoration-clip shadow-custom ovrfl-h">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="exampleModalLabel">Прошел модерацию</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Вы уверены что хотите заблокировать товар? После подтверждения товар будет заблокирован
        <form class="" action="{{ asset('admin/danger/product') }}" method="post" id="confirmModalBlock">
          {{ csrf_field() }}
          <select class="form-control" name="short_error">
            <option value="Блокировка">Блокировка</option>
          </select>

          <textarea name="long_error" class="form-control textarea-custom w-100 mt-2 long-error" maxlength="1500"></textarea>
          <input type="hidden" name="product_id" value="{{ $product->id }}">
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-form square_btn shadow-custom text-uppercase border-radius-50 admin-mod-button" form="confirmModalBlock">Подтвердить</button>
        <button type="button" class="btn btn-form square_btn shadow-custom text-uppercase border-radius-50" data-dismiss="modal">Отмена</button>
      </div>
    </div>
  </div>
</div>
