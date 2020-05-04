<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubcategoriesOption extends Model
{
    protected $table = 'testsubcategories_options';
    public function subcategory()
    {
        return $this->belongsTo('\App\Subcategory', 'testsubcategory_id');
    }
}
