<?php

namespace App\SearchModels\ProductSearch\Filters;

use Illuminate\Database\Eloquent\Builder;

class StatusSpacialEqually implements Filter
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
        $spacial_status_array = ['0', '1'];

        if($value == 'all' || $value == null){
            return $builder;
        }elseif(in_array($value, $spacial_status_array)){
            return $builder->where('status_spacial', $value);
        }

        return $builder;

    }
}