<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use Route;
use App\Http\Middleware\RouteName as RouteName;
use App\AdminUsers as AdminUsers;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        $route = $request->current_route[0];
        /** check login in admin mode and nonadmin mode */
        $login = false;
        if($route){
            /** this variable can get name from route */
            if($route=='admin'){
                $username = $request->session()->has('admin_user') ? 
                    $request->session()->get('admin_user') : false;
                $password = $request->session()->has('admin_pass') ? 
                    config('app.hash')($request->session()->get('admin_pass'), 'admin_password') : false;
                if($username && $password){
                    $admin_data = AdminUsers::where([
                        ['username', $username],
                        ['password', $password],
                        ['is_active', 1]
                    ])->get();
                    print_r($admin_data);exit();
                }
            } else {
                
            }
        }
        
        if (! $login) {
            $path = $request->getPathInfo();
            if($path != config('app.admin_url').'/login'){
                return config('app.admin_url').'/login/';
            }
        } else {
            if($path == config('app.admin_url').'/login'){
                return config('app.admin_url');
            }
        }
    }
}
