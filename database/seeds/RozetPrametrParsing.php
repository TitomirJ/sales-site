<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Subcategory;
use App\SubcategoriesOption;
use App\Parametr;
use App\Value;
use App\ParametrsValue;
use App\SubcategoriesParametr;

class RozetPrametrParsing extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('all_subcategories_options')->whereBetween('id', [1013, 1014])->orderBy('id')->chunk(1, function ($options) {
            foreach ($options as $option) {
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
        });
        //$option = SubcategoriesOption::find(3);

//                $json_data =  $option->options;
//                $array_data = json_decode($json_data, true);
//
//                for ($i=0; $i < count($array_data); $i++){
//                    $parametr = Parametr::firstOrCreate(
//                        ['rozet_id' => $array_data[$i]['id']],
//                        [
//                            'rozet_id' => $array_data[$i]['id'],
//                            'name' => $array_data[$i]['name'],
//                            'attr_type' => $array_data[$i]['attr_type'],
//                        ]
//                    );
//
//
//
//                    SubcategoriesParametr::firstOrCreate(
//                        [
//                            'subcategory_id' => $option->testsubcategory_id,
//                            'parametr_id' => $parametr->id,
//                        ],
//                        [
//                            'subcategory_id' => $option->testsubcategory_id,
//                            'parametr_id' => $parametr->id,
//                        ]
//                    );
//
//
//
//                    if(($array_data[$i]['value_id'] != null) && ($array_data[$i]['value_id'] != '')){
//                        $value = Value::firstOrCreate(
//                            ['rozet_id' => $array_data[$i]['value_id']],
//                            [
//                                'rozet_id' => $array_data[$i]['value_id'],
//                                'name' => $array_data[$i]['value_name'],
//                            ]
//                        );
//
//                        ParametrsValue::firstOrCreate(
//                            [
//                                'parametr_id' => $parametr->id,
//                                'value_id' => $value->id,
//                                ],
//                            [
//                                'parametr_id' => $parametr->id,
//                                'value_id' => $value->id,
//                            ]
//                        );
//
//                    }
//
//
//                }





    }
}
