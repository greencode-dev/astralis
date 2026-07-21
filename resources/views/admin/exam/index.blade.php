@extends('admin.layouts.app')

@section('title', 'Exam — Quick Reference')
@section('page_title', 'Exam — Quick Reference')

@section('content')
    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        @foreach([
            ['value' => $stats['corpi_celesti'], 'label' => 'Corpi Celesti', 'color' => '#22D3EE'],
            ['value' => $stats['categorie'], 'label' => 'Categorie', 'color' => '#A855F7'],
            ['value' => $stats['missioni'], 'label' => 'Missioni', 'color' => '#F97316'],
            ['value' => $stats['curiosita'], 'label' => 'Curiosità', 'color' => '#FACC15'],
            ['value' => $stats['galleria'], 'label' => 'Galleria', 'color' => '#22C55E'],
            ['value' => $stats['pivot_missioni'], 'label' => 'Pivot N-N', 'color' => '#EF4444'],
        ] as $s)
            <div class="rounded-xl p-4 bg-admin-card border border-admin-primary/10 text-center">
                <p class="text-2xl font-bold" style="color: {{ $s['color'] }}">{{ $s['value'] }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $s['label'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Architecture --}}
        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            <h3 class="text-lg font-semibold mb-4 text-admin-text">Architettura</h3>
            <div class="space-y-3 text-sm">
                @foreach([
                    ['label' => 'Models', 'path' => 'app/Models/', 'count' => '5 modelli'],
                    ['label' => 'Migrations', 'path' => 'database/migrations/', 'count' => '8 file'],
                    ['label' => 'Admin Controllers', 'path' => 'app/Http/Controllers/Admin/', 'count' => '8 controller'],
                    ['label' => 'API Controllers', 'path' => 'app/Http/Controllers/Api/', 'count' => '6 controller'],
                    ['label' => 'Services', 'path' => 'app/Services/', 'count' => '2 service'],
                    ['label' => 'Policies', 'path' => 'app/Policies/', 'count' => '5 policy'],
                    ['label' => 'Blade Admin Views', 'path' => 'resources/views/admin/', 'count' => '~20 viste'],
                    ['label' => 'React Guest Pages', 'path' => 'resources/js/guest/pages/', 'count' => '5 pagine'],
                    ['label' => 'Factories', 'path' => 'database/factories/', 'count' => '5 factory'],
                    ['label' => 'PHPUnit Tests', 'path' => 'tests/', 'count' => '270 test'],
                    ['label' => 'Vitest Tests', 'path' => 'resources/js/guest/__tests__/', 'count' => '110 test'],
                ] as $item)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">{{ $item['label'] }}</span>
                        <span class="text-admin-text font-mono text-xs">{{ $item['path'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- API Endpoints --}}
        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            <h3 class="text-lg font-semibold mb-4 text-admin-text">API Endpoints (10)</h3>
            <div class="space-y-2">
                @foreach($endpoints as $ep)
                    <div class="flex items-center gap-3 text-sm">
                        <span class="inline-block px-2 py-0.5 rounded text-xs font-bold bg-green-500/15 text-green-400">{{ $ep['method'] }}</span>
                        <span class="font-mono text-admin-primary text-xs">{{ $ep['path'] }}</span>
                        <span class="text-gray-500 text-xs ml-auto hidden lg:inline">{{ $ep['desc'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Tech Stack --}}
        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            <h3 class="text-lg font-semibold mb-4 text-admin-text">Tech Stack</h3>
            <div class="grid grid-cols-2 gap-3 text-sm">
                @foreach([
                    ['key' => 'Backend', 'val' => 'Laravel 13'],
                    ['key' => 'Auth', 'val' => 'Breeze (Blade)'],
                    ['key' => 'Database', 'val' => 'MySQL 8.x (port 3307)'],
                    ['key' => 'Admin', 'val' => 'Blade + Alpine.js'],
                    ['key' => 'Guest', 'val' => 'React 18 + Vite'],
                    ['key' => 'CSS', 'val' => 'Tailwind CSS'],
                    ['key' => 'Animazioni', 'val' => 'CSS transitions + keyframes'],
                    ['key' => 'Lightbox', 'val' => 'yet-another-react-lightbox'],
                    ['key' => 'Upload', 'val' => 'Intervention Image v4'],
                    ['key' => 'Slug', 'val' => 'spatie/laravel-sluggable'],
                    ['key' => 'Grafici', 'val' => 'Chart.js (npm, bundled via Vite)'],
                    ['key' => 'API esterne', 'val' => 'NASA Image API'],
                ] as $t)
                    <div>
                        <span class="text-gray-500">{{ $t['key'] }}:</span>
                        <span class="text-admin-text font-medium">{{ $t['val'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Key Files --}}
        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            <h3 class="text-lg font-semibold mb-4 text-admin-text">File Chiave</h3>
            <div class="space-y-2 text-sm font-mono">
                @foreach([
                    'routes/web.php → Route admin + catch-all SPA',
                    'routes/api.php → 10 endpoint JSON',
                    'app/Providers/AuthServiceProvider.php → Gate admin + 5 Policy',
                    'app/Observers/CorpoCelesteObserver.php → auto-import NASA',
                    'app/Services/NasaImageService.php → import NASA API',
                    'app/Services/WordMapService.php → IT→EN translation',
                    'app/Http/Requests/ → 2 FormRequest validazione',
                    'resources/js/guest/App.jsx → routing React + ErrorBoundary',
                    'resources/js/guest/apiClient.js → axios + retry logic',
                    'resources/js/guest/hooks/useFetch.js → custom hook',
                    'vite.config.js → proxy /api → localhost:8000',
                    'config/admin.php → nav items + color presets',
                ] as $f)
                    <div class="text-gray-400">{{ $f }}</div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Entities --}}
    <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10 mb-8">
        <h3 class="text-lg font-semibold mb-4 text-admin-text">Entità Database (5 + 1 pivot)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-admin-primary/10">
                        <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Entità</th>
                        <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Campi Chiave</th>
                        <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Relazione</th>
                        <th scope="col" class="text-left py-3 px-4 font-medium text-gray-400">Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach([
                        ['name' => 'Categoria', 'fields' => 'nome, slug, icona, descrizione, colore', 'rel' => '→ CorpoCeleste', 'type' => '1-N (HasMany)'],
                        ['name' => 'CorpoCeleste', 'fields' => 'nome, nome_en, slug, categoria_id, immagine, descrizione, tipo, massa_kg, ..., nasa_id', 'rel' => '← Categoria, → Galleria, → Curiosità, ↔ Missione', 'type' => 'N-1, 1-N, N-N'],
                        ['name' => 'Missione', 'fields' => 'nome, slug, logo, agenzia, data_lancio, durata_giorni, stato, descrizione, sito_web', 'rel' => '↔ CorpoCeleste', 'type' => 'N-N (pivot)'],
                        ['name' => 'Curiosità', 'fields' => 'corpo_celeste_id, titolo, descrizione, fonte', 'rel' => '← CorpoCeleste', 'type' => 'N-1 (BelongsTo)'],
                        ['name' => 'GalleriaCorpo', 'fields' => 'corpo_celeste_id, percorso, didascalia, crediti, ordine', 'rel' => '← CorpoCeleste', 'type' => 'N-1 (BelongsTo)'],
                        ['name' => 'corpo_celeste_missione', 'fields' => 'corpo_celeste_id, missione_id, tipo_esplorazione, anno_arrivo', 'rel' => 'pivot N-N', 'type' => 'BelongsToMany'],
                    ] as $e)
                        <tr class="border-b border-admin-primary/5">
                            <td class="py-3 px-4 text-admin-primary font-medium">{{ $e['name'] }}</td>
                            <td class="py-3 px-4 text-gray-400 font-mono text-xs">{{ $e['fields'] }}</td>
                            <td class="py-3 px-4 text-admin-text">{{ $e['rel'] }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-block px-2 py-0.5 rounded text-xs font-bold
                                    {{ str_contains($e['type'], 'N-N') ? 'bg-purple-500/15 text-purple-400' : (str_contains($e['type'], '1-N') ? 'bg-cyan-500/15 text-cyan-400' : 'bg-orange-500/15 text-orange-400') }}">
                                    {{ $e['type'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Quick Access --}}
    <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
        <h3 class="text-lg font-semibold mb-4 text-admin-text">Accesso Rapido</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach([
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['label' => 'Corpi Celesti', 'route' => 'admin.corpi-celesti.index', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                ['label' => 'Categorie', 'route' => 'admin.categorie.index', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                ['label' => 'Missioni', 'route' => 'admin.missioni.index', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ] as $link)
                <a href="{{ route($link['route']) }}" class="flex items-center gap-2 px-4 py-3 rounded-lg bg-admin-primary/8 text-admin-primary hover:bg-admin-primary/15 transition-colors text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"/>
                    </svg>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>
    </div>
@endsection
