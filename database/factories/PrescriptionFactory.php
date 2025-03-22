<?php

namespace Database\Factories;

use App\Models\Farm;
use App\Models\User;
use App\Models\Prescription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prescription>
 */
class PrescriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Prescription::class;

    public function definition()
    {
        return [
            'farm_id' => Farm::inRandomOrder()->value('id') ?? Farm::factory(),
            'diagnosis' => $this->faker->sentence(),
            'medication' => $this->faker->sentence(),
            'dosage' => $this->faker->word(),
            'additional_notes' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'approved']),
            'approved_by' => 1, // Admin user
            'created_by' => 2, // Staff user
        ];
    }
}
