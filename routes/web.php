<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    $file = file_get_contents('test.csv');
    $lines = explode(PHP_EOL,$file);
    $keys = explode(';',$lines[0]);
    $patients = [];
    for($i = 1;$i < sizeof($lines);$i++)
    {
        $data = explode(';',$lines[$i]);
        $patients[$i] = [];
        //  echo $data[0].PHP_EOL;
        for($j = 0;$j< sizeof($keys);$j++)
        {
             $patients[$i][$keys[$j]] = $data[$j] ?? null;
        }
    }
    dd($patients);
});

Route::get('test',function(){

    $times = array(
        array(
            'from' => 8,
            'to' => 9
        ),
        array(
            'from' => 4,
            'to' => 6
        ),
        array(
            'from' => 1,
            'to' => 3
        ),
        array(
            'from' => 13,
            'to' => 21
        ),
    );


    $exceptionTimes = array(
        array(
            'from' => '2023-04-14 08:00:00',
            'to' => '2023-04-14 11:00:00',
            'isAvailable' => false
        ),
        array(
            'from' => '2023-04-13 13:00:00',
            'to' => '2023-04-14 09:00:00',
            'isAvailable' => true
        ),
        array(
            'from' => '2023-04-14 15:00:00',
            'to' => '2023-04-14 19:00:00',
            'isAvailable' => false
        ),
    );

    $current_dey = '2023-04-14 00:00:00';

    var_dump($times,$exceptionTimes);

         $increaserTimes = [];
         $decreaserTimes = [];


         foreach($exceptionTimes as $time)
         {
            $date = Carbon::createFromFormat('Y-m-d H:i:s',$current_dey);
            $from = Carbon::createFromFormat('Y-m-d H:i:s',$time['from']);
            $to = Carbon::createFromFormat('Y-m-d H:i:s',$time['to']);

            if($time['isAvailable'])
            {
                $increaserTimes[] = [
                    'from' => $from->gt($date) ? intval($from->format('H')) : 0,
                    'to' => $to->gt($date->addDay()) ? 24 : intval($to->format('H'))
                ];
            }
            else
            {
                $decreaserTimes[] = [
                    'from' => $from->gt($date) ? intval($from->format('H')) : 0,
                    'to' => $to->gt($date->addDay()) ? 24 : intval( $to->format('H'))
                ];
            }
         }

        //   $timesUnion = $this->union(array_merge($times,$increaserTimes));

    // تابع مقایسه‌ای برای مقایسه دو آبجکت بر اساس کلید 'from'
    function compareByFrom($a, $b) {
        return $a['from'] - $b['from'];
    }

    $times = array_merge($times,$increaserTimes);
    // استفاده از تابع usort برای مرتب‌سازی آرایه بر اساس تابع مقایسه‌ای
    usort($times, 'compareByFrom');

    // var_dump($times);
    function union($times)
    {
        if(sizeof($times) > 1)
        {
            if($times[1]['from'] <= $times[0]['to'])
            {
                if($times[1]['to'] > $times[0]['to'])
                  $times[0]['to'] = $times[1]['to'];
                unset($times[1]);
                $times = array_values($times);
                return union($times);
            }
            else
            {
                $temp[] = $times[0];
                unset($times[0]);
                $times = array_values($times);
                return array_merge($temp,union($times));
            }
        }
        else
        {
           return $times;
        }
    }


    var_dump($times);
    $times = union($times);
    var_dump($times);
    var_dump($decreaserTimes);

    $times_array = array_values($times);

    foreach ($decreaserTimes as $key => $decreaserTime) {
        foreach ($times_array as $key => $time) {
             if($time['from'] < $decreaserTime['to'] && $time['to'] > $decreaserTime['from'])
             {
                if($time['from'] > $decreaserTime['from'] && $time['to'] < $decreaserTime['to'])
                      unset($times[$key]);
                elseif($time['from'] < $decreaserTime['from'] && $time['to'] > $decreaserTime['to'])
                {
                     $temp_1 = [
                        'from' => $time['from'],
                        'to' => $decreaserTime['from']
                     ];

                     $temp_2 = [
                        'from' => $decreaserTime['to'],
                        'to' => $time['to']
                     ];
                     unset($times[$key]);
                     $times[] = $temp_1;
                     $times[] = $temp_2;
                }
                elseif($time['from'] < $decreaserTime['from'])
                {
                     $times[$key]['to'] = $decreaserTime['from'];
                }
                else
                {
                    $times[$key]['from'] = $decreaserTime['to'];
                }

             }
        }
    }

    echo "********************";

    var_dump($times);

});
