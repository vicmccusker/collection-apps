<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PokemonCard>
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
            'FirstSkill' => $this->faker->sentence(3),
            'Weakness' => $this->faker->sentence(3),
            'Rating' => $this->faker->numberBetween(1,10),
            'Got' => $this->faker->boolean(50)
        ];
    }
}
