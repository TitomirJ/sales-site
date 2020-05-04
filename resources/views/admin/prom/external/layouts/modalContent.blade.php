@if($action == 'parsing')
    <form action="{{ asset('admin/prom/externals/'.$external->id.'/action') }}" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="action" value="{{$action}}">
        <button type="submit" class="btn btn-form btn-success shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">подтвердить</button>
        <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>
    </form>
@elseif($action == 'reparsing')
    <form action="{{ asset('admin/prom/externals/'.$external->id.'/action') }}" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="action" value="{{$action}}">
        <button type="submit" class="btn btn-form btn-success shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">подтвердить</button>
        <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>
    </form>
@endif