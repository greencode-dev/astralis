<?php

namespace Tests\Feature\Admin;

use App\Models\Categoria;
use App\Models\CorpoCeleste;

class CorpoCelesteCrudTest extends AdminTestCase
{
    private Categoria $categoria;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoria = Categoria::factory()->create();
    }

    public function test_guest_cannot_access_admin_index(): void
    {
        $response = $this->get(route('admin.corpi-celesti.index'));

        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_index(): void
    {
        CorpoCeleste::factory(3)->create(['categoria_id' => $this->categoria->id]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.corpi-celesti.index'));

        $response->assertStatus(200);
        $response->assertSee('Corpi Celesti');
    }

    public function test_admin_can_view_create_form(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.corpi-celesti.create'));

        $response->assertStatus(200);
        $response->assertSee('Nuovo Corpo Celeste');
    }

    public function test_admin_can_store_corpo(): void
    {
        $data = [
            'nome' => 'Test Planet Italiano',
            'nome_en' => 'Test Planet',
            'categoria_id' => $this->categoria->id,
            'tipo' => 'gassoso',
            'descrizione' => 'A test planet description.',
            'massa_kg' => '1.898e27',
            'distanza_km' => '778500000',
            'diametro_km' => '139820',
            'gravita' => 24.79,
            'temperatura' => -110,
            'periodo_orbitale' => 11.86,
            'scopritore' => 'Test',
            'anno_scoperta' => 2020,
            'in_evidenza' => true,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.corpi-celesti.store'), $data);

        $response->assertRedirect(route('admin.corpi-celesti.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('corpi_celesti', [
            'nome' => 'Test Planet Italiano',
            'in_evidenza' => true,
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.corpi-celesti.store'), []);

        $response->assertSessionHasErrors(['nome', 'categoria_id']);
    }

    public function test_store_validates_unique_nome(): void
    {
        CorpoCeleste::factory()->create([
            'categoria_id' => $this->categoria->id,
            'nome' => 'Duplicate',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.corpi-celesti.store'), [
                'nome' => 'Duplicate',
                'categoria_id' => $this->categoria->id,
            ]);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_admin_can_view_corpo(): void
    {
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => $this->categoria->id]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.corpi-celesti.show', $corpo));

        $response->assertStatus(200);
        $response->assertSee($corpo->nome);
    }

    public function test_admin_can_view_edit_form(): void
    {
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => $this->categoria->id]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.corpi-celesti.edit', $corpo));

        $response->assertStatus(200);
        $response->assertSee('Modifica');
    }

    public function test_admin_can_update_corpo(): void
    {
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => $this->categoria->id]);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.corpi-celesti.update', $corpo), [
                'nome' => 'Updated Planet',
                'categoria_id' => $this->categoria->id,
            ]);

        $response->assertRedirect(route('admin.corpi-celesti.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('corpi_celesti', [
            'id' => $corpo->id,
            'nome' => 'Updated Planet',
        ]);
    }

    public function test_update_allows_same_nome(): void
    {
        $corpo = CorpoCeleste::factory()->create([
            'categoria_id' => $this->categoria->id,
            'nome' => 'Unique Name',
        ]);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.corpi-celesti.update', $corpo), [
                'nome' => 'Unique Name',
                'categoria_id' => $this->categoria->id,
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_admin_can_delete_corpo(): void
    {
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => $this->categoria->id]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.corpi-celesti.destroy', $corpo));

        $response->assertRedirect(route('admin.corpi-celesti.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('corpi_celesti', ['id' => $corpo->id]);
    }
}
