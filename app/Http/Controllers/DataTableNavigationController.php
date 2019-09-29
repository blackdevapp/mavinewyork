<?php
/**
 * this controller will process data with key of (cid) , to current controller and get data back from the controller
 * to send to client and show that in tables @by: @MAGIC 20190928 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\adminSystemController as system;

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
                $last_data = [];
        }
        return [
            'draw' => (int)$data['draw'],
            'recordsFiltered' => 0,
            'recordsTotal' => 0,
            'data' => $last_data,
        ];
    }
}