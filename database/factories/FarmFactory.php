<?php
namespace Database\Factories;

use App\Models\Farm;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'phone_number' => '01' . $this->faker->numberBetween(100000000, 999999999), // Valid 11-digit BD number
            'address' => $this->faker->address(),
            'unique_id' => function () {
                do {
                    $id = rand(100000, 999999);
                } while (Farm::where('unique_id', $id)->exists());

                return $id;
            },
            'status' => $status,
            'is_active' => $this->faker->boolean(5) ? false : true,
            'created_by' => 2, // Staff user
            'approved_by' => $status === 'approved' ? 1 : null, // Set only if approved
            'approved_at' => $status === 'approved' ? now() : null, // Set only if approved
            'deleted_at' => $this->faker->boolean(15) ? now() : null,
            'remarks' => $this->faker->boolean(50)
                ? $this->faker->sentence(4, true) // 4 words, with period
                : null,
        ];
    }
}
