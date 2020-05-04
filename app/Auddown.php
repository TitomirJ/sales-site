<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auddown extends Model
{
    protected $table = 'autoupdate_downs';

    protected $fillable = [
        'dcompany_id','dproduct_id','dprice','dold_price','dstatus_available'
    ];
    
    public $timestamps = false;

    
}
