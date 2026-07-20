<?php

namespace Tests\Feature\Admin;

use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use App\Models\User;
use App\Services\NasaImageService;
use App\Services\WordMapService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CorpoCelesteActionsTest extends AdminTestCase
{
    private CorpoCeleste $corpo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->corpo = CorpoCeleste::factory()->create();
    }

    public function test_suggest_nome_requires_at_least_one_name(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.corpi-celesti.suggest-nome'), []);

        $decoded = json_decode($response->content(), true);
        $this->assertNotNull($decoded, 'Response should be valid JSON');
        $this->assertFalse($decoded['success'] ?? true);
        $this->assertEquals('Inserisci almeno un nome.', $decoded['message'] ?? '');
    }

    public function test_suggest_nome_returns_suggestion_when_nasa_matches(): void
    {
        Cache::flush();

        $mock = \Mockery::mock(NasaImageService::class);
        $mock->shouldReceive('searchNasa')
            ->once()
            ->with('Jupiter')
            ->andReturn([
                'success' => true,
                'items' => [
                    [
                        'data' => [
                            [
                                'title' => 'Jupiter',
                                'keywords' => ['planet', 'Jupiter'],
                            ],
                        ],
                    ],
                ],
            ]);
        $this->app->instance(NasaImageService::class, $mock);

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.corpi-celesti.suggest-nome'), ['nome' => 'Giove']);

        $response->assertOk()
            ->assertJson(['success' => true, 'nome_en' => 'Jupiter']);
    }

    public function test_suggest_nome_returns_failure_when_no_results(): void
    {
        Cache::flush();

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.corpi-celesti.suggest-nome'), ['nome' => 'Xyznotexist']);

        $response->assertOk()
            ->assertJson(['success' => false, 'needs_manual' => true]);
    }

    public function test_suggest_nome_guest_cannot_access(): void
    {
        $response = $this->postJson(route('admin.corpi-celesti.suggest-nome'), ['nome' => 'Giove']);

        $response->assertRedirect();
    }

    public function test_set_image_from_gallery_updates_immagine(): void
    {
        $galleria = GalleriaCorpo::factory()->for($this->corpo)->create([
            'percorso' => 'new-image.jpg',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.corpi-celesti.set-image', [$this->corpo, $galleria]));

        $response->assertRedirect(route('admin.corpi-celesti.show', $this->corpo));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('corpi_celesti', [
            'id' => $this->corpo->id,
            'immagine' => 'new-image.jpg',
            'immagine_utente' => true,
        ]);
    }

    public function test_set_image_from_gallery_rejects_wrong_ownership(): void
    {
        $otherCorpo = CorpoCeleste::factory()->create();
        $galleria = GalleriaCorpo::factory()->for($otherCorpo)->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.corpi-celesti.set-image', [$this->corpo, $galleria]));

        $response->assertNotFound();
    }

    public function test_set_image_guest_cannot_access(): void
    {
        $galleria = GalleriaCorpo::factory()->for($this->corpo)->create();

        $response = $this->post(route('admin.corpi-celesti.set-image', [$this->corpo, $galleria]));

        $response->assertRedirect('/login');
    }

    public function test_set_image_non_admin_cannot_access(): void
    {
        $nonAdmin = User::factory()->create(['is_admin' => false]);
        $galleria = GalleriaCorpo::factory()->for($this->corpo)->create();

        $response = $this->actingAs($nonAdmin)
            ->post(route('admin.corpi-celesti.set-image', [$this->corpo, $galleria]));

        $response->assertForbidden();
    }

    public function test_set_image_from_gallery_with_remote_url(): void
    {
        $remoteUrl = 'https://example.com/nasa-image.jpg';
        $galleria = GalleriaCorpo::factory()->for($this->corpo)->create([
            'percorso' => $remoteUrl,
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.corpi-celesti.set-image', [$this->corpo, $galleria]));

        $response->assertRedirect(route('admin.corpi-celesti.show', $this->corpo));

        $this->assertDatabaseHas('corpi_celesti', [
            'id' => $this->corpo->id,
            'immagine' => $remoteUrl,
            'immagine_utente' => true,
        ]);
    }

    public function test_set_image_flash_message_content(): void
    {
        $galleria = GalleriaCorpo::factory()->for($this->corpo)->create([
            'percorso' => 'updated.jpg',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.corpi-celesti.set-image', [$this->corpo, $galleria]));

        $response->assertSessionHas('success', 'Immagine principale aggiornata con successo.');
    }

    public function test_suggest_nome_non_admin_can_access(): void
    {
        Cache::flush();

        $nonAdmin = User::factory()->create(['is_admin' => false]);

        $mock = \Mockery::mock(NasaImageService::class);
        $mock->shouldReceive('searchNasa')
            ->once()
            ->with('Jupiter')
            ->andReturn([
                'success' => true,
                'items' => [
                    [
                        'data' => [
                            [
                                'title' => 'Jupiter',
                                'keywords' => ['planet'],
                            ],
                        ],
                    ],
                ],
            ]);
        $this->app->instance(NasaImageService::class, $mock);

        $response = $this->actingAs($nonAdmin)
            ->postJson(route('admin.corpi-celesti.suggest-nome'), ['nome' => 'Giove']);

        $response->assertOk()
            ->assertJson(['success' => true, 'nome_en' => 'Jupiter']);
    }

    public function test_suggest_nome_returns_consistent_results(): void
    {
        Cache::flush();

        $mock = \Mockery::mock(NasaImageService::class);
        $mock->shouldReceive('searchNasa')
            ->times(2)
            ->with('Jupiter')
            ->andReturn([
                'success' => true,
                'items' => [
                    [
                        'data' => [
                            [
                                'title' => 'Jupiter',
                                'keywords' => ['planet', 'Jupiter'],
                            ],
                        ],
                    ],
                ],
            ]);
        $this->app->instance(NasaImageService::class, $mock);

        $this->actingAs($this->admin)
            ->postJson(route('admin.corpi-celesti.suggest-nome'), ['nome' => 'Giove'])
            ->assertOk();

        $this->actingAs($this->admin)
            ->postJson(route('admin.corpi-celesti.suggest-nome'), ['nome' => 'Giove'])
            ->assertOk()
            ->assertJson(['success' => true, 'nome_en' => 'Jupiter']);
    }

    public function test_suggest_nome_returns_manual_when_translation_fails(): void
    {
        Cache::flush();

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.corpi-celesti.suggest-nome'), ['nome' => 'Xnotreal']);

        $response->assertOk()
            ->assertJson([
                'success' => false,
                'needs_manual' => true,
                'message' => 'Impossibile tradurre automaticamente. Inserisci il nome inglese manualmente.',
            ]);
    }
}
