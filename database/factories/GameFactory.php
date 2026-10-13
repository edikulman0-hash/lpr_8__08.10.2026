<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'developer_id'   => \App\Models\Developer::factory(),
            'title'          => mb_convert_case(fake()->unique()->words(rand(1, 3), true), MB_CASE_TITLE),
            'description'    => fake()->optional()->realText(120),
            'release_year'   => fake()->numberBetween(1990, 2026),
            'price'          => fake()->randomFloat(2, 199, 4999),
            'rating'         => fake()->randomFloat(1, 5, 10),
            'is_multiplayer' => fake()->boolean(40),
        ];
    }
}
