<?php

namespace Tests\Feature\Admin;

use App\Models\Animal;
use App\Models\Family;
use App\Models\Genus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenusTest extends TestCase
{
    use RefreshDatabase;

    public function test_genera_are_ordered_by_name(): void
    {
        $this->actingAsUser();

        Genus::factory()->create(['genus_name' => 'Tyto']);
        Genus::factory()->create(['genus_name' => 'Aix']);
        Genus::factory()->create(['genus_name' => 'Columba']);

        $response = $this->get('/admin/genera');

        $response->assertOk();

        $response->assertViewHas('taxa', function ($taxa) {
            return $taxa->pluck('genus_name')->values()->all() === [
                'Aix',
                'Columba',
                'Tyto',
            ];
        });
    }

    public function test_genera_pages_are_paginated(): void
    {
        $this->actingAsUser();

        Genus::factory()->count(25)->create();

        $response = $this->get('/admin/genera');

        $response->assertOk();

        $response->assertViewHas('taxa', function ($taxa) {
            return $taxa->count() === 20
                && $taxa->total() === 25
                && $taxa->lastPage() === 2;
        });
    }

    public function test_genus_create_page_displays_family_form(): void
    {
        $this->actingAsUser();

        $response = $this->get('/admin/genera/create');

        $response->assertOk();
        $response->assertViewHas('genus');
    }

    public function test_genus_create_form_receives_families_sorted_by_name(): void
    {
        $this->actingAsUser();

        Family::factory()->create(['family_name' => 'Accipitridae']);
        Family::factory()->create(['family_name' => 'Troglodytidae']);
        Family::factory()->create(['family_name' => 'Laridae']);

        $response = $this->get('/admin/genera/create');

        $response->assertOk();

        $response->assertViewHas('families', function ($families) {
            return array_values($families) === [
                'Accipitridae',
                'Laridae',
                'Troglodytidae',
            ];
        });
    }

    public function test_genus_can_be_created_from_admin_form(): void
    {
        $family = Family::factory()->create([
            'family_name' => 'Passeridae',
        ]);

        $this->actingAsUser();

        $response = $this->post('/admin/genera', [
            'genus_name' => 'Passer',
            'family_id' => $family->id,
        ]);

        $response->assertRedirect('/admin/genera/passer');

        $this->assertDatabaseHas('genera', [
            'genus_name' => 'Passer',
            'family_id' => $family->id,
            'slug' => 'passer',
        ]);
    }

    public function test_genus_creation_rejects_duplicate_genera(): void
    {

        $family = Family::factory()->create([
            'family_name' => 'Passeridae',
        ]);

        Genus::factory()->create([
            'genus_name' => 'Passer',
            'family_id' => $family->id,
        ]);

        $this->actingAsUser();

        $response = $this->post('/admin/genera', [
            'genus_name' => 'Passer',
            'family_id' => $family->id,
        ]);

        $response->assertSessionHasErrors([
            'genus_name' => 'The genus name has already been taken.',
        ]);
        $this->assertDatabaseCount('genera', 1);
    }

    public function test_genus_page_displays_genus_details(): void
    {
        $family = Family::factory()->create([
            'family_name' => 'Passeridae',
        ]);
        $genus = Genus::factory()->create([
            'genus_name' => 'Passer',
            'family_id' => $family->id,
        ]);

        $this->actingAsUser();

        $response = $this->get("/admin/genera/{$genus->slug}");

        $response->assertOk();

        $response->assertViewHas('genus', function ($viewGenus) use ($genus) {
            return $viewGenus->id === $genus->id
                && $viewGenus->family->family_name === 'Passeridae';
        });
    }

    public function test_genus_edit_page_displays_genus_form(): void
    {

        $familyOne = Family::factory()->create(['family_name' => 'Laridae']);
        Family::factory()->create(['family_name' => 'Falconidae']);

        $genus = Genus::factory()->create([
            'genus_name' => 'Passer',
            'family_id' => $familyOne->id,
        ]);

        $this->actingAsUser();

        $response = $this->get("/admin/genera/{$genus->slug}/edit");

        $response->assertOk();

        $response->assertViewHas('genus', function ($viewGenus) use ($genus) {
            return $viewGenus->id === $genus->id
                && $viewGenus->genus_name === 'Passer';
        });

        $response->assertViewHas('families', function ($families) {
            return array_values($families) === [
                'Falconidae',
                'Laridae',
            ];
        });
    }

    // Change the name of the genus and change the family_id to a different family
    public function test_genus_allows_updates(): void
    {
        $familyOne = Family::factory()->create();
        $familyTwo = Family::factory()->create();

        $genus = Genus::factory()->create([
            'genus_name' => 'Wrong Name',
            'family_id' => $familyOne->id,
        ]);

        $this->actingAsUser();

        $response = $this->put("/admin/genera/{$genus->slug}", [
            'genus_name' => 'Updated Name',
            'family_id' => $familyTwo->id,
        ]);

        $this->assertDatabaseHas('genera', [
            'id' => $genus->id,
            'genus_name' => 'Updated Name',
            'family_id' => $familyTwo->id,
        ]);

        $this->assertDatabaseMissing('genera', [
            'id' => $genus->id,
            'genus_name' => 'Wrong Name',
            'family_id' => $familyOne->id,
        ]);

        $response->assertRedirect('/admin/genera/updated-name');
        $response->assertSessionHas('success', 'Genus updated successfully!');
    }

    public function test_genus_rejects_edits_that_duplicates_genera(): void
    {
        $family = Family::factory()->create();

        $genusOne = Genus::factory()->create([
            'genus_name' => 'Genus One',
            'family_id' => $family->id,
        ]);

        $genusTwo = Genus::factory()->create([
            'genus_name' => 'Genus Two',
            'family_id' => $family->id,
        ]);

        $this->actingAsUser();

        $this->put("/admin/genera/{$genusTwo->slug}", [
            'genus_name' => 'Genus One',
            'family_id' => $family->id,
        ])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'genus_name' => 'The genus name has already been taken.',
            ]);

        $this->assertDatabaseHas('genera', [
            'id' => $genusOne->id,
            'genus_name' => 'Genus One',
        ]);

        $this->assertDatabaseHas('genera', [
            'id' => $genusTwo->id,
            'genus_name' => 'Genus Two',
        ]);
    }

    public function test_genus_can_be_deleted_when_it_has_no_species(): void
    {
        $genusOne = Genus::factory()->create();

        $this->actingAsUser();

        $this->delete("/admin/genera/{$genusOne->slug}")
            ->assertRedirect('/admin/genera')
            ->assertSessionHas(
                'success',
                'Genus deleted successfully.'
            );

        $this->assertDatabaseMissing('genera', [
            'id' => $genusOne->id,
        ]);
    }

    public function test_genus_cannot_be_deleted_when_it_has_species(): void
    {
        $genus = Genus::factory()->create();
        Animal::factory()->create([
            'genus_id' => $genus->id,
        ]);

        $this->actingAsUser();

        $this->delete("/admin/genera/{$genus->slug}")
            ->assertRedirect('/admin/genera')
            ->assertSessionHas(
                'error',
                'Cannot delete a genus that still has species.'
            );

        $this->assertDatabaseHas('genera', [
            'id' => $genus->id,
        ]);
    }
}
