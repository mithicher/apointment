<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $salonServices = [
            'Mens Haircut',
            'Ladies Haircut',
            'Shave',
            'Nail Art',
            'Hair Color'
        ];

        // foreach (range(1, 5) as $index) {
        //     $service = new Service;
        //     $service->user_id = 1;
        //     $service->service_name = $faker->unique()->randomElement($salonServices);
        //     $service->service_duration = "15 min";
        //     $service->service_price = $faker->unique()->randomElement([100, 200, 250, 300, 500]);
        //     $service->save();
        // }

        foreach (range(1, 5) as $index) {
            $service = new Service;
            $service->shop_id = 1;
            $service->service_name = $faker->unique()->randomElement($salonServices);
            $service->service_duration = "15 min";
            $service->service_price = $faker->unique()->randomElement([100, 200, 250, 300, 500]);
            $service->save();
        }
    }
}
