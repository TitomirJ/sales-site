@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/balanceCompaniesCheck/balanceCompaniesCheck.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

          <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
              <div class="text-uppercase blue-d-t">
                  История транзакций <i class="fa fa-history text-primary" aria-hidden="true"></i>
              </div>
              <div>
                Здравствуй, {{Auth::user()->name}}!<i class="fa fa-hand-peace-o ml-2" aria-hidden="true"></i>
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
                                  дата
                                </div>
                            </th>
                            <th scope="col" class="h-60">
                                <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                                  тип
                                </div>
                            </th>
                            <th scope="col" class="h-60">
                                <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                                  сумма
                                </div>
                            </th>
                            <th scope="col" class="h-60">
                                <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap radius-top-right border-right">
                                  компания
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="table-bg">
                      @foreach($transactions as $t)
                        <?//3 - абонентская плата 0- поплнение депозита?>
                          @if(($t->type_transaction == '0' || $t->type_transaction == '3') && $t->company_id != 12 && $t->company_id != 42)
                            <tr class="text-center bor-bottom">
                                <td class="font-weight-bold border-left">
                                  {{(new Date($t->created_at))->format('j F Y (H:i)')}}
                                </td>
                                <td class="font-weight-bold">
                                  @if($t->type_transaction == '0')
                                    поплнение депозита
                                    @elseif($t->type_transaction == '3')
                                    абонентская плата
                                  @endif
                                </td>
                                <td class="font-weight-bold">
                                  {{$t->total_sum}} грн
                                </td>
                                <td class="font-weight-bold border-right">
                                  <a href="{{asset('/admin/company/'.$t->company->id)}}">{{$t->company->name}}</a>
                                </td>
                            </tr>
                        @endif
                      @endforeach
                    </tbody>
                  </table>

                </div>

              </div>
            </div>


        </div>
    </div>

@endsection
