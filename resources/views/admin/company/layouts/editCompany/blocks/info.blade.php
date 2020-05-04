<form class="form-horizontal" method="POST" action="{{ asset('admin/company/'.$company->id.'/update') }}" id="update-company-form">
    {{ csrf_field() }}
    <input type="hidden" name="action" value="info">
</form>
<div class="row bg-light border-radius border-2 border-blue">
    <div class="col-md-6">

        <div class="row">
            <div class="col-12 p-3">
                <div class="form-group">
                    <label for="name">Название *</label>
                    <input id="name" type="text" class="legal-input form-control" name="name" form="update-company-form" value="{{ $company->name }}" autofocus>
                </div>

                <div class="form-group">
                    <label for="name">Ссылка</label>
                    <input id="link" type="text" class="form-control" name="link" form="update-company-form" value="{{ $company->link }}" autofocus>
                </div>

                <div class="form-group">
                    <label for="name">Ответсвтенный *</label>
                    <input id="responsible" type="text" class="legal-input form-control" name="responsible" form="update-company-form" value="{{ $company->	responsible }}" autofocus>
                </div>

                <div class="form-group">
                    <label for="name">Номер ответственного *</label>
                    <input id="responsible-phone" type="text" class="legal-input form-control mask-tel" name="responsible_phone" value="{{ $company->responsible_phone }}" form="update-company-form" autofocus>
                </div>

                <div class="form-group">
                    <label for="name">Информация о компании *</label>
                    <textarea id="info" type="text" class="legal-input form-control" name="info" form="update-company-form">{{ $company->info }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">

        <div class="row">
            <div class="col-12 p-3">

                <div class="form-group">
                    <label for="type-company">Тип компании *</label>
                    <select class="legal-input form-control type-company-select2 load-type-company-form" name="type_company" id="type-company" data-url="{{ asset('admin/company/type/form') }}" form="update-company-form">
                        <option value="0" @if($company->type_company == '0') selected @endif>Юридическое лицо</option>
                        <option value="1" @if($company->type_company == '1') selected @endif>Физическое лицо предприниматель (ФОП)</option>
                        <option value="2" @if($company->type_company == '2') selected @endif>Физическое лицо</option>
                    </select>
                </div>

                <div id="type-company-form">

                    @include('admin.company.layouts.editCompany.blocks.layouts.infoLegalBlock')

                </div>

            </div>
        </div>
    </div>

    <button id="update-company-submit-btn" class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3" type="submit" form="update-company-form">редактировать</button>

</div>
{{--<div>--}}
    {{--{{ $company->legal_person }}--}}
{{--</div>--}}
<script>
    $(document).ready(function(){
        $('.type-company-select2').select2();
    });
</script>