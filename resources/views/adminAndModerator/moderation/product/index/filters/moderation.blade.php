<form id="test-form"  action="{{ asset('admin/moderation/products/') }}" method="GET" data-type="1" onsubmit="return false" class="row">
    <input type='hidden' name="filter" value="true">
    <input type='hidden' name="type" value="moderation">
    <div class="col-12 col-md-3 d-flex justify-content-center">
        <select name="company_id" id="" class="search-products-moderator-c company-select2">
            <option value="all">Все компании</option>
            @foreach($companies as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-md-3">
        <input type="text" name="name_like_persent" class="p-2 h-100 w-100 search-products-moderator" placeholder="Введите наименование">
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
        <select name="status_remod" id="" class="search-products-moderator-c status-remod-select2">
            <option value="all">Все</option>
            <option value="0">Не редактировался</option>
            <option value="1">Редактировался</option>
        </select>
    </div>
</form>
