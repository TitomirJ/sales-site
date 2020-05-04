<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsItem extends Model
{
    protected $fillable = [
        'name', 'value', 'data', 'data_new', 'product_id',
    ];

    public function product()
    {
        return $this->belongsTo('\App\Product', 'product_id');
    }

	/**
    * блок методов по замене обратного слэша
    * в полях товара (апрель2020)

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = self::changeSlashInModel($value);
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = self::changeSlashInModel($value);
    }

    public function setDataAttribute($value)
    {
       
        $atr_arr = json_decode($value);
       
      if(isset($atr_arr->value)){
         $atr_arr->value = self::changeSlashInModel($atr_arr->value);
        
         $value = json_encode($atr_arr); 
         
      }
      $this->attributes['data'] = $value;
      
       
    }

    public function setDataNewAttribute($value)
    {
       
    
        $atr_arr = json_decode($value);
       
        if(isset($atr_arr->value)){
           $atr_arr->value = self::changeSlashInModel($atr_arr->value);
          
           $value = json_encode($atr_arr); 
           
        }
        $this->attributes['data_new'] = $value;
    }
	
    public function changeSlashInModel($value)
    {
        return $value = str_replace('\\', '/', $value);
    }
	*/
    //the end блок замены слэшей
}