<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tempcompany extends Model
{
    protected $table = 'tempcompanies';

    protected $fillable = [
        'company_id'
    ];
    
    public $timestamps = false;
}