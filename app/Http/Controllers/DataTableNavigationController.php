<?php
/**
 * this controller will process data with key of (cid) , to current controller and get data back from the controller
 * to send to client and show that in tables @by: @MAGIC 20190928 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\adminSystemController as system;
use App\Http\Controllers\fieldsViewGetController as fieldsViewGet; // set fields view get

class DataTableNavigationController extends Controller
{
    public static function init(Request $request, $data){
        $ids = explode('-', $data['cid']);
        $last_data = [];
        switch($ids[0]){
            case 'system':
                $last_data = system::dataTable($request, $data, $ids);
                break;
            default:
                $last_data = [[], 0, 0];
        }
        return [
            'draw' => (int)$data['draw'],
            'recordsFiltered' => $last_data[1],
            'recordsTotal' => $last_data[2],
            'data' => $last_data[0],
        ];
    }
    public static function set_data(Request $request, $table_data, $fields_list, $fields_data, $filtered_count=0, $count=0){
        $i = 0;
        foreach($table_data as $table){
            $last_data[$i] = [];
            foreach($fields_list as $fid => $field){
                $table->$field = fieldsViewGet::init_data($fields_data[$fid], $table->$field);
                $last_data[$i][$field] = $table->$field;
            }
            /** add settings table here @by: @MAGIC 20190929 */
            $last_data[$i]['settings'] = fieldsViewGet::init_data(['type' => 'settings'], '');
            $i++;
        }
        return [$last_data, $filtered_count, $count];
    }
}