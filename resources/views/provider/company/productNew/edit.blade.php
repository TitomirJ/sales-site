@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/product/product.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
                <div class="text-uppercase blue-d-t">
                    Редактирование товара
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

            <form method="POST" action="{{ asset('company/products/'.$product->id) }}" class="form-product">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <?//Вся форма?>
                <div class="row">
                    <div class="col-12">

                        <?//Навигация по табам?>
                        <ul class="nav nav-pills nav-justified text-uppercase" id="myTab" role="tablist">
                            <li class="nav-item products-tab ml-5 mr-5 border-bot radius-top-left radius-top-right">
                                <a class="nav-link rounded-0 dark-link text-nowrap font-weight-bold active" id="desc-tab" data-toggle="tab" href="#desc" role="tab" aria-controls="desc" aria-selected="true">Основное</a>
                            </li>
                            <li class="nav-item products-tab ml-5 mr-5 border-bot radius-top-left radius-top-right">
                                <a class="nav-link rounded-0 dark-link text-nowrap font-weight-bold" id="category-tab" data-toggle="tab" href="#category" role="tab" aria-controls="category" aria-selected="false">Дополнительно</a>
                            </li>
                            <li class="nav-item products-tab ml-5 mr-5 border-bot radius-top-left radius-top-right">
                                <a class="nav-link rounded-0 dark-link text-nowrap font-weight-bold" id="price-tab" data-toggle="tab" href="#price" role="tab" aria-controls="price" aria-selected="false">Цены</a>
                            </li>
                            <li class="nav-item products-tab ml-5 mr-5 border-bot radius-top-left radius-top-right">
                                <a class="nav-link rounded-0 dark-link text-nowrap font-weight-bold" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="false">Изображения</a>
                            </li>
                        </ul>
                        <?//End Навигация по табам?>


                        <?//Табы?>
                        <div class="tab-content" id="myTabContent">

                            <?//Таб 1?>
                            <div class="tab-pane fade show active" id="desc" role="tabpanel" aria-labelledby="desc-tab">

                                <div class="row mt-4">
                                    <div class="col-12 col-md-2 offset-md-1 d-md-flex d-none justify-content-center align-items-center border border-right-0 border-blue b-t-l b-b-l">
                                        <i class="fa fa-clipboard scale-5" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-12 col-md-8 p-3 border border-blue b-t-r b-b-r font-weight-bold">

                                        <div class="form-group">
                                            <label for="name">Название товара* <span id="check-caps" class="text-danger"></span></label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Укажите найменование товара..."  autofocus value="{{ $product->name }}">
                                        </div>

                                        <div class="form-group">
                                            <?
                                            $code = $product->code;
                                            $pos = strpos($code, '-');
                                            $rest = substr($code, 1+$pos);
                                            ?>
                                            <label for="code">Артикул*</label>
                                            <input type="text" class="form-control" id="code" myUrl="{{ asset('/company/check/code') }}" product-id="{{ $product->code }}" name="code" placeholder="Артикул..." value="{{ $rest }}" autofocus>

                                        </div>

                                        <div class="form-group">
                                            <label for="brand">Торговая марка (бренд)*</label>
                                            <input type="text" class="form-control" id="brand" name="brand" placeholder="Бренд..." value="{{ $product->brand }}" autofocus>
                                        </div>

                                        <div class="form-group">
                                            <label for="desc">Описание товара*</label>
                                            <textarea class="form-control" id="product-desc" name="desc" rows="3">{{ $product->desc }}</textarea>
                                        </div>

                                    </div>

                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <a class="btn square_btn shadow-custom text-uppercase text-white border-radius-50 w-100 create-p-next" data-action="1">Далее</a>
                                    </div>
                                </div>
                            </div>
                            <?//End Таб 1?>

                            <?//Таб 2?>
                            <div class="tab-pane fade" id="category" role="tabpanel" aria-labelledby="category-tab">

                                <div class="row mt-4">
                                    <div class="col-12 col-md-2 offset-md-1 d-md-flex d-none justify-content-center align-items-center border border-right-0 border-blue b-t-l b-b-l">
                                        <i class="fa fa-sitemap scale-5" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-12 col-md-8 p-3 border border-blue b-t-r b-b-r font-weight-bold">

                                        <div class="form-group">
                                            <label for="subcategory">Выбирете подкатегорию*
                                                <i class="fa fa-spinner fa-spin fa-fw" id="product-create-subcat-spinner" style="display: none"></i>
                                            </label>
                                            <select class="get-subcat-options-select select-1" id="subcategory"  myUrl="{{ asset('/company/get/subcategory/options') }}" name="subcategory" style="width: 100%;">
                                                @if(isset($subcategories))
                                                    @foreach($subcategories as $subcategory)
                                                        <option value="{{ $subcategory->id }}"
                                                                @if($subcategory->id == $product->subcategory_id)
                                                                selected
                                                                @endif
                                                        data-commission="{{ $subcategory->commission }}">{{ $subcategory->name }} ({{ $subcategory->category->name }})</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>


                                        <div class="alert alert-info mt-3" role="alert">
                                            Добавить характеристики товара по умолчанию
                                        </div>




                                        <div class="input-group mb-1">
                                            <div style="width: 85%;">
                                                <select class="custom-select form-control select-2 select-render-inputs s-sub-opt" id="subcategory-options" myUrl="{{ asset('company/product/render/input') }}">
                                                    @if(isset($parametrs))
                                                        @foreach($parametrs as $parametr)
                                                            <option value="{{ $parametr->id }}">{{ $parametr->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div style="width: 15%;">
                                                <button class="btn btn-secondary select-subcat-option on-overlay-loader" style="float: right;" type="button" tabindex="-1" ><i class="fa fa-plus" aria-hidden="true"></i></button>
                                            </div>
                                        </div>

                                        <div class="alert alert-info mt-3" role="alert">
                                            Добавить свои характеристики товара
                                        </div>

                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="your-self-key" name="" placeholder="Название характеристики">
                                            <input type="text" class="form-control" id="your-self-value" name="" placeholder="Значение характеристики">

                                            <span class="input-group-btn" style="margin-left: 5px;">
                                                <button class="btn btn-secondary create-your-self-input on-overlay-loader" type="button" tabindex="-1" myUrl="{{ asset('/company/product/render/yourself/input') }}"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                            </span>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="alert alert-info" role="alert">
                                                    Все характеристики товара
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 render-inputs">
                                                @if(isset($product_items))
                                                    {!! $product_items !!}
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <a class="btn square_btn shadow-custom text-uppercase text-white border-radius-50 next w-100 create-p-next" data-action="2">Далее</a>
                                    </div>
                                </div>

                            </div>
                            <?//End Таб 2?>

                            <?//Таб 3?>
                            <div class="tab-pane fade" id="price" role="tabpanel" aria-labelledby="price-tab">
                                <div class="row mt-4 price-block">
                                    <div class="col-12 col-md-2 offset-md-1 d-md-flex d-none justify-content-center align-items-center border border-right-0 border-blue b-t-l b-b-l">
                                        <i class="fa fa-usd scale-5" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-12 col-md-8 d-flex flex-column justify-content-center p-3 border border-blue b-t-r b-b-r font-weight-bold">

                                        <div class="form-group">
                                            <label for="price">Розничная цена*</label>
                                            <input type="number" step="any" min="0" class="form-control check-price form-price" id="product-price" name="price" placeholder="Укажите цену..." value="{{ $product->price }}" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label for="old-price">Старая цена</label>
                                            <input type="number" step="any" min="0" class="form-control check-price" id="old-price" name="old_price" placeholder="Укажите старую цену..." value="{{ $product->old_price or '' }}" autofocus>
                                        </div>
                                        <div>
                                            <span id="komission">

                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-3">
                                        <a class="btn square_btn shadow-custom text-uppercase text-white border-radius-50 next w-100 create-p-next" data-action="3">Далее</a>
                                    </div>
                                </div>
                            </div>
                            <?//End Таб 3?>

                            <?//Таб 4?>
                            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">

                                <div class="row mt-4">
                                    <div class="col-12 col-md-2 offset-md-1 d-md-flex d-none justify-content-center align-items-center border border-right-0 border-blue b-t-l b-b-l">
                                        <i class="fa fa-picture-o scale-5" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-12 col-md-8 p-3 border border-blue b-t-r b-b-r font-weight-bold">

                                        <div class="mb-2">
                                            <span class="f20">Добавте изображения товара</span><br> первое изображение основное, а остальные<br> в галерею товара (не менее 3-х)
                                        </div>

                                        <div class="w-100">
                                            <input id="product-gallery" type="hidden" name="gallery">
                                            <div class="dropzone" id="dropzoneFileUpload"></div>
                                        </div>

                                        <div class="border-radius bg-secondary p-2 pl-3 mb-2 mt-2">
                                            <a href="{{asset('/company/product/rules')}}" class="text-white" target="_blank"><u>Требования к изображениям</u></a>
                                        </div>

                                        <div class="pl-2">
                                            Добавить ссылки на видео
                                        </div>

                                        <div class="input-group">
                                            <input type="text" class="form-control product-video" id="video-url" name="video" placeholder="URL видео..." value="{{ $product->video_url or '' }}">
                                        </div>

                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 provider-create-product w-100">Редактировать товар</button>
                                    </div>
                                </div>
                                {{--NEW--}}
                            </div>
                            <?//Таб 4?>
                        </div>
                        <?//End Табы?>
                    </div>
                </div>
                <?//End Вся форма?>

            </form>
        </div>
    </div>
    <script type="text/javascript">

        var q = <? echo json_encode($image);?>;
        let mockFile = JSON.parse(q);



        var countImages = 0;
        var imagepath = null;
        var imagesArray = [];
        var gallery = [];
        var baseUrl = "{{ url('/') }}";
        var token = $('meta[name="csrf-token"]').attr('content');
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("div#dropzoneFileUpload", {
            acceptedFiles: 'image/*,.jpg,.png,.jpeg',
            addRemoveLinks: true,
            maxFilesize: 1,
            dictRemoveFile: 'Удалить',
            url: baseUrl+"/dropzone/uploadFiles",
            dictDefaultMessage: "+ Добавить изображение",
            params: {
                _token: token
            },
            init: function () {
                this.on("success", function (data) {
                    imagesArray.push([data.name, data.xhr.responseText]);
                    countImages++;
                    indexArray(imagesArray, countImages);
                    //console.log(imagesArray);
                    checkPrimaryImage();
                });
                this.on("removedfile", function (file) {
                    countImages--;
                    var imageId = findArrayImages(imagesArray, file.name);
                    //console.log(file.name)
                    var image = imagesArray[imageId][1];
                    $.post({
                        url: baseUrl+"/dropzone/deleteFiles",
                        data: {id: image, _token: $('[name="_token"]').val()},
                        dataType: 'json',
                        success: function (data) {
                            if(data['status'] == 'success'){
                                $.toaster({ message : data['message'], title : 'OK!', priority : data['status'], settings : {'timeout' : 3000} });
                            }else if(data['status'] == 'danger'){
                                $.toaster({ message : data['message'], title : 'Sorry!', priority : data['status'], settings : {'timeout' : 3000} });
                            }
                            checkPrimaryImage();
                        }
                    });

                    imagesArray.splice(imageId, 1);
                    indexArray(imagesArray, countImages);
                    //console.log(imagesArray)
                });
            }
        });

        for (var i = 0; i < mockFile.length; i++)
        {
            var dzImage = mockFile[i];
            myDropzone.files.push(dzImage);
            myDropzone.emit('addedfile', dzImage);
            myDropzone.createThumbnailFromUrl(
                dzImage,
                dzImage.url,
                function(thumbnail) {
                    myDropzone.emit('thumbnail', dzImage.url, thumbnail);
                },
                myDropzone.options.thumbnailWidth,
                myDropzone.options.thumbnailHeight,
                myDropzone.options.thumbnailMethod);

            myDropzone.emit('complete', dzImage);

            imagesArray.push([dzImage.name, 'images/uploads/'+dzImage.name]);
            countImages++;
            indexArray(imagesArray, countImages);
            checkPrimaryImage();
            console.log($('#product-gallery').val());
        }

        function findArrayImages(array, value){
            for (var i = 0; i < array.length; i++){
                if (array[i][0] == value){
                    return i;
                }
            }
        }
        function indexArray(array, count){
            if(count == 0){
                $('#product-gallery').val('');
            }else if(count > 0){
                $('#product-gallery').val('');
                var resault = array;
                $('#product-gallery').val('');
                gallery.length=0;
                for(var i = 0; i < resault.length; i++){
                    gallery[i] = resault[i][1];
                }
                $('#product-gallery').val(gallery);
            }
        }

        function checkPrimaryImage(){
            $(".dz-filename").each(function(indx, element){
                var image = $(element).children('span').text();
                $(element).parent('.dz-details').parent('.dz-preview').children('p').remove();
                if(imagesArray[0][0] == image){
                    $(element).parent('.dz-details').parent('.dz-preview').prepend('<p style="position: absolute;border-radius:5px; top:-15px; z-index:12; background:green; color:white; padding: 0px 5px;">Основная</p>');
                }
            });
        }
        $('#name').on('keydown', function(e) {
            $(this).data('_lastKey', e.which);
        });
        $('#name').on('keypress', function(e) {

            var lastKey = +$(this).data('_lastKey');

            if(lastKey < 47 || lastKey > 90)
                return true;

            var letter  = String.fromCharCode(e.which);
            var upper   = letter.toUpperCase();
            var lower    = letter.toLowerCase();
            var isNumeric = lastKey >= 48 && lastKey <= 57;

            var caps = false;

            if(isNumeric)
                caps = (lastKey == e.which && e.shiftKey) || (lastKey != e.which && !e.shiftKey);
            else if( (letter === upper && !e.shiftKey) || (letter === lower && e.shiftKey) )
                caps = !isNumeric;

            if(caps){
                $('#check-caps').html('(Включен CapsLock)');
            }else{
                $('#check-caps').html('');
            }

        });
    </script>
@endsection
