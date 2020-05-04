@if($type_company == '0')
    <h4 class="w-100 text-center">Юридическое лицо</h4>
    <div class="form-group">
        <label for="name">код ЕГРПОУ</label>
        <input type="text" class="legal-input2 form-control" name="legal_data[]" form="reg-company-form" autofocus>
    </div>
    <div class="form-group">
        <label for="name">Юридический адрес</label>
        <input type="text" class="legal-input2 form-control" name="legal_data[]" form="reg-company-form" autofocus>
    </div>

@elseif($type_company == '1')
    <h4 class="w-100 text-center">Физическое лицо предприниматель</h4>

    <div class="form-group">
        <label for="name">Паспорт(серия, номер)</label>
        <input type="text" class="legal-input2 form-control" name="legal_data[]" form="reg-company-form" autofocus>
    </div>
    <div class="form-group">
        <label for="name">Паспорт(кем выдан)</label>
        <input type="text" class="legal-input2 form-control" name="legal_data[]" form="reg-company-form" autofocus>
    </div>
    <div class="form-group">
        <label for="name">Паспорт(дата выдачи)</label>
        <input type="text" class="legal-input2 form-control" name="legal_data[]" form="reg-company-form" autofocus>
    </div>
    <div class="form-group">
        <label for="name">Индивидуальный налоговый номер (ИНН)</label>
        <input type="text" class="legal-input2 form-control" name="legal_data[]" form="reg-company-form" autofocus>
    </div>
@elseif($type_company == '2')
    <h4 class="w-100 text-center">Физическое лицо</h4>
    <div class="form-group">
        <label for="name">Паспорт(серия, номер)</label>
        <input type="text" class="legal-input2 form-control" name="legal_data[]" form="reg-company-form" autofocus>
    </div>
    <div class="form-group">
        <label for="name">Паспорт(кем выдан)</label>
        <input type="text" class="legal-input2 form-control" name="legal_data[]" form="reg-company-form" autofocus>
    </div>
    <div class="form-group">
        <label for="name">Паспорт(дата выдачи)</label>
        <input type="text" class="legal-input2 form-control" name="legal_data[]" form="reg-company-form" autofocus>
    </div>
    <div class="form-group">
        <label for="name">Индивидуальный налоговый номер (ИНН)</label>
        <input type="text" class="legal-input2 form-control" name="legal_data[]" form="reg-company-form" autofocus>
    </div>
@endif