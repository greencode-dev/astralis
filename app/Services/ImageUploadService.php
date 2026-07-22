<?php
// Service Layer: upload + resize immagini. Intervention Image v4, scaleDown, Storage disk public

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageUploadService
{
    // ImageManager: driver GD (non Imagick)
    private ImageManager $manager;

    // Constructor: inizializza Intervention Image con driver GD
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
        // Filename: time() _ uniqid() . extension (evita collisioni)
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        try {
            // Resize: decodePath → scaleDown (preserva aspect ratio, max 1200x1200)
            $img = $this->manager->decodePath($file->getRealPath());
            $img->scaleDown(width: $maxWidth, height: $maxHeight);

            Storage::disk('public')->put($directory . '/' . $filename, $img->encode());
        } catch (\Exception $e) {
            // Error: log + cleanup file parziale + re-throw
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
