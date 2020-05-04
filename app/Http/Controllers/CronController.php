<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProviderAbBlock;
use App\Functions\StaticFunctions as SF;
use App\Company;
use App\Product;
use App\Order;
use App\TreshedImage;
use App\User;
use App\Subcategory;
use App\SubcategoriesOption;
use App\Parametr;
use App\Value;
use App\ParametrsValue;
use App\SubcategoriesParametr;
use App\Usetting;
use App\Test;
use App\Transaction;
use Carbon\Carbon;
use Notification;
use App\Notifications\AdminCompanyAbonimentEndedShipped;
use App\PromExternal;

use App\Autoupdate;
use App\Tempcompany;

class CronController extends Controller
{
    public function checkAbonimentCompany(){

        $companies = Company::where('block_ab', '0')->get();

        foreach ($companies as $c){
            $company_id = $c->id;
            $company = Company::find($company_id);
            $date = $company->ab_to;

            $flag = self::checkDatesAbonimentCompany($date);
            if($flag){
                $company->block_ab = '1';
                if($company->block_new == '1'){
                    $company->block_new = '0';
                }
                $company->save();

                self::sendEmailToProviderAboutAbBlock($company->id);

                DB::table('products')
                    ->where('company_id', $company_id)
                    ->update(['status_spacial' => '0']);
            }
        }


     //   Company::where('id', 12)->update(['ab_to' => '2018-09-12 23:59:59']);
    }

    private function sendEmailToProviderAboutAbBlock($company_id){
       $company = Company::find($company_id);
       $search_user = null;
       foreach ($company->users as $user){
           if($user->isProviderAndDirector()){
               $search_user = $user;
           }
       }
        Mail::to($search_user->email)->send(new ProviderAbBlock($company));
    }

    private function checkDatesAbonimentCompany($date_ab){
        $date_now = time();
        $date_check = strtotime($date_ab);

        if($date_now > $date_check){
            return true;
        }else{
            return false;
        }
    }

    public function cancelOrderCompany(){
        $orders = Order::where('status', '0')->get();
        foreach ($orders as $order){
            self::checkDateOrder($order->id);
        }
    }

    private function checkDateOrder($order_id){
        $order = Order::find($order_id);
        $index_day = 86400;
        $date_now = time();
        $date_order = strtotime($order->created_at)+$index_day;
        if($date_now > $date_order){
            $order->status = '2';
            $order->save();

            // отключена смена статуса отмены заказа на маркетах системой 08.01.2019г
            //self::changeStatusCancelToMarketplace($order);
        }
    }

    private function changeStatusCancelToMarketplace($order){
        if($order->marketplace_id == '2'){

            $data = [
                'market_place_id' => $order->marketplace_id,
                'market_id' => $order->market_id,
                'status' => '2',
                'cancellation_reason' => 'another',
                'cancellation_text' => 'Заказ отменен!'
            ];
            $client = new \GuzzleHttp\Client();

            $client->post(
                'https://smart-plus.herokuapp.com/market-place/update-status',
                [
                    \GuzzleHttp\RequestOptions::JSON => $data
                ],
                ['Content-Type' => 'application/json']
            );
        }
    }



    public function parcing(){
       $setting = Usetting::find(6);
       $step =  $setting->n_par_5;
       $setting->n_par_5 = $step+1;
       $setting->save();

       if($setting->n_par_5 < 4960){

           $option =  Test::find($step);

                   $json_data =  $option->options;
                   $array_data = json_decode($json_data, true);

                   for ($i=0; $i < count($array_data); $i++){
                       $parametr = Parametr::firstOrCreate(
                           ['rozet_id' => $array_data[$i]['id']],
                           [
                               'rozet_id' => $array_data[$i]['id'],
                               'name' => $array_data[$i]['name'],
                               'attr_type' => $array_data[$i]['attr_type'],
                           ]
                       );



                       SubcategoriesParametr::firstOrCreate(
                           [
                               'subcategory_id' => $option->subcategory_id,
                               'parametr_id' => $parametr->id,
                           ],
                           [
                               'subcategory_id' => $option->subcategory_id,
                               'parametr_id' => $parametr->id,
                           ]
                       );



                       if(($array_data[$i]['value_id'] != null) && ($array_data[$i]['value_id'] != '')){
                           $value = Value::firstOrCreate(
                               ['rozet_id' => $array_data[$i]['value_id']],
                               [
                                   'rozet_id' => $array_data[$i]['value_id'],
                                   'name' => $array_data[$i]['value_name'],
                               ]
                           );

                           ParametrsValue::firstOrCreate(
                               [
                                   'parametr_id' => $parametr->id,
                                   'value_id' => $value->id,
                               ],
                               [
                                   'parametr_id' => $parametr->id,
                                   'value_id' => $value->id,
                               ]
                           );

                       }


                   }
               }



    }

    public function deleteTrashImages(){


        $all_trash_images = TreshedImage::where('created_at', '<', date('Y-m-d').' 00:00:00')->limit(3000)->get();

        foreach ($all_trash_images as $image){
            if(file_exists (public_path($image->image_path) )){
                unlink($image->image_path);
            }
            $image->delete();
        }
    }

    public function checkCompanyAbonimentForNotifyAdmin(){
        $time_stamp = Carbon::now()->addHour('12')->toDateTimeString();

        $companyes = Company::where('ab_to', '<=', $time_stamp)->where('ab_from', null)->where('block_ab', '0')->get();

        if($companyes){
            $time_now = Carbon::now()->toDateTimeString();
            $time_stamp_pre =  Carbon::now()->timestamp;

            $users = User::all();
            $personnel_bigsales = collect($users)->filter(function ($item, $key) {
                if ($item->isAdmin()) {
                    return true;
                }
            });

            foreach ($companyes as $company){
                Company::where('id', $company->id)->update(['ab_from' => $time_now]);
                Notification::send($personnel_bigsales, new AdminCompanyAbonimentEndedShipped($company, $company->id.$time_stamp_pre));
            }
        }
    }


	 /**
     * февраль 2020
     * автообновление xml файла от пользоваетелей
     * через cron установить время в которое будет срабатывать
     * формирует массив компании у которых выбран режим автообновления
     * и обрабатывает каждую компанию (файл) перезаписывая данные , а если нет такого товара
     * в файле формирует новый xml и скармливает его системе на парсинг
     */
    public function autonew()
    {

	/**
     * переменная для того чтобы определять день недели
     * чтобы в выходные не формировался файл xml с новыми товарами
     * а автообновление происходило (апрель2020)
     */
    $flag_day_work = self::dayWorkWeek();
		
		$start = microtime(true);

		$comp_id = Tempcompany::whereNotNull('company_id')->first();
		$comp = Company::find($comp_id->company_id);
        //$company_w_autoupdate = Company::where('update_auto','!=',NULL)->get();

       //foreach($company_w_autoupdate as $comp){

        // для отчета об обновлении о ошибках
            $errors_update = NULL;
            $info_updates = [];
		//обновленные товары
            $updated_product = [];
		// массив для тех товаров которые есть в файле, но не найдены в БД (products)
        $product_new_from_xmlfile = [];
        // количество обновленных товаров
        $update_product_count = 0;

            $company_id = $comp->id;
            $setting_autoupdate_in_bd = json_decode($comp->update_auto);

            $item_in_file_xml = $setting_autoupdate_in_bd[0];
            $item_not_file_xml = $setting_autoupdate_in_bd[1];

			//\Log::info($setting_autoupdate_in_bd[2].' company: '.$company_id);
		//\Log::info(empty($setting_autoupdate_in_bd[2]));
           if(!empty($setting_autoupdate_in_bd[2])){

            /**
             * в setting_autoupdate_in_bd[2] хранится id ссылки
             * по которой происходит автообновление товаров
             * в url_xml_file записывается сама ссылка
             */
            $url_in_bd= Autoupdate::find($setting_autoupdate_in_bd[2]);
            $url_xml_file = $url_in_bd->url_xml;



            //dd($url_xml_file);



        $url_xml_status = get_headers($url_xml_file);
         //dd($url_xml_status);
        /**
         * доступность ссылки на файл xml, если доступно статус 200
         * то включить его в работу
         *
         */
    if (preg_match("|200|", $url_xml_status[0])){

        if(self::isXMLFileValid($url_xml_file)){


        $xmlData = new \SimpleXMLElement($url_xml_file,null,true);

        /**
         * сравнить даты чтобы принять решение - обрабатывать данный файл или не надо
         * дата в таблице БД  и дата в самом файле
         */
        $date_in_file = $xmlData[0]['date'];
        //dd($comp->autoupdates->url_xml);

        /**
         * если нет даты последнего автообновления в БД (autoupdates-date_update)
         * формируется дата отличающаяся от даты в файле от пользователя
         * для того чтобы произвести автообновление и записать в БД дату обновления для последующих
         * сравнений изменения файла
         */
        if($url_in_bd->date_update == NULL || !isset($url_in_bd->date_update) || $url_in_bd->date_update ==''){
            $carbon = new Carbon($date_in_file);
            $date_autoupdate = $carbon->subDay();
        }else{
            $date_autoupdate = $url_in_bd->date_update;
        }




        /**
         * обработка файла начинается если дата в полученном файле
         * свежее чем дата в БД
         */
        if($date_in_file > $date_autoupdate){

            //сразу все товары достать чтобы поиск id был не по БД
            $temp_prod = Product::where('company_id',$company_id)->get();

            foreach($xmlData->xpath('//offer') as $item){
                /**
                 * данные для обновления существующих продуктов в БД
                 * которые указаны в файле xml
                 * артикул,наличие,цена,старая цена
                 */
                if(isset($item->vendorCode) && $item->vendorCode != ''){
					//$articul_from_xmlfile = $company_id.'-'.trim($item->vendorCode);
					$articul_from_xmlfile = $company_id.'-'.$item->vendorCode;
				}else{
					//$articul_from_xmlfile = $company_id.'-'.trim($item['id']);
					$articul_from_xmlfile = $company_id.'-'.$item['id'];
                }

				/**
                * articul_id_xmlfile переменная для поиска товара в БД по id offer
                * для случаев если товар был записан в БД по id offer а не по vendorCode
                */
                $articul_id_xmlfile = $company_id.'-'.$item['id'];

                $available_from_xmlfile = isset($item['available']) ? trim($item['available']) :'true';

                $price_from_xmlfile = self::validateValueInXmlFile($item->price);
                $price_from_xmlfile = $price_from_xmlfile ? $price_from_xmlfile : false;

                $old_price_from_xmlfile = self::validateValueInXmlFile($item->oldprice);
                $old_price_from_xmlfile = $old_price_from_xmlfile ? $old_price_from_xmlfile : false;

                //echo $available_from_xmlfile.' available <br>'.$articul_from_xmlfile.'<br>'.$item->name.'<br>price: '.$price_from_xmlfile.'<br>old_price: '. $old_price_from_xmlfile.'<br>';

				/**
                 * нахождение товара  по коду и перезапись его данных если
                 * такой есть в БД
                 */
                $prod_id_inbd = self::searchIdProductInBd($temp_prod,$articul_from_xmlfile);

				/**
                 * товар может быть записан в БД по id атрибуту offer ,а не по
                 * vendorCode, потому если не найден товар по коду надо поискать его и по id offer
                 * чтобы не искатть одно и тоже, сравнивается значение кода и айди ,если они одинаковы
                 * то нет смысла искать и по айди
                 */
                if(!$prod_id_inbd && $articul_from_xmlfile != $articul_id_xmlfile){
                    $prod_id_inbd = self::searchIdProductInBd($temp_prod,$articul_id_xmlfile);
                }


                if(!$prod_id_inbd){
                    /**
                     * если товар не найден в БД то добавить его в массив новых товаров
                     * чтобы в дальнейшем сформировать xml файл и отправить его на парсинг
                     */
                    //echo '<br>товар не найден будет добавлен как новый<br><hr>';
					
                    //array_push($product_new_from_xmlfile,$item);
					if($flag_day_work){
                        array_push($product_new_from_xmlfile,$item);                
                    }

                }else{
                    /**
                     * при нахождении товара в БД произвести обновление
                     * информации в зависимости от настроек автообновления выбранных пользователем
                     * которые хранятся в таблице Companies поле update_auto
                     */
                    //echo '<br>товар есть в БД<br>';

					 $item = Product::find($prod_id_inbd);

					$a=$p=$op=false;

                        switch($item_in_file_xml){
                                case "all":
                                    $a = self::change_available_product($item,$available_from_xmlfile);

                                    $p = self::change_price_product($item,$price_from_xmlfile);

                                 if($old_price_from_xmlfile){

                                    $op = self::change_oldprice_product($item,$old_price_from_xmlfile);
                                }
                                break;

                                case "price":
                                   $p = self::change_price_product($item,$price_from_xmlfile);

                                 if($old_price_from_xmlfile){

                                    $op = self::change_oldprice_product($item,$old_price_from_xmlfile);
                                }
                                break;

                                case "avai":
                                   $a = self::change_available_product($item,$available_from_xmlfile);
                                break;

                            }

							/**
                             * в случае если есть изменение т.е. отличие
                             * чего либо в файле и БД то проивести перезапись
                             */
							if($a==true||$p==true||$op==true){
                                $item->save();
                                $update_product_count++;

                            }

                        //TO DO ВКЛЮЧИТЬ на продакшене save!!!!!
                        //$item->save();
                        //echo $item->name.'<br>перезаписаны данные<hr>';
                        //$update_product_count++;

								/**
                                 * если в настройках автообновления выбрано выводить товар из маркета
                                 * который не указан в xml файле,то получить масив обновленных
                                 * для дальнейшей обработки (часть1)
                                 */
                                if($item_not_file_xml == 'to_exit'){
                                    array_push($updated_product,$item->id);
                                }

                }
            }
            // ----- end foreach xmlData обработка файла xml полученного от пользователя

             //dd($product_new_from_xmlfile);

			/**
              * обнуление наличия товаров тех которых нет в файле
              */
             if($item_not_file_xml == 'to_exit'){


                if(count($updated_product) > 0){

                    $items_change_avai = Product::where('company_id',$company_id)
                            ->whereNotIn('id', $updated_product)
                            ->update(['status_available' => '0']);


                }else{

                    $items_change_avai = Product::where('company_id',$company_id)
                            ->update(['status_available' => '0']);


                }

            }

             /**
              * теперь те товары которые не были найдены в БД отправляются в работу
              * формируется xml файл и загружается в систему
              */
            if(count($product_new_from_xmlfile) > 0){
               self::makeXmlFileAutoUpdate($product_new_from_xmlfile,$xmlData,$company_id);
            }

            /**
             * формируется дата для записи в БД
             * как отметка об обновлении для последующих сравнений
             * на наличие изменений в файле
             */
            $date_update_now = Carbon::now()->format('Y-m-d H:i:s');

            $url_in_bd->date_update = $date_update_now;
            $url_in_bd->save();


            /**
             * в случае когда дата из полученного файла не отличается
             *  от даты обработки этого же файла в БД.
             * (перезапись данных о товарах игнорируется)
             */
        }else{

            //echo 'у компании с id : '.$company_id.' Данные в файле не обновлялись после ' .$url_in_bd->date_update;
			 \Log::info('у компании с id : '.$company_id.' Данные в файле не обновлялись после ' .$url_in_bd->date_update) ;
        }

        }else{
            //array_push($no_valid_xml,[$company_id =>$url_xml_file]);

            //TO DO записывать в численном виде ошибки
            //1 - не валидный xml файл
            //array_push($errors_update,'1');
            $errors_update = 1;
        }

        /**
         * если ссылка не вернула статус 200 то считать ошибкой
         */
        }else{
            // 2 - битая ссылка
           //array_push($errors_update,'2');
            //dd($crashed_link_xml);
            $errors_update = 2;
        }


        /**
         * отчет об обновлении
         */
        $info_updates[] = [
            'new_product'=> count($product_new_from_xmlfile),
            'update_product'=> $update_product_count
        ];

        //$url_in_bd= Autoupdate::find($setting_autoupdate_in_bd[2]);

        $url_in_bd->info_update = json_encode($info_updates);


            $url_in_bd->error_update = $errors_update;



        //$url_in_bd->date_update = $date_update_now;
		   $url_in_bd->save();

		\Log::info('id:'.$comp->id.' Компания: '.$comp->name.' обновилась за ' . (microtime(true) - $start) . ' секунд');

    //}
     //----------------end foreach company-------------------
	 }else{

            \Log::info('Нет id ссылки в настройках автообновления у компании с id:  '.$company_id);
               //continue;
           }

		   $delcomp = Tempcompany::where('company_id',$comp->id);
        $delcomp->delete();
     /**
      * TO DO отчет об битых ссылках массив $crashed_link_xml положить в файл или на почту отправить
      * так же можно сформировать массив из тех компаний у которых не изменялись данные в файлах
      */

    }


	/**
     * поиск товара по коду и возврат его id
     * $temp_prod - массив товаров компании из БД
     * $codeVendor - артикул из xml файла
     */
    public function searchIdProductInBd($temp_prod,$codevendor)
    {
        $product_in_bd = array_pluck($temp_prod, 'code','id');

            foreach($product_in_bd as $key=>$value){

                if($value == $codevendor){
                    return $key;
                }
            }
            return false;

    }

	/**
     * методы перезаписи данных в БД
     * статус,цена,старая цена
     * $item -object(product in BD) $...from_xmlfile - значение из xml файла
     */
	public function change_available_product($item,$available_from_xmlfile)
    {
        /**
        * т.к в таблице хранится в формате enum(0,1) значение статуса наличия товара
        * а в xml файле записано bool тип то производится перевод в 1,0 чтобы
        * произвести сравнение на изменение
        */
        $status = $available_from_xmlfile =='true' ? 1 :0;

        if($item->status_available != $status){

                if($available_from_xmlfile =='true'){
                    $item->status_available = '1';
                }else{
                    $item->status_available = '0';
                }
                return true;
    }
    return false;

    }

    public function change_price_product($item,$price_from_xmlfile)
    {
        if( isset($price_from_xmlfile) && $item->price != $price_from_xmlfile){
            $item->price = $price_from_xmlfile;
			return true;
        }
		return false;
    }

    public function change_oldprice_product($item,$old_price_from_xmlfile)
    {
        if( isset( $old_price_from_xmlfile) && $item->old_price !=  $old_price_from_xmlfile){
            $item->old_price =  $old_price_from_xmlfile;
			return true;
        }
		return false;
    }



    /**
     * убрать пробелы с начала и конца и проверка на число
     * для полей цены
     */
    public function validateValueInXmlFile($value)
    {
        $input_text = trim($value);

        if( is_numeric($input_text) ){
            return $input_text;
        }else{
           return false;
        }


    }



    /**
     * создание файла с новыми товарами и запись в БД ссылки на новый файл для парсинга
     */
    public function makeXmlFileAutoUpdate($arr,$xmlData,$company_id)
    {
		$start_xml = microtime(true);
        $dateToday = Carbon::now();
        $company = Company::find($company_id);
        $nameCompany = $company->name;
        //$filename = fopen(public_path().'/files/xml/test.xml',"w+");

        $name = sha1(date('YmdHis') . str_random(30));
        $resize_name = $name . str_random(2) . '.xml';

        $tempPath = 'files/xml/'.$resize_name;

		//$path = base_path('public\\'.$tempPath);
		$path = public_path($tempPath);


        //создание нового xml файла с товарами которых нет в БД
        $filename = fopen($path,"w+");

        fwrite($filename, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
        fwrite($filename, "<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">\n");
        fwrite($filename, "<yml_catalog date=\"{$dateToday}\">\n");
        fwrite($filename, "<shop>\n");
        fwrite($filename, "<name>{$nameCompany}</name>\n");
        fwrite($filename, "<company>{$nameCompany}</company>\n");
        fwrite($filename, "<url>https://bigsales.pro/</url>\n");

        fwrite($filename, "<currencies>\n");

        foreach($xmlData->xpath('//currency') as $item){

            if(isset($item['code'])){

                fwrite($filename, "<currency code=\"{$item['code']}\">{$item}</currency>\n");
            }
            if(isset($item['id']) && isset($item['rate'])){

                fwrite($filename, "<currency id=\"{$item['id']}\" rate=\"{$item['rate']}\"/>\n");
            }

        }

        fwrite($filename, "</currencies>\n");

        fwrite($filename, "<categories>\n");

        foreach($xmlData->xpath('//category') as $item){

           $id =  $item['id'];
           $parent_id =  $item['parentId'];
           $val =  $item;
           if(isset($parent_id)){
              fwrite($filename, "<category id=\"{$id}\" parentId=\"{$parent_id}\">{$val}</category>\n");
           }else{
            fwrite($filename, "<category id=\"{$id}\">{$val}</category>\n");
           }

        }

        fwrite($filename, "</categories>\n");

        fwrite($filename, "<offers>\n");

        foreach($arr as $item){
			 $item['available'] = isset($item['available']) ? $item['available'] :"true";

            fwrite($filename, "<offer available=\"{$item['available']}\" id=\"{$item['id']}\">\n");

                fwrite($filename, "<price>{$item->price}</price>\n");

                fwrite($filename, "<currencyId>{$item->currencyId}</currencyId>\n");

                fwrite($filename, "<categoryId>{$item->categoryId[0]}</categoryId>\n");

                foreach($item->picture as $picture){
                    fwrite($filename, "<picture>{$picture}</picture>\n");

                }

                //fwrite($filename, "<name>{$item->name}</name>\n");
			$contents_name = htmlspecialchars($item->name,ENT_COMPAT,"UTF-8");
                fwrite($filename, "<name>{$contents_name}</name>\n");

                if(isset($item->vendor)){
                   //fwrite($filename, "<vendor>{$item->vendor}</vendor>\n");
					$contents_vendor = htmlspecialchars($item->vendor,ENT_COMPAT,"UTF-8");
                   fwrite($filename, "<vendor>{$contents_vendor}</vendor>\n");

                }

			if(isset($item->vendorCode) && !empty($item->vendorCode)){
                //fwrite($filename, "<vendorCode>{$item->vendorCode}</vendorCode>\n");
			$contents_vendorcode = htmlspecialchars($item->vendorCode,ENT_COMPAT,"UTF-8");
			fwrite($filename, "<vendorCode>{$contents_vendorcode}</vendorCode>\n");
			}
                fwrite($filename, "<description><![CDATA[{$item->description}]]></description>\n");

                foreach($item->param as $parametr){
                    //fwrite($filename, "<param name=\"{$parametr['name']}\">{$parametr}</param>\n");
					$val_parametr = htmlspecialchars($parametr,ENT_COMPAT,"UTF-8");
                    $contents_parametr = htmlspecialchars($parametr['name'],ENT_COMPAT,"UTF-8");
					fwrite($filename, "<param name=\"{$contents_parametr}\">{$val_parametr}</param>\n");

                }

                fwrite($filename, "</offer>\n");

        }

        fwrite($filename, "</offers>\n");
        fwrite($filename,"</shop>\n");
        fwrite($filename, "</yml_catalog>");
        fclose($filename);

		 \Log::info('xml сформирован за:  ' . (microtime(true) - $start_xml) . ' секунд');
        //$url = asset($tempPath);
		$url = 'https://bigsales.pro/'.$tempPath;

        //запись в БД ссылки на новый файл
        PromExternal::create([
            'unload_url' => $url,
            'company_id' => $company_id
        ]);

        //dd($url);


    }

    /**
     * блок методов валидации файла xml
     */
    private function isXMLFileValid($xmlFilename, $version = '1.0', $encoding = 'utf-8')
    {
        $xmlContent = file_get_contents($xmlFilename);
        return self::isXMLContentValid($xmlContent, $version, $encoding);
    }


    private function isXMLContentValid($xmlContent, $version = '1.0', $encoding = 'utf-8')
    {
        if (trim($xmlContent) == '') {
            return false;
        }

        libxml_use_internal_errors(true);

        $doc = new \DOMDocument($version, $encoding);
        $doc->loadXML($xmlContent);

        $errors = libxml_get_errors();
        libxml_clear_errors();

        return empty($errors);
    }


	/**
     * определяет выходные дни в которые при автообновлении
     * не должен формироваться xml файл
     */
    public function dayWorkWeek()
    {
        $day_of_week = Carbon::now()->dayOfWeek;
		//для настройки изм.д.недели
        //$day_of_week = $day_of_week->addDays(3)->dayOfWeek;
        if($day_of_week == 6 || $day_of_week == 0 ){
            return false;
        }else{
            return true;
        }
        
    }

}