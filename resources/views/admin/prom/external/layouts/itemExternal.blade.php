<td class="font-weight-bold">
    {{ $external->id }}
</td>
<td class="font-weight-bold">
    {{ $external->company->name }}
</td>
<td class="font-weight-bold">
    {{(new Date($external->created_at))->format('j F Y (H:i)')}}
</td>
<td class="font-weight-bold">
    @if($external->is_unload == '0')
        <span class="badge badge-secondary">Новый</span>
    @else
        <span class="badge badge-success">Загружен</span>
    @endif
</td>
<td class="font-weight-bold">
    <a href="{{ $external->unload_url }}" target="_blank" title="Посмотреть YML файл" class="text-info"><i class="fa fa-search" aria-hidden="true"></i></a>
    @if($external->is_unload == '0')
        <a href="{{ asset('admin/prom/externals/'.$external->id) }}" title="Распарсить YML файл" data-action="parsing" class="text-success action-external"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
    @else
        @if(!Auth::user()->isSuperAdmin())
            <a href="{{ asset('admin/prom/externals/'.$external->id) }}" data-action="reparsing" class="text-success action-external"><i class="fa fa-refresh" aria-hidden="true"></i></a>
        @endif
    @endif

</td>
