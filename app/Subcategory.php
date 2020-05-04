<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'name', 'commission', 'category_id', 'market_subcat_id', 'parent_subcat_id'
    ];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo('\App\Category', 'category_id');
    }

    public function products(){
        return $this->hasMany('App\Product', 'subcategory_id', 'id');
    }

    public function options(){
        return $this->hasOne('App\SubcategoriesOption', 'subcategory_id', 'id');
    }

    public function parametrs()
    {
        return $this->belongsToMany('App\Parametr', 'subcategories_parametrs', 'subcategory_id', 'parametr_id');
    }
}
