<div class="row white-text">
    <div class="col s12">
        <h5 class="text-u">Кабинет компании</h5>
    </div>
</div>

<div class="row white-text">
    <div class="col s12">

        <div class="block-wrapper block-wrapper_content hoverable">

            <div class="row">
                <div class="col s12">
                    <h5>Основная информация</h5>
                </div>

                <div class="col s12 mb-3"><div class="divider"></div></div>

                <div class="col s12 m6">
                    <div class="row mb-0">
                        <div class="col s12 input-field">
                            <input id="company_name" type="text" class="validate white-text">
                            <label for="company_name" class="">Название</label>
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col s12 input-field">
                            <input id="link" type="text" class="validate white-text">
                            <label for="link" class="">Ссылка</label>
                        </div>
                    </div>
                </div>

                <div class="col s12 m6">
                    <div class="row mb-0">
                        <div class="col s12 input-field">
                            <input id="responsible" type="email" class="validate white-text">
                            <label for="responsible" class="">Ответственный за прием заказов</label>
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col s12 input-field">
                            <input id="responsible_phone" type="tel" class="validate white-text">
                            <label for="responsible_phone" class="">Номер телефона ответственного</label>
                        </div>
                    </div>
                </div>

                <div class="col s12 m6 input-field">
                    <textarea rows='1' id="textarea1" class="textarea materialize-textarea white-text"></textarea>
                    <label for="textarea1" class="active">Информация о компании</label>
                </div>

                <div class="col s12 m6 input-field">
                    <textarea id="textarea2" class="textarea materialize-textarea white-text"></textarea>
                    <label for="textarea2" class="active">Информация о компании</label>
                </div>

                <script>
                    //для внесения нового контента для textarea
                    //$('#textarea1').val('New Text');

                    // авторесайз textarea
                    var textarea = document.querySelector('textarea');

                    textarea.addEventListener('keydown', autosize);

                    function autosize(){
                        var el = this;
                        setTimeout(function(){
                            el.style.cssText = 'height:auto; padding:0';
                            // for box-sizing other than "content-box" use:
                            // el.style.cssText = '-moz-box-sizing:content-box';
                            el.style.cssText = 'height:' + el.scrollHeight + 'px';
                        },0);
                    }
                </script>

            </div>
        </div>

    </div>
</div>

