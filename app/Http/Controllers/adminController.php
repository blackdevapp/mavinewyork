<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminController extends Controller
{
    public function index(){
        /** check if admin is login or not , then refer to current page */
        echo 'ss';
    }
    public function showLogin(){
        return view('admin.login');
    }
}
