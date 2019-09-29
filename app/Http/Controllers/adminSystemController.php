<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\adminController as admin; // use this line to get menu
/** load image model @by: @MAGIC 20190928 */
use App\Image as image;

class adminSystemController extends Controller
{
    /** this variable will create all fields needed in module @by: @MAGIC 20190928 */
    private static $fields_image = [
        [
            'id' => 'id',
            'name' => 'ID',
        ],
        [
            'id' => 'name',
            'name' => 'Name',
        ],
        [
            'id' => 'description',
            'name' => 'Description',
        ],
        [
            'id' => 'image',
            'name' => 'Image',
        ],
        [
            'id' => 'is_active',
            'name' => 'Active',
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
                    foreach($fields as $field){
                        $fields_list[] = $field['id'];
                    }
                    $table_data = image::select($fields_list)->get();
                    $i = 0;
                    foreach($table_data as $table){
                        $last_data[$i] = [];
                        foreach($fields_list as $field){
                            $last_data[$i][$field] = $table->$field;
                        }
                        $i++;
                    }
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
