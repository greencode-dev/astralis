<?php

namespace Tests\Feature\Admin;

use App\Models\Missione;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MissioneCrudTest extends AdminTestCase
{
    public function test_guest_cannot_access_admin_index(): void
    {
        $response = $this->get(route('admin.missioni.index'));

        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_index(): void
    {
        Missione::factory(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.missioni.index'));

        $response->assertStatus(200);
        $response->assertSee('Missioni');
    }

    public function test_admin_can_view_create_form(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.missioni.create'));

        $response->assertStatus(200);
        $response->assertSee('Nuova Missione');
    }

    public function test_admin_can_store_missione(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)
            ->post(route('admin.missioni.store'), [
                'nome' => 'Test Mission',
                'agenzia' => 'NASA',
                'data_lancio' => '2020-01-01',
                'durata_giorni' => 365,
                'stato' => 'Completata',
                'descrizione' => 'A test mission.',
                'sito_web' => 'https://example.com',
            ]);

        $response->assertRedirect(route('admin.missioni.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('missioni', ['nome' => 'Test Mission']);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.missioni.store'), []);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_store_validates_unique_nome(): void
    {
        Missione::factory()->create(['nome' => 'Duplicate']);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.missioni.store'), ['nome' => 'Duplicate']);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_admin_can_view_missione(): void
    {
        $missione = Missione::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.missioni.show', $missione));

        $response->assertStatus(200);
        $response->assertSee($missione->nome);
    }

    public function test_admin_can_view_edit_form(): void
    {
        $missione = Missione::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.missioni.edit', $missione));

        $response->assertStatus(200);
        $response->assertSee('Modifica');
    }

    public function test_admin_can_update_missione(): void
    {
        $missione = Missione::factory()->create();

        $response = $this->actingAs($this->admin)
            ->put(route('admin.missioni.update', $missione), [
                'nome' => 'Updated Mission',
            ]);

        $response->assertRedirect(route('admin.missioni.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('missioni', [
            'id' => $missione->id,
            'nome' => 'Updated Mission',
        ]);
    }

    public function test_update_allows_same_nome(): void
    {
        $missione = Missione::factory()->create(['nome' => 'Unique']);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.missioni.update', $missione), [
                'nome' => 'Unique',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_admin_can_delete_missione(): void
    {
        $missione = Missione::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.missioni.destroy', $missione));

        $response->assertRedirect(route('admin.missioni.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('missioni', ['id' => $missione->id]);
    }
}
