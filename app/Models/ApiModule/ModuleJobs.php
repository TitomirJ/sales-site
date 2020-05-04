<?php

namespace App\Models\ApiModule;

use App\Order;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Model;

class ModuleJobs extends Model
{
    public static function createOrderCheckStatusJob($order_id, $marketplace_id, $delay_type = 'M', $delay_amount = 60){

        if($marketplace_id == '1'){

            $client = new Client(['headers' => [
                'Content-Type' => 'application/json'
            ]]);


            $result = $client->request('post','https://api.bigsales.pro/api/jobs/actions', [
                'json' => [
                    "api_key" => 'ZXNuYm1uc3kycG9q',
                    "data" => [
                        'action' => 'createJobs',
                        'jobs' => [
                            'class' => 'check_order_status',
                            'settings' => [
                                'delay_type' => $delay_type,
                                'delay_amount' => $delay_amount
                            ],
                            'params' => [
                                'order_id' => $order_id,
                                'marketplace_id' => $marketplace_id
                            ]
                        ]
                    ]
                ]
            ]);

            $result = json_decode($result->getBody());

            return $result;
        }
    }

    public static function createOrderCheckDeliveryJob($order){
        $client = new Client(['headers' => [
            'Content-Type' => 'application/json'
        ]]);


        $result = $client->request('post','https://api.bigsales.pro/api/jobs/actions', [
            'json' => [
                "api_key" => 'ZXNuYm1uc3kycG9q',
                "data" => [
                    'action' => 'createJobs',
                    'jobs' => [
                        'class' => 'check_order_delivery',
                        'settings' => [
                            'delay_type' => 'M',
                            'delay_amount' => 0
                        ],
                        'params' => [
                            'order_id' => $order->id,
                            'delivery_type' => 'УкрПочта'
                        ]
                    ]
                ]
            ]
        ]);

        $result = json_decode($result->getBody());

        return $result;
    }

    public static function createJobForUpdateProductsFromExcel($data, $delay_type = 'M', $delay_amount = 60){

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json'
        ]]);


        $result = $client->request('post','https://api.bigsales.pro/api/jobs/actions', [
            'json' => [
                "api_key" => 'ZXNuYm1uc3kycG9q',
                "data" => [
                    'action' => 'createJobs',
                    'jobs' => [
                        'class' => 'update_products_from_excel',
                        'settings' => [
                            'delay_type' => $delay_type,
                            'delay_amount' => $delay_amount
                        ],
                        'params' => [
                            'external_product' => $data,
                        ]
                    ]
                ]
            ]
        ]);

        $result = json_decode($result->getBody());

        return $result;
    }
}
