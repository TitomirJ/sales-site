@if($status)
    <div class="row">
        <h4 class="w-100 text-center">Категория BigSales</h4>
        <div class="col-8">
            <p>Найменование категории: {{ $response_bigsales_subcat->name }}</p>
            <p>Ко-во характеристик: {{ $count_params_bigsales }} шт.</p>
            <p>Ко-во значений: {{ $count_values_bigsales }} шт.</p>
        </div>
        <div class="col-4">
            <a class="text-info" target="_blank" href="{{ asset('admin/api/show/params/bigsales/' . $response_bigsales_subcat->market_subcat_id) }}"><i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i></a>
        </div>
    </div>
@else
    <div class="row">
        <h4 class="w-100 text-center">Категория BigSales</h4>
        <div class="col-12">
           <h5 class="w-100 text-warning">Данные отсутсвуют!</h5>
        </div>
    </div>
@endif
