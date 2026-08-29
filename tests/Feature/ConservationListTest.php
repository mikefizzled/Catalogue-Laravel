<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\ConservationList;
use App\Models\ConservationStatus;
use Database\Seeders\ConservationListSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConservationListTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ConservationListSeeder::class);

    }

    public function test_conservation_list_has_many_statuses(): void
    {
        $list = ConservationList::where('short_name', 'BoCC5')->firstOrFail();

        $animalOne = Animal::factory()->create();
        $animalTwo = Animal::factory()->create();

        $statusOne = ConservationStatus::factory()->create([
            'animal_id' => $animalOne->id,
            'conservation_list_id' => $list->id,
            'status' => 'red',
        ]);

        $statusTwo = ConservationStatus::factory()->create([
            'animal_id' => $animalTwo->id,
            'conservation_list_id' => $list->id,
            'status' => 'amber',
        ]);

        $this->assertTrue($list->conservationStatuses->contains($statusOne));
        $this->assertTrue($list->conservationStatuses->contains($statusTwo));
        $this->assertCount(2, $list->conservationStatuses);
    }
}
