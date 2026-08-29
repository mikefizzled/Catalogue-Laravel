<?php

namespace Tests\Feature\Models;

use App\Models\Animal;
use App\Models\Location;
use App\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    public function test_location_can_be_created(): void
    {
        $location = Location::factory()->create([
            'name' => 'Weston Park',
            'city' => 'Sheffield',
            'latitude' => 53.382200,
            'longitude' => -1.490200,
            'area_caption' => 'A local park.',
        ]);

        $this->assertDatabaseHas('locations', [
            'id' => $location->id,
            'name' => 'Weston Park',
            'city' => 'Sheffield',
            'latitude' => 53.382200,
            'longitude' => -1.490200,
            'area_caption' => 'A local park.',

        ]);
    }

    public function test_location_slug_is_generated_from_location_name(): void
    {
        $location = Location::factory()->create([
            'name' => 'Test Location',
        ]);

        $this->assertEquals('test-location', $location->slug);
    }

    public function test_location_has_many_media(): void
    {

        $location = Location::factory()->create();

        $mediaOne = Media::factory()->create(['location_id' => $location->id]);
        $mediaTwo = Media::factory()->create(['location_id' => $location->id]);

        $this->assertTrue($location->media->contains($mediaOne));
        $this->assertTrue($location->media->contains($mediaTwo));
        $this->assertCount(2, $location->media);
    }

    public function test_location_retrieves_locations_for_animal(): void
    {

        $locationOne = Location::factory()->create();
        $locationTwo = Location::factory()->create();

        $animalOne = Animal::factory()->create();
        $animalTwo = Animal::factory()->create();

        Media::factory()->create([
            'location_id' => $locationOne->id,
            'animal_id' => $animalOne->id,
        ]);

        Media::factory()->create([
            'location_id' => $locationTwo->id,
            'animal_id' => $animalTwo->id,
        ]);

        $locations = Location::getForAnimal($animalOne->id);

        $this->assertTrue($locations->contains($locationOne));
        $this->assertFalse($locations->contains($locationTwo));
        $this->assertCount(1, $locations);
    }

    public function test_location_creates_title_attribute(): void
    {
        $location = Location::factory()->create([
            'name' => 'Test Location',
        ]);

        $this->assertEquals('Test Location', $location->title);
    }

    public function test_location_creates_subtitle_attribute(): void
    {
        $location = Location::factory()->create([
            'city' => 'London',
        ]);

        $this->assertEquals('London', $location->subtitle);
    }

    public function test_location_creates_thumbnail_attribute(): void
    {
        $location = Location::factory()->create([
            'image' => 'hyde-park-thumbnail.webp',
        ]);

        $this->assertEquals('hyde-park-thumbnail.webp', $location->thumbnail);
    }

    public function test_location_uses_slug_for_route_key(): void
    {
        $location = Location::factory()->create();

        $this->assertEquals('slug', $location->getRouteKeyName());
    }
}
