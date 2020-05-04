@extends('admin.layouts.app')

{{-- @section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/showProduct/showProduct.css') }}">
@endsection --}}

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

                <div class="row mt-3" id="clons_page">
                  <div class="col-12">

                  <div class="wrap_btn_ckecked_clons m-2" id="all_select_clons">
                    <p>Панель управления для удаления дубликатов</p>
                    <button class="btn btn-info" type="button" name="select_clons"> Выбрать все </button>
                    <button class="btn btn-info" type="button" name="cancel_clons"> Отменить выбор </button>
                  </div>
                  <div class="info_status m-3 shadow p-3 mb-5 bg-white rounded">
                    <span >Статус модерации -0  : на модерации</span><br>
                    <span >Статус модерации -3  : заблокирован модератором</span><br>
                    <span >Статус модерации -2  : невалидный контент</span>
                  </div>

                  <div class="wrap_clons mt-2 w-100" id="wrap_clons">

                    <form action="" method="POST" name="clons_for_del" id="clons_for_del">
                    <input type="hidden" name="count_clons" value="{{$count_results}}">
                    <input type="hidden" name="company_id" value="{{$company_id}}" id="company_id_clon">
                      {{csrf_field()}}

						
                            @foreach($clons_product as $clon)

						<?php if(!isset($clon[0])){continue;} ?>

                    <div class="main_block_clon d-flex justify-content-around" id="main_block_clons_{{$clon[0]->id}}">

                                  <div class="original_clon">


                                      {{-- карточка оригинала --}}
                                      <div class="card border border-danger shadow p-3 mb-5 bg-white rounded rounded" style="width: 18rem">
                                        <?php

                                        $pic = json_decode($clon[0]->gallery);
                                        ?>
                                        <img src="{{$pic[0]->public_path ? $pic[0]->public_path : asset('images/default/no_foto.png')}}" class="card-img-top" alt="{{$clon[0]->name}}">

                                        <div class="card-body">
                                              <h5 class="card-title">{{$clon[0]->id}}</h5>
                                              <p class="card-text">{{$clon[0]->name}}</p>
                                        </div>

                                        <ul class="list-group list-group-flush">
                                          <li class="list-group-item">Артикул: {{$clon[0]->code}}</li>
                                          <li class="list-group-item">Цена: {{$clon[0]->price}}</li>
                                          <li class="list-group-item  bg-warning">созд:{{ $clon[0]->created_at}}</li>
											<li class="list-group-item  bg-info">ред:{{ $clon[0]->updated_at}}</li>
											 <li class="list-group-item">Наличие: {{$clon[0]->status_available}}</li>
                                          <li class="list-group-item {{$clon[0]->status_moderation ==1 ? 'bg-success':'text-danger'}}">{{$clon[0]->status_moderation == 1 ? 'модерирован':'статус: '.$clon[0]->status_moderation}}</li>
                                        </ul>

                                          <div class="card-body bg-check" id="wrap_{{$clon[0]->id}}">
                                            <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="id_clon[]" value="{{$clon[0]->id}}" id="{{$clon[0]->id}}" autocomplete="off">
                                              <label class="form-check-label" for="{{$clon[0]->id}}">
                                                  Удалить
                                              </label>
                                            </div>
                                          </div>

                                      </div>
                                    {{-- end карточка оригинала --}}

                                  </div>


                                  {{-- блок для клонов оригинала --}}
                                  <div class="d-flex align-content-start justify-content-center flex-wrap">

                                    @for($i=1;$i<count($clon); $i++)

                                          {{-- карточка дубликата --}}
                                        <div class="card clons_item" style="width: 18rem;">
                                            <?php
                                            $pic = json_decode($clon[$i]->gallery);
                                            //dd($pic[0]->public_path);
                                            ?>
                                            <img src="{{$pic[0]->public_path ? $pic[0]->public_path : asset('images/default/no_foto.png')}}" class="card-img-top" alt="{{$clon[$i]->name}}">

                                            <div class="card-body">
                                                  <h5 class="card-title">{{$clon[$i]->id}}</h5>
                                                  <p class="card-text">{{$clon[$i]->name}}</p>
                                            </div>

                                            <ul class="list-group list-group-flush">
                                              <li class="list-group-item">Артикул: {{$clon[$i]->code}}</li>
                                              <li class="list-group-item">Цена: {{$clon[$i]->price}}</li>
                                              <li class="list-group-item">созд:{{ $clon[$i]->created_at}}</li>
												<li class="list-group-item  bg-info">ред:{{ $clon[0]->updated_at}}</li>
												<li class="list-group-item">Наличие: {{$clon[0]->status_available}}</li>
                                              <li class="list-group-item {{$clon[$i]->status_moderation ==1 ? 'bg-success':'text-danger'}}">{{$clon[$i]->status_moderation == 1 ? 'модерирован':'статус: '.$clon[$i]->status_moderation}}</li>
                                            </ul>

                                              <div class="card-body bg-check-clons" id="wrap_{{$clon[$i]->id}}">
                                                <div class="form-check">
                                                  <input class="form-check-input" type="checkbox" name="id_clon[]" value="{{$clon[$i]->id}}" id="{{$clon[$i]->id}}" autocomplete="off">
                                                  <label class="form-check-label" for="{{$clon[$i]->id}}">
                                                      Удалить
                                                  </label>
                                                </div>
                                              </div>

                                          </div>
                                        {{-- end карточка дубликата --}}

                                    @endfor


                                  </div>
                                    {{--конец блока для клонов оигинала  --}}
                              </div>
                          <hr>
                        @endforeach

                            <div class="wrap_btn-del m-4 text-center">
                              <button type="submit" class="btn btn-danger" id="btn_form_clons-del">Удалить выбранные дубликаты</button>
                            </div>


                      </form>
                    </div>
                  </div>
                </div>
                </div>
        </div>
      </div>



@endsection

@section('script2')
    <!-- clons select and cancel -->
    <script src="{{asset('js/clons.js')}}"></script>
@endsection