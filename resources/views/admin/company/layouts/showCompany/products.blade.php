@forelse($products as $p)
    <tr class="bor-bottom">
        <td scope="col" class="text-center align-middle">
            <div class="wrapper-checkbox">
                <input type="checkbox" name="product_id[]" value="{{$p->id}}" id="true-{{$p->id}}" class="css-checkbox form-check-input" form="group-product-actions">
                <label for="true-{{$p->id}}" class="form-check-label css-label radGroup1"></label>
            </div>
        </td>

        <td scope="col" class="text-center align-middle">
            {{ $p->id }}
        </td>
        <?
        $gallery_array = json_decode($p->gallery);
        ?>
        <td scope="col" class="text-center align-middle">
            <div>
                @if(count($gallery_array) > 0)
                    <img src="{{$gallery_array[0]->public_path}}" alt="{{$p->name}}" style="max-width: 70px;">
                @endif
            </div>
        </td>
        <td scope="col" class="text-center align-middle">
            <a href="{{ asset('admin/moderation/products/'.$p->id) }}">{{$p->name}}</a>
        </td>

        <?
        if($p->rozetka_data != null){
            $rozetka_data = json_decode($p->rozetka_data);
            $rozetka_link = $rozetka_data->url;
        }
        ?>

        <td scope="col" class="text-center align-middle">
            @if($p->rozetka_data != null)
                <a class="badge badge-pill badge-success" href="{{ $rozetka_link }}" target="_blank" title="Посмотреть товар на Розетке">Rozetka</a>
            @else
                <span class="badge badge-pill badge-secondary">Нет ссылки</span>
            @endif
        </td>

        <td scope="col" class="text-center align-middle">
            {{$p->subcategory->name}}
        </td>

        <td scope="col" class="text-center align-middle">
            {{$p->price}} грн
        </td>
        <td scope="col" class="text-center align-middle">
            {{$p->subcategory->commission}}%
        </td>

        <td scope="col" class="text-center align-middle">
            <form class="form-change-status-avail" action="{{ asset('admin/product/'.$p->id.'/change_avail') }}" method="POST">
                {{ csrf_field() }}
                <label class="switch mb-0">
                    <input type="checkbox" class="change-avail-admin" {{ ($p->status_available == 1)? 'checked': '' }} id="prop-p-checkbox-{{$p->id}}">
                    <span class="slider round change-avail-btn"></span>
                </label>
            </form>
        </td>

        <td scope="col" class="text-center align-middle">
            @include('/admin/company/layouts/showCompany/statusProduct')
        </td>
        <td scope="col" class="text-center align-middle">
            @include('/admin/company/layouts/showCompany/statusMarket')
        </td>
        <td scope="col" class="text-center align-middle">
            {{(new Date($p->updated_at))->format('j F Y (H:i)')}}
        </td>
        <td scope="col" class="text-center align-middle">
            {{$p->orders->count()}}
            @if(Auth::user()->isSuperAdmin())
                <a href="{{ asset('admin/product/'.$p->id.'/forcedelete') }}" class="ml-3 confirm-modal" text="Данная функция удаляет товар безвозвратно, ты уверен?">
                    <i class="fa fa-times text-danger" aria-hidden="true" style="transform: scale(1.2);"></i>
                </a>
            @endif
        </td>
    </tr>

@empty
    <tr>
        <td scope="col" colspan="12" class="text-center">Товары не найдены</td>
    </tr>
@endforelse
<tr>
    <td scope="col" colspan="12" class="text-center pagination-block" data-type="products">{{ $products->links() }}</td>
</tr>
