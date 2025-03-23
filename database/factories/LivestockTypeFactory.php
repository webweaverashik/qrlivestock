<?php

namespace Database\Factories;

use App\Models\LivestockType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LivestockType>
 */
class LivestockTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = LivestockType::class;
    
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['গরু', 'মুরগি', 'মহিষ', 'হাঁস', 'ছাগল' , 'ভেড়া']),
            'description' => $this->faker->sentence(),
        ];
    }
}
