@forelse($products_all as $p)
    <tr>
        <td scope="col" class="text-center align-middle">{{$p->id}}</td>
        <td scope="col" class="text-center align-middle">{{$p->code}}</td>
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

                @if($p->status_moderation == '0')
                <i class="fa fa-circle text-secondary" aria-hidden="true"></i>
                @elseif($p->status_moderation == '1')
                <i class="fa fa-circle text-success" aria-hidden="true"></i>
                @elseif($p->status_moderation == '2')
                <i class="fa fa-circle  text-warning" aria-hidden="true"></i>
                @elseif($p->status_moderation == '3')
                <i class="fa fa-circle text-danger" aria-hidden="true"></i>
                @endif
                    &nbsp;
                @if($p->status_available == '0')
                <i class="fa fa-circle text-danger" aria-hidden="true"></i>
                @else
                <i class="fa fa-circle text-success" aria-hidden="true"></i>
                @endif
                    &nbsp;
                @if($p->status_spacial == '0')
                <i class="fa fa-circle text-danger" aria-hidden="true"></i>
                @else
                <i class="fa fa-circle text-success" aria-hidden="true"></i>
                @endif

        </td>
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
        <td scope="col" colspan="11" class="text-center">Товары не найдены</td>
    </tr>
@endforelse
<tr>
    <td scope="col" colspan="11" class="text-center products-pagination" data-currentPage="{{ $products_all->currentPage() }}" data-type="3">{{ $products_all->links() }}</td>
</tr>