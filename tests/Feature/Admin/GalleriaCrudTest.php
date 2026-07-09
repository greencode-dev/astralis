<?php

namespace Tests\Feature\Admin;

use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleriaCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private CorpoCeleste $corpo;

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake();
        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->corpo = CorpoCeleste::factory()->create();
    }

    public function test_guest_cannot_access_admin_index(): void
    {
        $response = $this->get(route('admin.galleria.index'));

        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_index(): void
    {
        GalleriaCorpo::factory(3)->create(['corpo_celeste_id' => $this->corpo->id]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.galleria.index'));

        $response->assertStatus(200);
        $response->assertSee('Galleria');
    }

    public function test_admin_can_view_create_form(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.galleria.create'));

        $response->assertStatus(200);
        $response->assertSee('Nuova Immagine');
    }

    public function test_admin_can_store_galleria(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)
            ->post(route('admin.galleria.store'), [
                'corpo_celeste_id' => $this->corpo->id,
                'percorso' => UploadedFile::fake()->image('test.jpg'),
                'didascalia' => 'Test image',
                'crediti' => 'Test photographer',
            ]);

        $response->assertRedirect(route('admin.galleria.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('galleria_corpi', ['didascalia' => 'Test image']);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.galleria.store'), []);

        $response->assertSessionHasErrors(['corpo_celeste_id', 'percorso']);
    }

    public function test_admin_can_view_edit_form(): void
    {
        $item = GalleriaCorpo::factory()->create(['corpo_celeste_id' => $this->corpo->id]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.galleria.edit', $item));

        $response->assertStatus(200);
        $response->assertSee('Modifica');
    }

    public function test_admin_can_update_galleria(): void
    {
        $item = GalleriaCorpo::factory()->create(['corpo_celeste_id' => $this->corpo->id]);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.galleria.update', $item), [
                'corpo_celeste_id' => $this->corpo->id,
                'didascalia' => 'Updated didascalia',
            ]);

        $response->assertRedirect(route('admin.galleria.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('galleria_corpi', [
            'id' => $item->id,
            'didascalia' => 'Updated didascalia',
        ]);
    }

    public function test_admin_can_delete_galleria(): void
    {
        $item = GalleriaCorpo::factory()->create(['corpo_celeste_id' => $this->corpo->id]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.galleria.destroy', $item));

        $response->assertRedirect(route('admin.galleria.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('galleria_corpi', ['id' => $item->id]);
    }

    public function test_non_admin_cannot_store_galleria(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)
            ->post(route('admin.galleria.store'), [
                'corpo_celeste_id' => $this->corpo->id,
                'percorso' => UploadedFile::fake()->image('hacked.jpg'),
            ]);

        $response->assertStatus(403);
    }
}
