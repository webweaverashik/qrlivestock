<?php
namespace Database\Factories;

use App\Models\LivestockType;
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
        $status = $this->faker->randomElement(['pending', 'approved']);

        return [
            'livestock_type_id'        => LivestockType::inRandomOrder()->value('id'), // or null
            'livestock_age'            => $this->faker->numberBetween(1, 5) . ' বছর',
            'livestock_weight'         => $this->faker->numberBetween(50, 200) . ' কেজি',
            'disease_brief'            => $this->faker->sentence(6),
            'medication'               => $this->faker->words(3, true),
            'livestock_temp'           => $this->faker->randomFloat(1, 38.0, 40.5) . '°C',
            'livestock_pulse'          => $this->faker->numberBetween(60, 100) . ' bpm',
            'livestock_rumen_motility' => $this->faker->numberBetween(1, 3) . ' মিনিটে',
            'livestock_respiratory'    => $this->faker->numberBetween(20, 40) . ' rpm',
            'livestock_other'          => $this->faker->optional()->sentence(),
            'additional_notes'         => $this->faker->optional()->paragraph(),
            'status'                   => $status,
            'approved_by'              => $status === 'approved' ? 1 : null, // Admin user
            'created_by'               => 2,                                 // Staff user
        ];
    }
}
