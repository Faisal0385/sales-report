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
            'name'              => 'Techpoint User',
            'email'             => 'admin@techpoint.com',
            'password'          => Hash::make('password1'),
            'phone'             => null,
            'address'           => 'UK',
            'role'              => null,
            'company'           => 'TechPoint',
            'branch'            => null,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Restaurant User',
            'email'             => 'admin@restaurant.com',
            'password'          => Hash::make('password2'),
            'phone'             => null,
            'address'           => 'UK',
            'role'              => null,
            'company'           => 'Restaurant',
            'branch'            => null,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Hornchurch User',
            'email'             => 'hc@tiktech.com',
            'password'          => Hash::make('password3'),
            'phone'             => null,
            'address'           => 'UK',
            'role'              => null,
            'company'           => 'TikTech',
            'branch'            => 'Hornchurch',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Upminister User',
            'email'             => 'up@tiktech.com',
            'password'          => Hash::make('password4'),
            'phone'             => null,
            'address'           => 'UK',
            'role'              => null,
            'company'           => 'TikTech',
            'branch'            => 'Upminister',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Billericay User',
            'email'             => 'br@tiktech.com',
            'password'          => Hash::make('password5'),
            'phone'             => null,
            'address'           => 'UK',
            'role'              => null,
            'company'           => 'TikTech',
            'branch'            => 'Billericay',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Admin User',
            'email'             => 'super@gmail.com',
            'password'          => Hash::make('password#'),
            'phone'             => null,
            'address'           => 'UK',
            'role'              => 'superadmin',
            'company'           => 'TechPoint',
            'branch'            => null,
            'email_verified_at' => now(),
        ]);
    }
}
