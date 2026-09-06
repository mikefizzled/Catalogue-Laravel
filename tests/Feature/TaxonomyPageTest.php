<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\Family;
use App\Models\Genus;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaxonomyPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_json_response_without_genera(): void
    {
        $order = Order::factory()->create(['order_name' => 'Test Order']);
        $family = Family::factory()->create([
            'family_name' => 'Test Family',
            'order_id' => $order->id,
            'common_name' => 'Test Common Name']);
        $genus = Genus::factory()->create(['family_id' => $family->id]);

        Animal::factory()->create(['common_name' => 'Test Bird', 'scientific_name' => 'Testus birdus', 'genus_id' => $genus->id]);

        $response = $this->get('/taxonomy-json-without-genera');
        $response->assertStatus(200);

        $response->assertJson([
            'name' => 'Aves',
            'details' => 'Birds',
            'children' => [
                [
                    'name' => 'Test Order',
                    'children' => [
                        [
                            'name' => 'Test Family',
                            'details' => 'Test Common Name',
                            'children' => [
                                [
                                    'name' => 'Test Bird',
                                    'url' => '/birds/test-bird',
                                    'details' => 'Testus birdus',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function test_json_response_with_genera(): void
    {
        $order = Order::factory()->create(['order_name' => 'Test Order']);
        $family = Family::factory()->create([
            'family_name' => 'Test Family',
            'order_id' => $order->id,
            'common_name' => 'Test Common Name']);
        $genus = Genus::factory()->create(['family_id' => $family->id, 'genus_name' => 'Test Genus']);

        Animal::factory()->create(['common_name' => 'Test Bird', 'scientific_name' => 'Testus birdus', 'genus_id' => $genus->id]);

        $response = $this->get('/taxonomy-json-with-genera');
        $response->assertStatus(200);

        $response->assertJson([
            'name' => 'Aves',
            'details' => 'Birds',
            'children' => [
                [
                    'name' => 'Test Order',
                    'children' => [
                        [
                            'name' => 'Test Family',
                            'details' => 'Test Common Name',
                            'children' => [
                                [
                                    'name' => 'Test Genus',
                                    'children' => [
                                        [
                                            'name' => 'Test Bird',
                                            'url' => '/birds/test-bird',
                                            'details' => 'Testus birdus',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function test_taxonomy_without_genera_returns_default_json(): void
    {

        $response = $this->get('/taxonomy-json-without-genera');

        $response->assertStatus(200);
        $response->assertJson([
            'name' => 'Aves',
            'details' => 'Birds',
            'children' => [],
        ]);
    }

    public function test_taxonomy_with_genera_returns_default_json(): void
    {

        $response = $this->get('/taxonomy-json-with-genera');

        $response->assertStatus(200);
        $response->assertJson([
            'name' => 'Aves',
            'details' => 'Birds',
            'children' => [],
        ]);
    }
}
