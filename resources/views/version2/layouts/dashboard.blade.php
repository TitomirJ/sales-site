@section('stylesheets')
    @parent
    <?//Стили для графиков?>
    <?//Chartist?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.0/chartist.min.css">
    <link rel="stylesheet" href="{{ asset('cssv2/components/charts.css') }}">
@endsection

<div class="row">
    <div class="col s12">
        <h3 class="text-c white-text">Сводка</h3>
    </div>
</div>

<div class="row white-text">

    <div class="col s12 m4">
        <div class="block-wrapper hoverable">
            <div class="block-wrapper_content d-f a-i-c j-c-b">
                <div class="d-f a-i-c">
                    <div style="height: 84px; width: 84px;">
                        <div class="ct-chart w100p h100p"></div>
                    </div>
                    <div>
                        <div>Заказы</div>
                        <div>356</div>
                    </div>
                </div>

                <i class="material-icons medium d-i-b d-md-n d-lg-i-b">
                    shopping_cart
                </i>
            </div>
        </div>
    </div>

    <div class="col s12 m4 mt-4 mb-4 mt-md-0 mb-md-0">
        <div class="block-wrapper hoverable">
            <div class="block-wrapper_content d-f a-i-c j-c-b">
                <div class="d-f a-i-c">
                    <div style="height: 84px; width: 84px;">
                        <div class="ct-chart2 w100p h100p"></div>
                    </div>
                    <div>
                        <div>Сумма</div>
                        <div>16543</div>
                    </div>
                </div>
                <i class="material-icons medium d-i-b d-md-n d-lg-i-b">
                    attach_money
                </i>
            </div>
        </div>
    </div>

    <div class="col s12 m4">
        <div class="block-wrapper hoverable">
            <div class="block-wrapper_content d-f a-i-c j-c-b">
                <div class="d-f a-i-c">
                    <div style="height: 84px; width: 84px;">
                        <div class="ct-chart3 w100p h100p"></div>
                    </div>
                    <div>
                        <div>Отказов</div>
                        <div>23</div>
                    </div>
                </div>
                <i class="material-icons medium d-i-b d-md-n d-lg-i-b">
                    cancel
                </i>
            </div>
        </div>
    </div>

</div>

<div class="row">

    <div class="col s12 xl6 mb-4 mb-xl-0">
        <div class="block-wrapper hoverable white-text">

            <div class="block-wrapper_header">
                Маркетплейсы
            </div>
            <div class="block-wrapper_content block-stndrt-h d-f j-c-s">
                <canvas id="myChart"></canvas>
            </div>

        </div>
    </div>

    <div class="col s12 xl6">
        <div class="block-wrapper hoverable white-text">

            <div class="block-wrapper_header">
                Сделки по менеджерам
            </div>
            <div class="block-wrapper_content block-stndrt-h o-y-a">

                <div class="item-deal d-f a-i-c j-c-b">
                    <div>
                        <div>
                            <b class="f16">Адиль Жалелович</b>
                        </div>
                        <div class="f12 pt-2 pb-2">
                            36 сделок
                        </div>
                    </div>
                    <div>Общая сумма: 7182 грн</div>
                </div>
                <div class="divider"></div>

                <div class="item-deal d-f a-i-c j-c-b">
                    <div>
                        <div>
                            <b class="f16">Адиль Жалелович</b>
                        </div>
                        <div class="f12 pt-2 pb-2">
                            36 сделок
                        </div>
                    </div>
                    <div>Общая сумма: 7182 грн</div>
                </div>
                <div class="divider"></div>

                <div class="item-deal d-f a-i-c j-c-b">
                    <div>
                        <div>
                            <b class="f16">Адиль Жалелович</b>
                        </div>
                        <div class="f12 pt-2 pb-2">
                            36 сделок
                        </div>
                    </div>
                    <div>Общая сумма: 7182 грн</div>
                </div>
                <div class="divider"></div>

                <div class="item-deal d-f a-i-c j-c-b">
                    <div>
                        <div>
                            <b class="f16">Адиль Жалелович</b>
                        </div>
                        <div class="f12 pt-2 pb-2">
                            36 сделок
                        </div>
                    </div>
                    <div>Общая сумма: 7182 грн</div>
                </div>
                <div class="divider"></div>

                <div class="item-deal d-f a-i-c j-c-b">
                    <div>
                        <div>
                            <b class="f16">Адиль Жалелович</b>
                        </div>
                        <div class="f12 pt-2 pb-2">
                            36 сделок
                        </div>
                    </div>
                    <div>Общая сумма: 7182 грн</div>
                </div>
                <div class="divider"></div>

                <div class="item-deal d-f a-i-c j-c-b">
                    <div>
                        <div>
                            <b class="f16">Адиль Жалелович</b>
                        </div>
                        <div class="f12 pt-2 pb-2">
                            36 сделок
                        </div>
                    </div>
                    <div>Общая сумма: 7182 грн</div>
                </div>
                <div class="divider"></div>

                <div class="item-deal d-f a-i-c j-c-b">
                    <div>
                        <div>
                            <b class="f16">Адиль Жалелович</b>
                        </div>
                        <div class="f12 pt-2 pb-2">
                            36 сделок
                        </div>
                    </div>
                    <div>Общая сумма: 7182 грн</div>
                </div>
                <div class="divider"></div>

                <div class="item-deal d-f a-i-c j-c-b">
                    <div>
                        <div>
                            <b class="f16">Адиль Жалелович</b>
                        </div>
                        <div class="f12 pt-2 pb-2">
                            36 сделок
                        </div>
                    </div>
                    <div>Общая сумма: 7182 грн</div>
                </div>
                <div class="divider"></div>


            </div>

        </div>
    </div>

</div>

@section('footerjs')
    @parent

    <?//Скрпиты обьявление графиков и настройка?>
    <script src="{{asset('jsv2/components/charts/smallCharts.js')}}"></script>
    <script src="{{asset('jsv2/components/charts/bigChart.js')}}"></script>
@show

