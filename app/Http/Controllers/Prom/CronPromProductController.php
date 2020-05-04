<?php

namespace App\Http\Controllers\Prom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Stream;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Exception\NotReadableException;
use App\PromProduct;
use App\PromCategory;
use App\Currency;
use App\Subcategory;
use App\Company;
use App\Product;
use App\ProductsItem;

class CronPromProductController extends Controller
{
    //предпроверка товаров на наличие категории
    public function predAuditProductYml(){
        $products = PromProduct::where('confirm', '0')->orderBy('external_id', 'asc')->take(100)->get();
        foreach ($products as $product) {
            $data_errors = [];
            if(!isset($product->promCat()[0])){
                $data_errors[] = 'Не найдена соответствующая категория товара!';
                $change_product = PromProduct::find($product->id);
                $change_product->confirm = '4';
                $change_product->data_error = json_encode($data_errors);
                $change_product->save();
            }
        }
    }

    //планировщик для проверки товаров во временном хранилище
    public function auditProductYml(){
        $products = PromProduct::where('confirm', '1')->orderBy('external_id', 'asc')->take(100)->get();


        foreach ($products as $product) {
            $load_flag = true;
            $data_errors = [];
            // $product = PromProduct::where('confirm', '1')->firstOrFail();
            $external_id = $product->external_id;


            if ($product->market_id == '' || $product->market_id == null) {
                $load_flag = false;
                $data_errors[] = 'Не указана категория товара!';
            }else{
                $prom_cats = PromCategory::where('external_id', $external_id)->get()->toArray();
                if (!in_array($product->market_id, array_pluck($prom_cats, 'market_id'))) {
                    $load_flag = false;
                    $data_errors[] = 'Отсутствует категория!';
                }
            }

//            $check_products = PromProduct::where('external_id', $external_id)->where('id', '<>', $product->id)->get();
//            if (in_array($product->offer_id, array_pluck($check_products, 'offer_id'))) {
//                $load_flag = false;
//                $data_errors[] = 'Не уникальные идентификаторы товара, "offer_id"!';
//            }


            if ($product->name == '' || $product->name == null) {
                $load_flag = false;
                $data_errors[] = 'Не указано найменование товара!';
            }

            if ($product->desc == '' || $product->desc == null) {
                $load_flag = false;
                $data_errors[] = 'Не указано описание товара!';
            }

            if ($product->code == '' || $product->code == null) {
                $load_flag = false;
                $data_errors[] = 'Нет артикула товара!';
            }
//            else{
//                $search_real_company_product = Product::where('company_id', $product->company_id)->where('code', $product->comapny_id."-".$product->code)->get();
//                if($search_real_company_product->count() > 0){
//                    $load_flag = false;
//                    $data_errors[] = 'Товар с таким артикулом уже существует!';
//                }
//
//                if (in_array($product->code, array_pluck($check_products, 'code'))) {
//                    $load_flag = false;
//                    $data_errors[] = 'Дублирующий артикул товара в данном пакете товаров!';
//                }
//            }

//            if ($product->price == '' || $product->price == null) {
//                $load_flag = false;
//                $data_errors[] = 'Не указана цена товара!';
//            }

            if ($product->gallery == '' || $product->gallery == null) {
                $load_flag = false;
                $data_errors[] = 'Отсутствуют изображения товара!';
            } else {
                if (self::isJson($product->gallery)) {
                    $json_array_image = json_decode($product->gallery);
                    $no_img = false;
                    $no_link = false;
                    foreach ($json_array_image as $image) {
                        if($image->public_path != ''){
                            if (preg_match('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)([^\s]+(\.(?i)(jpg|png|gif|bmp|jpeg))$)@',
                                (string) trim($image->public_path))) {
                                $headers = @get_headers(trim($image->public_path));
                                if (!preg_match("|200|", $headers[0])) {
                                    if(preg_match("|302|", $headers[0])){
                                        if (!preg_match("|200|", $headers[7])){

                                            $no_link = true;
                                        }
                                    }elseif(preg_match("|301|", $headers[0])){
                                        if (!preg_match("|200|", $headers[6])){

                                            $no_link = true;
                                        }
                                        if (preg_match("|200|", $headers[7])){
                                            $no_link = false;
                                        }
                                    }else{
                                        $no_link = true;
                                    }
                                }
                            } else {
                                $no_img = true;
                            }
                        }
                    }
					//$no_img = false;
                    if ($no_img) {
                        $load_flag = false;
                        $data_errors[] = 'Есть файлы, которые не является изображением или расширения файла недопустимое!';
                    }
                    if ($no_link) {
                        $load_flag = false;
                        $data_errors[] = 'Есть изображения, к которым нет публичного доступа "Битая ссылка"!';
                    }
                } else {
                    $load_flag = false;
                    $data_errors[] = 'Список изображений не является JSON объектом!';
                }
            }

            if ($product->options == '' || $product->options == null) {
                //$load_flag = true; отключено (товары могут добавляться без характеристик) 29.11.2018
                //$data_errors[] = 'Отсутствуют характеристики товара!';
            } else {
                if (!self::isJson($product->options)) {
                    $load_flag = false;
                    $data_errors[] = 'Список характеристик товара не является JSON объектом!';
                }
            }

            if ($product->currency == '' || $product->currency == null) {
                $load_flag = false;
                $data_errors[] = 'Не указана валюта!';
            } else {
                $curen = Currency::all();
                if (!in_array($product->currency, array_pluck($curen->toArray(), 'code'))) {
                    $load_flag = false;
                    $data_errors[] = 'Данной валюты нет в базе данных или не верно указано его имя!';
                }
            }

            if ($product->status_available == '' || $product->status_available == null) {
                $load_flag = false;
                $data_errors[] = 'Отсутствуют данные о наличии товара!';
            } else {
                if (!in_array($product->status_available, ['0', '1'])) {
                    $load_flag = false;
                    $data_errors[] = 'Не верный формат парметра available должно быть или "true" ,или "false"!';
                }
            }

            $change_product = PromProduct::find($product->id);
            if (!$load_flag) {
                $change_product->confirm = '4';
                $change_product->data_error = json_encode($data_errors);
                $change_product->save();
            } else {
                $change_product->confirm = '2';
                $change_product->data_error = null;
                $change_product->save();

            }

        }
    }

    //проверка для json массива или обьекта
    private function isJson($string) {
        return ((is_string($string) &&
            (is_object(json_decode($string)) ||
                is_array(json_decode($string))))) ? true : false;
    }

    public function uploadAuditedProductsToCompany(){
        $products = PromProduct::where('confirm', '2')->take(20)->get();

      // dd($products);
        foreach ($products as $product) {

            $product_prom_cat = PromCategory::where('market_id', $product->market_id)->where('external_id', $product->external_id)->first();//->subcategory_id (null, no-def)
            $subcategory_id = $product_prom_cat->subcategory_id;

            $search_subcat = Subcategory::find($subcategory_id);
            $category_id = $search_subcat->category_id;//->category_id (not null, no-def)

            $name = $product->name;//->name (not null, no-def, 	varchar(180))

            $desc = $product->desc;//->desc (not null, no-def, 	longText())

            $code = $product->code;//->code (not null, no-def, 	varchar(50))

            $currency_code = Currency::where('code', $product->currency)->first();
            $currency_id = $currency_code->id;//->currency_id (not null, def(1), int(10))

            if($product->price == '' || $product->price == null){
                $price = 0;
            }else{
                $price = $product->price;
            }
            //->price (not null, no-def, double(20,2))

            $company_id = $product->company_id;//->company_id (not null, no-def, int(10))
            $search_company = Company::find($company_id);

            if($search_company->block_bal == '0' && $search_company->block_new == '0' && $search_company->block_ab == '0' && $search_company->blocked == '0'){
                $status_spatial = '1';
            }else{
                $status_spatial = '0';
            }//->status_spacial (not null, no-def, enum('0', '1'))

            $user_id = $search_company->users[0]->id;//->user_id (not null, no-def, int(10))

            $upload_type = '1';//->upload_type (not null, def(0), enum('0', '1', '2'))

            $external_id = $product->external_id;//->external_id (null, no-def, int(10))

            $status_available = ($product->status_available)?$product->status_available:'1';//->status_available (not null, def(1), enum('0', '1'))

            //переменные для создания товара с ошибками
            $flag_moderation_error = false;
            $count_moderation_errors = 0;
            $data_mod_short_error = [];
            $data_mod_long_error = [];

            //проверка наличия бренда товара
            if ($product->brand == '' || $product->brand == null) {
                $flag_moderation_error = true;
                $count_moderation_errors++;

                array_push($data_mod_short_error, 'Не указан бренд товара');
                array_push($data_mod_long_error, 'В товаре не указан бренд товара, редактируйте товар и замените "Error(brand not found)"');

                $brand = 'Error(brand not found)';//->brand (not null, no-def, varchar(180))
            }else{
                $brand = $product->brand;
            }

            //проверка на наличие одинаковых артикулов товара как созданых, так и в пакете ХМЛ
            $check_products = PromProduct::where('external_id', $external_id)->where('id', '<>', $product->id)->get();
            $search_real_company_product = Product::where('company_id', $product->company_id)->where('code', $product->comapny_id."-".$product->code)->get();

            if($search_real_company_product->count() > 0){
                $flag_moderation_error = true;
                $count_moderation_errors++;

                array_push($data_mod_short_error, 'Дубликат артикула');
                array_push($data_mod_long_error, 'Товар с таким артикулом уже существует!');

            }

            if (in_array($product->code, array_pluck($check_products, 'code'))) {
                $flag_moderation_error = true;
                $count_moderation_errors++;

                array_push($data_mod_short_error, 'Дубликат артикула');
                array_push($data_mod_long_error, 'Дублирующий артикул товара в данном пакете товаров!');
            }


            //flag для создания товара с ошибками и отправкой на доработку пользователю
            if($flag_moderation_error){

                $data_error = self::createDataErrorForProduct($count_moderation_errors, $data_mod_short_error, $data_mod_long_error);//->data_error (null, no-def, longtext())
                $status_moderation = '2';//->status_moderation (not null, def(0), enum('0', '1', '2', '3'))
            }else{
                $status_moderation = '0';
            }

            //create product gallery
            $json_gallery = $product->gallery;
            $array_gallery = json_decode($json_gallery);
            $gallery = self::storageCloudFromS3Drive($array_gallery); //->gallery (not null, no-def, longText())

            $upload_product = Product::updateOrCreate(
                [
                    'company_id' => $company_id,
                    'upload_offer_id' => $product->offer_id,
                    'external_id' => $external_id,
                ],
                [
                'company_id' => $company_id,
                'user_id' =>  $user_id,
                'category_id' => $category_id,
                'subcategory_id' => $subcategory_id,
                'name' => $name,
                'desc' => $desc,
                'code' => $company_id.'-'.$code,
                'brand' => $brand,
                'currency_id' => $currency_id,
                'price' => $price,
                'gallery' => $gallery,
                'status_spacial' => $status_spatial,
                'upload_type' => $upload_type,
                'external_id' => $external_id,
                'status_available' => $status_available,
                'status_moderation' => $status_moderation,
                'data_error' => (isset($data_error))?json_encode($data_error):null,
                ]
            );

            if(!($product->options == '' || $product->options == null)){
                self::createProductItems($upload_product->id, json_decode($product->options));
            }

            $change_product = PromProduct::find($product->id);
            $change_product->confirm = '3';
            $change_product->upload = '1';
            $change_product->product_id = $upload_product->id;
            $change_product->data_error = null;
            $change_product->save();
        }


    }

    private function createDataErrorForProduct($count, $data_short, $data_long){
        if($count == 1){
            $data_error =[
                'short_error' => $data_short[0],
                'long_error' => $data_long[0]
            ];

            return $data_error;
        }else{
            $data_error =[
                'short_error' => 'некорректный контент',
                'long_error' => implode("\n", $data_long)
            ];
            return $data_error;
        }
    }

    // получение публичного адреса изображения обработка и сохранение на амазоне, ответ json(object) с новым именем и публичным адресом изображения
    private function storageCloudFromS3Drive($array_image){
        $width = null;
        $height = 850;

        $array = [];
        for ($i=0; $i < count($array_image); $i++) {

                $file_name = trim($array_image[$i]->name);
                $file_path = trim($array_image[$i]->public_path);

                $new_name = self::renameImagesForS3Drive($file_name);

                Image::configure(array('driver' => 'gd'));


                try {
                    $image = Image::make($file_path);
                } catch (NotReadableException $e) {
                    $new_name = self::renameImagesForS3Drive('no_foto.png');
                    $image = Image::make('https://bigsales.pro/images/no_foto.png');
                }

                $image->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    //            $constraint->upsize();
                })->encode('jpg');

                Storage::disk('s3')->put($new_name, (string)$image, 'public');

                $url_upload_image = Storage::disk('s3')->url($new_name);

                $array[] = [
                    'name' => $new_name,
                    'public_path' => $url_upload_image
                ];

        }

        return json_encode($array);
    }

    private function createProductItems($product_id, $param_array){
        $id = $product_id;

        foreach ($param_array as $param){
            if((isset($param->name)) && (isset($param->value))){
                $param_name = $param->name;
                $param_value = $param->value;
                $data = [
                    'attr_type' => 'your_self',
                    'parametr' => $param_name,
                    'value' => $param_value
                ];
                ProductsItem::updateOrCreate(
                    [
                        'product_id' => $id,
                        'name' => $param_name ,
                        'value' => $param_value
                    ],
                    [
                        'product_id' => $id,
                        'name' => $param_name ,
                        'value' => $param_value,
                        'data' => json_encode($data)
                    ]
                );
            }
        }
    }

    private function renameImagesForS3Drive($filename){
        $format_file = stristr($filename, '.');
        $new_name = sha1(date('YmdHis').str_random(30)).$format_file;
        return $new_name;
    }

    public function deleteImagesFromS3Amazon($file_name){
        Storage::disk('s3')->delete($file_name);
    }


    // функция презаписи изображений повторно 05.11.2018(может пригодиться в будущем)
    public function reuploadImages(){
        $prom_product = PromProduct::where('upload', '0')->whereNotNull('product_id')->first();
        $product = Product::find($prom_product->product_id);

        $array = json_decode($product->gallery);
        for($i=0; $i<count($array);$i++){
            $file_name = $array[$i]->name;
            Storage::disk('s3')->delete($file_name);
        }

        $json_gallery = $prom_product->gallery;
        $array_gallery = json_decode($json_gallery);
        $gallery = self::storageCloudFromS3Drive($array_gallery);

        $product->gallery = $gallery;
        $product->save();

        $prom_product_new = PromProduct::find($prom_product->id);
        $prom_product_new->upload = '1';
        $prom_product_new->save();
        dd($product);
    }

}