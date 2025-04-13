<?php
namespace Database\Factories;

use App\Models\Disease;
use App\Models\Farm;
use App\Models\Prescription;
use App\Models\ServiceCategory;
use App\Models\ServiceRecord;
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

    public function definition()
    {
        $farm = Farm::inRandomOrder()->where('status', '!=', 'pending')->first();

        if (! $farm) {
            $farm = Farm::factory()->create(['status' => 'approved']); // Create a new approved farm if none exist
        }

        $serviceCategory = ServiceCategory::inRandomOrder()->first() ?? ServiceCategory::factory()->create();
        $disease         = Disease::inRandomOrder()->first() ?? Disease::factory()->create();
        $prescriptionId  = $this->faker->boolean(70) ? Prescription::inRandomOrder()->value('id') : null;

        return [
            'farm_id'                 => $farm->id,
            'service_category_id'     => $serviceCategory->id,
            'species_number_flock'    => $this->faker->randomNumber(2),
            'species_number_infected' => $this->faker->randomNumber(2),
            'species_number_dead'     => $this->faker->randomNumber(2),
            'species_type_species'    => $this->faker->word(),
            'species_type_breed'      => $this->faker->word(),
            'species_type_gender'     => $this->faker->randomElement(['male', 'female']),
            'species_type_age'        => $this->faker->randomNumber(2),
            'history_of_disease'      => $this->faker->sentence(),
            'symptoms_of_disease'     => $this->faker->sentence(),
            'microscopic_result'      => $this->faker->sentence(),
            'disease_id'              => $disease->id,
            'prescription_id'         => $prescriptionId,
            'created_by'              => 2, // Staff user
        ];
    }
}
