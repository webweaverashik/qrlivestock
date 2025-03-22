<?php

namespace Database\Factories;

use App\Models\Farm;
use App\Models\SMSLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SmsLog>
 */
class SMSLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = SMSLog::class;

    public function definition()
    {
        return [
            'farm_id' => Farm::inRandomOrder()->value('id') ?? Farm::factory(),
            'phone_number' => $this->faker->phoneNumber(),
            'message' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['sent', 'failed']),
        ];
    }
}
