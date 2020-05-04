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
        <td scope="col" class="text-center align-middle">{{$p->code}}</td>
        <td scope="col" class="text-center align-middle">{{$p->name}}</td>
        <td scope="col" class="text-center align-middle">
            <div class="d-flex align-items-center">
                <div class="m-auto">
                    {{$p->price}} грн
                    <div class="old-price">
                        @if($p->old_price == true)
                            {{$p->old_price}} грн
                        @endif
                    </div>
                </div>
            </div>
        </td>
        <td scope="col" class="text-center align-middle">
            <form class="form-change-status-avail-{{ $p->id }}" action="{{ asset('company/product/'.$p->id.'/available') }}" method="POST" data-action="reload-no-avail" data-url="{{ asset('/company/products?type=0&page=1') }}">
                {{ csrf_field() }}
                <label class="switch mb-0">
                    <input type="checkbox" class="" {{ ($p->status_available == 1)? 'checked': '' }}>
                    <span class="slider round confirm-modal-new" data-form="form-change-status-avail-{{ $p->id }}" action="reload-no-avail"></span>
                </label>
            </form>
        </td>
        <td scope="col" class="text-center align-middle" id="status-table-product-{{$p->id}}">
            @include('provider.company.product.layouts.layouts.statusProductBlock')
        </td>
        <td scope="col" class="text-center align-middle">

            @include('provider.company.product.layouts.layouts.dropdownButtonsMenu')

        </td>
    </tr>

    @empty

    <tr>
        <td scope="col" colspan="9" class="text-center">Товары не найдены</td>
    </tr>
@endforelse
    <tr>
        <td scope="col" colspan="9" class="text-center container-fluid all-products-pagination" all-product-current-page="{{ $products->currentPage() }}" type="1">{{ $products->links() }}</td>
    </tr>
