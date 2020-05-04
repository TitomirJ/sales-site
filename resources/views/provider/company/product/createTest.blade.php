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
                    Создание товара
                </div>
            </div>

            <form method="POST" action="{{ asset('company/product/stest') }}" class="form-product">
                {{ csrf_field() }}
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
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Укажите найменование товара..."  autofocus>
                                        </div>

                                        <div class="form-group">
                                            <label for="code">Артикул*</label>
                                            <input type="text" class="form-control" id="code" myUrl="{{ asset('/company/check/code') }}" product-id="null" name="code" placeholder="Артикул..."  autofocus>
                                        </div>

                                        <div class="form-group">
                                            <label for="brand">Торговая марка (бренд)*</label>
                                            <input type="text" class="form-control" id="brand" name="brand" placeholder="Бренд..." autofocus>
                                        </div>

                                        <div class="form-group">
                                            <label for="desc">Описание товара*</label>
                                            <textarea class="form-control textarea-autosize" id="product-desc" name="desc" rows="3"></textarea>
                                        </div>

                                    </div>

                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <a class="btn square_btn shadow-custom text-uppercase text-white border-radius-50 w-100 create-p-next" data-action="1">Далее</a>
                                    </div>
                                </div>
                            </div>

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
                                                <option value="false">Выбирете подкатегорию</option>
                                                @forelse($subcategories as $subcategory)
                                                    <option value="{{ $subcategory->id }}" data-commission="{{ $subcategory->commission }}">{{ $subcategory->name }} ({{ $subcategory->category->name }})</option>
                                                @empty
                                                    <option>Подкатегории отсутствуют</option>
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="alert bg-primary border-radius-50 mt-3 text-white" role="alert">
                                            Добавить характеристики товара по умолчанию
                                        </div>

                                        <div class="input-group mb-1">
                                            <div style="width: 85%;">
                                                <select class="custom-select select-render-inputs form-control s-sub-opt" id="subcategory-options"  myUrl="{{ asset('company/product/render/input') }}">

                                                </select>

                                            </div>
                                            <div style="width: 15%;">
                                                <button class="btn btn-secondary select-subcat-option on-overlay-loader" style="float: right;" type="button" tabindex="-1" ><i class="fa fa-plus" aria-hidden="true"></i></button>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <div class="alert bg-primary border-radius-50 text-white" role="alert">
                                                    Все характеристики товара
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 render-inputs"></div>
                                        </div>

                                        <div class="alert bg-primary border-radius-50 mt-3 text-white" role="alert">
                                            Добавить свои характеристики товара
                                        </div>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="your-self-key" name="" placeholder="Название характеристики">
                                            <input type="text" class="form-control" id="your-self-value" name="" placeholder="Значение характеристики">

                                            <span class="input-group-btn" style="margin-left: 5px;">
                                        <button class="btn btn-secondary create-your-self-input on-overlay-loader" type="button" tabindex="-1" myUrl="{{ asset('/company/product/render/yourself/input') }}"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </span>
                                        </div>

                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <a class="btn square_btn shadow-custom text-uppercase text-white border-radius-50 next w-100 create-p-next" data-action="2">Далее</a>
                                    </div>
                                </div>


                            </div>

                            <?//Таб 3?>
                            <div class="tab-pane fade" id="price" role="tabpanel" aria-labelledby="price-tab">
                                <div class="row mt-4 price-block">
                                    <div class="col-12 col-md-2 offset-md-1 d-md-flex d-none justify-content-center align-items-center border border-right-0 border-blue b-t-l b-b-l">
                                        <i class="fa fa-usd scale-5" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-12 col-md-8 d-flex flex-column justify-content-center p-3 border border-blue b-t-r b-b-r font-weight-bold">

                                        <div class="form-group">
                                            <label for="price">Розничная цена*</label>
                                            <input type="number" step="any" min="0" class="form-control check-price form-price" id="product-price" name="price" placeholder="Укажите цену..." autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label for="old-price">Старая цена</label>
                                            <input type="number" step="any" min="0" class="form-control check-price" id="old-price" name="old_price" placeholder="Укажите старую цену..." autofocus>
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

                            <?//Таб 4?>
                            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">

                                <div class="row mt-4">
                                    <div class="col-12 col-md-2 offset-md-1 d-md-flex d-none justify-content-center align-items-center border border-right-0 border-blue b-t-l b-b-l">
                                        <i class="fa fa-picture-o scale-5" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-12 col-md-8 p-3 border border-blue b-t-r b-b-r font-weight-bold">

                                        <div class="mb-2">
                                            <span class="f20">Добавте изображения товара</span><br> первое изображение основное, а остальные<br> в галерею товара (не менее 1-й и не больше 8-ми)
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
                                            <input type="text" class="form-control product-video" id="video-url" name="video" placeholder="URL видео...">
                                        </div>

                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 provider-create-product w-100">Создать товар</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 provider-create-product w-100">Создать товар</button>
                    </div>
                </div> -->
            </form>
        </div>
    </div>
    <script type="text/javascript">
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

@section('script2')

    <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
    <script type="text/javascript">
        autosize($('.textarea-autosize'));
    </script>

@endsection
