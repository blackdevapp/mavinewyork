<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\adminController as admin; // use this line to get menu
use App\Http\Controllers\DataTableNavigationController as NavigateControl;
/** we use this in every controller and will help us to parse some data @by: @MAGIC 20190930 */
use App\Http\Controllers\staticController as statics;
/** below use will get fields to use into adminsystem project @by: @MAGIC 20191003 */
use App\Http\Controllers\fieldsController as fields;
/** load image model @by: @MAGIC 20190928 */
use App\Image as image;

class adminSystemController extends Controller
{
    // add url for edit and delete data @by: @MAGIC 20190930
    private static function url(){ 
        return config('app.admin_url').'/system/images/';
    }
    /** it will exists in every admin controller and create data for tables @by: @MAGIC 20190928 */
    public static function dataTable(Request $request, $data, $ids){
        $last_data = [];
        if($ids[1]){
            switch($ids[1]){
                case 'image':
                    $fields = statics::field_render(fields::fields_image($request));
                    $fields_list = [];
                    $fields_data = []; // this variable will send field data to init_data controller @by: @MAGIC 20190929
                    /** set order by raws @by: @MAGIC 20190929 */
                    $orders = $data['orders'];
                    $order_by = [];
                    $has_order = false; // check if any order exists
                    foreach($orders as $order){
                        $order_field = $fields[$order['column']]['id'];
                        $order_by[] = $order_field.' '.$order['dir'];
                        $has_order = true;
                    }
                    // implode to convert array to string like name desc, order asc
                    $orderby = implode(',', $order_by);
                    foreach($fields as $field){
                        $fields_list[] = $field['id'];
                        $fields_data[] = $field;
                    }
                    $count = image::select('id')->count();
                    if($has_order){
                        $filter_count = image::select('id')->orderByRaw($orderby)->count();
                        $table_data = image::select($fields_list)->orderByRaw($orderby)->get();
                    } else {
                        $filter_count = image::select('id')->count();
                        $table_data = image::select($fields_list)->get();
                    }
                    $last_data = statics::set_data($request, $table_data, $fields_list, $fields_data, self::url(), $filter_count, $count);
                    break;
                default:
                    return [];
            }
        }
        return $last_data;
    }
    /** this function will create data for create and edit mode @by: @MAGIC 20190930*/
    public static function dataForm(Request $request, $data, $ids, $type='create'){
        $last_data = [];
        switch($ids){
            case 'image':
                $fields = $data;
                $fields_list = [];
                $fields_data = []; // this variable will send field data to init_data controller @by: @MAGIC 20190929
                foreach($fields as $field){
                    $fields_list[] = $field['id'];
                    $fields_data[] = $field;
                }
                $table_data = $type=='create' ? new \stdClass() : new \stdClass();
                // add url for edit and delete data @by: @MAGIC 20190930
                $last_data = statics::set_form($request, $table_data, $fields_list, $fields_data, self::url(), $type='create');
                break;
            default:
                return [];
        }
        return $last_data;
    }
    public function showImages(Request $request){
        $menu = admin::menu();
        /** this id (with cid name) is used in datatables @by: @MAGIC 20190928 
         * please do not use . , because of class name conflicts */
        $cid = 'system-image';
        $cfield = statics::field_render(fields::fields_image($request));
        /** check if admin is login or not , then refer to current page */
        return view('admin.system.images.home')->with([
            'router' => $request->router, 
            'menu' => $menu, 
            'cid' => $cid,
            'cfield' => $cfield
        ]);
    }
    public function createImages(Request $request){
        $menu = admin::menu();
        /** this id (with cid name) is used in datatables @by: @MAGIC 20190928
         * please do not use . , because of class name conflicts */
        $cid = 'system-image';
        $cfield = self::dataForm($request, statics::field_render(fields::fields_image($request), 'create'), 'image', 'create');
        /** check if admin is login or not , then refer to current page */
        return view('admin.system.images.form')->with([
            'router' => $request->router,
            'menu' => $menu,
            'cid' => $cid,
            // fields will process data for edit @by: @MAGIC 20190930
            'fields' => $cfield
        ]);
    }
    public function editImages(Reuqest $request){
        $menu = admin::menu();
        /** this id (with cid name) is used in datatables @by: @MAGIC 20190928
         * please do not use . , because of class name conflicts */
        $cid = 'system-image';
        $cfield = self::dataForm($request, statics::field_render(fields::fields_image($request), 'edit'), 'image', 'edit');
        /** check if admin is login or not , then refer to current page */
        return view('admin.system.images.form')->with([
            'router' => $request->router,
            'menu' => $menu,
            'cid' => $cid,
            // fields will process data for edit @by: @MAGIC 20190930
            'fields' => $cfield
        ]);
    }
    public function deleteImages(Reuqest $request){
        
    }
}
