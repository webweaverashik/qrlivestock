<?php

namespace Database\Seeders;

use App\Models\LivestockType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LivestockTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LivestockType::factory()
        ->count(6)
        ->sequence(['name' => 'গরু'], ['name' => 'ছাগল'], ['name' => 'মহিষ'], ['name' => 'ভেড়া'], ['name' => 'মুরগি'], ['name' => 'হাঁস'])
        ->create();
    }
}
