<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use App\Product;

class Company extends Model
{
    protected $fillable = [
        'name', 'legal_person', 'link', 'responsible', 'responsible_phone', 'info', 'moderator_id', 'ab_to', 'block_new', 'block_ab', 'block_bal', 'type_company', 'data', 'tariff_plan'
    ];

    protected $hidden = [
        'blocked', 'balance_sum', 'balance_limit', 'debet_sum', 'kredit_sum'
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function products(){
        return $this->hasMany('App\Product', 'company_id', 'id')->withTrashed();
    }

    public function countProducts()
    {
        $products = Product::where('company_id', $this->id)->get();
        return $products->count();
    }

    public function countProductsInfo()
    {
        $products = Product::where('company_id', $this->id)->where('status_moderation', '0')->get();
        return $products->count();
    }

    public function countProductsSuccess()
    {
        $products = Product::where('company_id', $this->id)->where('status_moderation', '1')->get();
        return $products->count();
    }

    public function countProductsWarning()
    {
        $products = Product::where('company_id', $this->id)->where('status_moderation', '2')->get();
        return $products->count();
    }

    public function countProductsDanger()
    {
        $products = Product::where('company_id', $this->id)->where('status_moderation', '3')->get();
        return $products->count();
    }

    public function moderator()
    {
        return $this->belongsTo('\App\User', 'id', 'moderator_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction')->orderBy('created_at', 'desc');
    }

    public function companyWarnings()
    {
        return $this->hasMany('App\CompanyWarning');
    }

    public function externals()
    {
        return $this->hasMany('App\PromExternal', 'company_id', 'id')->orderBy('id', 'desc');
    }

    public function countOrders()
    {
        $orders = Order::where('company_id', $this->id)->get();
        return $orders->count();
    }

    public function countNewOrders()
    {
        $orders = Order::where('company_id', $this->id)->where('status', '0')->get();
        return $orders->count();
    }

    public function countSaleOrders()
    {
        $orders = Order::where('company_id', $this->id)->where('status', '1')->get();
        return $orders->count();
    }

    public function countNotSaleOrders()
    {
        $orders = Order::where('company_id', $this->id)->where('status', '2')->get();
        return $orders->count();
    }

    public function countConfirmOrders()
    {
        $orders = Order::where('company_id', $this->id)->where('status', '4')->get();
        return $orders->count();
    }

    public function countSendingOrders()
    {
        $orders = Order::where('company_id', $this->id)->where('status', '3')->get();
        return $orders->count();
    }

    public function isBlocked(){
        if($this->blocked == '1'){
            return true;
        }elseif($this->blocked == '0'){
            return false;
        }
    }

    public function isAbonimentBlocked(){
        if($this->block_ab == '1'){
            return true;
        }elseif($this->block_ab == '0'){
            return false;
        }
    }

    public function isBalanceBlocked(){
        if($this->block_bal == '1'){
            return true;
        }elseif($this->block_bal == '0'){
            return false;
        }
    }

    public function countDinamScopeCompany($type){
        $count = 0;
        foreach ($this as $company){
            if($type == 'activ'){
                if($company->block_ab == '0' && $company->block_bal == '0' && $company->block_new == '0' && $company->blocked == '0'){$count++;}
            }elseif($type == 'not_activ'){
                if(($company->block_ab == '1' || $company->block_bal || '1' && $company->block_new || '1') && $company->blocked == '0'){$count++;}
            }elseif($type == 'blocked'){
                if($company->blocked == '1'){$count++;}
            }
        }

        return $this;
    }

    public function externalProduct(){
        return $this->hasOne('App\ExternalProduct', 'company_id', 'id');
    }

    public function rozetkaCharts()
    {
        return $this->hasMany('App\RozetkaChart', 'company_id', 'id');
    }
	
	public function autoupdates()
    {
        return $this->hasMany('App\Autoupdate','company_id','id');
    }
}