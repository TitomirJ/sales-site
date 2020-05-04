@if(!Auth::guest())
    @if(Auth::user()->isProvider())
        <div class="block-fix"></div>
      @if(Auth::user()->company->block_new == '1')

      <div class="content-wrapper1">
          <div class="container-fluid">
            <div class="alert alert-danger" role="alert">
              {{ Auth::user()->company->name.' '}}находится на "Пробном периоде"
              до {{ ' '.Auth::user()->company->ab_to}}. Данный период предназначен для ознакомления с функционалом сайта,
              в это время созданные товары не проходят модерацию и не отправляются на маркетплейсы.
              Для запуска полного функционала сайта необходимо пополнить депозит и абонплату.
            </div>
          </div>
      </div>
      @endif
      @if(Auth::user()->company->block_bal == '1' && Auth::user()->company->block_new == '0')
      <div class="content-wrapper1">
          <div class="container-fluid">
            <div class="alert alert-danger" role="alert">
              Функционал сайта ограничен по причине снижения депозита компании ниже установленного минимума -
              {{' '.Auth::user()->company->balance_limit.' грн.' }}!
              <a href="{{asset('/company/balance')}}">пополнить депозит</a>
            </div>
          </div>
      </div>
      @endif
      @if(Auth::user()->company->block_ab == '1' && Auth::user()->company->block_new == '0')
      <div class="content-wrapper1">
          <div class="container-fluid">
            <div class="alert alert-danger" role="alert">
              Срок абонплаты истек{{' '.Auth::user()->company->ab_to }},
              ваша учетная запись заблокирована, а товары выведены с маркетплейсов до пополнения абонплаты.
              <a href="{{asset('/company/balance')}}">пополнить абонплату</a>
            </div>
          </div>
      </div>
      @endif
    @endif
@endif
