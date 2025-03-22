<?php

namespace Database\Factories;

use App\Models\Farm;
use App\Models\LivestockType;
use App\Models\LivestockCount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LivestockCount>
 */
class LivestockCountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = LivestockCount::class;
    
    public function definition(): array
    {
        return [
            'farm_id' => Farm::inRandomOrder()->value('id') ?? Farm::factory(),
            'livestock_type_id' => LivestockType::inRandomOrder()->value('id') ?? LivestockType::factory(),
            'total' => $this->faker->numberBetween(50, 200),
        ];
    }
}
