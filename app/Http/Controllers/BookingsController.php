<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\Appointment;
use Carbon\Carbon;
use App\AppointmentSetting;
use App\BusinessHour;
use App\Enums\WeekName;

class BookingsController extends Controller
{
    public function index()
    {
        // $bookings = Appointment::latest()->get()->groupBy(\DB::raw('DATE(appointment_created)'));
        $collection = collect(Appointment::with('user.shops')->latest()->get());
        $bookings = $collection->sortByDesc('appointment_created')->groupBy('appointment_created');

        // Calendar Formatted datas
        $bookingDates = $bookings->map(function ($items, $key) {
            return [
                'date' => (int) date('d', strtotime($key)),
                'month' => (int) date('n', strtotime($key)) - 1,
                'year' => (int) date('Y', strtotime($key)),
                'details' => $items->map(function ($item, $key2) {
                    return [
                        'shop_name' => $item->user->shops[0]->shop_name,
                        'shop_address' => $item->user->shops[0]->shop_address,
                        'shop_phone' => $item->user->shops[0]->shop_phone,
                        'time' => $item->start_time,
                        'status' => $item->status
                    ];
                })
            ];
        })->values();

        return view('bookings.index', compact('bookings', 'bookingDates'));
    }
    
    public function create(Request $request, Shop $shop)
    {
        return view('bookings.create', compact('shop'));
    }

    public function store(Request $request, Shop $shop)
    {
        // get the shop owners user
        $shopUserId = $shop->user->id;

        $appointment = Appointment::create([
            'user_id' => 1,
            'client_id' => $shopUserId,
            'appointment_created' => now(),
            'start_time' => $request->input('time'),
            'price_expected' => 100
        ]);

        session()->flash('success', 'Appointment request submitted!');

        if ($request->expectsJson()) {
            return response([
                'status' => 'success',
                'message' => 'Appointment request submitted!',
                'data' => $appointment
            ], 201);
        }
    }

    public function show(Appointment $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    public function timeslots(Request $request, Shop $shop)
    {
        // From Appointment Settings Get Slot Range of Shop
        $appointmentSettings = AppointmentSetting::where('shop_id', $shop->id)
            ->select('slot_range', 'booking_period')
            ->first();

        $slot = $appointmentSettings->slot_range * 60;

        // Get Booking Period
        $bookingPeriods = $appointmentSettings->booking_period;

        date_default_timezone_set("Asia/Kolkata");

        for ($i = 0; $i < $bookingPeriods; $i++) {
            // Get Current day of Week
            $dayName = Carbon::today()->addDay($i)->format('l');
            $dayNameInNumber = WeekName::getValue($dayName);

            $formattedDisplayDate = Carbon::today()->addDay($i)->format('l, jS F');
            $formattedDate = Carbon::today()->addDay($i)->toDateString();

            // Get Business Hours of Shop
            $businessHour = BusinessHour::where('shop_id', $shop->id)
                ->where('day_of_week', $dayNameInNumber)
                ->first();
            
            if ($businessHour->status == 'closed') {
                $range[] = [
                    'range' => "00:00",
                    'date_display' => $formattedDisplayDate,
                    'date' => $formattedDate,
                    'status' => 'closed'
                ];
            } else {
                $range[] = [
                    'range' => range(strtotime($businessHour->open_time), strtotime($businessHour->close_time), $slot),
                    'date_display' => $formattedDisplayDate,
                    'date' => $formattedDate,
                    'status' => 'available'
                ];
            }
        }

        $dateRange = [];
        foreach ($range as $time) {
            if (is_array($time['range'])) {
                foreach ($time['range'] as $t) {
                    $appointmentFound = Appointment::whereDate('appointment_created', $time['date'])
                        ->where('start_time', date("H:i:s", $t))
                        ->first();
                    
                    $statusText = $appointmentFound ? 'booked' : 'available';

                    $dateRange[] = [
                        'time' => date("H:i", $t),
                        'date' => $time['date_display'],
                        'status' => $statusText
                    ];
                }
            } else {
                $dateRange[] = [
                    'time' => $time['range'],
                    'date' => $time['date_display'],
                    'status' => $time['status']
                ];
            }
        }

        return collect($dateRange)->groupBy('date');
        // return $collected->toJson();
    }
}
