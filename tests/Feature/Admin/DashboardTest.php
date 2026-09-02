<?php

namespace Tests\Feature\Admin;

use App\Models\Animal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_is_accessible_(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_admin_dashboard_requires_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_dashboard_displays_animal_count(): void
    {
        $user = User::factory()->create();
        Animal::factory()->count(6)->create();
        $this->actingAs($user);

        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);

        $response->assertViewHas('animalCount', 6);
    }

    public function test_admin_dashboard_collects_six_most_recently_added_birds(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        Animal::factory()->count(6)->create();

        $response = $this->get('/admin/dashboard');

        $response->assertViewHas('recentAnimals', function ($animals) {
            return $animals->count() === 6;
        });
    }
}
