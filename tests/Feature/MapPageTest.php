<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\Location;
use App\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MapPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_map_page_retrieves_bird_and_location(): void
    {
        $response = $this->get('/map');

        $response->assertStatus(200);

        $response->assertSee('Sightings Map');
    }

    public function test_map_data_contains_location_and_animal(): void
    {
        $bird = Animal::factory()->create([
            'common_name' => 'Test Bird',
        ]);

        $location = Location::factory()->create([
            'name' => 'Laravel Headquarters',
        ]);

        Media::factory()->create([
            'location_id' => $location->id,
            'animal_id' => $bird->id,
        ]);

        $response = $this->get('/map-data');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'location_name' => 'Laravel Headquarters',
        ]);

        $response->assertJsonFragment([
            'common_name' => 'Test Bird',
            'slug' => 'test-bird',
        ]);
    }

    public function test_map_data_only_collects_locations_with_media(): void
    {
        $location = Location::factory()->create([
            'name' => 'Location with media',
        ]);

        Location::factory()->create([
            'name' => 'Medialess location',
        ]);

        Media::factory()->create([
            'location_id' => $location->id,
        ]);

        $response = $this->get('/map-data');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'location_name' => 'Location with media',
        ]);

        $response->assertJsonMissing([
            'location_name' => 'Medialess location',
        ]);
    }

    public function test_map_data_returns_animals_sorted_by_common_name(): void
    {
        $birdOne = Animal::factory()->create([
            'common_name' => 'Wren',
        ]);
        $birdTwo = Animal::factory()->create([
            'common_name' => 'House Sparrow',
        ]);

        $location = Location::factory()->create();

        Media::factory()->create([
            'location_id' => $location->id,
            'animal_id' => $birdOne->id,
        ]);

        Media::factory()->create([
            'location_id' => $location->id,
            'animal_id' => $birdTwo->id,
        ]);

        $response = $this->get('/map-data');

        $response->assertStatus(200);

        $response->assertJsonPath('0.animals.0.common_name', 'House Sparrow');
        $response->assertJsonPath('0.animals.1.common_name', 'Wren');
    }

    public function test_map_data_does_not_duplicate_animals_with_multiple_media_records(): void
    {
        $bird = Animal::factory()->create([
            'common_name' => 'Test Bird',
        ]);

        $location = Location::factory()->create();

        Media::factory()->create([
            'location_id' => $location->id,
            'animal_id' => $bird->id,
        ]);

        Media::factory()->create([
            'location_id' => $location->id,
            'animal_id' => $bird->id,
        ]);

        $response = $this->get('/map-data');

        $response->assertStatus(200);

        $response->assertJsonCount(1, '0.animals');
        $response->assertJsonPath('0.animals.0.common_name', 'Test Bird');
    }
}
