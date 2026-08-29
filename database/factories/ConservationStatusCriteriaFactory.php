<?php

namespace Database\Factories;

use App\Models\BoccCriteriaDefinition;
use App\Models\ConservationList;
use App\Models\ConservationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ConservationStatusCriteria>
 */
class ConservationStatusCriteriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'conservation_status_id' => ConservationStatus::factory(),
        ];
    }

    // Build a status criteria linked to a provided list
    public function forConservationList(ConservationList $list): static
    {
        return $this->for(
            ConservationStatus::factory()
                ->forConservationList($list)
        );
    }

    // Build a status criteria linked to a criteria definition
    public function forBoccCriteria(BoccCriteriaDefinition $definition): static
    {
        return $this->state([
            'bocc_criteria_id' => $definition->id,
        ]);
    }
}
