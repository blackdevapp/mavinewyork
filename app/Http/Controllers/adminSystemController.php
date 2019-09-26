<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\adminController as admin; // use this line to get menu

class adminSystemController extends Controller
{
    public function showImages(Request $request){
        $menu = admin::menu();
        /** check if admin is login or not , then refer to current page */
        return view('admin.system.images.home')->with(['router' => $request->router, 'menu' => $menu]);
    }
}
