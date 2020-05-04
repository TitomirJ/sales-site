<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromCategory extends Model
{
    protected $table = 'prom_cats';
    public $timestamps = false;

    public function subcategory()
    {
        return $this->belongsTo('\App\Subcategory', 'subcategory_id');
    }

    public function external()
    {
        return $this->belongsTo('\App\PromExternal', 'external_id');
    }

    public function promProducts()
    {
        return $this->hasMany('App\PromProduct', 'market_id', 'market_id')->where('external_id', $this->external_id);
    }

}
