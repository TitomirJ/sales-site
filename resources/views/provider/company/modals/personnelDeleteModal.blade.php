<div class="modal fade" id="modal-delete-manager" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content shadow-custom border-0">

            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="">Удаление сотрудника</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                За данным сотрудником закреплено "<span class="count-products"></span>" товар(ов) и "<span class="count-orders"></span>" заказов<br>
                Выберите на кого хотите закрепить их перед удалением.
                <form id="delete-personnel-form" action="" method="POST">
                    {{ csrf_field() }}
                    <select class="form-control mt-2 personnel-select" name="responsible_id">
                        @foreach($personnel as $p)
                            <option class="personnel-option" value="{{ $p->id }}">{{$p->getFullName()}}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="modal-footer">
                <button type="submit" form="delete-personnel-form" class="btn square_btn shadow-custom text-uppercase border-radius-50">Удалить</button>
                <button type="button" class="btn square_btn shadow-custom text-uppercase border-radius-50" data-dismiss="modal">Отмена</button>
            </div>
            
        </div>
    </div>
</div>
