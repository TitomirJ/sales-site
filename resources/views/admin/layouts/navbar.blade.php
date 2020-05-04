<?php
    $counts_charts = \App\Http\Controllers\Rozetka\AdminChatsController::countNewMessagesForTypes();

?>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark dark-bg fixed-top" id="mainNav">
    <a class="navbar-brand logo-trans on-overlay-loader ml-lg-5 pl-lg-5 ml-0 pl-0" href="{{asset('/company')}}">
        {{--<img src="{{ asset('/public/images/logo_white3.png') }}" width="159px" height="42px" alt="logo">--}}
        <div class="wrapper-logotip position-relative d-flex text-uppercase font-weight-bold">
            <div class="white-block-logo bg-white"></div>
            <div class="big position-absolute">big</div>
            <div class="sales position-absolute text-white">sales</div>
        </div>
        <div class="logo-subtext"> продажи и маркетинг в одном сервисе</div>
    </a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav dark-bg" id="exampleAccordion" style="overflow: hidden; overflow-y: auto">


            <li class="nav-item border-top border-secondary hover-light" data-placement="right">
                <a class="nav-link d-lg-flex d-md-block align-items-center flex-column text-white on-overlay-loader pl-3" href="{{ asset('/admin') }}">
                    <i class="fa fa-tasks icon-zoom mt-3" aria-hidden="true"></i>
                    <span class="f11 text-center mt-2 ml-lg-0 ml-3">сводка</span>
                </a>
            </li>
            <li class="nav-item border-top border-secondary hover-light" data-placement="right">
                <a class="nav-link d-lg-flex d-md-block align-items-center flex-column text-white on-overlay-loader pl-3" href="{{asset('/admin/companies')}}">
                    <i class="fa fa-building icon-zoom mt-3"></i></i>
                    <span class="f11 text-center mt-3 ml-lg-0 ml-3">Компании</span>
                </a>
            </li>

            <li class="nav-item border-top border-bottom border-secondary hover-light" data-placement="right">
                <a class="nav-link d-lg-flex d-md-block align-items-center flex-column text-white on-overlay-loader pl-3" href="{{ asset('/admin/moderation/products') }}">
                    <i class="fa fa-cubes icon-zoom mt-3" aria-hidden="true"></i>
                    <span class="f11 text-center mt-3 ml-lg-0 ml-3">модерация товаров

                    </span>
                </a>
            </li>
            @if(Auth::user()->isAdmin())
            <li class="nav-item border-top border-bottom border-secondary hover-light" data-placement="right">
                <a class="nav-link d-lg-flex d-md-block align-items-center flex-column text-white on-overlay-loader pl-3" href="{{ asset('/admin/moderation/orders') }}">
                    <i class="fa fa-shopping-cart icon-zoom mt-3" aria-hidden="true"></i>
                    <span class="f11 text-center mt-3 ml-lg-0 ml-3">отмененные заказы</span>
                </a>
            </li>

            <li class="nav-item border-top border-secondary hover-light" data-placement="right">
                <a class="nav-link d-lg-flex d-md-block align-items-center flex-column text-white on-overlay-loader pl-3" href="{{ asset('/admin/prom') }}">
                    <i class="fa fa-file-code-o icon-zoom mt-3" aria-hidden="true"></i>
                    <span class="f11 text-center mt-3 ml-lg-0 ml-3">XML товары</span>
                </a>
            </li>

            <li class="nav-item border-top border-secondary hover-light" data-placement="right">
                <a class="nav-link d-lg-flex d-md-block align-items-center flex-column text-white on-overlay-loader pl-3" href="{{ asset('/admin/rozetka/chats?type=other') }}">
                    <i class="fa fa-comments icon-zoom mt-3" aria-hidden="true"></i>
                    <span class="f11 text-center mt-3 ml-lg-0 ml-3">Чаты</span>
					{{-- показ количества сообщений (апрель2020) --}}
                    <?php  $c=0;  ?>
                    @foreach($counts_charts as $mess)
                    <?php
                    if($mess > 0){
                        $c = $c+$mess;
                    } ?>
                    @endforeach
                    @if($c > 0)
                        <span class="badge badge-pill badge-danger">{{ $c }}</span>
                    @endif
                </a>
            </li>


            <li class="nav-item border-top border-secondary hover-light" data-placement="right">
                <a class="nav-link d-lg-flex d-md-block align-items-center flex-column text-white on-overlay-loader pl-3" href="{{ asset('/admin/companies/warnings') }}">
                    <i class="fa fa-ban icon-zoom mt-3" aria-hidden="true"></i>
                    <span class="f11 text-center mt-3 ml-lg-0 ml-3">замечания к компаниям</span>
                </a>
            </li>

			{{-- autoupdates info --}}
            @if((Auth::user()->isSuperAdmin()))
            <li class="nav-item border-top border-secondary hover-light" data-placement="right">
                <a class="nav-link d-lg-flex d-md-block align-items-center flex-column text-white on-overlay-loader pl-3" href="{{ asset('/admin/update_auto_info') }}">
                    <i class="fa fa-info-circle icon-zoom mt-3" aria-hidden="true"></i>
                    <span class="f11 text-center mt-3 ml-lg-0 ml-3">Отчет AUD</span>
                </a>
            </li>
            @endif
            {{-- end autoupdates info --}}

            @endif





        </ul>
        <ul class="navbar-nav ml-auto">

            {{-- кнопки просмотра уведомлений и сообщений--}}

            @if(!Auth::guest() && Auth::user()->isAdminOrModerator())
                {{--<li class="nav-item dropdown ">--}}
                    {{--<a class="nav-link dropdown-toggle mr-lg-2 text-white" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                        {{--<i class="fa fa-fw fa-envelope"></i>--}}
                        {{--<span class="d-lg-none">Messages--}}
                            {{--<span class="badge badge-pill badge-primary">12 New</span>--}}
                        {{--</span>--}}
                        {{--<span class="indicator text-primary d-none d-lg-block">--}}
                          {{--<i class="fa fa-fw fa-circle"></i>--}}
                        {{--</span>--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">--}}
                        {{--<h6 class="dropdown-header">New Messages:</h6>--}}
                        {{--<div class="dropdown-divider"></div>--}}
                        {{--<a class="dropdown-item" href="#">--}}
                            {{--<strong>David Miller</strong>--}}
                            {{--<span class="small float-right text-muted">11:21 AM</span>--}}
                            {{--<div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>--}}
                        {{--</a>--}}
                        {{--<div class="dropdown-divider"></div>--}}
                        {{--<a class="dropdown-item" href="#">--}}
                            {{--<strong>Jane Smith</strong>--}}
                            {{--<span class="small float-right text-muted">11:21 AM</span>--}}
                            {{--<div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00 instead of 4:00. Thanks!</div>--}}
                        {{--</a>--}}
                        {{--<div class="dropdown-divider"></div>--}}
                        {{--<a class="dropdown-item" href="#">--}}
                            {{--<strong>John Doe</strong>--}}
                            {{--<span class="small float-right text-muted">11:21 AM</span>--}}
                            {{--<div class="dropdown-message small">I've sent the final files over to you for review. When you're able to sign off of them let me know and we can discuss distribution.</div>--}}
                        {{--</a>--}}
                        {{--<div class="dropdown-divider"></div>--}}
                        {{--<a class="dropdown-item small" href="#">View all messages</a>--}}
                    {{--</div>--}}
                {{--</li>--}}

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle mr-lg-2 text-white" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-fw fa-bell"></i>
                        @if(Auth::user()->notifications->count() >= 1)
                            <span class="d-lg-none">Alerts
                              <span class="badge badge-pill badge-danger">{{ Auth::user()->notifications->count() }} New</span>
                            </span>
                            <span class="indicator text-danger d-none d-lg-block">
                              <i class="fa fa-fw fa-circle"></i>
                            </span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
                        @if(Auth::user()->notifications->count() >= 1)
                        <h6 class="dropdown-header">Новые уведомления:</h6>
                        @endif
                        @forelse(Auth::user()->notifications as $notification)
                            @include('admin.layouts.navbarNotification.admin_navbar_notify')
                        @empty
                            <h6 class="dropdown-header">Новых уведомлений нет</h6>
                        @endforelse
                    </div>
                </li>
            @endif

            <?//Мобильное нижнее меню?>
            <li class="nav-item d-block d-lg-none" data-placement="right">
                <a class="nav-link text-white pl-3" href="{{asset('/user/profile')}}"><i class="fa fa-address-card" aria-hidden="true"></i> Личный кабинет</a>
            </li>

            <li class="nav-item d-block d-lg-none" data-placement="right">
                @if(Auth::check())
                    @if(Auth::user()->isProviderAndDirector())
                        <a class="nav-link text-white pl-3" href="{{asset('/company/profile')}}"><i class="fa fa-building" aria-hidden="true"></i> Кабинет компании</a>
                    @endif
                @endif
            </li>






            <li class="nav-item d-block d-lg-none" data-placement="right">
                <a class="nav-link text-white pl-3" href="{{ asset('/admin/moderation/users') }}"><i class="fa fa-users" aria-hidden="true"></i> все пользователи</a>
            </li>

            @if(Auth::user()->isAdmin())

                <li class="nav-item d-block d-lg-none" data-placement="right">
                    <a class="nav-link text-white pl-3" href="{{ asset('/admin/personnel') }}"><i class="fa fa-users" aria-hidden="true"></i> сотрудники</a>
                </li>

                <li class="nav-item d-block d-lg-none" data-placement="right">
                    <a class="nav-link text-white pl-3" href="{{ asset('/admin/blog') }}"><i class="fa fa-newspaper-o" aria-hidden="true"></i> новости</a>
                </li>

                <li class="nav-item d-block d-lg-none" data-placement="right">
                    <a class="nav-link text-white pl-3" href="{{ asset('/admin/review') }}"><i class="fa fa-commenting-o" aria-hidden="true"></i> отзывы</a>
                </li>

                <li class="nav-item d-block d-lg-none" data-placement="right">
                    <a class="nav-link text-white pl-3" href="{{ asset('/admin/transactions') }}"><i class="fa fa-history" aria-hidden="true"></i> история транзакций</a>
                </li>

                @if(Auth::user()->id == 28 || Auth::user()->id == 9)
                    <li class="nav-item d-block d-lg-none" data-placement="right">
                        <a class="nav-link text-white pl-3" href="{{ asset('bigmarketing/balance') }}"><i class="fa fa-money" aria-hidden="true"></i> баланс BigMarketing</a>
                    </li>
                @endif

                <li class="nav-item d-block d-lg-none" data-placement="right">
                    <a class="nav-link text-white pl-3" href="{{ asset('/admin/orders/create') }}"><i class="fa fa-cart-plus" aria-hidden="true"></i> создать заказ</a>
                </li>

                <li class="nav-item d-block d-lg-none" data-placement="right">
                    <a class="nav-link text-white pl-3" href="{{ asset('/admin/themes') }}"><i class="fa fa-cube" aria-hidden="true"></i> тематики категорий</a>
                </li>

            @endif

            {{--<a class="dropdown-item text-white" href="{{asset('/user/profile')}}"><i class="fa fa-user" aria-hidden="true"></i> Личный кабинет</a>--}}
            @if(Auth::user()->isProviderAndDirector())
                <a class="dropdown-item text-white d-flex flex-row" href="{{asset('/company/profile')}}">
                    <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                        <i class="fa fa-building" aria-hidden="true"></i>
                    </div>
                    кабинет компании
                </a>
            @endif










            <li class="nav-item d-block d-lg-none" data-placement="right">
                <a class="nav-link text-white pl-3" data-toggle="modal" data-target="#exampleModal">
                <i class="fa fa-fw fa-sign-out"></i>Выйти</a>
            </li>
            <?//End Мобильное нижнее меню?>

            <?//Дропдаун на десктопе справа вверху?>
            <li class="nav-item dropdown d-none d-lg-block ml-lg-3" style="height: 40px; width: 40px;">
                <a class="nav-link dropdown-toggle text-white h-100 menus" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bars icon-zoom hamburger-menu" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu dark-bg text-secondary border-0 cust-dropdown" aria-labelledby="messagesDropdown">
                    <a class="dropdown-item text-white d-flex flex-row" href="{{asset('/user/profile')}}">
                        <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                        </div>
                        личный кабинет
                    </a>
                    @if(Auth::user()->isAdmin())
                    <a class="dropdown-item text-white d-flex flex-row" href="{{ asset('/admin/moderation/users') }}">
                        <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                        все пользователи
                    </a>
                    @if(Auth::user()->isSuperAdmin())
                        <a class="dropdown-item text-white d-flex flex-row" href="{{ asset('/admin/agents') }}">
                            <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </div>
                            Агенты
                        </a>
                    @endif

                    <a class="dropdown-item text-white d-flex flex-row" href="{{ asset('/admin/personnel') }}">
                        <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                        сотрудники
                    </a>

                    <a class="dropdown-item text-white d-flex flex-row" href="{{ asset('/admin/blog') }}">
                        <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                            <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                        </div>
                        новости
                    </a>

                    <a class="dropdown-item text-white d-flex flex-row" href="{{ asset('/admin/review') }}">
                        <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                            <i class="fa fa-commenting-o" aria-hidden="true"></i>
                        </div>
                        отзывы
                    </a>

                    @if(Auth::user()->id == 28 || Auth::user()->id == 9)
                            <a class="dropdown-item text-white d-flex flex-row" href="{{ asset('bigmarketing/balance') }}">
                                <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                </div>
                                баланс BigMarketing
                            </a>
                    @endif

                    <a class="dropdown-item text-white d-flex flex-row" href="{{ asset('/admin/transactions') }}">
                        <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                            <i class="fa fa-history" aria-hidden="true"></i>
                        </div>
                        история транзакций
                    </a>

                    <a class="dropdown-item text-white d-flex flex-row" href="{{ asset('/admin/orders/create') }}">
                        <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                            <i class="fa fa-cart-plus" aria-hidden="true"></i>
                        </div>
                        создать заказ
                    </a>

                    <a class="dropdown-item text-white d-flex flex-row" href="{{ asset('/admin/themes') }}">
                        <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                            <i class="fa fa-cube" aria-hidden="true"></i>
                        </div>
                        тематики категорий
                    </a>

                    @endif

                    {{--<a class="dropdown-item text-white" href="{{asset('/user/profile')}}"><i class="fa fa-user" aria-hidden="true"></i> Личный кабинет</a>--}}
                    @if(Auth::user()->isProviderAndDirector())
                        <a class="dropdown-item text-white d-flex flex-row" href="{{asset('/company/profile')}}">
                            <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                                <i class="fa fa-building" aria-hidden="true"></i>
                            </div>
                            кабинет компании
                        </a>
                    @endif
                    <a class="dropdown-item text-white d-flex flex-row" data-toggle="modal" data-target="#exampleModal">
                        <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                            <i class="fa fa-fw fa-sign-out"></i>
                        </div>
                        выйти
                    </a>
                </div>
            </li>
            <?//End Дропдаун на десктопе справа вверху?>

        </ul>
    </div>
</nav>