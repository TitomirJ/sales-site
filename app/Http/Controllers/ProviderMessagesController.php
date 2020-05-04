<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Functions\RozetkaApi;
use App\RozetkaChart;
use App\RozetkaMessage;
use App\Company;
use App\Usetting;

class ProviderMessagesController extends Controller
{

    private function usettingPagination(){
        $user = Auth::user();
        $usettings = Usetting::updateOrCreate(
            [
                'user_id' =>  $user->id,
            ],
            [
                'user_id' =>  $user->id,
                'n_par_3' => 20
            ]
        );

        return $usettings;
    }

    public function index(Request $request){
        $user = Auth::user();


        // настройки пагинации
        $usetting = self::usettingPagination();
        // Тип страницы
        $array_types = [
            'orders' => [
                'type' => '0',
                'title' => 'Вопросы по заказам'
            ],
            'products' => [
                'type' => '1',
                'title' => 'Вопросы по товарам'
            ],
            'other' => [
                'type' => '2',
                'title' => 'Вопросы от покупателей'
            ]];
        $type_subpage = (isset($request->type)) ? $request->type : 'orders';
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

        $counts_charts = self::countNewMessagesForTypes($user->company_id);

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

            $charts = RozetkaChart::where('company_id', $user->company_id)
                ->where('type', $array_types[$type_subpage]['type'])
                ->where($request->search_protocol, 'like', '%'.$request->search_text.'%')
                ->orderBy($sort_name, $sort_type)
                ->with(['company', 'messages', 'product'])
                ->paginate($usetting->n_par_3)
                ->appends($appends);
        }else{
            $charts = RozetkaChart::where('company_id', $user->company_id)
                ->where('type', $array_types[$type_subpage]['type'])
                ->orderBy($sort_name, $sort_type)
                ->with(['company', 'messages', 'product'])
                ->paginate($usetting->n_par_3)
                ->appends($appends);
        }



        if($request->ajax()){
            return json_encode([
                'status' => 'success',
                'render' => view('provider.company.message.index.layouts.chart', compact('charts', 'type_subpage'))->render()
            ]);
        }

        return view('provider.company.message.index.index', compact('charts', 'type_subpage', 'counts_charts'))->withTitle($array_types[$type_subpage]['title']);

    }

    //private function countNewMessagesForTypes($company_id){
	public static function countNewMessagesForTypes($company_id){
        $charts = RozetkaChart::where('company_id', $company_id)->where('read_market', '0')->get();

        $counts_array = ['orders' => 0, 'products' => 0, 'other' => 0];

        foreach ($charts as $c){
            if($c->type == '0'){
                $counts_array['orders']++;
            }elseif($c->type == '1'){
                $counts_array['products']++;
            }elseif($c->type == '2'){
                $counts_array['other']++;
            }
        }

        return $counts_array;
    }

    public function groupActionsChart(Request $request){

        $user = Auth::user();
        $company_id = $user->company_id;
        RozetkaChart::where('company_id', $company_id)->whereIn('id', $request->chart_id)->with(['company', 'messages', 'product'])->update(['read_market' => $request->action]);
        $updated_cols = RozetkaChart::where('company_id', $company_id)->whereIn('id', $request->chart_id)->with(['company', 'messages', 'receiver', 'product'])->get();
        $type_subpage = $request->type;


        $for_array = [];

        foreach ($updated_cols as $chart){
            array_push($for_array, [
                'id' => $chart->id,
                'content' => view('provider.company.message.index.layouts.layouts.chartItem', compact('type_subpage', 'chart'))->render()
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
        $user = Auth::user();

        $chart = RozetkaChart::where('id', $id)->where('company_id', $user->company_id)->with(['company', 'messages', 'receiver', 'product'])->first();

        $chart_update = RozetkaChart::find($chart['id']);
        $chart_update->read_market = '1';
        $chart_update->save();

        return view('provider.company.message.show.show', compact('chart'))->withTitle($chart->subject);
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
            'render' => view('provider.company.message.show.layouts.messagesItem', compact('chart'))->render(),
            'msg' => 'Сообщение успешно отправлено!'
        ]);

    }

//    public function create(Request $request){
//        $array = [
//            'm_id' => 3500415,
//            'm_order_id' => null,
//            'receiver_id' => 72892692,
//            'send_email' => 0,
//            'body' => 'Тест'
//        ];
//
//        $test = RozetkaApi::createMessageForChart1($array, '1');
//        // $test =  RozetkaApi::getSearchActiveProducts();
//        dd($test);
//    }
}