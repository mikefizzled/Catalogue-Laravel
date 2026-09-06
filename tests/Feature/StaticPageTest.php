<?php

namespace Tests\Feature;

use Tests\TestCase;

class StaticPageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_home_page_can_be_viewed(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Documenting UK Bird Species and Conservation Status');
    }

    public function test_about_page_can_be_viewed(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('About The Project');
    }

    public function test_changelog_page_can_be_viewed(): void
    {
        $response = $this->get('/changelog');
        $response->assertSee('Changes');
        $response->assertStatus(200);
    }

    public function test_non_existent_page_returns_404(): void
    {
        $response = $this->get('/test-address');

        $response->assertStatus(404);
        $response->assertSee('This page is proving elusive');
        $response->assertSee('Fly Home');
    }
}
