<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login',function (){

});

Route::group(['middleware' => 'auth:api'],function (){
    Route::apiResource('posts',\App\Http\Controllers\PostController::class);
    Route::apiResource('banners',\App\Http\Controllers\BannerController::class);
});

Route::get('user/{id}/activity',[\App\Http\Controllers\TestController::class,'getUserActivity']);
Route::post('op',function (Request $request){
    $op = new \App\DataTransferObjects\OptometryDTO($request->odOptometry['od'],'od');
    dd($op);
});

Route::post('file-upload',function (Request $request){
    $originalName = $request->file->getClientOriginalName();
    $path = "dev/table/ssssssss".$originalName;

    Storage::disk('local')->put($path, file_get_contents($request->file('file')[0]));
//    $uploaddir = base_path('/public/test/');
//    $uploadfile = $uploaddir .$request->modified."_". basename($_FILES['file']['name']);
//
//;
//    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
//        echo "File is valid, and was successfully uploaded.\n";
//    } else {
//        echo "Possible file upload attack!\n";
//    }

//     return response()->json([
//             'created time' =>  \Carbon\Carbon::createFromTimestamp(filectime($request->file('file')),'ASIA/TEHRAN')->format('Y-m-d H:i:s'),
//             'modified time' =>  \Carbon\Carbon::createFromTimestamp(filemtime($request->file('file')),'ASIA/TEHRAN')->format('Y-m-d H:i:s')
//         ]
//     );
});

Route::get('dox',function (){

//    $file = file_get_contents('4/CHAMBER-LOAD.CSV');
    $file = file_get_contents('4/PACHY-LOAD.CSV');
//    $file = file_get_contents('4/SUMMARY-LOAD.CSV');
//    $file = file_get_contents('4/INDEX-LOAD.CSV');
//    return response()->download('4/CHAMBER-LOAD.CSV', null, [], null);
    $lines = explode(PHP_EOL,$file);
    $keys = $lines[0];
    $keys = str_replace(' ','',$keys);
    $keys = explode(';',$keys);
    $records = [];
    $data[] = [];
    $eye_types = [
       'Right' => 'od',
       'Left' => 'os'
    ];
    for($i=1;$i<sizeof($lines) - 1;$i++)
    {
        $records[$i] = [];
        $data[$i] = [];
        $lines[$i] = str_replace(' ','',$lines[$i]);

        $line = explode(';',$lines[$i]);
        dd($keys);
        for ($j = 0;$j < sizeof($keys);$j++)
        {
            if(is_numeric($line[$j]))
            {
                $data[$i]['prescription_id'] = $line[$j];
                $j = sizeof($keys);
            }
        }

        for ($n = 0;$n < sizeof($keys);$n++)
        {
            $records[$i][$keys[$n]] = $line[$n];
        }
          isset($eye_types[$records[$i]['ExamEye:']]) && $data[$i]['eye_type'] = $eye_types[$records[$i]['ExamEye:']];
          isset($records[$i]['Rf:']) && $data[$i]['rf'] = $records[$i]['Rf:'];
//        $data[$i]['rs'] = $records[$i]['Rs:'];
//        $data[$i]['Axis_flat'] = $records[$i]['Axis(flat):'];
//        $data[$i]['PupilX'] = $records[$i]['PupilX:'];
//        $data[$i]['PupilY'] = $records[$i]['PupilY:'];
//        $data[$i]['pachy_min'] = $records[$i]['PachyMin:'];
//        $data[$i]['PachyMinX'] = $records[$i]['PachyMinX:'];
//        $data[$i]['PachyMinY'] = $records[$i]['PachyMinY:'];
    }
    dd($records);
//    dd($data);

});
