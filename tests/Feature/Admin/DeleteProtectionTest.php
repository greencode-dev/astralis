<?php

namespace Tests\Feature\Admin;

use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use App\Models\Missione;

class DeleteProtectionTest extends AdminTestCase
{
    public function test_galleria_destroy_blocked_when_used_as_main_image(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        $galleria = GalleriaCorpo::factory()->for($corpo)->create([
            'percorso' => 'main-image.jpg',
        ]);

        $corpo->update(['immagine' => 'main-image.jpg']);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.galleria.destroy', $galleria));

        $response->assertRedirect(route('admin.galleria.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('galleria_corpi', ['id' => $galleria->id]);
    }

    public function test_galleria_destroy_succeeds_when_not_used_as_main_image(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        $galleria = GalleriaCorpo::factory()->for($corpo)->create([
            'percorso' => 'gallery-only.jpg',
        ]);

        $corpo->update(['immagine' => 'different-image.jpg']);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.galleria.destroy', $galleria));

        $response->assertRedirect(route('admin.galleria.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('galleria_corpi', ['id' => $galleria->id]);
    }

    public function test_missione_destroy_blocked_when_has_corpi_celesti(): void
    {
        $missione = Missione::factory()->create();
        $corpo = CorpoCeleste::factory()->create();
        $missione->corpiCelesti()->attach($corpo);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.missioni.destroy', $missione));

        $response->assertRedirect(route('admin.missioni.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('missioni', ['id' => $missione->id]);
    }

    public function test_missione_destroy_succeeds_when_no_corpi_celesti(): void
    {
        $missione = Missione::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.missioni.destroy', $missione));

        $response->assertRedirect(route('admin.missioni.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('missioni', ['id' => $missione->id]);
    }

    public function test_guest_cannot_delete_galleria(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        $galleria = GalleriaCorpo::factory()->for($corpo)->create();

        $response = $this->delete(route('admin.galleria.destroy', $galleria));

        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_delete_missione(): void
    {
        $missione = Missione::factory()->create();

        $response = $this->delete(route('admin.missioni.destroy', $missione));

        $response->assertRedirect('/login');
    }
}
