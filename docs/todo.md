# Todo

> [Formato e legenda →](#note)

_Ultimo aggiornamento: 18/07/2026_

## Da Fare

- [ ] [Task 91] `[🟠][🎨]` Integrare 3 logo PNG nel progetto (completo, solo logo, solo testo) — Navbar, Footer, Sidebar admin, Auth layout
- [ ] [Task 90] `[🟠][🎨]` SolarSystem fix orbiting — centrare orbite (cambiare `absolute inset-0` → `absolute left-0 top-0 w-full h-full` nel container orbite) — `SolarSystem.jsx`
- [ ] [Task 89] `[🟠][🎨]` Landing page redesign (Opzione A) — hero full-width, SolarSystem al centro, testo + CTA + stats overlay con gradiente in basso — `HomePage.jsx`
- [ ] [Task 88] `[🟠][🖥️]` Revisione import NASA — verificare `NasaImageService.php` e `CorpoCelesteObserver.php` per comportamento errato o edge case — `NasaImageService.php`, `CorpoCelesteObserver.php`
- [ ] [Task 87] `[🟠][🖥️]` Loghi missioni corrotti/mancanti — `MissioneSeeder` referencia 9 logo che non esistono su disco (`public/images/missions/` non esiste). Verificare se servono, crearli o rimuovere i riferimenti — `MissioneSeeder.php`
- [ ] [Task 86] `[🟠][🖥️]` Immagini Marte corrotte pagina admin — `http://127.0.0.1:8000/admin/corpi-celesti/5` mostra immagini corrotte. Verificare campo `immagine` nel DB e path su disco — `CorpoCelesteController.php`

## Fatto

### 18/07/2026

- [x] [Task 85] `[🔴][🖥️]` Gallery quality fix — eliminati 74 record galleria, reimportati 90 (18×5) tutti `~orig.jpg` (0 thumb/small/medium). Fix `importForBody()`: rimosso early return che bloccava import galleria per corpi con `immagine_utente=true` — `NasaImageService.php`
- [x] [Task 84] `[🔵][🧪]` Test aggiornato — `test_import_for_body_force_does_not_overwrite_user_image` ora verifica che main non venga sovrascritta ma galleria venga importata — `NasaImageServiceTest.php`
- [x] [Task 83] `[🔵][📝]` Fix nomi skill in AGENTS.md (`react-best-practices` → `vercel-react-best-practices`, `composition-patterns` → `vercel-composition-patterns`)
- [x] [Task 82] `[🔵][📝]` Unificare sessioni 17/07 in changelog.md + aggiornare conteggi test
- [x] [Task 81] `[🟠][🎨]` Refactoring card dashboard — link cliccabili, 4 colori unici, meta info, table name links — `dashboard-stat.blade.php`, `DashboardController.php`, `dashboard.blade.php`
- [x] [Task 80] `[🔵][🧪]` Dashboard test aggiornati — clickable links, table links, meta info (3 nuovi test) — `DashboardTest.php`
- [x] [Task 79] `[🟠][🎨]` Solar system immagini — 9 foto reali NASA/croccate, tutte quadrate, dimensioni ingrandite (~1.8×) — `public/images/solar-system/`
- [x] [Task 78] `[🟠][🎨]` Solar system Sole — sostituito con NASA 3D rendering, crop 359×359 — `sole.jpg`
- [x] [Task 77] `[🟠][🎨]` Solar system CSS — `object-cover` → `object-contain`, rimosso `bg-black` da pianeti/Sole — `SolarSystem.jsx`
- [x] [Task 76] `[🟠][🎨]` SolarSystem fix — rimuovere boxShadow + riscrivere animazione con `requestAnimationFrame` (rotazione continua, DOM diretto). Rimossi .jpg, aggiunti .png, pianeti ~50% più grandi, label unite in un solo Link, Saturno 62→72px — `SolarSystem.jsx`, `public/images/solar-system/`

### 17/07/2026

- [x] [Task 75] `[🔴][🖥️]` Fix galleria duplicati — riposizionare `removeDuplicates()` dopo `handleBrokenUrls()`, check duplicati in `handleSync()`, migration UNIQUE `(corpo_celeste_id, percorso)`, test aggiornati — `CleanupGalleryDuplicates.php`, `database/migrations/`
- [x] [Task 74] `[🔴][🎨]` Fix grafici dashboard — colori concreti hex, `maintainAspectRatio: false` + `h-64`, layout `lg:grid-cols-3`, grafici spostati in cima, guard `typeof Chart` — `dashboard.blade.php`
- [x] [Task 73] `[🔴][🖥️]` Fix homepage performance — rimosso `galleria` eager-load da index/simili, `Cache::remember` 5min, index composto `[in_evidenza, nome]`, heading "In Evidenza" sempre visibile — `CorpoCelesteController.php`, `HomePage.jsx`, migration
- [x] [Task 72] `[🔴][🖥️]` Fix proxy API in vite.config.js — aggiunto `server.proxy: { '/api': 'http://localhost:8000' }` — risolve white page + CORB error
- [x] [Task 71] `[🟠][🎨]` Mobile nav Escape + click-outside + route-change cleanup — `Navbar.jsx`
- [x] [Task 70] `[🔵][🎨]` framer-motion mantenuto (uso legittimo in SolarSystem)
- [x] [Task 69] `[🟠][🖥️]` memory_limit=512M — rimosso (codice inesistente)
- [x] [Task 68] `[🔵][🧪]` Test accessor nome_display + immagine_url — `CorpoCelesteTest.php` (6 test)
- [x] [Task 67] `[🔵][🧪]` Test setImageFromGallery: non-admin 403, remote URL, flash — `CorpoCelesteActionsTest.php`
- [x] [Task 66] `[🔵][🧪]` Test suggestNome: non-admin, caching, fallback raw Italian — `CorpoCelesteActionsTest.php`
- [x] [Task 65] `[🔵][🧪]` Test ImportNasaImage job: implements, proprietà, uniqueId, handle, failed — `ImportNasaImageTest.php` (9 test)
- [x] [Task 64] `[🔵][🧪]` 28 nuovi test: CorpoCelesteTest (6), ImportNasaImageTest (9), CorpoCelesteActionsTest (13)
- [x] [Task 63] `[🔵][✨]` Logo Astralis ad alta risoluzione caricati in public/
- [x] [Task 62] `[🔵][📝]` Installazione graphify + aggiornamento grafo knowledge graph (1647 nodi, 2587 edges, 213 community)
- [x] [Task 61] `[🔵][📝]` Aggiornamento docs: React 19→18, test count 252/359, task numbering, changelog 17/07
- [x] [Task 60] `[🟠][📝]` Comandi custom — AGENTS.md: `\commit`, `\push`, `\save` con workflow automatizzato e conferme via `question` tool
- [x] [Task 59] `[🟠][📝]` Snapshot sessione — `### Sessione corrente` in AGENTS.md, letta da `\start`, sovrascritta da `\save`
- [x] [Task 58] `[🟠][📝]` Conferme unificate — 7 punti in AGENTS.md riscritti con tool `question` a checkbox

### 16/07/2026

- [x] [Task 57] `[🟠][🖥️]` orWhere grouping — `Admin/CorpoCelesteController.php`
- [x] [Task 56] `[🟠][🖥️]` accessor indent — `CorpoCeleste.php`
- [x] [Task 55] `[🟠][🎨]` logo oversized — `Navbar.jsx` + `Footer.jsx`
- [x] [Task 54] `[🔵][🎨]` focus-visible ring — `SearchBar.jsx`
- [x] [Task 53] `[🟠][🎨]` hardcoded hex → CSS vars — `Comparatore.jsx`
- [x] [Task 52] `[🔵][🖥️]` flash 3 blocks → foreach loop — `flash.blade.php`
- [x] [Task 51] `[🔵][🎨]` extract useDebounce hook — `CorpiLista.jsx` + `hooks/useDebounce.js`

### 15/07/2026

- [x] [Task 50] `[🟠][🎨]` Sidebar + Partials: config/admin.php, \_sidebar-nav, category-badge, index-header, dashboard-stat, empty-table-row, in-evidenza-badge, flash-in-layout, CSS vars error/success, Route::is()
- [x] [Task 49] `[🔴][🖥️🧪]` Fasi 1-3 — Sicurezza + Bug critici + UX: 15 fix (security, retry, race condition, unique job, color picker, flash messages, navbar mobile, useFetch keep-data, comparatore URL-based, gravita/temperatura locale IT). 359 test (252 PHPUnit + 107 Vitest)

### 14/07/2026

- [x] [Task 48] `[🔵][🧪]` API edge case tests: ApiEdgeCaseTest.php (17 test: percent, underscore, per_page, agenzia/stato filters, empty DB, factory, dashboard, galleria/curiosita includes)
- [x] [Task 47] `[🔵][🧪]` Search & filter tests: SearchAndFilterTest.php (10 test: search per nome/nome_it/titolo/didascalia, stato filter, wildcard escaping)
- [x] [Task 46] `[🔵][🧪]` Frontend tests: NotFound(4), ErrorBoundary(4), TimelineMissioni(8), Navbar(6) — 22 test Vitest
- [x] [Task 45] `[🔵][🧪]` CleanupGalleryDuplicatesTest: 9 test (dedup, dry-run, orphans, check, broken/working remote URLs, different corpi same path)
- [x] [Task 44] `[🔵][🧪]` WordMapServiceTest: 8 test (translate known/unknown/empty, planet names, prepositions, guessEnglishName)
- [x] [Task 43] `[🟠][🎨]` Inline styles→Tailwind, accessibility (scope, aria-label, aria-current, role), partials, delete protection
- [x] [Task 42] `[🔵][🖥️🎨]` CSS cleanup, config fixes, deps removal, curiosita showRoute, mission badge partial
- [x] [Task 41] `[🔵][🖥️]` ClearDashboardCache trait, ImageUploadService extraction
- [x] [Task 40] `[🟠][🧪]` Debug generale post-ottimizzazione: LightboxGalleria.jsx fix `}`→`});` (memo close), CorpoDettaglio.test.jsx fix import typo. 260 test (173 PHPUnit + 87 Vitest)

### 11/07/2026

- [x] [Task 39] `[🟠][🧪]` Uniform Http::fake() pattern in tutti i test
- [x] [Task 38] `[🔵][📝]` Frontend Design audit: palette coerenza, 7 inconsistenze colore, SolarSystem firma, tipografia
- [x] [Task 37] `[🔵][📝]` Writing Guidelines audit: 14 ellipsis, 14 heading case, 10+ passive voice, 16 filler "con successo"
- [x] [Task 36] `[🔵][📝]` Web Design Guidelines audit: 14 file React, 3 high, 6 medium, 3 low priority
- [x] [Task 35] `[🔵][🧪]` DashboardApiTest complete: 4 test (counts, corpi_in_evidenza, ultimi_corpi, missioni_per_stato)
- [x] [Task 34] `[🟠][🧪]` Copertura test mancante: CorpoCelesteActionsTest(7), GalleriaOrdineTest(6), NasaImportTest(8)
- [x] [Task 33] `[🟠][🧪]` Factory foreign key fix: corpo_celeste_id rimosso, usato ->for()
- [x] [Task 32] `[🔵][🧪]` Frontend fixtures.js centralizzato condiviso tra 6 test file
- [x] [Task 31] `[🟠][🧪]` Uniform Http::fake() pattern in tutti i test
- [x] [Task 30] `[🟠][🧪]` Uniform Http::fake() pattern in tutti i test
- [x] [Task 29] `[🟠][🧪]` AuthorizationTest: 19 test (store/update/delete per 5 entità + 6 guest redirect)
- [x] [Task 28] `[🟠][🖥️]` AdminTestCase base class: 5/5 CRUD test la estendono
- [x] [Task 27] `[🟠][🖥️]` suggestNome caching + debounce: Cache::remember(3600)
- [x] [Task 26] `[🟠][🖥️]` Authorization consistente: DashboardController fixato
- [x] [Task 25] `[🔵][🎨]` React.memo: LightboxGalleria + Thumbnail
- [x] [Task 24] `[🟠][🎨]` CSS component class: .admin-input, 8 Blade views riscritti
- [x] [Task 23] `[🟠][🎨]` Hardcoded hex → CSS variables: 13 variabili, 52 hex sostituiti
- [x] [Task 22] `[🟠][🎨]` Partials Blade: back-link, search, flash, stat-card, show-actions, index-actions
- [x] [Task 21] `[🟠][🎨]` Form partial unificato: 5 \_form.blade.php, 10 create/edit riscritti
- [x] [Task 20] `[🟠][🖥️]` Cache dashboard + invalidazione su CRUD
- [x] [Task 19] `[🟠][🎨]` framer-motion → CSS transitions + SolarSystem clickable/immagini
- [x] [Task 18] `[🟠][🎨]` Inline styles → Tailwind classes: ~68 oggetti in 15 file
- [x] [Task 17] `[🟠][🎨]` Rimossi import morti React + dipendenze inutilizzate/malposizionate

### 10/07/2026

- [x] [Task 16] `[🔴][🖥️]` 10 bug critici fixati
- [x] [Task 15] `[🟠][🖥️]` Quick wins: per_page, relazioni, .catch, nasa_id, indexes
- [x] [Task 14] `[🟠][🖥️]` FormRequest validazione store/update CorpoCeleste
- [x] [Task 13] `[🔴][🖥️]` Rimossa dipendenza Inertia
- [x] [Task 12] `[🔴][🖥️]` Auth pages: Inertia → Blade puro
- [x] [Task 11] `[🔴][🖥️]` Authorization Policy/Gates ai controller admin

### 09/07/2026

- [x] [Task 10] `[🔴][🖥️]` Bugfix auth, NASA import dedup, galleria cleanup
- [x] [Task 9] `[🟠][🖥️]` Bug critici: route(), nasa_id, categoria_id
- [x] [Task 8] `[🟠][🖥️]` Remote URLs, nome_it/nome_display, wordMap, auto-suggest admin

### 08/07/2026

- [x] [Task 7] `[🟠][🖥️]` NASA Import multi-immagine, Service Layer, CLI fetch-nasa
- [x] [Task 6] `[🟠][🖥️]` Bugfix Intervention Image v4, Force Import All

### 07/07/2026

- [x] [Task 5] `[🔵][🖥️🎨📝]` Fix orbite, redirect route, profilo, documentazione

### 04/07/2026

- [x] [Task 4] `[🔴][🎨]` React: Dettaglio, Lightbox, Missioni, Comparatore
- [x] [Task 3] `[🔴][🎨]` React: Homepage, Sistema solare animato, Lista
- [x] [Task 2] `[🔴][🖥️]` API REST (10 endpoint)

### 03/07/2026

- [x] [Task 1] `[🔴][🖥️🎨]` CRUD Admin (Categorie, Corpi Celesti, Missioni, Curiosità, Galleria)

## Note

- **Stato**: 6 task aperte. 377 test (267 PHPUnit + 110 Vitest), tutti verdi.
- Tasks spuntati (`[x]`) vengono spostati nella sezione **Fatto**
- Formato per aggiungere un nuovo task:
    ```
    - [ ] [Task n] `[Priorità][Topic]` Descrizione — `file/principale/coinvolto`
    ```
    **Priorità**: `[🔴]` Critic · `[🟠]` High · `[🔵]` Medium · `[🟢]` Low
    **Topic**: `[🖥️]` Backend · `[🎨]` Frontend · `[💾]` Database · `[🧪]` Test · `[✨]` Feature · `[📝]` Docs
