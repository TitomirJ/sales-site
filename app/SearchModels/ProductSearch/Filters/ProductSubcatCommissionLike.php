<?php

namespace App\SearchModels\ProductSearch\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductSubcatCommissionLike implements Filter
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
        return $builder->whereHas('subcategory', function ($query) use ($value)  {
            $query->where('commission', $value);
        });
    }
}