<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autoupdate extends Model
{
    
    protected $table = 'autoupdates';

    protected $fillable = [
        'company_id','url_xml','date_update','info_update','error_update'
    ];
    
    public $timestamps = false;

    public function company(){
        return $this->hasOne('App\Company');
    }
}
