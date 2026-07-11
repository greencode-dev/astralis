<?php

namespace Tests\Feature\Admin;

use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\Curiosita;
use App\Models\GalleriaCorpo;
use App\Models\Missione;
use App\Models\User;

class AuthorizationTest extends AdminTestCase
{
    // ── Store (3 entità con dati diversi) ──────────────────────

    public function test_non_admin_cannot_store_categoria(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)
            ->post(route('admin.categorie.store'), ['nome' => 'Hacked']);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_store_corpo_celeste(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $categoria = Categoria::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('admin.corpi-celesti.store'), [
                'nome' => 'Hacked',
                'categoria_id' => $categoria->id,
            ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_store_missione(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)
            ->post(route('admin.missioni.store'), ['nome' => 'Hacked']);

        $response->assertStatus(403);
    }

    // ── Update (5 entità) ──────────────────────────────────────

    public function test_non_admin_cannot_update_categoria(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $model = Categoria::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('admin.categorie.update', $model), ['nome' => $model->nome]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_update_corpo_celeste(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $model = CorpoCeleste::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('admin.corpi-celesti.update', $model), [
                'nome' => $model->nome,
                'categoria_id' => $model->categoria_id,
            ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_update_missione(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $model = Missione::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('admin.missioni.update', $model), ['nome' => $model->nome]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_update_curiosita(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $corpo = CorpoCeleste::factory()->create();
        $model = Curiosita::factory()->for($corpo)->create();

        $response = $this->actingAs($user)
            ->put(route('admin.curiosita.update', $model), [
                'corpo_celeste_id' => $model->corpo_celeste_id,
                'titolo' => $model->titolo,
                'descrizione' => $model->descrizione,
            ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_update_galleria(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $corpo = CorpoCeleste::factory()->create();
        $model = GalleriaCorpo::factory()->for($corpo)->create();

        $response = $this->actingAs($user)
            ->put(route('admin.galleria.update', $model), [
                'corpo_celeste_id' => $model->corpo_celeste_id,
                'didascalia' => $model->didascalia,
            ]);

        $response->assertStatus(403);
    }

    // ── Delete (5 entità) ──────────────────────────────────────

    public function test_non_admin_cannot_delete_categoria(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $model = Categoria::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('admin.categorie.destroy', $model));

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_delete_corpo_celeste(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $model = CorpoCeleste::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('admin.corpi-celesti.destroy', $model));

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_delete_missione(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $model = Missione::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('admin.missioni.destroy', $model));

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_delete_curiosita(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $corpo = CorpoCeleste::factory()->create();
        $model = Curiosita::factory()->for($corpo)->create();

        $response = $this->actingAs($user)
            ->delete(route('admin.curiosita.destroy', $model));

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_delete_galleria(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $corpo = CorpoCeleste::factory()->create();
        $model = GalleriaCorpo::factory()->for($corpo)->create();

        $response = $this->actingAs($user)
            ->delete(route('admin.galleria.destroy', $model));

        $response->assertStatus(403);
    }

    // ── Guest redirect (6 route index) ─────────────────────────

    public function test_guest_redirected_from_categorie_index(): void
    {
        $this->get(route('admin.categorie.index'))
            ->assertRedirect('/login');
    }

    public function test_guest_redirected_from_corpi_celesti_index(): void
    {
        $this->get(route('admin.corpi-celesti.index'))
            ->assertRedirect('/login');
    }

    public function test_guest_redirected_from_missioni_index(): void
    {
        $this->get(route('admin.missioni.index'))
            ->assertRedirect('/login');
    }

    public function test_guest_redirected_from_curiosita_index(): void
    {
        $this->get(route('admin.curiosita.index'))
            ->assertRedirect('/login');
    }

    public function test_guest_redirected_from_galleria_index(): void
    {
        $this->get(route('admin.galleria.index'))
            ->assertRedirect('/login');
    }

    public function test_guest_redirected_from_nasa_import_index(): void
    {
        $this->get(route('admin.nasa-import.index'))
            ->assertRedirect('/login');
    }
}
