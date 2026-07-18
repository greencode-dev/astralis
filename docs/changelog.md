# Changelog

> [Formato e legenda →](#formato)

## 18/07/2026

- `[🟠][🎨]` Refactoring card dashboard — link cliccabili alle index page, 4 colori unici per card (primary/secondary/accent/warning), meta info (ultimo creato, breakdown missioni), table Nome clickable. — `dashboard-stat.blade.php`, `DashboardController.php`, `dashboard.blade.php`
- `[🔵][🧪]` Dashboard test aggiornati — 3 nuovi test: clickable links, table links, meta info. — `DashboardTest.php`
- `[🟠][🎨]` Solar system immagini reali — 9 foto NASA/High-quality, tutte croppate a quadrato, dimensioni pianeti ingrandite ~1.8×. Rimosso `bg-black` e `object-cover` → `object-contain`. — `public/images/solar-system/`, `SolarSystem.jsx`
- `[🟠][🎨]` Solar system Sole — sostituito con NASA 3D rendering (pngtree), crop 359×359. — `sole.jpg`
- `[🔴][🖥️]` Gallery quality fix — eliminati 74 record galleria, reimportati 90 (18×5) tutti `~orig.jpg` (0 thumb/small/medium). Fix `importForBody()`: rimosso early return che bloccava import galleria per corpi con `immagine_utente=true`. — `NasaImageService.php`
- `[🔵][🧪]` Test aggiornato — `test_import_for_body_force_does_not_overwrite_user_image` ora verifica che main non venga sovrascritta ma galleria venga importata. — `NasaImageServiceTest.php`

**Test**: 377 totali (267 PHPUnit + 110 Vitest), tutti verdi.

---

## 17/07/2026

- `[🟠][📝]` Workflow unificato — AGENTS.md: 7 fasi (Fase 0-6) per session startup, git sync, documentazione, commit/push, graphify update
- `[🔴][🖥️]` Fix proxy API — `vite.config.js`: aggiunto `server.proxy: { '/api': 'http://localhost:8000' }` — risolve CORB e white page in dev mode
- `[🔵][📝]` graphify installato — CLI knowledge graph (`pip install graphifyy` v0.9.17). Grafo: 1647 nodi, 2587 edges, 213 community
- `[🔵][📝]` Docs alignment — Fixed React 19→18 in AGENTS.md + SKILL.md, test count nei doc, task numbering in todo.md
- `[🔵][✨]` Logo assets — 3 PNG ad alta risoluzione caricati in `public/`: `astralis_logo_completo.png`, `astralis_solo_logo.png`, `astralis_solo_testo.png`
- `[🔵][🧪]` 28 nuovi test — CorpoCelesteTest (6 accessor), ImportNasaImageTest (9 job), CorpoCelesteActionsTest (13 admin actions)
- `[🟠][🎨]` Navbar mobile — `Navbar.jsx`: Escape key handler, click-outside overlay, close on route change via `useEffect`
- `[🔵][🎨]` framer-motion mantenuto in `SolarSystem.jsx` (uso legittimo per orbite `useMotionValue`/`useTransform`)
- `[🟠][📝]` Comandi custom — AGENTS.md: aggiunti `\commit`, `\push`, `\save` con workflow automatizzato (Fasi 5-6 + chiusura sessione)
- `[🟠][📝]` Snapshot sessione — `### Sessione corrente` in AGENTS.md, sovrascritta ad ogni `\save`, letta da `\start`
- `[🔵][📝]` Fase 0 aggiornata — `\start` include lettura snapshot ultima sessione nel report
- `[🟠][📝]` Conferme unificate — AGENTS.md: tutte le conferme esplicite usano il tool `question` con checkbox, formato standard in 7 punti (Fase 5, Fase 6, \commit, \push, \save)

**Test**: 362 totali (255 PHPUnit + 107 Vitest), tutti verdi.

---

## 16/07/2026

- `[🟠][🖥️]` `Admin/CorpoCelesteController.php` — where/orWhere search wrapped in closure, fix SQL precedence (B1)
- `[🟠][🖥️]` `CorpoCeleste.php` — fixed 8-space indent → 4-space su `getNomeDisplayAttribute` (B3)
- `[🟠][🎨]` `Navbar.jsx` + `Footer.jsx` — logo oversized w-24 h-24 (96px) → w-10 h-10 (40px) (F8)
- `[🔵][🎨]` `SearchBar.jsx` — aggiunto `focus-visible:ring-2 focus-visible:ring-admin-primary/50` per keyboard accessibility (F7)
- `[🟠][🎨]` `Comparatore.jsx` — hardcoded `[#F97316]` → `admin-accent`, inline hex → `bg-admin-bg`/`bg-admin-card` (F3)
- `[🔵][🖥️]` `flash.blade.php` — 3 blocchi identici (35 righe) → 1 `@foreach` loop (22 righe) (B10)
- `[🔵][🎨]` `CorpiLista.jsx` — extract `useDebounce` hook in `hooks/useDebounce.js` (F4)
- `[🟠][🖥️]` `config/admin.php` — centralizzato nav_items (7 voci), mission_stati, mission_stato_default, color_presets
- `[🟠][🎨]` `_sidebar-nav.blade.php` — lettura nav da config, `Route::is()` per active state
- `[🟠][🎨]` `category-badge.blade.php` — badge riusabile con `$color`, `$name`, `$size`, `$withDot` — wired in 6 file
- `[🟠][🎨]` `index-header.blade.php` — header pagine index con titolo, descrizione, pulsante crea — wired in 5 file
- `[🟠][🎨]` `dashboard-stat.blade.php` — card statistiche dashboard — wired in dashboard (4 card)
- `[🟠][🎨]` `empty-table-row.blade.php` — stato tabella vuota — wired in 5 file
- `[🟠][🎨]` `in-evidenza-badge.blade.php` — badge "in evidenza" — wired in corpi-celesti/index+show
- `[🟠][🎨]` `layouts/app.blade.php` — flash include in layout master, fix bug flash non mostrati su dashboard
- `[🔵][🎨]` `flash.blade.php` + `show-actions.blade.php` — CSS vars `admin-success`/`admin-error`
- `[🟠][🎨]` `_sidebar-nav.blade.php` — `Route::is()` sostituito fragile `str_starts_with` + `explode`

**Test**: 359 totali (252 PHPUnit + 107 Vitest), tutti verdi.

---

## 15/07/2026

- `[🔴][🖥️]` `User.php` — rimosso `is_admin` da `#[Fillable]` — previene privilege escalation (C1)
- `[🔴][🖥️]` `StoreCategoriaRequest.php` — `colore` validato con regex `^#[0-9A-Fa-f]{6}$` — previene CSS injection (C5)
- `[🔴][🖥️]` `StoreGalleriaCorpoRequest.php` + `UpdateGalleriaCorpoRequest.php` — `didascalia` max ridotto da 500 a 255 (C2)
- `[🟠][🖥️]` `routes/web.php` — `throttle:120,1` su route admin, `throttle:30,1` su `suggestNome` (H1+H2)
- `[🔴][💾]` Migration — `categoria_id` FK cambiata da `cascadeOnDelete` a `restrictOnDelete` (H3)
- `[🔴][🎨]` `apiClient.js` — retry con config clonata + 2 abort signal check — fix state mutation e crash (C3)
- `[🔴][🎨]` `CorpoDettaglio.jsx` — `similiSlugRef` verifica slug match prima di `setSimili()` — fix race condition (C4)
- `[🔴][🖥️]` `ImportNasaImage.php` — `ShouldBeUnique` + `uniqueId()` su `corpo->id`, timeout 120s→60s (H4)
- `[🟠][🎨]` `color-picker-js.blade.php` — IIFE con null guard + sync su form submit (H13)
- `[🟠][🎨]` `nasa-import/index.blade.php` — messaggio conferma corretto (H15)
- `[🟠][🎨]` `useFetch.js` — START preserva dati esistenti (`{ ...state, loading: true }`) (H7)
- `[🟠][🎨]` `Comparatore.jsx` — state derivato direttamente da `searchParams` — eliminata dipendenza circolare (H8)
- `[🟠][🎨]` `Navbar.jsx` — hamburger toggle mobile responsive con Menu/X icons (H9)
- `[🟠][🎨]` `CorpoDettaglio.jsx` — gravita/temperatura null-safe con `toLocaleString('it-IT')` (H11)
- `[🟠][🎨]` `flash.blade.php` — auto-dismiss 5s, fade-out, bottone chiudi, ARIA roles (M1+M2)

**Test**: 338 totali (231 PHPUnit + 107 Vitest), tutti verdi.

---

## 14/07/2026

- `[🔴][🖥️]` `DashboardController` — rimosso `Cache::remember('admin.dashboard')` che causava `Attempt to read property "nome" on string`. Causa radice: `serializable_classes: false` in `config/cache.php`
- `[🟠][🖥️]` `ClearDashboardCache.php` — rimosso `Cache::forget('admin.dashboard')`, mantenuto `Cache::forget('api.dashboard.stats')`
- `[🟠][🖥️]` `ImportNasaImage.php` — rimosso `Cache::forget('admin.dashboard')`, mantenuto `Cache::forget('api.dashboard.stats')`
- `[🟠][🖥️]` 5 controller admin — trait `ClearDashboardCache` mantenuto solo per invalidazione cache API
- `[🔵][🖥️]` `CleanupGalleryDuplicates::headRequest()` — rimosso `withoutVerifying()` ridondante (P2)
- `[🟠][🖥️]` `WordMapService::translate()` — ora prova prima le chiavi compound ("Via Lattea", "Buco Nero") prima del word-by-word (P6)
- `[🟠][🖥️]` `NasaImportController::importAll()` — dispatch con `delay(now() + 2s * index)` per evitare flooding della coda (O6)
- `[🟠][🖥️]` `NasaImageService::searchNasa()` — cache NASA memorizza solo metadati essenziali (O9)
- `[🟠][🖥️]` `ImportNasaImage::$galleryCount` — default 3→5, uniformato con controller e command (B1)
- `[🟠][🖥️]` `ImportNasaImage` — aggiunti `$tries=3`, `$timeout=120`, metodo `failed()` con Log::error (B2)
- `[🟠][🖥️]` `NasaImageService::importAll()` — rimosso `set_time_limit(300)` (inefficace nei queue worker) (B3)
- `[🔵][🖥️]` `NasaImportController::index()` — `->get()` → `->paginate(20)` + links nella view (B4)
- `[🟠][🖥️]` `NasaImportController::importAll()` — filtra solo corpi senza immagine (`whereNull('immagine')`) (B5)
- `[🔵][🖥️]` `nasa-import/index.blade.php` — note aggiornate: gli URL sono ora remoti NASA (B6)
- `[🔵][🖥️]` `ImportNasaImage::handle()` — invalida cache dashboard dopo import (Bonus)
- `[🔵][🧪]` WordMapServiceTest — 8 test (translate known/unknown/empty/compound, planet names, prepositions, guessEnglishName)
- `[🔵][🧪]` CleanupGalleryDuplicatesTest — 9 test (dedup keeps first, dry-run, no-duplicates warning, orphan clean/check, broken/working remote URLs, different corpi same path)
- `[🔵][🧪]` Frontend tests — NotFound(4), ErrorBoundary(4), TimelineMissioni(8), Navbar(6) — 22 test Vitest
- `[🔵][🧪]` SearchAndFilterTest — 10 test (search across 5 entities, wildcard escaping, stato filter)
- `[🔵][🧪]` ApiEdgeCaseTest — 17 test (percent/underscore, per_page zero, agenzia+stato, empty DB, factory, dashboard, galleria/curiosita)
- `[🟠][🎨]` Inline styles → Tailwind in Blade: guest.blade.php, layouts/guest.blade.php, profile/edit.blade.php (Task 60)
- `[🟠][🎨]` Inline rgba() → Tailwind admin-primary/XX in 20 JSX components (Task 61)
- `[🟠][🎨]` Inline styles → Tailwind in Comparatore.jsx, HomePage.jsx (Task 62)
- `[🟠][🎨]` Accessibility: `scope="col"` su 43 `<th>`, `aria-label` su search inputs e Navbar, `aria-current="page"` su nav attiva (Task 63)
- `[🟠][🎨]` Loading skeletons: `role="status" aria-label="Caricamento..."` (Task 64)
- `[🟠][🖥️]` `GalleriaController` — delete protection: blocca eliminazione se immagine usata come principale (Task 59)
- `[🔵][🖥️]` `CuriositaController` — showRoute + mission-stato-badge partial extracted (Task 58)
- `[🔵][🎨]` Rimossi `@testing-library/user-event` dep, dead `fetchMissioni` tests (Task 57)
- `[🔵][🖥️]` Config fixes: `locale=it`, `name=Astralis`, `APP_LOCALE=it` (Task 56)
- `[🔵][🎨]` Rimossi unused CSS: `.animate-in-view-left`, `.animate-in-view-scale` (Task 55)
- `[🟠][🖥️]` ClearDashboardCache trait: extracted to `Admin/Concerns/ClearDashboardCache.php`, applied to 5 controllers (Task 52)
- `[🟠][🖥️]` ImageUploadService: extracted to `Services/ImageUploadService.php`, GalleriaController + MissioneController use method injection (Task 53)
- `[🟠][🧪]` `LightboxGalleria.jsx:70` — `}` → `});` chiusura `memo()` mancante; `CorpoDettaglio.test.jsx:4` — typo import fixtures.js (Task 40)

**Test**: 322 totali (215 PHPUnit + 107 Vitest), tutti verdi.

---

## 11/07/2026

- `[🟠][🎨]` Riscritte 8 viste Blade auth/profile: rimossi 17 handler onfocus/onblur inline, aggiunta `.admin-input-danger`, convertiti hex hardcoded (Task 5.1)
- `[🟠][🎨]` Aggiunto `:root` block in `app.css` con 13 CSS custom properties — sostituiti 52 hex hardcoded in 10 file Blade (Task 5.2)
- `[🟠][🎨]` Partials extraction: `back-link` in 14 file, `search` in 5 index, `stat-card` in 11 include, `show-actions` in 4 file, `index-actions` in 5 file — ~400 righe eliminate (Task 5.3)
- `[🟠][🎨]` Form partial unificato: 5 `_form.blade.php` + 10 create/edit riscritti — ~860 righe eliminate (55%) (Task 5.4)
- `[🔵][📝]` Frontend Design review — audit palette, 7 inconsistenze colore, tipografia, firma visiva SolarSystem, motion, 7 raccomandazioni P4 (Task 10.3)
- `[🔵][📝]` Web Design Guidelines review — 3 high (aria-hidden su link, outline-none, prefers-reduced-motion), 6 medium, 3 low (Task 10.1)
- `[🔵][📝]` Writing Guidelines review — 14 ellipsis, 14 heading case, 10+ passive voice, 16 filler "con successo", mixed Italian/English (Task 10.2)
- `[🟠][🧪]` 5 CRUD test migrati ad extend `AdminTestCase` — eliminati 5 setUp duplicati; DashboardApiTest da 1 a 4 test (Tasks 9.1+9.3+9.7)
- `[🟠][🧪]` 3 nuovi file: CorpoCelesteActionsTest (7 test), GalleriaOrdineTest (6 test), NasaImportTest (8 test) (Task 9.6)
- `[🟠][🎨]` framer-motion → CSS transitions + SolarSystem clickable/immagini realistiche — 87 test Vitest pass (Task 3.4)

**Test**: 260 totali (173 PHPUnit + 87 Vitest), tutti verdi.

---

## 10/07/2026

- `[🔴][🎨]` AbortController in HomePage, CorpiLista, CorpoDettaglio, Comparatore — impedisce `setState()` su componenti smontati
- `[🔴][🎨]` Custom hook `useFetch` con useReducer — centralizza loading/error/data/abort
- `[🔴][🎨]` ErrorBoundary globale in App.jsx con pulsante retry
- `[🔴][🎨]` Guard immagini rotte — CorpoCard, CorpoDettaglio, LightboxGalleria, TimelineMissioni: onError con fallback gradiente+icona
- `[🔴][🎨]` Axios interceptors + retry in apiClient.js — timeout 15s, 3 tentativi
- `[🔴][🖥️]` Observer → Job Queue: `CorpoCelesteObserver::created()` dispatcha `ImportNasaImage` job
- `[🔴][🖥️]` `app/Jobs/ImportNasaImage.php` — NUOVO: queue `import-nasa`, 2 retry, 30s timeout
- `[🔴][🖥️]` `NasaImageService::importAll()` — `CorpoCeleste::all()` → `CorpoCeleste::chunk(50)` riduce memoria
- `[🔴][🖥️]` Rate limiting API: `throttle:60,1` su tutti e 10 gli endpoint
- `[🔴][🖥️]` Caching `searchNasa()`: `Cache::remember(86400)`
- `[🔴][🖥️]` Routes API raggruppate sotto middleware `throttle:60,1` + `throttle:100,1` per dashboard

---

## 09/07/2026

- `[🟠][🖥️]` HasFactory su 5 modelli, observer testing guard (`app()->environment('testing')`), 26 test NasaImageService — 84 test totali (Task 13.0)
- `[🟠][🧪]` Vitest per componenti React — 27 test: CategoriaBadge(5), CorpoCard(10), LightboxGalleria(8), SolarSystem(4) (Task 13.1)
- `[🟠][🧪]` Vitest integrazione API — 61 test: apiClient(12), HomePage(11), CorpiLista(12), CorpoDettaglio(16), Comparatore(10) (Task 13.2)
- `[🟠][🎨]` Dashboard admin con grafici Chart.js — donut corpi/categoria, barre verticali corpi/tipo, barre orizzontali missioni/stato (Task 13.3)
- `[🔴][🖥️]` `curiosita/index.blade.php` — aggiunti 2 `@endif` mancanti; `categorie/index` + `galleria/index` — chiuso `@if` annidati (Task 14.0)
- `[🔴][🎨]` `CorpoCard.jsx` — `isNaN` guard in `formatDistance()`; `App.jsx` + `NotFound.jsx` — route catch-all `path="*"` (Task 14.0)
- `[🔴][🖥️]` `CorpoCelesteController::setImageFromGallery` — ownership check; `MissioneController::show` — eager loading N+1 fix (Task 14.0)
- `[🔴][💾]` Migration `create_missioni_table` — default `stato` da `'completata'` a `'Completata'` (Task 14.0)
- `[🔴][🖥️]` `NasaImageService.php` — `withoutVerifying()` ora solo in `local`/`testing` (Task 14.0)
- `[🔴][🎨]` `CorpoDettaglio.jsx` — unificato import duplicato `Orbit` da lucide-react (Task 14.0)
- `[🔴][🖥️]` Dashboard: 3 query (corpi per categoria, corpi per tipo, missioni per stato) + 3 canvas Chart.js, tema dark (Task 14.0)
- `[🟠][🎨]` Rimossi import morti React: `LightboxGalleria.jsx`, `Comparatore.jsx` (Task 14.1)
- `[🟠][🖥️]` Rimossi: `laravel/sanctum`, `barryvdh/laravel-dompdf`, `@tailwindcss/vite`, `@headlessui/react` (Task 14.1)
- `[🟠][🖥️]` `react`/`react-dom` spostati da devDependencies a dependencies; `@vitejs/plugin-react` spostato da dependencies a devDependencies (Task 14.1)
- `[🟠][🖥️]` CategoriaController::index — `->get()` → `->paginate(20)` + `withQueryString()` (Task 15.0)
- `[🟠][🖥️]` CuriositaController::show — nuovo metodo + vista `curiosita/show.blade.php` (Task 15.0)
- `[🟠][🖥️]` Search/filter admin per Categoria, Missione, Curiosità, Galleria — barra ricerca + `withQueryString()` + "Cancella filtro" (Task 15.1)
- `[🟠][🎨]` SEO meta tags React su 5 pagine guest via `useEffect` + `document.title` (Task 15.2)
- `[🔴][🎨]` Error Boundary globale React — `ErrorBoundary.jsx` con `componentDidCatch`, UI fallback tema dark (Task 15.3)
- `[🟠][🧪]` Admin CRUD test: CategoriaCrudTest(13), MissioneCrudTest(12), CuriositaCrudTest(11), GalleriaCrudTest(11) — 47 test, 335 assertion (Task 15.4)

---

## 08/07/2026

- `[🟠][🖥️]` Auth pages da Inertia a Blade puro — 11 viste Blade con tema scuro, GuestLayout + AppLayout, rimossi `Inertia::render()`/`Inertia::location()` da 9 controller (Task 12.1)
- `[🔴][🖥️]` Rimossa dipendenza Inertia — rimosso `HandleInertiaRequests.php`, cancellati 13 componenti JSX, rimossi composer `inertia-laravel`/`ziggy` e npm `@inertiajs/*`, routes catch-all SPA (Task 12.2)
- `[🟠][🖥️]` FormRequest per validazione CorpoCeleste — `StoreCorpoCelesteRequest` + `UpdateCorpoCelesteRequest`, validazione ridotta da ~40 righe a 2 righe (Task 12.3)
- `[🟠][🖥️]` Quick wins: `per_page=100`, ordinamento default, `.catch(() => {})` → `console.error`, `nasa_id` esposto in Resource, migration indici (Task 12.4)
- `[🔵][📝]` Sistema priorità semplificato: `[🔴]` Critic · `[🟠]` High · `[🔵]` Medium · `[🟢]` Low + format `[Priorità][Topic]` compatto (Task 12.5)
- `[🟠][🖥️]` WordMapService — `translate()` e `guessEnglishName()` estratti da controller; `inRandomOrder()` → `orderBy('nome')->limit(4)` in simili (Wave 1)
- `[🟠][🎨]` Inline styles → Tailwind classi admin in 21 file Blade (Wave 4)
- `[🟠][🎨]` `onMouseEnter`/`onMouseLeave` → CSS `:hover` in 24 file (5 JSX + 19 Blade) — ~270 righe eliminate (Wave 3)
- `[🎨frontend][🟣P3]` Accessibilità: `aria-label` su pulsanti reset/galleria, `role="img"` su fallback icon, SVG decorativi con `aria-hidden="true"` (Wave 2)
- `[🟠][🧪]` Vitest setup: vitest, jsdom, @testing-library — 27 test per 4 componenti React (Task 13.1)
- `[🟠][🧪]` HasFactory su 5 modelli, NasaImageServiceTest (26 test, 63 assertion), observer testing guard — 84 test totali (Task 13.0)

---

## 07/07/2026

- `[🔴][🖥️]` Inertia→Blade: login/logout con `Inertia::location()`, NASA import dedup, preserva `immagine_utente`, colonna `immagine_utente` su `corpi_celesti` (Task 11.0)
- `[🟠][🖥️]` Comando `astralis:gallery` con `--check`/`--clean`/`--sync`/`--fix`/`--dry-run` (Task 11.0)
- `[🟠][🎨]` Galleria: inline ordering (pulsanti su/giù), onerror placeholder, "Imposta come principale" (Task 11.0)
- `[🟠][🖥️]` `uploadImmagine()` con try/catch, `destroy()` skip file locali per URL remoti (Task 11.0)
- `[🟠][🖥️]` Galleria cleanup: sostituite 16 immagini seed mancanti con URL NASA (Task 11.0)
- `[🔴][🖥️]` Authorization: migration `is_admin` su `users`, 5 Policy + Gate `admin`, `$this->authorize()` su tutti i controller CRUD + NasaImport (Task 12.0)

---

## 06/07/2026

- `[🟠][🎨]` GuestLayout, Login, Register: tema scuro (`#0A0A1A`, `#111128`) (Task 10.0)
- `[🔵][🎨]` "Register" link su Login page per nuovi utenti (Task 10.0)
- `[🟠][🎨]` Velocità orbitali differenziate: pianeti lontani ruotano più lentamente (Task 10.0)
- `[🟠][🖥️]` Paginazione admin (`->paginate(20)`) su corpi-celesti, galleria, missioni, curiosità (Task 10.0)

---

## 05/07/2026

- `[🔴][🖥️]` Fix: route() senza virgolette in CorpoCelesteController (Task 9.1)
- `[🔴][🖥️]` Fix: `nasa_id` aggiunto a `$fillable` in CorpoCeleste model (Task 9.1)
- `[🔴][🖥️]` Fix: `categoria_id` dinamico nel seeder (non hard-coded) (Task 9.1)

---

## 04/07/2026

- `[🟠][🖥️]` Remote NASA URLs, `nome_it`, WordMap espansa, apostrophe fallback, auto-suggest admin — `NasaImageService::searchNasa()` riscritto, `suggestNome()` con 50+ termini (Task 10)
- `[🟠][🎨]` Blade views: create/edit con input URL, index/show con URL remoti, show con "Cerca su NASA" (Task 10)
- `[🟠][🎨]` Guest components: `nome_display` con fallback a `nome` in CorpoCard, LightboxGalleria, CorpoDettaglio (Task 10)
- `[🟠][💾]` Migration: colonna `nome_it` su `corpi_celesti` (Task 10)
- `[🟠][🧪]` 25/25 test pass, 61 assertions — Vite build: 3173 moduli, zero errori (Task 10)
- `[🟠][🖥️]` NASA Import multi-immagine: `NasaImageService` NUOVO (searchNasa, getBestImageUrl, extractMetadata, downloadAndProcess, importForBody, importAll) + `FetchNasaCommand` NUOVO (Task 9)
- `[🟠][🖥️]` `NasaImportController` refactor: delega logica a NasaImageService, importSingle ora importa 3 immagini in galleria (Task 9)
- `[🔵][📝]` `docs/progetto.md` → `docs/documentazione.md` rinominato, aggiornata sezione NASA Import (Task 9)
- `[🟠][🖥️]` `NasaImageService::downloadAndProcess()` — memory_limit 512M durante processing; fallback canonical → alternate → preview (Task 9)
- `[🟠][🎨]` Profile navigation: `<Link href="/admin">` → `<a href="/admin">` (Task 7.0)
- `[🟠][🖥️]` NASA Import: mappatura nomi italiano→inglese `$nameMap` (Cerere→Ceres, Terra→Earth) (Task 7.1)
- `[🟠][🖥️]` SSL: `->withoutVerifying()` a chiamate HTTP verso NASA API (solo local/testing) (Task 7.2)
- `[🟠][🖥️]` Intervention Image v3→v4: `read()` → `decodePath()`, `resize()` → `scaleDown()`, `Image::read()` → `ImageManager(new Driver())->decodeBinary()` (Task 7.3)
- `[🟠][🖥️]` Force Import All: `importSingle()` estratto, `importAll()` aggiunto, modale conferma Alpine.js, route POST (Task 7.4)
- `[🟠][🎨]` SolarSystem: orbite matematiche con seno/coseno + `useMotionValue`/`useTransform`, wrapper coordinate, 8 pianeti con etichette leggibili (Task 6.3+6.4)
- `[🟠][🖥️]` NASA Import backoffice: `NasaImportController` + vista `nasa-import/index.blade.php` + route GET/POST, voce sidebar (Task 6.5)
- `[🔵][🖥️]` `/dashboard` redirect → `/admin`, "Torna al sito" → home guest (Task 6.6)
- `[🟠][🎨]` Link "Profilo" nella sidebar admin (Task 6.7)
- `[🟠][🎨]` Pagine profilo adattate al tema scuro — layout dark, label italiane, componenti restilizzati (Task 6.8)
- `[🔴][🎨]` React SPA guest: entry point `main.jsx`, layout navbar+footer, homepage animata con hero + sistema solare + corpi in evidenza, lista corpi con filtri/paginazione (Task 5)
- `[🔴][🎨]` `CorpoDettaglio.jsx`, `LightboxGalleria.jsx`, `TimelineMissioni.jsx`, `Comparatore.jsx` — route, lightbox, timeline, tabella confronto (Task 6)

---

## 03/07/2026

- `[🔴][🖥️]` API REST: 5 Resource classes, 6 API Controllers, 10 endpoint JSON, filtri, route model binding con slug, bootstrap api.php (Task 4)
- `[🔴][🖥️]` Admin layout Blade: sidebar navigazione, palette scura (`#0A0A1A`, `#111128`, `#22D3EE`), dashboard con statistiche, tailwind.config.js esteso (Task 3)
- `[🔴][🖥️]` CRUD Categorie: index, create, store, show, edit, update, destroy; protezione eliminazione; color picker con palette 10 colori (Task 3)
- `[🔴][🖥️]` CRUD Corpi Celesti: index, create, store, show, edit, update, destroy (Task 3)
- `[🔴][🖥️]` CRUD Missioni: upload logo (Intervention Image, resize 300px), badge stato, vista show con dettagli, storage dedicato (Task 3)
- `[🔴][🖥️]` CRUD Curiosità: index, create, store, edit, update, destroy; route `{curiositum}` (Task 3)
- `[🔴][🖥️]` CRUD Galleria: upload immagini (Intervention Image, resize 1200px), index a griglia, route `{galleriaCorpo}` — Fase 2 completata (Task 3)
- `[🔴][💾]` Installati pacchetti: spatie/laravel-sluggable, intervention/image, barryvdh/laravel-dompdf; 6 migrations, 5 Models, 7 seeders con dati reali, admin user (Task 2)

---

## 02/07/2026

- `[🖥️backend][🎨frontend][🔴][📝]` Setup iniziale: Laravel v13.18.0, Breeze con React stack, .env (MySQL :3307), APP_KEY generata (Task 1)

---

## Formato

Ogni entry usa il formato:

```
- `[🔴][🖥️]` Descrizione — `file/coinvolto`
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
