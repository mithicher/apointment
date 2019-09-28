<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'phone',
        'user_deactivated',
        'user_isconfirmed'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // public function services()
    // {
    //     return $this->hasMany('App\Service');
    // }

    public function appointments()
    {
        return $this->hasMany('App\Appoinment', 'client_id');
    }

    public function personalappointments()
    {
        return $this->hasMany('App\Appoinment');
    }
    
    public function shops()
    {
        return $this->hasMany('App\Shop');
    }
}
