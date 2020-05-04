@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/showProduct/showProduct.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row">

                <div class="col-12 f30 mt-5 mb-5">
                    <div class="text-uppercase blue-d-t">
                        просмотр товара
                    </div>
                </div>

                @if($product->data_error == null || $product->data_error == '')
                  @else
                  <?
                      $text_error = json_decode($product->data_error);
                    ?>

                  <div class="alert alert-danger col-12" role="alert">
                    Замечания по товару:<br> {!! nl2br(htmlspecialchars($text_error->long_error)) !!}
                  </div>
                @endif

                <div class="col-6">


                    <?//слайдер картинок?>
                    <div id="cases">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <?//добавляет первой карточке класс active а остальным нет?>
                                <?$step = true;$count = 0;?>
                                @foreach($images as $image)
                                    <div class="carousel-item {{ (!$step)? '' : 'active'}}">
                                        <img class="d-block w-100" src="{{ $image->public_path }}" alt="{{$product->name . ' image-' . $count}}">
                                    </div>
                                    <?  $step = false; $count++; ?>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>

                    @if($product->status_moderation == '0')
                        <div class="alert alert-info mt-3" role="alert">
                            Товар на стадии модерации
                        </div>
                    @elseif($product->status_moderation == '1')
                        <div class="alert alert-success mt-3" role="alert">
                            Товар успешно прошел модерацию
                        </div>
                    @elseif($product->status_moderation == '2')
                        <div class="alert alert-warning mt-3" role="alert">
                            Товар возвращен компании на доработку
                        </div>
                    @elseif($product->status_moderation == '3')
                        @if($product->company->block == 0)
                            <div class="alert alert-danger mt-3" role="alert">
                                Товар заблокирован, компания на рассмотрении администратора для блокировки
                            </div>
                        @else
                            <div class="alert alert-danger mt-3" role="alert">
                                Компания заблокирована, модерация товара не доступна
                            </div>
                        @endif
                    @endif

                    @if($product->company->block == 0)
                        <button type="button" class="btn bg-success square_btn shadow-custom text-uppercase border-bottom-0 border-radius-50 w-100 mt-3 mb-3 op-mod-suc">
                          прошел модерацию
                        </button>
                        <button type="button" class="btn bg-warning square_btn shadow-custom text-uppercase border-bottom-0 border-radius-50 w-100 mt-3 mb-3 op-mod-war">
                          невалидный контент
                        </button>
                        <button type="button" class="btn bg-danger square_btn shadow-custom text-uppercase border-bottom-0 border-radius-50 w-100 mt-3 mb-3 op-mod-dan">
                          заблокировать
                        </button>

                        <a href="{{ asset('admin/moderation/products/'.$product->id.'/edit') }}" class="btn square_btn shadow-custom text-uppercase border-radius-50 w-100 mt-3 mb-3">редактировать</a>

                    @endif
                </div>

                <div class="col-6">

                    <div>
                        <div class="d-inline font-weight-bold">Артикул:</div> {{$product->code}}<br>
                        <div class="d-inline font-weight-bold">Наименование:</div> {{$product->name}}<br>
                        <div class="d-inline font-weight-bold">Бренд:</div> {{$product->brand}}<br>
                        <div class="d-inline font-weight-bold">Подкатегория:</div> {{$product->subcategory->name}}<br>
                        <div class="d-inline font-weight-bold">Комиссия:</div> {{$product->subcategory->commission}}%<br>

                        <div class="d-inline font-weight-bold">Цена:</div> {{$product->price}} грн<br>
                        @if($product->old_price != null)
                          <div class="d-inline font-weight-bold">Старая цена:</div> {{$product->old_price}} грн <br>
                        @endif
						{{-- апрель2020 --}}
                        @if($product->price_promo != null)
                          <div class="d-inline font-weight-bold">Промо цена:</div> {{$product->price_promo}} грн<br>
                        @endif
                        {{-- апрель2020 --}}
                        @if($product->video_url != null)
                          <div class="d-block font-weight-bold">Ссылка на видео:<a class="d-block" href="{{$product->video_url}}" target="_blank">{{$product->video_url}}</a></div>
                        @endif
                    </div>

                    <div class="mt-3">
                        @foreach($product_items as $items)
                            @if($items->data_new == null)
                                <?
                                    $data_item = json_decode($items->data);
                                ?>
                                @if($data_item->attr_type == "your_self")
                                    <div class="d-inline font-weight-bold"><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i> {{ $items->name }}</div> : {{ $items->value}}<br>
                                @else
                                    <div class="d-inline font-weight-bold"><i class="fa fa-check-circle-o text-success" aria-hidden="true"></i> {{ $items->name }}</div> : {{ $items->value}}<br>
                                @endif
                            @else
                                <?
                                    $data_new_json = json_decode($items->data_new);
                                    $data_new_string = implode(", ", $data_new_json->values);
                                ?>
                                <div class="d-inline font-weight-bold"><i class="fa fa-check-circle-o text-success" aria-hidden="true"></i> {{ $items->name }}</div> : {{ $data_new_string }}<br>

                            @endif
                        @endforeach
                    </div>

                    <div class="mt-3">
                        <span style="font-weight: bolder;">Описание товара:</span>
                        <br>
                        {!! nl2br($product->desc) !!}
                    </div>

                </div>
            </div>


        </div>
    </div>

    @include('adminAndModerator.moderation.product.layouts.modals')
@endsection

@section('script2')
  @include('adminAndModerator.moderation.product.layouts.script2')
  @include('adminAndModerator.moderation.product.layouts.scriptSlider')
@endsection