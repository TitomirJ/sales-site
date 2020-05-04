<?php

namespace App\SearchModels\CompanySearch\Filters;

use Illuminate\Database\Eloquent\Builder;

class ResponsiblePhoneLikePercent implements Filter
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
        if($value == null){
            return $builder;
        }else{
            $phone =  stristr($value, '_', true);

            return $builder->where('responsible_phone', 'like', '%'.$phone.'%');
        }

    }
}