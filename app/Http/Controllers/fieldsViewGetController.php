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
                if($data!==''){
                $final_data = '
                    <a href="'.config('app.v_upload_path').$data.'" target="_blank">
                        <img src="'.config('app.v_th_upload_path').$data.'" />
                    </a>';
                }
                break;
            case 'boolean':
                $final_data = $data;
                break;
            case 'settings':
                $final_data = '
                    <a class="transparent-color" href="'.$field['data'].'edit/'.$data.'">
                        <button class="btn btn-circle btn-info" data-id="'.$data.'"><i class="fas fa-edit"></i></button>
                    </a>
                    <a class="transparent-color href="#" data-toggle="modal" data-target="#delete_modal" data-title="'.$data.'" data-url="'.$field['data'].'delete/'.$data.'">
                        <button class="btn btn-circle btn-danger delete-button"><i class="fas fa-trash"></i></button>
                    </a>
                ';
                break;
            default:
                $final_data = $data;
        }
        //<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_modal">
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
    /** this will init form for edit and create @by: @MAGIC 20190930 */
    public static function init_form($field, $data, $type='create'){
        $final_data = '';
        // set default from fieldsviewget @by: @MAGIC 20191003
        $default = (@$field['default']) ? $field['default'] : '';
        /** check if data is not empty and default is exists @by: @MAGIC 20191003*/
        $data = ($data=='' && $type!='edit' && $default!='') ? $default : $data;
        switch($field['type']){
            case 'integer':
                $final_data = '<input name="'.$field['name'].'" class="form-control" type="number" value="'.$data.'" />';
                break;
            case 'string':
                $final_data = '<input name="'.$field['name'].'" class="form-control" type="text" value="'.$data.'" />';
                break;
            case 'image':
                $final_data = $type=='create' ? 
                '<input name="'.$field['name'].'" class="form-control" type="file" value="'.$data.'" />' :
                '<br /><img src="'.config('app.v_th_upload_path').$data.'" /><br /><br /><input name="'.$field['name'].'" class="form-control" type="file" value="'.$data.'" />';
                break;
            case 'boolean':
                $final_data = '<input name="'.$field['name'].'" class="form-control" type="number" value="'.$data.'" />';
                break;
            case 'char':
                $final_data = '<textarea class="form-control" name="'.$field['name'].'">'.$data.'</textarea>';
                break;
            default:
                $final_data = $data;
        }
        if(@$field['widget']) {
            switch($field['widget']){
                case 'selection':
                    $final_data = '<select name="'.$field['name'].'" class="form-control">';
                    foreach($field['data'] as $fdata_id => $fdata){
                        $final_data .= ($data==$fdata_id) ? '<option value="'.$fdata_id.'" selected>'.$fdata.'</option>' : '<option value="'.$fdata_id.'">'.$fdata.'</option>';
                    }
                    $final_data .= '</select>';
                    break;
                default:
                    // nothing
            }
        }
        if(@$field['hide']) {
            $final_data = '<input name="" type="hidden" value="'.$data.'" />';
        }
        return $final_data;
    }
}