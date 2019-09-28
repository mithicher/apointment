<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\WeekName;
use App\BusinessHour;
use App\Shop;

class TestController extends Controller
{
    public function test()
    {
        $weekdays = WeekName::toSelectArray();
        
        return view('test', compact('weekdays'));
    }

    public function saveBusinessHours(Request $request)
    {
        // $shop = Shop::firstOrFail(1);

        $datas = json_decode($request->input('hours'));

        foreach ($datas as $data) {
            BusinessHour::updateOrCreate(
                [
                    'shop_id' => 1,
                    'day_of_week' => $data->dayOfWeek
                ],
                [
                'shop_id' => 1,
                'day_of_week' => $data->dayOfWeek,
                'status' => $data->status,
                'open_time' => $data->open_time->HH.':'.$data->open_time->mm.':00',
                'close_time' => $data->close_time->HH.':'.$data->close_time->mm.':00',
            ]
            );
        }
        
        return back();
    }

    public function businessHours()
    {
        $hours = BusinessHour::where('shop_id', 1)->get();

        $collected = collect($hours)->map(function ($hour) {
            $openTime = explode(":", $hour->open_time);
            $closeTime = explode(":", $hour->close_time);

            return [
                'day_of_week' => $hour->day_of_week,
                'status' => $hour->status,
                'open_time' => [
                    'HH' => $openTime[0],
                    'mm' => $openTime[1]
                ],
                'close_time' => [
                    'HH' => $closeTime[0],
                    'mm' => $closeTime[1]
                ]
            ];
        });

        return $collected->values()->all();
    }
}
