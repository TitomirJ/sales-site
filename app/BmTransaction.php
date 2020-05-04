<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BmTransaction extends Model
{
    protected $fillable = [
         'code', 'name', 'surname', 'email', 'phone', 'currency_id', 'amount', 'description', '	status', 'data'
    ];

    public function currency()
    {
        return $this->belongsTo('\App\Currency', 'currency_id', 'id');
    }
}
