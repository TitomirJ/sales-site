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
                    категория(YML)
                </div>
            </th>
            <th scope="col" class="h-60">
                <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                    категория(BigSales)
                </div>
            </th>
            <th scope="col" class="h-60">
                <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                    ошибки
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
                    @if($product->gallery == '' || $product->gallery == null)
                    @else
                        <?$json_array_image = json_decode($product->gallery);?>
                        @foreach ($json_array_image as $image)
                            <img src="{{ $image->public_path }}" width="50">
                        @endforeach
                    @endif
                </td>
                <td class="font-weight-bold">
                    {{ $product->name }}
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
                        <span class="badge badge-danger">есть ошибки</span>
                        <br>
                        <a href="{{ asset('admin/prom/product/'.$product->id.'/reupload') }}" class="text-success"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                    @endif

                </td>

            </tr>
            <?
            $errors_array = json_decode($product->data_error);
            ?>
            <tr class="promprod-item-{{$product->id}}" style="border-bottom: gray solid 2px;">
                <td colspan="6" class="p-0">
                    <div id="collapse{{$product->id}}" class="collapse show" aria-labelledby="heading{{$product->id}}" data-parent="#accordionExample">
                        <div class="card-body">
                            <h5 class="text-danger">Список ошибок:</h5>
                            <? $count=0;?>
                            @foreach($errors_array as $error)
                                <?$count++;?>
                                <p>{{ $count }}. {{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
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
