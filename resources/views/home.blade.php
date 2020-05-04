@extends('layouts.app')

@section('navbar')
    @include('layouts.navbar')
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('alert'))
                        <div class="alert alert-danger">
                            {{ session('alert') }}
                        </div>
                    @endif
                    @if ( Auth::user()->isProviderAndDirector())
                            <div class="alert alert-success">
                                Добрый день {{ Auth::user()->name.' '.Auth::user()->surname }}, Вы создали компанию  {{ Auth::user()->company->name }} и являетесь ее Администратором!
                            </div>
                    @elseif(Auth::user()->isProviderAndManager())
                            <div class="alert alert-success">
                                Добрый день {{ Auth::user()->name.' '.Auth::user()->surname }}, Вы зарегестрированы как менеджер компании {{ Auth::user()->company->name }}!
                            </div>
                    @endif
                    @if(session('user_pas'))
                            <h3>Ваш сгенерированый пароль! - {{ session('user_pas') }}</h3>
                    @endif
                    You are logged in!



                    @if( Auth::user()->isProvider())
                        <h1>Я , {{ Auth::user()->name.' '.Auth::user()->surname.'.' }}</h1>
                        @elseif( Auth::user()->isAdmin())
                            <h1>Я , {{ Auth::user()->name.' '.Auth::user()->surname.'.' }}</h1>
                        @elseif( Auth::user()->isModerator())
                            <h1>Я , {{ Auth::user()->name.' '.Auth::user()->surname.'.' }}</h1>
                        @endif
                        @if( Auth::user()->isProvider())
                            @foreach($com->users as $user)

                                    @if($user->surname != 'sdf')
                                        {{ $user->getFullName() }}<br>
                                    @endif
                            @endforeach
                        @endif
                        {{ Auth::user()->getFullName() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
