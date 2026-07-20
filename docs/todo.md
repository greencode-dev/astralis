# Todo

> [Formato e legenda →](#note)

_Ultimo aggiornamento: 20/07/2026_

## Da Fare

- [ ] [Task 115] `[🟡][🧪]` Test PHP + JS aggiornati per nuovi campi — `tests/`
- [ ] [Task 114] `[🟡][🎨]` React SPA: aggiorna fixture, rimuovi nome_display, usa solo nome — `resources/js/guest/`
- [ ] [Task 113] `[🟡][🎨]` JS: auto-translate debounce, galleria inline NASA selezione multipla, copertina preview — `resources/views/admin/partials/`
- [ ] [Task 112] `[🟡][🎨]` Blade: _form ristrutturato (6 sezioni, in_evidenza in alto, tipo dropdown, upload copertina, galleria inline) — `resources/views/admin/corpi-celesti/`
- [ ] [Task 111] `[🟡][🖥️]` Route: nuove endpoint translate, search-gallery, add-gallery, remove-gallery — `routes/web.php`
- [ ] [Task 110] `[🟡][🖥️]` Resource: API response solo nome italiano — `app/Http/Resources/CorpoCelesteResource.php`
- [ ] [Task 109] `[🟡][🖥️]` Controller: aggiorna admin CRUD, API, aggiungi translate route — `app/Http/Controllers/`
- [ ] [Task 108] `[🟡][🖥️]` Validation: StoreCorpoCelesteRequest, UpdateCorpoCelesteRequest, SuggestNomeRequest aggiorna campi — `app/Http/Requests/`
- [ ] [Task 107] `[🟡][🖥️]` NasaImageService: aggiorna riferimenti a nome_en per ricerche NASA — `app/Services/NasaImageService.php`
- [ ] [Task 106] `[🟡][🖥️]` WordMapService: auto-popola wordmap custom da MyMemory fallback + salva in storage/app/wordmap-custom.json — `app/Services/WordMapService.php`
- [ ] [Task 105] `[🟡][💾]` Factory + Seeder: swap nomi, immagini default pianeti da public/images/solar-system/, slug italiano — `database/factories/`, `database/seeders/`
- [ ] [Task 104] `[🔴][🖥️]` Model CorpoCeleste: aggiorna fillable, rimuovi accessor nome_display, estendi immagine_url — `app/Models/CorpoCeleste.php`
- [ ] [Task 103] `[🔴][💾]` Migrazione DB: rename nome_it→nome, nome→nome_en + swap dati + rigenera slug — `database/migrations/`

## In lavorazione

> Nessuna task in lavorazione.

## Completate

### 19/07/2026

- [x] [Task 102] `[🔴][🖥️]` Fix API 500 cache serialization — cachea solo gli ID (`pluck('id')`), re-query con `whereIn()` + `with('categoria')`. 267+110 test verdi — `CorpoCelesteController.php`
- [x] [Task 101] `[🔵][📝]` Sezione Q&A in presentazione-progetto — 15 domande/risposte legate alla traccia esame (architettura, Eloquent, sicurezza, NASA, test, animazioni, design patterns) — `docs/presentazione-progetto.md`
- [x] [Task 100] `[🟡][🎨]` Landing page redesign — items-start griglia, self-end SolarSystem, marginTop 4rem per posizionamento verticale — `HomePage.jsx`
- [x] [Task 99] `[🟡][🎨]` Verifica card "In Evidenza" — card rendereggono correttamente, gestione errori OK, SolarSystem non causa crash. Nessuna azione necessaria — `HomePage.jsx`
- [x] [Task 98] `[🟡][🎨]` Verifica ErrorBoundary — "Riprova" funziona (reset state), double-wrapping intenzionale. Nessun bug trovato — `ErrorBoundary.jsx`, `App.jsx`
- [x] [Task 97] `[🟡][🎨]` Verifica logo PNG — tutti i 6 PNG esistono, usati in Navbar/Footer/Sidebar/Auth. Favicon link invariati — `Navbar.jsx`, `Footer.jsx`, `app.blade.php`, `layouts/guest.blade.php`
- [x] [Task 96] `[🟡][🖥️]` Revisione NasaImageService — rimosso codice morto (righe 62-82: doppio parsing response + slimItems irraggiungibile). 38 test NASA verdi — `NasaImageService.php`
- [x] [Task 95] `[🟡][🖥️]` config/cors.php — non necessaria in Laravel 13: framework gestisce CORS via middleware con defaults (`allowed_origins: *`, route `api/*`). Nessuna azione richiesta
- [x] [Task 94] `[🟡][🖥️]` Loghi missioni — rimossi riferimenti a 9 logo inesistenti da `MissioneSeeder`, aggiornate 10 righe DB a `null`. Le viste admin già gestiscono `@if ($missione->logo)` — `MissioneSeeder.php`
- [x] [Task 93] `[🟡][🖥️]` Fix immagine Marte — sostituito URL `.tif` (non renderizzabile) con PIA00407~orig.jpg — `CorpoCeleste` id=5
- [x] [Task 92] `[🟡][🎨]` Integrazione loghi — sostituito `/favicon.svg` con `/astralis_solo_logo_bianco.png` in Navbar, Footer, admin sidebar, guest layout. Favicon link invariati — `Navbar.jsx`, `Footer.jsx`, `app.blade.php`, `layouts/guest.blade.php`
- [x] [Task 91] `[🔵][🎨]` Font Orbitron — aggiunto `--font-orbitron` al blocco `@theme` in `app.css` — `resources/css/app.css`
- [x] [Task 90] `[🟡][🎨]` Orbite equidistanti — formula `(310-75)/7 ≈ 33.57px` per step, costanti `ORBIT_MIN/MAX/STEP` — `SolarSystem.jsx`
- [x] [Task 89] `[🟡][🎨]` SolarSystem centratura — verificata: Sole e orbite entrambi centrati in 670×670 con flex/translate. `useFetch` parallelo gia' ottimale — `SolarSystem.jsx`, `HomePage.jsx`, `useFetch.js`
- [x] [Task 88] `[🔵][🧪]` Mock ResizeObserver in test setup — aggiunto mock per jsdom in `setup.js` — `resources/js/guest/test/setup.js`
- [x] [Task 87] `[🟡][🎨]` SolarSystem responsive scaling — `ResizeObserver` + `aspect-ratio: 670/720` + `transform: scale()` automatico. Rimosso `self-end` e `translate: "50px 50px"` da HomePage — `SolarSystem.jsx`, `HomePage.jsx`
- [x] [Task 86] `[🔴][🖥️]` Fix API 500 — `Cache::remember` serializzava `LengthAwarePaginator` → deserializzazione falliva. Fix: cachea Collection, crea paginator dopo — `CorpoCelesteController.php`

---

### 18/07/2026

- [x] [Task 85] `[🔴][🖥️]` Gallery quality fix — eliminati 74 record galleria, reimportati 90 (18×5) tutti `~orig.jpg` (0 thumb/small/medium). Fix `importForBody()`: rimosso early return che bloccava import galleria per corpi con `immagine_utente=true` — `NasaImageService.php`
- [x] [Task 84] `[🔵][🧪]` Test aggiornato — `test_import_for_body_force_does_not_overwrite_user_image` ora verifica che main non venga sovrascritta ma galleria venga importata — `NasaImageServiceTest.php`
- [x] [Task 83] `[🔵][📝]` Fix nomi skill in AGENTS.md (`react-best-practices` → `vercel-react-best-practices`, `composition-patterns` → `vercel-composition-patterns`)
- [x] [Task 82] `[🔵][📝]` Unificare sessioni 17/07 in changelog.md + aggiornare conteggi test
- [x] [Task 81] `[🟡][🎨]` Refactoring card dashboard — link cliccabili, 4 colori unici, meta info, table name links — `dashboard-stat.blade.php`, `DashboardController.php`, `dashboard.blade.php`
- [x] [Task 80] `[🔵][🧪]` Dashboard test aggiornati — clickable links, table links, meta info (3 nuovi test) — `DashboardTest.php`
- [x] [Task 79] `[🟡][🎨]` Solar system immagini — 9 foto reali NASA/croccate, tutte quadrate, dimensioni ingrandite (~1.8×) — `public/images/solar-system/`
- [x] [Task 78] `[🟡][🎨]` Solar system Sole — sostituito con NASA 3D rendering, crop 359×359 — `sole.jpg`
- [x] [Task 77] `[🟡][🎨]` Solar system CSS — `object-cover` → `object-contain`, rimosso `bg-black` da pianeti/Sole — `SolarSystem.jsx`

---

### 17/07/2026

- [x] [Task 76] `[🔴][🖥️]` Fix galleria duplicati — riposizionare `removeDuplicates()` dopo `handleBrokenUrls()`, check duplicati in `handleSync()`, migration UNIQUE `(corpo_celeste_id, percorso)`, test aggiornati — `CleanupGalleryDuplicates.php`, `database/migrations/`
- [x] [Task 75] `[🔴][🎨]` Fix grafici dashboard — colori concreti hex, `maintainAspectRatio: false` + `h-64`, layout `lg:grid-cols-3`, grafici spostati in cima, guard `typeof Chart` — `dashboard.blade.php`
- [x] [Task 74] `[🔴][🖥️]` Fix homepage performance — rimosso `galleria` eager-load da index/simili, `Cache::remember` 5min, index composto `[in_evidenza, nome]`, heading "In Evidenza" sempre visibile — `CorpoCelesteController.php`, `HomePage.jsx`, migration
- [x] [Task 73] `[🔴][🖥️]` Fix proxy API in vite.config.js — aggiunto `server.proxy: { '/api': 'http://localhost:8000' }` — risolve white page + CORB error
- [x] [Task 72] `[🟡][🎨]` Mobile nav Escape + click-outside + route-change cleanup — `Navbar.jsx`
- [x] [Task 71] `[🔵][🎨]` framer-motion mantenuto (uso legittimo in SolarSystem)
- [x] [Task 70] `[🟡][🖥️]` memory_limit=512M — rimosso (codice inesistente)
- [x] [Task 69] `[🔵][🧪]` Test accessor nome_display + immagine_url — `CorpoCelesteTest.php` (6 test)
- [x] [Task 68] `[🔵][🧪]` Test setImageFromGallery: non-admin 403, remote URL, flash — `CorpoCelesteActionsTest.php`
- [x] [Task 67] `[🔵][🧪]` Test suggestNome: non-admin, caching, fallback raw Italian — `CorpoCelesteActionsTest.php`
- [x] [Task 66] `[🔵][🧪]` Test ImportNasaImage job: implements, proprietà, uniqueId, handle, failed — `ImportNasaImageTest.php` (9 test)
- [x] [Task 65] `[🔵][🧪]` 28 nuovi test: CorpoCelesteTest (6), ImportNasaImageTest (9), CorpoCelesteActionsTest (13)
- [x] [Task 64] `[🔵][✨]` Logo Astralis ad alta risoluzione caricati in public/
- [x] [Task 63] `[🔵][📝]` Installazione graphify + aggiornamento grafo knowledge graph (1647 nodi, 2587 edges, 213 community)
- [x] [Task 62] `[🔵][📝]` Aggiornamento docs: React 19→18, test count 252/359, task numbering, changelog 17/07
- [x] [Task 61] `[🟡][📝]` Comandi custom — AGENTS.md: `\commit`, `\push`, `\save` con workflow automatizzato e conferme via `question` tool
- [x] [Task 60] `[🟡][📝]` Snapshot sessione — `### Sessione corrente` in AGENTS.md, letta da `\start`, sovrascritta da `\save`
- [x] [Task 59] `[🟡][📝]` Conferme unificate — 7 punti in AGENTS.md riscritti con tool `question` a checkbox

---

### 16/07/2026

- [x] [Task 58] `[🟡][🖥️]` orWhere grouping — `Admin/CorpoCelesteController.php`
- [x] [Task 57] `[🟡][🖥️]` accessor indent — `CorpoCeleste.php`
- [x] [Task 56] `[🟡][🎨]` logo oversized — `Navbar.jsx` + `Footer.jsx`
- [x] [Task 55] `[🔵][🎨]` focus-visible ring — `SearchBar.jsx`
- [x] [Task 54] `[🟡][🎨]` hardcoded hex → CSS vars — `Comparatore.jsx`
- [x] [Task 53] `[🔵][🖥️]` flash 3 blocks → foreach loop — `flash.blade.php`
- [x] [Task 52] `[🔵][🎨]` extract useDebounce hook — `CorpiLista.jsx` + `hooks/useDebounce.js`

---

### 15/07/2026

- [x] [Task 51] `[🟡][🎨]` Sidebar + Partials: config/admin.php, \_sidebar-nav, category-badge, index-header, dashboard-stat, empty-table-row, in-evidenza-badge, flash-in-layout, CSS vars error/success, Route::is()
- [x] [Task 50] `[🔴][🖥️🧪]` Sicurezza + Bug critici + UX: 15 fix (security, retry, race condition, unique job, color picker, flash messages, navbar mobile, useFetch keep-data, comparatore URL-based, gravita/temperatura locale IT). 359 test (252 PHPUnit + 107 Vitest)

---

### 14/07/2026

- [x] [Task 49] `[🔵][🧪]` API edge case tests: ApiEdgeCaseTest.php (17 test: percent, underscore, per_page, agenzia/stato filters, empty DB, factory, dashboard, galleria/curiosita includes)
- [x] [Task 48] `[🔵][🧪]` Search & filter tests: SearchAndFilterTest.php (10 test: search per nome/nome_it/titolo/didascalia, stato filter, wildcard escaping)
- [x] [Task 47] `[🔵][🧪]` Frontend tests: NotFound(4), ErrorBoundary(4), TimelineMissioni(8), Navbar(6) — 22 test Vitest
- [x] [Task 46] `[🔵][🧪]` CleanupGalleryDuplicatesTest: 9 test (dedup, dry-run, orphans, check, broken/working remote URLs, different corpi same path)
- [x] [Task 45] `[🔵][🧪]` WordMapServiceTest: 8 test (translate known/unknown/empty, planet names, prepositions, guessEnglishName)
- [x] [Task 44] `[🟡][🎨]` Inline styles→Tailwind, accessibility (scope, aria-label, aria-current, role), partials, delete protection
- [x] [Task 43] `[🔵][🖥️🎨]` CSS cleanup, config fixes, deps removal, curiosita showRoute, mission badge partial
- [x] [Task 42] `[🔵][🖥️]` ClearDashboardCache trait, ImageUploadService extraction
- [x] [Task 41] `[🟡][🧪]` Debug generale post-ottimizzazione: LightboxGalleria.jsx fix `}`→`});` (memo close), CorpoDettaglio.test.jsx fix import typo. 260 test (173 PHPUnit + 87 Vitest)

---

### 11/07/2026

- [x] [Task 40] `[🟡][🧪]` Uniform Http::fake() pattern in tutti i test
- [x] [Task 39] `[🔵][📝]` Frontend Design audit: palette coerenza, 7 inconsistenze colore, SolarSystem firma, tipografia
- [x] [Task 38] `[🔵][📝]` Writing Guidelines audit: 14 ellipsis, 14 heading case, 10+ passive voice, 16 filler "con successo"
- [x] [Task 37] `[🔵][📝]` Web Design Guidelines audit: 14 file React, 3 high, 6 medium, 3 low priority
- [x] [Task 36] `[🔵][🧪]` DashboardApiTest complete: 4 test (counts, corpi_in_evidenza, ultimi_corpi, missioni_per_stato)
- [x] [Task 35] `[🟡][🧪]` Copertura test mancante: CorpoCelesteActionsTest(7), GalleriaOrdineTest(6), NasaImportTest(8)
- [x] [Task 34] `[🟡][🧪]` Factory foreign key fix: corpo_celeste_id rimosso, usato ->for()
- [x] [Task 33] `[🔵][🧪]` Frontend fixtures.js centralizzato condiviso tra 6 test file
- [x] [Task 32] `[🟡][🧪]` Uniform Http::fake() pattern in tutti i test
- [x] [Task 31] `[🟡][🧪]` Uniform Http::fake() pattern in tutti i test
- [x] [Task 30] `[🟡][🧪]` AuthorizationTest: 19 test (store/update/delete per 5 entità + 6 guest redirect)
- [x] [Task 29] `[🟡][🖥️]` AdminTestCase base class: 5/5 CRUD test la estendono
- [x] [Task 28] `[🟡][🖥️]` suggestNome caching + debounce: Cache::remember(3600)
- [x] [Task 27] `[🟡][🖥️]` Authorization consistente: DashboardController fixato
- [x] [Task 26] `[🔵][🎨]` React.memo: LightboxGalleria + Thumbnail
- [x] [Task 25] `[🟡][🎨]` CSS component class: .admin-input, 8 Blade views riscritti
- [x] [Task 24] `[🟡][🎨]` Hardcoded hex → CSS variables: 13 variabili, 52 hex sostituiti
- [x] [Task 23] `[🟡][🎨]` Partials Blade: back-link, search, flash, stat-card, show-actions, index-actions
- [x] [Task 22] `[🟡][🎨]` Form partial unificato: 5 \_form.blade.php, 10 create/edit riscritti
- [x] [Task 21] `[🟡][🖥️]` Cache dashboard + invalidazione su CRUD
- [x] [Task 20] `[🟡][🎨]` framer-motion → CSS transitions + SolarSystem clickable/immagini
- [x] [Task 19] `[🟡][🎨]` Inline styles → Tailwind classes: ~68 oggetti in 15 file
- [x] [Task 18] `[🟡][🎨]` Rimossi import morti React + dipendenze inutilizzate/malposizionate

---

### 10/07/2026

- [x] [Task 17] `[🔴][🖥️]` 10 bug critici fixati
- [x] [Task 16] `[🟡][🖥️]` Quick wins: per_page, relazioni, .catch, nasa_id, indexes
- [x] [Task 15] `[🟡][🖥️]` FormRequest validazione store/update CorpoCeleste
- [x] [Task 14] `[🔴][🖥️]` Rimossa dipendenza Inertia
- [x] [Task 13] `[🔴][🖥️]` Auth pages: Inertia → Blade puro
- [x] [Task 12] `[🔴][🖥️]` Authorization Policy/Gates ai controller admin

---

### 09/07/2026

- [x] [Task 11] `[🔴][🖥️]` Bugfix auth, NASA import dedup, galleria cleanup
- [x] [Task 10] `[🟡][🖥️]` Bug critici: route(), nasa_id, categoria_id
- [x] [Task 9] `[🟡][🖥️]` Remote URLs, nome_it/nome_display, wordMap, auto-suggest admin

---

### 08/07/2026

- [x] [Task 8] `[🟡][🖥️]` NASA Import multi-immagine, Service Layer, CLI fetch-nasa
- [x] [Task 7] `[🟡][🖥️]` Bugfix Intervention Image v4, Force Import All

---

### 07/07/2026

- [x] [Task 6] `[🔵][🖥️🎨📝]` Fix orbite, redirect route, profilo, documentazione

---

### 04/07/2026

- [x] [Task 5] `[🔴][🎨]` React: Dettaglio, Lightbox, Missioni, Comparatore
- [x] [Task 4] `[🔴][🎨]` React: Homepage, Sistema solare animato, Lista
- [x] [Task 3] `[🔴][🖥️]` API REST (10 endpoint)

---

### 03/07/2026

- [x] [Task 2] `[🔴][🖥️🎨]` CRUD Admin (Categorie, Corpi Celesti, Missioni, Curiosità, Galleria)

---

### 02/07/2026

- [x] [Task 1] `[🔴][🖥️🎨📝]` Setup Laravel + Breeze + React + documentazione

---

## Note

- **Stato**: 13 task aperte. 115 task totali (13 Da Fare + 102 Completate). 377 test (267 PHPUnit + 110 Vitest), tutti verdi.
- Tasks spuntati (`[x]`) vengono spostati nella sezione **Completate**
- Formato per aggiungere un nuovo task:
    ```
    - [ ] [Task N] `[Priorità][Topic]` Descrizione — `file/principale/coinvolto`
    ```
    **Priorità**: `[🔴]` Critic · `[🟡]` High · `[🔵]` Medium · `[🟢]` Low
    **Topic**: `[🖥️]` Backend · `[🎨]` Frontend · `[💾]` Database · `[🧪]` Test · `[✨]` Feature · `[📝]` Docs
