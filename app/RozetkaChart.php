<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RozetkaChart extends Model
{
    protected $table = 'rozetka_charts';

    protected $fillable = [
        'm_id','subject','m_user_id', 'user_fio', 'read_market','trash_market','star_market','m_order_id','orders_ids','m_product_id','product_id','type','admin_status','company_id','companies_ids',
    ];

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id', 'id');
    }

    public function messages(){
        return $this->hasMany('App\RozetkaMessage', 'chart_id', 'id')->orderBy('m_created_at', 'asc');
    }

    public function receiver(){
        return $this->belongsTo('App\RozetkaUser', 'm_user_id', 'm_id');
    }

    public function product(){
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }
}
