@if($form_type == 'update')
    <h2 class="w-100 text-center">Обновление текущей подкатегории</h2>
    <form class="form-horizontal" method="POST" action="{{ asset('/admin/api/rozetka/subcategory/'.$market_id) }}">
        {{ csrf_field() }}

        <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">
            обновить
        </button>
    </form>
@elseif($form_type == 'noUpdateNotHaveParams')
    <h2 class="w-100 text-danger text-center">Невозможно обновить отсутствует подкатегория на Розетке</h2>
@elseif($form_type == 'createNewWithRozet')
    <h2 class="w-100 text-center">Создание новой подкатегории с хар. Розетки</h2>
    <form class="form-horizontal" method="POST" action="{{ asset('/admin/api/rozetka/subcategory/with/params') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="category-id">Выбрать категорию</label>
            <select class="form-control category-select2" id="category-id" name="category_id">
                @forelse($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @empty
                    <option value="0">Категории отсутствуют</option>
                @endforelse
            </select>
        </div>


        <input id="market-id" type="hidden" class="form-control" name="market_id" value="{{ $market_id }}" required>


        <div class="form-group">
            <label for="name">Название подкатегории</label>
            <input id="name" type="text" class="form-control" name="name" value="{{ $rozetka_subcat_name }}" required>
        </div>

        <div class="form-group">
            <label for="commission">Размер комиссии</label>
            <input id="commission" type="text" class="commission-mask form-control" name="commission" required>
        </div>

        <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">
            Добавить подкатегорию
        </button>

    </form>
    <script>
        $(document).ready(function(){
            $('.category-select2').select2({
                placeholder: 'категории не найдены',
            });
        });
        $(".commission-mask").mask("99");
    </script>
@elseif($form_type == 'createWithOutRozet')

    <h2 class="w-100 text-center">Создание новой подкатегории без хар. Розетки</h2>
    <form class="form-horizontal" method="POST" action="{{ asset('/admin/subcategories') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="category-id">Выбрать категорию</label>
            <select class="form-control category-select2" id="category-id" name="category_id">
                @forelse($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @empty
                    <option value="0">Категории отсутствуют</option>
                @endforelse
            </select>
        </div>

        <div class="form-group">
            <label for="market-id">Код категории Розетки</label>
            <input id="market-id" type="number" class="form-control" name="market_id" value="{{ $market_id }}" required>
        </div>

        <div class="form-group">
            <label for="name">Название подкатегории</label>
            <input id="name" type="text" class="form-control" name="name" required>
        </div>

        <div class="form-group">
            <label for="commission">Размер комиссии</label>
            <input id="commission" type="text" class="commission-mask form-control" name="commission" required>
        </div>

        <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">
            Добавить подкатегорию
        </button>

    </form>
    <script>
        $(document).ready(function(){
            $('.category-select2').select2({
                placeholder: 'категории не найдены',
            });
        });
    </script>
@endif
