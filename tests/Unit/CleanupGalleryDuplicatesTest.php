<?php

namespace Tests\Unit;

use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CleanupGalleryDuplicatesTest extends TestCase
{
    use RefreshDatabase;

    public function test_remove_duplicates_keeps_first(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        $first = GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'same.jpg']);

        $this->artisan('astralis:gallery');

        $this->assertDatabaseHas('galleria_corpi', ['id' => $first->id]);
        $this->assertDatabaseCount('galleria_corpi', 1);
    }

    public function test_dry_run_preserves_duplicates(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        $first = GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'same.jpg']);

        $this->artisan('astralis:gallery', ['--dry-run' => true]);

        $this->assertDatabaseHas('galleria_corpi', ['id' => $first->id]);
        $this->assertDatabaseCount('galleria_corpi', 1);
    }

    public function test_unique_constraint_prevents_duplicates(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        $corpo = CorpoCeleste::factory()->create();
        GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'same.jpg']);
        GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'same.jpg']);
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

    public function test_cross_table_duplicate_removed(): void
    {
        $url = 'https://example.com/main.jpg';
        $corpo = CorpoCeleste::factory()->create(['immagine' => $url]);
        $gallery = GalleriaCorpo::factory()->for($corpo)->create(['percorso' => $url]);

        $this->artisan('astralis:gallery');

        $this->assertDatabaseMissing('galleria_corpi', ['id' => $gallery->id]);
    }

    public function test_cross_table_dry_run_preserves(): void
    {
        $url = 'https://example.com/main.jpg';
        $corpo = CorpoCeleste::factory()->create(['immagine' => $url]);
        $gallery = GalleriaCorpo::factory()->for($corpo)->create(['percorso' => $url]);

        $this->artisan('astralis:gallery', ['--dry-run' => true]);

        $this->assertDatabaseHas('galleria_corpi', ['id' => $gallery->id]);
    }

    public function test_nasa_id_duplicate_removed(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'https://images-assets.nasa.gov/image/PIA03644/PIA03644~small.jpg', 'ordine' => 0]);
        $dup = GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'https://images-assets.nasa.gov/image/PIA03644/PIA03644~thumb.jpg', 'ordine' => 1]);

        $this->artisan('astralis:gallery');

        $this->assertDatabaseMissing('galleria_corpi', ['id' => $dup->id]);
        $this->assertDatabaseCount('galleria_corpi', 1);
    }

    public function test_trim_keeps_max_images(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        for ($i = 0; $i < 8; $i++) {
            GalleriaCorpo::factory()->for($corpo)->create(['percorso' => "img-{$i}.jpg", 'ordine' => $i]);
        }

        $this->artisan('astralis:gallery', ['--trim' => 5]);

        $this->assertDatabaseCount('galleria_corpi', 5);
    }

    public function test_trim_dry_run_preserves(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        for ($i = 0; $i < 8; $i++) {
            GalleriaCorpo::factory()->for($corpo)->create(['percorso' => "img-{$i}.jpg", 'ordine' => $i]);
        }

        $this->artisan('astralis:gallery', ['--trim' => 5, '--dry-run' => true]);

        $this->assertDatabaseCount('galleria_corpi', 8);
    }

    public function test_trim_resequences_ordine(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'a.jpg', 'ordine' => 5]);
        GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'b.jpg', 'ordine' => 10]);
        GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'c.jpg', 'ordine' => 15]);

        $this->artisan('astralis:gallery');

        $ordines = DB::table('galleria_corpi')->where('corpo_celeste_id', $corpo->id)->pluck('ordine')->sort()->values()->toArray();
        $this->assertEquals([0, 1, 2], $ordines);
    }

    public function test_nasa_id_dry_run_preserves(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'https://images-assets.nasa.gov/image/PIA03644/PIA03644~small.jpg']);
        $dup = GalleriaCorpo::factory()->for($corpo)->create(['percorso' => 'https://images-assets.nasa.gov/image/PIA03644/PIA03644~thumb.jpg']);

        $this->artisan('astralis:gallery', ['--dry-run' => true]);

        $this->assertDatabaseHas('galleria_corpi', ['id' => $dup->id]);
    }

    public function test_trim_with_nasa_dedup_exact_count(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        for ($i = 0; $i < 5; $i++) {
            GalleriaCorpo::factory()->for($corpo)->create([
                'percorso' => "https://images-assets.nasa.gov/image/PIA{$i}000/PIA{$i}000~small.jpg",
                'ordine' => $i,
            ]);
            GalleriaCorpo::factory()->for($corpo)->create([
                'percorso' => "https://images-assets.nasa.gov/image/PIA{$i}000/PIA{$i}000~thumb.jpg",
                'ordine' => $i + 5,
            ]);
        }

        $this->artisan('astralis:gallery', ['--trim' => 5]);

        $this->assertDatabaseCount('galleria_corpi', 5);
    }
}
