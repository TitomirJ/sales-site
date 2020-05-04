<div class="modal fade pr-0" id="regModalWelcome" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <a href="" class="button-close close-modal-reg text-white position-absolute"><i class="fas fa-times fa-2x"></i></a>
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content border-0 reg-modal">



            <div class="modal-body">

                <h3 class="text-center text-white pb-2">Регистрация</h3>

                <form method="POST" action="{{ route('register') }}" id="formRegist">
                    {{ csrf_field() }}
                    <div class="form-group text-white">
                        <input type="email" class="form-control" id="reg-email" placeholder="Введите почту" name="email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group text-white">
                        <input type="text" class="mask-tel form-control" id="reg-phone" placeholder="Введите телефон" name="phone" value="{{ old('phone') }}" required autofocus>
                    </div>

                    <div class="d-flex text-white">
                        <input type="checkbox" id="agree" style="width: 50px;">
                        <label for="agree" class="pl-3">
                            Вы подтверждаете, что ознакомлены и принимаете условия использования платформы, закрепленные в
                            <a href="{{asset('/public/documents/dogovirBigSales.pdf')}}">договоре</a>.<br>
                            Я подтверждаю своё совершеннолетие и ответственность за размещение объявления
                        </label>
                    </div>
                    <div class="text-danger d-none agree-text">
                        Необходимо подтвердить ваше согласие
                    </div>

                    <button type="submit" class="btn btn-form btn-primary btn-lg w-100" id="btn-registration">Зарегистрироваться</button>
                </form>

                <p class="text-center text-white mt-3">Уже есть аккаунт на BigSales?
                    @if (Request::path() == 'login')
                        <a href="" class="close-modal-reg">Войти</a>
                    @else
                        <a href="{{ asset('/login') }}" class="">Войти</a>
                    @endif

                </p>



                <p class="text-center text-white">Перед регистрацией советуем ознакомиться с<br>
                    <a href="{{asset ('/privacy')}}" target="_blank">Политикой конфиденциальности</a><br>
                    <a href="{{asset ('/agreement')}}" target="_blank">Пользовательское соглашение</a>
                </p>


            </div>
        </div>
    </div>
</div>
