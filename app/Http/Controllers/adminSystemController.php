<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\adminController as admin; // use this line to get menu
use App\Http\Controllers\DataTableNavigationController as NavigateControl;
/** load image model @by: @MAGIC 20190928 */
use App\Image as image;

class adminSystemController extends Controller
{
    /** this variable will create all fields needed in module @by: @MAGIC 20190928 */
    private static $fields_image = [
        [
            'id' => 'id',
            'name' => 'ID',
            'type' => 'integer',
        ],
        [
            'id' => 'name',
            'name' => 'Name',
            'type' => 'string',
        ],
        [
            'id' => 'description',
            'name' => 'Description',
            'type' => 'char',
        ],
        [
            'id' => 'image',
            'name' => 'Image',
            'type' => 'image',
        ],
        [
            'id' => 'is_active',
            'name' => 'Active',
            'type' => 'boolean',
            'widget' => 'selection',
            'data' => [
                0 => 'not active',
                1 => 'active'
            ]
        ]
    ];
    /** it will exists in every admin controller @by: @MAGIC 20190928 */
    public static function dataTable(Request $request, $data, $ids){
        $last_data = [];
        if($ids[1]){
            switch($ids[1]){
                case 'image':
                    $fields = self::$fields_image;
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
                    $last_data = NavigateControl::set_data($request, $table_data, $fields_list, $fields_data, $filter_count, $count);
                    break;
                default:
                    return [];
            }
        }
        return $last_data;
    }
    public function showImages(Request $request){
        $menu = admin::menu();
        /** this id (with cid name) is used in datatables @by: @MAGIC 20190928 
         * please do not use . , because of class name conflicts */
        $cid = 'system-image';
        $cfield = self::$fields_image;
        /** check if admin is login or not , then refer to current page */
        return view('admin.system.images.home')->with([
            'router' => $request->router, 
            'menu' => $menu, 
            'cid' => $cid,
            'cfield' => $cfield
        ]);
    }
}
