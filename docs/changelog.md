# Changelog

## Fix proxy API + graphify setup (17/07/2026 — sessione 2)

- **Bug critico** — `vite.config.js`: aggiunto `server.proxy: { '/api': 'http://localhost:8000' }` — senza proxy, le chiamate API in dev mode fallivano con CORB (Cross-Origin Read Blocking). La pagina appariva bianca perché il browser bloccava le risposte JSON cross-origin
- **graphifyy installato** — CLI knowledge graph (`pip install graphifyy` v0.9.17). Grafo aggiornato: 1647 nodi, 2587 edges, 213 community. Snapshot salvato in `graphify-out/2026-07-17/`
- **Docs alignment** — Fixed React 19→18 in AGENTS.md + SKILL.md, test count 252/359 in 5 file docs, task numbering in todo.md, changelog 17/07 sessione 1
- **Logo assets** — 3 PNG ad alta risoluzione caricati in `public/`: `astralis_logo_completo.png`, `astralis_solo_logo.png`, `astralis_solo_testo.png`
- **28 nuovi test** — CorpoCelesteTest (6 accessor), ImportNasaImageTest (9 job), CorpoCelesteActionsTest (13 admin actions)

**Test**: 359 totali (252 PHPUnit + 107 Vitest), tutti verdi.

## Bug residui — fix (17/07/2026 — sessione 1)

- **Navbar mobile** — `Navbar.jsx`: Escape key handler, click-outside overlay, close on route change via `useEffect`
- **Test accessor** — `CorpoCelesteTest.php`: 6 test per `nome_display` e `immagine_url` accessors
- **Test actions** — `CorpoCelesteActionsTest.php`: 6 nuovi test (setImageFromGallery, suggestNome)
- **Test job** — `ImportNasaImageTest.php`: 9 test (ShouldQueue, ShouldBeUnique, tries, timeout, uniqueId, handle, failed)
- **framer-motion** mantenuto in `SolarSystem.jsx` (uso legittimo per orbite `useMotionValue`/`useTransform`)

**Test**: 359 totali (252 PHPUnit + 107 Vitest), tutti verdi.

## Quick wins — 7 fix (16/07/2026)

- **B1** — `Admin/CorpoCelesteController.php`: `where`/`orWhere` search wrapped in closure — SQL precedence bug fixed
- **B3** — `CorpoCeleste.php`: fixed 8-space indent → 4-space on `getNomeDisplayAttribute`
- **F8** — `Navbar.jsx` + `Footer.jsx`: logo `w-24 h-24` (96px) → `w-10 h-10` (40px) — was overflowing h-16 navbar
- **F7** — `SearchBar.jsx`: added `focus-visible:ring-2 focus-visible:ring-admin-primary/50` for keyboard accessibility
- **F3** — `Comparatore.jsx`: replaced hardcoded `[#F97316]` with `admin-accent`, inline hex `#0E0E24`/`#111128` with `bg-admin-bg`/`bg-admin-card`
- **B10** — `flash.blade.php`: refactored 3 identical blocks (35 lines) into 1 `@foreach` loop (22 lines)
- **F4** — `CorpiLista.jsx`: extracted inline `useDebounce` to shared `hooks/useDebounce.js`

**Test**: 252 PHPUnit + 107 Vitest, tutti verdi.

## Sidebar + Blade Partials Refactoring (16/07/2026)

- **config/admin.php**: centralizzato nav_items (7 voci), mission_stati, mission_stato_default, color_presets
- **_sidebar-nav.blade.php**: lettura nav da config, `Route::is()` per active state
- **category-badge.blade.php**: badge riusabile con `$color`, `$name`, `$size`, `$withDot` — wired in 6 file
- **index-header.blade.php**: header pagine index con titolo, descrizione, pulsante crea — wired in 5 file
- **dashboard-stat.blade.php**: card statistiche dashboard con `$color`, `$icon`, `$value`, `$label` — wired in dashboard (4 card)
- **empty-table-row.blade.php**: stato tabella vuota con `$colspan`, `$message` — wired in 5 file
- **in-evidenza-badge.blade.php**: badge "in evidenza" riusabile — wired in corpi-celesti/index+show
- **flash in layout master**: `@include('admin.partials.flash')` in `layouts/app.blade.php` — fix bug flash non mostrati su dashboard
- **CSS vars**: `green-500`/`red-500` → `admin-success`/`admin-error` in flash + show-actions
- **Route::is()**: sostituito fragile `str_starts_with` + `explode` per active state sidebar

## Sicurezza e UX — Fasi 1-3 (15/07/2026)

### Fase 1 — Security fixes
- **C1** — `User.php`: rimosso `is_admin` da `#[Fillable]` — previene privilege escalation
- **C5** — `StoreCategoriaRequest.php`: `colore` validato con regex `^#[0-9A-Fa-f]{6}$` — previene CSS injection
- **C2** — `StoreGalleriaCorpoRequest.php` + `UpdateGalleriaCorpoRequest.php`: `didascalia` max ridotto da 500 a 255 (allineato a DB)
- **H1+H2** — `routes/web.php`: `throttle:120,1` su route admin, `throttle:30,1` su `suggestNome`
- **H3** — Migration: `categoria_id` FK cambiata da `cascadeOnDelete` a `restrictOnDelete`

### Fase 2 — Critical bug fixes
- **C3** — `apiClient.js`: retry con config clonata + 2 abort signal check — fix state mutation e crash
- **C4** — `CorpoDettaglio.jsx`: `similiSlugRef` verifica slug match prima di `setSimili()` — fix race condition
- **H4** — `ImportNasaImage.php`: `ShouldBeUnique` + `uniqueId()` su `corpo->id`, timeout 120s→60s
- **H13** — `color-picker-js.blade.php`: IIFE con null guard + sync su form submit
- **H15** — `nasa-import/index.blade.php`: messaggio conferma corretto

### Fase 3 — UX & quality improvements
- **H7** — `useFetch.js`: START preserva dati esistenti (`{ ...state, loading: true }`)
- **H8** — `Comparatore.jsx`: state derivato direttamente da `searchParams` — eliminata dipendenza circolare
- **H9** — `Navbar.jsx`: hamburger toggle mobile responsive con Menu/X icons
- **H11** — `CorpoDettaglio.jsx`: gravita/temperatura null-safe con `toLocaleString('it-IT')`
- **M1+M2** — `flash.blade.php`: auto-dismiss 5s, fade-out, bottone chiudi, ARIA roles

**Test**: 338 totali (231 PHPUnit + 107 Vitest), tutti verdi.

## Fix Dashboard Cache Bug (14/07/2026)

- **Bug critico** — `DashboardController`: rimosso `Cache::remember('admin.dashboard')` che causava `Attempt to read property "nome" on string`. Causa radice: `serializable_classes: false` in `config/cache.php` impediva la deserializzazione di oggetti Eloquent dal database cache
- `ClearDashboardCache.php`: rimosso `Cache::forget('admin.dashboard')` (non più necessario), mantenuto `Cache::forget('api.dashboard.stats')`
- `ImportNasaImage.php`: rimosso `Cache::forget('admin.dashboard')`, mantenuto `Cache::forget('api.dashboard.stats')`
- 5 controller admin: trait `ClearDashboardCache` mantenuto solo per invalidazione cache API

## Ottimizzazioni NASA Import — P1/P2 (14/07/2026)

- **P2** — `CleanupGalleryDuplicates::headRequest()`: rimosso `withoutVerifying()` ridondante (chiamato 2 volte)
- **P6** — `WordMapService::translate()`: ora prova prima le chiavi compound ("Via Lattea", "Buco Nero") prima del word-by-word
- **O6** — `NasaImportController::importAll()`: dispatch con `delay(now() + 2s * index)` per evitare flooding della coda
- **O9** — `NasaImageService::searchNasa()`: cache NASA ora memorizza solo metadati essenziali (nasa_id, title, photographer, description, keywords, links) invece della response intera

## Bugfix NASA Import — B1-B6 (14/07/2026)

- **B1** — `ImportNasaImage::$galleryCount`: default 3→5, uniformato con controller e command
- **B2** — `ImportNasaImage`: aggiunti `$tries=3`, `$timeout=120`, metodo `failed()` con Log::error
- **B3** — `NasaImageService::importAll()`: rimosso `set_time_limit(300)` (inefficace nei queue worker)
- **B4** — `NasaImportController::index()`: `->get()` → `->paginate(20)` + links nella view
- **B5** — `NasaImportController::importAll()`: filtra solo corpi senza immagine (`whereNull('immagine')`)
- **B6** — Note `nasa-import/index.blade.php`: aggiornato — gli URL sono ora remoti NASA, non file locali
- Bonus: `ImportNasaImage::handle()` ora invalida cache dashboard dopo import

## Tasks 65-70 — Test Coverage Expansion (14/07/2026)

- **Task 65** — WordMapServiceTest: 8 test (translate known/unknown/empty/compound, planet names, prepositions, guessEnglishName)
- **Task 66** — CleanupGalleryDuplicatesTest: 9 test (dedup keeps first, dry-run, no-duplicates warning, orphan clean/check, broken/working remote URLs, different corpi same path)
- **Task 67** — Frontend tests: NotFound(4), ErrorBoundary(4), TimelineMissioni(8), Navbar(6) — 22 new Vitest
- **Task 69** — SearchAndFilterTest: 10 test (search across 5 entities, wildcard %/ _ escaping, stato filter)
- **Task 70** — ApiEdgeCaseTest: 17 test (percent/underscore, per_page zero, agenzia+stato, empty DB, factory, dashboard, galleria/curiosita)
- **Total**: 322 test (215 PHPUnit + 107 Vitest), 522+ assertion — tutti verdi

## Tasks 60-64 — Accessibility, Tailwind, Delete Protection (14/07/2026)

- **Task 60** — Inline styles → Tailwind in Blade: guest.blade.php, layouts/guest.blade.php, profile/edit.blade.php
- **Task 61** — Inline rgba() → Tailwind admin-primary/XX in 20 JSX components
- **Task 62** — Inline styles → Tailwind in Comparatore.jsx, HomePage.jsx (#1CB8D0 → hover:brightness-110)
- **Task 63** — Accessibility: `scope="col"` on 43 `<th>` elements, `aria-label` on search inputs, `aria-label` on Navbar, `aria-current="page"` on active nav
- **Task 64** — Loading skeletons: `role="status" aria-label="Caricamento..."` on all skeletons
- **Task 59** — GalleriaController delete protection: blocks deletion if image used as main CorpoCeleste image
- **Task 58** — Curiosita showRoute + mission-stato-badge partial extracted
- **Task 57** — Removed `@testing-library/user-event` dep, dead `fetchMissioni` tests
- **Task 56** — Config fixes: `locale=it`, `name=Astralis`, `APP_LOCALE=it`
- **Task 55** — Removed unused CSS: `.animate-in-view-left`, `.animate-in-view-scale`

## Tasks 52-53 — DRY Refactoring (14/07/2026)

- **Task 52** — ClearDashboardCache trait: extracted to `Admin/Concerns/ClearDashboardCache.php`, applied to 5 controllers, removed 16 duplicate Cache::forget pairs
- **Task 53** — ImageUploadService: extracted to `Services/ImageUploadService.php`, GalleriaController + MissioneController use method injection

## Task 40 — Debug generale post-ottimizzazione

### 14/07/2026 — fix: 2 bug Vitest (LightboxGalleria memo close + CorpoDettaglio import typo)
- `LightboxGalleria.jsx:70`: `}` → `});` — chiusura `memo()` mancante, causava parse error in 2 file di test
- `CorpoDettaglio.test.jsx:4`: `mockCorpoDettaglioDettaglio` → `mockCorpoDettaglio` — typo nell'import da fixtures.js
- **260 test totali** (173 PHPUnit + 87 Vitest), tutti verdi

## Ottimizzazione — UI/UX Review (Fase 10)

### Task 10.3 — 11/07/2026 — Frontend Design review
- **Audit completo** del design system frontend React SPA (9 componenti + 5 pagine) + tailwind.config.js + app.css + 3 layout Blade
- **Palette & Coerenza** — Il tema deep navy + cyan/purple/orange è distintivo e coerente col subject (astronomia). La scelta non è generica: i colori derivano dal mondo celeste (cyan = Terra, purple = Galassia, orange = Sole/Venere, yellow = Giove). La palette non è un template AI generico.
- **Inconsistenze colore** (7 trovate):
  - `#1CB8D0` su CTA HomePage — unico nel progetto, non corrisponde a nessun token (il cyan corretto è `#22D3EE`)
  - `#1A1A2E` su badge text CorpoCard — colore non definito in nessun config/variabile
  - 4 variabili CSS (`--admin-success`, `--admin-error`, `--admin-neutral`, `--admin-chart-text`) senza corrispondente Tailwind token → inutilizzabili come classi utility
  - 25+ valori `rgba()` scritti a mano dove Tailwind opacità modifier (`admin-primary/8`) farebbe lo stesso lavoro
  - `text-gray-400` (Tailwind default) usato in 8+ posti admin accanto a `text-admin-muted` e `text-admin-dim` per lo stesso ruolo → 3 grigi diversi per "testo secondario"
- **Tipografia** — Figtree è clean e leggibile, ma è una scelta comune (usa geometric sans). Il peso 800 (extrabold) è caricato solo in `guest.blade.php` e usato in 3 posti (HomePage hero h1, CorpoDettaglio h1, Comparatore h1). I layout admin e alternativo caricano solo 400-700 → se il wrong layout viene cachato, gli 800-weight glyphs cadono a 700.
- **Firma visiva** — Il SolarSystem è l'elemento unico: modello orbitale interattivo con framer-motion, immagini reali Wikipedia, stelle twinkle CSS, sole pulsante con glow multi-livello. Non è un template — è un componente costruito specificamente per questo progetto.
- **Layout** — Container pattern coerente (`max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`) con eccezioni deliberate: `max-w-5xl` per CorpoDettaglio/NotFound (meno card = meno width), `max-w-6xl` per Comparatore (table). Grid responsive coerente. Card pattern consistente (`rounded-xl bg-admin-card border border-admin-primary/10 p-4`).
- **Motion** — Animazioni deliberate: orbital planets (framer-motion), twinkle stars (CSS), scroll-triggered fade-up (IntersectionObserver), sun pulse. Il 93% delle animazioni serve il subject (astronomia = movimento continuo). Manca `prefers-reduced-motion` per utenti con disturbi vestibolari.
- **Valori hardcoded da estrarre** — 23 colori unici in JSX, di cui 8 in SolarSystem (colori pianeti — giustificati), 4 in constants.js (gradienti fallback — giustificati), 11 sparsi in inline styles → 6 potrebbero usare Tailwind tokens esistenti.
- **Raccomandazioni** (non bloccanti, P4):
  1. Sostituire `#1CB8D0` con `hover:bg-admin-primary` su CTA HomePage
  2. Registrare `#1A1A2E` come CSS variable o usare `text-admin-bg` per badge
  3. Aggiungere `admin.success`, `admin.error`, `admin.neutral`, `admin.chart-text` a tailwind.config.js
  4. Convertire `rgba()` hardcoded in Tailwind opacity modifiers dove possibile
  5. Allineare font-weight 800 in admin layout o rimuovere da guest (consiglia: tenere solo in guest)
  6. Aggiungere `@media (prefers-reduced-motion: reduce)` per disabilitare animazioni continue
  7. Unificare `text-gray-400` → `text-admin-muted` in admin



### Task 10.1 — 11/07/2026 — Web Design Guidelines review
- **Audit completo** di 14 file React (9 componenti + 5 pagine) contro le Web Interface Guidelines
- **High priority** (da fixare):
  - `SolarSystem.jsx:93` — `aria-hidden="true"` su container che wrappa link interattivi → tutta la navigazione pianeti invisibile agli screen reader
  - `SearchBar.jsx:16`, `Comparatore.jsx:81` — `outline-none` senza `focus-visible:ring-*` replacement → utenti tastiera non vedono focus
  - Progetto-wide: nessun `@media (prefers-reduced-motion)` definito → utenti con disturbi vestibolari non possono disabilitare animazioni continue
- **Medium priority**:
  - 22 occorrenze `transition-all` in 11 file → animano proprietà layout inutilmente
  - 4 icone decorative mancanti `aria-hidden="true"` (TimelineMissioni, CorpoDettaglio)
  - `CorpiLista.jsx:144` — manca `aria-live` per risultati async
  - `Comparatore.jsx:74/78` — `<label>` e `<select>` non associati programmaticamente
- **Low priority**:
  - `CorpiLista.jsx:173` — "..." ASCII invece di "…" ellipsis
  - `CorpoCard.jsx:50`, `CorpoDettaglio.jsx:109` — text overflow non troncato
  - `SearchBar.jsx:11` — input senza autocomplete/name

### Task 10.2 — 11/07/2026 — Writing Guidelines review
- **Audit completo** di ~22 file (React componenti/pagine + Blade admin + Controller) contro le Writing Guidelines
- **Ellipsis `...` → `…`**: 14 occorrenze in 13 file (placeholder, loading state, pagination)
- **Title Case → Sentence case**: 14 heading in 8 file (HomePage, CorpiLista, Comparatore, CorpoDettaglio, dashboard, show views)
- **Passive voice**: 10+ occorrenze in empty states ("Nessun corpo celeste trovato") e flash messages ("Impossibile eliminare: ci sono corpi celesti associati")
- **Filler "con successo"**: 16 flash messages in 5 controller — rimuovere (il flash verde già indica successo)
- **Mixed Italian/English**: NASA import page — "Force Import All", "Image Library" in italiano
- **Missing NBSP in units**: 8+ occorrenze in CorpoDettaglio, Comparatore, utils.js
- **Marketing voice**: "immagini spettacolari", "Scopri i segreti del cosmo" — riscrivere in modo concreto
- **Em dash come punteggiatura**: Footer.jsx — usare `|` o `·` invece di `—`

## Ottimizzazione — Test Refactoring (Fase 9)

### Tasks 9.1 + 9.3 + 9.7 — 11/07/2026 — AdminTestCase refactoring + Http::fake uniform + DashboardApiTest
- 5 CRUD test migrati ad extend `AdminTestCase` — eliminati 5 setUp duplicati, 5 `use RefreshDatabase`, 5 import TestCase
- CategoriaCrudTest, MissioneCrudTest: setUp rimosso completamente (orphaned `$this->admin` rimosso)
- CuriositaCrudTest, GalleriaCrudTest, CorpoCelesteCrudTest: setUp ridotto a 2-3 righe (solo factory props)
- `unsetEventDispatcher`/`setEventDispatcher` rimosso da GalleriaApiTest — pattern obsoleto sostituito da Http::fake()
- `Http::fake()` aggiunto a MissioneApiTest (prima mancante, per coerenza)
- DashboardApiTest: da 1 test (3 campi) a 4 test (counts + corpi_in_evidenza + ultimi_corpi + missioni_per_stato)
- 133 test, 364 assertion — tutti verdi

### Tasks 9.6 — 11/07/2026 — Copertura test mancante
- 3 nuovi file: CorpoCelesteActionsTest (7 test: suggestNome validazione/success/failure/guest + setImage success/ownership/guest), GalleriaOrdineTest (6 test: su/giù/zero/validation/required/guest), NasaImportTest (8 test: index/import/importAll/guest/non-admin)
- suggestNome test: mock NasaImageService via Mockery (Http::fake + Cache::remember layered caching)
- Bus::fake() per NasaImportTest (verifica dispatch job senza eseguire)
- 154 test, 414 assertion — tutti verdi

## Ottimizzazione P1

### Task 5.1 — 11/07/2026 — admin-input class per auth/profile views
- Riscritte 8 viste Blade auth/profile: login, register, forgot-password, reset-password, confirm-password, update-profile-information, update-password, delete-user
- Rimossi 17 handler onfocus/onblur inline + attributi style
- Aggiunta variante `.admin-input-danger` in app.css per campi eliminazione
- Convertiti pulsanti a classi `admin-btn-primary` / `admin-btn-cancel`
- Convertiti hex hardcoded a Tailwind utility classes (text-admin-text, text-admin-dim, text-admin-accent)
- -85 righe, eliminazione stili inline su form auth

### Task 5.2 — 11/07/2026 — Hardcoded hex → CSS variables
- Aggiunto `:root` block in `app.css` con 13 CSS custom properties (admin palette + success/error/neutral/chart-text)
- Sostituiti 52 valori hex hardcoded in 10 file Blade con `var(--admin-xxx)`
- File modificati: guest.blade.php, layouts/guest.blade.php, dashboard.blade.php, missioni/index+show, corpi-celesti/show, nasa-suggest-js, color-picker-html, galleria/index, categorie/edit, nasa-import/index, verify-email
- Rimossi onmouseover/onmouseout da verify-email.blade.php (convertiti a classi admin-btn-*)
- Cambio palette ora richiede modifica di un singolo blocco `:root`

### Task 5.3 — 11/07/2026 — Partials extraction completa
- Wired `back-link` in 14 file (tutti create/edit/show) — eliminati 14 blocchi inline
- Wired `search` in 5 index pages — eliminati 5 form inline, aggiunto param `extraFilters` per missioni
- Enhanced `flash.blade.php` — aggiunto supporto session `warning`
- Wired `flash` in nasa-import/index — eliminati 3 blocchi flash inline
- Created `stat-card.blade.php` — 11 include in corpi-celesti/show (8) + missioni/show (3)
- Created `show-actions.blade.php` — 4 include in tutti i show pages, harmonizzato stile curiosita/show
- Created `index-actions.blade.php` — 5 include in tutti i index pages, param `size=sm` per galleria
- Fixed missioni create/edit button styles → admin-btn-primary / admin-btn-cancel
- ~400 righe di HTML inline eliminate

### Task 5.4 — 11/07/2026 — Form partial unificato create/edit
- Created 5 `_form.blade.php` partials: categorie (48L), corpi-celesti (146L), curiosita (62L), galleria (83L), missioni (84L)
- Rewritten 10 create/edit files to use form partials (media 14 righe vs 70-156 prima)
- Pattern: `$isEdit = isset($entity)` + `old('field', $entity->field ?? null)` per tutti i campi
- Structural diffs gestite con `@if($isEdit)`: preview immagini, required attributes, help text, enctype
- ~860 righe eliminate (55% delle 1311 originali)

## Fase 0 — Setup

### 0.1 — 02/07/2026 — `6df5099` — feat: setup iniziale Laravel + Breeze + React + documentazione
- Creazione progetto Laravel v13.18.0
- Installazione Breeze con React stack
- Configurazione .env (MySQL :3307, DB: astralis)
- Generazione APP_KEY

## Fase 1 — Database e Modelli

### 1.0 — 03/07/2026 — `0a57208` — feat: database e modelli con seeders
- Installati pacchetti: spatie/laravel-sluggable, intervention/image, barryvdh/laravel-dompdf
- Creazione database MySQL `astralis`
- 6 migrations: categorie, corpi_celesti, galleria_corpi, missioni, curiosita, corpo_celeste_missione
- 5 Eloquent Models con relazioni e sluggable
- 7 seeders con dati reali (8 categorie, 18 corpi celesti, 10 missioni, 16 galleria, 18 curiosità, 17 relazioni pivot)
- Utente admin: admin@astralis.it / password

## Fase 2 — Backoffice Blade CRUD

### 2.1 — 03/07/2026 — `070da55` — feat: admin backoffice layout, sidebar navigation e dashboard
- Admin layout Blade con sidebar navigazione (tema scuro palette `#0A0A1A`, `#111128`, `#22D3EE`)
- Dashboard admin con statistiche (conteggio entità) e tabella ultimi corpi celesti
- Route `/admin` protette da auth Breeze
- Estensione tailwind.config.js con colori admin
- Fix: aggiunto `resources/js/bootstrap.js` mancante per Vite build

### 2.2 — 03/07/2026 — `758be4c` — feat: CRUD categorie backoffice
- CRUD completo Categorie (index, create, store, show, edit, update, destroy)
- Protezione eliminazione: se ci sono corpi celesti associati, bloccata con messaggio errore
- Color picker con palette rapida 10 colori nei form create/edit
- Vista show con conteggio corpi associati
- Fix: aggiunto `resources/js/bootstrap.js` mancante (bloccava build Vite)

### 2.3 — 03/07/2026 — `18a6b20` — feat: CRUD corpi celesti backoffice
- CRUD completo Corpi Celesti (index, create, store, show, edit, update, destroy)

### 2.4 — 03/07/2026 — `6d86177` — feat: CRUD missioni backoffice
- CRUD completo Missioni (index, create, store, show, edit, update, destroy)
- Upload logo con Intervention Image (resize 300px, max 1MB, supporto SVG)
- Badge stato colorato: Completata (verde), In corso (ciano), Pianificata (giallo)
- Vista show con dettagli missione + tabella corpi celesti esplorati
- Storage dedicato `storage/app/public/missioni/`

### 2.5 — 03/07/2026 — `2f8a67e` — feat: CRUD curiosità backoffice
- CRUD completo Curiosità (index, create, store, edit, update, destroy — senza show)
- Route resource con parametro `{curiositum}` (singolare latino di "curiosita")
- Vista index con tabella titolo, corpo celeste (link), descrizione, fonte
- Vista create con select corpo celeste, titolo, textarea descrizione, fonte opzionale

### 2.6 — 03/07/2026 — `99615bb` — feat: CRUD galleria backoffice
- CRUD completo Galleria (index, create, store, edit, update, destroy — senza show)
- Upload immagini con Intervention Image (resize 1200px, storage `public/galleria/`)
- Vista index a griglia con card thumbnail, didascalia, corpo celeste, crediti, ordine
- Route resource con parametro `{galleriaCorpo}`
- **Fase 2 completata** (tutti e 6 i CRUD)

## Fase 3 — API REST

### 3.0 — 03/07/2026 — feat: API REST (10 endpoint JSON)
- 5 API Resource classes: CorpoCelesteResource, CategoriaResource, MissioneResource, CuriositaResource, GalleriaCorpoResource
- 6 API Controllers: CorpoCeleste, Categoria, Missione, Curiosita, Galleria, Dashboard
- 10 endpoint JSON in `routes/api.php`
- Filtri su GET `/api/corpi-celesti`: categoria (slug), tipo, search, in_evidenza, per_page
- Filtri su GET `/api/missioni`: agenzia, stato
- Route model binding con slug su show endpoints
- Bootstrap app.php configurato per caricare api.php

## Fase 4 — React Guest Frontend

### 4.0 — 04/07/2026 — feat: React SPA guest (homepage + lista corpi celesti)
- Architettura: React standalone (separato da Inertia), comunicazione via API REST
- Entry point Vite separato `resources/js/guest/main.jsx`
- Layout guest con navbar + footer tema spazio (palette `#0A0A1A`)
- Homepage animata: hero + sistema solare (framer-motion) + corpi in evidenza
- Pagina lista corpi celesti con griglia, filtri (categoria, tipo, ricerca), paginazione
- Dipendenze: framer-motion, react-router-dom, lucide-react, axios
- Route `/` guest sostituisce Welcome Inertia

## Fase 5 — React Guest Dettaglio, Lightbox, Missioni, Comparatore

### 5.0 — 04/07/2026 — `0e18a60` — feat: dettaglio corpo celeste, lightbox, timeline missioni, comparatore pianeti
- Installato yet-another-react-lightbox per lightbox galleria immagini
- Creata pagina `CorpoDettaglio.jsx`: hero immagine, metriche scientifiche, scoperta, curiosità
- Creato componente `LightboxGalleria.jsx`: lightbox con slideshow immagini
- Creato componente `TimelineMissioni.jsx`: timeline orizzontale missioni con indicatori
- Creata pagina `Comparatore.jsx`: selezione due pianeti, tabella confronto metriche
- Route aggiunte: `/corpi-celesti/:slug` → dettaglio, `/confronta` → comparatore
- Link a comparatore dalla sidebar dettaglio (solo per categoria Pianeta)
- Corpi simili nella sezione finale del dettaglio

## Fase 6 — Fix sistema solare, NASA Import, Profilo, Documentazione

### 6.0 — 04/07/2026 — `45e01ad` — docs: Fase 6 completata
- Documentazione finale aggiornata

### 6.1 — 04/07/2026 — `fde7aaf` — fix: orbita pianeti - transformOrigin centrato sul Sole
- Primo tentativo: centrare rotazione pianeti sul Sole via CSS transformOrigin
- Risultato: orbite circolari ma etichette e dettagli ruotano con i pianeti

### 6.2 — 04/07/2026 — `a6e612a` — fix: etichette pianeti solidali e contro-rotanti nell orbita
- Secondo tentativo: contro-rotazione delle etichette per mantenerle dritte
- Parziale: etichette leggibili ma posizionamento non preciso

### 6.3 — 04/07/2026 — `4e354ea` — fix: orbita pianeti con useMotionValue/useTransform
- Riscrittura completa: orbite matematiche con seno/coseno invece di rotate CSS
- `useMotionValue` + `useTransform` per calcolare coordinate x/y in tempo reale
- Testo delle etichette sempre dritto (nessuna contro-rotazione necessaria)

### 6.4 — 04/07/2026 — `196dd15` — fix: orbite e pianeti allineati al Sole
- Wrapper coordinate comune per allineare perfettamente orbite e pianeti al centro del Sole
- Sistema solare completamente funzionante: 8 pianeti orbitano con etichette leggibili

### 6.5 — 04/07/2026 — `aed8789` — feat: NASA Import da API nel backoffice
- `NasaImportController.php` — index (tabella corpi con badge Presenza/Assente) + import (cerca su NASA API, scarica, salva)
- Vista `resources/views/admin/nasa-import/index.blade.php` — tabella con bottoni "Importa da NASA" (ciano) e "Forza import" (arancione)
- Route GET `admin/nasa-import` e POST `admin/nasa-import/{corpoCeleste}`
- Voce sidebar "NASA Import" con icona refresh
- `config/services.php` — array `nasa.key` da `.env`

### 6.6 — 04/07/2026 — `c82001d` — fix: /dashboard reindirizza a /admin, Torna al sito alla home guest
- Route `/dashboard` (Inertia) → redirect a `/admin`
- Link "Torna al sito" nella sidebar admin → `route('home')` (guest SPA)

### 6.7 — 04/07/2026 — `5ade134` — feat: link Profilo nella sidebar admin
- Aggiunto link "Profilo" nella sidebar admin sotto "Torna al sito"
- Icona User per il link profilo

### 6.8 — 04/07/2026 — `aa1ff42` — feat: pagine profilo adattate al tema scuro
- `Profile/Edit.jsx` — nuovo layout dark (sfondo `#0A0A1A`, card `#111128`), link "Torna all'admin"
- 3 partials aggiornati: label italiane (Nome, Password Attuale, Elimina Account...)
- Shared components restilizzati: TextInput (dark), InputLabel (`#B8B8D0`), PrimaryButton (cyan), SecondaryButton (dark), Modal (dark)

## Fase 7 — Bugfix Intervention Image v4, NASA Import Force All, Documentazione

### 7.0 — 04/07/2026 — fix: Profile navigation — Link Inertia → a tag per href esterno
- `resources/js/Pages/Profile/Edit.jsx`: sostituito `<Link href="/admin">` con `<a href="/admin">` per evitare che Inertia intercetti la navigazione verso pagine Blade

### 7.1 — 04/07/2026 — fix: NASA Import — mappatura nomi italiano→inglese
- `NasaImportController.php`: aggiunto array `$nameMap` (Cerere→Ceres, Terra→Earth, ecc.) per cercare nomi inglesi su NASA API

### 7.2 — 04/07/2026 — fix: SSL cURL error 60 su Windows
- `NasaImportController.php`: aggiunto `->withoutVerifying()` a tutte e 3 le chiamate HTTP verso NASA API

### 7.3 — 04/07/2026 — fix: Intervention Image v3→v4 API migration
- `CorpoCelesteController.php`: `read($file->getRealPath())` → `decodePath($file->getRealPath())`, `resize(closure)` → `scaleDown(width: 800, height: 800)`
- `MissioneController.php`: stesso fix, `scaleDown(width: 300, height: 300)`
- `GalleriaController.php`: stesso fix, `scaleDown(width: 1200, height: 1200)`
- `NasaImportController.php`: `Image::read()` → `ImageManager(new Driver())->decodeBinary()`

### 7.4 — 04/07/2026 — feat: Force Import All con Alpine.js modal
- `NasaImportController.php`: estratto metodo privato `importSingle()`, refactor `import()` per riutilizzo, aggiunto metodo `importAll()` che processa tutti i corpi celesti
- `routes/web.php`: aggiunta route POST `nasa-import/import-all`
- `resources/views/admin/nasa-import/index.blade.php`: bottone "Force Import All" (#F97316), modale conferma Alpine.js (`x-data`, `x-show`, `x-cloak`, `@click.away`), blocco `session('warning')` per risultati misti
- `resources/views/admin/layouts/app.blade.php`: aggiunto Alpine.js CDN + style `[x-cloak]`

## Fase 8 — NASA Import multi-immagine, Service Layer, CLI Command

### 8.0 — 04/07/2026 — feat: NASA Import multi-immagine in galleria + CLI fetch-nasa + metadati
- `database/migrations/...add_nasa_id_to_corpi_celesti_table.php`: nuova colonna `nasa_id` su `corpi_celesti`
- `app/Services/NasaImageService.php` — **NUOVO**: service centralizzato con metodi:
  - `searchNasa(string $query): array` — ricerca su NASA Image API
  - `getBestImageUrl(array $item): ?string` — URL preferito: canonical (~orig) > alternate > preview
  - `extractMetadata(array $item): array` — estrae nasa_id, title, photographer, description
  - `downloadAndProcess(string $url, string $filename, string $storageDir, int $width, int $height): ?string` — download, process, salva
  - `importForBody(CorpoCeleste, int $galleryCount = 5, bool $force = false, bool $updateDescription = false): array` — import completo per un corpo (1 main + N galleria)
  - `importAll(...): array` — import per tutti i corpi
- `app/Console/Commands/FetchNasaCommand.php` — **NUOVO**: `php artisan astralis:fetch-nasa` con opzioni `--force`, `--gallery=N`, `--update-description`
- `app/Http/Controllers/Admin/NasaImportController.php` — refactor: delega logica a `NasaImageService`, importSingle ora importa anche 3 immagini in galleria
- `docs/progetto.md` → `docs/documentazione.md`: rinominato, aggiornata sezione NASA Import e guida installazione
- `README.md`: aggiunto comando `astralis:fetch-nasa` nell'installazione

### 8.1 — 04/07/2026 — fix: memory limit per immagini NASA grandi + fallback URL per item
- `NasaImageService.php`: `downloadAndProcess()` ora imposta `memory_limit = 512M` durante il processing, ripristina il valore originale al termine
- `importForBody()`: per ogni item tenta canonical (~orig) → alternate (~small senza conversione) → preview (~thumb senza conversione) prima di passare all'item successivo
- Rimosso metodo `getBestImageUrl()` (dead code, convertiva ~small/~thumb in ~orig nei fallback)

## Fase 9 — Remote URLs, nome_it, WordMap, Apostrophe Fallback

### 9.0 — 04/07/2026 — feat: remote NASA URLs, nome_it, wordMap espansa, apostrophe fallback, auto-suggest
- **CorpoCeleste Model**: aggiunto campo `nome_it` (nome italiano) + accessor `getNomeDisplayAttribute()` che restituisce `nome_it ?? nome`
- **CorpoCelesteResource**: aggiunto `nome_display` nell'output JSON API
- **GalleriaCorpoResource**: aggiunto `nome_display` del corpo celeste associato
- **NasaImageService**: riscritto `searchNasa()` con fallback automatico per apostrofi (es. `Halley's Comet` → `Halleys Comet` + extra fallback "comet"). Rimosso `downloadAndProcess()`. `importForBody()` ora salva URL remoti (~medium.jpg) invece di scaricare localmente. Priorità URL: `alternate` (medium) → `preview` (thumb) → `canonical` (orig fallback)
- **CorpoCelesteController**: aggiunto metodo `suggestNome()` per auto-suggest admin (POST `/admin/corpi-celesti/suggest-nome`). Espansa `$wordMap` da 14 a ~50 termini (pianeti, lune, termini astronomici)
- **Blade views corpi-celesti**: create/edit ora con input URL invece di file upload; index/show usano URL remoti; show ha pulsante "Cerca su NASA"
- **Blade views galleria**: edit/index mostrano URL remoti
- **Blade views missioni**: edit/index con URL remoti
- **Guest components**: CorpoCard, LightboxGalleria, CorpoDettaglio usano `nome_display` con fallback a `nome`
- **Migration**: aggiunta colonna `nome_it` a `corpi_celesti` (2026_07_04_164500)
- **Test**: 25/25 PHPUnit passati (61 assertions)
- **Vite build**: 3173 moduli, zero errori
- **Documentazione**: changelog, todo, bug, documentazione, session.log, SKILL.md aggiornati

## Fase 9.1 — Bug critici (route, fillable, seeder)

### 9.1 — 05/07/2026 — `3034aba` — fix: bug critici — route() senza virgolette, nasa_id in fillable, categoria_id dinamico nel seeder
- Fix: route() senza virgolette in CorpoCelesteController
- Fix: `nasa_id` aggiunto a `$fillable` in CorpoCeleste model
- Fix: `categoria_id` dinamico nel seeder (non hard-coded)

## Fase 10 — UI/UX tema scuro, sistema solare, paginazione

### 10.0 — 06/07/2026 — `2d736af` `be1ee9b` `14ed82f` — feat: tema scuro auth pages, link Register, ridotta velocità orbite
- GuestLayout, Login, Register: tema scuro (`#0A0A1A`, `#111128`)
- "Register" link su Login page per nuovi utenti
- Velocità orbitali differenziate: pianeti lontani ruotano più lentamente
- Paginazione admin (`->paginate(20)`) su corpi-celesti, galleria, missioni, curiosità

## Fase 11 — Bugfix Inertia→Blade, NASA dedup, galleria cleanup

### 11.0 — 07/07/2026 — `65ed6d4` — fix: Inertia→Blade transizione, NASA import dedup, galleria cleanup e ordinamento
- Login/logout: `Inertia::location()` per full page reload, logout redirect a `/login`
- Tutti gli auth controller POST → `Inertia::location()` (6 controllers)
- NASA import: deduplicazione galleria (stesso `percorso` + `corpo_celeste_id`)
- NASA import: preserva `immagine_utente` (non sovrascrive se flag true)
- Colonna `immagine_utente` (boolean) su `corpi_celesti`
- Comando `astralis:gallery` con `--check`/`--clean`/`--sync`/`--fix`/`--dry-run`
- Galleria: inline ordering (pulsanti su/giù), onerror placeholder, "Imposta come principale"
- `uploadImmagine()` con try/catch, `destroy()` skip file locali per URL remoti
- Galleria cleanup: sostituite 16 immagini seed mancanti con URL NASA

## Fase 12 — Authorization (Policy + Gates)

### 12.0 — 07/07/2026 — feat: authorization admin con Policy e Gates
- Migration `2026_07_07_114500_add_is_admin_to_users_table`: colonna `is_admin` (boolean) su `users`
- `app/Providers/AuthServiceProvider.php`: registrate 5 Policy + Gate `admin` (`fn($user) => $user->is_admin`)
- Policy create: `CategoriaPolicy`, `CorpoCelestePolicy`, `MissionePolicy`, `CuriositaPolicy`, `GalleriaCorpoPolicy`
- Pattern Policy: `viewAny`/`view` → true (tutti gli autenticati), `create`/`update`/`delete` → false, `before` hook lascia passare admin
- `User.php`: `is_admin` in fillable + cast boolean
- `UserFactory.php`: default `is_admin => false`
- `DatabaseSeeder.php`: admin creato con `is_admin => true`
- `$this->authorize()` aggiunto a tutti i metodi CRUD di: CategoriaController, CorpoCelesteController, MissioneController, CuriositaController, GalleriaController
- `Gate::authorize('admin')` aggiunto a NasaImportController (index, import, importAll)
- Fix: CategoriaController.php — riparata doppia dichiarazione di classe (residuo sessione precedente)

### 12.5 — 08/07/2026 — docs: sostituito sistema priorità Alta/Media/Bassa con P0-P4 + emoji nel todo
- Nuovo sistema: 🔴P0 bloccante → 🟠P1 utente → 🔵P2 manutenzione → 🟣P3 accessibilità → ⚪P4 futuro
- Emoji per separare forma e colore: cerchi 🔴🟠🔵🟣⚪ per priorità, oggetti 🖥️🎨🧪✨ per categoria
- Sezioni P0/P1 vuote con messaggio verde 🟢 a riprova del lavoro fatto
- Tutti i task riclassificati e ordinati per priorità

### 12.4 — 08/07/2026 — feat: quick wins — per_page, ordinamento relazioni, .catch, nasa_id, indexes
- Max `per_page` (100) in Api\CorpoCelesteController — previene abuso
- Ordinamento default: `galleria()` per `ordine`, `curiosita()` per `created_at desc`
- Sostituiti 3 `.catch(() => {})` silenziosi con `console.error` in React
- Esposto `nasa_id` in CorpoCelesteResource
- Migration: index su `tipo`, `in_evidenza`, `galleria_corpi.ordine`
- Spostato task rate limiting in Bassa priorità
- 25/25 test pass, 61 assertions

### 12.3 — 08/07/2026 — feat: FormRequest per validazione store/update CorpoCeleste
- Creati `StoreCorpoCelesteRequest` e `UpdateCorpoCelesteRequest` in `app/Http/Requests/`
- Estratta validazione inline da `CorpoCelesteController` nei FormRequest
- `UpdateCorpoCelesteRequest` estende `StoreCorpoCelesteRequest` (differenza: unique su nome ignora record corrente)
- `in_evidenza` convertito a boolean in `passedValidation()`
- 25/25 test pass, 61 assertions

### 12.2 — 08/07/2026 — `f62f945` — feat: rimossa dipendenza Inertia (Fase 12.2)
- Rimosso `app/Http/Middleware/HandleInertiaRequests.php`
- Rimossi tutti i componenti JSX Inertia (13 Components, 2 Layouts, 2 Pages, app.jsx)
- Rimossa root view `resources/views/app.blade.php`
- Rimosse dipendenze composer: `inertiajs/inertia-laravel`, `tightenco/ziggy`
- Rimossa dipendenza npm: `@inertiajs/react`
- Adeguati: Controller.php, bootstrap/app.php, providers.php, routes/web.php, vite.config.js
- Adeguate viste: admin/layouts/app.blade.php, profile/edit.blade.php
- Fix: autoloader PSR-4 corrotto (laravel/pail mancante) rigenerato con `composer dump-autoload`
- Fix: permessi bootstrap/cache/ ripristinati
- 25/25 test pass, 61 assertions

### 12.2 — 08/07/2026 — `0931d17` — feat: rimossa dipendenza Inertia
- Rimosso HandleInertiaRequests middleware
- Cancellati 13 componenti JSX Inertia, Layouts, Pages
- Rimosse dipendenze composer (inertia-laravel, ziggy) e npm (@inertiajs/*)
- routes/web.php aggiornato (catch-all SPA invece di Inertia fallback)
- vite.config.js, bootstrap/app.php, providers.php aggiornati
- resources/views/admin/layouts/app.blade.php adattato per non-Inertia
- Guest pages React standalone (main.jsx, non app.jsx)

### 12.3 — 08/07/2026 — `b17c0d9` — feat: FormRequest per validazione CorpoCeleste
- Creati `StoreCorpoCelesteRequest` e `UpdateCorpoCelesteRequest` in `app/Http/Requests/`
- Validazione inline del controller ridotta da ~40 righe a 2 righe (DI)
- `in_evidenza` convertito a boolean in `passedValidation()`

### 12.4 — 08/07/2026 — `1869bc8` — feat: quick wins (per_page, ordinamento, .catch, nasa_id, indexes)
- Max `per_page=100` in API controller
- Ordinamento default per `galleria()` (ordine) e `curiosita()` (created_at desc)
- 3 `.catch(() => {})` silenziosi → `console.error`
- `nasa_id` esposto in `CorpoCelesteResource`
- Migration per indici su `tipo`, `in_evidenza`, `galleria_corpi.ordine`

### 12.5 — 08/07/2026 — docs: sistema priorità P0-P4 con emoji
- Nuovo formato `[🎨frontend][🔵P2]` nel todo.md
- Sezioni P0/P1 vuote con messaggio verde 🟢

### Wave 1 — 08/07/2026 — feat: backend P2 (WordMapService, simili ordinati)
- Sostituito `inRandomOrder()` con `orderBy('nome')->limit(4)` in `Api/CorpoCelesteController@simili`
- Creato `app/Services/WordMapService.php` con metodi `translate()` e `guessEnglishName()`
- Estratto `$wordMap` inline dal controller admin al servizio dedicato
- Rimossa duplicazione `'Anello' => 'Ring'` nel wordMap
- Rimossa private method `guessEnglishName()` dal controller

### Wave 4 — 08/07/2026 — feat: frontend P2 stili inline → Tailwind classi admin
- Convertiti stili inline color/bg/border in classi Tailwind in 21 file Blade admin
- Usata palette `admin.*` da tailwind.config.js (admin.bg, admin.card, admin.text, admin.primary, admin.secondary, admin.accent)
- Rimosse centinaia di `style=""` con classi Tailwind equivalenti
- Mantenuti inline solo: input onfocus/onblur (52 occorrenze) e colori dinamici PHP (34 occorrenze)

### Wave 3 — 08/07/2026 — feat: frontend P2 onMouseEnter/onMouseLeave → CSS :hover
- React: convertiti tutti gli inline onMouseEnter/onMouseLeave in hover: Tailwind (5 file JSX)
- Blade: convertiti tutti gli inline onmouseover/onmouseout in hover: Tailwind (19 file Blade)
- Rimossi ~270 righe di inline JavaScript event handlers, sostituiti con CSS :hover
- Pattern comuni: hover:bg-[rgba(...)], hover:text-[#...], hover:scale-105, hover:-translate-y-0.5

### Wave 2 — 08/07/2026 — feat: frontend P3 accessibilità (aria-label, role="img")
- React: aggiunto `aria-label` a pulsante reset selezioni (Comparatore)
- React: aggiunto `aria-label` a pulsanti galleria thumbnail (LightboxGalleria)
- React: aggiunto `role="img"` + `aria-label` a fallback gradient icon (CorpoCard, CorpoDettaglio)
- React: aggiunto `role="img"` + `aria-label` a fallback mission logo (TimelineMissioni)
- Blade: aggiunto `aria-label` a tutti i pulsanti/link azione tabelle admin (5 CRUD index)
- Blade: aggiunto `aria-label` a 10 color swatch categoria (create + edit)
- Blade: aggiunto `role="img"` + `aria-label` a fallback avatar/logo (corpi, missioni, nasa-import)
- Blade: fix onerror galleria — `role="img"` nel fallback "Immagine non disponibile"
- Tutti gli SVG decorativi icon-only hanno `aria-hidden="true"`

### 13.1 — 08/07/2026 — feat: Vitest per componenti React — 27 test (CategoriaBadge, CorpoCard, Lightbox, SolarSystem)
- Installati `vitest`, `jsdom`, `@testing-library/react`, `@testing-library/jest-dom`, `@testing-library/user-event`
- Configurazione `vitest.config.js` con environment jsdom + React plugin
- Fix: `LightboxGalleria.jsx` — aggiunto null guard `(immagini || [])` per prevenire crash su props null
- 27 test Vitest per 4 componenti React: CategoriaBadge (5), CorpoCard (10), LightboxGalleria (8), SolarSystem (4)
- `docs/testing.md` aggiornato con sezione Vitest e comandi npm test

### 13.0 — 08/07/2026 — feat: HasFactory su 5 modelli, 26 test NasaImageService, observer testing guard, 84 test verdi
- Aggiunto trait `HasFactory` ai 5 modelli (Categoria, CorpoCeleste, Curiosita, GalleriaCorpo, Missione) — le factory esistevano già
- Fix: `CorpoCelesteObserver::created()` skip in ambiente testing (`app()->environment('testing')`) — prima faceva chiamate HTTP reali
- Fix: `NasaImageService::searchNasa()` — riordinato `str_replace` in query stripping (`'s` prima di `'`) per correggere fallback possessivo inglese
- Fix: `NasaImageService::importForBody()` — with `immagine_utente=true` e `force=true`, ora skip completo (non crea voci galleria)
- Fix: `Missione.php` — imports su riga singola riparati (a capo mancante)
- 26 test unitari NasaImageServiceTest (searchNasa, extractMetadata, pickImageUrl, importForBody, importAll) — 63 assertion
- 9 file feature test fixati con `Http::fake()` e response structure corrette
- **84/84 test pass, 220 assertion**

### 12.1 — 07/07/2026 — feat: auth pages da Inertia a Blade puro
- Create 11 viste Blade per auth e profilo con tema scuro
- `app/View/Components/GuestLayout.php` e `AppLayout.php` per compatibilità x-*
- Rimossi `Inertia::render()` e `Inertia::location()` da 9 controller auth
- Sostituiti con `view()` e `redirect()->intended()`/`redirect()`
- Eliminati file JSX Inertia non più utilizzati (`Pages/Auth/`, `Pages/Profile/`)
- Test aggiornati (redirect `/dashboard` → `/admin`, logout `/` → `/login`)
- 25/25 test pass, 61 assertions

### 13.2 — 09/07/2026 — feat: Vitest integrazione API — 61 test (apiClient + 4 guest pages)
- `resources/js/guest/test/setup.js`: mock globale IntersectionObserver (richiesto da framer-motion `whileInView`)
- `apiClient.test.js` — 12 test per 6 funzioni di apiClient (fetchCorpiCelesti, fetchCategorie, fetchCorpoCeleste, fetchSimili, fetchMissioni, fetchDashboardStats)
- `HomePage.test.jsx` — 11 test di integrazione (hero, loading, corpi in evidenza, stats, error)
- `CorpiLista.test.jsx` — 12 test di integrazione (filtri, paginazione, ricerca, reset, error)
- `CorpoDettaglio.test.jsx` — 16 test di integrazione (metriche, galleria, curiosità, missioni, simili, errore 404)
- `Comparatore.test.jsx` — 10 test di integrazione (dropdown, pre-fill URL, tabella confronto, esclusione)

### 13.3 — 09/07/2026 — feat: Dashboard admin con grafici Chart.js

## Fase 14 — 10 Bug critici fixati

### 14.0 — 09/07/2026 — fix: 10 bug critici (Blade @endif, React null guard, 404 route, N+1, senza SSL, import duplicato)
- `curiosita/index.blade.php`: aggiunti 2 `@endif` mancanti — tabella e paginazione non erano più intrappolate nei condizionali
- `categorie/index.blade.php` e `galleria/index.blade.php`: chiuso `@if (session('success'))` prima di annidare `@if (session('error'))`, rimosso blocco errore duplicato
- `CorpoCard.jsx`: aggiunto `isNaN` guard in `formatDistance()` per prevenire "NaN km"
- `App.jsx` + nuova `NotFound.jsx`: aggiunta route catch-all `path="*"` per URL sconosciuti
- `CorpoCelesteController.php::setImageFromGallery`: aggiunto ownership check (`abort(404)` se `$galleriaCorpo->corpo_celeste_id !== $corpoCeleste->id`)
- `MissioneController.php::show`: eager loading `corpiCelesti.categoria` (N+1 fix)
- Migration `create_missioni_table`: default `stato` da `'completata'` a `'Completata'`
- `NasaImageService.php`: `withoutVerifying()` ora solo in ambiente `local`/`testing`
- `CorpoDettaglio.jsx`: unificato import duplicato `Orbit` da lucide-react (rimosso da linea 4, usato `OrbitIcon` da linea 10)
- `app/Http/Controllers/Admin/DashboardController.php`: aggiunte 3 query — corpi per categoria (withCount, filtrata count>0), corpi per tipo (groupBy), missioni per stato (3 count)
- `resources/views/admin/dashboard.blade.php`: 3 canvas Chart.js — donut corpi/categoria, barre verticali corpi/tipo, barre orizzontali missioni/stato
- Chart.js v4.4.7 caricato da CDN via `@push('scripts')` (stesso pattern Alpine.js)
- Tema dark: `Chart.defaults.color` e `borderColor` configurati per palette admin
- Accessibilità: `role="img"` + `aria-label` su ogni canvas

### 14.1 — 09/07/2026 — chore: rimossi import morti React e dipendenze inutilizzate/malposizionate
- `LightboxGalleria.jsx`: rimosso import morto `Image` da lucide-react
- `Comparatore.jsx`: rimossi import morti `Weight, Thermometer, Gauge, MapPin` da lucide-react
- `laravel/sanctum`: `composer remove` (mai usato, API pubbliche)
- `barryvdh/laravel-dompdf`: `composer remove` (mai usato, nessuna generazione PDF)
- `@tailwindcss/vite`: `npm uninstall` (incompatibile con Tailwind v3)
- `@headlessui/react`: `npm uninstall` (mai importato)
- `react`/`react-dom`: spostati da `devDependencies` a `dependencies`
- `@vitejs/plugin-react`: spostato da `dependencies` a `devDependencies`

## Fase 15 — P2/P3 manutenzione e accessibilità

### 15.0 — 09/07/2026 — feat: Categoria index pagination, Curiosita show view
- `CategoriaController::index()`: `->get()` → `->paginate(20)` + `withQueryString()`  
- Vista categorie/index: aggiunto `$categorie->links()` con paginazione Tailwind
- `CuriositaController::show()`: nuovo metodo + vista `curiosita/show.blade.php`
- Route curiosita: `except(['show'])` → `except()` (rimuove except)
- `resources/views/admin/curiosita/show.blade.php`: **NUOVA** — dettaglio curiosità con layout admin

### 15.1 — 09/07/2026 — feat: search/filter admin per Categoria, Missione, Curiosità, Galleria
- `CategoriaController::index()`: filtro `->when($request->search, fn($q, $v) => $q->where('nome','like',"%{$v}%"))`
- `MissioneController::index()`: filtri `search` (nome), `agenzia`, `stato`
- `CuriositaController::index()`: filtro `search` (titolo)
- `GalleriaController::index()`: filtro `search` (didascalia)
- Ogni vista index: barra di ricerca con stesso pattern di corpi-celesti + `withQueryString()` + bottone "Cancella filtro"

### 15.2 — 09/07/2026 — feat: SEO meta tags React (5 pagine guest)
- `HomePage.jsx`: `document.title = "Astralis — Catalogo di Corpi Celesti"`
- `CorpiLista.jsx`: `document.title = "Corpi Celesti — Astralis"`
- `CorpoDettaglio.jsx`: `document.title = "{nome} — Astralis"` (con fallback iniziale)
- `Comparatore.jsx`: `document.title = "Confronta Pianeti — Astralis"`
- `NotFound.jsx`: `document.title = "Pagina non trovata — Astralis"`
- Tutti via `useEffect` con dipendenza appropriata

### 15.3 — 09/07/2026 — feat: Error Boundary globale React
- `resources/js/guest/components/ErrorBoundary.jsx`: **NUOVO** — class component React con `componentDidCatch`
- UI fallback: tema dark, icona AlertTriangle, messaggio "Qualcosa è andato storto", link home
- `App.jsx`: wrapper `<ErrorBoundary>` intorno a `<Routes>`

### 15.4 — 09/07/2026 — feat: Admin CRUD test (4 file)
- `tests/Feature/Admin/CategoriaCrudTest.php`: **NUOVO** — 13 test (index, create, store, validazione, unique, show, edit, update, delete, protezione cancellazione con corpi associati, 403 per non-admin)
- `tests/Feature/Admin/MissioneCrudTest.php`: **NUOVO** — 12 test (CRUD completo + filtri search/agenzia/stato + 403)
- `tests/Feature/Admin/CuriositaCrudTest.php`: **NUOVO** — 11 test (CRUD completo + show + 403)
- `tests/Feature/Admin/GalleriaCrudTest.php`: **NUOVO** — 11 test (CRUD completo + 403)
- Totale: 130 test PHPUnit, 335 assertion

## Fase 1 — Critico React Frontend (P0)

### 1.0 — 10/07/2026 — `f5ed6ab` — feat: React P0 — AbortController, useFetch, ErrorBoundary, image guards, axios interceptors
- **AbortController** in HomePage, CorpiLista, CorpoDettaglio, Comparatore — impedisce `setState()` su componenti smontati
- **Custom hook `useFetch`** con useReducer in `hooks/useFetch.js` — centralizza loading/error/data/abort
- **ErrorBoundary globale** in App.jsx con pulsante retry — wrappa Navbar+Footer+Routes
- **Guard immagini rotte** — CorpoCard, CorpoDettaglio, LightboxGalleria, TimelineMissioni: onError con fallback gradiente+icona
- **Axios interceptors + retry** in apiClient.js — timeout 15s, 3 tentativi, gestione errori centralizzata

## Fase 2 — Critico Backend Laravel (P0)

### 2.0 — 10/07/2026 — `f5ed6ab` — feat: Laravel P0 — Job queue, chunk(50), rate limiting, caching NASA
- **Observer → Job Queue**: `CorpoCelesteObserver::created()` ora dispatcha `ImportNasaImage` job invece di chiamata HTTP sincrona
- **`app/Jobs/ImportNasaImage.php`**: **NUOVO** — job dispatchato alla queue `import-nasa`, 2 retry, 30s timeout
- **`NasaImportController::importAll()`**: sostituito `set_time_limit(300)` con dispatch massivo via Job Queue
- **`NasaImageService::importAll()`**: `CorpoCeleste::all()` → `CorpoCeleste::chunk(50)` — riduce memoria da migliaia a decine di modelli
- **Rate limiting API**: `throttle:60,1` su tutti e 10 gli endpoint in `routes/api.php`
- **Caching `searchNasa()`**: `Cache::remember(86400)` per risultati NASA API
- **Update routes/api.php**: raggruppate 10 route sotto middleware `throttle:60,1` + `throttle:100,1` per dashboard

## Piano Ottimizzazione — P1

### 3.4 — 11/07/2026 — feat: framer-motion→CSS + SolarSystem clickable/immagini realistiche
- Rimossi `motion.div` da 4 file guest (HomePage, CorpiLista, CorpoDettaglio, Comparatore)
- CSS keyframes: `fadeUp`, `slideLeft`, `slideRight`, `fadeScale`, `fadeIn`, `twinkle`, `pulseSun`
- Nuovo hook `useInView` per scroll-triggered animations (IntersectionObserver)
- SolarSystem: pianeti cliccabili con `<Link>` → pagina dettaglio
- SolarSystem: immagini reali NASA (Wikimedia) con fallback colore originale
- SolarSystem: stelle twinkle + sun pulse convertiti a CSS
- SolarSystem: hover scale convertito a CSS `.planet-hover`
- framer-motion ora importato solo in SolarSystem.jsx (orbite useMotionValue/useTransform)
- 87 test Vitest pass, build Vite OK
