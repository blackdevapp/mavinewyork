<?php
/** use https://github.com/verot/class.upload.php to upload and resize images @by: @MAGIC 20191009 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
/** use below class to upload images @by: @MAGIC 20191010 */
use Verot\Upload\Upload;
use App\Http\Controllers\adminController as admin; // use this line to get menu
/** we use this in every controller and will help us to parse some data @by: @MAGIC 20190930 */
use App\Http\Controllers\staticController as statics;
/** below use will get fields to use into adminsystem project @by: @MAGIC 20191003 */
use App\Http\Controllers\fieldsController as fields;
/** load image model @by: @MAGIC 20190928 */
use App\Image as image;
use Validator; // validate requests check
use Illuminate\Validation\Rule;
use File;

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
                    /** search fields will use when search.value @by: @MAGIC 20191010 */
                    $search_fields = ['name', 'description'];
                    /** set order by raws @by: @MAGIC 20190929 */
                    $last_data = statics::set_data($request, image::class, $fields, $search_fields, $data, self::url());//$table_data, $fields_list, $fields_data, $fields_search, self::url());
                    break;
                default:
                    return [];
            }
        }
        return $last_data;
    }
    /** this function will create data for create and edit mode @by: @MAGIC 20190930*/
    public static function dataForm(Request $request, $table_data, $data, $ids, $type='create'){
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
                // add url for edit and delete data @by: @MAGIC 20190930
                // some bug fixed : remove 'create' from $type @by: @MAGIC 20191010
                $last_data = statics::set_form($request, $table_data, $fields_list, $fields_data, self::url(), $type);
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
        $enctype = 'enctype=multipart/form-data';
        /** this id (with cid name) is used in datatables @by: @MAGIC 20190928
         * please do not use . , because of class name conflicts */
        $cid = 'system-image';
        $cfield = self::dataForm($request, new \stdClass(), statics::field_render(fields::fields_image($request), 'create'), 'image', 'create');
        /** check if admin is login or not , then refer to current page */
        return view('admin.system.images.form')->with([
            'router' => $request->router,
            'menu' => $menu,
            'type' => 'create',
            'enctype' => $enctype,
            'cid' => $cid,
            // fields will process data for edit @by: @MAGIC 20190930
            'fields' => $cfield
        ]);
    }
    public function editImages(Request $request){
        // redirect if id not exists or not a number @by: @MAGIC 20191003
        if(@$request->id && is_numeric($request->id)){
            $id = (int)$request->id;
            $enctype = 'enctype=multipart/form-data';
            /** this variable will check if data exists @by: @MAGIC 20191003 */
            $filter_count = image::select('id')->where('id', $id)->count();
            if(!$filter_count) return redirect(self::url());
            $menu = admin::menu();
            /** this id (with cid name) is used in datatables @by: @MAGIC 20190928
             * please do not use . , because of class name conflicts */
            $table_data = image::where('id', $id)->first();
            $cid = 'system-image';
            $cfield = self::dataForm($request, $table_data, statics::field_render(fields::fields_image($request), 'edit'), 'image', 'edit');
            /** check if admin is login or not , then refer to current page */
            return view('admin.system.images.form')->with([
                'router' => $request->router,
                'menu' => $menu,
                'type' => 'edit/'.$request->id,
                'enctype' => $enctype,
                'cid' => $cid,
                // fields will process data for edit @by: @MAGIC 20190930
                'fields' => $cfield
            ]);
        } else {
            return redirect(self::url());
        }
    }
    public function createImagesPost(Request $request){
        $validator = Validator::make($request->all(), []);
        $validator = Validator::make($request->all(), [
            'Name' => [
                'required',
                'min:3',
                'max:50',
                'regex:/^[a-zA-Z0-9._\- ]{3,50}$/',
                /** unique will get image table and check name field
                 * and then ignore if id is not current $id @by: @MAGIC 20191010 */
                Rule::unique('image', 'name'),
            ],
            'Description' => 'nullable|min:5|max:100',
            'Active' => 'required|regex:/^[0-1]{1,1}$/',
            'Image' => 'required|max:2048',
        ]);
        if(!count($validator->getMessageBag()->all())){
            if ($request->hasFile('Image')) {
                /** it will create 2 image , one for static and original size and
                 * one for thumbnail and resized current image @by: @MAGIC 20191010*/
                $ext = config('app.file_ext')($request->file('Image'));
                $handle = new Upload($request->file('Image'));
                $handle_resize = new Upload($request->file('Image'));
                // create random image name here @by: @MAGIC 20191010
                $name = config('app.hash')(false, 'image');
                $handle->allowed = array('image/*');
                
                $handle->file_new_name_body          = $name; // rename image
                $handle->file_new_name_ext           = $ext;
                $handle_resize->file_new_name_body   = $name; // rename thumbnail image
                $handle_resize->file_new_name_ext    = $ext;
                $handle_resize->image_resize         = true;
                $handle_resize->image_x              = 150;
                $handle_resize->image_ratio_y        = true;
                
                $handle->process(config('app.upload_path'));
                if(!$handle->processed){
                    $validator->getMessageBag()->add('', trans('validation.noextimage'));
                    $handle->clean();
                } else {
                    $handle_resize->process(config('app.th_upload_path'));
                    if ($handle->processed && $handle_resize->processed) {
                        $handle->clean();
                        $handle_resize->clean();
                    }
                }
            } else {
                $validator->getMessageBag()->add('', trans('validation.noimage'));
            }
        }
        /** check if count of all messages exists ,
         * becasue if not use that , the $validator->fails() run and
         * will empty message box @by: @MAGIC 20191010 */
        if(!count($validator->getMessageBag()->all())){
            $insert_data = [
                'name'        => $request->Name,
                'image'       => $name.'.'.$ext,
                'description' => $request->Description,
                'is_active'   => $request->Active
            ];
            image::insert($insert_data);
            return redirect(self::url());
        } else {
            return $this->createImages($request)->withErrors($validator);
        }
    }
    public function editImagesPut(Request $request){
        $id = $request->id;
        $image_is_changed = false; // this variable will check if image is changed
        $validator = Validator::make($request->all(), []);
        $validator = Validator::make($request->all(), [
            'Name' => [
                'required',
                'min:3',
                'max:50',
                'regex:/^[a-zA-Z0-9._\- ]{3,50}$/',
                /** unique will get image table and check name field
                 * and then ignore if id is not current $id @by: @MAGIC 20191010 */
                Rule::unique('image', 'name')->ignore($id),
            ],
            'Description' => 'nullable|min:5|max:100',
            'Active' => 'required|regex:/^[0-1]{1,1}$/',
            'Image' => 'required|max:2048',
        ]);
        /** add upload image @by: @MAIGC 20191010 */
        if(!count($validator->getMessageBag()->all())){
            if ($request->hasFile('Image')) {
                /** it will create 2 image , one for static and original size and 
                 * one for thumbnail and resized current image @by: @MAGIC 20191010*/
                $ext = config('app.file_ext')($request->file('Image'));
                $handle = new Upload($request->file('Image'));
                $handle_resize = new Upload($request->file('Image'));
                // create random image name here @by: @MAGIC 20191010
                $name = config('app.hash')(false, 'image');
                $handle->allowed = array('image/*');
                
                
                $handle->file_new_name_body          = $name; // rename image
                $handle->file_new_name_ext           = $ext;
                $handle_resize->file_new_name_body   = $name; // rename thumbnail image
                $handle_resize->file_new_name_ext    = $ext;
                $handle_resize->image_resize         = true;
                $handle_resize->image_x              = 150;
                $handle_resize->image_ratio_y        = true;
                
                $handle->process(config('app.upload_path'));
                if(!$handle->processed){
                    $validator->getMessageBag()->add('', trans('validation.noextimage'));
                    $handle->clean();
                } else {
                    $handle_resize->process(config('app.th_upload_path'));
                    if ($handle->processed && $handle_resize->processed) {
                        $handle->clean();
                        $handle_resize->clean();
                    }
                    /** remove current image and set new image @by: @MAGIC 20191010 */
                    $req = image::select('image')->where('id', $id)->first();
                    if($req->image!=''){
                        if(File::exists(config('app.upload_path').$req->image)){
                            File::delete(config('app.upload_path').$req->image);
                            File::delete(config('app.th_upload_path').$req->image);
                        }
                    }
                    $image_is_changed = true;
                }
            } else {
                //$validator->getMessageBag()->add('', trans('validation.noimage'));
            }
        }
        /** check if count of all messages exists ,
         * becasue if not use that , the $validator->fails() run and
         * will empty message box @by: @MAGIC 20191010 */
        if(!count($validator->getMessageBag()->all())){
            $update_data = [
                'name'        => $request->Name,
                'description' => $request->Description,
                'is_active'   => $request->Active
            ];
            if($image_is_changed){
                /** change image name with new name and ext @by: @MAGIC 20191010 */
                $update_data['image'] = $name.'.'.$ext;
            }
            image::where('id', $id)->update($update_data);
            return redirect(self::url());
        } else {
            /** add with errors to check if any error occured @by: @MAGIC 20191010 */
            return $this->editImages($request)->withErrors($validator);
        }
    }
    public function deleteImages(Request $request){
        $id = $request->id;
        image::where('id', $id)->delete();
        return redirect(self::url());
    }
}
