<?php

namespace App\SearchModels\ProductSearchBuilder;

use App\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductSearchBuilder
{
    public static function apply($filters, $other_query = [], $withTrashed=false)
    {
        $query =
            static::applyDecoratorsFromRequest(
                $filters, (new Product)->newQuery()
            );

        if($withTrashed){
            $query = $query->withTrashed();
        }

        $query = static::applyAddOtherQuery($query, $other_query);

        $collection = static::getResults($query);

        return $collection;
    }

    private static function applyAddOtherQuery(Builder $query, $other_query)
    {
        if(count($other_query) > 0){
            for($i = 0; $i < count($other_query); $i++){
                if($other_query[$i][0] == 'where'){
                    $query = $query->where($other_query[$i][1], $other_query[$i][2], $other_query[$i][3]);
                }elseif($other_query[$i][0] == 'whereIn'){
                    $query = $query->whereIn($other_query[$i][1], $other_query[$i][3]);
                }
            }
            return $query;
        }
        return $query;
    }

    private static function applyDecoratorsFromRequest($request, Builder $query)
    {
        foreach ($request as $filterName => $value) {

            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }

        }
        return $query;
    }

    private static function createFilterDecorator($name)
    {
       return __NAMESPACE__ . '\\Filters\\' .
        str_replace(' ', '',
            ucwords(str_replace('_', ' ', $name)));
    }

    private static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    private static function getResults(Builder $query)
    {
        return $query->orderBy('created_at', 'desc');
    }

}