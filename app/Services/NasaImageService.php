<?php
// Service Layer: ricerca/import/dedup immagini NASA. searchNasa, importForBody, importAll. SEARCH_ENHANCED per query specifiche. Timeout 30s, retry 2

namespace App\Services;

use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use App\Services\WordMapService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class NasaImageService
{
    // Query enhance: termini specifici per evitare risultati irrilevanti (es. "Mars Celebration")
    private const SEARCH_ENHANCED = [
        'Mars'           => 'Mars planet surface',
        'Mercury'        => 'Mercury planet',
        'Venus'          => 'Venus planet',
        'Earth'          => 'Earth Blue Marble',
        'Jupiter'        => 'Jupiter atmosphere planet',
        'Saturn'         => 'Saturn planet',
        'Uranus'         => 'Uranus planet',
        'Neptune'        => 'Neptune planet',
        'Sun'            => 'Sun solar',
        'Moon'           => 'Moon lunar surface',
        'Pluto'          => 'Pluto dwarf planet',
        'Europa'         => 'Europa moon Jupiter',
        'Titan'          => 'Titan moon Saturn',
        'Ceres'          => 'Ceres dwarf planet',
        'Milky Way'      => 'Milky Way galaxy',
    ];

    // Dipendenza: WordMapService iniettata via constructor (DI Laravel)
    public function __construct(
        // Constructor injection: WordMapService per traduzione IT→EN
        private readonly WordMapService $wordMap = new WordMapService(),
    ) {}

    // searchNasa: cerca immagini su images-api.nasa.gov con fallback multipli
    public function searchNasa(string $query, array $extraFallbacks = [], bool $bypassCache = false): array
    {
        // Cache key: MD5 query + fallbacks, TTL 24h
        $cacheKey = 'nasa_search_' . md5($query . '|' . implode(',', $extraFallbacks));

        // Closure searchFn: esegue query NASA, prova fallback, gestisce errori HTTP
        $searchFn = function () use ($query, $extraFallbacks) {
            $fallbacks = $extraFallbacks;

            // Pulizia: rimuove apostrofi, backtick, spazi multipli
            $stripped = str_replace(["'s", "'", "`", "’"], "", $query);
            $stripped = trim(preg_replace('/\s+/', ' ', $stripped));
            if ($stripped !== $query) {
                $fallbacks[] = $stripped;
            }

            // Queries: merge query originale + fallbacks
            $queries = array_merge([$query], $fallbacks);

            foreach ($queries as $q) {
                try {
                    // HTTP: timeout 30s, retry 2x, senza SSL in local/testing
                    $http = Http::timeout(30)->retry(2, 1000);
                    if (app()->environment('local', 'testing')) {
                        $http = $http->withoutVerifying();
                    }
                    $response = $http->get('https://images-api.nasa.gov/search', [
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
                } catch (\Exception $e) {
                    Log::warning('NASA API connection error', [
                        'query' => $q,
                        'error' => $e->getMessage(),
                    ]);
                    continue;
                }
            }

            return ['success' => false, 'message' => "Nessuna immagine trovata per \"{$query}\"."];
        };

        // Cache strategy: bypassCache = skip, altrimenti Cache::remember 24h
        if ($bypassCache) {
            return $searchFn();
        }

        return Cache::remember($cacheKey, 86400, $searchFn);
    }

    // extractMetadata: nasa_id, title, photographer, description, keywords da data[0]
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

    // pickMainImageUrl: priorità canonical → preview → alternate
    public function pickMainImageUrl(array $item): ?string
    {
        return $this->findLinkByRels($item, ['canonical', 'preview', 'alternate']);
    }

    // pickGalleryImageUrl: priorità canonical → alternate → preview
    public function pickGalleryImageUrl(array $item): ?string
    {
        return $this->findLinkByRels($item, ['canonical', 'alternate', 'preview']);
    }

    // findLinkByRels: cerca link con rel + render=image + estensione valida
    private function findLinkByRels(array $item, array $rels): ?string
    {
        foreach ($rels as $rel) {
            foreach ($item['links'] ?? [] as $link) {
                if (($link['rel'] ?? '') === $rel
                    && ($link['render'] ?? '') === 'image'
                    && $this->isValidImageUrl($link['href'] ?? '')) {
                    return $link['href'];
                }
            }
        }
        return null;
    }

    // isValidImageUrl: whitelist jpg/jpeg/png/webp/gif
    private function isValidImageUrl(string $url): bool
    {
        $path = parse_url($url, PHP_URL_PATH);
        if (!$path) {
            return false;
        }
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
    }

    // importForBody: importa immagine principale + galleria per 1 corpo celeste
    public function importForBody(CorpoCeleste $corpo, int $galleryCount = 5, bool $force = false, bool $updateDescription = false): array
    {
        // Guard: skip se immagine già presente e non force
        if ($corpo->immagine && !$force) {
            return ['success' => true, 'message' => "{$corpo->nome}: già presente, skip."];
        }

        // Traduzione: IT→EN via wordMap, fallback "comet" per comete
        $nomeIt = $corpo->nome;
        $nomeEn = $corpo->nome_en ?: $this->wordMap->translate($nomeIt);

        // Query enhance: usa termini specifici per evitare risultati irrilevanti
        $searchQuery = self::SEARCH_ENHANCED[$nomeEn] ?? $nomeEn;

        // 3-step fallback: enhanced → nome inglese semplice → nome italiano
        $extraFallbacks = [];
        if ($searchQuery !== $nomeEn) {
            $extraFallbacks[] = $nomeEn;
        }
        if ($nomeEn !== $nomeIt) {
            $extraFallbacks[] = $nomeIt;
        }

        if (stripos($nomeIt, "comet") !== false || stripos($nomeIt, "halley") !== false) {
            $extraFallbacks[] = "comet";
        }

        // Search: chiama searchNasa, fallback multipli
        $searchResult = $this->searchNasa($searchQuery, $extraFallbacks, $force);
        if (!$searchResult['success']) {
            Log::warning('NASA import failed for body', [
                'corpo' => $corpo->nome,
                'message' => $searchResult['message'],
            ]);
            return ['success' => false, 'message' => $searchResult['message']];
        }

        $items = $searchResult['items'];
        $mainImported = false;
        $mainNasaId = null;
        $galleryImported = 0;
        $gallerySkipped = 0;
        $errors = [];

        // Dedup: controlla galleria esistente, nasa_id duplicati, clean force (rimuovi .tif/.tiff/.fit)
        $hasLocalImage = $corpo->immagine && !str_starts_with($corpo->immagine, 'http');
        $canOverwriteMain = $force && !$corpo->immagine_utente && !$hasLocalImage;

        $existingGalleryCount = GalleriaCorpo::where('corpo_celeste_id', $corpo->id)->count();
        $galleryFull = !$force && $existingGalleryCount >= $galleryCount;

        $existingNasaIds = GalleriaCorpo::where('corpo_celeste_id', $corpo->id)
            ->pluck('percorso')
            ->map(fn ($p) => strtok(basename($p), '~'))
            ->filter()
            ->values();

        if ($force) {
            GalleriaCorpo::where('corpo_celeste_id', $corpo->id)
                ->where(fn ($q) => $q
                    ->where('percorso', 'LIKE', '%.tif')
                    ->orWhere('percorso', 'LIKE', '%.tiff')
                    ->orWhere('percorso', 'LIKE', '%.fit')
                    ->orWhere(fn ($q2) => $q2->where('percorso', 'NOT LIKE', 'http%'))
                )
                ->delete();
        }

        // Loop items: per ogni item NASA — estrae metadata, pick URL, gestisce main vs galleria
        foreach ($items as $index => $item) {
            $metadata = $this->extractMetadata($item);
            $nasaId = $metadata['nasa_id'] ?? uniqid();

            // Main image: solo se canOverwriteMain (force + non utente + non locale)
            $isMain = !$mainImported && $canOverwriteMain;

            $imageUrl = $isMain
                ? $this->pickMainImageUrl($item)
                : $this->pickGalleryImageUrl($item);

            if (!$imageUrl) {
                $label = $isMain ? 'immagine principale' : "immagine galleria #{$galleryImported}";
                $errors[] = "{$corpo->nome}: nessun URL disponibile per {$label}";
                continue;
            }

            if ($isMain) {
                // Main update: cancella vecchia locale, salva URL + nasa_id, opzionale description
                if ($corpo->immagine && !str_starts_with($corpo->immagine, 'http')) {
                    Storage::disk('public')->delete('corpi-celesti/' . $corpo->immagine);
                }

                $updateData = ['immagine' => $imageUrl, 'nasa_id' => $nasaId];
                if ($updateDescription && $metadata['description']) {
                    $updateData['descrizione'] = $metadata['description'];
                }
                $corpo->update($updateData);
                $mainImported = true;
                $mainNasaId = $nasaId;
            } else {
                // Gallery: dedup per URL, nasa_id, existingNasaIds; ordine incrementale
                if ($galleryFull) {
                    $gallerySkipped++;
                    continue;
                }

                if ($nasaId && $nasaId === $mainNasaId) {
                    continue;
                }

                if ($corpo->immagine && $imageUrl === $corpo->immagine) {
                    continue;
                }

                $exists = GalleriaCorpo::where('corpo_celeste_id', $corpo->id)
                    ->where('percorso', $imageUrl)
                    ->exists();

                if ($exists) {
                    $gallerySkipped++;
                    continue;
                }

                $baseNasaId = strtok(basename($imageUrl), '~');
                if ($baseNasaId && $existingNasaIds->contains($baseNasaId)) {
                    $gallerySkipped++;
                    continue;
                }

                GalleriaCorpo::create([
                    'corpo_celeste_id' => $corpo->id,
                    'percorso' => $imageUrl,
                    'didascalia' => $metadata['title'],
                    'crediti' => $metadata['photographer'],
                    'ordine' => $existingGalleryCount + $galleryImported,
                ]);
                $existingNasaIds->push($baseNasaId);
                $galleryImported++;
            }

            if ($galleryImported >= $galleryCount) {
                break;
            }
        }

        // Post-loop: se main non sovrascrivibile e già presente, conta come importato
        if (!$canOverwriteMain && $corpo->immagine) {
            $mainImported = true;
        }

        // Report: riepilogo testuale con main, gallery, skip, errors
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

    // importAll: processa tutti i corpi, raccoglie stats globali
    public function importAll(int $galleryCount = 5, bool $force = false, bool $updateDescription = false): array
    {
        $results = [];
        $successCount = 0;
        $totalCount = 0;
        $totalMain = 0;
        $totalGallery = 0;
        $errors = [];

        // Chunk 50: elabora in blocchi, accumula errori (max 2 per corpo, 10 totali)
        CorpoCeleste::chunk(50, function ($corpi) use ($galleryCount, $force, $updateDescription, &$successCount, &$totalCount, &$totalMain, &$totalGallery, &$errors) {
            foreach ($corpi as $corpo) {
                $result = $this->importForBody($corpo, $galleryCount, $force, $updateDescription);

                if (!empty($result['errors'])) {
                    $errors = array_merge($errors, array_slice($result['errors'], 0, 2));
                }

                $totalCount++;
                if ($result['success']) {
                    $successCount++;
                }
                if (isset($result['main']) && $result['main']) {
                    $totalMain++;
                }
                $totalGallery += $result['gallery'] ?? 0;
            }
        });

        return [
            'success' => $successCount,
            'total' => $totalCount,
            'total_main' => $totalMain,
            'total_gallery' => $totalGallery,
            'errors' => array_slice($errors, 0, 10),
        ];
    }
}
