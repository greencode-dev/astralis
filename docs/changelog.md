# Changelog

> [Formato e legenda →](#formato)

## 17/07/2026

- `[📝docs][🟠P1]` Workflow unificato — AGENTS.md: 7 fasi (Fase 0-6) per session startup, git sync, documentazione, commit/push, graphify update
- `[🖥️backend][🔴P0]` Fix proxy API — `vite.config.js`: aggiunto `server.proxy: { '/api': 'http://localhost:8000' }` — risolve CORB e white page in dev mode
- `[📝docs][🔵P2]` graphify installato — CLI knowledge graph (`pip install graphifyy` v0.9.17). Grafo: 1647 nodi, 2587 edges, 213 community
- `[📝docs][🔵P2]` Docs alignment — Fixed React 19→18 in AGENTS.md + SKILL.md, test count nei doc, task numbering in todo.md
- `[✨feature][🔵P2]` Logo assets — 3 PNG ad alta risoluzione caricati in `public/`: `astralis_logo_completo.png`, `astralis_solo_logo.png`, `astralis_solo_testo.png`
- `[🧪test][🔵P2]` 28 nuovi test — CorpoCelesteTest (6 accessor), ImportNasaImageTest (9 job), CorpoCelesteActionsTest (13 admin actions)
- `[🎨frontend][🟠P1]` Navbar mobile — `Navbar.jsx`: Escape key handler, click-outside overlay, close on route change via `useEffect`
- `[🎨frontend][🔵P2]` framer-motion mantenuto in `SolarSystem.jsx` (uso legittimo per orbite `useMotionValue`/`useTransform`)

**Test**: 362 totali (255 PHPUnit + 107 Vitest), tutti verdi.

---

## 16/07/2026

- `[🖥️backend][🟠P1]` `Admin/CorpoCelesteController.php` — where/orWhere search wrapped in closure, fix SQL precedence (B1)
- `[🖥️backend][🟠P1]` `CorpoCeleste.php` — fixed 8-space indent → 4-space su `getNomeDisplayAttribute` (B3)
- `[🎨frontend][🟠P1]` `Navbar.jsx` + `Footer.jsx` — logo oversized w-24 h-24 (96px) → w-10 h-10 (40px) (F8)
- `[🎨frontend][🔵P2]` `SearchBar.jsx` — aggiunto `focus-visible:ring-2 focus-visible:ring-admin-primary/50` per keyboard accessibility (F7)
- `[🎨frontend][🟠P1]` `Comparatore.jsx` — hardcoded `[#F97316]` → `admin-accent`, inline hex → `bg-admin-bg`/`bg-admin-card` (F3)
- `[🖥️backend][🔵P2]` `flash.blade.php` — 3 blocchi identici (35 righe) → 1 `@foreach` loop (22 righe) (B10)
- `[🎨frontend][🔵P2]` `CorpiLista.jsx` — extract `useDebounce` hook in `hooks/useDebounce.js` (F4)
- `[🖥️backend][🟠P1]` `config/admin.php` — centralizzato nav_items (7 voci), mission_stati, mission_stato_default, color_presets
- `[🎨frontend][🟠P1]` `_sidebar-nav.blade.php` — lettura nav da config, `Route::is()` per active state
- `[🎨frontend][🟠P1]` `category-badge.blade.php` — badge riusabile con `$color`, `$name`, `$size`, `$withDot` — wired in 6 file
- `[🎨frontend][🟠P1]` `index-header.blade.php` — header pagine index con titolo, descrizione, pulsante crea — wired in 5 file
- `[🎨frontend][🟠P1]` `dashboard-stat.blade.php` — card statistiche dashboard — wired in dashboard (4 card)
- `[🎨frontend][🟠P1]` `empty-table-row.blade.php` — stato tabella vuota — wired in 5 file
- `[🎨frontend][🟠P1]` `in-evidenza-badge.blade.php` — badge "in evidenza" — wired in corpi-celesti/index+show
- `[🎨frontend][🟠P1]` `layouts/app.blade.php` — flash include in layout master, fix bug flash non mostrati su dashboard
- `[🎨frontend][🔵P2]` `flash.blade.php` + `show-actions.blade.php` — CSS vars `admin-success`/`admin-error`
- `[🎨frontend][🟠P1]` `_sidebar-nav.blade.php` — `Route::is()` sostituito fragile `str_starts_with` + `explode`

**Test**: 359 totali (252 PHPUnit + 107 Vitest), tutti verdi.

---

## 15/07/2026

- `[🖥️backend][🔴P0]` `User.php` — rimosso `is_admin` da `#[Fillable]` — previene privilege escalation (C1)
- `[🖥️backend][🔴P0]` `StoreCategoriaRequest.php` — `colore` validato con regex `^#[0-9A-Fa-f]{6}$` — previene CSS injection (C5)
- `[🖥️backend][🔴P0]` `StoreGalleriaCorpoRequest.php` + `UpdateGalleriaCorpoRequest.php` — `didascalia` max ridotto da 500 a 255 (C2)
- `[🖥️backend][🟠P1]` `routes/web.php` — `throttle:120,1` su route admin, `throttle:30,1` su `suggestNome` (H1+H2)
- `[💾database][🔴P0]` Migration — `categoria_id` FK cambiata da `cascadeOnDelete` a `restrictOnDelete` (H3)
- `[🎨frontend][🔴P0]` `apiClient.js` — retry con config clonata + 2 abort signal check — fix state mutation e crash (C3)
- `[🎨frontend][🔴P0]` `CorpoDettaglio.jsx` — `similiSlugRef` verifica slug match prima di `setSimili()` — fix race condition (C4)
- `[🖥️backend][🔴P0]` `ImportNasaImage.php` — `ShouldBeUnique` + `uniqueId()` su `corpo->id`, timeout 120s→60s (H4)
- `[🎨frontend][🟠P1]` `color-picker-js.blade.php` — IIFE con null guard + sync su form submit (H13)
- `[🎨frontend][🟠P1]` `nasa-import/index.blade.php` — messaggio conferma corretto (H15)
- `[🎨frontend][🟠P1]` `useFetch.js` — START preserva dati esistenti (`{ ...state, loading: true }`) (H7)
- `[🎨frontend][🟠P1]` `Comparatore.jsx` — state derivato direttamente da `searchParams` — eliminata dipendenza circolare (H8)
- `[🎨frontend][🟠P1]` `Navbar.jsx` — hamburger toggle mobile responsive con Menu/X icons (H9)
- `[🎨frontend][🟠P1]` `CorpoDettaglio.jsx` — gravita/temperatura null-safe con `toLocaleString('it-IT')` (H11)
- `[🎨frontend][🟠P1]` `flash.blade.php` — auto-dismiss 5s, fade-out, bottone chiudi, ARIA roles (M1+M2)

**Test**: 338 totali (231 PHPUnit + 107 Vitest), tutti verdi.

---

## 14/07/2026

- `[🖥️backend][🔴P0]` `DashboardController` — rimosso `Cache::remember('admin.dashboard')` che causava `Attempt to read property "nome" on string`. Causa radice: `serializable_classes: false` in `config/cache.php`
- `[🖥️backend][🟠P1]` `ClearDashboardCache.php` — rimosso `Cache::forget('admin.dashboard')`, mantenuto `Cache::forget('api.dashboard.stats')`
- `[🖥️backend][🟠P1]` `ImportNasaImage.php` — rimosso `Cache::forget('admin.dashboard')`, mantenuto `Cache::forget('api.dashboard.stats')`
- `[🖥️backend][🟠P1]` 5 controller admin — trait `ClearDashboardCache` mantenuto solo per invalidazione cache API
- `[🖥️backend][🔵P2]` `CleanupGalleryDuplicates::headRequest()` — rimosso `withoutVerifying()` ridondante (P2)
- `[🖥️backend][🟠P1]` `WordMapService::translate()` — ora prova prima le chiavi compound ("Via Lattea", "Buco Nero") prima del word-by-word (P6)
- `[🖥️backend][🟠P1]` `NasaImportController::importAll()` — dispatch con `delay(now() + 2s * index)` per evitare flooding della coda (O6)
- `[🖥️backend][🟠P1]` `NasaImageService::searchNasa()` — cache NASA memorizza solo metadati essenziali (O9)
- `[🖥️backend][🟠P1]` `ImportNasaImage::$galleryCount` — default 3→5, uniformato con controller e command (B1)
- `[🖥️backend][🟠P1]` `ImportNasaImage` — aggiunti `$tries=3`, `$timeout=120`, metodo `failed()` con Log::error (B2)
- `[🖥️backend][🟠P1]` `NasaImageService::importAll()` — rimosso `set_time_limit(300)` (inefficace nei queue worker) (B3)
- `[🖥️backend][🔵P2]` `NasaImportController::index()` — `->get()` → `->paginate(20)` + links nella view (B4)
- `[🖥️backend][🟠P1]` `NasaImportController::importAll()` — filtra solo corpi senza immagine (`whereNull('immagine')`) (B5)
- `[🖥️backend][🔵P2]` `nasa-import/index.blade.php` — note aggiornate: gli URL sono ora remoti NASA (B6)
- `[🖥️backend][🔵P2]` `ImportNasaImage::handle()` — invalida cache dashboard dopo import (Bonus)
- `[🧪test][🔵P2]` WordMapServiceTest — 8 test (translate known/unknown/empty/compound, planet names, prepositions, guessEnglishName)
- `[🧪test][🔵P2]` CleanupGalleryDuplicatesTest — 9 test (dedup keeps first, dry-run, no-duplicates warning, orphan clean/check, broken/working remote URLs, different corpi same path)
- `[🧪test][🔵P2]` Frontend tests — NotFound(4), ErrorBoundary(4), TimelineMissioni(8), Navbar(6) — 22 test Vitest
- `[🧪test][🔵P2]` SearchAndFilterTest — 10 test (search across 5 entities, wildcard escaping, stato filter)
- `[🧪test][🔵P2]` ApiEdgeCaseTest — 17 test (percent/underscore, per_page zero, agenzia+stato, empty DB, factory, dashboard, galleria/curiosita)
- `[🎨frontend][🟠P1]` Inline styles → Tailwind in Blade: guest.blade.php, layouts/guest.blade.php, profile/edit.blade.php (Task 60)
- `[🎨frontend][🟠P1]` Inline rgba() → Tailwind admin-primary/XX in 20 JSX components (Task 61)
- `[🎨frontend][🟠P1]` Inline styles → Tailwind in Comparatore.jsx, HomePage.jsx (Task 62)
- `[🎨frontend][🟠P1]` Accessibility: `scope="col"` su 43 `<th>`, `aria-label` su search inputs e Navbar, `aria-current="page"` su nav attiva (Task 63)
- `[🎨frontend][🟠P1]` Loading skeletons: `role="status" aria-label="Caricamento..."` (Task 64)
- `[🖥️backend][🟠P1]` `GalleriaController` — delete protection: blocca eliminazione se immagine usata come principale (Task 59)
- `[🖥️backend][🔵P2]` `CuriositaController` — showRoute + mission-stato-badge partial extracted (Task 58)
- `[🎨frontend][🔵P2]` Rimossi `@testing-library/user-event` dep, dead `fetchMissioni` tests (Task 57)
- `[🖥️backend][🔵P2]` Config fixes: `locale=it`, `name=Astralis`, `APP_LOCALE=it` (Task 56)
- `[🎨frontend][🔵P2]` Rimossi unused CSS: `.animate-in-view-left`, `.animate-in-view-scale` (Task 55)
- `[🖥️backend][🟠P1]` ClearDashboardCache trait: extracted to `Admin/Concerns/ClearDashboardCache.php`, applied to 5 controllers (Task 52)
- `[🖥️backend][🟠P1]` ImageUploadService: extracted to `Services/ImageUploadService.php`, GalleriaController + MissioneController use method injection (Task 53)
- `[🧪test][🟠P1]` `LightboxGalleria.jsx:70` — `}` → `});` chiusura `memo()` mancante; `CorpoDettaglio.test.jsx:4` — typo import fixtures.js (Task 40)

**Test**: 322 totali (215 PHPUnit + 107 Vitest), tutti verdi.

---

## 11/07/2026

- `[🎨frontend][🟠P1]` Riscritte 8 viste Blade auth/profile: rimossi 17 handler onfocus/onblur inline, aggiunta `.admin-input-danger`, convertiti hex hardcoded (Task 5.1)
- `[🎨frontend][🟠P1]` Aggiunto `:root` block in `app.css` con 13 CSS custom properties — sostituiti 52 hex hardcoded in 10 file Blade (Task 5.2)
- `[🎨frontend][🟠P1]` Partials extraction: `back-link` in 14 file, `search` in 5 index, `stat-card` in 11 include, `show-actions` in 4 file, `index-actions` in 5 file — ~400 righe eliminate (Task 5.3)
- `[🎨frontend][🟠P1]` Form partial unificato: 5 `_form.blade.php` + 10 create/edit riscritti — ~860 righe eliminate (55%) (Task 5.4)
- `[📝docs][🔵P2]` Frontend Design review — audit palette, 7 inconsistenze colore, tipografia, firma visiva SolarSystem, motion, 7 raccomandazioni P4 (Task 10.3)
- `[📝docs][🔵P2]` Web Design Guidelines review — 3 high (aria-hidden su link, outline-none, prefers-reduced-motion), 6 medium, 3 low (Task 10.1)
- `[📝docs][🔵P2]` Writing Guidelines review — 14 ellipsis, 14 heading case, 10+ passive voice, 16 filler "con successo", mixed Italian/English (Task 10.2)
- `[🧪test][🟠P1]` 5 CRUD test migrati ad extend `AdminTestCase` — eliminati 5 setUp duplicati; DashboardApiTest da 1 a 4 test (Tasks 9.1+9.3+9.7)
- `[🧪test][🟠P1]` 3 nuovi file: CorpoCelesteActionsTest (7 test), GalleriaOrdineTest (6 test), NasaImportTest (8 test) (Task 9.6)
- `[🎨frontend][🟠P1]` framer-motion → CSS transitions + SolarSystem clickable/immagini realistiche — 87 test Vitest pass (Task 3.4)

**Test**: 260 totali (173 PHPUnit + 87 Vitest), tutti verdi.

---

## 10/07/2026

- `[🎨frontend][🔴P0]` AbortController in HomePage, CorpiLista, CorpoDettaglio, Comparatore — impedisce `setState()` su componenti smontati
- `[🎨frontend][🔴P0]` Custom hook `useFetch` con useReducer — centralizza loading/error/data/abort
- `[🎨frontend][🔴P0]` ErrorBoundary globale in App.jsx con pulsante retry
- `[🎨frontend][🔴P0]` Guard immagini rotte — CorpoCard, CorpoDettaglio, LightboxGalleria, TimelineMissioni: onError con fallback gradiente+icona
- `[🎨frontend][🔴P0]` Axios interceptors + retry in apiClient.js — timeout 15s, 3 tentativi
- `[🖥️backend][🔴P0]` Observer → Job Queue: `CorpoCelesteObserver::created()` dispatcha `ImportNasaImage` job
- `[🖥️backend][🔴P0]` `app/Jobs/ImportNasaImage.php` — NUOVO: queue `import-nasa`, 2 retry, 30s timeout
- `[🖥️backend][🔴P0]` `NasaImageService::importAll()` — `CorpoCeleste::all()` → `CorpoCeleste::chunk(50)` riduce memoria
- `[🖥️backend][🔴P0]` Rate limiting API: `throttle:60,1` su tutti e 10 gli endpoint
- `[🖥️backend][🔴P0]` Caching `searchNasa()`: `Cache::remember(86400)`
- `[🖥️backend][🔴P0]` Routes API raggruppate sotto middleware `throttle:60,1` + `throttle:100,1` per dashboard

---

## 09/07/2026

- `[🖥️backend][🟠P1]` HasFactory su 5 modelli, observer testing guard (`app()->environment('testing')`), 26 test NasaImageService — 84 test totali (Task 13.0)
- `[🧪test][🟠P1]` Vitest per componenti React — 27 test: CategoriaBadge(5), CorpoCard(10), LightboxGalleria(8), SolarSystem(4) (Task 13.1)
- `[🧪test][🟠P1]` Vitest integrazione API — 61 test: apiClient(12), HomePage(11), CorpiLista(12), CorpoDettaglio(16), Comparatore(10) (Task 13.2)
- `[🎨frontend][🟠P1]` Dashboard admin con grafici Chart.js — donut corpi/categoria, barre verticali corpi/tipo, barre orizzontali missioni/stato (Task 13.3)
- `[🖥️backend][🔴P0]` `curiosita/index.blade.php` — aggiunti 2 `@endif` mancanti; `categorie/index` + `galleria/index` — chiuso `@if` annidati (Task 14.0)
- `[🎨frontend][🔴P0]` `CorpoCard.jsx` — `isNaN` guard in `formatDistance()`; `App.jsx` + `NotFound.jsx` — route catch-all `path="*"` (Task 14.0)
- `[🖥️backend][🔴P0]` `CorpoCelesteController::setImageFromGallery` — ownership check; `MissioneController::show` — eager loading N+1 fix (Task 14.0)
- `[💾database][🔴P0]` Migration `create_missioni_table` — default `stato` da `'completata'` a `'Completata'` (Task 14.0)
- `[🖥️backend][🔴P0]` `NasaImageService.php` — `withoutVerifying()` ora solo in `local`/`testing` (Task 14.0)
- `[🎨frontend][🔴P0]` `CorpoDettaglio.jsx` — unificato import duplicato `Orbit` da lucide-react (Task 14.0)
- `[🖥️backend][🔴P0]` Dashboard: 3 query (corpi per categoria, corpi per tipo, missioni per stato) + 3 canvas Chart.js, tema dark (Task 14.0)
- `[🎨frontend][🟠P1]` Rimossi import morti React: `LightboxGalleria.jsx`, `Comparatore.jsx` (Task 14.1)
- `[🖥️backend][🟠P1]` Rimossi: `laravel/sanctum`, `barryvdh/laravel-dompdf`, `@tailwindcss/vite`, `@headlessui/react` (Task 14.1)
- `[🖥️backend][🟠P1]` `react`/`react-dom` spostati da devDependencies a dependencies; `@vitejs/plugin-react` spostato da dependencies a devDependencies (Task 14.1)
- `[🖥️backend][🟠P1]` CategoriaController::index — `->get()` → `->paginate(20)` + `withQueryString()` (Task 15.0)
- `[🖥️backend][🟠P1]` CuriositaController::show — nuovo metodo + vista `curiosita/show.blade.php` (Task 15.0)
- `[🖥️backend][🟠P1]` Search/filter admin per Categoria, Missione, Curiosità, Galleria — barra ricerca + `withQueryString()` + "Cancella filtro" (Task 15.1)
- `[🎨frontend][🟠P1]` SEO meta tags React su 5 pagine guest via `useEffect` + `document.title` (Task 15.2)
- `[🎨frontend][🔴P0]` Error Boundary globale React — `ErrorBoundary.jsx` con `componentDidCatch`, UI fallback tema dark (Task 15.3)
- `[🧪test][🟠P1]` Admin CRUD test: CategoriaCrudTest(13), MissioneCrudTest(12), CuriositaCrudTest(11), GalleriaCrudTest(11) — 47 test, 335 assertion (Task 15.4)

---

## 08/07/2026

- `[🖥️backend][🟠P1]` Auth pages da Inertia a Blade puro — 11 viste Blade con tema scuro, GuestLayout + AppLayout, rimossi `Inertia::render()`/`Inertia::location()` da 9 controller (Task 12.1)
- `[🖥️backend][🔴P0]` Rimossa dipendenza Inertia — rimosso `HandleInertiaRequests.php`, cancellati 13 componenti JSX, rimossi composer `inertia-laravel`/`ziggy` e npm `@inertiajs/*`, routes catch-all SPA (Task 12.2)
- `[🖥️backend][🟠P1]` FormRequest per validazione CorpoCeleste — `StoreCorpoCelesteRequest` + `UpdateCorpoCelesteRequest`, validazione ridotta da ~40 righe a 2 righe (Task 12.3)
- `[🖥️backend][🟠P1]` Quick wins: `per_page=100`, ordinamento default, `.catch(() => {})` → `console.error`, `nasa_id` esposto in Resource, migration indici (Task 12.4)
- `[📝docs][🔵P2]` Sistema priorità P0-P4 con emoji: 🔴P0 bloccante → 🟠P1 utente → 🔵P2 manutenzione → 🟣P3 accessibilità → ⚪P4 futuro (Task 12.5)
- `[🖥️backend][🟠P1]` WordMapService — `translate()` e `guessEnglishName()` estratti da controller; `inRandomOrder()` → `orderBy('nome')->limit(4)` in simili (Wave 1)
- `[🎨frontend][🟠P1]` Inline styles → Tailwind classi admin in 21 file Blade (Wave 4)
- `[🎨frontend][🟠P1]` `onMouseEnter`/`onMouseLeave` → CSS `:hover` in 24 file (5 JSX + 19 Blade) — ~270 righe eliminate (Wave 3)
- `[🎨frontend][🟣P3]` Accessibilità: `aria-label` su pulsanti reset/galleria, `role="img"` su fallback icon, SVG decorativi con `aria-hidden="true"` (Wave 2)
- `[🧪test][🟠P1]` Vitest setup: vitest, jsdom, @testing-library — 27 test per 4 componenti React (Task 13.1)
- `[🧪test][🟠P1]` HasFactory su 5 modelli, NasaImageServiceTest (26 test, 63 assertion), observer testing guard — 84 test totali (Task 13.0)

---

## 07/07/2026

- `[🖥️backend][🔴P0]` Inertia→Blade: login/logout con `Inertia::location()`, NASA import dedup, preserva `immagine_utente`, colonna `immagine_utente` su `corpi_celesti` (Task 11.0)
- `[🖥️backend][🟠P1]` Comando `astralis:gallery` con `--check`/`--clean`/`--sync`/`--fix`/`--dry-run` (Task 11.0)
- `[🎨frontend][🟠P1]` Galleria: inline ordering (pulsanti su/giù), onerror placeholder, "Imposta come principale" (Task 11.0)
- `[🖥️backend][🟠P1]` `uploadImmagine()` con try/catch, `destroy()` skip file locali per URL remoti (Task 11.0)
- `[🖥️backend][🟠P1]` Galleria cleanup: sostituite 16 immagini seed mancanti con URL NASA (Task 11.0)
- `[🖥️backend][🔴P0]` Authorization: migration `is_admin` su `users`, 5 Policy + Gate `admin`, `$this->authorize()` su tutti i controller CRUD + NasaImport (Task 12.0)

---

## 06/07/2026

- `[🎨frontend][🟠P1]` GuestLayout, Login, Register: tema scuro (`#0A0A1A`, `#111128`) (Task 10.0)
- `[🎨frontend][🔵P2]` "Register" link su Login page per nuovi utenti (Task 10.0)
- `[🎨frontend][🟠P1]` Velocità orbitali differenziate: pianeti lontani ruotano più lentamente (Task 10.0)
- `[🖥️backend][🟠P1]` Paginazione admin (`->paginate(20)`) su corpi-celesti, galleria, missioni, curiosità (Task 10.0)

---

## 05/07/2026

- `[🖥️backend][🔴P0]` Fix: route() senza virgolette in CorpoCelesteController (Task 9.1)
- `[🖥️backend][🔴P0]` Fix: `nasa_id` aggiunto a `$fillable` in CorpoCeleste model (Task 9.1)
- `[🖥️backend][🔴P0]` Fix: `categoria_id` dinamico nel seeder (non hard-coded) (Task 9.1)

---

## 04/07/2026

- `[🖥️backend][🟠P1]` Remote NASA URLs, `nome_it`, WordMap espansa, apostrophe fallback, auto-suggest admin — `NasaImageService::searchNasa()` riscritto, `suggestNome()` con 50+ termini (Task 10)
- `[🎨frontend][🟠P1]` Blade views: create/edit con input URL, index/show con URL remoti, show con "Cerca su NASA" (Task 10)
- `[🎨frontend][🟠P1]` Guest components: `nome_display` con fallback a `nome` in CorpoCard, LightboxGalleria, CorpoDettaglio (Task 10)
- `[💾database][🟠P1]` Migration: colonna `nome_it` su `corpi_celesti` (Task 10)
- `[🧪test][🟠P1]` 25/25 test pass, 61 assertions — Vite build: 3173 moduli, zero errori (Task 10)
- `[🖥️backend][🟠P1]` NASA Import multi-immagine: `NasaImageService` NUOVO (searchNasa, getBestImageUrl, extractMetadata, downloadAndProcess, importForBody, importAll) + `FetchNasaCommand` NUOVO (Task 9)
- `[🖥️backend][🟠P1]` `NasaImportController` refactor: delega logica a NasaImageService, importSingle ora importa 3 immagini in galleria (Task 9)
- `[📝docs][🔵P2]` `docs/progetto.md` → `docs/documentazione.md` rinominato, aggiornata sezione NASA Import (Task 9)
- `[🖥️backend][🟠P1]` `NasaImageService::downloadAndProcess()` — memory_limit 512M durante processing; fallback canonical → alternate → preview (Task 9)
- `[🎨frontend][🟠P1]` Profile navigation: `<Link href="/admin">` → `<a href="/admin">` (Task 7.0)
- `[🖥️backend][🟠P1]` NASA Import: mappatura nomi italiano→inglese `$nameMap` (Cerere→Ceres, Terra→Earth) (Task 7.1)
- `[🖥️backend][🟠P1]` SSL: `->withoutVerifying()` a chiamate HTTP verso NASA API (solo local/testing) (Task 7.2)
- `[🖥️backend][🟠P1]` Intervention Image v3→v4: `read()` → `decodePath()`, `resize()` → `scaleDown()`, `Image::read()` → `ImageManager(new Driver())->decodeBinary()` (Task 7.3)
- `[🖥️backend][🟠P1]` Force Import All: `importSingle()` estratto, `importAll()` aggiunto, modale conferma Alpine.js, route POST (Task 7.4)
- `[🎨frontend][🟠P1]` SolarSystem: orbite matematiche con seno/coseno + `useMotionValue`/`useTransform`, wrapper coordinate, 8 pianeti con etichette leggibili (Task 6.3+6.4)
- `[🖥️backend][🟠P1]` NASA Import backoffice: `NasaImportController` + vista `nasa-import/index.blade.php` + route GET/POST, voce sidebar (Task 6.5)
- `[🖥️backend][🔵P2]` `/dashboard` redirect → `/admin`, "Torna al sito" → home guest (Task 6.6)
- `[🎨frontend][🟠P1]` Link "Profilo" nella sidebar admin (Task 6.7)
- `[🎨frontend][🟠P1]` Pagine profilo adattate al tema scuro — layout dark, label italiane, componenti restilizzati (Task 6.8)
- `[🎨frontend][🔴P0]` React SPA guest: entry point `main.jsx`, layout navbar+footer, homepage animata con hero + sistema solare + corpi in evidenza, lista corpi con filtri/paginazione (Task 5)
- `[🎨frontend][🔴P0]` `CorpoDettaglio.jsx`, `LightboxGalleria.jsx`, `TimelineMissioni.jsx`, `Comparatore.jsx` — route, lightbox, timeline, tabella confronto (Task 6)

---

## 03/07/2026

- `[🖥️backend][🔴P0]` API REST: 5 Resource classes, 6 API Controllers, 10 endpoint JSON, filtri, route model binding con slug, bootstrap api.php (Task 4)
- `[🖥️backend][🔴P0]` Admin layout Blade: sidebar navigazione, palette scura (`#0A0A1A`, `#111128`, `#22D3EE`), dashboard con statistiche, tailwind.config.js esteso (Task 3)
- `[🖥️backend][🔴P0]` CRUD Categorie: index, create, store, show, edit, update, destroy; protezione eliminazione; color picker con palette 10 colori (Task 3)
- `[🖥️backend][🔴P0]` CRUD Corpi Celesti: index, create, store, show, edit, update, destroy (Task 3)
- `[🖥️backend][🔴P0]` CRUD Missioni: upload logo (Intervention Image, resize 300px), badge stato, vista show con dettagli, storage dedicato (Task 3)
- `[🖥️backend][🔴P0]` CRUD Curiosità: index, create, store, edit, update, destroy; route `{curiositum}` (Task 3)
- `[🖥️backend][🔴P0]` CRUD Galleria: upload immagini (Intervention Image, resize 1200px), index a griglia, route `{galleriaCorpo}` — Fase 2 completata (Task 3)
- `[💾database][🔴P0]` Installati pacchetti: spatie/laravel-sluggable, intervention/image, barryvdh/laravel-dompdf; 6 migrations, 5 Models, 7 seeders con dati reali, admin user (Task 2)

---

## 02/07/2026

- `[🖥️backend][🎨frontend][📝docs][🔴P0]` Setup iniziale: Laravel v13.18.0, Breeze con React stack, .env (MySQL :3307), APP_KEY generata (Task 1)

---

## Formato

Ogni entry usa il formato:

```
- `[🖥️backend][🔴P0]` Descrizione — `file/coinvolto`
```

**Tag (ambito)**:

| Emoji | Ambito |
|-------|--------|
| 🖥️ | Backend |
| 🎨 | Frontend |
| 💾 | Database |
| 🧪 | Test |
| ✨ | Feature |
| 📝 | Docs |

**Priorità**:

| Cerchio | Livello | Descrizione |
|---------|---------|-------------|
| 🔴 | P0 | Bloccante |
| 🟠 | P1 | Utente |
| 🔵 | P2 | Manutenzione |
| 🟣 | P3 | Accessibilità |
| ⚪ | P4 | Futuro |

Il conteggio test viene aggiornato all'ultima entry di ogni giorno. I prefissi B/F/C/H/M/O tra parentesi `(B1)`, `(F8)` ecc. sono riferimenti interni legacy ai task originali.

## Note

- Il changelog registra tutte le modifiche significative dal02/07/2026 al17/07/2026 (16 giorni di sviluppo)
- Le entry sono in ordine cronologico inverso (più recente prima)
- I doppioni sono stati rimossi (entry 12.2, 12.3, 12.4, 12.5 duplicate)
- Per aggiungere una nuova entry: aggiungere la riga sotto la data corrente con il formato `[tag]` Descrizione — `file`
- Test count: aggiornare il conteggio nell'ultima entry della giornata
