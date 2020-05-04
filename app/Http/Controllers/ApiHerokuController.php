<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Product;
use App\Company;
use App\Order;
use App\Transaction;
use App\User;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\DB;
use App\Functions\StaticFunctions as SF;
use Illuminate\Support\Facades\Mail;
use Notification;
use App\Notifications\OrderShipped as AdminNotifOrderShipped;
use Illuminate\Support\Collection;
use App\Models\ApiModule\ModuleJobs;


class ApiHerokuController extends Controller
{
    public function recheckBalanceCompanyForModuleApi(Request $request){
        $key = (isset($request->api_key)) ? $request->api_key : '';
        if($key == 'ZXNuYm1uc3kycG9q'){
            $company_id = (isset($request->company_id)) ? $request->company_id : null;
            if($company_id == null){
                return json_encode( [
                    'status' => 'error',
                    'msg' => 'Не указан айди компании!'
                ]);
            }else{
                $company = Company::find((int) $company_id);
                if ($company == null) {
                    return json_encode( [
                        'status' => 'error',
                        'msg' => 'Компания с таким номером не найдена!'
                    ]);
                } else {
                    SF::recalculationBalanceCompany($company->id);
                    SF::checkCompanyBalance($company->id);
                    self::comboFunctionsProductsSpetial($company->id);
                    return json_encode( [
                        'status' => 'success',
                        'msg' => 'перерасчет баланса выполнен',
                        'company' => $company
                    ]);
                }
            }

        }else{
            return json_encode( [
                'status' => 'error',
                'msg' => 'Апи ключ не верен!'
            ]);
        }
    }

    public function recheckBalanceCompany(Request $request){
        $api_key = env('API_HEROKU_KEY');
        $data = $request->data;

        if($data['key'] == $api_key){
            $company_id = $data['id'];
            SF::recalculationBalanceCompany($company_id);
            SF::checkCompanyBalance($company_id);
            $count_changed_products = self::comboFunctionsProductsSpetial($company_id);
            self::orderShipped($company_id);

            return 'true';
        }else{
            return 'false';
        }
    }

    private function comboFunctionsProductsSpetial($company_id){
        $flag = SF::checkCompanyToBlockProductsSpetial($company_id);
        $resault = SF::changeProductsSpetialStatus($company_id, $flag);

        return $resault;
    }

    private function orderShipped($company_id){
        $company = Company::find($company_id);
        $orders = Order::where('company_id', $company_id)->where('status', '0')->get();
        $users = [];
        foreach ($orders as $o){
            if(!in_array($o->user_id, $users)){
                array_push($users, $o->user_id);
            }
        }

        for ($i=0; $i<count($users); $i++){
            $user = User::find($users[$i]);
            $user_orders =  Order::where('company_id', $company_id)->where('user_id', $user->id)->where('status', '0')->get();
            Mail::to($user->email)->send(new OrderShipped($company, $user_orders));
            self::providerAndroidNotificationAboutNewOrder($user);
        }

        $from = env('ALFA_NAME_ESPUTNIK');
        $text = $orders->count().' новых заказов - BigSales.pro';
        $phone = $company->responsible_phone;
        SF::sendsms($from, $text, $phone);

        self::adminNotificationOrderShipped($company_id);

    }

    public function uploadImgForVova(Request $request)
    {
        $file_path = $request->public_path;

        $width = 850;
        $height = 850;


        $new_name = self::renameImagesForS3Drive($file_path);

        Image::configure(array('driver' => 'gd'));

        $image = Image::make($file_path);
        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');

        Storage::disk('public_heroku')->put($new_name, (string)$image);

        $array = [
            'name' => $new_name,
            'public_path' => asset('/images/heroku/'.$new_name )
        ];


        return json_encode($array);
    }

    private function renameImagesForS3Drive($filename){
        $format_file = substr($filename, strripos($filename, '.'));
        $new_name = sha1(date('YmdHis').str_random(30)).$format_file;
        return $new_name;
    }

    private function adminNotificationOrderShipped($company_id){
        $order = Order::where('company_id', $company_id)->where('status', '0')->orderBy('created_at', 'desc')->first();
        $company = $order->company;
        $users = User::all();
        $personnel_bigsales = collect($users)->filter(function ($item, $key) {
            if ($item->isAdmin()) {
                return true;
            }
        });

        Notification::send($personnel_bigsales, new AdminNotifOrderShipped($order, $company));
        ModuleJobs::createOrderCheckStatusJob($order->id, $order->marketplace_id, 'M', 60);
    }

    //отправка уведомлений на Андроид о новом заказе если пользователь авторизован на Андроид приложении
    private function providerAndroidNotificationAboutNewOrder($user){
        $token = $user->callback_token;
        if($token == '' || $token == null){}else{
            $company_id = $user->company_id;
            $order = Order::where('company_id', $company_id)->where('status', '0')->latest()->first();
            SF::sendNotificationToAndroidAboutNewOrder($token, $order->id);
        }
    }

    public function uploadXmlRozetka(Request $request){
        $title = $request->title;
        $data = $request->data;
        Storage::disk('public_heroku_xml')->delete('rozetka.xml');
        Storage::disk('public_heroku_xml')->put('rozetka.xml', $data);
        return 'true';
    }

    public function uploadXmlProm(Request $request){
        $title = $request->title;
        $data = $request->data;
        Storage::disk('public_heroku_xml')->delete('prom.xml');
        Storage::disk('public_heroku_xml')->put('prom.xml', $data);
        return 'true';
    }

    public function uploadXmlZakupka(Request $request){
        $title = $request->title;
        $data = $request->data;
        Storage::disk('public_heroku_xml')->delete('zakupka.xml');
        Storage::disk('public_heroku_xml')->put('zakupka.xml', $data);
        return 'true';
    }

    public function getXmlRozetka(Request $request){
        $pathToFile=file_get_contents("https://bigsales.pro/xml_heroku/rozetka.xml");
        return $pathToFile;
    }

    public function getXmlProm(Request $request){
        $pathToFile=file_get_contents("https://bigsales.pro/xml_heroku/prom.xml");
        return $pathToFile;
    }

    public function getXmlZakupka(Request $request){
        $pathToFile=file_get_contents("https://bigsales.pro/xml_heroku/zakupka.xml");
        return $pathToFile;
    }
}
