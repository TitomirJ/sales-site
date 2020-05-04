<div class="dropdown">
    <button class="btn-trans dropdown-toggle f36" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
    </button>
    <div class="dropdown-menu border-radius border-0 text-lowercase shadow-custom">
        <a href="{{ asset('admin/company/'.$warning->company_id.'/warnings/modal/show') }}" class="dropdown-item font-weight-bold drop-menu-actions admin-moder-com-button" data-type="ignor" data-warning="{{$warning->id}}">игнорировать</a>
        <a href="{{ asset('admin/company/'.$warning->company_id.'/warnings/modal/show') }}" class="dropdown-item font-weight-bold drop-menu-actions admin-moder-com-button" data-type="block" data-warning="{{$warning->id}}">заблокировать</a>
    </div>
</div>
