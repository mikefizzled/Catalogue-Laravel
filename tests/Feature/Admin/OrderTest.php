<?php

namespace Tests\Feature\Admin;

use App\Models\Family;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_orders_are_ordered_by_name(): void
    {
        $this->actingAsUser();

        Order::factory()->create(['order_name' => 'Strigiformes']);
        Order::factory()->create(['order_name' => 'Anseriformes']);
        Order::factory()->create(['order_name' => 'Falconiformes']);

        $response = $this->get('/admin/orders');

        $response->assertOk();

        $response->assertViewHas('taxa', function ($taxa) {
            return $taxa->pluck('order_name')->values()->all() === [
                'Anseriformes',
                'Falconiformes',
                'Strigiformes',
            ];
        });
    }

    public function test_orders_page_is_paginated(): void
    {
        $this->actingAsUser();

        Order::factory()->count(25)->create();

        $response = $this->get('/admin/orders');

        $response->assertOk();

        $response->assertViewHas('taxa', function ($taxa) {
            return $taxa->count() === 20
                && $taxa->total() === 25
                && $taxa->lastPage() === 2;
        });
    }

    public function test_order_create_page_displays_order_form(): void
    {
        $this->actingAsUser();

        $response = $this->get('/admin/orders/create');

        $response->assertOk();
        $response->assertViewIs('admin.orders.create');
    }

    public function test_order_can_be_created_from_admin_form(): void
    {
        $this->actingAsUser();

        $response = $this->post('/admin/orders', [
            'order_name' => 'Passeriformes',
        ]);

        $response->assertRedirect('/admin/orders/passeriformes');

        $this->assertDatabaseHas('orders', [
            'order_name' => 'Passeriformes',
            'slug' => 'passeriformes',
        ]);
    }

    public function test_admin_order_rejects_duplicate_orders(): void
    {
        Order::factory()->create(['order_name' => 'Passeriformes']);

        $this->actingAsUser();

        $response = $this->post('/admin/orders', [
            'order_name' => 'Passeriformes',
        ]);

        $response->assertSessionHasErrors([
            'order_name' => 'The order name has already been taken.',
        ]);
        $this->assertDatabaseCount('orders', 1);
    }

    public function test_order_page_displays_order_details(): void
    {
        $order = Order::factory()->create([
            'order_name' => 'Passeriformes',
        ]);
        $family = Family::factory()->create([
            'order_id' => $order->id,
        ]);

        $this->actingAsUser();

        $response = $this->get("/admin/orders/{$order->slug}");

        $response->assertOk();

        $response->assertViewHas('order', function ($viewOrder) use ($order, $family) {
            return $viewOrder->id === $order->id
                && $viewOrder->order_name === 'Passeriformes'
                && $viewOrder->families->contains('id', $family->id);
        });
    }

    public function test_order_edit_page_displays_order_form(): void
    {
        $order = Order::factory()->create([
            'order_name' => 'Passeriformes',
        ]);

        $this->actingAsUser();

        $response = $this->get("/admin/orders/{$order->slug}/edit");

        $response->assertOk();

        $response->assertViewHas('order', function ($viewOrder) use ($order) {
            return $viewOrder->id === $order->id
                && $viewOrder->order_name === 'Passeriformes';
        });
    }

    public function test_admin_order_updates_orders(): void
    {
        $order = Order::factory()->create(['order_name' => 'Initial Name']);

        $this->actingAsUser();

        $updatedOrder = ['order_name' => 'Updated Name'];

        $this->put("/admin/orders/{$order->slug}", $updatedOrder)
            ->assertStatus(302)
            ->assertSessionHas('success', 'Order updated successfully!');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'order_name' => 'Updated Name',
        ]);

        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
            'order_name' => 'Initial Name',
        ]);

    }

    public function test_admin_order_rejects_edits_that_duplicate_orders(): void
    {
        $order = Order::factory()->create([
            'order_name' => 'Order One',
        ]);

        Order::factory()->create([
            'order_name' => 'Order Two',
        ]);

        $this->actingAsUser();

        $this->put("/admin/orders/{$order->slug}", [
            'order_name' => 'Order Two',
        ])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'order_name' => 'The order name has already been taken.',
            ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'order_name' => 'Order One',
        ]);
    }

    public function test_admin_order_can_be_deleted_when_it_has_no_families(): void
    {
        $order = Order::factory()->create();

        $this->actingAsUser();

        $this->delete("/admin/orders/{$order->slug}")
            ->assertRedirect('/admin/orders')
            ->assertSessionHas(
                'success',
                'Order deleted successfully.'
            );

        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);
    }

    public function test_admin_order_cannot_be_deleted_when_it_has_families(): void
    {
        $order = Order::factory()->create();

        Family::factory()->create([
            'order_id' => $order->id,
        ]);

        $this->actingAsUser();

        $this->delete("/admin/orders/{$order->slug}")
            ->assertRedirect('/admin/orders')
            ->assertSessionHas(
                'error',
                'Cannot delete an order that still has families.'
            );

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
        ]);
    }
}
