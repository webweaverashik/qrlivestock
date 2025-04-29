<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create one admin user
        User::factory()->create([
            'name'     => 'ডাঃ উজ্জ্বল কুমার কুন্ডু',
            'email'    => 'admin@mail.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        // Create one staff user
        User::factory()->create([
            'name'     => 'এ এম ইউনুস আলী',
            'email'    => 'staff@mail.com', 
            'password' => bcrypt('password'),
            'role'     => 'staff',
        ]);
    }
}
