<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParametrsValue extends Model
{
    protected $table = 'parametrs_values';

    protected $fillable = [
        'parametr_id', 'value_id',
    ];
}
