<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Order;
use Cache;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'surname', 'phone', 'company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function lastTimeOnline()
    {
        if(Cache::has('user-last-time-online-' . $this->id)){
            return Cache::get('user-last-time-online-' . $this->id);
        }else{
            return 'nodata';
        }
    }

    public function usetting()
    {
        return $this->hasOne('App\Usetting');
    }

    public function company()
    {
        return $this->belongsTo('\App\Company');
    }

    public function companies()
    {
        return $this->hasMany('App\Company', 'moderator_id', 'id');
    }

    public function companyWarnings()
    {
        return $this->hasMany('App\CompanyWarning', 'inspector_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'users_roles', 'user_id', 'role_id');
    }

    public function orders(){
        return $this->hasMany('App\Order', 'user_id', 'id');
    }

    public function products(){
        return $this->hasMany('App\Product', 'user_id', 'id')->withTrashed();
    }

    public function isSuperAdmin()
    {
        $flag1 = in_array('admin', array_pluck($this->roles->toArray(), 'name'));
        $flag2 =  in_array('superAdmin', array_pluck($this->roles->toArray(), 'name'));
        if($flag1 && $flag2){
            return true;
        }else{
            return false;
        }
    }

    public function isAdminOrModerator()
    {
        $flag1 = in_array('admin', array_pluck($this->roles->toArray(), 'name'));
        $flag2 =  in_array('moderator', array_pluck($this->roles->toArray(), 'name'));
        if($flag1 || $flag2){
            return true;
        }else{
            return false;
        }
    }

    public function countOrders()
    {
        $user_id = $this->id;
        $products = Product::where('user_id', $user_id)->get();
        $count_orders = 0;
        foreach ($products as $p){
            $count_orders += $p->orders->count();
        }

        return $count_orders;
    }

    public function dinCountOrders($from, $to)
    {
        $user_id = $this->id;
        $products = Product::where('user_id', $user_id);
        $count_orders = 0;
        foreach ($products->get() as $p){
            $interval_orders = $p->orders()->dateIntervalCreate($from, $to)->get();
            foreach ($interval_orders as $order){
                $count_orders ++;
            }
        }
        return $count_orders;
    }

    public function totalSaleSum()
    {
        $user_id = $this->id;
        $products = Product::where('user_id', $user_id)->get();
        $total_sum = 0;
        foreach ($products as $p){
            foreach ($p->orders as $order){
                if($order->status == 1){
                    $total_sum += $order->total_sum;
                }
            }
        }

        return $total_sum;
    }

    public function dinTotalSaleSum($from, $to)
    {
        $user_id = $this->id;
        $products = Product::where('user_id', $user_id)->withTrashed();
        $total_sum = 0;
        foreach ($products->get() as $p){
            $interval_orders = $p->orders()->dateIntervalCreate($from, $to)->get();
            foreach ($interval_orders as $order){
                if($order->status == '1'){
                    $total_sum += $order->total_sum;
                }
            }
        }
        return $total_sum;
    }

    public function isAdmin()
    {
        return in_array('admin', array_pluck($this->roles->toArray(), 'name'));
    }

    public function isModerator()
    {
        return in_array('moderator', array_pluck($this->roles->toArray(), 'name'));
    }

    public function isProvider()
    {
        return in_array('provider', array_pluck($this->roles->toArray(), 'name'));
    }

    public function jobs()
    {
        return $this->belongsToMany('App\Job', 'users_jobs', 'user_id', 'job_id');
    }



    public function isProviderAndDirector()
    {
        return (in_array('provider', array_pluck($this->roles->toArray(), 'name')) && in_array('director', array_pluck($this->jobs->toArray(), 'name')));
    }

    public function isProviderAndManager()
    {
        return (in_array('provider', array_pluck($this->roles->toArray(), 'name')) && in_array('manager', array_pluck($this->jobs->toArray(), 'name')));
    }

    public function getFullName(){
        return $this->name.' '.$this->surname;
    }
}
