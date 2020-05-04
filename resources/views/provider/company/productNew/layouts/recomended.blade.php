<tr class="font-weight-bold bor-bottom">
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
            статус
        </div>
    </td>
    <td scope="col" class="align-middle">
        <div class="d-block text-center text-uppercase text-nowrap">
            замечание
        </div>
    </td>
    <td scope="col" class="align-middle">
        <div class="d-block text-center text-uppercase text-nowrap">
            действие
        </div>
    </td>
</tr>
@forelse($products_nomoder as $p)
    <tr class="bor-bottom" id="nomoder-item-{{$p->id}}">
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
        <td scope="col" class="text-center align-middle" id="status-table-product-{{$p->id}}">
            @include('provider.company.product.layouts.layouts.statusProductBlock')
        </td>
            <?
                $text_error = json_decode($p->data_error);
            ?>
        <td scope="col" class="text-center align-middle" id="status-table-product-{{$p->id}}">
            <a href="{{ asset('company/products/'.$p->id) }}">{!! $text_error->short_error !!}<i class="fa fa-exclamation text-danger"></i></a>
        </td>
        <td scope="col" class="text-center align-middle">

            @include("provider.company.product.layouts.layouts.dropdownButtonsMenu")

        </td>
    </tr>

@empty

    <tr>
        <td scope="col" colspan="9" class="text-center">Товары не найдены</td>
    </tr>
@endforelse
<tr>
    <td scope="col" colspan="9" class="text-center container-fluid all-products-pagination" all-product-current-page="{{ $products_nomoder->currentPage() }}" type="1">{{ $products_nomoder->links() }}</td>
</tr>
