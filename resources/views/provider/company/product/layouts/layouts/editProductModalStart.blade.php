Данный товар размещен на маркетплейсе и прошел модерацию
вы можете изменить только его цену и в наличии или не в наличии
если вы желаете полностью изменить товар
он будет вы веден с маркетплейса  а после отправлен на модерацию.
<div class="d-flex justify-content-around mt-3">
  <button type="button" class="btn square_btn shadow-custom text-uppercase border-radius-50 edit-modal-load-short-form mr-3" data-url="{{ asset('company/load/short_form/edit/'.$product->id) }}">Редактировать</button>
  <form action="{{ asset('company/products/'.$product->id.'/edit') }}" method="GET">
      <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 text-white">Вывести с маркетплейса</button>
  </form>
</div>
