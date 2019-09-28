<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessHour extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['shop_id', 'day_of_week', 'status', 'open_time', 'close_time'];

    
    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }
}
