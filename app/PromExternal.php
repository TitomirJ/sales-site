<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromExternal extends Model
{
    protected $table = 'external_unloading';

    protected $fillable = [
        'unload_url', 'company_id'
    ];

    public function company(){
        return $this->belongsTo('\App\Company', 'company_id');
    }

    public function promCategories()
    {
        return $this->hasMany('App\PromCategory', 'external_id', 'id')->whereHas('promProducts');
    }

    public function promProducts()
    {
        return $this->hasMany('App\PromProduct', 'external_id', 'id');
    }

    public function countNotLinkCats(){
        $cats = PromCategory::where('external_id', $this->id)->where('subcategory_id', null)->whereHas('promProducts')->get();
        return $cats->count();
    }

    public function countLinkCats(){
        $cats = PromCategory::where('external_id', $this->id)->where('subcategory_id', '<>', null)->whereHas('promProducts')->get();
        return $cats->count();
    }

    public function countInfoArrayProducts(){
        $products = PromProduct::where('external_id', $this->id)->get();
        $data = [
            'new' => 0,
            'link' => 0,
            'checked' => 0,
            'created' => 0,
            'error'=> 0
        ];
        foreach ($products as $p){
            if($p->confirm == '0'){
                $data['new'] = $data['new']+1;
            }elseif($p->confirm == '1'){
                $data['link'] = $data['link']+1;
            }elseif($p->confirm == '2'){
                $data['checked'] = $data['checked']+1;
            }elseif($p->confirm == '3'){
                $data['created'] = $data['created']+1;
            }elseif($p->confirm == '4'){
                $data['error'] = $data['error']+1;
            }

        }
        return $data;
    }
}
