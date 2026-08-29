<?php

namespace Tests\Feature\Models;

use App\Models\BoccCriteriaDefinition;
use App\Models\ConservationList;
use App\Models\ConservationStatusCriteria;
use Database\Seeders\BoccCriteriaDefinitionSeeder;
use Database\Seeders\ConservationListSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoccCriteriaDefinitionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(BoccCriteriaDefinitionSeeder::class);
        $this->seed(ConservationListSeeder::class);
    }

    public function test_bocc_criteria_definition_is_created(): void
    {
        $bcd = BoccCriteriaDefinition::query()->firstOrFail();

        $this->assertDatabaseHas('bocc_criteria_definitions', [
            'id' => $bcd->id,
        ]);
    }

    public function test_bocc_criteria_definition_has_many_statuses(): void
    {
        $list = ConservationList::query()->firstOrFail();
        $definition = BoccCriteriaDefinition::query()->firstOrFail();

        $criteria = ConservationStatusCriteria::factory()
            ->count(2)
            ->forConservationList($list)
            ->create([
                'bocc_criteria_id' => $definition->id,
            ]);

        $this->assertEqualsCanonicalizing(
            $criteria->pluck('id')->all(),
            $definition->conservationStatuses->pluck('id')->all()
        );
    }
}
