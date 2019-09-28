<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_id',
        'service_name',
        'service_slug',
        'service_code',
        'service_details',
        'service_duration',
        'service_price',
        'service_isactive'
    ];

    protected $casts = [
        'service_isactive' => 'Boolean'
    ];

    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }
}
