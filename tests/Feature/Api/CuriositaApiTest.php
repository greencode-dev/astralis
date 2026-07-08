<?php

namespace Tests\Feature\Api;

use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\Curiosita;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CuriositaApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake();
    }

    public function test_index_returns_all_curiosita(): void
    {
        $categoria = Categoria::factory()->create();
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => $categoria->id]);
        Curiosita::factory(3)->create(['corpo_celeste_id' => $corpo->id]);

        $response = $this->getJson('/api/curiosita');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));
    }
}
