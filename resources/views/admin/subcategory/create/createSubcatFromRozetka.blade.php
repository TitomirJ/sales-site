@extends('admin.layouts.app')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid mt-5">



            <div class="row">
                <div class="col-12">
                    <h2 class="text-center">Поготовка и обновление покатегорий через АПИ Розетки</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5 offset-md-1">
                    <form action="{{ asset('admin/api/rozetka/subcat/search') }}" method="GET" id="search-rozet-subcat-form"></form>
                    <input type="number" id="search-form-market-id" name="market_id" form="search-rozet-subcat-form">
                    <button type="submit" form="search-rozet-subcat-form" id="btn-submit-rozet-subcat-form">Поиск</button>
                </div>

                <div class="col-md-5">
                    <form action="{{ asset('admin/api/rozetka/subcat/search') }}" method="GET" id="search-rozet-subcat-form2"></form>
                    <select class="select2-subcat form-control" name="market_id" form="search-rozet-subcat-form2" id="all-bigsales-subcat">
                        @foreach($subcategories as $subcategory)
                            <option value="{{ $subcategory->market_subcat_id }}">{{ $subcategory->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <h2 class="w-100 text-center">Результат поиска</h2>
                </div>
                <div class="col-md-6" id="bigsales-subcat-place"></div>
                <div class="col-md-6" id="rozetka-subcat-place"></div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12" id="form-new-subcat-place">

                </div>
            </div>

        </div>
    </div>





@endsection

@section('script2')
    <script>
        $(document).ready(function(){
            $('.select2-subcat').select2({
                placeholder: 'категории не найдены',
            });
        });

        $('#btn-submit-rozet-subcat-form').on('click', function (e) {
            e.preventDefault();
            var form = $('#'+$(this).attr('form'));
            var url = form.attr('action');
            loadCatsBlocks(form, url);

        });

        $('#all-bigsales-subcat').on('change', function (e) {
            e.preventDefault();
            var form = $('#'+$(this).attr('form'));
            var url = form.attr('action');
            loadCatsBlocks(form, url);
        });

        function loadCatsBlocks(form, url) {
            var inProgress = false;

            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    data: form.serialize(),
                    beforeSend: function () {
                        inProgress = true;
                        $('#overlay-loader').show();
                    },
                    success: function (data) {
                        $('#overlay-loader').hide();
                        var data = JSON.parse(data);

                        if(data.status == 'success'){
                            $('#rozetka-subcat-place').html(data.render.rozetka);
                            $('#bigsales-subcat-place').html(data.render.bigsales);
                            $('#form-new-subcat-place').html(data.render.form);
                        }
                    },
                    error: function (data) {
                        $('#overlay-loader').hide();
                        $.toaster({
                            message: "Ошибка сервера!",
                            title: 'Sorry!',
                            priority: 'danger',
                            settings: {'timeout': 3000}
                        });
                    }
                });
            }
        }

    </script>
@endsection
