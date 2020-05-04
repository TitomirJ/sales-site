@if($company->rozetka_on == '1')
    @if($p->rozetka_on == '1')
        <span class="badge badge-pill badge-r-{{$p->id}}" style="background-color: #00a046; color: white;">R</span>
    @else
        <span class="badge badge-pill badge-r-{{$p->id}}" style="background-color: #00a046; color: white; display: none;">R</span>
    @endif
@endif

@if($company->prom_on == '1')
    @if($p->prom_on == '1')
        <span class="badge badge-pill badge-p-{{$p->id}}" style="background-color: #53499D; color: white;">P</span>
    @else
        <span class="badge badge-pill badge-p-{{$p->id}}" style="background-color: #53499D; color: white; display: none;">P</span>
    @endif
@endif

@if($company->zakupka_on == '1')
    @if($p->zakupka_on == '1')
        <span class="badge badge-pill badge-z-{{$p->id}}" style="background-color: #E1001A; color: white;">Z</span>
    @else
        <span class="badge badge-pill badge-z-{{$p->id}}" style="background-color: #E1001A; color: white; display: none;">Z</span>
    @endif
@endif