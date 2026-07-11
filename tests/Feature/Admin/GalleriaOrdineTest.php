<?php

namespace Tests\Feature\Admin;

use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;

class GalleriaOrdineTest extends AdminTestCase
{
    private CorpoCeleste $corpo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->corpo = CorpoCeleste::factory()->create();
    }

    public function test_aggiorna_ordine_su_decreases(): void
    {
        $item = GalleriaCorpo::factory()->create([
            'corpo_celeste_id' => $this->corpo->id,
            'ordine' => 5,
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.galleria.ordine', $item), ['direzione' => 'su']);

        $response->assertRedirect(route('admin.galleria.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('galleria_corpi', [
            'id' => $item->id,
            'ordine' => 4,
        ]);
    }

    public function test_aggiorna_ordine_giu_increases(): void
    {
        $item = GalleriaCorpo::factory()->create([
            'corpo_celeste_id' => $this->corpo->id,
            'ordine' => 3,
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.galleria.ordine', $item), ['direzione' => 'giu']);

        $response->assertRedirect(route('admin.galleria.index'));

        $this->assertDatabaseHas('galleria_corpi', [
            'id' => $item->id,
            'ordine' => 4,
        ]);
    }

    public function test_aggiorna_ordine_floors_at_zero(): void
    {
        $item = GalleriaCorpo::factory()->create([
            'corpo_celeste_id' => $this->corpo->id,
            'ordine' => 0,
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.galleria.ordine', $item), ['direzione' => 'su']);

        $response->assertRedirect(route('admin.galleria.index'));

        $this->assertDatabaseHas('galleria_corpi', [
            'id' => $item->id,
            'ordine' => 0,
        ]);
    }

    public function test_aggiorna_ordine_validates_direzione(): void
    {
        $item = GalleriaCorpo::factory()->create([
            'corpo_celeste_id' => $this->corpo->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.galleria.ordine', $item), ['direzione' => 'invalid']);

        $response->assertSessionHasErrors(['direzione']);
    }

    public function test_aggiorna_ordine_requires_direzione(): void
    {
        $item = GalleriaCorpo::factory()->create([
            'corpo_celeste_id' => $this->corpo->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.galleria.ordine', $item), []);

        $response->assertSessionHasErrors(['direzione']);
    }

    public function test_aggiorna_ordine_guest_cannot_access(): void
    {
        $item = GalleriaCorpo::factory()->create([
            'corpo_celeste_id' => $this->corpo->id,
        ]);

        $response = $this->post(route('admin.galleria.ordine', $item), ['direzione' => 'su']);

        $response->assertRedirect('/login');
    }
}
