@forelse($companies as $c)
    <tr class="text-center bor-bottom item-company">
        <td class="font-weight-bold border-left">
            <a href="{{asset('/admin/company/'.$c->id)}}">{{$c->name}}</a>
        </td>
        <td class="font-weight-bold">
            @include('admin.company.layouts.indexCompany.onlineIndicatorCompany')
        </td>
        @if(Auth::user()->isAdmin())
            <td class="font-weight-bold">
                <a href="tel:{{$c->responsible_phone}}">{{$c->responsible_phone}}</a>
            </td>
        @endif
        <td class="font-weight-bold">
            @include('admin.company.layouts.indexCompany.statusCompany')
        </td>
        <td class="font-weight-bold">
            @include('admin.company.layouts.indexCompany.balanceCompany')
        </td>
        <td class="font-weight-bold">
            @include('admin.company.layouts.indexCompany.countProductsCompany')
        </td>
        <td class="font-weight-bold">
            @include('admin.company.layouts.indexCompany.countOrdersCompany')
        </td>
        @if(Auth::user()->isAdmin())
            <td class="font-weight-bold border-right">
                @include('admin.company.layouts.indexCompany.actionButtons')
            </td>
        @endif
    </tr>
@empty
    @if(Auth::user()->isAdmin())
        <tr class="text-center bor-bottom item-company">
            <td colspan="8" class="font-weight-bold border-left border-right">
                компании не найдены
            </td>
        </tr>
    @else
        <tr class="text-center bor-bottom item-company">
            <td colspan="7" class="font-weight-bold border-left border-right">
                компании не найдены
            </td>
        </tr>
    @endif
@endforelse
@if(Auth::user()->isAdmin())
    <tr class="text-center bor-bottom item-company">
        <td colspan="8" class="font-weight-bold border-left">
            {{$companies->links()}}
        </td>
    </tr>
@else
    <tr class="text-center bor-bottom item-company">
        <td colspan="7" class="font-weight-bold border-left">
            {{$companies->links()}}
        </td>
    </tr>
@endif
