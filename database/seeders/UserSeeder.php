<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@kampus.com',
            'role' => 'admin',
            'password' => Hash::make('password'), // password: password
        ]);

        // Akun User Biasa
        User::create([
            'name' => 'Staff Logistik',
            'email' => 'staff@kampus.com',
            'role' => 'user',
            'password' => Hash::make('password'),
        ]);
    }
}