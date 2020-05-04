@extends('provider.company.layouts.app')

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
                @if($product->status_moderation == '2')
                    <div class="alert alert-warning col-12" role="alert">
                        Замечания по товару:<br> {!! nl2br(htmlspecialchars($text_error->long_error)) !!}
                    </div>
                @elseif($product->status_moderation == '3')
                    <div class="alert alert-danger col-12" role="alert">
                        Замечания по товару:<br> {!! nl2br(htmlspecialchars($text_error->long_error)) !!}
                    </div>
                @endif

            @endif

              <div class="col-6">
                  @if($product->status_moderation == '2')
                      <div class="row">
                          <div class="col-12">
                              <a href="{{ asset('/company/products/'.$product->id.'/edit') }}" class="btn btn-primary w-100">редактировать товар</a>
                          </div>
                      </div>
                  @endif



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

              </div>

              <div class="col-6">

                <div>
                  <div class="d-inline font-weight-bold">Название:</div> {{$product->name}}<br>
                    <?
                    $str = $product->code;
                    $result = substr($str, strpos($str, '-') + 1, strlen($str));
                    ?>
                  <div class="d-inline font-weight-bold">Артикул:</div> {{$result}}<br>
                  <div class="d-inline font-weight-bold">Бренд:</div> {{$product->brand}}<br>
                  <div class="d-inline font-weight-bold">Цена:</div> {{$product->price}}<br>
					 {{-- (апрель2020) --}}
                @if(Auth::user()->company_id == 59)
                  @if($product->old_price != null)
                  <div class="d-inline font-weight-bold">Старая цена:</div> {{$product->old_price}}<br>
                  @endif
                  @if($product->price_promo != null)
                      <div class="d-inline font-weight-bold">Промо цена:</div> {{$product->price_promo}} грн<br>
                  @endif
                @endif
                {{-- (апрель2020) --}}
                </div>

                <div class="mt-3">
                  @foreach($product_items as $items)
                        @if($items->data_new == null)
                            <div class="d-inline font-weight-bold">{{ $items->name }}</div> : {!! $items->value !!}<br>
                        @else
                            <?
                            $data_new_json = json_decode($items->data_new);
                            $data_new_string = implode(", ", $data_new_json->values);
                            ?>
                            <div class="d-inline font-weight-bold">{{ $items->name }}</div> : {!! $data_new_string !!}<br>
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

@endsection