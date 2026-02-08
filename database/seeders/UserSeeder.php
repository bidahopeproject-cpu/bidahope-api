<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // ADMIN ACCOUNT
        User::create([
            'first_name' => 'System',
            'last_name' => 'Admin',
            'mobile_number' => '09123456789',
            'email' => 'admin@bidahope.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // ENCODER ACCOUNT
        User::create([
            'first_name' => 'Test',
            'last_name' => 'Encoder',
            'mobile_number' => '09987654321',
            'email' => 'encoder@bidahope.com',
            'password' => Hash::make('encoder123'),
            'role' => 'encoder',
        ]);
    }
}