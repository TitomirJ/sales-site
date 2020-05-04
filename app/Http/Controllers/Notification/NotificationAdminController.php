<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Notification;

class NotificationAdminController extends Controller
{
    public function confirmNoficationAdmin($id){
        $notification = Notification::find($id);
        if($notification){
            $notification_type = snake_case(class_basename($notification->type));
            $notification_data = json_decode($notification->data);

            //уведомления для сотрудников сайта о новом заказе
            if($notification_type == 'order_shipped'){

                $notification_order_id = $notification_data->order_id;
                $company_id = $notification_data->company_id;

                $array_notify = [];
                $group_notifications = Notification::where('type', 'App\Notifications\OrderShipped')->get();
                foreach ($group_notifications as $notif){
                    $chack_notify = json_decode($notif->data);

                    if($notification_order_id == $chack_notify->order_id){
                        array_push($array_notify, $notif->id);
                    }
                }
                Notification::destroy($array_notify);

                return redirect()->route('admin_company_show', ['id' => $company_id]);

                //уведомления для сотрудников сайта о новой оплате(депозит или абонплата)
            }elseif ($notification_type == 'admin_transaction_shipped'){

                $notification_transaction_id = $notification_data->transaction_id;
                $company_id = $notification_data->company_id;

                $array_notify = [];
                $group_notifications = Notification::where('type', 'App\Notifications\AdminTransactionShipped')->get();
                foreach ($group_notifications as $notif){
                    $chack_notify = json_decode($notif->data);

                    if($notification_transaction_id == $chack_notify->transaction_id){
                        array_push($array_notify, $notif->id);
                    }
                }
                Notification::destroy($array_notify);

                return redirect()->route('admin_company_show', ['id' => $company_id]);
                //уведомление для сотрудников сайта о блокировке компании через 12 часов
            }elseif ($notification_type == 'admin_company_aboniment_ended_shipped'){

                $notification_timestemp_id = $notification_data->timestemp_id;
                $company_id = $notification_data->company_id;

                $array_notify = [];
                $group_notifications = Notification::where('type', 'App\Notifications\AdminCompanyAbonimentEndedShipped')->get();
                foreach ($group_notifications as $notif){
                    $chack_notify = json_decode($notif->data);

                    if($notification_timestemp_id == $chack_notify->timestemp_id){
                        array_push($array_notify, $notif->id);
                    }
                }
                Notification::destroy($array_notify);

                return redirect()->route('admin_company_show', ['id' => $company_id]);
                //уведомление для сотрудников сайта о новой ссылке XML
            }elseif ($notification_type == 'admin_external_shipped'){

                $notification_external_id = $notification_data->external_id;

                $array_notify = [];
                $group_notifications = Notification::where('type', 'App\Notifications\AdminExternalShipped')->get();
                foreach ($group_notifications as $notif){
                    $chack_notify = json_decode($notif->data);

                    if($notification_external_id == $chack_notify->external_id){
                        array_push($array_notify, $notif->id);
                    }
                }
                Notification::destroy($array_notify);

                return redirect('/admin/prom');
            }
        }else{
           return back()->with('info', 'Уведомление больше не актуально!');
        }
    }
}
