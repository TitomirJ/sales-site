<form class="form-horizontal" id="edit-cat-form" method="POST" action="{{ asset('/admin/categories/'.$category->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="form-group">
        <label for="name">Название категории</label>
        <input id="name" type="text" class="form-control" name="name" value="{{ $category->name }}" required>
    </div>

    <div class="form-group">
        <label for="commission">Размер комиссии</label>
        <input id="commission" type="text" class="commission-mask form-control" name="commission" value="@if($category->commission >= 10){{$category->commission}}@else{{'0'.$category->commission}}@endif" >
    </div>

    <div class="wrapper-checkbox mb-5">
        <input type="checkbox" class="css-checkbox " id="group-edit-cat" name="group">
        <label for="group-edit-cat" class="css-label text-center" style="font-size: 14px; color: red;">Изменить комиссию всем подкатегориям данной категории, на указаный процент?</label>
    </div>

    <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 edit-cat-submit">
        Изменить категорию
    </button>
    <button type="button" class="btn btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">Отмена</button>
</form>








