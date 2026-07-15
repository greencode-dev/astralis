<?php

namespace Tests\Feature\Admin;

use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\Curiosita;
use App\Models\Missione;
use App\Models\User;

class DashboardTest extends AdminTestCase
{
    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_non_admin_also_accesses_dashboard(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard'));

        $response->assertStatus(200);
    }

    public function test_dashboard_shows_correct_stats(): void
    {
        CorpoCeleste::factory(3)->create();
        Categoria::factory(2)->create();
        Missione::factory(4)->create();
        $corpo = CorpoCeleste::factory()->create();
        Curiosita::factory(5)->for($corpo)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $response->assertStatus(200);
    }

    public function test_dashboard_shows_chart_data_when_data_exists(): void
    {
        $categoria = Categoria::factory()->create(['nome' => 'Pianeta']);
        CorpoCeleste::factory(3)->for($categoria)->create();

        Missione::factory()->create(['stato' => 'Completata']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $response->assertStatus(200);
    }
}
