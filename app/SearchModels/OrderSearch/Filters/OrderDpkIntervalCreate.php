<?php

namespace App\SearchModels\OrderSearch\Filters;

use Illuminate\Database\Eloquent\Builder;

class OrderDpkIntervalCreate implements Filter
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

        $date_array = explode(' - ', $value);
        $base_from = date('Y-m-d' . ' 00:00:00', strtotime($date_array[0]));
        $base_to = date('Y-m-d' . ' 23:59:59', strtotime($date_array[1]));

        return $builder->whereBetween('created_at', [$base_from, $base_to]);
    }
}