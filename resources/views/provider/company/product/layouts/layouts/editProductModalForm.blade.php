<form action="{{ asset('company/short_edit/product/'.$product->id) }}" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="price">Розничная цена</label>
        <input type="number" step="any" min="0" class="form-control check-price border-radius blue-input" id="product-price" name="price" placeholder="Укажите цену..." value="{{ $product->price }}" required>
    </div>
    <div class="form-group">
        <label for="old-price">Старая цена*</label>
        <input type="number" step="any" min="0" class="form-control check-price border-radius blue-input" id="old-price" name="old_price" placeholder="Укажите старую цену..." value="{{ $product->old_price }}">
    </div>
    <div class="d-flex align-items-center h-100 text-uppercase mt-2 ">
        <div class="mr-2">Не в наличии/В наличии</div>
        <label class="switch mb-0">
            <input type="checkbox" name="status_available" class=""  value="1" {{ ($product->status_available == '1')? "checked": '' }}>
            <span class="slider round "></span>
        </label>
    </div>
    <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 text-white">Изменить</button>
</form>
