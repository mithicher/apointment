<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $user = User::create([
            'name' => 'John Doe',
            'email' => 'owner@test.test',
            'phone' => '7086051060',
            'password' => bcrypt('pass123'),
            'user_type' => 1
        ]);
        
        $user->shops()->create([
            'shop_name' => 'ABC Saloon',
            'shop_address' => $faker->streetAddress(),
            'shop_phone' => '7086051060',
            'shop_logo' => $faker->imageUrl($width = 100, $height = 100),
            'shop_image' => $faker->imageUrl($width = 300, $height = 200)
        ]);

        // User::create([
        //     'name' => 'Summer Doe',
        //     'email' => 'summer@test.test',
        //     'password' => bcrypt('pass123'),
        //     'phone' => '7086051060',
        //     'user_type' => 2
        // ]);
    }
}
