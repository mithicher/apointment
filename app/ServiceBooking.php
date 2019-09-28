<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['appointment_id', 'service_id', 'price'];

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function appointment()
    {
        return $this->belongsTo('App\Appoinment');
    }
}
