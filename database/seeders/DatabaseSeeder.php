<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            PermissionsSeeder::class,
            SyncPermissionToRoleSeeder::class,
            FooterSeeder::class,
            DemoContentSeeder::class,
            CustomerTypeSeeder::class
        ]);
    }
}
