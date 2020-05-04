<div class="row white-text">
    <div class="col s12">
        <h5 class="text-u">Товары</h5>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <ul class="block-wrapper tabs hoverable">
            <li class="tab col s3"><a class="active" href="#all">Все товары</a></li>
            <li class="tab col s3"><a href="#no-moderation">Не прошли модерацию</a></li>
            <li class="tab col s3"><a href="#no-available">Нет в наличии</a></li>
            <li class="tab col s3"><a href="#deleted">Удаленные товары</a></li>
        </ul>
    </div>

    {{--Все товары--}}
    <div id="all" class="col s12">
        <div class="block-wrapper block-wrapper_content">
            <!--Таблица с функцией открытия на полный экран-->
            <div id="contentFull">
                <div class="row">

                    <div class="col s12">

                        <div class="d-f a-i-c j-c-b pb-2 f-d-c f-d-md-r">
                            <div class="pl-2 d-f j-c-c f-d-c f-d-sm-r">
                                <a class="waves-effect waves-light btn m-1">добавить</a>
                                <a class="waves-effect waves-light btn m-1">нет в наличии</a>
                                <a class="waves-effect waves-light btn m-1">удалить</a>
                            </div>
                            <div class="d-f a-i-c pr-2">
                                <div class="input-field col s12 white-text" style="width:70px;">
                                    <select>
                                        <option value="" selected>10</option>
                                        <option value="1">100</option>
                                        <option value="2">250</option>
                                        <option value="3">500</option>
                                    </select>
                                </div>
                                <a href="#contentFull" title="Открыть во весь экран" class="btn-floating btn-large waves-effect waves-light red" id="btnFull">
                                    <i class="material-icons">fullscreen</i>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="col s12">
                        <div class="normal-table p-r white-text" style="overflow-x:auto;">
                            <table style="overflow-x: hidden;background: rgba(0, 0, 0, 0.5);">

                                <thead>
                                    <tr>
                                        <th>
                                            <p>
                                                <label>
                                                    <input type="checkbox">
                                                    <span></span>
                                                </label>
                                            </p>
                                        </th>
                                        <th>ФОТО</th>
                                        <th>АРТИКУЛ</th>
                                        <th>НАЗВАНИЕ ТОВАРА</th>
                                        <th>ЦЕНА</th>
                                        <th>В НАЛИЧИИ</th>
                                        <th>СТАТУС</th>
                                        <th>ДЕЙСТВИЕ</th>
                                    </tr>
                                </thead>

                                <tr>
                                    <td>
                                        <p>
                                            <label>
                                                <input type="checkbox" />
                                                <span></span>
                                            </label>
                                        </p>
                                    </td>
                                    <td>
                                        <img class="img-zoom" src="https://smartplus-images.s3.eu-west-3.amazonaws.com/c690a9e81af7b8b8ea982fd742a9bb11172b02e1aJ.jpg" alt="fdgdfg" style="width: 70px;">
                                    </td>

                                    <style>

                                    </style>

                                    <td>42-234</td>
                                    <td>Макака</td>
                                    <td>324324 грн</td>
                                    <td>
                                        <div class="switch">
                                            <label>
                                                <input type="checkbox">
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        Выведен с маркетплеса
                                    </td>
                                    <td>
                                        <?//Дропдаун действия?>
                                        <div class="dropdown-wrap">

                                            <a class='dropdown-btn btn d-f a-i-c j-c-c transparent z-depth-0' href=''>
                                                <i class="fas fa-ellipsis-h c-p icon-bar small" style="z-index: 2"></i>
                                            </a>

                                            <div class='dropdown z-depth-3 b-r-5 grey-text animated fade faster' style="opacity: 0; visibility: hidden">
                                                <a href="#!" class="d-b grey-text text-darken-3 dropdown-text">
                                                    <div>посмотреть</div>
                                                </a>
                                            </div>

                                        </div>
                                        <?//End Дропдаун действия?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <p>
                                            <label>
                                                <input type="checkbox" />
                                                <span></span>
                                            </label>
                                        </p>
                                    </td>
                                    <td>
                                        <img class="img-zoom" src="https://smartplus-images.s3.eu-west-3.amazonaws.com/c690a9e81af7b8b8ea982fd742a9bb11172b02e1aJ.jpg" alt="fdgdfg" style="width: 70px;">
                                    </td>
                                    <td>42-234</td>
                                    <td>Макака</td>
                                    <td>324324 грн</td>
                                    <td>
                                        <div class="switch">
                                            <label>
                                                <input type="checkbox">
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        Выведен с маркетплеса
                                    </td>
                                    <td>
                                        <?//Дропдаун действия?>
                                        <div class="dropdown-wrap">

                                            <a class='dropdown-btn btn d-f a-i-c j-c-c transparent z-depth-0' href=''>
                                                <i class="fas fa-ellipsis-h c-p icon-bar small" style="z-index: 2"></i>
                                            </a>

                                            <div class='dropdown z-depth-3 b-r-5 grey-text animated fade faster' style="opacity: 0; visibility: hidden">
                                                <a href="#!" class="d-b grey-text text-darken-3 dropdown-text">
                                                    <div>посмотреть</div>
                                                </a>

                                            </div>

                                        </div>
                                        <?//End Дропдаун действия?>
                                    </td>
                                </tr>



                            </table>

                            <script>
                                // функция полноэкранного режима таблицы
                                $('#btnFull').on('click', function() {
                                    $('.nav').toggleClass('d-n');
                                    $('.scroll-to-top').toggleClass('d-n');
                                    $('.main').toggleClass('o-h');
                                    $('.main-wrapper').toggleClass('m-0');
                                    $('#contentFull').toggleClass('fullscreen-table');
                                });
                            </script>
                        </div>
                    </div>

                </div>
            </div>
            <!--End Таблица с функцией открытия на полный экран-->
        </div>
    </div>


    {{--Не прошли модерацию--}}
    <div id="no-moderation" class="col s12">
        <div class="block-wrapper block-wrapper_content">Test 2</div>
    </div>
    <div id="no-available" class="col s12">
        <div class="block-wrapper block-wrapper_content">Test 3</div>
    </div>
    <div id="deleted" class="col s12">
        <div class="block-wrapper block-wrapper_content">Test 4</div>
    </div>
</div>


