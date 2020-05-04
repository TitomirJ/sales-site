<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_id', 'user_id', 'company_id', 'marketplace_id', 'name',
        'quantity', 'total_sum', 'commission_sum', 'customer_name', 'customer_email',
        'customer_phone', 'customer_adress', 'comment', 'delivery_method', 'payment_method',
        'market_id', 'status_data'
        ];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function product()
    {
        return $this->belongsTo('\App\Product')->withTrashed();
    }

    public function transaction()
    {
        return $this->hasOne('App\Transaction');
    }

    public function company()
    {
        return $this->belongsTo('\App\Company');
    }

    public function marketplace()
    {
        return $this->belongsTo('\App\Marketplace');
    }

    public function companyWarnings()
    {
        return $this->hasMany('App\CompanyWarning');
    }

    public function scopeDateIntervalCreate($query, $from, $to)
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }
}
