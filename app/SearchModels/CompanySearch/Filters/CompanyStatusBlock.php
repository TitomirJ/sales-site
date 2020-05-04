<?php

namespace App\SearchModels\CompanySearch\Filters;

use Illuminate\Database\Eloquent\Builder;

class CompanyStatusBlock implements Filter
{

    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value)
    {
        if($value == 'all' || $value == null){
            return $builder;
        }elseif($value == 'active'){
            return $builder->where('block_ab', '0')->where('block_bal', '0')->where('block_new', '0');
        }elseif($value == 'not_active'){
            return $builder->where(function ($query) {
                $query->where('block_ab', '1')->orWhere('block_bal', '1')->orWhere('block_new', '1');
            });
        }elseif($value == 'blocked'){
            return $builder->where('blocked', '1');
        }else{
            return $builder;
        }
    }
}