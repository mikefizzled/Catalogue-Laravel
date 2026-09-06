<?php

namespace Tests\Feature\Models;

use App\Models\Animal;
use App\Models\ConservationList;
use App\Models\ConservationStatus;
use App\Models\Genus;
use App\Models\Media;
use Database\Seeders\ConservationListSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ConservationListSeeder::class);

    }

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

    public function test_animal_belongs_to_genus(): void
    {
        $genus = Genus::factory()->create();

        $animal = Animal::factory()->create([
            'genus_id' => $genus->id,
        ]);

        $this->assertTrue($animal->genus->is($genus));
    }

    public function test_animal_has_many_media(): void
    {
        $animal = Animal::factory()->create();

        $mediaOne = Media::factory()->create([
            'animal_id' => $animal->id,
        ]);

        $mediaTwo = Media::factory()->create([
            'animal_id' => $animal->id,
        ]);

        $this->assertTrue($animal->images->contains($mediaOne));
        $this->assertTrue($animal->images->contains($mediaTwo));
        $this->assertCount(2, $animal->images);
    }

    public function test_animal_creates_title_attribute(): void
    {
        $animal = Animal::factory()->create([
            'common_name' => 'Test Animal',
        ]);

        $this->assertEquals('Test Animal', $animal->title);
    }

    public function test_animal_creates_subtitle_attribute(): void
    {
        $animal = Animal::factory()->create([
            'scientific_name' => 'Passer domesticus',
        ]);

        $this->assertEquals('Passer domesticus', $animal->subtitle);
    }

    public function test_animal_creates_thumbnail_attribute(): void
    {
        $animal = Animal::factory()->create([
            'thumbnail_url' => 'house-sparrow-thumbnail.webp',
        ]);

        $this->assertEquals('house-sparrow-thumbnail.webp', $animal->thumbnail);
    }

    public function test_animal_get_slug_returns_animal_slug(): void
    {
        $animal = Animal::factory()->create([
            'common_name' => 'House Sparrow',
        ]);

        $this->assertEquals(
            'house-sparrow',
            Animal::getSlug($animal->id)
        );
    }

    public function test_animal_get_slug_returns_unknown_for_missing_animal(): void
    {
        $this->assertEquals(
            'Unknown',
            Animal::getSlug(999999)
        );
    }

    public function test_animal_creates_status_map_from_conservation_statuses(): void
    {
        $animal = Animal::factory()->create();

        $bocc4 = ConservationList::where('short_name', 'BoCC4')->firstOrFail();
        $bocc5 = ConservationList::where('short_name', 'BoCC5')->firstOrFail();

        ConservationStatus::factory()->create([
            'animal_id' => $animal->id,
            'conservation_list_id' => $bocc4->id,
            'status' => 'amber',
        ]);

        ConservationStatus::factory()->create([
            'animal_id' => $animal->id,
            'conservation_list_id' => $bocc5->id,
            'status' => 'red',
        ]);

        $this->assertEquals([
            $bocc4->id => 'amber',
            $bocc5->id => 'red',
        ], $animal->status_map);

    }

    public function test_animal_uses_slug_for_route_key(): void
    {
        $animal = Animal::factory()->create();

        $this->assertEquals('slug', $animal->getRouteKeyName());
    }
}
