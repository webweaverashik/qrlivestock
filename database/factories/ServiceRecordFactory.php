<?php

namespace Database\Factories;

use App\Models\Farm;
use App\Models\User;
use App\Models\Disease;
use App\Models\Prescription;
use App\Models\ServiceRecord;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceRecord>
 */
class ServiceRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ServiceRecord::class;
    
    public function definition(): array
    {
        return [
            'farm_id' => Farm::inRandomOrder()->value('id') ?? Farm::factory(),
            'service_category_id' => ServiceCategory::inRandomOrder()->value('id') ?? ServiceCategory::factory(),
            'species_number_flock' => $this->faker->randomNumber(),
            'species_number_infected' => $this->faker->randomNumber(),
            'species_number_dead' => $this->faker->randomNumber(),
            'species_type_species' => $this->faker->word(),
            'species_type_breed' => $this->faker->word(),
            'species_type_gender' => $this->faker->randomElement(['male', 'female']),
            'species_type_age' => $this->faker->randomNumber(2),
            'history_of_disease' => $this->faker->sentence(),
            'microscopic_result' => $this->faker->sentence(),
            'disease_id' => Disease::inRandomOrder()->value('id') ?? Disease::factory(),
            'prescription_id' => $this->faker->boolean(70) ? Prescription::inRandomOrder()->value('id') : null, // 70% chance to assign an existing prescription
            'created_by' => 2, // Staff user
        ];
    }
}
