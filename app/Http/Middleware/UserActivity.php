<?php
namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Auth;
use Cache;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()) {
            $last_ative = Carbon::now();
            $expiresAt = Carbon::now()->addMinutes(15);
            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
            Cache::put('user-last-time-online-' . Auth::user()->id, $last_ative);
        }
        return $next($request);
    }
}