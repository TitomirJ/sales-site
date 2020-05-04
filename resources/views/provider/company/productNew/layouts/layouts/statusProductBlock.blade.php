
@if($p->deleted_at != null)
    <i class="fa fa-ban text-danger" aria-hidden="true"></i>
    Удален
@elseif($p->status_available == '0' && $p->status_spacial == '1')
    <i class="fa fa-shopping-basket text-danger" aria-hidden="true"></i>
    Выведен с маркетплеса
@elseif($p->status_spacial == '1')
    @if($p->status_moderation == '0')
        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
        На модерации
    @elseif($p->status_moderation == '1')
        <i class="fa fa-shopping-basket green-text" aria-hidden="true"></i>
        отправлен на маркетплейс
    @elseif($p->status_moderation == '2')
        <a href="{{ asset('company/products/'.$p->id) }}">
            <i class="fa fa-shopping-basket text-warning" aria-hidden="true"></i>
            Некорректный контент
        </a>
    @elseif($p->status_moderation == '3')
        <a href="{{ asset('company/products/'.$p->id) }}">
        <i class="fa fa-shopping-basket text-danger" aria-hidden="true"></i>
        Заблокирован
        </a>
    @endif
@elseif($p->status_spacial == '0')
    @if($company->block_bal == '1' && $company->block_new == '1')
        <div class="dropdown d-inline-block">
            <button class="btn-trans dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-question-circle-o  text-danger" aria-hidden="true"></i>
            </button>
            <div class="dropdown-menu border-radius border-0 p-1">
                <p style="font-size: 10px;">Что бы отправить товары на модерацию и на маркетплейсы необходимо: <br>1) <a href="{{asset('company/balance')}}">Пополнить абонимент</a>; <br>2) <a href="{{asset('company/balance')}}">Депозит должен быть больше {{$company->balance_limit}} грн.</a></p>
            </div>
        </div>
        Не модерируется
    @elseif($company->block_bal == '0' && $company->block_new == '1')
        <div class="dropdown d-inline-block">
            <button class="btn-trans dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-question-circle-o  text-danger" aria-hidden="true"></i>
            </button>
            <div class="dropdown-menu border-radius border-0 p-1">
                <p style="font-size: 10px;">Что бы отправить товары на модерацию и на маркетплейсы необходимо: <br>1) <a href="{{asset('company/balance')}}">Пополнить абонимент</a>;</p>
            </div>
        </div>
        Не модерируется
    @elseif($company->block_bal == '1' && $company->block_new == '0')
        <div class="dropdown d-inline-block">
            <button class="btn-trans dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-question-circle-o  text-danger" aria-hidden="true"></i>
            </button>
            <div class="dropdown-menu border-radius border-0 p-1">
                <p style="font-size: 10px;">Депозит компании ниже установленного лимита {{$company->balance_limit}} грн., товар выведен с маркетплейсов. <br> <a href="{{asset('company/balance')}}">Пополнить депозит</a></p>
            </div>
        </div>
        Выведен с маркетплеса
    @endif
@endif