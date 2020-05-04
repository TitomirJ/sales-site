<div class="table-responsive">
    <table class="table position-relative table-prom-pro-all">
        <thead>
        <tr class="tb-head text-uppercase blue-d-t text-center">
            <th scope="col" class="h-60">
                <div class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link text-nowrap">
                    изображения
                </div>
            </th>
            <th scope="col" class="h-60">
                <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                    найменование
                </div>
            </th>
            <th scope="col" class="h-60">
                <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                    категория(BigSales)
                </div>
            </th>
            <th scope="col" class="h-60">
                <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                    id товара
                </div>
            </th>
            <th scope="col" class="h-60">
                <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                    модерация
                </div>
            </th>
            <th scope="col" class="h-60">
                <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap radius-top-right border-right">
                    статус
                </div>
            </th>
        </tr>
        </thead>

        <tbody id="product-place" class="table-bg">

        @forelse($products as $product)
            <tr class="text-center bor-bottom item-pro-{{ $product->id }}">
                <td class="font-weight-bold">
                    <?$json_array_image = json_decode($product->gallery);?>
                    @foreach ($json_array_image as $image)
                        <img src="{{ $image->public_path }}" width="50">
                    @endforeach
                </td>
                <td class="font-weight-bold">
                    {{ $product->name }}
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
                    <a href="{{ asset('admin/moderation/products/'.$product->product_id) }}">{{ $product->product_id }} <i class="fa fa-search" aria-hidden="true"></i></a>
                </td>
                <td class="font-weight-bold">
                    @if($product->product->status_moderation == '0')
                        <span class="badge badge-secondary">на модерации</span>
                    @elseif($product->product->status_moderation == '1')
                        <span class="badge badge-success">прошел модерацию</span>
                    @elseif($product->product->status_moderation == '2')
                        <span class="badge badge-warning">на доработке</span>
                    @elseif($product->product->status_moderation == '3')
                        <span class="badge badge-danger">заблокирован</span>
                    @endif
                </td>
                <td class="font-weight-bold">
                    @if( $product->confirm == '3')
                        <span class="badge badge-success">создан</span>
                    @endif
                </td>

            </tr>

        @empty
            <tr>
                <td colspan="7" class="text-center" >товары отсутствуют</td>
            </tr>
        @endforelse

        </tbody>
    </table>

    {{ $products->links() }}
</div>
