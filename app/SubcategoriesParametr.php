<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubcategoriesParametr extends Model
{
    protected $table = 'subcategories_parametrs';

    protected $fillable = [
        'parametr_id', 'subcategory_id',
    ];
}
