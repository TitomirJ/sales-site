<?
$company_data = json_decode($company->data);
?>

@if($company->type_company == '0')
    <h4 class="w-100 text-center">Юридическое лицо</h4>
    <div class="form-group">
        <label for="name">код ЕГРПОУ *</label>
        <input type="text" class="legal-input form-control" name="legal_data[]" form="update-company-form" value="{{ $company_data[0] }}" autofocus>
    </div>
    <div class="form-group">
        <label for="name">Юридический адрес *</label>
        <input type="text" class="legal-input form-control" name="legal_data[]" form="update-company-form" value="{{ $company_data[1] }}" autofocus>
    </div>

@elseif($company->type_company == '1')
    <h4 class="w-100 text-center">Физическое лицо предприниматель</h4>

    <div class="form-group">
        <label for="name">Паспорт(срерия, номер) *</label>
        <input type="text" class="legal-input form-control" name="legal_data[]" form="update-company-form" value="{{ $company_data[0] }}" autofocus>
    </div>
    <div class="form-group">
        <label for="name">Паспорт(кем выдан) *</label>
        <input type="text" class="legal-input form-control" name="legal_data[]" form="update-company-form" value="{{ $company_data[1] }}" autofocus>
    </div>
    <div class="form-group">
        <label for="name">Паспорт(дата выдачи) *</label>
        <input type="text" class="legal-input form-control" name="legal_data[]" form="update-company-form" value="{{ $company_data[2] }}" autofocus>
    </div>
    <div class="form-group">
        <label for="name">Индивидуальный налоговый номер (ИНН) *</label>
        <input type="text" class="legal-input form-control" name="legal_data[]" form="update-company-form" value="{{ $company_data[3] }}" autofocus>
    </div>
@elseif($company->type_company == '2')
    <h4 class="w-100 text-center">Физическое лицо</h4>
    <div class="form-group">
        <label for="name">Паспорт(срерия, номер) *</label>
        <input type="text" class="legal-input form-control" name="legal_data[]" form="update-company-form" value="{{ $company_data[0] }}" autofocus>
    </div>
    <div class="form-group">
        <label for="name">Паспорт(кем выдан) *</label>
        <input type="text" class="legal-input form-control" name="legal_data[]" form="update-company-form" value="{{ $company_data[1] }}" autofocus>
    </div>
    <div class="form-group">
        <label for="name">Паспорт(дата выдачи) *</label>
        <input type="text" class="legal-input form-control" name="legal_data[]" form="update-company-form" value="{{ $company_data[2] }}" autofocus>
    </div>
    <div class="form-group">
        <label for="name">Индивидуальный налоговый номер (ИНН) *</label>
        <input type="text" class="legal-input form-control" name="legal_data[]" form="update-company-form" value="{{ $company_data[3] }}" autofocus>
    </div>
@endif

