<div class="row">
    <div class="col s12">
        <h3 class="text-c">Компоненты</h3>
    </div>
</div>

{{--Buttons--}}
<div class="row">
    <div class="col s12 text-u pb-3 mt-5">
        <b>Buttons</b>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <div class="block-wrapper hoverable">
            <div class="block-wrapper_content">
                <a class="waves-effect waves-light btn">button</a>
                <a class="waves-effect waves-light btn"><i class="material-icons left">cloud</i>button</a>
                <a class="waves-effect waves-light btn"><i class="material-icons right">cloud</i>button</a>

                <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
                </button>

                <a class="waves-effect waves-light btn-large">Button</a>

                <a class="btn-large disabled">Button</a>

                <a class="waves-effect waves-light btn-small">Button</a>

                <a class="waves-effect waves-teal btn-flat">Button</a>

                <a class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
            </div>
        </div>
    </div>
</div>
{{--End Buttons--}}

<div class="divider mt-5 mb-5"></div>

{{--Tabs--}}
<div class="row">
    <div class="col s12 text-u pb-3 mt-5">
        <b>Tabs</b>
    </div>
</div>


<div class="row">
    <div class="col s12">
        <ul class="block-wrapper tabs hoverable">
            <li class="tab col s3"><a class="active" href="#test1">Tab 1</a></li>
            <li class="tab col s3"><a href="#test2">Tab 2</a></li>
            <li class="tab col s3"><a href="#test3">Tab 3</a></li>
            <li class="tab col s3"><a href="#test4">Tab 4</a></li>
        </ul>
    </div>
    <div id="test1" class="col s12">
        <div class="block-wrapper block-wrapper_content">Test 1</div>
    </div>
    <div id="test2" class="col s12">
        <div class="block-wrapper block-wrapper_content">Test 2</div>
    </div>
    <div id="test3" class="col s12">
        <div class="block-wrapper block-wrapper_content">Test 3</div>
    </div>
    <div id="test4" class="col s12">
        <div class="block-wrapper block-wrapper_content">Test 4</div>
    </div>
</div>
{{--End Tabs--}}

{{--Table--}}
<div class="row">
    <div class="col s12 text-u pb-3 mt-5">
        <b>Tables</b>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <div class="block-wrapper hoverable">
            <div class="block-wrapper_content p-r sm-table">
                {{--Loader--}}
                <a class="btn-floating btn-large waves-effect waves-light red open-loader"><i class="material-icons">add</i></a>
                <div class="preloader-wrap p-a w100p h100p" style="display: none;">
                    <div class="p-r h100p">
                        <div class="loader">
                            <div class="circles"></div>
                        </div>
                        <div class="loader-circle"></div>
                    </div>
                </div>
                {{--End Loader--}}

                <table>

                    <caption>Адаптивная Таблица</caption>
                    <thead>
                    <tr>
                        <th scope="col">Account</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Period</th>
                        <th scope="col">Count</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Count</th>
                        <th scope="col">Comment</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td data-label="Account">Visa - 3412</td>
                        <td data-label="Due Date">04/01/2016</td>
                        <td data-label="Amount">$1,190</td>
                        <td data-label="Period">03/01/2016 - 03/31/2016</td>
                        <td data-label="Amount">$1,190</td>
                        <td data-label="Period">03/01/2016 - 03/31/2016</td>
                        <td data-label="Amount">$1,190</td>
                        <td data-label="Period">03/01/2016 - 03/31/2016</td>
                    </tr>
                    <tr>
                        <td scope="row" data-label="Account">Visa - 6076</td>
                        <td data-label="Due Date">03/01/2016</td>
                        <td data-label="Amount">$2,443</td>
                        <td data-label="Period">02/01/2016 - 02/29/2016</td>
                        <td data-label="Amount">$2,443</td>
                        <td data-label="Period">02/01/2016 - 02/29/2016</td>
                        <td data-label="Amount">$2,443</td>
                        <td data-label="Period">02/01/2016 - 02/29/2016</td>
                    </tr>
                    <tr>
                        <td scope="row" data-label="Account">Corporate AMEX</td>
                        <td data-label="Due Date">03/01/2016</td>
                        <td data-label="Amount">$1,181</td>
                        <td data-label="Period">02/01/2016 - 02/29/2016</td>
                        <td data-label="Amount">$1,181</td>
                        <td data-label="Period">02/01/2016 - 02/29/2016</td>
                        <td data-label="Amount">$1,181</td>
                        <td data-label="Period">02/01/2016 - 02/29/2016</td>
                    </tr>
                    <tr>
                        <td scope="row" data-label="Acount">Visa - 3412</td>
                        <td data-label="Due Date">02/01/2016</td>
                        <td data-label="Amount">$842</td>
                        <td data-label="Period">01/01/2016 - 01/31/2016</td>
                        <td data-label="Amount">$842</td>
                        <td data-label="Period">01/01/2016 - 01/31/2016</td>
                        <td data-label="Amount">$842</td>
                        <td data-label="Period">01/01/2016 - 01/31/2016</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{--End Tables--}}


<div class="divider mt-5 mb-5"></div>



<div class="divider mt-5 mb-5"></div>

{{--Toasts--}}
<div class="row">
    <div class="col s12 text-u pb-3">
        <b>Toasts</b>
    </div>
</div>

<div class="col s12">
    <a onclick="M.toast({html: 'Информатсия для юзЭров', classes: 'rounded blue lighten-1'})" class="btn blue lighten-1">Информатсия</a>

    <a onclick="M.toast({html: 'Все гуд, все класс!', classes: 'rounded green'})" class="btn green">Гы</a>

    <a onclick="M.toast({html: 'Что-то идет не так..', classes: 'rounded yellow darken-2'})" class="btn yellow darken-2">Га</a>

    <a onclick="M.toast({html: 'Все п**дец, делаем ноги', classes: 'rounded red accent-2'})" class="btn red accent-2">Ги</a>
</div>
{{--End Toasts--}}

<div class="divider mt-5 mb-5"></div>

{{--Modal--}}
<div class="row">
    <div class="col s12 text-u pb-3">
        <b>Modal</b>
    </div>
</div>


<div class="col s12">

    <!-- Modal Trigger -->
    <a class="waves-effect waves-light btn modal-trigger" href="#modal1" onclick="return false">Modal</a>

    <!-- Modal Structure -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Modal Header</h4>
            <p>A bunch of text</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Disagree</a>
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
        </div>
    </div>

</div>
{{--End Modal--}}


<div class="divider mt-5 mb-5"></div>

{{-- Input with icon color change animation --}}
<div class="row">
    <div class="col s12 text-u pb-3 mt-5">
        <b>inputs with animate Icon</b>
    </div>
</div>

<form class="col s12">
    <div class="row">
        <div class="input-field col s6">
            <i class="material-icons prefix">mode_edit</i>
            <textarea id="icon_prefix2" class="materialize-textarea"></textarea>
            <label for="icon_prefix2">First Name</label>
        </div>
    </div>
</form>
{{--End Input with icon color change animation --}}

<div class="divider mt-5 mb-5"></div>


<div class="divider mt-5 mb-5"></div>

{{-- File upload --}}
<div class="row">
    <div class="col s12 text-u pb-3 mt-5">
        <b>File upload</b>
    </div>
</div>


<div class="col s12">
    <form action="#">
        <div class="file-field input-field">
            <div class="btn">
                <span>File</span>
                <input type="file" multiple>
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Upload one or more files">
            </div>
        </div>
    </form>
</div>
{{--End File upload--}}

<div class="divider mt-5 mb-5"></div>

{{--Select--}}
<div class="row">
    <div class="col s12 text-u pb-3 mt-5">
        <b>Select</b>
    </div>
</div>


<div class="input-field col s12">
    <select>
        <option value="" disabled selected>Choose your option</option>
        <option value="1">Option 1</option>
        <option value="2">Option 2</option>
        <option value="3">Option 3</option>
    </select>
    <label>Materialize Select</label>
</div>
{{--End Select--}}

<div class="divider mt-5 mb-5"></div>

{{--collapsible--}}
<div class="row">
    <div class="col s12 text-u pb-3 mt-5">
        <b>collapsible</b>
    </div>
</div>


<ul class="collapsible">
    <li>
        <div class="collapsible-header"><i class="material-icons">filter_drama</i>First</div>
        <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
    </li>
    <li>
        <div class="collapsible-header"><i class="material-icons">place</i>Second</div>
        <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
    </li>
    <li>
        <div class="collapsible-header"><i class="material-icons">whatshot</i>Third</div>
        <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
    </li>
</ul>