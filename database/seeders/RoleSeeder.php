<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrator'],
            ['name' => 'Employee'],
            ['name' => 'Customer'],
            ['name' => 'Manager'],
        ];
        foreach ($roles as $role) {
            Role::create([
                'name'  => $role['name']
            ]);
        }
    }
}
