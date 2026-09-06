<?php

namespace Tests\Feature\Admin;

use App\Models\Location;
use App\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    // ==========================================
    // INDEX TESTS
    // ==========================================

    public function test_index_displays_locations_ordered_by_name(): void
    {
        $this->actingAsUser();

        Location::factory()->create(['name' => 'Laravel HQ']);
        Location::factory()->create(['name' => 'Stonehenge']);
        Location::factory()->create(['name' => 'Flamborough Head']);

        $response = $this->get('/admin/locations');

        $response->assertOk();
        $response->assertViewHas('locations', function ($locations) {
            return $locations->pluck('name')->values()->all() === [
                'Flamborough Head',
                'Laravel HQ',
                'Stonehenge',
            ];
        });
    }

    public function test_index_is_paginated(): void
    {
        $this->actingAsUser();
        Location::factory()->count(15)->create();

        $response = $this->get('/admin/locations');

        $response->assertOk();
        $response->assertViewHas('locations', function ($locations) {
            return $locations->count() === 10
                && $locations->total() === 15
                && $locations->lastPage() === 2;
        });
    }

    // ==========================================
    // CREATE TESTS
    // ==========================================

    public function test_create_form_loads_with_all_locations(): void
    {
        $locationOne = Location::factory()->create();
        $locationTwo = Location::factory()->create();

        $this->actingAsUser();

        $response = $this->get('/admin/locations/create');

        $response->assertOk();
        $response->assertViewIs('admin.locations.create');
        $response->assertViewHas('allLocations', function ($locations) use ($locationOne, $locationTwo) {
            return $locations->contains('id', $locationOne->id)
                && $locations->contains('id', $locationTwo->id);
        });
    }

    public function test_store_creates_location_successfully(): void
    {
        $this->actingAsUser();

        $response = $this->post('/admin/locations', [
            'name' => 'Stonehenge',
            'city' => 'Amesbury',
            'latitude' => 51.173972,
            'longitude' => -1.822377,
            'area_caption' => 'A prehistoric monument in Wiltshire, England.',
        ]);

        $response->assertRedirect('/admin/locations/'.Location::latest()->first()->slug);

        $this->assertDatabaseHas('locations', [
            'name' => 'Stonehenge',
            'city' => 'Amesbury',
        ]);
    }

    public function test_store_rejects_duplicate_location_name(): void
    {
        Location::factory()->create(['name' => 'Name Test']);

        $this->actingAsUser();

        $response = $this->post('/admin/locations', [
            'name' => 'Name Test',
            'city' => 'Different City',
            'latitude' => 56.197372,
            'longitude' => -3.223787,
            'area_caption' => 'A prehistoric monument in Wiltshire.',
        ]);

        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseCount('locations', 1);
    }

    // ==========================================
    // SHOW TESTS
    // ==========================================

    public function test_show_displays_location_details(): void
    {
        $location = Location::factory()->create(['name' => 'Stonehenge']);

        $this->actingAsUser();

        $response = $this->get("/admin/locations/{$location->slug}");

        $response->assertOk();
        $response->assertViewHas('location', fn ($viewLocation) => $viewLocation->id === $location->id);
    }

    // ==========================================
    // EDIT TESTS
    // ==========================================

    public function test_edit_form_loads_correct_model_and_all_locations(): void
    {
        $location = Location::factory()->create(['name' => 'Stonehenge']);
        $locationTwo = Location::factory()->create(['name' => 'Flamborough Head']);

        $this->actingAsUser();

        $response = $this->get("/admin/locations/{$location->slug}/edit");

        $response->assertOk();
        $response->assertViewHas('location', fn ($viewLocation) => $viewLocation->id === $location->id);
        $response->assertViewHas('allLocations', fn ($locations) => $locations->contains('id', $locationTwo->id));
    }

    // ==========================================
    // UPDATE TESTS
    // ==========================================

    public function test_update_modifies_location_successfully(): void
    {
        $location = Location::factory()->create(['name' => 'Wrong Name']);

        $this->actingAsUser();

        $response = $this->put("/admin/locations/{$location->slug}", [
            'name' => 'Stonehenge',
            'city' => 'Amesbury',
            'latitude' => 51.173972,
            'longitude' => -1.822377,
            'area_caption' => 'A prehistoric monument in Wiltshire, England.',
        ]);

        $response->assertRedirect('/admin/locations/stonehenge');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('locations', [
            'id' => $location->id,
            'name' => 'Stonehenge',
        ]);
    }

    public function test_update_rejects_duplicate_name(): void
    {
        $rivelinValley = Location::factory()->create(['name' => 'Rivelin Valley']);
        $westonPark = Location::factory()->create(['name' => 'Weston Park']);

        $this->actingAsUser();

        $response = $this->put("/admin/locations/{$westonPark->slug}", [
            'name' => 'Rivelin Valley',
            'city' => 'Sheffield',
            'latitude' => 53.382200,
            'longitude' => -1.490200,
            'area_caption' => 'A Victorian-era city park.',
        ]);

        $response->assertSessionHasErrors(['name' => 'The name has already been taken.']);
        $this->assertDatabaseCount('locations', 2);

        $this->assertDatabaseHas('locations', [
            'id' => $westonPark->id,
            'name' => 'Weston Park',
        ]);
        $this->assertDatabaseHas('locations', [
            'id' => $rivelinValley->id,
            'name' => 'Rivelin Valley',
        ]);
    }

    // ==========================================
    // DESTROY TESTS
    // ==========================================

    public function test_destroy_deletes_location_successfully(): void
    {
        $location = Location::factory()->create(['name' => 'Stonehenge']);

        $this->actingAsUser();

        $response = $this->delete("/admin/locations/{$location->slug}");

        $response->assertRedirect('/admin/locations');
        $response->assertSessionHas('success', 'Location deleted successfully.');

        $this->assertDatabaseMissing('locations', [
            'id' => $location->id,
        ]);
    }

    public function test_destroy_blocks_deletion_when_associated_media_exists(): void
    {
        $location = Location::factory()->create(['name' => 'Stonehenge']);
        $media = Media::class::factory()->create(['location_id' => $location->id]);

        $this->actingAsUser();

        $response = $this->delete("/admin/locations/{$location->slug}");

        $this->delete("/admin/locations/{$location->slug}")
            ->assertRedirect('/admin/locations')
            ->assertSessionHas(
                'error',
                'Cannot delete a location that still has media associated.'
            );

        $this->assertDatabaseHas('locations', [
            'id' => $location->id,
        ]);
    }
}
