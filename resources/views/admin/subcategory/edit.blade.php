<form id="edit-subcat" class="form-horizontal" method="POST" action="{{ asset('/admin/subcategories/'.$subcategory->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="form-group">
        <label for="category-id">Выбрать категорию</label>
        <select class="form-control select2-edit-tcs" id="category-id" name="category_id">
            @forelse($categories as $category)
                <option value="{{ $category->id }}" {{ ($category->id == $subcategory->category_id)? 'selected' : '' }}>{{ $category->name }}</option>
            @empty
                <option value="0">Категории отсутствуют</option>
            @endforelse
        </select>
    </div>
    <input type="hidden" name="type_edit" value="{{$type}}">
    <div class="form-group">
        <label for="name">Название подкатегории</label>
        <input id="name" type="text" class="form-control" name="name" value="{{ $subcategory->name }}">
    </div>

    <div class="form-group">
        <label for="commission">Размер комиссии</label>
        <input id="commission" type="text" class="commission-mask form-control" name="commission" value="@if($subcategory->commission >= 10){{$subcategory->commission}}@else{{'0'.$subcategory->commission}}@endif">
    </div>

    <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 edit-subcat-submit">
        Изменить подкатегорию
    </button>

    <button type="button" class="btn btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">
        Отмена
    </button>

</form>

<script type="text/javascript">
    $('.select2-edit-tcs').select2({
        placeholder: 'Категории не найдены',
        dropdownParent: $("#editAndCreateModal")
    });
</script>