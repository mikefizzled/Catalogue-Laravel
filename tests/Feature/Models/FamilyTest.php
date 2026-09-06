<?php

namespace Tests\Feature\Models;

use App\Models\Family;
use App\Models\Genus;
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

    public function test_family_belongs_to_order(): void
    {
        $order = Order::factory()->create();

        $family = Family::factory()->create([
            'order_id' => $order->id,
        ]);

        $this->assertTrue($family->order->is($order));
    }

    public function test_family_has_many_genera(): void
    {

        $family = Family::factory()->create();

        $genusOne = Genus::factory()->create(['family_id' => $family->id]);
        $genusTwo = Genus::factory()->create(['family_id' => $family->id]);

        $this->assertTrue($family->genera->contains($genusOne));
        $this->assertTrue($family->genera->contains($genusTwo));
        $this->assertCount(2, $family->genera);
    }

    public function test_family_creates_title_attribute(): void
    {
        $family = Family::factory()->create([
            'family_name' => 'Passeridae',
            'common_name' => 'Old World Sparrows',
        ]);

        $this->assertEquals('Passeridae (Old World Sparrows)', $family->title);
    }

    public function test_family_creates_subtitle_attribute(): void
    {
        $order = Order::factory()->create([
            'order_name' => 'Passeriformes',
        ]);

        $family = Family::factory()->create([
            'order_id' => $order->id,
            'family_name' => 'Passeridae',
        ]);

        $this->assertEquals('Passeriformes → Passeridae', $family->subtitle);
    }

    public function test_family_uses_slug_for_route_key(): void
    {
        $family = Family::factory()->create();

        $this->assertEquals('slug', $family->getRouteKeyName());
    }

    public function test_families_are_ordered_by_name(): void
    {
        Family::factory()->create(['family_name' => 'Paridae']);
        Family::factory()->create(['family_name' => 'Corvidae']);
        Family::factory()->create(['family_name' => 'Troglodytidae']);

        $families = Family::orderedByName()->get();

        $this->assertEquals(
            ['Corvidae', 'Paridae', 'Troglodytidae'],
            $families->pluck('family_name')->toArray()
        );
    }
}
