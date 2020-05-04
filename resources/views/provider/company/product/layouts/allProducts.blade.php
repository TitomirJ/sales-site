<tr class="font-weight-bold bor-bottom">
        <td scope="col" class="align-middle">
            <div class="d-block text-center text-nowrap dark-link">
                <div class="wrapper-checkbox">
                    <input type="checkbox" class="css-checkbox" id="click-all-products">
                    <label for="click-all-products" class="css-label radGroup1"></label>
                </div>
            </div>
        </td>
        <td scope="col" class="align-middle">
            <div class="d-block text-center text-uppercase text-nowrap">
                фото
            </div>
        </td>
        <td scope="col" class="align-middle">
            <div class="d-block text-center text-uppercase text-nowrap">
                артикул
            </div>
        </td>
        <td scope="col" class="align-middle">
            <div class="d-block text-center text-uppercase text-nowrap">
                название товара
            </div>
        </td>
        <td scope="col" class="align-middle">
            <div class="d-block text-center text-uppercase text-nowrap">
                ссылки
            </div>
        </td>
        <td scope="col" class="align-middle">
            <div class="d-block text-center text-uppercase text-nowrap">
                цена
            </div>
        </td>
        <td scope="col" class="align-middle">
            <div class="d-block text-center text-uppercase text-nowrap">
                в наличии
            </div>
        </td>
        <td scope="col" class="align-middle">
            <div class="d-block text-center text-uppercase text-nowrap">
                статус
            </div>
        </td>
        <td scope="col" class="align-middle">
            <div class="d-block text-center text-uppercase text-nowrap">
                действие
            </div>
        </td>
        <td scope="col" class="align-middle">
            <div class="d-block text-center text-uppercase text-nowrap">
                #поиск
            </div>
        </td>
    </tr>
@forelse($products as $p)
    <tr class="bor-bottom">
        <td scope="col" class="text-center align-middle">
            <div class="wrapper-checkbox">
                <input type="checkbox" form="action-form-all-product" name="product_id[]" value="{{$p->id}}" id="true-{{$p->id}}" class="css-checkbox form-check-input">
                <label for="true-{{$p->id}}" class="form-check-label css-label radGroup1"></label>
            </div>
        </td>
        <?
        $gallery_array = json_decode($p->gallery);
        ?>
        <td scope="col" class="text-center align-middle">
            <div>
                <img src="{{$gallery_array[0]->public_path}}" alt="{{$p->name}}" style="max-width: 70px;">
            </div>
        </td>
        <td scope="col" class="text-center align-middle">
            <?
            $str = $p->code;
            $result = substr($str, strpos($str, '-') + 1, strlen($str));
            ?>
            {{$result}}
        </td>
        <td scope="col" class="text-center align-middle">{{$p->name}}</td>
        <?
            if($p->rozetka_data != null){
                $rozetka_data = json_decode($p->rozetka_data);
                $rozetka_link = $rozetka_data->url;
            }
        ?>

        <td scope="col" class="text-center align-middle">
            @if($p->rozetka_data != null)
                <a class="badge badge-pill badge-success" href="{{ $rozetka_link }}" target="_blank" title="Посмотреть товар на Розетке">R</a>
            @else
                <span class="badge badge-pill badge-secondary">R</span>
            @endif
        </td>
        <td scope="col" class="text-center align-middle">
            <div class="d-flex align-items-center">
                <div class="m-auto bg-success rounded text-white p-1">
                    {{$p->price}} грн
                    <div class="old-price bg-secondary rounded text-white p-1 m-1">
                        @if($p->old_price == true)
                            {{$p->old_price}} грн
                        @endif
                    </div>
                    <div class="price_promo bg-warning text-danger rounded p-1 m-1">
                        @if($p->price_promo == true)
                            {{$p->price_promo}} грн
                        @endif
                    </div>
                </div>
            </div>
        </td>
        <td scope="col" class="text-center align-middle">
            <form class="form-change-status-avail" action="{{ asset('company/product/'.$p->id.'/available') }}" method="POST">
                {{ csrf_field() }}
                <label class="switch mb-0">
                    <input type="checkbox" class="" {{ ($p->status_available == 1)? 'checked': '' }}>
                    <span class="slider round change-status-avail" action="reload-no-avail" myUrl="{{ asset('/company/products?type=3&page=1') }}"></span>
                </label>
            </form>
        </td>
        <td scope="col" class="text-center align-middle" id="status-table-product-{{$p->id}}">
            @include('provider.company.product.layouts.layouts.statusProductBlock')
        </td>
        <td scope="col" class="text-center align-middle">

            @include('provider.company.product.layouts.layouts.dropdownButtonsMenu')

        </td>
        {{-- кнопка для добавления поисковых слов  --}}
        <td scope="col" class="text-center align-middle">
         {{-- <form action="{{ asset('company/product/keywords/'.$p->id) }}" method="POST">
            {{ csrf_field() }}
         <input type="hidden" name="item_id" value="{{$p->id}}">  --}}

         <?php $lenstr = strlen($p->words); ?>
         @if($lenstr > 2)
         {{-- <button class="btn btn-success shadow-custom  border-radius-50 ml-2 mr-2 dropdown-toggle" type="submit" id="add_keywords">
            редактировать
        </button> --}}
        <a href="{{ asset('company/product/keywords/'.$p->id) }}" class="btn btn-success shadow-custom  border-radius-50 ml-2 mr-2 dropdown-toggle" id="add_keywords">
            редактировать
        </a>
         @else
            {{-- <button class="btn square_btn shadow-custom text-uppercase border-radius-50 ml-2 mr-2 dropdown-toggle" type="submit" id="add_keywords">
                добавить
            </button> --}}
            <a href="{{ asset('company/product/keywords/'.$p->id) }}" class="btn square_btn shadow-custom text-uppercase border-radius-50 ml-2 mr-2 dropdown-toggle" id="add_keywords">
                добавить
            </a>
        @endif
        {{-- </form>  --}}
        </td>
    </tr>

    @empty

    <tr>
        <td scope="col" colspan="9" class="text-center">Товары не найдены</td>
    </tr>
@endforelse
    <tr>
        <td scope="col" colspan="10" class="text-center container-fluid all-products-pagination" all-product-current-page="{{ $products->currentPage() }}" type="1">{{ $products->links() }}</td>
    </tr>