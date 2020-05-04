@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/admin/companies/company.css') }}">
@endsection

@section('content')


<div class="wrap_content bg-light" style="min-height:90vh">
    <div class="title mt-2 p-2">
        <h3 class="text-center">Отчет по авто обновлению компаний</h3>
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="info_content " style="width:100%;height:95%;overflow-y: scroll;">

                {{-- если есть компании у которых выбрано автообновление --}}
                @if(count($companies) > 0)

                {{-- перебор компаний котрые автообновляются --}}
                @foreach($companies as $comp)

                {{-- блок компании --}}
                <div class="block_company_info_update card p-2 mt-1">
                    <p class="p-3 mb-2 bg-info text-white">{{$comp->name}}</p>

                        {{-- есть ли у компании данные в табл. Autoupdates --}}
                        @if(count($comp->autoupdates) > 0)

                            {{-- Ссылка автообновления может быть не одна у компании --}}
                            @foreach($comp->autoupdates as $item)
                    <?php
                    //Данные из табл.Autoupdates-info_update
                    $info_products_update = ($item->info_update !==NULL) ? json_decode($item->info_update) :false;
                    ?>
                    {{-- блок данных по одной ссылке --}}
                        <div class="info_url card p-2">

                            <p>{{$item->url_xml}}</p>

                            @if($info_products_update !== false)

                                <p>Новых товаров: {{$info_products_update[0]->new_product}}</p>
                                <p>Обновленных товаров: {{$info_products_update[0]->update_product}}</p>

                            @endif
                                <p>Дата обновления: {{$item->date_update !==NULL ? $item->date_update :'Нет данных'}}</p>

                                @if($item->error_update != NULL)
                                    <p class="badge badge-danger">Статус ошибки: {{$item->error_update == 2 ? '- нет доступа к файлу':'- Ошибка синтаксического анализа XML'}}</p>
                                @endif
                        </div>
                        {{-- The end блок данных по одной ссылке --}}
                       @endforeach

                    @else
                    <span class="badge badge-danger"> не указана ссылка на xml файл </span>
                    @endif
                </div>
                 {{--End блок компании --}}
                    @endforeach

                @else
                    <p>
                        Нет компаний у которых включен режим автообновления
                    </p>

                @endif
                </div>
            </div>
        </div>
    </div>
</div>



@endsection