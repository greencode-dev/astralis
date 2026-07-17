<?php

namespace Tests\Unit;

use App\Jobs\ImportNasaImage;
use App\Models\CorpoCeleste;
use App\Services\NasaImageService;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ImportNasaImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_implements_should_queue(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        $job = new ImportNasaImage($corpo);

        $this->assertInstanceOf(ShouldQueue::class, $job);
    }

    public function test_job_implements_should_be_unique(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        $job = new ImportNasaImage($corpo);

        $this->assertInstanceOf(ShouldBeUnique::class, $job);
    }

    public function test_job_tries_set_to_3(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        $job = new ImportNasaImage($corpo);

        $this->assertEquals(3, $job->tries);
    }

    public function test_job_timeout_set_to_60(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        $job = new ImportNasaImage($corpo);

        $this->assertEquals(60, $job->timeout);
    }

    public function test_unique_id_returns_corpo_id(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        $job = new ImportNasaImage($corpo);

        $this->assertEquals($corpo->id, $job->uniqueId());
    }

    public function test_job_defaults(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        $job = new ImportNasaImage($corpo);

        $this->assertEquals(5, $job->galleryCount);
        $this->assertTrue($job->force);
    }

    public function test_job_custom_parameters(): void
    {
        $corpo = CorpoCeleste::factory()->create();
        $job = new ImportNasaImage($corpo, galleryCount: 10, force: false);

        $this->assertEquals(10, $job->galleryCount);
        $this->assertFalse($job->force);
    }

    public function test_handle_is_noop_in_testing_environment(): void
    {
        $mock = \Mockery::mock(NasaImageService::class);
        $mock->shouldReceive('importForBody')->never();
        $this->app->instance(NasaImageService::class, $mock);

        $corpo = CorpoCeleste::factory()->create();
        $job = new ImportNasaImage($corpo);
        $job->handle($mock);
    }

    public function test_failed_logs_error(): void
    {
        Log::shouldReceive('error')
            ->once()
            ->with(\Mockery::on(fn($msg) => str_contains($msg, 'NASA import fallito per Marte') && str_contains($msg, 'Connection timeout')));

        $corpo = CorpoCeleste::factory()->create(['nome' => 'Marte']);
        $job = new ImportNasaImage($corpo);

        $exception = new \RuntimeException('Connection timeout');
        $job->failed($exception);
    }
}
