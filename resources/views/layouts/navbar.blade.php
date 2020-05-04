<div class="hidden"></div>
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light mb-2 bg-white">

    <div class="container mt-3 mb-3">

        <a class="navbar-brand ml-5" href="{{asset('/')}}" style="z-index: 1;">
            <img src="{{ asset('/public/images/logo.png') }}" width="159px" height="52px" alt="logo">
        </a>

        <button class="navbar-toggler mb-2" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="z-index: 2;">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-5 d-flex align-items-center font-weight-bold text-uppercase font-medium pt-1">

                <li class="nav-item mr-2 pt-1 text-nowrap">
                    <a class="nav-link scroll-base" href="" myattr="scroll1-item">Как мы работаем</a>
                </li>
                <li class="nav-item mr-2 pt-1 text-nowrap">
                    <a class="nav-link scroll-base" href="" myattr="scroll2-item">Кому подойдет</a>
                </li>
                <li class="nav-item mr-2 pt-1 text-nowrap">
                    <a class="nav-link scroll-base" href="" myattr="scroll3-item">Отзывы партнеров</a>
                </li>
                <li class="nav-item mr-2 pt-1 text-nowrap">
                    <a class="nav-link" href="{{asset('/about')}}">О нас</a>
                </li>

                @if(Auth::guest())
                    <a href="{{ asset('/login') }}" class="btn btn-primary  btn-custom btn-login text-white text-uppercase font-weight-light d-block d-lg-none d-xl-block">Авторизация</a>
                    <a href="{{ asset('/login') }}" class="btn btn-primary  btn-custom btn-login text-white text-uppercase font-weight-light d-none d-lg-block d-xl-none">
                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                    </a>

                    <a href="#" class="action-reg-modal text-white btn btn-primary  btn-register btn-custom font-weight-light d-block d-lg-none d-xl-block">Начать</a>
                    <a href="#" class="action-reg-modal text-white btn btn-primary  btn-register btn-custom font-weight-light d-none d-lg-block d-xl-none">
                        <i class="fas fa-sign-in-alt"></i>
                    </a>
                @else
                    @if(Auth::user()->isProvider())
                        <a class="btn btn-primary btn-login btn-custom text-white font-weight-light" href="{{asset('/company')}}">
                            <span>кабинет</span>
                        </a>
                    @elseif(Auth::user()->isAdminOrModerator())
                        <a class="btn btn-primary btn-login btn-custom text-white font-weight-light" href="{{asset('/admin')}}">
                            <span>кабинет</span>
                        </a>
                    @else
                        <a class="btn btn-primary btn-login btn-custom text-white font-weight-light" href="{{asset('/welcome')}}">
                            <span>кабинет</span>
                        </a>
                    @endif
                    <a class="btn btn-primary  btn-login btn-custom text-white font-weight-light d-block d-lg-none d-xl-block" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Выйти
                    </a>

                    <a class="btn btn-primary  btn-login btn-custom text-white font-weight-light d-none d-lg-block d-xl-none" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-in-alt"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        {{ csrf_field() }}
                    </form>
                @endif
            </ul>
        </div>

    </div>

</nav>

