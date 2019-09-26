<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminUsers as AdminUsers;
use Validator;

class adminController extends Controller
{
    public function home(Request $request){
        /** check if admin is login or not , then refer to current page */
        return view('admin.home')->with(['router' => $request->router]);
    }
    public function showLogin(Request $request){
        /** check if session exists and return to home page @by: @MAGIC 20190926 */
        $validator = Validator::make($request->all(), []);
        if($request->session()->has('admin_user') && $request->session()->has('admin_pass')){
            return redirect($request->current_route[0]);
        }
        if($request->has('username') && !$validator->fails()){
            /** add a validator where username exists @by: @MAGIC 20190926 */
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:3|max:50|regex:/^[a-zA-Z0-9._-]{3,50}$/',
                'password' => 'required|min:5|max:50'
            ]);
            $username = $request->username;
            $password = $request->password;
            /** check validation of form here @by: @MAGIC 20190925 */
            /** if validation is true , then below codes will run @by: @MAGIC 20190926 */
            // change password to hash type with admin_password type :
            $password = config('app.hash')($password, 'admin_password');
            $admin_data = AdminUsers::where([
                ['username', $username],
                ['password', $password],
                ['is_active', 1]
            ])->first();
            if($admin_data){
                /** set admin data to session and then redirect to home page @by: @MAGIC 20190926 */
                $request->session()->put('admin_user', $username);
                $request->session()->put('admin_pass', $password);
                $request->session()->put('name', $admin_data->name);
                $request->session()->put('email', $admin_data->email);
                return redirect($request->current_route[0]);
            } else {
                /** add a message to validator to throw an error if user or password is not true @by: @MAGIC 20190926 */
                $validator->getMessageBag()->add('', trans('validation.nouser'));
            }
        }
        return view('admin.login')->with(['router' => $request->router])->withErrors($validator);
    }
    /** admin logout */
    public function logout(Request $request){
        if($request->session()->has('admin_user') && $request->session()->has('admin_pass')){
            $request->session()->forget([
                'admin_user',
                'admin_pass',
                'name',
                'email'
            ]);
        }
        return redirect(config('app.admin_url'));
    }
}