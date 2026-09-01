<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\Family;
use App\Models\Genus;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimalPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_birds_list_is_accessible(): void
    {
        Animal::factory()->create([
            'common_name' => 'Test Bird',
        ]);

        $response = $this->get('/birds');

        $response->assertStatus(200);

        $response->assertSee('Birds List');
        $response->assertSee('Test Bird');
    }

    public function test_birds_list_pagination(): void
    {
        Animal::factory()->count(35)->create();

        $response = $this->get('/birds');

        $response->assertStatus(200);

        $response->assertViewHas('animals', function ($animals) {
            return $animals->count() === 30
                && $animals->total() === 35
                && $animals->lastPage() === 2;
        });

        $response = $this->get('/birds?page=2');
        $response->assertStatus(200);
        $response->assertViewHas('animals', function ($animals) {
            return $animals->count() === 5;
        });
    }

    public function test_birds_list_is_ordered_by_common_name(): void
    {
        Animal::factory()->create(['common_name' => 'Tree Sparrow']);
        Animal::factory()->create(['common_name' => 'Blackbird']);
        Animal::factory()->create(['common_name' => 'Robin']);

        $response = $this->get('/birds');
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'Blackbird',
            'Robin',
            'Tree Sparrow',
        ]);
    }

    public function test_birds_are_retrieved_by_family(): void
    {
        $familyOne = Family::factory()->create();
        $familyTwo = Family::factory()->create();

        $genusOne = Genus::factory()->create([
            'family_id' => $familyOne->id,
        ]);

        $genusTwo = Genus::factory()->create([
            'family_id' => $familyTwo->id,
        ]);

        Animal::factory()->create([
            'genus_id' => $genusOne->id,
            'common_name' => 'Family One Bird',
        ]);

        Animal::factory()->create([
            'genus_id' => $genusTwo->id,
            'common_name' => 'Family Two Bird',
        ]);

        $response = $this->get('/birds?family='.$familyOne->slug);
        $response->assertStatus(200);
        $response->assertSee('Family One Bird');
        $response->assertDontSee('Family Two Bird');
    }

    public function test_birds_list_retrieves_orders_in_alphabetical_order(): void
    {

        Order::factory()->create(['order_name' => 'Suliformes']);
        Order::factory()->create(['order_name' => 'Anseriformes']);
        Order::factory()->create(['order_name' => 'Galliformes']);

        $response = $this->get('/birds');
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'Anseriformes',
            'Galliformes',
            'Suliformes',
        ]);
    }

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
