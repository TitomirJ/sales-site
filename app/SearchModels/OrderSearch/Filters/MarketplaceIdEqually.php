<?php

namespace App\SearchModels\OrderSearch\Filters;

use Illuminate\Database\Eloquent\Builder;

class MarketplaceIdEqually implements Filter
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
        }
        return $builder->where('marketplace_id', $value);
    }
}