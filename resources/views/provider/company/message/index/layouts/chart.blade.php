<input type="hidden" name="page" value="{{ $charts->currentPage() }}" form="group-charts-actions">
<input type="hidden" name="type" value="{{ $type_subpage }}" form="group-charts-actions">
@forelse($charts as  $chart)
    <tr class="bor-bottom" id="col-chart-{{$chart->id}}">
        @include('provider.company.message.index.layouts.layouts.chartItem')
    </tr>
@empty
    <tr>
        <td scope="col" colspan="6" class="text-center">Сообщения не найдены</td>
    </tr>
@endforelse
<tr>
    <td scope="col" colspan="6" class="text-center pagination-block" data-page="{{ $charts->currentPage() }}" data-type="{{ $type_subpage }}">{{ $charts->links() }}</td>
</tr>