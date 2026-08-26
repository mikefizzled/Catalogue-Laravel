<?php

namespace Tests\Feature;

use App\Models\Family;
use App\Models\Genus;
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
}
