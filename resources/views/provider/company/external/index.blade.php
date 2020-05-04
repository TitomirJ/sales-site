@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{asset('/css/pages/externals/externals.css')}}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row mb-4 mt-3">

                <div class="col-12">
                    <div class="shadow-custom p-4 bg-white">
                        Порядок осуществления импорта позиций:

                        <ul class="pt-2">
                            <li>Выбор и загрузка файла или ссылки для импорта</li>
                            <li>Сопоставление полей загруженного файла, если они не совпадают со стандартными полями шаблона файла для импорта (указан в Примерах файлов импорта).</li>
                            <li>Проверка файла на ошибки</li>
                            <li>Импорт позиций</li>
                        </ul>

                        <div>
                            Пример файла для импорта:<u><a href="https://bigsales.pro/company/external/rule" class="pl-3">XML-файл</a></u>
                        </div>
                        <div class="col-12 mt-3">
                            <button class="btn square_btn shadow-custom text-uppercase border-radius-50" id="open-ext-mod" data-url="{{ asset('company/externals/create') }}" data-action="link">добавить ссылку на XML</button>
                            <button class="btn square_btn shadow-custom text-uppercase border-radius-50" id="open-ext-mod" data-url="{{ asset('company/externals/create') }}" data-action="linkxml">Загрузить XML</button>

							{{-- временно в тестовом режиме только для компании Евгений --}}
                            {{-- @if(\Auth::user()->company_id == 59 ) --}}

                            <form action="" method="POST" id="autoupdate_btn">
                            <div class="wrap_btn_auto mt-2 d-flex justify-content-center">

                                {{ csrf_field() }}
                                <div class="block_btn_autoupdate">
                                <label for="autoupdate_xml">Авто обновление XML</label>
                                <input type="checkbox" id="autoupdate_xml" name="autoupdate_xml" autocomplete="off" {{$setting_autoupdate ? 'checked' : ''}}>
                                <span class="badge {{$setting_autoupdate ? 'badge-danger':'badge-success'}}" id="info_btn_autoupdate">{{$setting_autoupdate ? 'Авто обновление включено':'Авто обновление выключено'}}</span>
                                </div>
                            </div>
                        </form>
                        <div class="wrap_setting_autoupdate" id="wrap_setting_autoupdate">
                            @if($setting_autoupdate)
                            @include('provider.company.external.autoupdate_form')
                            @endif
                        </div>

                        {{-- @endif --}}
                         {{--end временно в тестовом режиме только для компании Евгений --}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="p-3 bg-white shadow-custom">

                        <h3 class="mt-2 mb-3">Отчет по импорту</h3>

                        <div class="table-responsive scroll_wrap">
                            <table class="table position-relative scroll_me">

                                <thead>
                                <tr class="tb-head text-uppercase blue-d-t text-center">
                                    <th scope="col" class="h-60">
                                        <div class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap">
                                            Ссылка на XML
                                        </div>
                                    </th>
                                    <th scope="col" class="h-60">
                                        <div class="d-block h-100 p-3 border-top border-bottom border-blue text-nowrap">
                                            Дата и время импорта
                                        </div>
                                    </th>
                                    <th scope="col" class="h-60">
                                        <div class="d-block h-100 p-3 border-top border-bottom border-blue text-nowrap radius-top-right border-right">
                                            Состояние товаров
                                        </div>
                                    </th>
                                </tr>
                                </thead>

                                <tbody class="table-bg">

                                @forelse($company->externals as $external)

                                    <tr class="bor-bottom">
                                        <td scope="col" class="text-center align-middle bor-bottom">
                                            <div>
                                                <a href="{{$external->unload_url}}">Ссылка №{{ $external->id }}</a>
                                            </div>
                                        </td>

                                        <td scope="col" class="text-center align-middle bor-bottom">
                                            <div>
                                                {{$external->created_at}}
                                            </div>
                                        </td>

                                        <? $array_info_products = $external->countInfoArrayProducts(); ?>

                                        <td scope="col" class="text-center align-middle bor-bottom">
                                            @if($external->is_unload == '1' || $external->is_unload == '2')
                                                <div class="position-relative">
                                                    <span class="text-secondary">{{ $array_info_products['new'] }}</span> -
                                                    <span class="text-info">{{ $array_info_products['link'] }}</span> -
                                                    <span class="text-primary">{{ $array_info_products['checked'] }}</span> -
                                                    <span class="text-success">{{ $array_info_products['created'] }}</span> -
                                                    <span class="text-danger">{{  $array_info_products['error'] }}</span>
                                                </div>
                                            @elseif($external->is_unload == '0')
                                                <span class="badge badge-pill badge-info">XML на проверке</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bor-bottom">
                                        <td colspan="3" class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="mr-4">
                                                    Нет ссылок
                                                </div>

                                                <i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse


                                </tbody>

                            </table>
                        </div>

                    </div>

                </div>








            </div>

        </div>
    </div>

@include('provider.company.external.layouts.modals')
@endsection

@section('script2')
    <script src="{{ asset('js/pages/provider/external/ext_index.js') }}"></script>
    <script>
        $( "span.text-secondary" ).hover(function() {
                $( this ).append( $( "<div class='position-absolute bg-white border-radius p-3 msg-top border'>необработаные</div>" ) );
            }, function() {
                $( this ).find( "div:last" ).remove();
            }
        );

        $( "span.text-info" ).hover(function() {
                $( this ).append( $( "<div class='position-absolute bg-white border-radius p-3 msg-top border'>ждут проверки</div>" ) );
            }, function() {
                $( this ).find( "div:last" ).remove();
            }
        );

        $( "span.text-primary" ).hover(function() {
                $( this ).append( $( "<div class='position-absolute bg-white border-radius p-3 msg-top border'>провереные</div>" ) );
            }, function() {
                $( this ).find( "div:last" ).remove();
            }
        );

        $( "span.text-success" ).hover(function() {
                $( this ).append( $( "<div class='position-absolute bg-white border-radius p-3 msg-top border'>созданы</div>" ) );
            }, function() {
                $( this ).find( "div:last" ).remove();
            }
        );

        $( "span.text-danger" ).hover(function() {
                $( this ).append( $( "<div class='position-absolute bg-white border-radius p-3 msg-top border'>ошибки</div>" ) );
            }, function() {
                $( this ).find( "div:last" ).remove();
            }
        );
    </script>
@endsection