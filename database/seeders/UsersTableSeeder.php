<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create a new user
        $user = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'super@app.com',
            'password' => Hash::make('123456'),
        ]);

        // Assign Role
        $role = Role::where('name', 'supper_admin')->first();
        if ($role) {
            $user->roles()->attach($role->id);
        }

        // Assign Permissions (optional)
        $permissions = Permission::pluck('id')->toArray();
        $user->permissions()->sync($permissions);
    }
}
