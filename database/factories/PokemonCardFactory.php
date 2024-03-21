<?php

namespace Database\Factories;

use App\Models\PokemonCard;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PokemonCard>
 */
class PokemonCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'HP' => $this->faker->numberBetween(1, 200),
            'FirstSkill' => 'Test',
            'Weakness' => $this->faker->sentence(1),
            'Rating' => $this->faker->numberBetween(1, 10),
            'Got' => $this->faker->boolean(50),
        ];
    }
}
