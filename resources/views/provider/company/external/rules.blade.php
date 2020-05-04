@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link href="{{ asset('css/pages/requirements/requirements.css') }}" rel="stylesheet">
@endsection

@section('navbar')
@show

@section('content')

        <div class="container-fluid decoration-clip">

            <div>
                <div>
                    <div>
                        <div>
                            <h1>Требования к XML-файлу</h1>
                        </div>
                        <div>
                            <div>
                                <p>Для выставления товаров на Rozetka.ua продавцу необходимо подготовить прайс с
                                    предложениями в формате XML. В процессе работы магазина адрес ссылки xml должен быть
                                    статичным и не меняться.</p>
                                <h3>Требования к XML-файлу</h3>
                                <ul>
                                    <li>Стандарт XML не допускает использования непечатаемых символов с ASCII-кодами от
                                        0 до 31 (за исключением символов с кодами 9, 10, 13 — табуляция, перевод строки,
                                        возврат каретки).
                                    </li>
                                    <li>
                                        Символы ", &amp;, &gt;, &lt;, ' нужно заменять на эквивалентные коды:
                                        <div class="mt-3 mb-3">
                                            <table>
                                                <tbody class="table-blr table-1 shadow-custom">
                                                <tr class="tr-bt">
                                                    <th>Символ в тексте</th>
                                                    <th>Код для XML-файла</th>
                                                </tr>
                                                <tr class="tr-bt">
                                                    <td class="rz-td-first">"</td>
                                                    <td class="rz-td-second">&amp;quot;</td>
                                                </tr>
                                                <tr class="tr-bt">
                                                    <td class="rz-td-first">&amp;</td>
                                                    <td class="rz-td-second">&amp;amp;</td>
                                                </tr>
                                                <tr class="tr-bt">
                                                    <td class="rz-td-first">&gt;</td>
                                                    <td class="rz-td-second">&amp;gt;</td>
                                                </tr>
                                                <tr class="tr-bt">
                                                    <td class="rz-td-first">&lt;</td>
                                                    <td class="rz-td-second">&amp;lt;</td>
                                                </tr>
                                                <tr class="tr-bb tr-bt">
                                                    <td class="rz-td-first">'</td>
                                                    <td class="rz-td-second">&amp;apos;</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </li>
                                    <li>URL-адрес товарного предложения на сайте магазина должен быть закодирован в
                                        соответствии со стандартом
                                    </li>
                                    <li>Допустимая кодировка XML-файла: UTF-8.</li>
                                </ul>
                                <p><strong>Пример XML-файла</strong></p>
                                <div class="example-code p-4 shadow-custom">
                                    <code>
                                        <div class="string pdn-1">&lt;?xml version="1.0" encoding="UTF-8"?&gt;</div>
                                        <div class="string pdn-2">&lt;!DOCTYPE yml_catalog SYSTEM "shops.dtd"&gt;</div>
                                        <div class="string pdn-3">&lt;yml_catalog date="2018-10-18 15:31"&gt;</div>
                                        <div class="string pdn-3">&lt;shop&gt;</div>
                                        <div class="string pdn-4">&lt;name&gt;Smart Plus&lt;/name&gt;</div>
                                        <div class="string pdn-4">&lt;company&gt;Smart Plus&lt;/company&gt;</div>
                                        <div class="string pdn-4">&lt;url&gt;https://smartplusnet.prom.ua/&lt;/url&gt;
                                        </div>
                                        <div class="string pdn-4">&lt;currencies&gt;</div>
                                        <div class="string pdn-5">&lt;currency id="USD" rate="CB"/&gt;</div>
                                        <div class="string pdn-5">&lt;currency id="RUR" rate="CB"/&gt;</div>
                                        <div class="string pdn-5">&lt;currency id="UAH" rate="1"/&gt;</div>
                                        <div class="string pdn-5">&lt;currency id="BYN" rate="CB"/&gt;</div>
                                        <div class="string pdn-5">&lt;currency id="KZT" rate="CB"/&gt;</div>
                                        <div class="string pdn-5">&lt;currency id="EUR" rate="CB"/&gt;</div>
                                        <div class="string pdn-4">&lt;/currencies&gt;</div>
                                        <div class="string pdn-4">&lt;categories&gt;</div>
                                        <div class="string pdn-5">&lt;category id="40705778"&gt;IP-камеры&lt;/category&gt;</div>
                                        <div class="string pdn-4">&lt;/categories&gt;</div>
                                        <div class="string pdn-4">&lt;offers&gt;</div>
                                        <div class="string pdn-5">&lt;offer available="true" id="785371554"&gt;</div>
                                        <div class="string pdn-6">&lt;price&gt;2935&lt;/price&gt;</div>
                                        <div class="string pdn-6">&lt;currencyId&gt;UAH&lt;/currencyId&gt;</div>
                                        <div class="string pdn-6">&lt;categoryId&gt;40705778&lt;/categoryId&gt;</div>
                                        <div class="string pdn-6">&lt;picture&gt;https://images.ua.prom.st/1342570007_w640_h640_cid2837156_pid785371554-10558d5d.jpg&lt;/picture&gt;</div>
                                        <div class="string pdn-6">&lt;picture&gt;https://images.ua.prom.st/1342570008_w640_h640_cid2837156_pid785371554-4d3c03d3.jpg&lt;/picture&gt;</div>
                                        <div class="string pdn-6">&lt;picture&gt;https://images.ua.prom.st/1342570009_w640_h640_cid2837156_pid785371554-5010fcbf.jpg&lt;/picture&gt;</div>
                                        <div class="string pdn-6">&lt;picture&gt;https://images.ua.prom.st/1342570010_w640_h640_cid2837156_pid785371554-1ab3d275.jpg&lt;/picture&gt;</div>
                                        <div class="string pdn-6">&lt;picture&gt;https://images.ua.prom.st/1342570011_w640_h640_cid2837156_pid785371554-deff0c17.jpg&lt;/picture&gt;</div>
                                        <div class="string pdn-6">&lt;picture&gt;https://images.ua.prom.st/1342570012_w640_h640_cid2837156_pid785371554-51863beb.jpg&lt;/picture&gt;</div>

                                        <div class="string pdn-6">&lt;name&gt;Внутренняя IP камера Hikvision
                                            DS-2CD2422FWD-IW (2.8) (6421)&lt;/name&gt;
                                        </div>

                                        <div class="string pdn-6">&lt;vendor&gt;Hikvision&lt;/vendor&gt;</div>
                                        <div class="string pdn-6">&lt;vendorCode&gt;6421&lt;/vendorCode&gt;</div>
                                        <div class="string pdn-6">&lt;description&gt;Принцип действия

                                            IP видеокамера Hikvision - это компактная сетевая камера, предназначенная
                                            для видеонаблюдения в режиме реального времени на любых объектах. Камера
                                            подключается к беспроводной Wi-Fi-сети и позволяет вести видеонаблюдение в
                                            разрешении Full HD (1920 x 1080), с оптимальной цветопередачей и резкостью.

                                            Устройство приспособлено к работе в условиях слабой освещенности или полной
                                            темноте благодаря наличию ИК-подсветки, дальностью до 10 м. Оснащено
                                            2-мегапиксельным объективом с фокусным расстоянием 2.8 мм и углом обзора
                                            115°. Осуществляет двустороннюю аудио связь через встроенный микрофон и
                                            динамик. Имеет тревожный вход и выход. Камера работает при температуре -10°C
                                            ~ +60°C. Питается от блока питания DC 12В, по технологии PoE и с
                                            максимальной потребляемой мощностью - 5 Вт.&lt;/description&gt;
                                        </div>
                                        <div class="string pdn-6">&lt;param name="Тип матрицы"&gt;Progressive Scan CMOS&lt;/param&gt;</div>
                                        <div class="string pdn-6">&lt;param name="Разрешение"&gt;2&lt;/param&gt;</div>
                                        <div class="string pdn-6">&lt;param name="Ночная съемка"&gt;До 10 м&lt;/param&gt;</div>
                                        <div class="string pdn-6">&lt;param name="Гарантия"&gt;12
                                            месяцев&lt;/param&gt;
                                        </div>
                                        <div class="string pdn-6">&lt;param name="Вес"&gt;400 г&lt;/param&gt;</div>
                                        <div class="string pdn-6">&lt;param name="Размеры"&gt;72 x 92 x 131 мм&lt;/param&gt;</div>
                                        <div class="string pdn-6">&lt;param name="Рабочая влажность"&gt;не более 90%&lt;/param&gt;</div>
                                        <div class="string pdn-6">&lt;param name="Диапазон рабочих температур"&gt;-10°C
                                            ~ +60°C&lt;/param&gt;
                                        </div>
                                        <div class="string pdn-6">&lt;param name="Потребление тока с подсветкой/без"&gt;макс.
                                            5 Вт&lt;/param&gt;
                                        </div>
                                        <div class="string pdn-6">&lt;param name="Рабочее напряжение"&gt;DC 12В, PoE
                                            (802.3af)&lt;/param&gt;
                                        </div>
                                        <div class="string pdn-5">&lt;/offer&gt;</div>
                                        <div class="string pdn-4">&lt;/offers&gt;</div>
                                        <div class="string pdn-3">&lt;/shop&gt;</div>
                                        <div class="string pdn-3">&lt;/yml_catalog&gt;</div>
                                    </code>
                                </div>
                            </div>
                            <div class="mt-5">
                                <h3>Описание элементов</h3>
                                <table class="table table-responsive decription-table table-blr shadow-custom">
                                    <tbody>
                                    <tr class="tr-bt">
                                        <th>Элемент</th>
                                        <th>Описание</th>
                                    </tr>
                                    <tr class="tr-bt">
                                        <td class="rz-td-first name"><b>yml_catalog</b></td>
                                        <td class="rz-td-second">
                                            Любой XML-документ может содержать только один корневой элемент. Формат YML
                                            в качестве корневого использует элемент &lt;yml_catalog&gt;. Атрибут date
                                            элемента &lt;yml_catalog&gt; должен соответствовать дате и времени генерации
                                            YML-файла на стороне магазина. Дата должна иметь формат YYYY-MM-DD hh:mm.
                                        </td>
                                    </tr>
                                    <tr class="tr-bt">
                                        <td class="rz-td-first name"><b>shop</b></td>
                                        <td class="rz-td-second">
                                            Элемент содержит описание магазина и его товарных предложений. <br>
                                            Обязательный элемент.
                                        </td>
                                    </tr>
                                    <tr class="tr-bt">
                                        <td class="rz-td-first name"><b>name</b></td>
                                        <td class="rz-td-second">
                                            Короткое название магазина. Должно содержать не более 20 символов. В
                                            названии нельзя использовать слова, не имеющие отношения к наименованию
                                            магазина (например: «лучший», «дешевый»), указывать номер телефона и т. п.
                                            <br>
                                            Название магазина должно совпадать с фактическим названием магазина, которое
                                            публикуется на сайте.<br>
                                            Обязательный элемент.
                                        </td>
                                    </tr>
                                    <tr class="tr-bt">
                                        <td class="rz-td-first name"><b>company</b></td>
                                        <td class="rz-td-second">
                                            Полное наименование компании, владеющей магазином. Не публикуется,
                                            используется для внутренней идентификации.<br>
                                            Обязательный элемент.
                                        </td>
                                    </tr>
                                    <tr class="tr-bt">
                                        <td class="rz-td-first name"><b>url</b></td>
                                        <td class="rz-td-second">URL главной страницы магазина.<br>
                                            Обязательный элемент. Заполнение не обязательно.
                                        </td>
                                    </tr>
                                    <tr class="tr-bt">
                                        <td class="rz-td-first name"><b>currencies</b></td>
                                        <td class="rz-td-second">
                                            Список курсов валют магазина.<br>Основная валюта – гривна, присваивается
                                            единица.<br><br>
                                            <i> &lt;currency id="UAH" rate="1"/&gt;</i> <br><br>Только у гривны
                                            rate="1". Другие валюты на сайт не выводятся и главное, чтоб у них rate не
                                            был единицей. <br>
                                            Обязательный элемент.

                                        </td>
                                    </tr>
                                    <tr class="tr-bt">
                                        <td class="rz-td-first name"><b>categories</b></td>
                                        <td class="rz-td-second">
                                            Список категорий. Каждой категории должен присваиваться уникальный
                                            номер, нумерация – на усмотрение магазина. В одной категории магазина не должно быть товаров
                                            из двух разных категорий на нашем сайте. <br>
                                            Обязательный элемент.
                                        </td>
                                    </tr>
                                    <tr class="tr-bt tr-bb">
                                        <td class="rz-td-first name"><b>offers</b></td>
                                        <td class="rz-td-second">
                                            Список товаров магазина. Каждый товар описывается в отдельном элементе
                                            offer. Каждый товар должен иметь уникальный идентификатор.<br><br>
                                            <div class="string pdn-1">
                                                <i> &lt;offer available="true" id="74279"&gt;<br>
                                                    available="true" </i>– наличие товара: true – товар в наличии; false
                                                – товар не в наличии.<br><br>
                                                <i> id="74279" </i>– уникальный идентификатор товара. В его роли может
                                                быть артикул. Только числовое значение.<br><br>
                                            </div>
                                            <div class="string pdn-1"><i>&lt;price&gt;2935&lt;/price&gt; </i>- цена
                                                товара
                                            </div><br>
                                            <div class="string pdn-1"><i> &lt;currencyId&gt;UAH&lt;/currencyId&gt; </i>
                                                - валюта товара
                                            </div><br>
                                            <div class="string pdn-1"><i>&lt;categoryId&gt;40705778&lt;/categoryId&gt; </i>-
                                                категория товара
                                            </div><br>
                                            <div class="string pdn-1"><i>&lt;picture&gt;https://images.ua.prom.st/1342570007_w640_h640_cid2837156_pid785371554-10558d5d.jpg&lt;/picture&gt; </i>-
                                                ссылка на фото товара.<br> Важно предоставить публичный доступ к фото. Обязательно добавить от 3-ех до 8-ми фото.
                                                Первая фотография в выгрузке xml будет основной в карточке товара.
                                                <a href="https://bigsales.pro/company/product/rules">Требования
                                                    и рекомендации к фотографиям товара</a>.
                                            </div>
                                            <br>
                                            Пример оформления в прайсе:<br><br>
                                            <i>
                                                <div class="string pdn-1">&lt;picture&gt;https://images.ua.prom.st/1342570007_w640_h640_cid2837156_pid785371554-10558d5d.jpg&lt;/picture&gt;</div>
                                                <div class="string pdn-1">&lt;picture&gt;https://images.ua.prom.st/1342570008_w640_h640_cid2837156_pid785371554-4d3c03d3.jpg&lt;/picture&gt;</div>
                                                <div class="string pdn-1"> &lt;picture&gt;https://images.ua.prom.st/1342570009_w640_h640_cid2837156_pid785371554-5010fcbf.jpg&lt;/picture&gt;</div>
                                            </i>
                                            <br>
                                            <br>
                                            <div class="string pdn-1"><i>&lt;name&gt;Внутренняя IP камера Hikvision DS-2CD2422FWD-IW&lt;/name&gt; </i>- название товара. Не
                                                должно содержать разделительных знаков (запятые, точки, тире, дефисы),
                                                кроме относящихся к наименованию модели. Не надо писать слова в названии
                                                капсом. Названия должны быть уникальными и не повторяться. Обязательно
                                                проверьте, что производитель(бренд) был указан в названии.
                                            </div><br>

                                            <div class="string pdn-1"><i>&lt;vendor&gt;Hikvision&lt;/vendor&gt; </i>-
                                                бренд-производитель товара.<br> Должен указываться так, как прописано
                                                производителем и как бренд зарегистрирован документально. При наличии
                                                созданного бренда на Розетке в прайсе указывается аналогичное
                                                наименование. В этом теге и в названии товара производитель должен
                                                прописываться одинаково. Не следует указывать производителя капсом. Не
                                                надо добавлять к названию производителя: торговая марка, ТМ, ЛТД, ООО,
                                                ФОП, ТОВ и т. п.
                                            </div><br>

                                            <div class="string pdn-1"><i>&lt;vendorCode&gt;6421&lt;/vendorCode&gt; </i>-
                                                Артикул. Обязательно к заполнению.
                                            </div><br>

                                            <div class="string pdn-1"><i>&lt;description&gt; </i>- описание товара.
                                                Описание товара может быть однотипным для всей категории. В описании
                                                должна присутствовать информация только про сам товар. Описание не
                                                должно содержать ссылок, телефонов, адресов, предложений услуг, акций,
                                                цен, картинок, видеообзоров и т.д.<br><br>
                                                Пример:<br><br>
                                                <i>
                                                    <div class="string pdn-1">&lt;description&gt;</div>
                                                    <div class="string pdn-2">
                                                        Принцип действия IP видеокамера Hikvision - это компактная сетевая камера, предназначенная для видеонаблюдения в режиме реального времени на любых объектах. Камера подключается к беспроводной Wi-Fi-сети и позволяет вести видеонаблюдение в разрешении Full HD (1920 x 1080), с оптимальной цветопередачей и резкостью. Устройство приспособлено к работе в условиях слабой освещенности или полной темноте благодаря наличию ИК-подсветки, дальностью до 10 м. Оснащено 2-мегапиксельным объективом с фокусным расстоянием 2.8 мм и углом обзора 115°. Осуществляет двустороннюю аудио связь через встроенный микрофон и динамик. Имеет тревожный вход и выход. Камера работает при температуре -10°C ~ +60°C. Питается от блока питания DC 12В, по технологии PoE и с максимальной потребляемой мощностью - 5 Вт.
                                                    </div>
                                                    <div class="string pdn-1">&lt;/description&gt;</div>
                                                </i></div>
                                            <br><br>
                                            <i>
                                                <div class="string pdn-1">&lt;param
                                                    name="Цвет"&gt;Черный&lt;/param&gt;
                                                </div>
                                                <div class="string pdn-1"> &lt;param
                                                    name="Вид"&gt;Куртка&lt;/param&gt;
                                                </div>
                                            </i>
                                                <div class="string pdn-1"><i> &lt;param name="Категория"&gt;Мужская&lt;/param&gt;</i>
                                                - параметры товара.
                                                </div>

                                            <div class="string pdn-1"><i></i>
                                                <br>
                                                <div class="string pdn-1"><i>&lt;param name="название параметра"&gt;Значение&lt;/param&gt;</i>
                                                </div>
                                                <br>
                                            </div>
                                            <br>
                                            <div class="string pdn-1">
                                                Все элементы обязательны
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


@endsection

@section('footer')
@show