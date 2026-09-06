<?php

namespace Database\Factories;

use App\Models\Animal;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'animal_id' => Animal::factory(),
            'location_id' => Location::factory(),
            'media_url' => fake()->unique()->slug().'.webp',
            'thumbnail_url' => fake()->unique()->slug().'-thumbnail.webp',
            'media_type' => fake()->randomElement(['image', 'video']),
            'rating' => fake()->numberBetween(1, 10),
            'date_taken' => fake()->dateTimeBetween('-5 years', 'now'),
            'caption' => fake()->words(6, true),
            'gender' => fake()->randomElement(['male', 'female', 'unknown']),
            'age' => fake()->randomElement(['juvenile', 'adult', 'unknown']),
            'metadata' => json_encode([
                'Camera' => 'Canon EOS 70D',
                'Lens' => 'Canon EF 200mm f/2.8L II USM',
                'Focal Length' => '200mm',
                'F-stop' => 'f/2.8',
                'Exposure Time' => '1/320 sec.',
                'ISO' => 'ISO-320', ]),
            'hash' => fake()->unique()->sha256(),
        ];
    }
}
