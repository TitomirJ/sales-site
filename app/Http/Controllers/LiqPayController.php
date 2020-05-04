<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\LiqPay;
use Illuminate\Support\Facades\Log;
use App\User;
use App\Order;
use App\Cart;
use App\ItemsOrder;
use App\Product;
use PDF;
use App\Http\Model\StaticFunctions;
use App\Mail\SendKuponsWithPdfToUser;
use Illuminate\Support\Facades\Mail;
use App\Notifications\InvoicePaidDataBase;

class LiqPayController extends Controller
{
    public function liqpayStatus(Request $request)
    {
        $user = $request->user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);

        $data = $request->data;
        $signature = $request->signature;
        $result= json_decode( base64_decode($request->data ));

        if(self::checkSignature($signature, $data)){
            return view('user.orders', compact('user', 'orders', 'result'))->withTitle('Мои заказы');
        }else{
            return redirect()->to('/')->with('danger', 'Сигнатуры данных, платежной системы, отсутствуют или не верны!');
        }
    }

    public function liqpayServer(Request $request)
    {
        $data = $request->data;
        $signature = $request->signature;
        if(self::checkSignature($signature, $data)){
            self::checkStatusPayment($data);
        }else{
            Log::info('Сигнатуры не совпадают!');
            Log::info(base64_decode($data));
        }
    }

    // Проверка сигнатуры Ликпея
    private function checkSignature($request_signature, $request_data)
    {
        $private_key = env('LIQPAY_PRIVAT_KEY');

        $liqpay_data = $request_data;
        $liqpay_signature = $request_signature;

        $resault_sign = base64_encode( sha1($private_key.$liqpay_data.$private_key, 1 ));

        if($liqpay_signature === $resault_sign){
            return true;
        }else{
            return false;
        }
    }

    //Проверка статуса платежа
    private function checkStatusPayment($data)
    {
        $resault_data = json_decode( base64_decode($data));
        if($resault_data->status == 'success' || $resault_data->status == 'sandbox')
        {
            //данные
            $order_id = $resault_data->order_id;
            $order = Order::find($order_id);
            $itemsOrder = ItemsOrder::where('order_id', $order->id)->get();
            $user = User::find($order->user_id);

            // путь к PDF файлу
            $path_to_pdf_kupon = self::createPDFkupons($order_id);

            //отправка письма с файлом pdf
            $email_status = self::sendEmailToUser($user, $order, $itemsOrder, $path_to_pdf_kupon);

            // Проверка отправки письма и изменение статуса статуса(data) в базу данных
            if($email_status){

                $order->paid = '1';
                $order->confirmed = '1';
                $order->liqpay_status = $resault_data->status;
                $order->liqpay_data = base64_decode($data);
                $order->save();

                //отправка СМС покупателю
                self::sendSMStoUser($order->user->phone);

                //создание уведомления для поставщика
                self::createNotificationToProviders($order->id);
            }else{
                $order->paid = '1';
                $order->liqpay_status = $resault_data->status;
                $order->liqpay_data = base64_decode($data);
                $order->save();
            }

            // удаление PDF ранее созданого из дериктории сайта
            unlink($path_to_pdf_kupon);

            //  Log::info();
        }elseif($resault_data->status == 'failure' || $resault_data->status == 'error'){

            $order_id = $resault_data->order_id;
            $order = Order::find($order_id);
            $order->liqpay_status = $resault_data->status;
            $order->liqpay_data = base64_decode($data);
            $order->save();

            Log::info('Ошибка платежа'.base64_decode($data));
        }
    }

    //Создание PDF файла с купонами и сохранение в дериктории сайта
    private function createPDFkupons($id)
    {
        $order = Order::find($id);
        $user = User::find($order->user->id);
        $itemsOrder = ItemsOrder::where('order_id', $id)->get();

        PDF::loadView('kupons.pdf', compact('user', 'itemsOrder', 'order'))->save(public_path().'/pdf/'.$order->id.'.pdf');

        $path = public_path().'/pdf/'.$order->id.'.pdf';

        return $path ;
    }

    // Подтверждение оплаты заказа пользователем на смс
    private function sendSMStoUser($num_phone)
    {
        $from = env('ALFA_NAME_ESPUTNIK');
        $text = 'Купоны отправлены на вашу эл. почту.';
        $phone = $num_phone;
        StaticFunctions::sendSMS($from, $text, $phone);
    }

    // Отправка эл. почты покупателю и подтверждение получения
    private function sendEmailToUser($user_data, $order_data, $itemsOrder_data, $path_to_pdf_kupon)
    {
        $user = $user_data;
        $order = $order_data;
        $itemsOrder = $itemsOrder_data;
        $path = $path_to_pdf_kupon;

        Mail::to($user->email)->queue(new SendKuponsWithPdfToUser($user, $order, $itemsOrder, $path));

        //Проверка на отправку почты, failures() возвращает ошибки отправки почты
        if( count(Mail::failures()) == 0 ) {
            return true;
        }else{
            return false;
        }
    }

    // создание уведомления (используя метод toDatabase) для поставщиков акции о приобритении купона
    private function createNotificationToProviders($order_id){
        $order = Order::find($order_id);
        $user = $order->user->id;
        $items = $order->items;

        foreach ($items as $item){
            $product = Product::find($item->product_id);
            $provider_id = $product->provider->user->id;
            $provider = User::find($provider_id);

            $provider->notify(new InvoicePaidDataBase($order, $item, $product, $user));

        }

    }

    //orders from easymarket
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('user.orders', compact('user', 'orders'))->withTitle('Мои заказы');
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $order = Order::find($id);
//        $items_order = ItemsOrder::where('order_id', $order->id)->get();
//        $array = [];
//        for($i = 0; $i < $items_order->count(); $i++){
//            $array[$i] = $items_order[$i]['product_id'];
//        }
//		$products = Product::whereIn('id', $array)->where('moderation', '<>', '1')->get();
//        echo '<pre>';
//        print_r($products->toArray());
//        echo '</pre>';
        if($order->user_id == $user->id){

            $public_key = env('LIQPAY_PUBLIC_KEY');
            $privat_key = env('LIQPAY_PRIVAT_KEY');

            $params = [
                'action'         => 'pay',
                'amount'         => $order->total_sum,
                'currency'       => 'UAH',
                'description'    => 'Оплата заказа № '.$order->id.' на сайте Easy Market',
                'order_id'       =>  $order->id,
                'version'        => '3',
                'language'       => 'ru',
                'sender_first_name' => $user->name,
                'sender_last_name' => $user->surname,
                "server_url" => "https://www.easy.net.ua/liqpay/server",
                "result_url" => "https://www.easy.net.ua/liqpay/status",
                //'sandbox'  => true,
            ];
            $liqP = new LiqPay($public_key , $privat_key);
            $formLiqPay = $liqP->cnb_form($params);
            return view('user.orderShow', compact('user', 'order', 'formLiqPay'))->withTitle('Заказ № '.$order->id);
        }else{
            return redirect()->back()->with('danger', 'Это не ваш заказ!');
        }

    }

    public function create(Request $request)
    {
        if(session('cart') && $request->method('POST')) {
            $user = $request->user();
            $e = session('totalsum');
            if ($e != '') {
                $array_check = self::checkCountProductsInStockWithBasket();
                if(count($array_check) == 0) {
                    $order = new Order;
                    $order->user_id = $request->user()->id;
                    $order->total_sum = session('totalsum');
                    $order->save();

                    foreach (session('cart') as $p) {
                        $itemsorder = new ItemsOrder;
                        $itemsorder->order_id = $order->id;
                        $itemsorder->product_id = $p['id'];
                        $itemsorder->quantity = $p['qty'];
                        $itemsorder->codes = self::setCodeKupone($order->id, $p['qty']);
                        $itemsorder->price = $p['price'];
                        $itemsorder->confirm = self::createConirmColumnForItem($p['qty']);
                        $itemsorder->save();

                        DB::table('products')->where('id', $p['id'])->decrement('in_stock', $p['qty']);
                    }
                    Cart::clear();



                    return redirect()->route('showOrder', ['id' => $order->id])
                        ->with('success', 'Заказ сформирован и готов к оплате!');
                }else{
                    return self::showModalWithChangeBasket($array_check);
                }
            }
        }else{
            return redirect('basket')->withTitle('Моя корзина');
        }
    }

    private function checkCountProductsInStockWithBasket()
    {
        $array_products_id = [];
        $array_products_instock_id = [];
        $array_products_not_instock_id = [];
        foreach (session('cart') as $p) {
            array_push($array_products_id, $p['id']);
            $product = Product::where('id', $p['id'])->get();
            if($product[0]['in_stock'] >= $p['qty']){
                array_push($array_products_instock_id, $p['id']);
            }else{
                array_push($array_products_not_instock_id, $p['id']);
            }
        }

        return  $array_products_not_instock_id;

    }

    public function showModalWithChangeBasket($false_products_id){

        if(session('cart')) {
            $false_id = $false_products_id;

            foreach (session('cart') as $p){
                if(in_array($p['id'], $false_id)){
                    $product = Product::where('id', $p['id'])->get();

                    Session::put('reserv.product'.$p['id'].'.id', $p['id']);
                    Session::put('reserv.product'.$p['id'].'.label', $product[0]['label']);
                    Session::put('reserv.product'.$p['id'].'.price', $product[0]['price']);
                    Session::put('reserv.product'.$p['id'].'.image_path', $product[0]['image_path']);
                    Session::put('reserv.product'.$p['id'].'.qty', $product[0]['in_stock']);
                }
            }

            return view('pages.cart.index')->withTitle('Моя корзина');
        }else{
            return redirect('basket')->withTitle('Моя корзина');
        }
    }

    public function createWithoutBasket(Request $request, $id)
    {
        if($request->method('POST')) {
            $user = $request->user();
            $product = Product::find($id);
            if (\App\Http\Model\StaticFunctions::guardTimeOfProduct($product->interval_from, $product->interval_to)) {

                if($product->in_stock <= 0){
                    return redirect()->back()->with('danger', 'Заказ сформировать не удалось, не осталось в наличии купонов!');
                }else{
                    //New order
                    $order = new Order;
                    $order->user_id = $request->user()->id;
                    $order->total_sum = $product->price;
                    $order->save();
                    //Order's items
                    $itemsorder = new ItemsOrder;
                    $itemsorder->order_id = $order->id;
                    $itemsorder->product_id = $product->id;
                    $itemsorder->quantity = '1';
                    $itemsorder->codes = self::setCodeKupone($order->id, 1);
                    $itemsorder->price = $product->price;
                    $itemsorder->confirm = self::createConirmColumnForItem(1);
                    $itemsorder->save();

                    DB::table('products')->where('id', $product->id)->decrement('in_stock');

                    return redirect()->route('showOrder', ['id' => $order->id])->with('success', 'Заказ сформирован и готов к оплате!');
                }
            }else{
                return redirect()->back()->with('danger', 'Заказ сформировать не удалось, срок действия акции закончился!');
            }
        }else{
            return redirect('basket')->withTitle('Моя корзина');
        }
    }

    public function delete(Request $request, $id)
    {
        $user = $request->user();
        $order = Order::find($id);
        if($user->id == $order->user_id){
            if($order->paid == '0'){
                $items_order = ItemsOrder::where('order_id', $order->id);
                $check_items = $items_order->get();
                foreach ($check_items as $item){
                    DB::table('products')->where('id', $item->product_id)->increment('in_stock', $item->quantity);
                }
                $order->delete();
                $items_order->delete();
                return redirect()->route('showUsersOrders')->with('success', 'Заказ успешно удален!');
            }else{
                return redirect()->route('showUsersOrders')->with('danger', 'Удалить нельзя!');
            }
        }else{
            return redirect()->back()->with('danger', 'Вы можете удалить только свой заказ!');
        }
    }

    public function setCodeKupone($id, $num)
    {
        $array = [];
        for($i=0; $i<$num; $i++){
            $array[$i] = self::getStringOfCodes($id);
        }
        $res = json_encode($array);
        return $res;
    }

    public function getStringOfCodes($id)
    {
        $length = 12;
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = $id.'';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    public function downloadPDFkupons(Request $request, $id)
    {
        $user = User::find($request->user()->id);
        $order = Order::find($id);

        if($request->user()->id == $order->user_id){
            $itemsOrder = ItemsOrder::where('order_id', $id)->get();

            $pdf = PDF::loadView('kupons.pdf', compact('user', 'itemsOrder', 'order'))->save(public_path().'/pdf/'.$order->id.'.pdf');
            $file_path = public_path('pdf/'.$order->id.'.pdf');
            return $pdf->stream();
//          return response()->download($file_path)->deleteFileAfterSend(true);
        }else{
            return back()->with('danger', 'Это не ваш заказ или вы не авторизованы!');
        }
    }

    private function createConirmColumnForItem($num)
    {
        $array = [];
        for ($i=0;$i<$num;$i++){
            $array[$i] = 0;
        }
        $res = json_encode($array);
        return $res;
    }
}
