<?php

namespace Tests\Feature\Admin;

use App\Models\Categoria;
use App\Models\User;

class CategoriaCrudTest extends AdminTestCase
{
    public function test_guest_cannot_access_admin_index(): void
    {
        $response = $this->get(route('admin.categorie.index'));

        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_index(): void
    {
        Categoria::factory(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.categorie.index'));

        $response->assertStatus(200);
        $response->assertSee('Categorie');
    }

    public function test_admin_can_view_create_form(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.categorie.create'));

        $response->assertStatus(200);
        $response->assertSee('Nuova Categoria');
    }

    public function test_admin_can_store_categoria(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.categorie.store'), [
                'nome' => 'Test Category',
                'icona' => '🪐',
                'descrizione' => 'A test category.',
                'colore' => '#FF0000',
            ]);

        $response->assertRedirect(route('admin.categorie.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('categorie', ['nome' => 'Test Category']);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.categorie.store'), []);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_store_validates_unique_nome(): void
    {
        Categoria::factory()->create(['nome' => 'Duplicate']);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.categorie.store'), ['nome' => 'Duplicate']);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_admin_can_view_categoria(): void
    {
        $categoria = Categoria::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.categorie.show', $categoria));

        $response->assertStatus(200);
        $response->assertSee($categoria->nome);
    }

    public function test_admin_can_view_edit_form(): void
    {
        $categoria = Categoria::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.categorie.edit', $categoria));

        $response->assertStatus(200);
        $response->assertSee('Modifica');
    }

    public function test_admin_can_update_categoria(): void
    {
        $categoria = Categoria::factory()->create();

        $response = $this->actingAs($this->admin)
            ->put(route('admin.categorie.update', $categoria), [
                'nome' => 'Updated Category',
            ]);

        $response->assertRedirect(route('admin.categorie.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('categorie', [
            'id' => $categoria->id,
            'nome' => 'Updated Category',
        ]);
    }

    public function test_update_allows_same_nome(): void
    {
        $categoria = Categoria::factory()->create(['nome' => 'Unique']);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.categorie.update', $categoria), [
                'nome' => 'Unique',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_admin_cannot_delete_categoria_with_corpi(): void
    {
        $categoria = Categoria::factory()->hasCorpiCelesti(1)->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.categorie.destroy', $categoria));

        $response->assertRedirect(route('admin.categorie.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('categorie', ['id' => $categoria->id]);
    }

    public function test_admin_can_delete_categoria(): void
    {
        $categoria = Categoria::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.categorie.destroy', $categoria));

        $response->assertRedirect(route('admin.categorie.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('categorie', ['id' => $categoria->id]);
    }

    public function test_non_admin_cannot_store_categoria(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)
            ->post(route('admin.categorie.store'), ['nome' => 'Hacked']);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_delete_categoria(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $categoria = Categoria::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('admin.categorie.destroy', $categoria));

        $response->assertStatus(403);
    }
}
