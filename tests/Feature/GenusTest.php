<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\Family;
use App\Models\Genus;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenusTest extends TestCase
{
    use RefreshDatabase;

    public function test_genus_can_be_created(): void
    {
        $family = Family::factory()->create();

        $genus = Genus::factory()->create([
            'family_id' => $family->id,
            'genus_name' => 'Passer',
        ]);

        $this->assertDatabaseHas('genera', [
            'id' => $genus->id,
            'family_id' => $family->id,
            'genus_name' => 'Passer',
        ]);

        $this->assertTrue($genus->family->is($family));
    }

    public function test_genus_slug_is_generated_from_genus_name(): void
    {
        $genus = Genus::factory()->create([
            'genus_name' => 'Test Genus',
        ]);

        $this->assertEquals('test-genus', $genus->slug);
    }

    public function test_genus_belongs_to_family(): void
    {
        $family = Family::factory()->create();

        $genus = Genus::factory()->create([
            'family_id' => $family->id,
        ]);

        $this->assertTrue($genus->family->is($family));
    }

    public function test_genus_has_many_animals(): void
    {

        $genus = Genus::factory()->create();

        $animalOne = Animal::factory()->create(['genus_id' => $genus->id]);
        $animalTwo = Animal::factory()->create(['genus_id' => $genus->id]);

        $this->assertTrue($genus->animals->contains($animalOne));
        $this->assertTrue($genus->animals->contains($animalTwo));
        $this->assertCount(2, $genus->animals);
    }

    public function test_genus_creates_title_attribute(): void
    {
        $genus = Genus::factory()->create([
            'genus_name' => 'Passer',
        ]);

        $this->assertEquals('Passer', $genus->title);
    }

    public function test_genus_creates_subtitle_attribute(): void
    {
        $order = Order::factory()->create([
            'order_name' => 'Passeriformes',
        ]);

        $family = Family::factory()->create([
            'order_id' => $order->id,
            'family_name' => 'Passeridae',
        ]);

        $genus = Genus::factory()->create([
            'family_id' => $family->id,
            'genus_name' => 'Passer',
        ]);

        $this->assertEquals('Passeriformes → Passeridae → Passer', $genus->subtitle);
    }

    public function test_genus_uses_slug_for_route_key(): void
    {
        $genus = Genus::factory()->create();

        $this->assertEquals('slug', $genus->getRouteKeyName());
    }
}
