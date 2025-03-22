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
        $status = $this->faker->randomElement(['pending', 'approved']);

        return [
            'farm_name' => $this->faker->name(),
            'owner_name' => $this->faker->name(),
            'phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'unique_id' => strtoupper(implode('', array_map(fn() => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'[rand(0, 35)], range(1, 7)))),
            'status' => $status,
            'is_active' => $this->faker->boolean(5) ? false : true,
            'created_by' => 2, // Staff user
            'approved_by' => $status === 'approved' ? 1 : null, // Set only if approved
            'approved_at' => $status === 'approved' ? now() : null, // Set only if approved
            'deleted_at' => $this->faker->boolean(15) ? now() : null,
        ];
    }
}
