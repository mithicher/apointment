<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\User;
use App\AppointmentSetting;
use App\Shop;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // @TODO remove this and add nice logic
        User::creating(function ($user) {
            $user->email_verified_at = now();
            $user->user_type = 1;
        });

        Shop::created(function ($shop) {
            $shop->appointmentsetting()->create([
                'slot_range' => 20,
                'booking_period' => 7
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
