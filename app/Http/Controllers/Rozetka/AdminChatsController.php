<?php

namespace App\Http\Controllers\Rozetka;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Functions\RozetkaApi;
use App\RozetkaChart;
use App\RozetkaMessage;
use App\Company;
use App\Order;


class AdminChatsController extends Controller
{
    public function index(Request $request){

        // Тип страницы
        $array_types = [
            'orders' => [
                'type' => '0',
                'title' => 'Розетка - Вопросы по заказам'
            ],
            'other' => [
                'type' => '2',
                'title' => 'Розетка - Вопросы от покупателей'
            ]];
        $type_subpage = (isset($request->type)) ? $request->type : 'other';
        // Проверка на правильно указаный тип страницы
        if(!array_key_exists($type_subpage, $array_types)){
            if($request->ajax()){
                return json_encode([
                    'status' => 'danger',
                    'msg' => 'Не верно указаны параметры запроса!'
                ]);
            }
            abort('404');
        }

        $sort_name = 'updated_at';
        $sort_type = 'desc';

        $appends = $request->only('type');

        if(isset($request->sort_name)){

            $sort_name = $request->sort_name;
            $sort_type = $request->sort_type;

            $appends = $request->only('type', 'sort_name', 'sort_type');
        }

        if($request->search_text != ''){
            $appends = $request->only('type', 'sort_name', 'sort_type', 'search_protocol', 'search_text');

            $charts = RozetkaChart::where('admin_status', '1')
                ->where('type', $array_types[$type_subpage]['type'])
                ->where($request->search_protocol, 'like', '%'.$request->search_text.'%')
                ->orderBy($sort_name, $sort_type)
                ->with(['company', 'messages', 'product'])
                ->paginate(20)
                ->appends($appends);
        }else{
            $charts = RozetkaChart::where('admin_status', '1')
                ->where('type', $array_types[$type_subpage]['type'])
                ->orderBy($sort_name, $sort_type)
                ->with(['company', 'messages', 'product'])
                ->paginate(20)
                ->appends($appends);
        }

        if($request->ajax()){
            return json_encode([
                'status' => 'success',
                'render' => view('adminAndModerator.rozetka.chats.index.layouts.chat_block', compact('charts', 'type_subpage'))->render()
            ]);
        }
        $counts_charts = self::countNewMessagesForTypes();
        return view('adminAndModerator.rozetka.chats.index.index', compact('charts', 'type_subpage', 'counts_charts'))->withTitle($array_types[$type_subpage]['title']);

    }

    //апрель2020
	//private function countNewMessagesForTypes(){
		public static function countNewMessagesForTypes(){
        $charts = RozetkaChart::where('admin_status', '1')->where('read_market', '0')->get();

        $counts_array = ['orders' => 0, 'products' => 0, 'other' => 0];

        foreach ($charts as $c){
            if($c->type == '0'){
                $counts_array['orders']++;
            }elseif($c->type == '2'){
                $counts_array['other']++;
            }
        }

        return $counts_array;
    }

    public function groupActionsChart(Request $request){

        RozetkaChart::where('admin_status', '1')->whereIn('id', $request->chart_id)->with(['company', 'messages', 'product'])->update(['read_market' => $request->action]);
        $updated_cols = RozetkaChart::where('admin_status', '1')->whereIn('id', $request->chart_id)->with(['company', 'messages', 'receiver', 'product'])->get();
        $type_subpage = $request->type;


        $for_array = [];

        foreach ($updated_cols as $chart){
            array_push($for_array, [
                'id' => $chart->id,
                'content' => view('adminAndModerator.rozetka.chats.index.layouts.layouts.chat_item', compact('type_subpage', 'chart'))->render()
            ]);
        }

        $response = [
            'status' => 'success',
            'msg' => 'Действие выполнено!',
            'renderArray' => $for_array
        ];

        return json_encode($response);
    }

    public function show(Request $request, $id){

        $chart = RozetkaChart::where('id', $id)->where('admin_status', '1')->with(['company', 'messages', 'receiver', 'product'])->first();

        if(!$chart){
            return redirect('admin/rozetka/chats')->withDanger('Такой чат не найден в базе данных!');
        }

        $chart_update = RozetkaChart::find($chart['id']);
        $chart_update->read_market = '1';
        $chart_update->save();

        return view('adminAndModerator.rozetka.chats.show.show', compact('chart'))->withTitle($chart->subject);
    }

    public function store(Request $request){

        $response =  RozetkaApi::createMessageForChart($request->all());

        // если передать данные не удалось - возврат текстового сообщения ошибки
        if(!$response->success){
            return json_encode([
                'status' => 'danger',
                'msg' => $response->errors->message
            ]);

        }

        $response_content = $response->content;
        /*
          +"content": {#2126 
            +"chat_id": 3500415
            +"body": "Тест"
            +"created": "2019-05-30 10:01:49"
            +"receiver_id": 72892692
            +"sender": 2
            +"seller": {#2139 }
            +"seller_id": 6511
        }*/
        // данные для создания нового сообщения чата полученного от Розетки
        $db_chart_id = (int) $request->id;
        $db_m_chart_id = (int) $response_content->chat_id;
        $db_body = (string) $response_content->body;
        $db_m_receiver_id = (int) $response_content->receiver_id;
        $db_sender = (string) $response_content->sender;
        $db_m_created_at = (string) $response_content->created;

        RozetkaMessage::firstOrCreate(
            [
                'chart_id' => $db_chart_id,
                'm_chart_id' => $db_m_chart_id,
                'm_created_at' => $db_m_created_at
            ],
            [

                'body' => $db_body,
                'm_receiver_id' => $db_m_receiver_id,
                'sender' => $db_sender
            ]
        );

        $chart = RozetkaChart::find($db_chart_id);
        $chart->load(['company', 'messages', 'receiver']);


        return json_encode([
            'status' => 'success',
            'render' => view('adminAndModerator.rozetka.chats.show.layouts.messagesItem', compact('chart'))->render(),
            'msg' => 'Сообщение успешно отправлено!'
        ]);

    }

    public function edit(Request $request, $id){

        $chart = RozetkaChart::find($id);

        if($chart->admin_status == '0') {
            return json_encode([
                'status' => 'danger',
                'msg' => 'Выбраный чат уже привязан, обновите страницу!'
            ]);
        }

        if($chart->type == '0'){
            $companies = Company::where('blocked', '0')->whereIn('id', json_decode($chart->companies_ids))->orderBy('name', 'asc')->get();
        }else{
            $companies = Company::where('blocked', '0')->orderBy('name', 'asc')->get();
        }

        return json_encode([
            'status' => 'success',
            'render' => view('adminAndModerator.rozetka.chats.index.layouts.modal_content', compact('chart', 'companies'))->render(),
            'chartId' => $id,
            'msg' => 'Выбирете компанию для привязки чата!'
        ]);
    }

    public function update(Request $request, $id){

        $chart = RozetkaChart::find($id);
        $company = Company::find($request->company_id);

        if($chart->type == '0'){

            $orders_ids_array = json_decode($chart->orders_ids);
            $resault_check_order_array = [];
            foreach ($orders_ids_array as $order_id){
                $order = Order::find($order_id);
                if($order->company_id == $request->company_id){
                    array_push($resault_check_order_array, $order->id);
                }
            }

            if(count($resault_check_order_array) < 1){
                return json_encode([
                    'status' => 'danger',
                    'msg' => 'Привязка не возможна: ни один из заказов не относится к выбранной компании!'
                ]);
            }

            $chart->orders_ids = json_encode($resault_check_order_array);
         }

        $chart->admin_status = '0';
        $chart->companies_ids = null;
        $chart->company_id = $request->company_id;
        $chart->read_market = '0';
        $chart->save();

        return json_encode([
            'status' => 'success',
            'chartId' => $id,
            'msg' => 'Чат успешно привязан компании: '.$company['name'].'.'
        ]);
    }
}