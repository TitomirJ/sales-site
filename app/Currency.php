<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public function bmTransactions(){
        return $this->hasMany('App\BmTransaction', 'currency_id', 'id')->withTrashed();
    }
}
