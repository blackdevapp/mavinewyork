<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

class adminController extends Controller
{
    public function index(){
        /** check if admin is login or not , then refer to current page */
        $data = [
            'router'=> $request->router
        ];
        return view('admin.home')->with(['data' => $data, 'router' => $request->router]);
    }
    public function showLogin(Request $request){
        if($request->has('username')){
            $username = $request->username;
            $password = $request->password;
            /** check validation of form here @by: @MAGIC 20190925 */
            $request->validate([
                'username' => 'required|min:5|max:50',
                'password' => 'required|min:6|max:50'
            ],[
                'required' => trans($request->router.'user_required', ['attr' => ':attribute']),
                'min' => trans($request->router.'user_min', [
                    'attr' => ':attribute',
                    'min' => ':min'
                ]),
                'max' => trans($request->router.'user_max', [
                    'attr' => ':attribute',
                    //'input' => ':input',
                    'max' => ':max'
                ]),
            ]);
        }
        $data = [
            'router'=> $request->router
        ];
        return view('admin.login')->with(['data' => $data, 'router' => $request->router]);
    }
}