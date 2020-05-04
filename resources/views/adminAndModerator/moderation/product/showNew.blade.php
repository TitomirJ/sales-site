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

                <div class="col-6">


                    <?//слайдер картинок?>
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
              @if($product->status_moderation == '0')
                    <button type="button" class="btn bg-success square_btn shadow-custom text-uppercase border-bottom-0 border-radius-50 w-100 mt-3 mb-3" data-toggle="modal" data-target="#success">
                      прошел модерацию
                    </button>
                    <button type="button" class="btn bg-warning square_btn shadow-custom text-uppercase border-bottom-0 border-radius-50 w-100 mt-3 mb-3" data-toggle="modal" data-target="#invalid">
                      невалидный контент
                    </button>
                    <button type="button" class="btn bg-danger square_btn shadow-custom text-uppercase border-bottom-0 border-radius-50 w-100 mt-3 mb-3" data-toggle="modal" data-target="#block">
                      заблокировать
                    </button>

                    <a href="#" class="btn square_btn shadow-custom text-uppercase border-radius-50 w-100 mt-3 mb-3">редактировать</a>
                  @else
                  <div class="alert alert-success mt-3" role="alert">
                    Модерация товара не доступна
                  </div>
                @endif
                </div>

                <div class="col-6">

                    <div>
                        <div class="d-inline font-weight-bold">Наименование:</div> {{$product->name}}<br>
                        <div class="d-inline font-weight-bold">Артикул:</div> {{$product->code}}<br>
                        <div class="d-inline font-weight-bold">Категория:</div> {{$product->category->name}}<br>
                        <div class="d-inline font-weight-bold">Бренд:</div> {{$product->brand}}<br>
                        <div class="d-inline font-weight-bold">Цена:</div> {{$product->price}}<br>
						{{-- апрель2020 --}}                        
                        @if($product->price_promo != null)
                          <div class="d-inline font-weight-bold">Промо цена:</div> {{$product->price_promo}} грн<br>
                        @endif
                        {{-- апрель2020 --}}
                    </div>

                    <div class="mt-3">
                        @foreach($product_items as $items)
                            <div class="d-inline font-weight-bold">{{ $items->name }}</div> : {{ $items->value}}<br>
                        @endforeach
                    </div>

                    <div class="mt-3">
                        {{$product->desc}}
                    </div>

                </div>
            </div>


        </div>
    </div>
    @include('adminAndModerator.moderation.product.layouts.modals')
@endsection

@section('script2')
  @include('adminAndModerator.moderation.product.layouts.script2')
@endsection