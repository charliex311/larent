<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class SyncPermissionToRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1);
        if ($user) {
            $role = Role::find(1);
            if ($role) {
                $user->assignRole($role);
                foreach (Permission::all() as $permisison) {
                    // $role->givePermissionTo($permisison->id);
                    if (!$user->hasPermissionTo($permisison->id)) {
                        $user->givePermissionTo($permisison->id);
                    }
                }
            } else {
                Role::create(['name'=>'Administrator']);
                return;
            }
        } else {
            return;
        }
    }
}
