<?php

namespace Tests\Feature\Api;

use App\Models\Missione;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MissioneApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake();
    }

    public function test_index_returns_all_missioni(): void
    {
        Missione::factory(3)->create();

        $response = $this->getJson('/api/missioni');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));
    }

    public function test_show_returns_missione(): void
    {
        $missione = Missione::factory()->create();

        $response = $this->getJson("/api/missioni/{$missione->slug}");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['id', 'nome', 'slug', 'agenzia']]);
        $this->assertEquals($missione->slug, $response->json('data.slug'));
    }

    public function test_show_returns_404_for_invalid_slug(): void
    {
        $response = $this->getJson('/api/missioni/non-existent');

        $response->assertStatus(404);
    }
}
