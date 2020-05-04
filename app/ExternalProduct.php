<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExternalProduct extends Model
{
    protected $table = 'external_products';

    protected $fillable = [
        'company_id', 'file_path', 'count_products', 'count_updated', 'count_notfound', 'step', 'status'
    ];

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }
}
