<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::all();
        $role = Role::where('name', 'supper_admin')->first();

        if ($role) {
            $role->permissions()->sync($permissions->pluck('id')->toArray());
        }
    }
}
