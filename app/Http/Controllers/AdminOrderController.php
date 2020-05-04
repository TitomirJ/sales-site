<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Functions\StaticFunctions as SF;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
use App\User;
use App\Product;
use App\Marketplace;
use App\Company;
use App\Order;
use App\Transaction;
use App\Functions\RozetkaApi;

class AdminOrderController extends Controller
{
    public function index(Request $request){
        $market_orders_id = RozetkaApi::getOrderTypeList(3);
        $orders = Order::whereIn('order_market_id', $market_orders_id)->where('status', '<>', '2')->orderBy('created_at', 'desc')->paginate(20);
        //$orders = Order::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.order.index', compact('orders'))->withTitle('Создать заказ');
    }

    public function create(Request $request){
        $products = Product::all();
        $products->load('company');
        $marketplaces = Marketplace::all();
        return view('admin.order.create', compact('products', 'marketplaces'))->withTitle('Создать заказ');
    }

    public function store(Request $request){
        $product_id = $request->product_id;
        $product = Product::find($product_id);
        $company = Company::find($product->company_id);
        $subcat_commission = $product->subcategory->commission;
        $product_price = $product->price;
        $quantity = $request->quantity;

        $commission = $product_price * $quantity / 100 * $subcat_commission;
        $total_sum = $product_price * $quantity;

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'marketplace_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'customer_name' => 'required|string|max:180',
        ],
            [
                'quantity.required' => 'Поле "Количество" обязательно!',
                'customer_name.required' => 'Поле "ФИО покупателя" обязательно!',
            ]
        );

        if ($validator->fails()) {
            return redirect('admin/orders/create')
                ->with('errorsArray', $validator->getMessageBag()->toArray())
                ->withInput()->withErrors($validator);
        }

        $new_order = Order::create([
            'product_id' => $product_id,//int(10)
            'user_id' => $product->user_id,//int(10)
            'company_id' => $company->id,//int(10)
            'marketplace_id' => $request->marketplace_id,//int(10)
            'name' => $product->name,//varchar(180)
            'quantity' => $quantity,//	int(11)
            'total_sum' => $total_sum,//double(20,2)
            'commission_sum' => $commission,//double(20,2)
            'customer_name' => $request->customer_name,//	varchar(191)
            'customer_email' => $request->customer_email,//	varchar(191)
            'customer_phone' => $request->customer_phone,//	varchar(191)
            'customer_adress' => $request->customer_adress,//	varchar(191)
            'comment' => $request->comment,//	longtext
            'delivery_method' => $request->delivery_method,//varchar(180)
            'payment_method' => $request->payment_method,//varchar(180)
            'market_id' => 0,//	bigint(20)
        ]);

        $new_transaction = Transaction::create([
            'company_id' => $new_order->company_id,
            'order_id' =>$new_order->id,
            'type_dk' => '0',
            'type_transaction' => '1',
            'total_sum' =>$new_order->commission_sum
        ]);

        SF::recalculationBalanceCompany($new_transaction->company_id);
        SF::checkCompanyBalance($new_transaction->company_id);
        self::comboFunctionsProductsSpetial($new_transaction->company_id);
        self::orderShipped($new_transaction->company_id);

        return back()->with('success', 'Заказ успешно создан!');
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
        }
    }

    public function show(Request $request, $id){
        if($request->ajax()){
            $product = Product::find($id);
            $product->load('company');
            $product->load('subcategory');
            $data = [];
            $data['status'] = 'success';
            $data['render'] = view('admin.order.layouts.productItem', compact('product'))->render();

            return json_encode($data);
        }else{
            abort('404');
        }
    }

    public function showOrder(Request $request, $id){
        $order = Order::find($id);

        dd($order);
    }


    // временный роут для смены статуса обр. менеджером -> доставляется новой почтой
    public function changeStatusDelOrders($id){
        $order = Order::find($id);
        $order_market_id = $order->order_market_id;
        $ttn = $order->ttn;

        $text = 'Данные подверждены, заказ ожидает отправки';
        RozetkaApi::putOrderStatus($order->order_market_id, 2, $text);

        $text = 'ТТН: '.$ttn;
        $response = RozetkaApi::putOrderStatus($order->order_market_id, 3, $text, $ttn);

        dd($response);
    }
}
