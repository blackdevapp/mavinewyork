<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** add name to all routes , to check where are they and seperate by dash (-) @by: @MAGIC 20190925 */
/** we use 'admin' or 'nonadmin' for the first name of the route @by: @MAGIC 20190925 */
/** we should use 'request.data' middleware for every request */
Route::get(config('app.admin_url'), 'adminController@home')->name('admin-home')->middleware('request.data','auth');

Route::get(config('app.admin_url').'/login', 'adminController@showLogin')->name('admin-login')->middleware('request.data','guest');
Route::post(config('app.admin_url').'/login', 'adminController@showLogin')->name('admin-login')->middleware('request.data','guest');

Route::get(config('app.admin_url').'/logout', 'adminController@logout')->name('admin-logout')->middleware('request.data','auth');

/** add modules here */
Route::get(config('app.admin_url').'/system/images', 'adminSystemController@showImages')
->name('admin-system')->middleware('request.data','auth');

Route::get(config('app.admin_url').'/system/images/create', 'adminSystemController@createImages')
->name('admin-system')->middleware('request.data','auth');
Route::post(config('app.admin_url').'/system/images/create', 'adminSystemController@createImagesPost')
->name('admin-system')->middleware('request.data','auth');

Route::get(config('app.admin_url').'/system/images/edit/{id}', 'adminSystemController@editImages')
->where('id','^[1-9]{1}[0-9]{0,9}$')->name('admin-system')->middleware('request.data','auth');
Route::put(config('app.admin_url').'/system/images/edit/{id}', 'adminSystemController@editImagesPut')
->where('id','^[1-9]{1}[0-9]{0,9}$')->name('admin-system')->middleware('request.data','auth');

Route::get(config('app.admin_url').'/system/images/delete/{id}', 'adminSystemController@deleteImages')
->where('id','^[1-9]{1}[0-9]{0,9}$')->name('admin-system')->middleware('request.data','auth');

Route::get('/test', function(){
    //arrow($img, 50, 20, 50, 200, 4, 4, $black);
    function arrow($im, $x1, $y1, $x2, $y2, $alength, $awidth, $color) {
        $distance = sqrt(pow($x1 - $x2, 2) + pow($y1 - $y2, 2));
        
        $dx = $x2 + ($x1 - $x2) * $alength / $distance;
        $dy = $y2 + ($y1 - $y2) * $alength / $distance;
        
        $dx1 = $x1 + ($x2 - $x1) * $alength / $distance;
        $dy1 = $y1 + ($y2 - $y1) * $alength / $distance;
        
        $k = $awidth / $alength;
        
        $x2o = $x2 - $dx;
        $x1o = $dx1 - $x1;
        $y2o = $dy - $y2;
        $y1o = $y1 - $dy1;
        $x3 = $y2o * $k + $dx;
        $y3 = $x2o * $k + $dy;
        $x13 = $y1o * $k + $dx1;
        $y13 = $x1o * $k + $dy1;
        
        $x4 = $dx - $y2o * $k;
        $y4 = $dy - $x2o * $k;
        
        $x14 = $dx1 - $y1o * $k;
        $y14 = $dy1 - $x1o * $k;
              
        imageline($im, $x1, $y1, $dx, $dy, $color);
        imagefilledpolygon($im, array($x2, $y2, $x3, $y3, $x4, $y4), 3, $color);
        imagefilledpolygon($im, array($x1, $y1, $x13, $y13, $x14, $y14), 3, $color);
    }
    //$img = imagecreatetruecolor(1200,600);
    $img = imagecreate(1200,600);
    $white = imagecolorallocate($img, 255, 255, 255);
    $black = imagecolorallocate($img, 0, 0, 0);
    //imagecolortransparent($img);
    imagecolorallocate($img, 255, 255, 255);
    $im     = imagecreatefromjpeg("resources/img/1.jpg"); // sit toilet
    $im2    = imagecreatefromjpeg("resources/img/2.jpg"); // wall
    $im3    = imagecreatefromjpeg("resources/img/3.jpg"); // door
    $im4    = imagecreatefromjpeg("resources/img/4.jpg"); // thin wall rounded
    $im5    = imagecreatefromjpeg("resources/img/5.jpg"); // stand toilet
    $im6    = imagecreatefromjpeg("resources/img/6.jpg"); // thin wall
    $im = imagescale($im, 80);
    
    $states = [
        1 => [
            'has_start_small_wall' => true, // this option said that start small wall exists
            'has_start_wall' => true,
            'has_end_small_wall' => true,
            'has_end_wall' => true,
            'large_start_depth' => true,
            'large_end_depth' => true,
            'large_start_height' => true,
            'large_end_height' => true,
            'small_wall_depth' => '78',
            'wall_depth' => '109', // 78 + 28 + 3 ( max : 109 inches )
            'stall_count' => 5,
            'screen_count' => 2,
            'stall_details' => [
                1 => [
                    'width' => '36',
                    'frac_width' => '1/4',
                    'door' => '24',
                    
                ]
            ]
        ],
        2 => [
            'has_start_wall' => true,
        ],
        3 => [
            'has_start_wall' => true,
        ],
        4 => [
            'has_start_wall' => true,
        ],
        5 => [
            'has_start_wall' => true,
        ],
        6 => [
            'has_start_wall' => true,
        ],
        7 => [
            'has_start_wall' => true,
        ],
        8 => [
            'has_start_wall' => true,
        ],
        9 => [
            'has_start_wall' => true,
        ],
        10 => [
            'has_start_wall' => true,
        ],
        11 => [
            'has_start_wall' => true,
        ],
        12 => [
            'has_start_wall' => true,
        ],
        13 => [
            'has_start_wall' => true,
        ],
        14 => [
            'has_start_wall' => true,
        ],
        15 => [
            'has_start_wall' => true,
        ],
        16 => [
            'has_start_wall' => true,
        ],
        17 => [
            'has_start_wall' => true,
        ],
        18 => [
            'has_start_wall' => true,
        ]
    ];
    
    $thin_wall_width = 10;
    $thin_wall_height = 77;
    
    $wall_width = 18;
    $wall_height = 300;

    
    // toilet - destination , source , start x , start y, start source x, start source y, width, quality
    imagecopymerge($img, $im, 100, 16, 0, 0, 80, 106, 100);
    
    //$im = imagerotate($im, 90, 0);
    //imagecopymerge($img, $im, 150, 150, 0, 0, 100, 150, 100);
    
    // wall
    $im2 = imagescale($im2, 300);
    
    imagecopymerge($img, $im2, 50, 0, 0, 0, $wall_height, $wall_width, 100);
    imagecopymerge($img, $im2, 350, 0, 0, 0, $wall_height, $wall_width, 100);
    imagecopymerge($img, $im2, 650, 0, 0, 0, $wall_height, $wall_width, 100);
    
    // wall
    $im2_r = imagerotate($im2, 270, 0);
    imagecopymerge($img, $im2_r, 33, 0, -1, 0, $wall_width, $wall_height, 100);
    
    // thin wall
    $im6 = imagescale($im6, 10);
    
    imagecopymerge($img, $im6, 220, 17, 0, 0, $thin_wall_width, $thin_wall_height-1, 100);
    imagecopymerge($img, $im6, 220, 93, 0, 1, $thin_wall_width, $thin_wall_height-1, 100); // 76 + 17 = 93 - 1 is remove the top line
    imagecopymerge($img, $im6, 220, 169, 0, 1, $thin_wall_width, $thin_wall_height, 100); // 76 + 93 = 169 - 1 is remove the top line , 18 will add bottom line
    
    // thin wall
    $im6_r = imagerotate($im6, 90, 0);
    imagecopymerge($img, $im6_r, 190, 236, 0, 0, 30, $thin_wall_width, 100); // 236 = 169 + 77 - 10
    imagecopymerge($img, $im6_r, 51, 236, 20, 0, 58, $thin_wall_width, 100); // 77 - (58-1) = 20 (will add line to end of image)
    
    // door
    $im3_f = imagescale($im3, 80);
    imageflip($im3_f, IMG_FLIP_HORIZONTAL);
    imagecopymerge($img, $im3_f, 110, 168, 0, 0, 80, 78, 100); // 236 - 68 = 168 (68 = 80 - 12(depth of wall))
    
    // arrows
    arrow($img, 50, 260, 230, 260, 4, 4, $black);
    // source , size , x1 , y1 , x2 , y2 , color , font name , text
    imagettftext($img, 9, 0, 130, 275, $black, 'C:/Users/Magic/Pictures/tahoma.ttf', '2.2"');
    arrow($img, 60, 18, 60, 235, 4, 4, $black);
    imagettftext($img, 9, 90, 75, 150, $black, 'C:/Users/Magic/Pictures/tahoma.ttf', '3.5"');
    
    //arrow($img, 150, 20, 300, 20, 4, 4, $black);
    
    //wall2
    imagecopymerge($img, $im2, 50, 350, 0, 0, $wall_height, $wall_width, 100);
    imagecopymerge($img, $im2, 350, 350, 0, 0, $wall_height, $wall_width, 100);
    imagecopymerge($img, $im2, 650, 350, 0, 0, $wall_height, $wall_width, 100);
    
    // thin wall
    $im4 = imagescale($im4, 10);
    imagecopymerge($img, $im4, 100, 367, 0, 0, 10, 75, 100); // last size is 80
    imagecopymerge($img, $im4, 100, 442, 0, 30, 10, 50, 100);
    
    // stand toilet
    $im5 = imagescale($im5, 80);
    $im5_f = $im5;
    imageflip($im5_f, IMG_FLIP_VERTICAL);
    imagecopymerge($img, $im5, 145, 368, 0, 0, 80, 87, 100);
    
    // thin wall
    $im4 = imagescale($im4, 10);
    imagecopymerge($img, $im4, 260, 367, 0, 0, 10, 75, 100); // last size is 80
    imagecopymerge($img, $im4, 260, 442, 0, 30, 10, 50, 100);
    
    // arrows
    arrow($img, 100, 500, 270, 500, 4, 4, $black);
    // source , size , x1 , y1 , x2 , y2 , color , font name , text
    imagettftext($img, 9, 0, 175, 520, $black, 'C:/Users/Magic/Pictures/tahoma.ttf', '2.2"');
    arrow($img, 90, 368, 90, 490, 4, 4, $black);
    imagettftext($img, 9, 90, 80, 430, $black, 'C:/Users/Magic/Pictures/tahoma.ttf', '3.5"');
    
    
    
    //imagettftext($img, 9, 0, 215, 35, $black, 'C:/Users/Magic/Pictures/tahoma.ttf', '2.2"');
    header("Content-type: image/png");
    imagepng($img);
    imagedestroy($img);
});

/** get table data , as ajax request */
Route::get(config('app.admin_url').'/get_tables', 'adminController@getTable')->name('admin-datatable')->middleware('request.data','auth');



Route::view('/{path?}', 'app');

/** redirect to home page , if page not exist @by: @MAGIC 20191011 */
Route::any('{query}',
function() { return redirect(config('app.admin_url')); })
->where('query', '.*');