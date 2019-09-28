<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'client_id',
        'walkin_name',
        'walkin_contact',
        'appointment_created',
        'start_time',
        'end_time',
        'price_expected',
        'price_full',
        'discount',
        'price_final',
        'canceled',
        'cancellation_reason'
    ];

    protected $dates = [
        'appointment_created'
    ];

    public function getAppointmentCreatedAttribute($value)
    {
        return (new Carbon($value))->format('Y-m-d');
    }
    

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function client()
    {
        return $this->belongsTo('App\User');
    }
}
