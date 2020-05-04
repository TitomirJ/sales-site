<?php

namespace App\SearchModels\OrderSearch\Filters;

use Illuminate\Database\Eloquent\Builder;

class CustomerNameLikePercent implements Filter
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
        if($value == '' || $value == null){
            return $builder;
        }
        return $builder->where('customer_name', 'like', '%'.$value.'%');
    }
}