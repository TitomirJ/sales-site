<?php

namespace App\SearchModels\CompanySearch\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Company;

class CompanyOnline implements Filter
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
        }else{
            $companies = Company::all();
            $companies->load('users');
            $companies_array = [];
            if($value == 'online'){
                foreach ($companies as $company){
                    foreach ($company->users as $user){
                        if($user->isOnline()){
                            array_push($companies_array, $user->company_id);
                        }
                    }
                }
                $companies_array_unique = array_unique($companies_array);
                return $builder->whereIn('id', $companies_array_unique);
            }elseif($value == 'offline'){
                foreach ($companies as $company){
                    foreach ($company->users as $user){
                        if(!$user->isOnline()){
                            array_push($companies_array, $user->company_id);
                        }
                    }
                }

                $companies_array_unique = array_unique($companies_array);
                return $builder->whereIn('id', $companies_array_unique);
            }else{
                return $builder;
            }
        }


    }
}