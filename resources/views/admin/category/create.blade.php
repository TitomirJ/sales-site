<form class="form-horizontal" id="create-cat-form" method="POST" action="{{ asset('/admin/categories') }}">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="theme-id">Выбрать тематику</label>
        <select class="select-edit-tcs form-control" id="theme-id" name="theme_id">
            @forelse($themes as $theme)
                <option value="{{ $theme->id }}"
                        @if(isset($selected_theme_id))
                            @if($selected_theme_id == $theme->id)
                                selected
                            @endif
                        @endif
                >{{ $theme->name }}</option>
            @empty
                <option value="0">Тематики отсутствуют</option>
            @endforelse
        </select>
    </div>

    <div class="form-group">
        <label for="name">Название категории</label>
        <input id="name" type="text" class="form-control border-radius" name="name">
    </div>

    <div class="form-group">
        <label for="commission">Размер комиссии</label>
        <input id="commission" type="text" class="commission-mask form-control border-radius" name="commission">
    </div>

    <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 add-new-cat">
        Добавить категорию
    </button>
    <button type="button" class="btn btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>

</form>

<script type="text/javascript">
$('.select-edit-tcs').select2({
    placeholder: 'Категории не найдены',
    dropdownParent: $("#editAndCreateModal")
});
</script>
