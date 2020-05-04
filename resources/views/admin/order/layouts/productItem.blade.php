<div class="row">
    <?
        $gallery = json_decode($product->gallery);
    ?>
    <div class="col-4">
        <img src="{{ $gallery[0]->public_path }}" class="w-100" alt="">
    </div>
    <div class="col-8">
        <h5>Информация о компании</h5>
        <p>Компания: {{ $product->company->name }}</p>
        <p>Статус компании:
            @if($product->company->blocked == '1')
                <span class="badge badge-pill badge-danger">заблокирована</span>
            @elseif($product->company->block_ab == '0' && $product->company->block_bal == '0' && $product->company->block_new == '0' && $product->company->blocked == '0')
                <span class="badge badge-pill badge-success">Активна</span>
            @else
                <span class="badge badge-pill badge-warning">Не активна</span>
            @endif
        </p>
        <p>Депозит: {{ $product->company->balance_sum }} грн.</p>
        <hr>
        <h5>Информация о товаре</h5>
        <p>Наименование: {{ $product->name }}</p>
        <p>Цена: {{ $product->price }} грн.</p>
        <p>Комиссия: {{ $product->subcategory->commission }} %</p>
    </div>
</div>