<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\Address;
use App\Models\Setting;
use App\Models\Optionalproduct;
use Illuminate\Support\Str;

class DemoContentSeeder extends Seeder
{
    
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // create some Customer user

        $types = [
            'host',
            'company',
            'private',
        ];

        for ($i=0; $i < 5; $i++) { 
            foreach($types as $type){
                $customer = User::create([
                    'first_name'  => $faker->firstName,
                    'last_name'  => $faker->lastName,
                    'email' => $faker->safeEmail,
                    'phone' => $faker->phoneNumber,
                    'customer_type' => $type,
                    'email_verified_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'remember_token' => Str::random(10),
                ]);
                if ($customer) {
                    $customer->assignRole('Customer');

                    Setting::create(['user_id' => $customer->id]);
    
                    for ($u=0; $u < 5; $u++) {
    
                        $price = $faker->numberBetween(50,500);
                        $tax = 5;
                        $percentage = 5/100;
                        $tax_value = $price * $percentage;
                        $total_price = $price + $tax_value;


                        // regularity

                        $regularity = ['regular', 'sunday'];
                        $randomIndexRegularity = array_rand($regularity);
                        $randomValueRegularity = $regularity[$randomIndexRegularity];

                        // speciality

                        $speciality = ['normal','special'];
                        $randomIndexSpeciality = array_rand($speciality);
                        $randomValueSpeciality = $speciality[$randomIndexSpeciality];
        
                        Service::create([
                            'title'  => $faker->company,
                            'unit' => 'flat rate',
                            'price' => 133,
                            'currency' => '$', 
                            'tax' => $tax,
                            'tax_value' => $tax_value,
                            'total_price' => $total_price,
                            'status' => 1,
                            'user_id' => $customer->id,
                            'street' => $faker->streetAddress,
                            'postal_code' => $faker->postcode,
                            'city' => $faker->city,
                            'country' => $faker->country,
                            'regularity' => $randomValueRegularity,
                            'speciality' => $randomValueSpeciality,
                        ]);
    
                    }

                    /*generate some address*/
                    for ($a=0; $a < 5; $a++) {

                        $Address_for = ['billing', 'location'];
                        $randomA = array_rand($Address_for);
                        $randomaddresValue = $Address_for[$randomA];

                        Address::create([
                            'user_id' => $customer->id,
                            'street' => $faker->streetAddress,
                            'postal_code' => $faker->postcode,
                            'city' => $faker->city,
                            'country' => $faker->country,
                            'address_for' => $randomaddresValue,
                        ]);
                    }
    
                }
            }
        }

        
        // create some Employee user
        for ($i=0; $i < 20; $i++) {
            $employee = User::create([
                'first_name'  => $faker->firstName,
                'last_name'  => $faker->lastName,
                'email' => $faker->safeEmail,
                'phone' => $faker->phoneNumber,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);
            if ($employee) {
                $employee->assignRole('Employee');
                Setting::create(['user_id' => $employee->id]);
            }
        }


        // cretae some optional products
        $products = [
            [
                'name' => 'Cleaning',
                'status'=> 1,
                'icon'=> null,
                'currency'=> '$',
                'add_on_price' => 120
            ],
            [
                'name' => 'Pet',
                'status'=> 1,
                'icon'=> null,
                'currency'=> '$',
                'add_on_price' => 17.50
            ],
            [
                'name' => 'Bike',
                'status'=> 1,
                'is_input'=> 1,
                'icon'=> null,
                'currency'=> '$',
                'add_on_price' => 55.00
            ],
            [
                'name' => 'Children beds',
                'status'=> 1,
                'is_input'=> 1,
                'icon'=> null,
                'currency'=> '$',
                'add_on_price' => 15.55
            ],
        ];

        foreach($products as $product){

            Optionalproduct::create([
                'name' => $product['name'],
                'status'=> $product['status'],
                'icon'=> null,
                'currency'=> $product['currency'],
                'add_on_price' => $product['add_on_price']
            ]);
        }
    }
}
