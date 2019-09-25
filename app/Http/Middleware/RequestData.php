<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use App;

class RequestData
{
    public function handle($request, Closure $next)
    {
        /** this variable can get name from route */
        $current_route = (Route::currentRouteName() && Route::currentRouteName()!='') ? explode('-', Route::currentRouteName()) : [];
        $request->current_route = $current_route;
        /** we will set locale here if needed */
        
        /** end of setlocale */
        $request->current_locale = App::getLocale();
        /** set router to check current route and get lang data from itself @by: @MAGIC 20190925 
         * add (.) to end of router to set trans data from current translate file */
        $request->router = implode($current_route, '/');
        $request->router .= '.';
        
        return $next($request);
    }
}
