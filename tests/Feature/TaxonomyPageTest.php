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

        $response = $this->get('/api/taxonomy');
        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
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
            ],
            'meta' => [
                'include_genera' => false,
            ],
        ]);
    }

    public function test_taxonomy_returns_animals_with_genera(): void
    {
        $order = Order::factory()->create(['order_name' => 'Test Order']);
        $family = Family::factory()->create([
            'family_name' => 'Test Family',
            'order_id' => $order->id,
            'common_name' => 'Test Common Name']);
        $genus = Genus::factory()->create(['family_id' => $family->id, 'genus_name' => 'Test Genus']);

        Animal::factory()->create(['common_name' => 'Test Bird', 'scientific_name' => 'Testus birdus', 'genus_id' => $genus->id]);

        $response = $this->getJson('/api/taxonomy?include_genera=true');
        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
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
            ],
            'meta' => [
                'include_genera' => true,
            ],
        ]);
    }

    public function test_taxonomy_returns_empty_tree_by_default(): void
    {
        $response = $this->getJson('/api/taxonomy');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'name' => 'Aves',
                'details' => 'Birds',
                'children' => [],
            ],
            'meta' => [
                'include_genera' => false,
            ],
        ]);
    }


    public function test_taxonomy_returns_empty_tree_with_genera(): void
    {
        $response = $this->getJson('/api/taxonomy?include_genera=true');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'name' => 'Aves',
                'details' => 'Birds',
                'children' => [],
            ],
            'meta' => [
                'include_genera' => true,
            ],
        ]);
    }


    public function test_taxonomy_rejects_invalid_include_genera(): void
    {
        $response = $this->getJson('/api/taxonomy?include_genera=laravel');

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'include_genera',
        ]);
    }

}
