@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/companyPersonel/companyPersonel.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

          <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
              <div class="text-uppercase blue-d-t">
                  сотрудники компании
              </div>
          </div>

          <table class="table position-relative">
              <thead>
                  <tr class="tb-head text-uppercase blue-d-t text-center">
                      <th scope="col" class="h-60">
                          <a href="#" class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link">
                            id
                          </a>
                      </th>
                      <th scope="col" class="h-60">
                          <div class="d-block p-3 h-100 border-top border-bottom border-blue">
                              имя
                          </div>
                      </th>
                      <th scope="col" class="h-60">
                          <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link">
                            фамилия
                          </div>
                      </th>
                      <th scope="col" class="h-60">
                          <div class="d-block h-100 p-3 border-top border-bottom border-blue">
                              почта
                          </div>
                      </th>
                      <th scope="col" class="h-60">
                          <div class="d-block h-100 p-3 border-top border-bottom border-blue">
                              телефон
                          </div>
                      </th>
                      <th scope="col" class="h-60">
                        <div class="d-block h-100 p-3 border-top border-bottom border-blue radius-top-right border-right">
                          действия
                        </div>
                      </th>
                  </tr>
              </thead>

              <tbody>
              @foreach($personnel as $p)
                  <tr class="text-center bor-bottom border-left border-right">
                      <th scope="row">{{$p->id}}</th>
                      <td>{{$p->name}}</td>
                      <td>{{$p->surname}}</td>
                      <td>{{$p->email}}</td>
                      <td>{{$p->phone}}</td>
                      <td>
                          @if(Auth::user()->id == $p->id)
                              <a href="{{asset('/user/profile')}}" class="text-dark mr-2" title="Редактировать профиль">
                                  <i class="fa fa-pencil-square-o scale" aria-hidden="true"></i>
                              </a>
                          @endif

                          @if(Auth::user()->isProviderAndDirector())
                              @if(Auth::user()->id != $p->id)
                                  @if($p->products->count() <= 0)
                                      <a href="{{ asset('/company/manager/'.$p->id.'/delete') }}" class="text-danger confirm-modal" title="Удалить сотрудника" text="Подтвердите удаление сотрудника">
                                          <i class="fa fa-window-close" aria-hidden="true"></i>
                                      </a>
                                  @else
                                      <a href="{{ asset('/company/manager/'.$p->id.'/delete') }}" personnel-id="{{ $p->id }}" count-products="{{ $p->products->count() }}" class="text-danger delete-manager" title="Удалить сотрудника">
                                          <i class="fa fa-window-close" aria-hidden="true"></i>
                                      </a>
                                  @endif
                              @endif
                          @endif
                          
                      </td>
                  </tr>
              @endforeach
              </tbody>

          </table>

          @if(Auth::user()->isProviderAndDirector())
              <form action="{{asset('/company/add/manager')}}" class="d-flex justify-content-center" method="GET">
                  <button type="submit"  class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg  mt-2 mb-3">
                      <i class="fa fa-plus" aria-hidden="true"></i>
                      Добавить сотрудника
                  </button>
              </form>
          @endif

        </div>
    </div>

    @include('provider.company.modals.personnelDeleteModal')


@endsection
