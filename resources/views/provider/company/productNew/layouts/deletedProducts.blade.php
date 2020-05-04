<tr class="font-weight-bold bor-bottom">
    <td scope="col" class="align-middle">
        <div class="d-block text-center text-nowrap dark-link">
            <div class="wrapper-checkbox">
                <input type="checkbox" class="css-checkbox" id="click-all-deleted-product">
                <label for="click-all-deleted-product" class="css-label radGroup1"></label>
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
@forelse($deleted_products as $p)

    <tr>
        <td scope="col" class="text-center align-middle">
            <div class="wrapper-checkbox">
                <input type="checkbox"  form="action-form-deleted-product" name="product_id[]" value="{{$p->id}}" id="deleted-p-{{$p->id}}" class="css-checkbox form-check-input">
                <label for="deleted-p-{{$p->id}}" class="form-check-label css-label radGroup1"></label>
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

                {{--Иконки в наличии или нет--}}
                {{--@if($p->status_available == 1)--}}
                {{--<i class="fa fa-check-circle" aria-hidden="true" style="color:#1ebc01;"></i>--}}
                {{--@else--}}
                {{--<i class="fa fa-times-circle" aria-hidden="true" style="color:#dc3545;"></i>--}}
                {{--@endif--}}
            </div>
        </td>
        <td scope="col" class="text-center align-middle">
            <i class="fa fa-ban text-danger" aria-hidden="true"></i>
            Удален
        </td>
        <td scope="col" class="text-center align-middle">
            @include('provider.company.product.layouts.layouts.statusProductBlock')
        </td>
        <td scope="col" class="text-center align-middle">

            @include("provider.company.product.layouts.layouts.dropdownButtonsMenu")

        </td>
    </tr>

@empty
    <tr>
        <td scope="col" colspan="8" class="text-center">Товары не найдены</td>
    </tr>
@endforelse
<tr>
    <td scope="col" colspan="8" class="text-center container-fluid deleted-products-pagination"   deleted-product-current-page="{{ $deleted_products->currentPage() }}" type="4">{{ $deleted_products->links() }}</td>
</tr>





