<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\fieldsViewGetController as fieldsViewGet; // set fields view get
// this controller will change some data and used in all of controllers @by: @MAGIC 20190930
class staticController extends Controller
{
    /** this function will set data to show in tables @by: @MAGIC 20190930 */
    public static function set_data(Request $request, $model, $fields, $search_fields, $data, $url){
        $fields_list = [];
        $fields_data = []; // this variable will send field data to init_data controller @by: @MAGIC 20190929
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
        $count = $model::select('id')->count();
        $table_data = $model::select($fields_list)->skip($data['from'])->take($data['to']);
        $filtered_count = $model::select('id');
        if($has_order){
            $filtered_count = $filtered_count->orderByRaw($orderby)->count();
            $table_data = $table_data->orderByRaw($orderby);
            if($data['search']!=''){
                foreach($search_fields as $search_key => $search_field){
                    if($search_key==0)
                        $table_data = $table_data->where($search_field, 'like', '%'.$data['search'].'%');
                    else
                        $table_data = $table_data->orWhere($search_field, 'like', '%'.$data['search'].'%');
                }
            }
        } else {
            $filtered_count = $filtered_count->count();
            if($data['search']!=''){
                foreach($search_fields as $search_key => $search_field){
                    if($search_key==0)
                        $table_data = $table_data->where($search_field, 'like', '%'.$data['search'].'%');
                        else
                            $table_data = $table_data->orWhere($search_field, 'like', '%'.$data['search'].'%');
                }
            }
        }
        $table_data = $table_data->get();
        $i = 0;
        foreach($table_data as $table){
            $last_data[$i] = [];
            foreach($fields_list as $fid => $field){
                $table->$field = fieldsViewGet::init_data($fields_data[$fid], $table->$field);
                $last_data[$i][$field] = $table->$field;
            }
            /** add settings table here @by: @MAGIC 20190929 */
            $last_data[$i]['settings'] = fieldsViewGet::init_data([
                'type' => 'settings',
                'data' => $url
            ], $table->id);
            $i++;
        }
        return [$last_data, $filtered_count, $count];
    }
    /** set form data @by: @MAGIC 20190930 */
    public static function set_form(Request $request, $table_data, $fields_list, $fields_data, $url, $type='create'){
        $last_data = [];
        foreach($fields_data as $table_id => $table){
            $field_name = $fields_list[$table_id];
            $field = fieldsViewGet::init_form($table, (count((array)$table_data)) ? $table_data->$field_name : '', $type);
            $last_data[$field_name] = ['name' => $table['name'], 'field' => $field, 'hide' => (@$table['hide']) ? true : false];
        }
        return $last_data;
    }
    /** this function will send active and not active icons and show to admin @by: @MAGIC 20190930 */
    /** it will check if type is view or create or edit and send current type to form @by: @MAGIC 20191003 */
    public static function active_field(Request $request, $type='view'){
        return ($type=='view') ? [
            0 => '<a href="'.config('app.admin_url').'/system/images/create" class="btn btn-danger btn-icon-split">
                      <span class="icon text-white-50">
                      <i class="fas fa-times"></i></span>
                  </a>',
            1 => '<a href="'.config('app.admin_url').'/system/images/create" class="btn btn-success btn-icon-split">
                      <span class="icon text-white-100">
                      <i class="fas fa-check"></i></span>
                  </a>'
        ] : [
            0 => trans($request->router.'not_active'),
            1 => trans($request->router.'active'),
        ];
    }
    public static function create(Request $request){
        
    }
    public static function edit(Request $request){
        $id = $request->id;
        echo $id;exit();
    }
    public static function delete(Request $request){
        
    }
    /** this function will render fields and return with show or hide fields @by: @MAGIC 20190930 */
    public static function field_render($fields, $type='view'){
        /** sometimes maybe we want a hidden field to have hidden type and should show in view mode
         * or maybe not , because of that , we will have two type of variables to render
         * in view mode and in create-edit mode @by: @MAGIC 20191003
         *  */
        $fields_after_render = []; // use in view mode
        $fields_for_create_edit = [];  // use in create-edit mode
        foreach($fields as $field){
            $is_hide = false;
            if(@$field['hide']){
                $is_hide = in_array($type, $field['hide']);
            }
            if(!$is_hide){
                $fields_after_render[] = $field;
                $fields_for_create_edit[] = $field;
            } else {
                $field['hide'] = true;
                $fields_for_create_edit[] = $field;
            }
        }
        return ($type=='view') ? $fields_after_render : $fields_for_create_edit;
    }
}
