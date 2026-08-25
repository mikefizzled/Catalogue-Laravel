<?php

namespace Database\Factories;

use App\Models\Genus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'genus_id' => Genus::factory(),
            'common_name' => fake()->words(2, true),
            'scientific_name' => fake()->unique()->words(2, true),
            'thumbnail_url' => fake()->unique()->slug().'-thumbnail.webp',
            'ebird_species_code' => strtolower(fake()->unique()->lexify('??????')).'1',
        ];
    }
}
