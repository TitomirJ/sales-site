<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametr extends Model
{
    protected $fillable = [
        'rozet_id', 'name', 'attr_type',
    ];

    public function values()
    {
        return $this->belongsToMany('App\Value', 'parametrs_values', 'parametr_id', 'value_id');
    }
}
