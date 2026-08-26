<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\Genus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimalTest extends TestCase
{
    use RefreshDatabase;

    public function test_animal_can_be_created(): void
    {
        $genus = Genus::factory()->create();

        $animal = Animal::factory()->create([
            'genus_id' => $genus->id,
            'common_name' => 'House Sparrow',
            'scientific_name' => 'Passer domesticus',
            'ebird_species_code' => 'houspa',
        ]);

        $this->assertDatabaseHas('animals', [
            'id' => $animal->id,
            'genus_id' => $genus->id,
            'common_name' => 'House Sparrow',
            'scientific_name' => 'Passer domesticus',
            'ebird_species_code' => 'houspa',
        ]);

        $this->assertTrue($animal->genus->is($genus));
    }

    public function test_animal_slug_is_generated_from_common_name(): void
    {
        $animal = Animal::factory()->create([
            'common_name' => 'Test Animal',
        ]);

        $this->assertEquals('test-animal', $animal->slug);
    }
}
