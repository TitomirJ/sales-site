<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PromCategory;


class PromProduct extends Model
{
    protected $table = 'promproducts';
    public $timestamps = false;

    public function promCat(){
        $market_id = $this->market_id;
        $external_id = $this->external_id;

        return PromCategory::where('market_id', $market_id)->where('external_id', $external_id)->get();
    }

    public function externalHasError()
    {
        $external_id = $this->external_id;
        $products = PromProduct::where('external_id', $external_id)->get();
        if (in_array('4', array_pluck($products, 'confirm'))) {
            return true;
        }

        return false;
    }

    public function external()
    {
        return $this->belongsTo('\App\PromExternal', 'external_id');
    }

    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
