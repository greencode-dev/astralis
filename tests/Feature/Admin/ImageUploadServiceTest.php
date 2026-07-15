<?php

namespace Tests\Feature\Admin;

use App\Services\ImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadServiceTest extends AdminTestCase
{
    private ImageUploadService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ImageUploadService();
    }

    public function test_upload_stores_file_on_disk(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('test.jpg', 800, 600);

        $filename = $this->service->upload($file, 'galleria');

        $this->assertMatchesRegularExpression('/\d+_\w+\.jpg$/', $filename);
        Storage::disk('public')->assertExists("galleria/{$filename}");
    }

    public function test_upload_resizes_large_image(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('large.jpg', 3000, 2000);

        $filename = $this->service->upload($file, 'galleria', 1200, 1200);

        Storage::disk('public')->assertExists("galleria/{$filename}");
    }

    public function test_upload_uses_custom_directory(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('mission-logo.png', 200, 200);

        $filename = $this->service->upload($file, 'missioni', 300, 300);

        Storage::disk('public')->assertExists("missioni/{$filename}");
    }

    public function test_upload_preserves_extension(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('photo.png');

        $filename = $this->service->upload($file, 'galleria');

        $this->assertStringEndsWith('.png', $filename);
    }

    public function test_upload_generates_unique_filenames(): void
    {
        Storage::fake('public');

        $file1 = UploadedFile::fake()->image('a.jpg');
        $file2 = UploadedFile::fake()->image('b.jpg');

        $name1 = $this->service->upload($file1, 'galleria');
        $name2 = $this->service->upload($file2, 'galleria');

        $this->assertNotEquals($name1, $name2);
    }
}
