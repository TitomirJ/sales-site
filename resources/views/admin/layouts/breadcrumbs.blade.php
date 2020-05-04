<ol class="breadcrumb mt-2">
    <li class="breadcrumb-item">
        <a class="on-overlay-loader" href="{{asset('/admin')}}">Сводка</a>
    </li>

    @if(Request::path() == 'admin')
        <li class="breadcrumb-item active">Общая сводка</li>

        <?// Крохи для страгицы сотрцдников?>

    @elseif(Request::path() == 'admin/personnel')
        <li class="breadcrumb-item active">Сотрудники сайта</li>

    @elseif(Request::path() == 'admin/personnel/create')
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/admin/personnel')}}">Сотрудники сайта</a>
        </li>
        <li class="breadcrumb-item active">Зарегистрировать нового модератора</li>

        <?// Крохи для личного кабинета?>

    @elseif(Request::path() == 'user/profile')
        <li class="breadcrumb-item active">Личный кабинет</li>

        <?// Крохи для новостей?>

    @elseif(Request::path() == 'admin/blog')
        <li class="breadcrumb-item active">Новости</li>

    @elseif(Request::path() == 'admin/blog/create')
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/admin/blog')}}">Новости</a>
        </li>
        <li class="breadcrumb-item active">Создание новостей</li>

    @elseif(Request::is('admin/blog/edit/*'))
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/admin/blog')}}">Новости</a>
        </li>
        <li class="breadcrumb-item active">Редактирование новости</li>

        <?// Крохи для отзывов?>

    @elseif(Request::path() == 'admin/review')
        <li class="breadcrumb-item active">Отзывы</li>

    @elseif(Request::path() == 'admin/review/create')
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/admin/review')}}">Отзывы</a>
        </li>
        <li class="breadcrumb-item active">Создание отзыва</li>

    @elseif(Request::is('admin/review/edit/*'))
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/admin/review')}}">Отзывы</a>
        </li>
        <li class="breadcrumb-item active">Редактирование отзыва</li>

        <?// Крохи для тематик?>
    @elseif(Request::path() == 'admin/themes')
        <li class="breadcrumb-item active">Тематики категорий</li>

    @elseif(Request::is('admin/themes/*'))
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/admin/themes')}}">Тематики категорий</a>
        </li>
        <li class="breadcrumb-item active">{{ $theme->name }}</li>

        <?// Крохи для категорий?>
    @elseif(Request::path() == 'admin/categories')
        <li class="breadcrumb-item active">Категории товаров</li>

    @elseif(Request::path() == 'admin/categories/create')
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/admin/categories')}}">Категории товаров</a>
        </li>
        <li class="breadcrumb-item active">Создать категорию</li>

    @elseif(Request::is('admin/categories/*/edit'))
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/admin/categories')}}">Категории товаров</a>
        </li>
        <li class="breadcrumb-item active">Редактирование категории</li>
    @elseif(Request::is('admin/categories/*'))
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/admin/categories')}}">Категории товаров</a>
        </li>
        <li class="breadcrumb-item active">{{ $category->name }}</li>

        <?// Крохи для подкатегорий?>
    @elseif(Request::path() == 'admin/subcategories')
        <li class="breadcrumb-item active">Подкатегории товаров</li>

    @elseif(Request::path() == 'admin/subcategories/create')
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/admin/subcategories')}}">Подкатегории товаров</a>
        </li>
        <li class="breadcrumb-item active">Создать подкатегорию</li>

    @elseif(Request::is('admin/subcategories/*/edit'))
        <li class="breadcrumb-item">
            <a class="on-overlay-loader" href="{{asset('/admin/subcategories')}}">Подкатегории товаров</a>
        </li>
        <li class="breadcrumb-item active">Редактирование подкатегории</li>
    @endif

</ol>