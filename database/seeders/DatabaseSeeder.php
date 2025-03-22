<?php

namespace Database\Seeders;

use App\Models\Farm;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\SMSLog;
use App\Models\Disease;
use App\Models\Prescription;
use App\Models\LivestockType;
use App\Models\ServiceRecord;
use App\Models\LivestockCount;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create one admin user
        User::factory()->create([
            'name' => 'ডাঃ উজ্জ্বল কুমার কুন্ডু',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create one staff user
        User::factory()->create([
            'name' => 'এ এম ইউনুস আলী',
            'email' => 'staff@mail.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
        ]);

        // Now populate all other tables with 'created_by' = 2 (staff user)
        Farm::factory(30)->create(['created_by' => 2]);
        LivestockType::factory()
            ->count(5)
            ->sequence(['name' => 'cattle'], ['name' => 'chicken'], ['name' => 'buffalo'], ['name' => 'duck'], ['name' => 'goat'])
            ->create();
        LivestockCount::factory(10)->create();
        ServiceCategory::factory(10)->create();
        Disease::factory(15)->create();
        ServiceRecord::factory(20)->create(['created_by' => 2]);
        Prescription::factory(10)->create(['created_by' => 2, 'approved_by' => 1]);
        SMSLog::factory(10)->create();
    }
}
