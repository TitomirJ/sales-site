<?php

    $setting_autoupdate = json_decode($setting_autoupdate);
    $has_product_in_file = $setting_autoupdate[0];
    $not_product_in_file = $setting_autoupdate[1];

    if( ($url_xml = $setting_autoupdate[2]) != ''){
        $url = App\Autoupdate::find($url_xml);
        $url_xml = $url->url_xml;

    }else{

        $url_xml = '' ;
    }



?>
<form action="/company/product/make_setting_autoupdate" method="POST">
    {{ csrf_field() }}

    <div class="wrap_url text-center">
        <div class="row">
            <div class="col col-lg-7 m-auto">
                <div class="form-group">
                    <span>Вставьте в поле ссылку на xml файл:</span>
                <input type="text" class="form-control {{$url_xml ===''? 'font-italic':''}}" id="url_xml" name="url_xml" value="{{$url_xml ===''? 'замените этот текст ссылкой на xml файл':$url_xml}}">
                    <small id="emailHelp" class="form-text text-muted">По этой ссылке система будет автообновлять информацию</small>
                  </div>
            </div>
        </div>

    </div>
    <div class="wrap_main_setting_autoupdate d-flex justify-content-center mt-2">


    {{-- блок для товаров указанных в файле --}}
        <div class="wrap_available_in_file border border-info p-2 mr-2" id="in_file">
            <p>Товары которые есть в файле</p>

            <div class="form-check">
                <input class="form-check-input" type="radio" id="all_autoupdate" name="available_in_file" value="all" {{$has_product_in_file =='all' ? 'checked':''}}>
                <label class="form-check-label {{$has_product_in_file =='all' ? 'badge-warning':''}}" for="all_autoupdate">Обновлять все</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" id="price_autoupdate" name="available_in_file" value="price" {{$has_product_in_file =='price' ? 'checked':''}}>
                <label class="form-check-label {{$has_product_in_file =='price' ? 'badge-warning':''}}" for="price_autoupdate">Только цена</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" id="available_autoupdate" name="available_in_file" value="avai" {{$has_product_in_file =='avai' ? 'checked':''}}>
                <label class="form-check-label {{$has_product_in_file =='avai' ? 'badge-warning':''}}" for="available_autoupdate">Только наличие</label>
            </div>

        </div>
        {{-- end блок для товаров указанных в файле --}}

        {{-- блок для товаров не указанных в файле --}}
        <div class="wrap_notavailable_in_file border border-info p-2" id="not_file">
            <p>Товары которых нет в файле</p>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="not_exit" name="available_not_file" value="no_exit" {{$not_product_in_file =='no_exit' ? 'checked':''}}>
                <label class="form-check-label {{$not_product_in_file =='no_exit' ? 'badge-warning':''}}" for="not_exit">Не выводить из маркета</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="to_exit" name="available_not_file" value="to_exit" {{$not_product_in_file =='to_exit' ? 'checked':''}}>
                <label class="form-check-label {{$not_product_in_file =='to_exit' ? 'badge-warning':''}}" for="to_exit">Выводить из маркета</label>
            </div>
        </div>
         {{-- end блок для товаров не указанных в файле --}}


    </div>

    <div class="wrap_btn_save text-center mt-2">
        <button class="btn btn-info " id="btn-save_setting-autoupdate">Сохранить изменения</button>
    </div>
	<p class="text-danger text-center"><i class="fa fa-2x fa-exclamation-triangle"></i>Обязательно сохраните изменения после вставки ссылки на файл !!!</p>
</form>

<div class="wrap_info_update mt-2">
    <div class="row">
        <div class="col">
            <div class="contents_info">
                @include('provider.company.external.layouts._info_updates_xml')
            </div>
        </div>
    </div>
</div>