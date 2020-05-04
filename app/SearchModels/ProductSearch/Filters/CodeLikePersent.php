<?php

namespace App\SearchModels\ProductSearch\Filters;

use Illuminate\Database\Eloquent\Builder;

class CodeLikePersent implements Filter
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
        return $builder->where('code', 'LIKE', '%'.$value.'%');
    }
}