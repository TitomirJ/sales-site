@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/rulesProduct/rulesProduct.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid pb-5">

            @include('provider.company.layouts.breadcrumbs')
            <h2>
                Рекомендации по качеству изображений
            </h2>
            <h3>Количество изображений</h3>
            <div>
                <ul>
                    <li>
                        Минимум 1 изображение
                    </li>
                </ul>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Рекомендовано
                    </a>
                </p>
                <div class="collapse success-card position-relative" id="collapseExample">
                    <div class="success-card-ok position-absolute"></div>
                    <div class="card card-body success-card-content">
                        <ul class="mb-0">
                            <li>От 2 до 8 изображений</li>
                        </ul>
                    </div>
                </div>
            </div>

            <h3>Размер и разрешение изображения</h3>
            <ul>
                <li>Размер 600х500 пикселей</li>
                <li>Минимальное разрешение 72dpi</li>
                <li>Изображение продукта на фото должно быть ясным, чётким, без зернистости и размытости</li>
                <li>Изображение продукта должно иметь белый (светлый, однотонный, если фото сделано профессионально в студии) или прозрачный фон</li>
            </ul>
            <div>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapseSize" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Рекомендовано
                    </a>
                </p>
                <div class="collapse success-card position-relative" id="collapseSize">
                    <div class="success-card-ok position-absolute"></div>
                    <div class="card card-body success-card-content">
                        <ul class="mb-0">
                            <li>Размер 850 х 850 пикселей и выше</li>
                            <li>Соотношение изображения 1х1</li>
                            <li>Продукт должен охватывать более 80% полотна самой длинной оси</li>
                            <li>Изображение должно иметь белый или прозрачный фон</li>
                        </ul>
                    </div>
                </div>
            </div>

            <h3>Изображение продукта на фото</h3>
            <ul>
                <li>Продукт на изображении должен быть на переднем плане. Его вид не должен быть заблокирован или закрыт другими предметами</li>
                <li>Фотографировать товар нужно с фронтальной стороны или под углом 30 градусов. Фотографии всех товаров должны быть сделаны в одном стиле</li>
                <li>Продукт на изображении должен быть без упаковки</li>
                <li>Изображение продукта должно быть в натуральном размере, не растянуто или сплюснуто</li>
                <li>Товар на фотографии не должен быть обрезан. Весь товар должен быть в пределах изображения</li>
            </ul>
            <div>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapseImg" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Рекомендовано
                    </a>
                </p>
                <div class="collapse success-card position-relative" id="collapseImg">
                    <div class="success-card-ok position-absolute"></div>
                    <div class="card card-body success-card-content">
                        <ul class="mb-0">
                            <li>Фотографии не должны содержать какие-либо тени, другие предметы</li>
                            <li>Товар на фотографии должен быть чистым, без пыли и отпечатков пальцев</li>
                            <li>На карточке товара рекомендуется добавить фото материала/поверхности товара крупным планом (исключение – заглавная фотография продукта)</li>
                            <li>На фотографии должно быть размещено только изображение продаваемого товара. Товар может находиться в интерьере, однако не в выставочном зале рядом с другими товарами</li>
                        </ul>
                    </div>
                </div>
            </div>

            <h3>Другое</h3>
            <ul>
                <li>Изображение продукта соответствует характеристикам и описанию карточки товара</li>
                <li>Фотографировать товар нужно с фронтальной стороны или под углом 30 градусов. Фотографии всех товаров должны быть сделаны в одном стиле</li>
                <li>Изображение без вотермарок, текста, логотипа, ссылок и др.графических элементов</li>
            </ul>

            <h3>Размер изображения, фон и качество</h3>
            <ul>
                <li>Любое расположение изображения допустимо</li>
                <li>Товар на фото может занимать любое кол-во пространства</li>
            </ul>
            <div>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapseex" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Пример
                    </a>
                </p>
                <div class="collapse success-card position-relative" id="collapseex">
                    <div class="success-card-ok position-absolute"></div>
                    <div class="card card-body success-card-content">
                        <img src="https://i1.rozetka.ua/pages/325/325038.png" style="max-width:896px;">
                    </div>
                </div>
            </div>

            <ul>
                <li>Рекомендуется размер изображения 1х1 с белым фоном</li>
                <li>Рекомендуется, чтобы товар занимал около 80% изображения</li>
            </ul>

            <div>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapsechet" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Рекомендовано
                    </a>
                </p>
                <div class="collapse success-card position-relative" id="collapsechet">
                    <div class="success-card-ok position-absolute"></div>
                    <div class="card card-body success-card-content">
                        <img src="https://i1.rozetka.ua/pages/325/325056.png" style="max-width:896px;">
                    </div>
                </div>
            </div>

            <ul>
                <li>Фотография товара должна быть четкая, без размытости</li>
            </ul>

            <div>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Пример
                    </a>
                </p>
                <div class="collapse" id="collapse1">
                    <div class="success-card position-relative mb-3">
                        <div class="success-card-ok position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i1.rozetka.ua/pages/325/325530.png" style="max-width:429px;">
                        </div>
                    </div>

                    <div class="error-card position-relative">
                        <div class="error-card-not  position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i2.rozetka.ua/pages/321/321276.png" style="max-width:196px;">
                        </div>
                    </div>
                </div>
            </div>

            <ul>
                <li>Фотография товара должна быть четкая, без зернистости</li>
            </ul>

            <div>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Пример
                    </a>
                </p>
                <div class="collapse" id="collapse2">
                    <div class="success-card position-relative mb-3">
                        <div class="success-card-ok position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i2.rozetka.ua/pages/325/325548.png" style="max-width:429px;">
                        </div>
                    </div>

                    <div class="error-card position-relative">
                        <div class="error-card-not  position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i2.rozetka.ua/pages/321/321330.png" style="max-width:196px;">
                        </div>
                    </div>
                </div>
            </div>

            <ul>
                <li>Товар должен иметь чёткий контур на фотографии</li>
            </ul>

            <div>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Пример
                    </a>
                </p>
                <div class="collapse" id="collapse3">
                    <div class="success-card position-relative mb-3">
                        <div class="success-card-ok position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i2.rozetka.ua/pages/325/325566.png" style="max-width:429px;">
                        </div>
                    </div>

                    <div class="error-card position-relative">
                        <div class="error-card-not  position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i1.rozetka.ua/pages/321/321366.png" style="max-width:196px;">
                        </div>
                    </div>
                </div>
            </div>

            <ul>
                <li>На главной фотографии должен быть чётко показан фронтальный вид</li>
            </ul>

            <div>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapse4" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Пример
                    </a>
                </p>
                <div class="collapse" id="collapse4">
                    <div class="success-card position-relative mb-3">
                        <div class="success-card-ok position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i2.rozetka.ua/pages/325/325584.png" style="max-width:429px;">
                        </div>
                    </div>

                    <div class="error-card position-relative">
                        <div class="error-card-not  position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i2.rozetka.ua/pages/321/321402.png" style="max-width:196px;">
                        </div>
                    </div>
                </div>
            </div>

            <ul>
                <li>Товар не должен иметь следов использования</li>
            </ul>

            <div>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapse5" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Пример
                    </a>
                </p>
                <div class="collapse" id="collapse5">
                    <div class="success-card position-relative mb-3">
                        <div class="success-card-ok position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i2.rozetka.ua/pages/325/325602.png" style="max-width:429px;">
                        </div>
                    </div>

                    <div class="error-card position-relative">
                        <div class="error-card-not  position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i1.rozetka.ua/pages/325/325098.png" style="max-width:196px;">
                        </div>
                    </div>
                </div>
            </div>

            <ul>
                <li>Товар на фотографии должен иметь корректную форму, не растянут или не сжат по одной из сторон фотографии</li>
            </ul>

            <div>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapse6" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Пример
                    </a>
                </p>
                <div class="collapse" id="collapse6">
                    <div class="success-card position-relative mb-3">
                        <div class="success-card-ok position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i1.rozetka.ua/pages/325/325620.png" style="max-width:429px;">
                        </div>
                    </div>

                    <div class="error-card position-relative">
                        <div class="error-card-not  position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i1.rozetka.ua/pages/321/321924.png" style="max-width:196px;">
                        </div>
                    </div>
                </div>
            </div>

            <ul>
                <li>Фотография товара должно иметь прямое отношение к характеристикам и описанию карточки товара</li>
            </ul>

            <div>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapse7" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Пример
                    </a>
                </p>
                <div class="collapse" id="collapse7">
                    <div class="success-card position-relative mb-3">
                        <div class="success-card-ok position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i1.rozetka.ua/pages/325/325638.png" style="max-width:429px;">
                        </div>
                    </div>

                    <div class="error-card position-relative">
                        <div class="error-card-not  position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i1.rozetka.ua/pages/321/321960.png" style="max-width:196px;">
                        </div>
                    </div>
                </div>
            </div>

            <ul>
                <li>Фотографии, преимущественно, нижнего белья, купальных костюмов, др.одежды, а также других товаров не должны содержать сексуальный подтекст или оголённые части тела</li>
            </ul>

            <div>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapse8" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Пример
                    </a>
                </p>
                <div class="collapse" id="collapse8">
                    <div class="success-card position-relative mb-3">
                        <div class="success-card-ok position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i1.rozetka.ua/pages/325/325656.png" style="max-width:429px;">
                        </div>
                    </div>

                    <div class="error-card position-relative">
                        <div class="error-card-not  position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i1.rozetka.ua/pages/322/322014.png" style="max-width:196px;">
                        </div>
                    </div>
                </div>
            </div>

            <h3>Угол фотографирования товара</h3>
            <ul>
                <li>Товар может быть сфотографирован под любым углом, если его вид спереди будет чётко виден</li>
                <li>Рекомендуется делать фотографии товара с видом спереди и в повороте на 30 градусов для лучшего отображения товара</li>
            </ul>

            <div>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapse9" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Пример
                    </a>
                </p>
                <div class="collapse" id="collapse9">
                    <div class="success-card position-relative mb-3">
                        <div class="success-card-ok position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i2.rozetka.ua/pages/322/322212.png" style="max-width:895px;">
                        </div>
                    </div>
                </div>
            </div>

            <h3>Расположение других предметов на товаре</h3>
            <ul>
                <li>Расположение других предметов допустимы на фотографиях товаров</li>
                <li>Рекомендуется добавлять фотографии товаров без каких-либо отражений</li>
            </ul>

            <div>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapse10" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Пример
                    </a>
                </p>
                <div class="collapse" id="collapse10">
                    <div class="success-card position-relative mb-3">
                        <div class="success-card-ok position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i1.rozetka.ua/pages/325/325116.png" style="max-width:895px;">
                        </div>
                    </div>
                </div>
            </div>

            <h3>Фотографии не на белом фоне</h3>
            <ul>
                <li>Допускаются фотографии не на белом фоне, если сделаны в профессиональной студии</li>
            </ul>

            <div>
                <p>
                    <a class="ml-4" data-toggle="collapse" href="#collapse11" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Пример
                    </a>
                </p>
                <div class="collapse" id="collapse11">
                    <div class="success-card position-relative mb-3">
                        <div class="success-card-ok position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i2.rozetka.ua/pages/322/322248.png" style="max-width:895px;">
                        </div>
                    </div>

                    <div class="error-card position-relative">
                        <div class="error-card-not  position-absolute"></div>
                        <div class="card card-body success-card-content">
                            <img src="https://i2.rozetka.ua/pages/322/322266.png" style="max-width:895px;">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
