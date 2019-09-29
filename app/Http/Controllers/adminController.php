<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminUsers as AdminUsers;
use App\AdminMenu as AdminMenu;
/** navigation controller will navigate cid from current controller @by: @MAGIC 20190928 */
use App\Http\Controllers\DataTableNavigationController as Navigation;
use Validator;

class adminController extends Controller
{
    /** this function use in this class and will get and sort menus to use into admin pages @by: @MAGIC 20190926 */
    public static function menu(){
        $data = AdminMenu::where([
            ['is_active', 1]
        ])->get();
        foreach($data as $i => $d){
            // change first character to uppercase @by: @MAGIC 20190926
            $d->name = ucfirst($d->name);
            // add admin_url to all menu links @by: @MAGIC 20190926
            $d->link = config('app.admin_url').$d->link;
        }
        return $data;
    }
    public function home(Request $request){
        /** check if admin is login or not , then refer to current page */
        return view('admin.home')->with(['router' => $request->router, 'menu' => $this->menu()]);
    }
    public function showLogin(Request $request){
        /** check if session exists and return to home page @by: @MAGIC 20190926 */
        $validator = Validator::make($request->all(), []);
        if($request->session()->has('admin_user') && $request->session()->has('admin_pass')){
            return redirect($request->current_route[0]);
        }
        if($request->has('username')){
            /** add a validator where username exists @by: @MAGIC 20190926 */
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:3|max:50|regex:/^[a-zA-Z0-9._-]{3,50}$/',
                'password' => 'required|min:5|max:50'
            ]);
            if(!$validator->fails()){
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
        }
        return view('admin.login')->with(['router' => $request->router])->withErrors($validator);
    }
    /** get all tables data @by: @MAGIC 20190928 */
    public function getTable(Request $request){
        $validator = Validator::make($request->all(), [
            'start' => 'required|min:1|max:20|regex:/^[0-9]{1,20}$/',
            'length' => 'required|min:1|max:20|regex:/^[0-9]{1,20}$/',
            'search.value' => 'nullable|min:3|max:50|regex:/^[a-zA-Z0-9 ]{3,50}$/',
            'draw' => 'required|min:1|max:20|regex:/^[0-9]{1,20}$/',
            'cid' => 'required|min:3|max:50|regex:/^[a-zA-Z0-9_-]{3,50}$/',
        ]);
        //$validator->errors()
        $draw = $request->draw;
        if($validator->fails()){
            return json_encode([
                'draw' => (int)$draw,
                'recordsFiltered' => 0,
                'recordsTotal' => 0,
                'data' => [],
            ]);
        }
        /** find orders and send them to navigate controller to use with current controller @by: @MAGIC 20190928 */
        $orders = [];
        /** check order variables by regex @by: @MAGIC 20190928 */
        if($request->order){
            $order_check = '/^[0-9]{1,3}$/m';
            $dir_check = '/^(asc|desc)$/m';
            foreach($request->order as $order){
                if(preg_match_all($order_check, $order['column'], $matches, PREG_SET_ORDER, 0) && 
                    preg_match_all($dir_check, $order['dir'], $matches, PREG_SET_ORDER, 0)){
                    $orders[] = [
                        'column' => $order['column'],
                        'dir'    => $order['dir']
                    ];
                }
            }
        }
        $data = [
            'from'   => $request->start,
            'to'     => $request->length,
            'search' => $request->search['value'],
            'cid'    => $request->cid,
            'orders' => $orders,
            'draw'   => $request->draw
        ];
        /** we should navigate data from current module (cid) here @by: @MAGIC 20190928 */
        return json_encode(Navigation::init($request, $data));
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