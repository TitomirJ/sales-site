<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyWarning extends Model
{
    protected $fillable = [
        'company_id', 'inspector_id', 'type_warning', 'desc_warning', 'product_id', 'order_id'
    ];

    protected $table = 'company_warnings';

    public function company()
    {
        return $this->belongsTo('\App\Company', 'company_id');
    }

    public function product()
    {
        return $this->belongsTo('\App\Product')->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo('\App\Order');
    }

    public function inspector()
    {
        return $this->belongsTo('\App\User', 'inspector_id', 'id');
    }
}
