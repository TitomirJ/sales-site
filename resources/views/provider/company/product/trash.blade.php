<label for="category">Выбирете категорию*</label>
<select class="get-subcat-select  select-1 is-invalid" id="product-category" myUrl="{{ asset('/company/get/subcategories') }}" name="category" style="width: 100%;">
    @forelse($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
    @empty
        <option>Категории отсутствуют</option>
    @endforelse
</select>

<label for="category">Выбирете категорию*</label>
<select class="get-subcat-select  select-1 is-invalid" id="product-category" myUrl="{{ asset('/company/get/subcategories') }}" name="category" style="width: 100%;">
        @forelse($categories as $category)
                <option value="{{ $category->id }}"
                        @if($category->id == $product->category_id)
                        selected
                        @endif
                >{{ $category->name }}</option>
        @empty
                <option>Категории отсутствуют</option>
        @endforelse
</select>

<label for="category">Выбирете категорию*</label>
<select class="get-subcat-select  select-1 is-invalid" id="product-category" myUrl="{{ asset('/company/get/subcategories') }}" name="category" style="width: 100%;">
        @forelse($categories as $category)
                <option value="{{ $category->id }}"
                        @if($category->id == $product->category_id)
                        selected
                        @endif
                >{{ $category->name }}</option>
        @empty
                <option>Категории отсутствуют</option>
@endforelse
</select>