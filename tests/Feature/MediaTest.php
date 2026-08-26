<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\Location;
use App\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_media_can_be_created(): void
    {
        $animal = Animal::factory()->create();
        $location = Location::factory()->create();

        $media = Media::factory()->create([
            'animal_id' => $animal->id,
            'location_id' => $location->id,
            'media_type' => 'image',
            'rating' => 8,
            'caption' => 'Test caption',
            'gender' => 'male',
            'age' => 'adult',
        ]);

        $this->assertDatabaseHas('media', [
            'id' => $media->id,
            'animal_id' => $animal->id,
            'location_id' => $location->id,
            'media_type' => 'image',
            'rating' => 8,
            'caption' => 'Test caption',
            'gender' => 'male',
            'age' => 'adult',
        ]);

        $this->assertTrue($media->animal->is($animal));
        $this->assertTrue($media->location->is($location));
    }

    public function test_media_correctly_chooses_next_number(): void
    {

        $animal = Animal::factory()->create();
        $location = Location::factory()->create();

        $media = Media::factory()->create([
            'animal_id' => $animal->id,
            'location_id' => $location->id,
            'media_type' => 'image',
        ]);

        $media2 = Media::factory()->create([
            'animal_id' => $animal->id,
            'location_id' => $location->id,
            'media_type' => 'image',
        ]);

        $media3 = Media::factory()->create([
            'animal_id' => $animal->id,
            'location_id' => $location->id,
            'media_type' => 'audio',
        ]);

        $this->assertEquals(Media::nextMediaNumber($animal->id, 'image'), 3);
        $this->assertEquals(Media::nextMediaNumber($animal->id, 'audio'), 2);
    }
}
