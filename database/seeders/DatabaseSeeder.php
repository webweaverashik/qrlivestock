<?php
namespace Database\Seeders;

use App\Models\Disease;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Farm;
use App\Models\LivestockCount;
use App\Models\LivestockType;
use App\Models\Prescription;
use App\Models\ServiceCategory;
use App\Models\ServiceRecord;
use App\Models\SMSLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            UnionSeeder::class,
        ]);

        
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

        // Now populate all other tables with 'created_by' = 2 (staff user)
        Farm::factory(40)->create(['created_by' => 2]);
        LivestockType::factory()
            ->count(6)
            ->sequence(['name' => 'গরু'], ['name' => 'মুরগি'], ['name' => 'মহিষ'], ['name' => 'হাঁস'], ['name' => 'ছাগল'], ['name' => 'ভেড়া'])
            ->create();
        LivestockCount::factory(10)->create();
        ServiceCategory::factory(20)->create();
        Disease::factory(20)->create();
        Prescription::factory(20)->create();

        ServiceRecord::factory(20)
            ->create(['created_by' => 2])
            ->each(function ($serviceRecord) {
                if (fake()->boolean(50)) { // 50% chance
                    $prescription = Prescription::factory()->create([
                        'created_by' => $serviceRecord->created_by,
                    ]);

                    // Attach the prescription to this service record
                    $serviceRecord->prescription_id = $prescription->id;
                    $serviceRecord->save();
                }
            });
        SMSLog::factory(20)->create();

    }
}
