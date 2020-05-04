<form id="change-prom-cat-form" action="{{ asset('admin/prom/categories/'.$prom_cat->id) }}" method="PUT">
    {{csrf_field()}}
    {{ method_field('PUT') }}
    <select class="form-control select-prom-cat"  name="subcategory_id">
        @foreach($subcategories as $subcategory)
            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-form btn-success shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 change-prom-cat" data-form="#change-prom-cat-form">подтвердить</button>
    <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>
</form>
<script>
    $('.select-prom-cat').select2({
        placeholder: 'Подкатегории не найдены',
        dropdownParent: $("#prom-cat-modal")
    });
</script>
