@extends('provider.company.layouts.app')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            @include('provider.company.layouts.breadcrumbs')

            <div class="row">
                <div class="col-12">
                    <h2 class="text-center test-click">Клонирование товара</h2>
                    <div class="dropdown-divider"></div>
                </div>
            </div>
            <form method="POST" action="{{ asset('company/products') }}" class="form-product">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-pills nav-justified" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="desc-tab" data-toggle="tab" href="#desc" role="tab" aria-controls="desc" aria-selected="true">Основное</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="category-tab" data-toggle="tab" href="#category" role="tab" aria-controls="category" aria-selected="false">Дополнительно</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="price-tab" data-toggle="tab" href="#price" role="tab" aria-controls="price" aria-selected="false">Цены</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="false">Изображения</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="desc" role="tabpanel" aria-labelledby="desc-tab">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="name">Название товара* <span id="check-caps" class="text-danger"></span></label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Укажите найменование товара..."  autofocus value="{{ $product->name }}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex align-items-center h-100 text-uppercase mt-2 ">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <?
                                            $code = $product->code;
                                            $pos = strpos($code, '-');
                                            $rest = substr($code, 1+$pos);
                                            ?>
                                            <label for="code">Артикул*</label>
                                            <input type="text" class="form-control" id="code" myUrl="{{ asset('/company/check/code') }}" product-id="false" name="code" placeholder="Артикул..." value="{{ $rest }}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="brand">Торговая марка (бренд)*</label>
                                            <input type="text" class="form-control" id="brand" name="brand" placeholder="Бренд..." value="{{ $product->brand }}" autofocus>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="desc">Описание товара*</label>
                                            <textarea class="form-control" id="product-desc" name="desc" rows="3">{{ $product->desc }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="category" role="tabpanel" aria-labelledby="category-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
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
                                                        >{{ $subcategory->name }} ({{ $subcategory->category->name }})</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="alert alert-info" role="alert">
                                            Выбрать характеристики по умолчанию
                                        </div>
                                        <label for="subcategory-options">Характеристики товара
                                            <i class="fa fa-spinner fa-spin fa-fw" id="product-create-subcat-options-spinner" style="display: none"></i>
                                        </label>
                                        <div class="input-group">

                                            <select class="form-control select-2 select-render-inputs" id="subcategory-options" style="width: 91%;" myUrl="{{ asset('company/product/render/input') }}">
                                                @if(isset($parametrs))
                                                    @foreach($parametrs as $parametr)
                                                        <option value="{{ $parametr->id }}">{{ $parametr->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="input-group-btn" style="margin-left: 5px; ">
                                            <button class="btn btn-secondary select-subcat-option on-overlay-loader" type="button" tabindex="-1" ><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </span>
                                        </div>
                                        <br>
                                        <div class="alert alert-info" role="alert">
                                            Создать свои характеристики товара
                                        </div>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="your-self-key" name="" placeholder="Название характеристики">
                                            <input type="text" class="form-control" id="your-self-value" name="" placeholder="Значение характеристики">

                                            <span class="input-group-btn" style="margin-left: 5px;">
                                            <button class="btn btn-secondary create-your-self-input on-overlay-loader" type="button" tabindex="-1" myUrl="{{ asset('/company/product/render/yourself/input') }}"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
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
                                <br>
                            </div>

                            <div class="tab-pane fade" id="price" role="tabpanel" aria-labelledby="price-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="price">Розничная цена*</label>
                                            <input type="number" step="any" min="0" class="form-control check-price form-price" id="product-price" name="price" placeholder="Укажите цену..." value="{{ $product->price }}" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label for="old-price">Старая цена</label>
                                            <input type="number" step="any" min="0" class="form-control check-price" id="old-price" name="old_price" placeholder="Укажите старую цену..." value="{{ $product->old_price or '' }}" autofocus>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="alert alert-info" role="alert">
                                            Добавте изображения товара, первое изображение основное, а остальные в галерею товара
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <input id="product-gallery" type="hidden" name="gallery">
                                        <div class="dropzone" id="dropzoneFileUpload"></div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="alert alert-info" role="alert">
                                            Добаить ссылки на видео
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control product-video" id="video-url" name="video" placeholder="URL видео..." value="{{ $product->video_url or '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary provider-create-product w-100">Создать клон</button>
                    </div>
                </div>
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
                myDropzone.options.thumbnailMethod,
            );
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
