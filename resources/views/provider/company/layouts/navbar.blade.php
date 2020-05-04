<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark dark-bg fixed-top" id="mainNav">

    <a class="navbar-brand logo-trans on-overlay-loader ml-lg-5 pl-lg-5 ml-0 pl-0" href="{{asset('/company')}}">

        <div class="wrapper-logotip position-relative d-flex text-uppercase font-weight-bold">
            <div class="white-block-logo bg-white"></div>
            <div class="big position-absolute">big</div>
            <div class="sales position-absolute text-white">sales</div>
        </div>

        <div class="logo-subtext">продажи и маркетинг в одном сервисе</div>

    </a>

	 {{-- для отображения баланса компании на всех страницах --}}
    @if(\Route::current()->getPrefix() == '/company')
    @if(\Route::current()->getName() !== 'balance_comp')
    <?php

        if(!isset($company)){
            $ind = \Auth::user()->company_id;
            $company = \App\Company::find($ind);

        }
    ?>
    <div class="wrap_balance ml-3">

        @if($company ->balance_sum < $company ->balance_limit)
                <span class="text-danger">Баланс компании: {{$company ->balance_sum}} грн</span>
              @else
                <span class="text-success">Баланс компании: {{$company ->balance_sum}} грн</span>
              @endif

    </div>
    @endif
    @endif
{{-- окончание блока баланса компании --}}


    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">

        <ul class="navbar-nav navbar-sidenav dark-bg" id="exampleAccordion">

            <li class="nav-item border-top border-secondary<? if(Request::path() == 'company'){ echo ' active-tab-nav';}else{echo' hover-light';}?>" data-placement="right">
                <a class="nav-link d-lg-flex d-md-block align-items-center flex-column on-overlay-loader pl-3 <? if(Request::path() == 'company'){ echo ' active-tab-nav-icon';}?>" href="{{ asset('/company') }}">
                    <i class="fa fa-tasks icon-zoom mt-3" aria-hidden="true"></i>
                    <span class="f11 mt-2 ml-lg-0 ml-3">сводка</span>
                </a>
            </li>

            <li class="nav-item border-top border-bottom border-secondary<? if(Request::is('company/products*')){ echo ' active-tab-nav';}else{echo' hover-light';}?>" data-placement="right">
                <a class="nav-link d-lg-flex d-md-block align-items-center flex-column on-overlay-loader pl-3<? if(Request::is('company/products*')){ echo ' active-tab-nav-icon';}?>" href="{{ asset('/company/products') }}">
                    <i class="fa fa-archive icon-zoom mt-3" aria-hidden="true"></i>
                    <span class="f11 mt-3 ml-lg-0 ml-3">товары</span>
                </a>
            </li>

            <li class="nav-item<? if(Request::is('company/orders*')){ echo ' active-tab-nav';}else{echo' hover-light';}?>" data-placement="right">
                <a class="nav-link d-lg-flex d-md-block align-items-center flex-column on-overlay-loader pl-3<? if(Request::is('company/orders*')){ echo ' active-tab-nav-icon';}?>" href="{{asset('/company/orders')}}">
                    <i class="fa fa-cart-arrow-down icon-down-zoom mt-3" aria-hidden="true"></i>
                    <span class="f11 mt-3 ml-lg-0 orders text-center">заказы
                        @if(!Auth::guest())
                            @if(Auth::user()->isProvider())
                              @if(Auth::user()->company->countNewOrders() > 0)
                                <br>
                                <span class="badge badge-pill badge-danger">{{Auth::user()->company->countNewOrders()}}</span>
                              @endif
                            @endif
                        @endif

                    </span>
                </a>
            </li>

            <li class="nav-item border-top border-bottom border-secondary<? if(Request::is('company/balance*')){ echo ' active-tab-nav';}else{echo' hover-light';}?>" data-placement="right" >
                <a class="nav-link d-lg-flex d-md-block align-items-center flex-column on-overlay-loader pl-3<? if(Request::is('company/balance*')){ echo ' active-tab-nav-icon';}?>" href="{{asset('/company/balance')}}">
                    <i class="fa fa-credit-card-alt icon-card mt-3" aria-hidden="true"></i>
                    <span class="f11 mt-3 ml-lg-0 balance-text">баланс</span>
                </a>
            </li>

            <li class="nav-item border-top border-bottom border-secondary<? if(Request::is('company/messages*')){ echo ' active-tab-nav';}else{echo' hover-light';}?>" data-placement="right" >
                <a class="nav-link d-lg-flex d-md-block align-items-center flex-column on-overlay-loader pl-3<? if(Request::is('company/messages*')){ echo ' active-tab-nav-icon';}?>" href="{{asset('/company/messages')}}">
                    <i class="fa fa-comments icon-card mt-3" aria-hidden="true"></i>
                    <span class="f11 mt-3 ml-lg-0 balance-text">переписка</span>
					<?php $us = isset(\Auth::user()->company_id) ? \Auth::user()->company_id : false;  ?>
                    @if($us)
                    {{-- показ количества сообщений (апрель2020) --}}
                    <?php
					 //$id_comp = Auth::user()->company_id;
    				//$counts_charts = \App\Http\Controllers\ProviderMessagesController::countNewMessagesForTypes($id_comp);
					$counts_charts_a = [];
					$id_comp_a = isset(\Auth::user()->company_id) ? \Auth::user()->company_id : false;
    				if($id_comp_a){
       					$counts_charts_a = \App\Http\Controllers\ProviderMessagesController::countNewMessagesForTypes($id_comp_a);
    				};

					$c=0;
					?>
                    @foreach($counts_charts_a as $mess)
                    <?php
                    if($mess > 0){
                        $c = $c+$mess;
                    } ?>
                    @endforeach
                    @if($c > 0)
                        <span class="badge badge-pill badge-danger">{{ $c }}</span>
                    @endif

                    @endif
                </a>
            </li>

            <li class="nav-item d-flex align-items-center h-100 hover-light" data-placement="right" >
                <a class="nav-link d-lg-flex d-md-block align-items-center h-100 justify-content-center flex-column on-overlay-loader pl-3" href="{{asset('/help')}}">
                    <i class="fa fa-question icon-zoom icon-down-zoom" aria-hidden="true" style="color: #73b4ea;"></i>
                    <span class="f11 mt-3 ml-lg-0 ml-4">помощь</span>
                </a>
            </li>

        </ul>

        <ul class="navbar-nav ml-auto">




            @if(Auth::check())
                @if(Auth::user()->isProvider())
                {{--<li class="nav-item dropdown ">--}}
                    {{--<a class="nav-link dropdown-toggle mr-lg-2 text-white pl-3" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                        {{--<i class="fa fa-fw fa-envelope"></i>--}}
                        {{--<span class="d-lg-none">Messages--}}
                            {{--<span class="badge badge-pill badge-primary">12 New</span>--}}
                        {{--</span>--}}
                        {{--<span class="indicator text-primary d-none d-lg-block">--}}
                            {{--<i class="fa fa-fw fa-circle"></i>--}}
                        {{--</span>--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-menu" aria-labelledby="messagesDropdown">--}}
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

                {{--<li class="nav-item dropdown">--}}
                    {{--<a class="nav-link dropdown-toggle mr-lg-2 text-white pl-3" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                        {{--<i class="fa fa-fw fa-bell"></i>--}}
                        {{--<span class="d-lg-none">Alerts--}}
                          {{--<span class="badge badge-pill badge-warning">6 New</span>--}}
                        {{--</span>--}}
                        {{--<span class="indicator text-warning d-none d-lg-block">--}}
                          {{--<i class="fa fa-fw fa-circle"></i>--}}
                        {{--</span>--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-menu" aria-labelledby="alertsDropdown">--}}
                        {{--<h6 class="dropdown-header">New Alerts:</h6>--}}
                        {{--<div class="dropdown-divider"></div>--}}
                        {{--<a class="dropdown-item" href="#">--}}
                          {{--<span class="text-success">--}}
                            {{--<strong>--}}
                              {{--<i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>--}}
                          {{--</span>--}}
                          {{--<span class="small float-right text-muted">11:21 AM</span>--}}
                          {{--<div class="dropdown-message small">This is an automated server response message. All systems are online.</div>--}}
                        {{--</a>--}}
                        {{--<div class="dropdown-divider"></div>--}}
                        {{--<a class="dropdown-item" href="#">--}}
              {{--<span class="text-danger">--}}
                {{--<strong>--}}
                  {{--<i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>--}}
              {{--</span>--}}
                            {{--<span class="small float-right text-muted">11:21 AM</span>--}}
                            {{--<div class="dropdown-message small">This is an automated server response message. All systems are online.</div>--}}
                        {{--</a>--}}
                        {{--<div class="dropdown-divider"></div>--}}
                        {{--<a class="dropdown-item" href="#">--}}
              {{--<span class="text-success">--}}
                {{--<strong>--}}
                  {{--<i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>--}}
              {{--</span>--}}
                            {{--<span class="small float-right text-muted">11:21 AM</span>--}}
                            {{--<div class="dropdown-message small">This is an automated server response message. All systems are online.</div>--}}
                        {{--</a>--}}
                        {{--<div class="dropdown-divider"></div>--}}
                        {{--<a class="dropdown-item small" href="#">View all alerts</a>--}}
                    {{--</div>--}}
                {{--</li>--}}
            @endif
        @endif

            <li class="nav-item d-block d-lg-none" data-placement="right" >
                <a class="nav-link text-white pl-3" href="{{asset('/user/profile')}}">
                    <i class="fa fa-address-card" aria-hidden="true"></i>
                    Личный кабинет
                </a>
            </li>

            <li class="nav-item d-block d-lg-none" data-placement="right" >
                @if(Auth::check())
                    @if(Auth::user()->isProviderAndDirector())
                        <a class="nav-link text-white pl-3" href="{{asset('/company/profile')}}">
                            <i class="fa fa-laptop" aria-hidden="true"></i>
                            Кабинет компании
                        </a>
                    @endif
                @endif
            </li>

            <li class="nav-item d-block d-lg-none" data-placement="right" >
                <a class="nav-link text-white pl-3" href="{{asset('/company/personnel')}}">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    Сотрудники компании
                </a>
            </li>

            <li class="nav-item d-block d-lg-none" data-placement="right" >
                <a class="nav-link text-white pl-3" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-fw fa-sign-out"></i>
                    Выйти
                </a>
            </li>

             <li class="nav-item dropdown d-none d-lg-block ml-lg-3" style="height: 40px; width: 40px;">
                <a class="nav-link dropdown-toggle text-white h-100" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bars icon-zoom hamburger-menu" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu shadow-custom dark-bg text-secondary border-0 cust-dropdown" aria-labelledby="messagesDropdown">
                @if(Auth::check())
                    @if(!Auth::user()->isProvider())
                            <a class="dropdown-item text-white d-flex flex-row" href="{{asset('/company/reg')}}">
                                <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                </div>
                                создать компанию
                            </a>
                    @endif
                @endif
                    <a class="dropdown-item text-white d-flex flex-row" href="{{asset('/user/profile')}}">
                        <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                        </div>
                        личный кабинет
                    </a>
                    @if(Auth::check())
                        @if(Auth::user()->isProviderAndDirector())
                            <a class="dropdown-item text-white d-flex flex-row" href="{{asset('/company/profile')}}">
                                <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                                    <i class="fa fa-laptop" aria-hidden="true"></i>
                                </div>
                                кабинет компании
                            </a>
                        @endif
                    @endif
                    <a class="dropdown-item text-white d-flex flex-row" href="{{asset('/company/personnel')}}">
                        <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                        </div>
                        сотрудники компании
                    </a>
                    @if(Auth::check())
                        <a class="dropdown-item text-white d-flex flex-row" data-toggle="modal" data-target="#exampleModal">
                            <div class="d-flex align-items-center justify-content-center hamburg-dropdown mr-2">
                                <i class="fa fa-fw fa-sign-out"></i>
                            </div>
                            Выйти
                        </a>
                    @endif
                </div>
            </li>
        </ul>
    </div>
</nav>