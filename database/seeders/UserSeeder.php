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
        // Example admin user
        User::create([
            'name'              => 'Admin User',
            'email'             => 'admin@gmail.com',
            'password'          => Hash::make('11111111'),
            'phone'             => '017XXXXXXXX',
            'address'           => 'Dhaka, Bangladesh',
            'company'           => 'TechPoint',
            'branch'            =>  null,
            'email_verified_at' => now(),
        ]);

        // Example staff user
        User::create([
            'name'              => 'Staff User',
            'email'             => 'staff@gmail.com',
            'password'          => Hash::make('11111111'),
            'phone'             => '018XXXXXXXX',
            'address'           => 'London, UK',
            'company'           => 'TikTech',
            'branch'            => 'TikTech-Upminister',
            'email_verified_at' => now(),
        ]);

        // Example restaurant manager
        User::create([
            'name'              => 'Restaurant Manager',
            'email'             => 'manager@gmail.com',
            'password'          => Hash::make('11111111'),
            'phone'             => '019XXXXXXXX',
            'address'           => 'Billericay, UK',
            'company'           => 'Restaurant',
            'branch'            => null,
            'email_verified_at' => now(),
        ]);
    }
}
