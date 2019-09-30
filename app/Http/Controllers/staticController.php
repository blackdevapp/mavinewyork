<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// this controller will change some data and used in all of controllers @by: @MAGIC 20190930
class staticController extends Controller
{
    /** this function will set data to show in tables @by: @MAGIC 20190930 */
    public static function set_data(Request $request, $table_data, $fields_list, $fields_data, $url, $filtered_count=0, $count=0){
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
    public static function set_form(Request $request, $table_data, $fields_list, $fields_data){
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
    /** this function will send active and not active icons and show to admin @by: @MAGIC 20190930 */
    public static function active_field(){
        return [
            0 => '<a href="'.config('app.admin_url').'/system/images/create" class="btn btn-danger btn-icon-split">
                      <span class="icon text-white-50">
                      <i class="fas fa-times"></i></span>
                  </a>',
            1 => '<a href="'.config('app.admin_url').'/system/images/create" class="btn btn-success btn-icon-split">
                      <span class="icon text-white-100">
                      <i class="fas fa-check"></i></span>
                  </a>'
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
        $fields_after_render = [];
        foreach($fields as $field){
            $is_hide = false;
            if(@$field['hide']){
                foreach($field['hide'] as $hide){
                    $is_hide = $hide==$type ? true : false;
                }
            }
            if(!$is_hide){
                $fields_after_render[] = $field;
            }
        }
        return $fields_after_render;
    }
}
