<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $superAdminRole = Role::create(['name' => 'super_admin', 'display_name' => 'Super Admin']);
        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Admin']);

        // Create permissions
        $permissions = ['create_user', 'read_user', 'update_user', 'delete_user'];
        foreach ($permissions as $permissionName) {
            $permission = Permission::create(['name' => $permissionName]);
            $superAdminRole->permissions()->attach($permission);
        }

        // // Assign roles to a user
        // $user = User::create([
        //     'first_name' => 'Super',
        //     'last_name' => 'Admin',
        //     'email' => 'super@app.com',
        //     'password' => Hash::make('123456'),
        // ]);

        // $user->roles()->attach($superAdminRole);
    }
}
