# Todo

> [Formato e legenda →](#note)

_Ultimo aggiornamento: 18/07/2026_

## Da Fare

- [ ] `[🎨frontend][🟠P1]` Integrare 3 logo PNG nel progetto (completo, solo logo, solo testo) — Navbar, Footer, Sidebar admin, Auth layout
- [ ] `[🎨frontend][🟠P1]` SolarSystem fix — rimuovere boxShadow (alone semitrasparente) + riscrivere animazione con `requestAnimationFrame` (rotazione non continua, pianeti saltano). Piano in `.opencode/plans/solar-system-fix.md`

## Fatto

### 18/07/2026

- [x] `[🖥️backend][🔴P0]` Gallery quality fix — eliminati 74 record galleria, reimportati 90 (18×5) tutti `~orig.jpg` (0 thumb/small/medium). Fix `importForBody()`: rimosso early return che bloccava import galleria per corpi con `immagine_utente=true` — `NasaImageService.php`
- [x] `[🧪test][🔵P2]` Test aggiornato — `test_import_for_body_force_does_not_overwrite_user_image` ora verifica che main non venga sovrascritta ma galleria venga importata — `NasaImageServiceTest.php`
- [x] `[📝docs][🔵P2]` Fix nomi skill in AGENTS.md (`react-best-practices` → `vercel-react-best-practices`, `composition-patterns` → `vercel-composition-patterns`)
- [x] `[📝docs][🔵P2]` Unificare sessioni 17/07 in changelog.md + aggiornare conteggi test
- [x] `[🎨frontend][🟠P1]` Refactoring card dashboard — link cliccabili, 4 colori unici, meta info, table name links — `dashboard-stat.blade.php`, `DashboardController.php`, `dashboard.blade.php`
- [x] `[🧪test][🔵P2]` Dashboard test aggiornati — clickable links, table links, meta info (3 nuovi test) — `DashboardTest.php`
- [x] `[🎨frontend][🟠P1]` Solar system immagini — 9 foto reali NASA/croccate, tutte quadrate, dimensioni ingrandite (~1.8×) — `public/images/solar-system/`
- [x] `[🎨frontend][🟠P1]` Solar system Sole — sostituito con NASA 3D rendering, crop 359×359 — `sole.jpg`
- [x] `[🎨frontend][🟠P1]` Solar system CSS — `object-cover` → `object-contain`, rimosso `bg-black` da pianeti/Sole — `SolarSystem.jsx`

### 17/07/2026

- [x] `[🖥️backend][🔴P0]` Fix galleria duplicati — riposizionare `removeDuplicates()` dopo `handleBrokenUrls()`, check duplicati in `handleSync()`, migration UNIQUE `(corpo_celeste_id, percorso)`, test aggiornati — `CleanupGalleryDuplicates.php`, `database/migrations/`
- [x] `[🎨frontend][🔴P0]` Fix grafici dashboard — colori concreti hex, `maintainAspectRatio: false` + `h-64`, layout `lg:grid-cols-3`, grafici spostati in cima, guard `typeof Chart` — `dashboard.blade.php`
- [x] `[🖥️backend][🔴P0]` Fix homepage performance — rimosso `galleria` eager-load da index/simili, `Cache::remember` 5min, index composto `[in_evidenza, nome]`, heading "In Evidenza" sempre visibile — `CorpoCelesteController.php`, `HomePage.jsx`, migration
- [x] `[🖥️backend][🔴P0]` Fix proxy API in vite.config.js — aggiunto `server.proxy: { '/api': 'http://localhost:8000' }` — risolve white page + CORB error
- [x] `[🎨frontend][🟠P1]` Mobile nav Escape + click-outside + route-change cleanup — `Navbar.jsx`
- [x] `[🎨frontend][🔵P2]` framer-motion mantenuto (uso legittimo in SolarSystem)
- [x] `[🖥️backend][🟠P1]` memory_limit=512M — rimosso (codice inesistente)
- [x] `[🧪test][🔵P2]` Test accessor nome_display + immagine_url — `CorpoCelesteTest.php` (6 test)
- [x] `[🧪test][🔵P2]` Test setImageFromGallery: non-admin 403, remote URL, flash — `CorpoCelesteActionsTest.php`
- [x] `[🧪test][🔵P2]` Test suggestNome: non-admin, caching, fallback raw Italian — `CorpoCelesteActionsTest.php`
- [x] `[🧪test][🔵P2]` Test ImportNasaImage job: implements, proprietà, uniqueId, handle, failed — `ImportNasaImageTest.php` (9 test)
- [x] `[🧪test][🔵P2]` 28 nuovi test: CorpoCelesteTest (6), ImportNasaImageTest (9), CorpoCelesteActionsTest (13)
- [x] `[✨feature][🔵P2]` Logo Astralis ad alta risoluzione caricati in public/
- [x] `[📝docs][🔵P2]` Installazione graphify + aggiornamento grafo knowledge graph (1647 nodi, 2587 edges, 213 community)
- [x] `[📝docs][🔵P2]` Aggiornamento docs: React 19→18, test count 252/359, task numbering, changelog 17/07
- [x] `[📝docs][🟠P1]` Comandi custom — AGENTS.md: `\commit`, `\push`, `\save` con workflow automatizzato e conferme via `question` tool
- [x] `[📝docs][🟠P1]` Snapshot sessione — `### Sessione corrente` in AGENTS.md, letta da `\start`, sovrascritta da `\save`
- [x] `[📝docs][🟠P1]` Conferme unificate — 7 punti in AGENTS.md riscritti con tool `question` a checkbox

### 16/07/2026

- [x] `[🖥️backend][🟠P1]` orWhere grouping — `Admin/CorpoCelesteController.php` (B1)
- [x] `[🖥️backend][🟠P1]` accessor indent — `CorpoCeleste.php` (B3)
- [x] `[🎨frontend][🟠P1]` logo oversized — `Navbar.jsx` + `Footer.jsx` (F8)
- [x] `[🎨frontend][🔵P2]` focus-visible ring — `SearchBar.jsx` (F7)
- [x] `[🎨frontend][🟠P1]` hardcoded hex → CSS vars — `Comparatore.jsx` (F3)
- [x] `[🖥️backend][🔵P2]` flash 3 blocks → foreach loop — `flash.blade.php` (B10)
- [x] `[🎨frontend][🔵P2]` extract useDebounce hook — `CorpiLista.jsx` + `hooks/useDebounce.js` (F4)

### 15/07/2026

- [x] `[🎨frontend][🟠P1]` Sidebar + Partials: config/admin.php, \_sidebar-nav, category-badge, index-header, dashboard-stat, empty-table-row, in-evidenza-badge, flash-in-layout, CSS vars error/success, Route::is()
- [x] `[🖥️backend][🧪test][🔴P0]` Fasi 1-3 — Sicurezza + Bug critici + UX: 15 fix (security, retry, race condition, unique job, color picker, flash messages, navbar mobile, useFetch keep-data, comparatore URL-based, gravita/temperatura locale IT). 359 test (252 PHPUnit + 107 Vitest)

### 14/07/2026

- [x] `[🧪test][🔵P2]` Task 70 — API edge case tests: ApiEdgeCaseTest.php (17 test: percent, underscore, per_page, agenzia/stato filters, empty DB, factory, dashboard, galleria/curiosita includes)
- [x] `[🧪test][🔵P2]` Task 69 — Search & filter tests: SearchAndFilterTest.php (10 test: search per nome/nome_it/titolo/didascalia, stato filter, wildcard escaping)
- [x] `[🧪test][🔵P2]` Task 67 — Frontend tests: NotFound(4), ErrorBoundary(4), TimelineMissioni(8), Navbar(6) — 22 test Vitest
- [x] `[🧪test][🔵P2]` Task 66 — CleanupGalleryDuplicatesTest: 9 test (dedup, dry-run, orphans, check, broken/working remote URLs, different corpi same path)
- [x] `[🧪test][🔵P2]` Task 65 — WordMapServiceTest: 8 test (translate known/unknown/empty, planet names, prepositions, guessEnglishName)
- [x] `[🎨frontend][🟠P1]` Task 60-64 — Inline styles→Tailwind, accessibility (scope, aria-label, aria-current, role), partials, delete protection
- [x] `[🖥️backend][🎨frontend][🔵P2]` Task 55-59 — CSS cleanup, config fixes, deps removal, curiosita showRoute, mission badge partial
- [x] `[🖥️backend][🔵P2]` Task 52-53 — ClearDashboardCache trait, ImageUploadService extraction
- [x] `[🧪test][🟠P1]` Task 40 — Debug generale post-ottimizzazione: LightboxGalleria.jsx fix `}`→`});` (memo close), CorpoDettaglio.test.jsx fix import typo. 260 test (173 PHPUnit + 87 Vitest)

### 11/07/2026

- [x] `[📝docs][🔵P2]` Task 39 — Frontend Design audit: palette coerenza, 7 inconsistenze colore, SolarSystem firma, tipografia
- [x] `[📝docs][🔵P2]` Task 38 — Writing Guidelines audit: 14 ellipsis, 14 heading case, 10+ passive voice, 16 filler "con successo"
- [x] `[📝docs][🔵P2]` Task 37 — Web Design Guidelines audit: 14 file React, 3 high, 6 medium, 3 low priority
- [x] `[🧪test][🔵P2]` Task 36 — DashboardApiTest complete: 4 test (counts, corpi_in_evidenza, ultimi_corpi, missioni_per_stato)
- [x] `[🧪test][🟠P1]` Task 35 — Copertura test mancante: CorpoCelesteActionsTest(7), GalleriaOrdineTest(6), NasaImportTest(8)
- [x] `[🧪test][🟠P1]` Task 34 — Factory foreign key fix: corpo_celeste_id rimosso, usato ->for()
- [x] `[🧪test][🔵P2]` Task 33 — Frontend fixtures.js centralizzato condiviso tra 6 test file
- [x] `[🧪test][🟠P1]` Task 32 — Uniform Http::fake() pattern in tutti i test
- [x] `[🧪test][🟠P1]` Task 31 — Uniform Http::fake() pattern in tutti i test
- [x] `[🧪test][🟠P1]` Task 30 — AuthorizationTest: 19 test (store/update/delete per 5 entità + 6 guest redirect)
- [x] `[🖥️backend][🟠P1]` Task 29 — AdminTestCase base class: 5/5 CRUD test la estendono
- [x] `[🖥️backend][🟠P1]` Task 28 — suggestNome caching + debounce: Cache::remember(3600)
- [x] `[🖥️backend][🟠P1]` Task 27 — Authorization consistente: DashboardController fixato
- [x] `[🎨frontend][🔵P2]` Task 26 — React.memo: LightboxGalleria + Thumbnail
- [x] `[🎨frontend][🟠P1]` Task 25 — CSS component class: .admin-input, 8 Blade views riscritti
- [x] `[🎨frontend][🟠P1]` Task 24 — Hardcoded hex → CSS variables: 13 variabili, 52 hex sostituiti
- [x] `[🎨frontend][🟠P1]` Task 23 — Partials Blade: back-link, search, flash, stat-card, show-actions, index-actions
- [x] `[🎨frontend][🟠P1]` Task 22 — Form partial unificato: 5 \_form.blade.php, 10 create/edit riscritti
- [x] `[🖥️backend][🟠P1]` Task 21 — Cache dashboard + invalidazione su CRUD
- [x] `[🎨frontend][🟠P1]` Task 20 — framer-motion → CSS transitions + SolarSystem clickable/immagini
- [x] `[🎨frontend][🟠P1]` Task 19 — Inline styles → Tailwind classes: ~68 oggetti in 15 file
- [x] `[🎨frontend][🟠P1]` Task 18 — Rimossi import morti React + dipendenze inutilizzate/malposizionate

### 10/07/2026

- [x] `[🖥️backend][🔴P0]` Task 18 — 10 bug critici fixati
- [x] `[🖥️backend][🟠P1]` Task 17 — Quick wins: per_page, relazioni, .catch, nasa_id, indexes
- [x] `[🖥️backend][🟠P1]` Task 16 — FormRequest validazione store/update CorpoCeleste
- [x] `[🖥️backend][🔴P0]` Task 15 — Rimossa dipendenza Inertia
- [x] `[🖥️backend][🔴P0]` Task 14 — Auth pages: Inertia → Blade puro
- [x] `[🖥️backend][🔴P0]` Task 13 — Authorization Policy/Gates ai controller admin

### 09/07/2026

- [x] `[🖥️backend][🔴P0]` Task 12 — Bugfix auth, NASA import dedup, galleria cleanup
- [x] `[🖥️backend][🟠P1]` Task 11 — Bug critici: route(), nasa_id, categoria_id
- [x] `[🖥️backend][🟠P1]` Task 10 — Remote URLs, nome_it/nome_display, wordMap, auto-suggest admin

### 08/07/2026

- [x] `[🖥️backend][🟠P1]` Task 9 — NASA Import multi-immagine, Service Layer, CLI fetch-nasa
- [x] `[🖥️backend][🟠P1]` Task 8 — Bugfix Intervention Image v4, Force Import All

### 07/07/2026

- [x] `[🖥️backend][🎨frontend][📝docs]` Task 7 — Fix orbite, redirect route, profilo, documentazione

### 04/07/2026

- [x] `[🎨frontend][🔴P0]` Task 6 — React: Dettaglio, Lightbox, Missioni, Comparatore
- [x] `[🎨frontend][🔴P0]` Task 5 — React: Homepage, Sistema solare animato, Lista
- [x] `[🖥️backend][🔴P0]` Task 4 — API REST (10 endpoint)

### 03/07/2026

- [x] `[🖥️backend][🎨frontend][🔴P0]` Task 3 — CRUD Admin (Categorie, Corpi Celesti, Missioni, Curiosità, Galleria)
- [x] `[🖥️backend][💾database][🔴P0]` Task 2 — Database e Modelli (6 migrations, 5 models, seeder)

### 02/07/2026

- [x] `[🖥️backend][🎨frontend][📝docs][🔴P0]` Task 1 — Setup Laravel + Breeze + React + documentazione

## Note

- **Stato**: 2 task aperte. 377 test (267 PHPUnit + 110 Vitest), tutti verdi.
- Tasks spuntati (`[x]`) vengono spostati nella sezione **Fatto**
- Formato per aggiungere un nuovo task:
    ```
    - [ ] `[🖥️🎨💾🧪✨📝][🔴🟠🔵🟣⚪]` Descrizione — `file/principale/coinvolto`
    ```
    **Tag (oggetti — ambito)**: `[🖥️backend]` `[🎨frontend]` `[💾database]` `[🧪test]` `[✨feature]` `[📝docs]`
    **Priorità (cerchi — urgenza)**: 🔴P0 bloccante · 🟠P1 utente · 🔵P2 manutenzione · 🟣P3 accessibilità · ⚪P4 futuro
