<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate([
            'name' => 'Admin User',
            'email' => 'pilsam123@gmail.com',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('admin');

        $editor = User::firstOrCreate([
            'name' => 'Manager User',
            'email' => 'malinjadock@gmail.com',
            'password' => Hash::make('password')
        ]);
        $editor->assignRole('manager');

        $user = User::firstOrCreate([
            'name' => 'Regular User',
            'email' => 'malinjadocko@gmail.com',
            'password' => Hash::make('password')
        ]);
        $user->assignRole('staff');

        $user = User::firstOrCreate([
            'name' => 'Editor User',
            'email' => 'malinjadock2@gmail.com',
            'password' => Hash::make('password')]);
        $user->assignRole('editor');

        $user = User::firstOrCreate([
            'name' => 'Senior Manager User',
            'email' => 'malinjadock1@gmail.com',
            'password' => Hash::make('password')
        ]);
        $user->assignRole('senior_manager');
    }
}
