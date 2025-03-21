<?php

namespace Database\Factories;

use App\Models\Farm;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Farm>
 */
class FarmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Farm::class;
    
    public function definition(): array
    {
        return [
            'owner_name' => $this->faker->name(),
            'phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'unique_id' => Str::uuid(),
            'status' => $this->faker->randomElement(['pending', 'approved']),
            'created_by' => 2, // Staff user
            'approved_by' => 1, // Admin user
            'approved_at' => now(),
        ];
    }
}
