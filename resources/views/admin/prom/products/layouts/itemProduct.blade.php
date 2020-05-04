<td class="font-weight-bold">
    <a href="{{ asset('admin/company/'.$product->external->company->id) }}">{{ $product->external->company->name }}</a>
</td>
<td class="font-weight-bold">
    @if($product->gallery == '' || $product->gallery == null || $product->gallery == '1')
    @else
    <?$json_array_image = json_decode($product->gallery);?>
    @foreach ($json_array_image as $image)
        <img src="{{ $image->public_path }}" width="50">
    @endforeach
    @endif
</td>
<td class="font-weight-bold">
    {{ $product->name }} {{ $product->id }}
</td>
<td class="font-weight-bold">
    @if(isset($product->promCat()[0]))
        {{ $product->promCat()[0]->name }}
    @else
        <i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i> отсутсвует категория
    @endif
</td>
<td class="font-weight-bold">
    @if(isset($product->promCat()[0]))
        @if($product->promCat()[0]->subcategory_id == null)
            <a href="{{ asset('admin/prom/categories/'.$product->promCat()[0]->id.'/edit') }}" class="text-info search-our-subcat"><i class="fa fa-plus-square-o fa-2x toggle-siner" aria-hidden="true"></i></a>
        @else
            {{ $product->promCat()[0]->subcategory['name'] }}
        @endif
    @else
        <i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i> отсутсвует категория
    @endif
</td>
<td class="font-weight-bold">
    @if($product->externalHasError())
        @if($product->data_error != null)
            <?$errors = json_decode($product->data_error)?>
            <span>Ко-во ошибок: <span class="text-danger">{{ count($errors) }}</span></span>
        @else
            @if($product->confirm == '0' || $product->confirm == '1')
                ожидает проверки
            @else
                ошибок нет
            @endif
        @endif
    @endif

</td>
<td class="font-weight-bold">

    @if( $product->confirm == '0')
        <span class="badge badge-secondary">не привязан</span>
    @elseif($product->confirm == '1')
        <span class="badge badge-info">проверяется</span>
    @elseif($product->confirm == '2')
        <span class="badge badge-primary">проверен</span>
    @elseif($product->confirm == '3')
        <span class="badge badge-success">создан</span>
    @elseif($product->confirm == '4')
        <a href="{{ asset('admin/prom/external/'.$product->external_id.'/products?type=4') }}"><span class="badge badge-danger">есть ошибки</span></a>
    @endif

</td>