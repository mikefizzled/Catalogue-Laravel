<?php

namespace Tests\Feature;

use App\Models\Animal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SingleBirdPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_single_bird_page_retrieves_from_slug(): void
    {
        $bird = Animal::factory()->create([
            'common_name' => 'Test Bird',
            'scientific_name' => 'Testus birdus',
        ]);

        $response = $this->get('/birds/'.$bird->slug);

        $response->assertStatus(200);
        $response->assertSee('Test Bird');
        $response->assertSee('Testus birdus');
    }

    public function test_single_bird_returns_404_on_unknown_bird(): void
    {
        $response = $this->get('/birds/php-laravel');

        $response->assertStatus(404);
        $response->assertSee('This page is proving elusive');
        $response->assertSee('Fly Home');
    }
}
