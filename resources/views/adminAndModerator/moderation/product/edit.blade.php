@extends('admin.layouts.app')

@section('stylesheets')
    @parent

    <link rel="stylesheet" href="{{ asset('css/modules/checkbox.css') }}">

@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            @include('provider.company.layouts.breadcrumbs')

            <div class="row">
                <div class="col-12">
                    <h2 class="text-center test-click">Редактирование товара</h2>
                    <div class="dropdown-divider"></div>
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
            <form method="POST" action="{{ asset('admin/moderation/products/'.$product->id) }}" class="form-product">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-pills nav-justified" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="desc-tab" data-toggle="tab" href="#desc" role="tab" aria-controls="desc" aria-selected="true">Основное</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="category-tab" data-toggle="tab" href="#category" role="tab" aria-controls="category" aria-selected="false">Категория\Опции</a>
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
                                            <label for="name">Наименование товара*</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Укажите найменование товара..."  autofocus value="{{ $product->name }}">
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
                                            <input type="text" class="form-control" id="code" myUrl="{{ asset('/company/check/code') }}" product-id="{{ $product->code }}" name="code" placeholder="Артикул..." value="{{ $rest }}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="brand">Торговая марка (бренд)</label>
                                            <input type="text" class="form-control" id="brand" name="brand" placeholder="Бренд..." value="{{ $product->brand }}" autofocus>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="desc">Краткое описание товара</label>
                                            <textarea class="form-control textarea-autosize" id="product-desc" name="desc" rows="3">{{ $product->desc }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-11 offset-1">
                                        <div class="form-group">
                                            <div class="wrapper-checkbox">
                                                <input type="checkbox" class="css-checkbox" id="status-mod" name="status_mod" value="true">
                                                <label for="status-mod" class="css-label">Прошел/не прошел модерацию</label>
                                            </div>
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
                                            <select class="get-subcat-options-select select-1" id="subcategory"  myUrl="{{ asset('/admin/get/subcategory/options') }}" name="subcategory" style="width: 100%;">
                                                @if(isset($subcategories))
                                                    @foreach($subcategories as $subcategory)
                                                        <option value="{{ $subcategory->id }}"
                                                                @if($subcategory->id == $product->subcategory_id)
                                                                selected
                                                                @endif
                                                                data-commission="{{ $subcategory->commission }}">{{ $subcategory->name }} ({{ $subcategory->category->name }} {{ $subcategory->commission }}%)</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="alert alert-info" role="alert">
                                            Выбрать опции по умолчанию
                                        </div>
                                        <label for="subcategory-options">Опции товара
                                            <i class="fa fa-spinner fa-spin fa-fw" id="product-create-subcat-options-spinner" style="display: none"></i>
                                        </label>
                                        <div class="input-group">

                                            <select class="form-control select-2 select-render-inputs" id="subcategory-options" style="width: 91%;" myUrl="{{ asset('admin/moderation/product/render/input') }}">
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
                                            Создать свои опции товара
                                        </div>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="your-self-key" name="" placeholder="Название опции">
                                            <input type="text" class="form-control" id="your-self-value" name="" placeholder="Значение опции">

                                            <span class="input-group-btn" style="margin-left: 5px;">
                                            <button class="btn btn-secondary create-your-self-input on-overlay-loader" type="button" tabindex="-1" myUrl="{{ asset('admin/moderation/product/render/yourself/input') }}"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="alert alert-info" role="alert">
                                                    Все опции товара
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
                                            <label for="price">Розничная цена</label>
                                            <input type="number" step="any" min="0" class="form-control check-price form-price" id="product-price" name="price" placeholder="Укажите цену..." value="{{ $product->price }}" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label for="old-price">Старая цена*</label>
                                            <input type="number" step="any" min="0" class="form-control check-price" id="old-price" name="old_price" placeholder="Укажите старую цену..." value="{{ $product->old_price or '' }}" autofocus>
                                        </div>
										 {{-- апрель2020 --}}
                                        <div class="form-group bg-warning rounded p-1">
                                            <label for="price_promo" class="text-danger text-uppercase">Промо цена</label>
                                            <small class="font-italic">Промо цена должна быть равная или ниже обычной цены</small>
                                            <input type="number" step="any" min="0" class="form-control check-price" id="price_promo" name="price_promo" placeholder="Укажите промо цену..." value="{{ $product->price_promo or '' }}" autofocus>
                                            <small class="form-text">Важно!В день выхода промоакции менять цену или удалять товар категорически <span class="badge badge-danger"> ЗАПРЕЩЕНО!</span></small>
                                        </div>
                                        {{-- апрель2020 --}}
                                    </div>
                                    <div class="col-12">
                                            <span id="komission" class="text-danger">

                                            </span>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="alert alert-info" role="alert">
                                            Добавте изображения товара, первое изображение основное, а остальные в галерею товара (не менее 1-й и не больше 8-ми)
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
                        <button type="submit" class="btn btn-primary provider-create-product w-100">Сохранить изменения</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        var q = <? echo json_encode($image);?>;
        let mockFile = JSON.parse(q);

        var countImages = 0;
        var imagesArray = [];
        var gallery = [];
        var baseUrl = "{{ url('/') }}";
        var token = $('meta[name="csrf-token"]').attr('content');
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("div#dropzoneFileUpload", {
            acceptedFiles: 'image/*,.jpg,.png,.jpeg',
            addRemoveLinks: true,
            maxFilesize: 1,
            dictRemoveFile: '',
            dictCancelUpload: '',
            url: baseUrl+"/dropzone/uploadFiles",
            dictDefaultMessage: "+ Добавить изображение",
            params: {
                _token: token
            },
            init: function () {
                this.on("success", function (file, serverResponse) {
                    var fileName = file.name;
                    var serverFileName = serverResponse.replace(/images\/uploads\//g,"");
                    var serverFilePath = serverResponse;

                    createImageArray(fileName, serverFileName, serverFilePath);
                });
                this.on("removedfile", function (file) {
                    var fileDeletedName = file.name;
                    var rmvFile = "";
                    var imageId = null;

                    for( var f = 0; f < imagesArray.length; f++ ){
                        if(imagesArray[f][0] == fileDeletedName)
                        {
                            imageId = f;
                            rmvFile = imagesArray[f][2];
                        }

                    }
                    countImages--;

                    var image = rmvFile;
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
                        }
                    });

                    imagesArray.splice(imageId, 1);
                    indexArray(imagesArray, countImages);
                    checkPrimaryImage();
                });
            }
        });

        function createImageArray(fileName, serverName, serverPath){
            imagesArray.push([fileName, serverName, serverPath]);
            countImages++;
            indexArray(imagesArray, countImages);
            checkPrimaryImage();
            //console.log(imagesArray);
        }

        $('.dropzone').on('click', '.change-top-image', function () {

            var imageBlock = $(this).next('.prew-item').next('.dz-image').next('.dz-details');
            var newTopImage = imageBlock.children('.dz-filename').children('span').text();

            var indexInArray = null;
            var serverNameImageShort = null;
            var serverNameImageLong = null;
            for (var i = 0; i < imagesArray.length; i++) {
                if( imagesArray[i][0] == newTopImage){
                    indexInArray = i;
                    serverNameImageShort = imagesArray[i][1];
                    serverNameImageLong = imagesArray[i][2];
                }
            }

            imagesArray.splice(indexInArray, 1);
            imagesArray.unshift([newTopImage, serverNameImageShort, serverNameImageLong]);
            var newImagesArray = imagesArray.filter(function(val){return val});
            imagesArray.length=0;
            imagesArray = newImagesArray;

            indexArray(imagesArray, countImages);
            checkPrimaryImage();
            // console.log(imagesArray);
        });

        $('.dropzone').on('click', '.delete-image', function () {
            var prewBlock = $(this).parent('.dz-preview');
            var deleteBtn = prewBlock.find('a');

            deleteBtn.simulateClick('click');
        });

        $.fn.simulateClick = function() {
            return this.each(function() {
                if('createEvent' in document) {
                    var doc = this.ownerDocument,
                        evt = doc.createEvent('MouseEvents');
                    evt.initMouseEvent('click', true, true, doc.defaultView, 1, 0, 0, 0, 0, false, false, false, false, 0, null);
                    this.dispatchEvent(evt);
                } else {
                    this.click(); // IE Boss!
                }
            });
        }

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

            createImageArray(dzImage.name, dzImage.name, 'images/uploads/'+dzImage.name);
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
                    gallery[i] = resault[i][2];
                }
                $('#product-gallery').val(gallery);
            }
        }

        function checkPrimaryImage(){
            $(".dz-filename").each(function(indx, element){
                var image = $(element).children('span').text();
                $(element).parent('.dz-details').parent('.dz-preview').children('.prew-item').remove();
                if(imagesArray[0][0] == image){
                    $(element).parent('.dz-details').parent('.dz-preview').prepend('<div class="prew-item" style="position: absolute;border-radius:5px; left: 12px; top:-15px; z-index:24; background:green; color:white; padding: 0px 5px;">Основная</div><div class="prew-item prew-action delete-image" style="position: absolute;border-radius:12px; right: -11px; bottom:-11px; z-index:24; background:red; color:white; padding: 0px 7px;  opacity: 0.5;" title="удалить изображение">x</div>');
                }else{
                    $(element).parent('.dz-details').parent('.dz-preview').prepend('<div class="prew-item prew-action change-top-image" style="position: absolute;border-radius:12px; right: -11px; top:-11px; z-index:24; background:green; color:white; padding: 0px 7px; opacity: 0.5;"  title="сделать основным">+</div><div class="prew-item prew-action delete-image" style="position: absolute;border-radius:12px; right: -11px; bottom:-11px; z-index:24; background:red; color:white; padding: 0px 7px;  opacity: 0.5;" title="удалить изображение">x</div>');
                }
            });
        }

    </script>
@endsection

@section('script2')

    <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
    <script type="text/javascript">
        autosize($('.textarea-autosize'));
    </script>

@endsection