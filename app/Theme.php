<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'categories_themes',  'theme_id','category_id');
    }

    public function subcategories()
    {
        return $this->hasManyThrough('App\Subcategory', 'App\Category');
    }
}
