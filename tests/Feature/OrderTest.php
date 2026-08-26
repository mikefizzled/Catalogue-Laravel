<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_can_be_created(): void
    {

        $order = Order::factory()->create([
            'order_name' => 'Passeriformes',
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'order_name' => 'Passeriformes',
            'slug' => 'passeriformes',
        ]);
    }

    public function test_order_slug_is_generated_from_order_name(): void
    {
        $order = Order::factory()->create([
            'order_name' => 'Test Order',
        ]);

        $this->assertEquals('test-order', $order->slug);
    }
}
