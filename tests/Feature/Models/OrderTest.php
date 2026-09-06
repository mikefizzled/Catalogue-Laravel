<?php

namespace Tests\Feature\Models;

use App\Models\Family;
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

    public function test_order_has_many_families(): void
    {
        $order = Order::factory()->create();

        $order->getRouteKeyName();
        $familyOne = Family::factory()->create(
            [
                'order_id' => $order->id,
            ]);
        $familyTwo = Family::factory()->create(
            [
                'order_id' => $order->id,
            ]);

        $this->assertTrue($order->families->contains($familyOne));
        $this->assertTrue($order->families->contains($familyTwo));
        $this->assertCount(2, $order->families);
    }

    public function test_order_generates_title(): void
    {
        $order = Order::factory()->create(
            ['order_name' => 'Test Order']);

        $this->assertEquals('Test Order', $order->title);
    }
}
