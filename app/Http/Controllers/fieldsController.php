<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\staticController as statics;
/** this function will store all fields of tables here and call them to current controller @by: @MAGIC 20191003 */
class fieldsController extends Controller
{
    /** change private static variable to public static function fields_image to use in staticController @by: @MAGIC 20190930 */
    /**  this function will used in adminSystemController @by: @MAGIC 20191003*/
    public static function fields_image(Request $request){
        return [
            [
                'id' => 'id',
                'name' => 'ID',
                'validation' => 'nullable|min:1|max:10',
                'hide' => ['create', 'edit'],
                'type' => 'integer',
            ],
            [
                'id' => 'name',
                'name' => 'Name',
                'validation' => 'required|min:3|max:50',
                'type' => 'string',
                'required' => true,
            ],
            [
                'id' => 'description',
                'name' => 'Description',
                'validation' => 'nullable|min:3|max:500',
                'type' => 'char',
            ],
            [
                'id' => 'image',
                'name' => 'Image',
                'validation' => 'required',
                'type' => 'image',
                'default' => 'T',
                'required' => true,
            ],
            [
                'id' => 'is_active',
                'name' => 'Active',
                'validation' => 'required|regex:/^(0|1){1,1}$/',
                'type' => 'boolean',
                'widget' => 'selection',
                'data' => statics::active_field($request, 'no_view'),
                'default' => 1,
                'required' => true,
            ]
        ];
    }
}
