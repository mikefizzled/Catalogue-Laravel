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

        Media::factory()->create([
            'animal_id' => $animal->id,
            'location_id' => $location->id,
            'media_type' => 'image',
        ]);

        Media::factory()->create([
            'animal_id' => $animal->id,
            'location_id' => $location->id,
            'media_type' => 'image',
        ]);

        Media::factory()->create([
            'animal_id' => $animal->id,
            'location_id' => $location->id,
            'media_type' => 'video',
        ]);

        $this->assertEquals(Media::nextMediaNumber($animal->id, 'image'), 3);
        $this->assertEquals(Media::nextMediaNumber($animal->id, 'video'), 2);
    }

    public function test_media_belongs_to_location(): void
    {
        $location = Location::factory()->create();

        $media = Media::factory()->create([
            'location_id' => $location->id,
        ]);

        $this->assertTrue($media->location->is($location));
    }

    public function test_media_belongs_to_animal(): void
    {
        $animal = Animal::factory()->create();

        $media = Media::factory()->create([
            'animal_id' => $animal->id,
        ]);

        $this->assertTrue($media->animal->is($animal));
    }

    public function test_media_uses_id_for_route_key(): void
    {
        $media = Media::factory()->create();

        $this->assertEquals('id', $media->getRouteKeyName());
    }

    public function test_media_is_collected_by_type_then_sorted(): void
    {
        $animalOne = Animal::factory()->create();
        $animalTwo = Animal::factory()->create();

        $mediaOne = Media::factory()->create([
            'animal_id' => $animalOne->id,
            'media_type' => 'image',
        ]);

        $mediaTwo = Media::factory()->create([
            'animal_id' => $animalTwo->id,
            'media_type' => 'image',
        ]);

        $mediaThree = Media::factory()->create([
            'animal_id' => $animalOne->id,
            'media_type' => 'image',
        ]);

        $media = Media::getVisualMediaForAnimal($animalOne->id);

        $this->assertTrue($media->contains($mediaOne));
        $this->assertFalse($media->contains($mediaTwo));
        $this->assertTrue($media->contains($mediaThree));
    }

    public function test_media_creates_title_attribute(): void
    {
        $animal = Animal::factory()->create([
            'common_name' => 'House Sparrow',
        ]);

        $media = Media::factory()->create([
            'animal_id' => $animal->id,
        ]);

        $this->assertEquals('House Sparrow', $media->title);
    }

    public function test_media_creates_subtitle_attribute(): void
    {
        $location = Location::factory()->create([
            'name' => 'Test Location',
        ]);

        $media = Media::factory()->create([
            'location_id' => $location->id,
            'date_taken' => '2024-06-28 12:00:00',
        ]);

        $this->assertEquals('Test Location – June 28, 2024', $media->subtitle);
    }
}
