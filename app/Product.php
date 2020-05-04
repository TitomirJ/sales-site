<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'market_url', 'words', 'check_at', 'subcategory_id', 'name', 'desc', 'code', 'brand', 'price', 'old_price', 'gallery', 'video_url', 'user_id', 'company_id', 'status_moderation', 'status_available', 'status_spacial', 'status_remod', 'rozetka_on', 'rozetka_id', 'rozetka_data', 'prom_on', 'zakupka_on', 'data', 'options', 'currency_id', 'upload_type', 'external_id', 'data_error'
    ];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo('\App\Category', 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo('\App\Subcategory', 'subcategory_id')->withTrashed();
    }

    public function company()
    {
        return $this->belongsTo('\App\Company', 'company_id');
    }

    public function responsible()
    {
        return $this->belongsTo('\App\User', 'user_id');
    }

    public function companyWarnings()
    {
        return $this->hasMany('App\CompanyWarning');
    }

    public function productsItems(){
        return $this->hasMany('App\ProductsItem');
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }

    public function promProduct(){
        return $this->hasOne('App\PromProduct');
    }
	/**
 	* блок методов по замене обратного слэша
 	* в полях товара (апрель2020)
 	
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = self::changeSlashInModel($value);
    }
    public function setDescAttribute($value)
    {
        $this->attributes['desc'] = self::changeSlashInModel($value);
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = self::changeSlashInModel($value);
    }

    public function setBrandAttribute($value)
    {
        $this->attributes['brand'] = self::changeSlashInModel($value);
    }

    public function changeSlashInModel($value)
    {
        return $value = str_replace('\\', '/', $value);
    }
	*/
    //the end блок замены слэшей
}