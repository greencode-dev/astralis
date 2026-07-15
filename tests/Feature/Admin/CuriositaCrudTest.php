<?php

namespace Tests\Feature\Admin;

use App\Models\CorpoCeleste;
use App\Models\Curiosita;

class CuriositaCrudTest extends AdminTestCase
{
    private CorpoCeleste $corpo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->corpo = CorpoCeleste::factory()->create();
    }

    public function test_guest_cannot_access_admin_index(): void
    {
        $response = $this->get(route('admin.curiosita.index'));

        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_index(): void
    {
        Curiosita::factory(3)->for($this->corpo)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.curiosita.index'));

        $response->assertStatus(200);
        $response->assertSee('Curiosità');
    }

    public function test_admin_can_view_create_form(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.curiosita.create'));

        $response->assertStatus(200);
        $response->assertSee('Nuova Curiosità');
    }

    public function test_admin_can_store_curiosita(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.curiosita.store'), [
                'corpo_celeste_id' => $this->corpo->id,
                'titolo' => 'Test Curiosità',
                'descrizione' => 'A test curiosity.',
                'fonte' => 'https://example.com',
            ]);

        $response->assertRedirect(route('admin.curiosita.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('curiosita', ['titolo' => 'Test Curiosità']);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.curiosita.store'), []);

        $response->assertSessionHasErrors(['corpo_celeste_id', 'titolo', 'descrizione']);
    }

    public function test_admin_can_view_curiosita(): void
    {
        $curiositum = Curiosita::factory()->for($this->corpo)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.curiosita.show', $curiositum));

        $response->assertStatus(200);
        $response->assertSee($curiositum->titolo);
    }

    public function test_admin_can_view_edit_form(): void
    {
        $curiositum = Curiosita::factory()->for($this->corpo)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.curiosita.edit', $curiositum));

        $response->assertStatus(200);
        $response->assertSee('Modifica');
    }

    public function test_admin_can_update_curiosita(): void
    {
        $curiositum = Curiosita::factory()->for($this->corpo)->create();

        $response = $this->actingAs($this->admin)
            ->put(route('admin.curiosita.update', $curiositum), [
                'corpo_celeste_id' => $this->corpo->id,
                'titolo' => 'Updated Curiosità',
                'descrizione' => 'Updated description.',
            ]);

        $response->assertRedirect(route('admin.curiosita.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('curiosita', [
            'id' => $curiositum->id,
            'titolo' => 'Updated Curiosità',
        ]);
    }

    public function test_admin_can_delete_curiosita(): void
    {
        $curiositum = Curiosita::factory()->for($this->corpo)->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.curiosita.destroy', $curiositum));

        $response->assertRedirect(route('admin.curiosita.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('curiosita', ['id' => $curiositum->id]);
    }
}
