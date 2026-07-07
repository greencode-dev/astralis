<?php

namespace App\Services;

use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class NasaImageService
{
    public function searchNasa(string $query, array $extraFallbacks = []): array
    {
        $fallbacks = $extraFallbacks;

        $stripped = str_replace(["'", "`", "’", "'s ", "'s"], "", $query);
        $stripped = trim(preg_replace('/\s+/', ' ', $stripped));
        if ($stripped !== $query) {
            $fallbacks[] = $stripped;
        }

        $queries = array_merge([$query], $fallbacks);

        foreach ($queries as $q) {
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->retry(2, 1000)
                ->get('https://images-api.nasa.gov/search', [
                    'q' => $q,
                    'media_type' => 'image',
                ]);

            if ($response->failed()) {
                continue;
            }

            $items = $response->json('collection.items');

            if (!empty($items)) {
                return ['success' => true, 'items' => $items, 'used_query' => $q];
            }
        }

        $last = $queries[count($queries) - 1];
        return ['success' => false, 'message' => "Nessuna immagine trovata per \"{$query}\"."];
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

    public function pickImageUrl(array $item): ?string
    {
        foreach (['alternate', 'preview', 'canonical'] as $rel) {
            foreach ($item['links'] ?? [] as $link) {
                if (($link['rel'] ?? '') === $rel && ($link['render'] ?? '') === 'image') {
                    return $link['href'];
                }
            }
        }
        return null;
    }

    public function importForBody(CorpoCeleste $corpo, int $galleryCount = 5, bool $force = false, bool $updateDescription = false): array
    {
        if (!$force && $corpo->immagine) {
            return ['success' => true, 'message' => "{$corpo->nome}: già presente, skip."];
        }

        $extraFallbacks = [];
        $nome = $corpo->nome;

        if (stripos($nome, "comet") !== false || stripos($nome, "halley") !== false) {
            $extraFallbacks[] = "comet";
        }

        $searchResult = $this->searchNasa($nome, $extraFallbacks);
        if (!$searchResult['success']) {
            return ['success' => false, 'message' => $searchResult['message']];
        }

        $items = $searchResult['items'];
        $mainImported = false;
        $galleryImported = 0;
        $gallerySkipped = 0;
        $errors = [];

        $canOverwriteMain = $force && !$corpo->immagine_utente;

        foreach ($items as $index => $item) {
            $metadata = $this->extractMetadata($item);
            $nasaId = $metadata['nasa_id'] ?? uniqid();

            $isMain = !$mainImported && $canOverwriteMain;

            $imageUrl = $this->pickImageUrl($item);
            if (!$imageUrl) {
                $label = $isMain ? 'immagine principale' : "immagine galleria #{$galleryImported}";
                $errors[] = "{$corpo->nome}: nessun URL disponibile per {$label}";
                continue;
            }

            if ($isMain) {
                if ($corpo->immagine && !str_starts_with($corpo->immagine, 'http')) {
                    Storage::disk('public')->delete('corpi-celesti/' . $corpo->immagine);
                }

                $updateData = ['immagine' => $imageUrl, 'nasa_id' => $nasaId];
                if ($updateDescription && $metadata['description']) {
                    $updateData['descrizione'] = $metadata['description'];
                }
                $corpo->update($updateData);
                $mainImported = true;
            } else {
                $exists = GalleriaCorpo::where('corpo_celeste_id', $corpo->id)
                    ->where('percorso', $imageUrl)
                    ->exists();

                if ($exists) {
                    $gallerySkipped++;
                    continue;
                }

                GalleriaCorpo::create([
                    'corpo_celeste_id' => $corpo->id,
                    'percorso' => $imageUrl,
                    'didascalia' => $metadata['title'],
                    'crediti' => $metadata['photographer'],
                    'ordine' => $galleryImported,
                ]);
                $galleryImported++;
            }

            if ($galleryImported >= $galleryCount) {
                break;
            }
        }

        if (!$canOverwriteMain && $corpo->immagine) {
            $mainImported = true;
        }

        $parts = [];
        $parts[] = $mainImported ? "immagine principale importata" : "NESSUNA immagine importata";

        if ($galleryImported > 0) {
            $parts[] = "{$galleryImported} immagini galleria aggiunte";
        } else {
            $parts[] = "nessuna immagine galleria";
        }

        if ($gallerySkipped > 0) {
            $parts[] = "{$gallerySkipped} già presenti (skippate)";
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
        set_time_limit(300);

        $corpi = CorpoCeleste::all();
        $results = [];
        $successCount = 0;
        $totalMain = 0;
        $totalGallery = 0;

        foreach ($corpi as $corpo) {
            $result = $this->importForBody($corpo, $galleryCount, $force, $updateDescription);

            if (!empty($result['errors'])) {
                $result['message'] .= ' ' . implode('; ', array_slice($result['errors'], 0, 2));
            }

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
