<?php

namespace Tests\Unit;

use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CleanupGalleryDuplicatesTest extends TestCase
{
    use RefreshDatabase;

    public function test_remove_duplicates_keeps_first(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        $first = GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'same.jpg']);
        $second = GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'same.jpg']);

        $this->artisan('astralis:gallery');

        $this->assertDatabaseHas('galleria_corpi', ['id' => $first->id]);
        $this->assertDatabaseMissing('galleria_corpi', ['id' => $second->id]);
    }

    public function test_dry_run_preserves_duplicates(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        $first = GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'same.jpg']);
        $second = GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'same.jpg']);

        $this->artisan('astralis:gallery', ['--dry-run' => true]);

        $this->assertDatabaseHas('galleria_corpi', ['id' => $first->id]);
        $this->assertDatabaseHas('galleria_corpi', ['id' => $second->id]);
    }

    public function test_no_duplicates_returns_warning(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'unique.jpg']);

        $this->artisan('astralis:gallery')
            ->expectsOutputToContain('Nessun duplicato trovato');
    }

    public function test_clean_orphaned_files(): void
    {
        Storage::fake('public');
        $corpo = CorpoCeleste::factory()->create();
        GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'valid.jpg']);
        Storage::disk('public')->put('galleria/orphan.jpg', 'data');

        $this->artisan('astralis:gallery');

        Storage::disk('public')->assertMissing('galleria/orphan.jpg');
    }

    public function test_check_mode_does_not_delete(): void
    {
        Storage::fake('public');
        $corpo = CorpoCeleste::factory()->create();
        GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'valid.jpg']);
        Storage::disk('public')->put('galleria/orphan.jpg', 'data');

        $this->artisan('astralis:gallery', ['--check' => true, '--dry-run' => true]);

        Storage::disk('public')->assertExists('galleria/orphan.jpg');
    }

    public function test_dry_run_preserves_orphaned_files(): void
    {
        Storage::fake('public');
        $corpo = CorpoCeleste::factory()->create();
        GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'valid.jpg']);
        Storage::disk('public')->put('galleria/orphan.jpg', 'data');

        $this->artisan('astralis:gallery', ['--dry-run' => true]);

        Storage::disk('public')->assertExists('galleria/orphan.jpg');
    }

    public function test_broken_remote_url_check(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        GalleriaCorpo::factory()->for($corpo)->create([
            'percorso' => 'https://example.com/broken.jpg',
        ]);

        \Illuminate\Support\Facades\Http::fake([
            'example.com/*' => \Illuminate\Support\Facades\Http::response([], 404),
        ]);

        $this->artisan('astralis:gallery', ['--check' => true])
            ->expectsOutputToContain('KO');
    }

    public function test_working_remote_url_ok(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        GalleriaCorpo::factory()->for($corpo)->create([
            'percorso' => 'https://example.com/valid.jpg',
        ]);

        \Illuminate\Support\Facades\Http::fake([
            'example.com/*' => \Illuminate\Support\Facades\Http::response([], 200),
        ]);

        $this->artisan('astralis:gallery', ['--check' => true])
            ->expectsOutputToContain('OK');
    }

    public function test_different_corpi_same_path_not_deduped(): void
    {
        $corpo1 = CorpoCeleste::factory()->create();
        $corpo2 = CorpoCeleste::factory()->create();
        $a = GalleriaCorpo::factory()->for($corpo1)->create(['percorso' => 'same.jpg']);
        $b = GalleriaCorpo::factory()->for($corpo2)->create(['percorso' => 'same.jpg']);

        $this->artisan('astralis:gallery');

        $this->assertDatabaseHas('galleria_corpi', ['id' => $a->id]);
        $this->assertDatabaseHas('galleria_corpi', ['id' => $b->id]);
    }
}
