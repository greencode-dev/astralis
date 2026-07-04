<?php

namespace App\Services;

use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class NasaImageService
{
    private array $nameMap = [
        'Cerere'   => 'Ceres',
        'Terra'    => 'Earth',
        'Marte'    => 'Mars',
        'Giove'    => 'Jupiter',
        'Saturno'  => 'Saturn',
        'Urano'    => 'Uranus',
        'Nettuno'  => 'Neptune',
        'Venere'   => 'Venus',
        'Mercurio' => 'Mercury',
        'Luna'     => 'Moon',
        'Sole'     => 'Sun',
        'Via Lattea' => 'Milky Way',
    ];

    private ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function searchNasa(string $query): array
    {
        $searchName = $this->nameMap[$query] ?? $query;

        $response = Http::withoutVerifying()
            ->timeout(15)
            ->get('https://images-api.nasa.gov/search', [
                'q' => $searchName,
                'media_type' => 'image',
            ]);

        if ($response->failed()) {
            return ['success' => false, 'message' => "Errore di connessione a NASA API per \"{$query}\"."];
        }

        $items = $response->json('collection.items');

        if (empty($items)) {
            return ['success' => false, 'message' => "Nessuna immagine trovata per \"{$query}\"."];
        }

        return ['success' => true, 'items' => $items];
    }

    public function getBestImageUrl(array $item): ?string
    {
        $preferences = ['canonical', 'alternate', 'preview'];

        foreach ($preferences as $rel) {
            foreach ($item['links'] ?? [] as $link) {
                if (($link['rel'] ?? '') === $rel && ($link['render'] ?? '') === 'image') {
                    $url = $link['href'];
                    if ($rel === 'canonical') {
                        return $url;
                    }
                    return preg_replace('/~(thumb|small|medium)\./', '~orig.', $url, 1);
                }
            }
        }

        return null;
    }

    public function extractMetadata(array $item): array
    {
        $data = $item['data'][0] ?? [];

        return [
            'nasa_id' => $data['nasa_id'] ?? null,
            'title' => $data['title'] ?? null,
            'photographer' => $data['photographer'] ?? $data['secondary_creator'] ?? null,
            'description' => $data['description'] ?? null,
            'keywords' => $data['keywords'] ?? [],
        ];
    }

    public function downloadAndProcess(string $url, string $filename, string $storageDir, int $width, int $height): ?string
    {
        $previous = ini_get('memory_limit');
        try {
            ini_set('memory_limit', '512M');

            $response = Http::withoutVerifying()
                ->timeout(30)
                ->get($url);

            if ($response->failed()) {
                return null;
            }

            $imageData = $response->body();

            $img = $this->manager->decodeBinary($imageData);
            $img->scaleDown(width: $width, height: $height);

            Storage::disk('public')->put("{$storageDir}/{$filename}", $img->encode());

            return $filename;
        } catch (\Exception $e) {
            return null;
        } finally {
            ini_set('memory_limit', $previous);
        }
    }

    public function importForBody(CorpoCeleste $corpo, int $galleryCount = 5, bool $force = false, bool $updateDescription = false): array
    {
        if (!$force && $corpo->immagine) {
            return ['success' => true, 'message' => "{$corpo->nome}: già presente, skip."];
        }

        $searchResult = $this->searchNasa($corpo->nome);
        if (!$searchResult['success']) {
            return ['success' => false, 'message' => $searchResult['message']];
        }

        $items = $searchResult['items'];
        $mainImported = false;
        $galleryImported = 0;
        $errors = [];

        foreach ($items as $index => $item) {
            $metadata = $this->extractMetadata($item);
            $nasaId = $metadata['nasa_id'] ?? uniqid();
            $ext = 'jpg';

            $targetSize = !$mainImported ? 'main' : 'gallery';
            $width = !$mainImported ? 800 : 1200;
            $height = !$mainImported ? 800 : 1200;
            $storageDir = !$mainImported ? 'corpi-celesti' : 'galleria';

            $urlTried = false;
            $urlSuccess = false;

            foreach (['canonical', 'alternate', 'preview'] as $rel) {
                $imageUrl = null;
                foreach ($item['links'] ?? [] as $link) {
                    if (($link['rel'] ?? '') === $rel && ($link['render'] ?? '') === 'image') {
                        $imageUrl = $link['href'];
                        if ($rel !== 'canonical') {
                            $imageUrl = preg_replace('/~(thumb|small|medium)\./', '~orig.', $imageUrl, 1);
                        }
                        break;
                    }
                }

                if (!$imageUrl) {
                    continue;
                }

                $urlTried = true;
                $filename = "{$nasaId}_{$corpo->id}_{$targetSize}_{$rel}.{$ext}";

                if ($targetSize === 'main' && $rel === 'canonical' && $corpo->immagine) {
                    Storage::disk('public')->delete('corpi-celesti/' . $corpo->immagine);
                }

                $result = $this->downloadAndProcess($imageUrl, $filename, $storageDir, $width, $height);

                if ($result) {
                    if ($targetSize === 'main') {
                        $updateData = ['immagine' => $filename, 'nasa_id' => $nasaId];
                        if ($updateDescription && $metadata['description']) {
                            $updateData['descrizione'] = $metadata['description'];
                        }
                        $corpo->update($updateData);
                        $mainImported = true;
                    } else {
                        $exists = GalleriaCorpo::where('corpo_celeste_id', $corpo->id)
                            ->where('percorso', $filename)
                            ->exists();
                        if (!$exists) {
                            GalleriaCorpo::create([
                                'corpo_celeste_id' => $corpo->id,
                                'percorso' => $filename,
                                'didascalia' => $metadata['title'],
                                'crediti' => $metadata['photographer'],
                                'ordine' => $galleryImported,
                            ]);
                        }
                        $galleryImported++;
                    }
                    $urlSuccess = true;
                    break;
                }
            }

            if (!$urlTried) {
                continue;
            }

            if (!$urlSuccess) {
                $label = $targetSize === 'main' ? 'immagine principale' : "immagine galleria #{$galleryImported}";
                $errors[] = "{$corpo->nome}: fallito download {$label} (tentati canonical, alternate, preview)";
            }

            if ($mainImported && $galleryImported >= $galleryCount) {
                break;
            }
        }

        $parts = [];
        $parts[] = $mainImported ? "immagine principale importata" : "NESSUNA immagine importata";

        if ($galleryImported > 0) {
            $parts[] = "{$galleryImported} immagini galleria aggiunte";
        } else {
            $parts[] = "nessuna immagine galleria";
        }

        if (!empty($errors)) {
            $parts[] = "errori: " . implode('; ', array_slice($errors, 0, 3));
        }

        return [
            'success' => $mainImported,
            'message' => "{$corpo->nome}: " . implode(', ', $parts) . '.',
            'main' => $mainImported,
            'gallery' => $galleryImported,
            'errors' => $errors,
        ];
    }

    public function importAll(int $galleryCount = 5, bool $force = false, bool $updateDescription = false): array
    {
        $corpi = CorpoCeleste::all();
        $results = [];
        $successCount = 0;
        $totalMain = 0;
        $totalGallery = 0;

        foreach ($corpi as $corpo) {
            $result = $this->importForBody($corpo, $galleryCount, $force, $updateDescription);
            $results[] = $result;
            if ($result['success']) {
                $successCount++;
            }
            if (isset($result['main']) && $result['main']) {
                $totalMain++;
            }
            $totalGallery += $result['gallery'] ?? 0;
        }

        return [
            'success' => $successCount,
            'total' => $corpi->count(),
            'total_main' => $totalMain,
            'total_gallery' => $totalGallery,
            'results' => $results,
        ];
    }
}
