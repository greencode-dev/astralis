<?php

namespace Tests\Unit;

use App\Models\CorpoCeleste;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CorpoCelesteTest extends TestCase
{
    use RefreshDatabase;

    public function test_nome_returns_italian_name(): void
    {
        $corpo = CorpoCeleste::factory()->create([
            'nome' => 'Giove',
            'nome_en' => 'Jupiter',
        ]);

        $this->assertEquals('Giove', $corpo->nome);
    }

    public function test_nome_en_returns_english_name_when_set(): void
    {
        $corpo = CorpoCeleste::factory()->create([
            'nome' => 'Giove',
            'nome_en' => 'Jupiter',
        ]);

        $this->assertEquals('Jupiter', $corpo->nome_en);
    }

    public function test_nome_en_returns_null_when_not_set(): void
    {
        $corpo = CorpoCeleste::factory()->create([
            'nome' => 'Giove',
            'nome_en' => null,
        ]);

        $this->assertNull($corpo->nome_en);
    }

    public function test_immagine_url_returns_null_when_no_image(): void
    {
        $corpo = CorpoCeleste::factory()->create([
            'immagine' => null,
        ]);

        $this->assertNull($corpo->immagine_url);
    }

    public function test_immagine_url_returns_http_url_as_is(): void
    {
        $url = 'https://example.com/image.jpg';
        $corpo = CorpoCeleste::factory()->create([
            'immagine' => $url,
        ]);

        $this->assertEquals($url, $corpo->immagine_url);
    }

    public function test_immagine_url_returns_storage_url_for_local_filename(): void
    {
        $corpo = CorpoCeleste::factory()->create([
            'immagine' => 'planets/jupiter.jpg',
        ]);

        $expected = Storage::url('corpi-celesti/planets/jupiter.jpg');
        $this->assertEquals($expected, $corpo->immagine_url);
    }

    public function test_immagine_url_returns_public_path_for_public_prefix(): void
    {
        $corpo = CorpoCeleste::factory()->create([
            'immagine' => 'public/images/solar-system/terra.png',
        ]);

        $this->assertEquals('/images/solar-system/terra.png', $corpo->immagine_url);
    }
}
