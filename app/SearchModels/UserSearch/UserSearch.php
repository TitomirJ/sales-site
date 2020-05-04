<?php

namespace App\SearchModels\UserSearch;

use App\User;
use Illuminate\Database\Eloquent\Builder;

class UserSearch
{
    public static function apply($filters, $loads = [], $other_query = [])
    {
        $query =
            static::applyDecoratorsFromRequest(
                $filters, (new User)->newQuery()
            );

        $query = static::applyAddOtherQuery($query, $other_query);

        $collection = static::getResults($query);

        $collection_with_loads = static::getLoads($collection, $loads);

        return $collection_with_loads;
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
        return $query->get();
    }

    private static function getLoads($collection, $loads = [])
    {
        if(count($loads) > 0){
            foreach ($loads as $load){
                $collection->load($load);
            }
            return $collection;
        }
        return $collection;
    }
}