<?php

namespace Tests\Feature;

use App\Models\Family;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FamilyTest extends TestCase
{
    use RefreshDatabase;

    public function test_family_can_be_created(): void
    {
        $order = Order::factory()->create();

        $family = Family::factory()->create([
            'order_id' => $order->id,
            'family_name' => 'Passeridae',
            'common_name' => 'Old World Sparrows',
        ]);

        $this->assertDatabaseHas('families', [
            'id' => $family->id,
            'order_id' => $order->id,
            'family_name' => 'Passeridae',
            'common_name' => 'Old World Sparrows',
        ]);

        $this->assertTrue($family->order->is($order));
    }

    public function test_family_slug_is_generated_from_family_name(): void
    {
        $family = Family::factory()->create([
            'family_name' => 'Test Family',
        ]);

        $this->assertEquals('test-family', $family->slug);
    }
}
