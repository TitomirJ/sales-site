@if($action == 'link')
    <form action="{{ asset('company/externals') }}" method="POST" id="ext-link-form">
        {{ csrf_field() }}

        <input type="hidden" name="action" value="{{ $action }}">

        <div class="form-group">
            <label for="pub-link-ext">Публичный адрес XML файла</label>
            <input type="text" id="pub-link-ext" class="form-control border-radius shadow-custom" name="link">

        </div>
        
        <hr>

        <button type="submit" class="btn btn-form btn-success shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 create-link-ext" data-form="#ext-link-form">создать</button>
        <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">отмена</button>

    </form>

    {{-- форма для загрузки XML файла локально с компьютера пользователя --}}

@elseif($action == 'linkxml')

<form action="{{ asset('company/externals') }}" method="POST" id="ext-link-formxml" enctype="multipart/form-data">
    {{ csrf_field() }}

    <input type="hidden" name="action" value="{{ $action }}">

    <div class="form-group">
        <label for="pub-link-ext">Выбрать XML файл</label>
        <input type="file" id="pub-link-ext" class="form-control border-radius shadow-custom" name="linkxml">

    </div>
    
    <hr>

    <button type="submit" class="btn btn-form btn-success shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 create-link-extxml" data-form="#ext-link-formxml">загрузить</button>
    <button type="button" class="btn btn-form btn-secondary shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" data-dismiss="modal">отмена</button>

</form>

@endif