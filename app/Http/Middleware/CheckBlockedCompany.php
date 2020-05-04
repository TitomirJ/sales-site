<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Company;
use Illuminate\Support\Facades\Auth;

class CheckBlockedCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $flag = Auth::user()->company->isBlocked();
        if($flag){
            return redirect('/company/blocked')->withTitle('Блокировка');
        }else{
            return $next($request);
        }
    }
}
