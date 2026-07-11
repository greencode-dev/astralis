<?php

namespace Tests\Feature\Admin;

use App\Models\CorpoCeleste;
use App\Models\User;
use Illuminate\Support\Facades\Bus;

class NasaImportTest extends AdminTestCase
{
    private CorpoCeleste $corpo;

    protected function setUp(): void
    {
        parent::setUp();
        Bus::fake();
        $this->corpo = CorpoCeleste::factory()->create();
    }

    public function test_guest_cannot_access_index(): void
    {
        $response = $this->get(route('admin.nasa-import.index'));

        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_index(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.nasa-import.index'));

        $response->assertStatus(200);
        $response->assertSee('Import');
    }

    public function test_import_dispatches_job(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.nasa-import.import', $this->corpo));

        $response->assertRedirect(route('admin.nasa-import.index'));
        $response->assertSessionHas('success');

        Bus::assertDispatched(\App\Jobs\ImportNasaImage::class);
    }

    public function test_import_all_dispatches_jobs_for_all_corpi(): void
    {
        CorpoCeleste::factory(3)->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.nasa-import.import-all'));

        $response->assertRedirect(route('admin.nasa-import.index'));
        $response->assertSessionHas('success');

        Bus::assertDispatched(\App\Jobs\ImportNasaImage::class, 4);
    }

    public function test_import_guest_cannot_access(): void
    {
        $response = $this->post(route('admin.nasa-import.import', $this->corpo));

        $response->assertRedirect('/login');
    }

    public function test_import_guest_cannot_access_import_all(): void
    {
        $response = $this->post(route('admin.nasa-import.import-all'));

        $response->assertRedirect('/login');
    }

    public function test_non_admin_cannot_import(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)
            ->post(route('admin.nasa-import.import', $this->corpo));

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_import_all(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)
            ->post(route('admin.nasa-import.import-all'));

        $response->assertStatus(403);
    }
}
