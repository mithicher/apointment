<?php

use Illuminate\Support\Facades\Route;

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

use Illuminate\Http\Request;

Route::get('/timeranges', function (Request $request) {
    // return view('welcome');
    // $slot = $request->get('slot') * 60;
    $slot = 15 * 60;

    date_default_timezone_set("Asia/Kolkata");
    $range = range(strtotime("10:00"), strtotime("17:00"), $slot);

    $dateRange = [];
    foreach ($range as $time) {
        $dateRange[] = date("H:i", $time);
    }

    $collected = collect($dateRange)->map(function ($item) {
        return [
            'date' => date('Y-m-d'),
            'time' => $item
        ];
    });

    return $collected->toJson();
});

Route::get('test', 'TestController@test');
Route::post('/hours', 'TestController@saveBusinessHours');
Route::get('/businesshours', 'TestController@businessHours');

Route::get('/', 'PageController@index');
Route::get('/appointments', 'BookingsController@index');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/services', 'ServicesController@index');
// Route::get('/shop/{shop}/details', 'ServicesController@index');

Route::resource('shops', 'ShopsController');
Route::get('/shops/{shop}/booking', 'BookingsController@create')->name('bookings.create');
Route::post('/shops/{shop}/booking', 'BookingsController@store')->name('bookings.store');
Route::get('/shops/{shop}/bookingslots', 'BookingsController@timeslots');

Route::get('/bookings/{booking}', 'BookingsController@show')->name('bookings.show');

// Route::resource('services', 'ServicesController');
Route::get('/shops/{shop}/appointment-settings', 'AppointmentSettingsController@getAppointmentSettings');
Route::put('/shops/{shop}/status', 'ShopsController@updateShopStatus');
Route::put('/appointmentsettings/{appointmentsetting}', 'AppointmentSettingsController@update');
Route::get('/shops/{shop}/services', 'ShopServicesController@index');
Route::post('/shops/{shop}/services', 'ShopServicesController@store');
Route::put('/shops/{shop}/services/{services}', 'ShopServicesController@update');

Route::get('/weekdays', function () {
    return \App\Enums\WeekName::toSelectArray();
});
Route::get('/appointmentstatuses', function () {
    return \App\Enums\AppointmentStatusType::toArray();
});

Route::get('/admin/{any}', 'AdminController@index')->where('any', '.*');
