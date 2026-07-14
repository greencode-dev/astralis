<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageUploadService
{
    private ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Upload and resize an image.
     *
     * @param  UploadedFile  $file
     * @param  string  $directory  Storage subdirectory (e.g. 'galleria', 'missioni')
     * @param  int  $maxWidth
     * @param  int  $maxHeight
     * @return string  Stored filename
     *
     * @throws \Exception
     */
    public function upload(UploadedFile $file, string $directory, int $maxWidth = 1200, int $maxHeight = 1200): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        try {
            $img = $this->manager->decodePath($file->getRealPath());
            $img->scaleDown(width: $maxWidth, height: $maxHeight);

            Storage::disk('public')->put($directory . '/' . $filename, $img->encode());
        } catch (\Exception $e) {
            Log::error("Errore upload immagine {$directory}", [
                'file' => $file->getClientOriginalName(),
                'error' => $e->getMessage(),
            ]);

            if (Storage::disk('public')->exists($directory . '/' . $filename)) {
                Storage::disk('public')->delete($directory . '/' . $filename);
            }

            throw $e;
        }

        return $filename;
    }
}
