<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Vis\eSputnikClient\eSputnikClient;
use Excel;
use DB;
use App\User;
use App\Subcategory;
use App\SubcategoriesOption;
use App\Parametr;
use App\Value;
use App\Company;
use App\Transaction;
use App\Usetting;
use App\Product;
use App\Order;

class AdminController extends Controller
{
    public  function indexBrief(Request $request){
        //баланс еСпутника(СМС)
        $client = new eSputnikClient;
        $bal_esputnik =  json_decode($client->getMyParam('GET', 'balance'));

//        $resault = Excel::load('excel/30112018_category_4647990_attributes.xls', function($reader) {
//
//            $reader->all();
//
//        })->get();

//        $headings =  $resault->getHeading(); //- заголовки

        //подсчет компаний
//        $companies = Company::get();
//        $data_companies = self::countDinamScopeCompany($companies);
//        $subcategories = Subcategory::doesnthave('parametrs')->get();

        
        return view('adminAndModerator.brief.index', compact('bal_esputnik', 'resault', 'headings'));
    }

    private function countDinamScopeCompany($companies){
        $data = [
            'active' => 0,
            'not_active' => 0,
            'blocked' => 0
        ];
        foreach ($companies as $company){
                if($company->block_ab == '0' && $company->block_bal == '0' && $company->block_new == '0' && $company->blocked == '0'){
                    $data['active'] = $data['active']+1;
                }elseif(($company->block_ab == '1' || $company->block_bal || '1' && $company->block_new || '1') && $company->blocked == '0'){
                    $data['not_active'] = $data['not_active']+1;
                }elseif($company->blocked == '1'){
                    $data['blocked'] = $data['blocked']+1;
                }
        }
        return $data;
    }

    public function personnelIndex(){
        $personnel = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin')->orWhere('name', 'moderator');
        })->get();

        return view('admin.personnel.index', compact('personnel'))->withTitle('Сотрудники сайта');
    }

    public function moderatorDelete(Request $request, $id){
        if($request->user()->isAdmin()){
            $user = User::find($id);
            if($user){
                $user->delete();
                return redirect()->route('admin_personnel_index')->with('success', 'Удаление успешно выполнено!');
            }else{
                return redirect()->route('admin_personnel_index')->with('danger', 'Действие невыполнимо, такой пользователь отсутсвует или уже удален!');
            }
        }else{
            return redirect()->route('admin_personnel_index')->with('danger', 'В доступе отказано!');
        }

    }

    public function parcingRozetParametrsAndValuesFromSubcategoriesToDB($from, $to){
         SubcategoriesOption::whereBetween('id', [$from, $to])->chunk(1, function ($rozet_options) {
            foreach ($rozet_options as $option){
                $json_data =  $option->options;
                $array_data = json_decode($json_data, true);
                $flag = 0;
                for ($i=0; $i < count($array_data); $i++){
                    $parametr = Parametr::firstOrCreate(
                        ['rozet_id' => $array_data[$i]['id']],
                        [
                            'rozet_id' => $array_data[$i]['id'],
                            'name' => $array_data[$i]['name'],
                            'attr_type' => $array_data[$i]['attr_type'],
                        ]
                    );



                    if($flag==$parametr->id){

                    }else{
                        DB::insert('insert into subcategories_parametrs (subcategory_id, parametr_id) values (?, ?)', [$option->subcategory_id, $parametr->id]);
                    }


                    if(($array_data[$i]['value_id'] != null) && ($array_data[$i]['value_id'] != '')){
                        $value = Value::firstOrCreate(
                            ['rozet_id' => $array_data[$i]['value_id']],
                            [
                                'rozet_id' => $array_data[$i]['value_id'],
                                'name' => $array_data[$i]['value_name'],
                            ]
                        );

                        DB::insert('insert into parametrs_values (parametr_id, value_id) values (?, ?)', [$parametr->id, $value->id]);
                    }

                    $flag=$parametr->id;
                }
            }

        });

        return 'all right';
    }
}
