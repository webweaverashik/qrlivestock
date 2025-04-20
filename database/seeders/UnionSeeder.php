<?php
namespace Database\Seeders;

use App\Models\Union;
use Illuminate\Database\Seeder;

class UnionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unions = [
            'হরিণাকুন্ডু পৌরসভা',
            'ভায়না ইউনিয়ন',
            'জোড়াদহ ইউনিয়ন',
            'তাহেরহুদা ইউনিয়ন',
            'দৌলতপুর ইউনিয়ন',
            'কাপাসহাটিয়া ইউনিয়ন',
            'ফলসী ইউনিয়ন',
            'রঘুনাথপুর ইউনিয়ন',
            'চাঁদপুর ইউনিয়ন',
        ];

        foreach ($unions as $unionName) {
            Union::create([
                'name' => $unionName,
            ]);
        }
    }
}
