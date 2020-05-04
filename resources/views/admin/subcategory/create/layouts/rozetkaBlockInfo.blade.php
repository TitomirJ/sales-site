@if($status)
    <div class="row">
        <h4 class="w-100 text-center">Категория Розетки</h4>
        <div class="col-8">
            <p>Найменование категории: {{ $response_rezetka_subcat->content->marketCategorys[0]->name }}</p>
            <p>Ко-во характеристик: {{ $count_params_rozetka }} шт.</p>
            <p>Ко-во значений: {{ $count_values_rozetka }} шт.</p>
        </div>
        <div class="col-4">
            <a class="text-info" target="_blank" href="{{ asset('admin/api/show/params/rozetka/' . $response_rezetka_subcat->content->marketCategorys[0]->category_id) }}"><i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i></a>
        </div>
    </div>
@else
    <div class="row">
        <h4 class="w-100 text-center">Категория Розетки</h4>
        <div class="col-12">
            Данные отсутсвуют!
        </div>
    </div>
@endif
