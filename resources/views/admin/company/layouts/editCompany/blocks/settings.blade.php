<form class="form-horizontal" method="POST" action="{{ asset('admin/company/'.$company->id.'/update') }}" id="setting-company-form">
    {{ csrf_field() }}
    <input type="hidden" name="action" value="settings">
</form>
<div class="row bg-light border-radius border-2 border-blue">
    <div class="col-md-5">
        <div class="form-group mt-3">
            <label for="limit">Редактирование лимита компании (грн.)</label>
            <input type="number" step="any" min="0" class="form-control" name="balance_limit" value="{{ $company->balance_limit }}" form="setting-company-form">
        </div>

        <div class="form-group mt-3">
            <label for="name">Редактирование даты окончания абонплаты</label>
            <input type="text" class="dpk-ab-company form-control" name="ab_to" value="{{ $company->ab_to }}" form="setting-company-form">
        </div>

        <p class="mt-5 ml-2">Настройка отправки товаров на маркетплейсы</p>
        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label class="switch d-block">
                        <input type="checkbox" name="rozetka_on" class="form-control" {{ ($company->rozetka_on == "1")? 'checked': '' }} form="setting-company-form">
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="col-10 p-2">
                    <span class="mt-2">Отправка товаров на Розетку</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label class="switch d-block">
                        <input type="checkbox" name="prom_on" class="form-control" {{ ($company->prom_on == "1")? 'checked': '' }} form="setting-company-form">
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="col-10 p-2">
                    <span class="mt-2">Отправка товаров на Пром</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label class="switch d-block">
                        <input type="checkbox" name="zakupka_on" class="form-control" {{ ($company->zakupka_on == "1")? 'checked': '' }} form="setting-company-form">
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="col-10 p-2">
                    <span class="mt-2">Отправка товаров на Закупку</span>
                </div>
            </div>
        </div>
		
		{{-- временная мера в ручном режиме добавление новой площадки --}}
       
        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label class="switch d-block">
                        <input type="checkbox" name="fua_on" class="form-control" {{ ($company->fua_on == "1")? 'checked': '' }} form="setting-company-form">
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="col-10 p-2">
                    <span class="mt-2">Отправка товаров на F.ua</span>
                </div>
            </div>
        </div>
        
        {{-- окончание временная мера в ручном режиме добавление новой площадки --}}
		
        <div class="form-group">

        </div>

    </div>
    <div class="col-md-2">

    </div>
    <?
        $products = $company->products;
        $count_products = $products->count();
        $count_to_market = 0;
        $count_to_no_market = 0;
        $count_to_moderation = 0;
        $count_arter_moderation = 0;
        $count_back_to_company = 0;;
        $count_avail = 0;
        $count_not_avail = 0;

        foreach ($products as $product){
            if($product->status_spacial == '1'){
                $count_to_market++;
            }else{
                $count_to_no_market++;
            }

            if($product->status_moderation == '0'){
                $count_to_moderation++;
            }elseif($product->status_moderation == '1'){
                $count_arter_moderation++;
            }elseif($product->status_moderation == '2'){
                $count_back_to_company++;
            }

            if($product->status_available == '1'){
                $count_avail++;
            }else{
                $count_not_avail++;
            }
        }

    ?>
    <div class="col-md-5">
        <div class="form-group mt-3">
            <label for="name">Принудительная отправка товаров на маркетплейсоы</label>
            <form action="{{ asset('admin/company/'.$company->id.'/products/move-marketplace') }}" method="POST" id="move-products-to-market-form">
                {{ csrf_field() }}
                <input type="hidden" name="action" value="move">
                <button type="submit" class="btn btn-success shadow-custom text-uppercase confirm-com-settings" form="move-products-to-market-form">Принудительно отправить</button>
            </form>
        </div>

        <div class="form-group mt-3">
            <label for="name">Принудительный вывод товаров с маркетплейсов</label>
            <form action="{{ asset('admin/company/'.$company->id.'/products/move-marketplace') }}" method="POST" id="out-products-from-market-form">
                {{ csrf_field() }}
                <input type="hidden" name="action" value="out">
                <button type="submit" class="btn btn-danger shadow-custom text-uppercase confirm-com-settings" form="out-products-from-market-form">Принудительно вывести</button>
            </form>
        </div>
        <h4 class="w-100 text-center">Сводка по товарам</h4>
        <div class="row">
            <div class="col-12">
                <p>Всего товаров: {{ $count_products }} шт.</p>
                <p>Товаров на маркетплейсах: {{ $count_to_market }} шт.</p>
                <p>Товаров не на маркетплейсах: {{ $count_to_no_market }} шт.</p>
                <p>Товаров на модерации: {{ $count_to_moderation }} шт.</p>
                <p>Товаров прошли модерацию: {{ $count_arter_moderation }} шт.</p>
                <p>Товаров возвращено компании: {{ $count_back_to_company }} шт.</p>
                <p>Товаров в наличии: {{ $count_avail }} шт.</p>
                <p>Товаров не в наличии: {{ $count_not_avail }} шт.</p>
            </div>
        </div>
    </div>


</div>
<button id="settings-company-submit-btn" class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" type="submit" form="setting-company-form">Сохранить</button>
<script>
    (function($, undefined){
        $(function(){

            var dataTimeNow = new Date();
            var datapickerAbCompany = $('.dpk-ab-company').datepicker({
                toggleSelected: false,
                minDate: dataTimeNow,
                dateFormat: 'yyyy-mm-dd 23:59:59',
                onSelect: function(formattedDate, date, inst){
                    datapickerAbCompany.blur();
                }
            });

        });
    })(jQuery);
</script>