<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['shop_id', 'slot_range', 'booking_period'];
}
