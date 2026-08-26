<?php

namespace Tests\Feature;

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
}
