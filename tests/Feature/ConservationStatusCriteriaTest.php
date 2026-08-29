<?php

namespace Tests\Feature;

use App\Models\BoccCriteriaDefinition;
use App\Models\ConservationList;
use App\Models\ConservationStatus;
use App\Models\ConservationStatusCriteria;
use Database\Seeders\BoccCriteriaDefinitionSeeder;
use Database\Seeders\ConservationListSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConservationStatusCriteriaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ConservationListSeeder::class);
        $this->seed(BoccCriteriaDefinitionSeeder::class);

    }

    public function test_conservation_status_criteria_can_be_created(): void
    {

        $list = ConservationList::query()->firstOrFail();

        $status = ConservationStatus::factory()->create([
            'conservation_list_id' => $list->id,
        ]);
        $bcd = BoccCriteriaDefinition::query()->firstOrFail();

        ConservationStatusCriteria::factory()->create([
            'conservation_status_id' => $status->id,
            'bocc_criteria_id' => $bcd->id,
        ]);

        $this->assertDatabaseHas('conservation_status_criteria', [
            'conservation_status_id' => $status->id,
            'bocc_criteria_id' => $bcd->id,
        ]);
    }

    public function test_conservation_status_criteria_belongs_to_status(): void
    {
        $list = ConservationList::query()->firstOrFail();
        $status = ConservationStatus::factory()->create([
            'conservation_list_id' => $list->id,
        ]);

        $bcd = BoccCriteriaDefinition::query()->firstOrFail();

        $css = ConservationStatusCriteria::factory()->create([
            'conservation_status_id' => $status->id,
            'bocc_criteria_id' => $bcd->id,
        ]);

        $this->assertTrue($css->conservationStatus->is($status));
    }

    public function test_conservation_status_criteria_belongs_to_bocc_criterion(): void
    {
        $list = ConservationList::query()->firstOrFail();
        $status = ConservationStatus::factory()->create([
            'conservation_list_id' => $list->id,
        ]);

        $bcd = BoccCriteriaDefinition::query()->firstOrFail();

        $css = ConservationStatusCriteria::factory()->create([
            'conservation_status_id' => $status->id,
            'bocc_criteria_id' => $bcd->id,
        ]);

        $this->assertTrue($css->boccCriteria->is($bcd));
    }
}
