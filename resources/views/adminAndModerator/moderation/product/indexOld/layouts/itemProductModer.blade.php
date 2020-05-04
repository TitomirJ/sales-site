@forelse($products_moder as $p)
    <tr>
        <td scope="col" class="text-center align-middle">{{$p->company->name}}</td>
        <?
        $gallery_array = json_decode($p->gallery);
        ?>
        <td scope="col" class="text-center align-middle">
            <div>
                <img src="{{$gallery_array[0]->public_path}}" alt="{{$p->name}}" style="max-width: 70px;">
            </div>
        </td>
        <td scope="col" class="text-center align-middle">{{$p->name}}</td>
        <td scope="col" class="text-center align-middle">{{ $p->category->name }}</td>
        <td scope="col" class="text-center align-middle">{{$p->subcategory->name}}</td>
        <td scope="col" class="text-center align-middle">{{$p->subcategory->commission}} %</td>
        <td scope="col" class="text-center align-middle">
            {{(new Date($p->updated_at))->format('j F Y (H:i)')}}
            <br>
            @if($p->status_remod == '0')
                <i class="fa fa-check-circle-o text-success" aria-hidden="true"></i> Не редактировался
            @elseif($p->status_remod == '1')
                <i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> Внесены изменения
            @endif
        </td>

        <td scope="col" class="text-center align-middle">

            <button class="btn-trans f36" type="button">
                <a href="{{ asset('admin/moderation/products/'.$p->id) }}" class="text-warning font-weight-bold"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
            </button>

        </td>
    </tr>

@empty

    <tr>
        <td scope="col" colspan="8" class="text-center">Товары не найдены</td>
    </tr>
@endforelse
<tr>
    <td scope="col" colspan="8" class="text-center products-pagination" data-currentPage="{{ $products_moder->currentPage() }}" data-type="1">{{ $products_moder->links() }}</td>
</tr>