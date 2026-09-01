<?php

namespace Tests\Feature;

use Database\Seeders\ConservationListSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConservationPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_conservation_page_collects_reports(): void
    {
        $this->seed(ConservationListSeeder::class);
        $response = $this->get('/conservation');

        $response->assertStatus(200);
        $response->assertSee('Conservation Data Sourcing');

        $response->assertSeeInOrder([
            'BoCC1',
            'BoCC2',
            'BoCC3',
            'BoCC4',
            'BoCC5',
            'BoCC5a',
        ]);
    }
}
