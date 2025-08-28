<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customertype;

class CustomerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'Company',
            'Private Person',
            'Airbnb',
            'Scam',
            'Partner',
            'Host',
            'Subunternehmer',
            'Teilzeit',
            'Minijob',
            'Bewerber',
        ];

        foreach ($datas as $key => $value) {
            Customertype::create([
                'name' => $value
            ]);
        }
    }
}
