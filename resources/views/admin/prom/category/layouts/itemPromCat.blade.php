<?
        $count_products = $prom_cat->promProducts->count();
?>
<td class="font-weight-bold">
    {{ $prom_cat->id }}
</td>
<td class="font-weight-bold">
        {{ $prom_cat->external->company->name }}
</td>
<td class="font-weight-bold">
    {{ $prom_cat->name }}
</td>
<td class="font-weight-bold">
       {{ $count_products }}
</td>
<td class="font-weight-bold">
@if($count_products == 0)
                {{--<form action="{{ asset('admin/prom/categories/'. $prom_cat->id) }}" method="post">--}}
                        {{--{{ csrf_field() }}--}}
                        {{--{{ method_field('DELETE') }}--}}
                        {{--<button type="submit"><i class="fa fa-times-circle text-danger fa-2x" aria-hidden="true" style="float: right;"></i></button>--}}
                {{--</form>--}}
@else
        @if($prom_cat->subcategory_id == null)
                <a href="{{ asset('admin/prom/categories/'.$prom_cat->id.'/edit') }}" class="text-info search-our-subcat"><i class="fa fa-plus-square-o fa-2x toggle-siner" aria-hidden="true"></i></a>
        @else
                @if(Auth::user()->isSuperAdmin())
                        <a href="{{ asset('admin/prom/categories/'.$prom_cat->id.'/edit') }}" class="search-our-subcat">{{ $prom_cat->subcategory['name'] }} <i class="fa fa-pencil text-warning" aria-hidden="true"></i></a>
                @else
                        {{ $prom_cat->subcategory['name'] }}
                @endif
        @endif
@endif
</td>