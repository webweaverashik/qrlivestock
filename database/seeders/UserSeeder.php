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
            'email'    => 'ulohorinakondo@gmail.com',
            'password' => bcrypt('Bx30SOV)Uxt1'),
            'role'     => 'admin',
        ]);

        // Create one staff user
        User::factory()->create([
            'name'     => 'মো: হুমায়ন কবির',
            'email'    => 'humaon.kabir09@gmail.com', 
            'password' => bcrypt('Bx30SOV)Uxt1'),
            'role'     => 'staff',
        ]);
    }
}
