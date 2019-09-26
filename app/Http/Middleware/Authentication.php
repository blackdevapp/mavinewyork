<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use App\Http\Middleware\RouteName as RouteName;
use App\AdminUsers as AdminUsers;

class Authentication
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function handle($request, Closure $next)
    {
        $route = $request->current_route[0];
        /** check login in admin mode and nonadmin mode */
        $login = false;
        if($route){
            /** this variable can get name from route */
            // if route is admin :
            if($route=='admin'){
                $username = $request->session()->has('admin_user') ? 
                    $request->session()->get('admin_user') : false;
                $password = $request->session()->has('admin_pass') ? 
                    $request->session()->get('admin_pass') : false;
                if($username && $password){
                    $admin_data = AdminUsers::where([
                        ['username', $username],
                        ['password', $password],
                        ['is_active', 1]
                    ])->first(); 
                    if($admin_data){
                        $login = true;
                    }
                }
            // if route is not admin ( normal user ) :
            } else {
                
            }
        }
        $path = $request->getPathInfo();
        if (! $login) {
            if($path != config('app.admin_url').'/login'){
                return redirect(config('app.admin_url').'/login/');
            }
        } else {
            if($path == config('app.admin_url').'/login'){
                return redirect(config('app.admin_url'));
            }
        }
        return $next($request);
    }
}
