<form  action="{{ asset('admin/moderation/products/') }}" method="GET" data-type="3" onsubmit="return false" class="row">
    <input type='hidden' name="filter" value="true">
    <input type='hidden' name="type" value="all">
    <div class="col-12 col-md-3">
        <input type="number" name="product_id" class="p-2 h-100 w-100 search-products-moderator" placeholder="ID товара">
    </div>
    <div class="col-12 col-md-3">
        <input type="text" name="code_like_persent" class="p-2 h-100 w-100 search-products-moderator" placeholder="Артикул товара">
    </div>
    <div class="col-12 col-md-3">
        <input type="text" name="name_like_persent" class="p-2 h-100 w-100 search-products-moderator" placeholder="Введите наименование">
    </div>
    <div class="col-12 col-md-3 d-flex justify-content-center">
        <select name="company_id" id="" class="search-products-moderator-c company-select2">
            <option value="all">Все компании</option>
            @foreach($companies as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-md-3">
        <select name="subcategory_id" id="" class="search-products-moderator-c subcategory-select2">
            <option value="all">Все подкатегории</option>
            @foreach($subcat as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-md-3">
        <select name="status_moderation_equally" id="" class="search-products-moderator-c status-remod-select2">
            <option value="all">Все статусы модерации</option>
            <option value="0">На модерации</option>
            <option value="1">Прошли модерацию</option>
            <option value="2">Невалидный контент</option>
            <option value="3">Заблокирован модератором</option>
        </select>
    </div>
    <div class="col-12 col-md-3">
        <select name="status_available_equally" id="" class="search-products-moderator-c status-remod-select2">
            <option value="all">Все статусы наличия</option>
            <option value="1">В наличии</option>
            <option value="0">Не в наличии</option>
        </select>
    </div>
    <div class="col-12 col-md-3">
        <select name="status_spacial_equally" id="" class="search-products-moderator-c status-remod-select2">
            <option value="all">Все статусы рассылки</option>
            <option value="1">Отпавляются</option>
            <option value="0">Не отправляются</option>
        </select>
    </div>
</form>
