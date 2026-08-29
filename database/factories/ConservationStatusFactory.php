<?php

namespace Database\Factories;

use App\Models\Animal;
use App\Models\ConservationList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ConservationStatus>
 */
class ConservationStatusFactory extends Factory
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
            'status' => fake()->randomElement([
                'green',
                'amber',
                'red',
                'former breeder',
                'not assessed',
            ]),
        ];
    }

    public function forConservationList(ConservationList $list): static
    {
        return $this->state([
            'conservation_list_id' => $list->id,
        ]);
    }
}
