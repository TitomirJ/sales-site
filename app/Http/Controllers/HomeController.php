<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\User;
use App\Product;
use App\Company;
use App\Review;
use App\Parametr;
use App\Transaction;
use App\Role;
use PDF;
use App\Mail\CallBackOrder;
use Illuminate\Support\Facades\Mail;
use App\SubcategoriesOption;
use App\Subcategory;
use App\Category;
use App\Independent;
use DB;
use App\Functions\StaticFunctions as SF;
use Vis\eSputnikClient\eSputnikClient;
use Notification;
use App\Notifications\AdminExternalShipped;
use App\Notifications\AdminCompanyAbonimentEndedShipped;
use Illuminate\Support\Collection;
use App\PromExternal;
use Carbon\Carbon;
use App\Functions\RozetkaApi;
use App\Functions\PromApi;
use SoapClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Ukrpost;
use App\Models\ApiModule\ModuleJobs;
use App\PromProduct;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public  function sendSMS(){
        $company = Company::find(42);
        $company->load('orders');
        $orders = $company->orders()->where('status', '1')->get();

        $from = env('ALFA_NAME_ESPUTNIK');
        $text = 'У вас ('.$orders->count().') новых заказов. Посмотреть можно в личном кабинете BigSales.pro.';
        $phone = $company->responsible_phone;
        SF::sendsms($from, $text, $phone);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('provider.company.companyWelcome')->withTitle('Главная');
    }

    public function welcome()
    {
        //$reviews = Review::where('block', '1')->get();
//        return view('welcome', compact('reviews'));
        return view('landing.index');
    }

    public function callBackOrder(Request $request)
    {
        self::amoCrmSendCallback($request->name, $request->phone);
        return back()->with('success', 'Заявка отправлена, ожидайте оператор с вами свяжется.');
    }

//    public function options(){
//        $transactions = Transaction::all();
//        $pdf = PDF::loadView('pdf.balance', compact('transactions'))->save(public_path().'/pdf/new.pdf');
//       return $pdf->stream();
//
//        $file_path = public_path('pdf/new.pdf');
//return response()->download($file_path)->deleteFileAfterSend(true);
//    }

    public function options(Request $request){

//        var_dump(preg_match('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)([^\s]+(\.(?i)(jpg|png|gif|bmp|jpeg))$)@',
//            (string) trim('http://optovik.dp.ua/image/cache/catalog/neman/39/4-600x600.jpg')));




//       $client = new SoapClient('http://services.ukrposhta.ua/barcodestatistic/barcodestatistic.asmx?WSDL');
//        $params = new \stdClass();
//        $params->guid = 'fcc8d9e1-b6f9-438f-9ac8-b67ab44391dd';
//        $params->culture = 'uk';
//        $params->barcode = 'CA123456789UA';
//
//        $result = $client->GetBarcodeInfo($params)->GetBarcodeInfoResult;
//            $client = new Client(['headers' => [
//                'aftership-api-key' => '64223cc5-0699-4a5e-b1da-2251b07cbb88',
//                'Content-Type' => 'application/json'
//            ]]);
//
//        $result = $client->request('get','https://api.aftership.com/v4/trackings/ukrposhta/0500138238680');
        /*
         * метод перерасчета комиссии заказов у компаний на льготных условиях
        $orders = Order::where('company_id', 96)->get();

        $orders->each(function ($order){
            echo $order->id.'<br>';
            $c_order = Order::find($order->id);
            $c_order->load('product');
            $product_commission = $c_order->product->subcategory->commission - 2;
            $total_commission_sum = $c_order->total_sum/100*$product_commission;

            $transaction = Transaction::where('order_id', $order->id)->first();
            $c_t = Transaction::find($transaction->id);

            $c_order->commission_sum = $total_commission_sum;
            $c_order->save();

            $c_t->total_sum = $total_commission_sum;
            $c_t->save();
        });


        dd($orders);
        */
        
        $test = RozetkaApi::searchAvailStatusesGroupRozetka('3&page=2');
        dd(json_encode($test));
//        $test =  Order::whereIn('status', ['0', '3', '4'])->where('marketplace_id', '1')->get();
//
//
//
//        foreach($test as $order){
//            ModuleJobs::createOrderCheckStatusJob($order->id, $order->marketplace_id, 'M', 0);
//        }
//
//
//
//
//        dd($test);
//
//        $order = Order::find(1131);
//        $test = ModuleJobs::createOrderCheckStatusJob($order->id, $order->marketplace_id, 'M', 0);
//        dd($test);

//        $client = new Ukrpost();
//        $info = $client->GetBarcodeInfo('05001382386801','uk');
//
//        echo gettype($info['code']);


            //dd($first_request->content->_meta->pageCount);
//            $status = 4;
//            $seller_comment = 'Товар отправлен';
//            $test = RozetkaApi::putOrderStatus($id, $status, $seller_comment);
//            dd($test);
//        $test = RozetkaApi::getDataOrder($id);
//        dd($test);
//          $order = Order::find(352);
//          $ttn = 20450115760661;
//            $text = 'ТТН: '.$ttn;
//            $test = RozetkaApi::putOrderStatus($order->order_market_id, 3, $text, $ttn);
//            dd($test);
//        $test = RozetkaApi::searchAvailStatusesRozetka(4);
//        foreach ($test->content->orderStatus[0]->status_available as $status){
//            $res = RozetkaApi::searchAvailStatusesRozetka($status->child_id);
//
//            echo 'id = '.$res->content->orderStatus[0]->id.' name = '.$res->content->orderStatus[0]->name.'<br>';
//        }
       // dd($test->content->orderStatus[0]->status_available);
//        $director = User::find(28);
//        $user = User::find(28);
//        $password = 'sdsdsdsdd';
//        $orders = Order::all();
//        $order = Order::first();
//        $company = Company::find(12);
//        $type = $request->type;
//        if($type == 'user'){
//            return view('emails.users.sendNewUserReg', compact('user', 'password'));
//        }elseif ($type == 'manager'){
//            return view('emails.providers.managers.sendNewManagerReg', compact('user', 'password', 'director', 'company'));
//        }elseif ($type == 'moderator'){
//            return view('emails.moderators.sendNewModeratorReg', compact('user', 'password'));
//        }elseif ($type == 'order'){
//            return view('emails.providers.orders.orderShipped', compact('orders',  'company'));
//        }elseif ($type == 'block'){
//            return view('emails.providers.block.blockAb', compact(  'company'));
//        }elseif ($type == 'restore'){
//            return view('emails.providers.orders.restoreCanceledOrder', compact(  'order',  'company'));
//        }

//        $test = RozetkaApi::getDataOrder(201732363);
//        dd($test);
//
//        $products = Product::where('status_moderation','1')->where('status_moderation','1')->where('status_moderation','1')->whereNull('deleted_at')->whereNull('check_at')->whereNull('market_url')->take(10)->get();
//
//        foreach ($products as $product){
//            $code = $product->code;
//            $pos = strpos($code, '-');
//            $rest = substr($code, 1+$pos);
//
//            $serch_name_and_code = $product->name.' ('.$rest.')';
//
//            $test = RozetkaApi::getSearchProductToNameAndCode($serch_name_and_code);
//
//            $flag = $test->content->_meta->totalCount;
//            //   dd($flag);
//            if($flag != '0'){
//
//                echo ($test->content->items[0]->url)."<br>";
//            }else{
//                echo "false<br>";
//            }
//        }


//
//
//        $test = RozetkaApi::getSearchActiveProducts();
//
//        dd($test->content);

//        $cat = Category::all();
//        dd($cat);
    }

    public function checkBalanceRedirect(Request $request){
        if(Auth::guest()){
            return redirect('/login');
        }else{
            if(Auth::user()->isProvider()){
                return redirect('company/balance');
            }
        }
    }

    private function amoCrmSendCallback($name, $phone){


        $pipeline_id = '2093950'; //id ответственного по сделке, контакту, компании
        $lead_name = $name; //Название добавляемой сделки
        $lead_status_id = '17882395'; //id этапа продаж, куда помещать сделку
        $contact_name =  'Узнать при звонке';//Название добавляемого контакта
        $contact_phone = $phone; //Телефон контакта
        $contact_email = ''; //Емейл контакта

        //АВТОРИЗАЦИЯ
        $user=array(
            'USER_LOGIN'=>'imarketdevelop@gmail.com', #Ваш логин (электронная почта)
            'USER_HASH'=>'4163529790c113eb35c7c0b94786765ac4dd53f2' #Хэш для доступа к API (смотрите в профиле пользователя)
        );
        $subdomain='bigsaless';
        #Формируем ссылку для запроса
        $link='https://'.$subdomain.'.amocrm.ru/private/api/auth.php?type=json';
        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
        #Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link);
        curl_setopt($curl,CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($user));
        curl_setopt($curl,CURLOPT_HEADER,0);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
        $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
        curl_close($curl);  #Завершаем сеанс cURL
        $Response=json_decode($out,true);
        if($code !== 200){
            echo 'Ошибка! <br>';
            echo '<pre>'; print_r($Response); echo '</pre>';
            exit;
        }
        $user_id = $Response['response']['user']['id'];

        $link='https://'.$subdomain.'.amocrm.ru/private/api/v2/json/accounts/current'; #$subdomain уже объявляли выше
        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
        #Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link);
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
        $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        curl_close($curl);
        $Response=json_decode($out,true);
        //echo '<pre>'; print_r($Response); echo '</pre>';exit;
        $contacts=$Response['response']['account']['custom_fields']['contacts'];
        //ФОРМИРУЕМ МАССИВ С ЗАПОЛНЕННЫМИ ПОЛЯМИ КОНТАКТА
        //Стандартные поля амо:
        $sFields = [];
        foreach ($contacts as $contact){
            if($contact['code'] == 'PHONE')
                $sFields['PHONE'] = $contact['id'];

            if($contact['code'] == 'EMAIL')
                $sFields['EMAIL'] = $contact['id'];
        }
        //ДОБАВЛЯЕМ СДЕЛКУ
        $leads['add']=array(
            array(
                'name' => $lead_name,
                'status_id' => $lead_status_id, //id статуса
                'responsible_user_id' => $user_id, //id ответственного по сделке
                'pipeline_id' => $pipeline_id
            )
        );
        $link='https://'.$subdomain.'.amocrm.ru/api/v2/leads';
        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
        #Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,'https://'.$subdomain.'.amocrm.ru/api/v2/leads');
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($leads));
        curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
        $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);

        $Response=json_decode($out,true);
        if($code !== 200){
            echo 'Ошибка! <br>';
            echo '<pre>'; print_r($Response); echo '</pre>';
            exit;
        }
        $lead_id = '';
        if(is_array($Response['_embedded']['items']))
            $lead_id = $Response['_embedded']['items'][0]['id']; //id новой сделки
        //ДОБАВЛЯЕМ СДЕЛКУ - КОНЕЦ
        //ДОБАВЛЕНИЕ КОНТАКТА
        $contact = array(
            'name' => $contact_name,
            'linked_leads_id' => array($lead_id), //id сделки
            'responsible_user_id' => $user_id, //id ответственного
            'custom_fields'=>array(
                array(
                    'id' => $sFields['PHONE'],
                    'values' => array(
                        array(
                            'value' => $contact_phone,
                            'enum' => 'WORK'
                        )
                    )
                ),
                array(
                    'id' => $sFields['EMAIL'],
                    'values' => array(
                        array(
                            'value' => $contact_email,
                            'enum' => 'WORK'
                        )
                    )
                )
            )
        );
        $set['request']['contacts']['add'][]=$contact;
        #Формируем ссылку для запроса
        $link='https://'.$subdomain.'.amocrm.ru/private/api/v2/json/contacts/set';
        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
        #Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($set));
        curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
        $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        $Response=json_decode($out,true);
        if($code !== 200){
            echo 'Ошибка! <br>';
            echo '<pre>'; print_r($Response); echo '</pre>';
            exit;
        }
    }

    public function backProducts(){
        $products = Product::where('status_moderation', '1')->get();
//       foreach ($products as $p){
//           $product = Product::find($p->id);
//           $product->status_moderation = '0';
//           $product->save();
//       }
        dd($products);
    }

    public function independent(){
        $independent = Independent::find(2);
        $test = explode('+', $independent->offerPhone);
        dd($test[1]);
    }

    public function testNotifForAdmin(){
//        $users = User::all();
//
//        $personnel_bigsales = collect($users)->filter(function ($item, $key) {
//            if ($item->isAdmin()) {
//                return true;
//            }
//        });
//
//        $external = PromExternal::find(5);
//        $company = $external->company;
//
//        Notification::send($personnel_bigsales, new AdminExternalShipped($external, $company));

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
}
