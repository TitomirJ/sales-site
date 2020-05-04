@forelse($companies as $company)
    @foreach($company->externals as $external)
        <tr class="text-center bor-bottom item-com-ext-{{ $company->id }}">
            <td>
                <a href="{{ asset('admin/company/'.$company->id) }}">{{ $company->name }}</a>
            </td>
            <td>
                {{(new Date($external->created_at))->format('j F Y (H:i:s)')}}
                <a href="{{ $external->unload_url }}" target="_blank" title="Просмотреть ссылку"> <i class="fa fa-search" aria-hidden="true"></i></a>
            </td>
            <td>
                @if($external->is_unload == '0')
                    <span class="badge badge-secondary">не подготовлен</span>
                @elseif($external->is_unload == '1')
                    <span class="badge badge-success">подготовлен</span>
                @elseif($external->is_unload == '2')
                    <span class="badge badge-info">на проверке</span>
                @elseif($external->is_unload == '3')
                    <span class="badge badge-danger">не прошел проверку</span>
                @endif
            </td>
            <td>
                @if($external->promCategories->count() > 0)
                    <?
                    $count_cats_not_link = $external->countNotLinkCats();
                    $count_cats_link = $external->countLinkCats();
                    ?>
                    <div class="dropdown">
                        <button class="btn-trans dropdown-toggle font-weight-bold" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $external->promCategories->count() }}<br>
                            ( <span class="text-success">{{ $count_cats_link }}</span> -
                            <span class="text-danger">{{  $count_cats_not_link }}</span> )
                        </button>
                        <div class="dropdown-menu border-radius border-0 shadow-custom">
                            <a  href="{{ asset('admin/prom/external/'.$external->id.'/categories') }}" class="dropdown-item font-weight-bold drop-menu-actions">посмотеть все</a>

                            <a href="{{ asset('admin/prom/external/'.$external->id.'/categories?type=link') }}" class="dropdown-item drop-menu-actions"><span class="badge badge-success">{{ $count_cats_link }}</span>  Привязано</a>
                            <a  href="{{ asset('admin/prom/external/'.$external->id.'/categories?type=nolink') }}" class="dropdown-item drop-menu-actions"><span class="badge badge-danger">{{ $count_cats_not_link }}</span>  Не привязано</a>
                        </div>
                    </div>
                @else
                    @if($external->is_unload == '0')
                        <span class="badge badge-warning">Еще не загружены</span>
                    @else
                        <span class="badge badge-danger">Категории отсутствуют</span>
                    @endif
                @endif
            </td>
            <td>
                @if($external->promProducts->count() > 0)
                    <? $array_info_products = $external->countInfoArrayProducts(); ?>
                    <div class="dropdown">
                        <button class="btn-trans dropdown-toggle font-weight-bold" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $external->promProducts->count() }}<br>
                            ( <span class="text-secondary">{{ $array_info_products['new'] }}</span> -
                            <span class="text-info">{{ $array_info_products['link'] }}</span> -
                            <span class="text-primary">{{ $array_info_products['checked'] }}</span> -
                            <span class="text-success">{{ $array_info_products['created'] }}</span> -
                            <span class="text-danger">{{  $array_info_products['error'] }}</span> )
                        </button>
                        <div class="dropdown-menu border-radius border-0 shadow-custom">
                            <a  href="{{ asset('admin/prom/external/'.$external->id.'/products?type=all') }}" class="dropdown-item font-weight-bold drop-menu-actions">посмотеть все</a>
                            <a href="{{ asset('admin/prom/external/'.$external->id.'/products?type=0') }}" class="dropdown-item drop-menu-actions"><span class="badge badge-secondary">{{ $array_info_products['new'] }}</span>  Не обработаны</a>
                            <a href="{{ asset('admin/prom/external/'.$external->id.'/products?type=1') }}" class="dropdown-item drop-menu-actions"><span class="badge badge-info">{{ $array_info_products['link'] }}</span>  Привязано</a>
                            <a href="{{ asset('admin/prom/external/'.$external->id.'/products?type=2') }}" class="dropdown-item drop-menu-actions"><span class="badge badge-primary">{{ $array_info_products['checked'] }}</span>  Проверены</a>
                            <a href="{{ asset('admin/prom/external/'.$external->id.'/products?type=3') }}" class="dropdown-item drop-menu-actions"><span class="badge badge-success">{{ $array_info_products['created'] }}</span>  Добавлено</a>
                            <a href="{{ asset('admin/prom/external/'.$external->id.'/products?type=4') }}" class="dropdown-item drop-menu-actions"><span class="badge badge-danger">{{  $array_info_products['error'] }}</span>  Допущены ошибки</a>
                        </div>
                    </div>
                @else
                    @if($external->is_unload == '0')
                        <span class="badge badge-warning">Еще не загружены</span>
                    @else
                        <span class="badge badge-danger">Товары отсутствуют</span>
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
@empty
    <tr>
        <td colspan="5" class="text-center" >ссылки отсутствуют</td>
    </tr>
@endforelse