<?php

namespace App\SearchModels\ProductSearch\Filters;

use Illuminate\Database\Eloquent\Builder;

class StatusModerationEqually implements Filter
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
        $moderation_status_array = ['0', '1', '2', '3'];

        if($value == 'all' || $value == null){
            return $builder;
        }elseif($value == 'deleted'){
            return $builder->whereNotNull('deleted_at');
        }elseif(in_array($value, $moderation_status_array)){
            return $builder->where('status_moderation', $value);
        }

        return $builder;

    }
}