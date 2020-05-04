<div class="row">
    <div class="col-12">
        <h4>Поиск по фильтрам</h4>
    </div>
</div>
<form  action="{{ asset('admin/moderation/products/chprice/filter') }}" method="GET" data-type="2" onsubmit="return false" class="row">
    <div class="col-12 col-md-4 d-flex justify-content-center">
        <select name="company_id" id="" class="search-products-moderator-c company-select2">
            <option value="all">Все компании</option>
            @foreach($companies_chprice as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-md-4">
        <input type="text" name="name_like_persent" class="p-2 h-100 w-100 search-products-moderator" placeholder="Введите наименование">
    </div>
    <div class="col-12 col-md-4">
        <select name="subcategory_id" id="" class="search-products-moderator-c subcategory-select2">
            <option value="all">Все подкатегории</option>
            @foreach($subcat_chprice as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
</form>
