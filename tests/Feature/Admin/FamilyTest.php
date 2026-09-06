<?php

namespace Tests\Feature\Admin;

use App\Models\Family;
use App\Models\Genus;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFamilyTest extends TestCase
{
    use RefreshDatabase;

    public function test_families_are_ordered_by_name(): void
    {
        $this->actingAsUser();

        Family::factory()->create(['family_name' => 'Accipitridae']);
        Family::factory()->create(['family_name' => 'Troglodytidae']);
        Family::factory()->create(['family_name' => 'Laridae']);

        $response = $this->get('/admin/families');

        $response->assertOk();

        $response->assertViewHas('taxa', function ($taxa) {
            return $taxa->pluck('family_name')->values()->all() === [
                'Accipitridae',
                'Laridae',
                'Troglodytidae',
            ];
        });
    }

    public function test_families_page_is_paginated(): void
    {
        $this->actingAsUser();

        Family::factory()->count(25)->create();

        $response = $this->get('/admin/families');

        $response->assertOk();

        $response->assertViewHas('taxa', function ($taxa) {
            return $taxa->count() === 20
                && $taxa->total() === 25
                && $taxa->lastPage() === 2;
        });
    }

    public function test_family_create_form_receives_orders_sorted_by_name(): void
    {
        $this->actingAsUser();

        Order::factory()->create(['order_name' => 'Strigiformes']);
        Order::factory()->create(['order_name' => 'Anseriformes']);
        Order::factory()->create(['order_name' => 'Falconiformes']);

        $response = $this->get('/admin/families/create');

        $response->assertOk();

        $response->assertViewHas('orders', function ($orders) {
            return array_values($orders) === [
                'Anseriformes',
                'Falconiformes',
                'Strigiformes',
            ];
        });
    }

    public function test_family_can_be_created_from_admin_form(): void
    {
        $order = Order::factory()->create([
            'order_name' => 'Passeriformes', ]);

        $this->actingAsUser();

        $response = $this->post('/admin/families', [
            'family_name' => 'Passeridae',
            'common_name' => 'Old World Sparrows',
            'order_id' => $order->id,
        ]);

        $response->assertRedirect('/admin/families/passeridae');

        $this->assertDatabaseHas('families', [
            'family_name' => 'Passeridae',
            'slug' => 'passeridae',
            'order_id' => $order->id,
        ]);
    }

    public function test_family_creation_rejects_duplicate_families(): void
    {

        $order = Order::factory()->create([
            'order_name' => 'Passeriformes', ]);

        Family::factory()->create([
            'family_name' => 'Passeridae',
            'order_id' => $order->id,
            'common_name' => 'Old World Sparrows']);

        $this->actingAsUser();

        $response = $this->post('/admin/families', [
            'family_name' => 'Passeridae',
            'common_name' => 'Old World Sparrows',
            'order_id' => $order->id,
        ]);

        $response->assertSessionHasErrors([
            'family_name' => 'The family name has already been taken.',
        ]);
        $this->assertDatabaseCount('families', 1);
    }

    public function test_family_page_displays_family_details(): void
    {
        $family = Family::factory()->create([
            'family_name' => 'Passeridae',
            'common_name' => 'Old World Sparrows',
        ]);

        $this->actingAsUser();

        $response = $this->get("/admin/families/{$family->slug}");

        $response->assertOk();

        $response->assertViewHas('family', function ($viewFamily) use ($family) {
            return $viewFamily->id === $family->id
                && $viewFamily->family_name === 'Passeridae';
        });
    }

    public function test_family_edit_page_displays_family_form(): void
    {

        $orderOne = Order::factory()->create(['order_name' => 'Passeriformes']);
        $orderTwo = Order::factory()->create(['order_name' => 'Falconiformes']);

        $family = Family::factory()->create([
            'family_name' => 'Passeridae',
            'common_name' => 'Old World Sparrows',
            'order_id' => $orderOne->id,
        ]);

        $this->actingAsUser();

        $response = $this->get("/admin/families/{$family->slug}/edit");

        $response->assertOk();

        $response->assertViewHas('family', function ($viewFamily) use ($family) {
            return $viewFamily->id === $family->id
                && $viewFamily->family_name === 'Passeridae';
        });

        $response->assertViewHas('orders', function ($orders) {
            return array_values($orders) === [
                'Falconiformes',
                'Passeriformes',
            ];
        });
    }

    // Change the name of the family and common name, and change the order_id to a different order
    public function test_family_allows_updates(): void
    {
        $orderOne = Order::factory()->create();
        $orderTwo = Order::factory()->create();

        $family = Family::factory()->create([
            'order_id' => $orderOne->id,
            'family_name' => 'Wrong Name',
            'common_name' => 'Wrong Common Name',
        ]);

        $this->actingAsUser();

        $response = $this->put("/admin/families/{$family->slug}", [
            'family_name' => 'Updated Name',
            'common_name' => 'Updated Common Name',
            'order_id' => $orderTwo->id,
        ]);

        $this->assertDatabaseHas('families', [
            'id' => $family->id,
            'family_name' => 'Updated Name',
            'common_name' => 'Updated Common Name',
            'order_id' => $orderTwo->id,
        ]);

        $this->assertDatabaseMissing('families', [
            'id' => $family->id,
            'family_name' => 'Wrong Name',
            'common_name' => 'Wrong Common Name',
            'order_id' => $orderOne->id,
        ]);

        $response->assertRedirect('/admin/families/updated-name');
        $response->assertSessionHas('success', 'Family updated successfully!');

    }

    public function test_family_rejects_edits_that_duplicates_families(): void
    {
        $order = Order::factory()->create();

        $familyOne = Family::factory()->create([
            'family_name' => 'Family One',
            'common_name' => 'Common One',
            'order_id' => $order->id,
        ]);

        $familyTwo = Family::factory()->create([
            'family_name' => 'Family Two',
            'common_name' => 'Common Two',
            'order_id' => $order->id,
        ]);

        $this->actingAsUser();

        $this->put("/admin/families/{$familyTwo->slug}", [
            'family_name' => 'Family One',
            'common_name' => 'Common One',
            'order_id' => $order->id,
        ])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'family_name' => 'The family name has already been taken.',
            ]);

        $this->assertDatabaseHas('families', [
            'id' => $familyOne->id,
            'family_name' => 'Family One',
        ]);

        $this->assertDatabaseHas('families', [
            'id' => $familyTwo->id,
            'family_name' => 'Family Two',
        ]);
    }

    public function test_family_can_be_deleted_when_it_has_no_genera(): void
    {
        $family = Family::factory()->create();

        $this->actingAsUser();

        $this->delete("/admin/families/{$family->slug}")
            ->assertRedirect('/admin/families')
            ->assertSessionHas(
                'success',
                'Family deleted successfully.'
            );

        $this->assertDatabaseMissing('families', [
            'id' => $family->id,
        ]);
    }

    public function test_family_cannot_be_deleted_when_it_has_genera(): void
    {
        $family = Family::factory()->create();

        Genus::factory()->create([
            'family_id' => $family->id,
        ]);

        $this->actingAsUser();

        $this->delete("/admin/families/{$family->slug}")
            ->assertRedirect('/admin/families')
            ->assertSessionHas(
                'error',
                'Cannot delete a family that still has genera.'
            );

        $this->assertDatabaseHas('families', [
            'id' => $family->id,
        ]);
    }
}
