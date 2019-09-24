<?php

namespace App\Http\Middleware;

use Closure;
use Route;

class RequestData
{
    public function handle($request, Closure $next)
    {
        /** this variable can get name from route */
        $current_route = (Route::currentRouteName() && Route::currentRouteName()!='') ? explode('-', Route::currentRouteName()) : [];
        $request->current_route = $current_route;
        
        return $next($request);
    }
}
