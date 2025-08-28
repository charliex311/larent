<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Setting;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $user = User::create([
            'first_name'  => 'John',
            'last_name'  => 'Doe',
            'email' => 'info@fleckfrei.de',
            'phone' => '5615',
            'email_verified_at' => now(),
            'password' => bcrypt('Admin'), // password
            'remember_token' => Str::random(10),
        ]);

        if ($user) {
            Setting::create([
                'user_id' => $user->id,
                'currency' => '€'
            ]);
        }


    }
}
