<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'company_id', 'order_id', 'type_dk', 'type_transaction', 'total_sum', 'data_ab', 'data'
    ];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
