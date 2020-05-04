
<ol class="breadcrumb mt-1">
    <li class="breadcrumb-item">
        <a class="on-overlay-loader" href="{{asset('/company')}}">Сводка</a>
    </li>
    @if(Request::path() == 'company')
        <li class="breadcrumb-item active">Общая сводка</li>
    @elseif(Request::path() == 'company/profile')
        <li class="breadcrumb-item active">Данные компании</li>
    @elseif(Request::path() == 'user/profile')
        <li class="breadcrumb-item active">Личный кабинет</li>
    @elseif(Request::path() == 'company/personnel')
        <li class="breadcrumb-item active">Сотрудники компании</li>
    @elseif(Request::path() == 'company/add/manager')
        <li class="breadcrumb-item active">Добавить сотрудника</li>

        <?// Товары поставщика?>

    @elseif(Request::path() == 'company/products')
        <li class="breadcrumb-item active">Товары</li>

    @elseif(Request::is('company/products/'.(isset($product)?$product->id:'null')))
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/company/products')}}">Товары</a>
        </li>
        <li class="breadcrumb-item active">Просмотр товара</li>

    @elseif(Request::path() == 'company/products/create')
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/company/products')}}">Товары</a>
        </li>
        <li class="breadcrumb-item active">Создание товара</li>

    @elseif(Request::is('company/products/*/edit'))
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/company/products')}}">Товары</a>
        </li>
        <li class="breadcrumb-item active">Редактирование товара</li>
    @elseif(Request::is('company/products/*/orders'))
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/company/products')}}">Товары</a>
        </li>
        <li class="breadcrumb-item active">Просмотр заказов по товару</li>
    @elseif(Request::is('company/products/*/clone'))
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/company/products')}}">Товары</a>
        </li>
        <li class="breadcrumb-item active">Клонирование товара</li>
    @elseif(Request::is('admin/products/*'))
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/company/products')}}">Товары</a>
        </li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>

        <?// Товары поставщика?>
    @elseif(Request::path() == 'company/orders')
        <li class="breadcrumb-item active">Заказы</li>

    @endif
</ol>