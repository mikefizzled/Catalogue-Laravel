<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\BoccCriteriaDefinition;
use App\Models\ConservationList;
use App\Models\ConservationStatus;
use App\Models\ConservationStatusCriteria;
use Database\Seeders\ConservationListSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConservationStatusTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ConservationListSeeder::class);

    }

    public function test_conservation_status_belongs_to_an_animal(): void
    {
        $animal = Animal::factory()->create();

        $bocc4 = ConservationList::where('short_name', 'BoCC4')->firstOrFail();

        $status = ConservationStatus::factory()->create([
            'animal_id' => $animal->id,
            'conservation_list_id' => $bocc4->id,
            'status' => 'amber',
        ]);

        $this->assertTrue($status->animal->is($animal));

    }

    public function test_conservation_status_belongs_to_a_list(): void
    {
        $animal = Animal::factory()->create();

        $bocc5a = ConservationList::where('short_name', 'BoCC5a')->firstOrFail();

        $status = ConservationStatus::factory()->create([
            'animal_id' => $animal->id,
            'conservation_list_id' => $bocc5a->id,
        ]);

        $this->assertTrue($status->conservationList->is($bocc5a));

    }

    public function test_conservation_status_has_many_status_criteria(): void
    {
        $list = ConservationList::query()->firstOrFail();

        $criteriaDefinitions = BoccCriteriaDefinition::query()
            ->take(2)
            ->get();

        $status = ConservationStatus::factory()
            ->forConservationList($list)
            ->create();

        $criteria = $criteriaDefinitions->map(
            fn (BoccCriteriaDefinition $definition) => ConservationStatusCriteria::factory()->create([
                'conservation_status_id' => $status->id,
                'bocc_criteria_id' => $definition->id,
            ])
        );

        $this->assertEqualsCanonicalizing(
            $criteria->pluck('id')->all(),
            $status->criteria->pluck('id')->all()
        );
    }
}
