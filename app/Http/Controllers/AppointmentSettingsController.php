<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppointmentSetting;

class AppointmentSettingsController extends Controller
{
    public function getAppointmentSettings($id)
    {
        $appointmentsetting = AppointmentSetting::where('shop_id', $id)->first();

        if (request()->expectsJson()) {
            return response(['data' => $appointmentsetting, 'status' => 'success'], 201);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'slot_range' => 'required',
            'booking_period' => 'required'
        ]);

        $appointmentsetting = AppointmentSetting::find($id);
        $appointmentsetting->fill($request->all());
        $appointmentsetting->save();

        if ($request->expectsJson()) {
            return response(['data' => $appointmentsetting, 'status' => 'success'], 201);
        }

        session()->flash('success', 'New shop created!');

        return back();
    }
}
