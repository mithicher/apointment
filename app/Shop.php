<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'shop_name',
        'shop_address',
        'shop_phone',
        'shop_logo',
        'shop_image'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function services()
    {
        return $this->hasMany('App\Service');
    }

    public function appointmentsetting()
    {
        return $this->hasOne('App\AppointmentSetting');
    }

    public function appointments()
    {
        return $this->hasMany('App\Appointment', 'client_id');
    }
}
