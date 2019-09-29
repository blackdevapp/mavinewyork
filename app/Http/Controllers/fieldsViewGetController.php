<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class fieldsViewGetController extends Controller
{
    /** this controller will process fields and append them to variables @by: @MAGIC 20190929 */
    /** this function (init_data) will return data by type @by: @MAGIC 20190929 */
    public static function init_data($field, $data){
        $final_data = '';
        switch($field['type']){
            case 'integer':
                $final_data = (int)$data;
                break;
            case 'string':
                $final_data = $data;
                break;
            case 'image':
                $final_data = '<img src="'.$data.'" />';
                break;
            case 'boolean':
                $final_data = $data;
                break;
            case 'settings':
                $final_data = '<button>Edit</button> <button>Delete</button>';
                break;
            default:
                $final_data = $data;
        }
        if(@$field['widget']) {
            switch($field['widget']){
                case 'selection':
                    $final_data = $field['data'][$final_data];
                    break;
                default:
                    // nothing
            }
        }
        return $final_data;
    }
}