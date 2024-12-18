<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'super@app.com',
            'password' => Hash::make('123456')

        ]);



        $user->hasRole('admin');


        // $admin = Role::create([
        //     'name' => 'admin',
        //     'display_name' => 'User Administrator', // optional
        //     'description' => 'User is allowed to manage and edit other users', // optional
        // ]);
        // $owner = Role::create([
        //     'name' => 'owner',
        //     'display_name' => 'Project Owner', // optional
        //     'description' => 'User is the owner of a given project', // optional
        // ]);
        // $user->attachRole('supper_admin');
        // $user->ability(['admin', 'owner'], ['create', 'read', 'update', 'delete']);
    }
}
