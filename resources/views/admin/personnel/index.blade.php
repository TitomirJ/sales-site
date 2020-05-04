@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">

          <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
              <div class="text-uppercase blue-d-t">
                  Сотрудники сайта <i class="fa fa-users"></i>
              </div>
          </div>

          <div class="row mt-3">
            <div class="col-12">

              <div class="table-responsive scroll_wrap">

                <table class="table position-relative scroll_me">

                  <thead>
                      <tr class="tb-head text-uppercase blue-d-t text-center">
                          <th scope="col" class="h-60">
                              <div class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link text-nowrap">
                                id
                              </div>
                          </th>
                          <th scope="col" class="h-60">
                              <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                                имя
                              </div>
                          </th>
                          <th scope="col" class="h-60">
                              <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                фамилия
                              </div>
                          </th>
                          <th scope="col" class="h-60">
                              <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                должность
                              </div>
                          </th>
                          <th scope="col" class="h-60">
                              <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                почта
                              </div>
                          </th>
                          <th scope="col" class="h-60">
                              <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                телефон
                              </div>
                          </th>
                          <th scope="col" class="h-60">
                              <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap radius-top-right border-right">
                                действия
                              </div>
                          </th>
                      </tr>
                  </thead>

                  <tbody class="table-bg">
                    @foreach($personnel as $p)
                    <tr class="text-center bor-bottom">
                      <td class="font-weight-bold border-left">
                        {{$p->id}}
                      </td>
                      <td class="font-weight-bold">
                        {{$p->name}}
                      </td>
                      <td class="font-weight-bold">
                        {{$p->surname}}
                      </td>
                      <td class="font-weight-bold">
                        @if($p->isSuperAdmin())
                            <span class="badge badge-danger">Старший Админ</span>
                        @elseif($p->isAdmin())
                            <span class="badge badge-success">{{$p->roles[0]['label']}}</span>
                        @else
                            <span class="badge badge-info">{{$p->roles[0]['label']}}</span>
                        @endif
                      </td>
                      <td class="font-weight-bold">
                        {{$p->email}}
                      </td>
                      <td class="font-weight-bold">
                        {{$p->phone}}
                      </td>
                      <td class="font-weight-bold border-right">
                        @if(Auth::user()->id == $p->id)
                            <a href="{{asset('/user/profile')}}" class="text-warning mr-2" title="Редактировать профиль">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                        @endif
                        @if(Auth::user()->isSuperAdmin())
                            @if(!$p->isSuperAdmin())
                                @if($p->isAdmin())
                                        <a href="{{asset('/admin/personnel/'.$p->id.'/promotion')}}" class="text-success mr-2 confirm-modal"
                                           text="Вы уверены, что хотите повысить {{ $p->getFullName() }}?" title="Повысить до Старшего Админа"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>

                                        <a href="{{asset('/admin/personnel/'.$p->id.'/downgrading')}}" class="text-danger mr-2 confirm-modal"
                                           text="Вы уверены, что хотите понизить {{ $p->getFullName() }}?" title="Понизить до модератора"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>

                                        <a href="{{asset('/admin/personnel/admin/'.$p->id.'/delete')}}" class="text-danger mr-2 confirm-modal"
                                           text="Вы уверены, что хотите удалить {{ $p->getFullName() }}?" title="Удалить администратора">
                                            <i class="fa fa-window-close" aria-hidden="true"></i>
                                        </a>
                                @elseif($p->isModerator())
                                        <a href="{{asset('/admin/personnel/'.$p->id.'/promotion')}}" class="text-success mr-2 confirm-modal"
                                           text="Вы уверены, что хотите повысить {{ $p->getFullName() }}?" title="Повысить до администратора"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>

                                        <a href="{{asset('/admin/personnel/moderator/'.$p->id.'/delete')}}" class="text-danger mr-2 confirm-modal"
                                           text="Вы уверены, что хотите удалить {{ $p->getFullName() }}?" title="Удалить модератора">
                                            <i class="fa fa-window-close" aria-hidden="true"></i>
                                        </a>
                                @endif

                            @endif
                        @endif
                        @if(!Auth::user()->isSuperAdmin() && Auth::user()->isAdmin())
                            @if(!$p->isAdmin() && !$p->isSuperAdmin())
                                    <a href="{{asset('/admin/personnel/moderator/'.$p->id.'/delete')}}" class="text-danger mr-2 confirm-modal"
                                       text="Вы уверены, что хотите удалить {{ $p->getFullName() }}?" title="Удалить модератора">
                                        <i class="fa fa-window-close" aria-hidden="true"></i>
                                    </a>
                            @endif
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>

              </div>
            </div>
          </div>


          
            @if(Auth::user()->isAdmin())
                <form action="{{asset('/admin/personnel/create')}}" method="GET">
                    <button type="submit"  class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Добавить сотрудника
                    </button>
                </form>
            @endif
        </div>
    </div>






@endsection
