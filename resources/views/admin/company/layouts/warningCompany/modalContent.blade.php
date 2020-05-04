@if($type == 'ignor')
    <form action="{{ asset('admin/company/'.$company_id.'/warnings/modal/action') }}" id="ignor-com" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="action" value="{{ $type }}">
        <input type="hidden" name="warning_id" value="{{ $warning }}">
        <button type="submit" class="btn btn-form btn-danger shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 submit-moder-com" data-form="#ignor-com">игнорировать</button>
        <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>
    </form>
@elseif($type == 'block')
    <form action="{{ asset('admin/company/'.$company_id.'/warnings/modal/action') }}" id="block-com" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="action" value="{{ $type }}">
        <input type="hidden" name="warning_id" value="{{ $warning }}">
        <button type="submit" class="btn btn-form btn-danger shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 submit-moder-com" data-form="#block-com">заблокировать</button>
        <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>
    </form>
@endif