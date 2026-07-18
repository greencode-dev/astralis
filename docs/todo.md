# Todo

> [Formato e legenda →](#note)

_Ultimo aggiornamento: 18/07/2026_

## Da Fare

- [ ] [Task 92] `[🎨frontend][🟠P1]` Integrare 3 logo PNG nel progetto (completo, solo logo, solo testo) — Navbar, Footer, Sidebar admin, Auth layout
- [ ] [Task 91] `[🎨frontend][🟠P1]` SolarSystem fix orbiting — centrare orbite (cambiare `absolute inset-0` → `absolute left-0 top-0 w-full h-full` nel container orbite) — `SolarSystem.jsx`
- [ ] [Task 90] `[🎨frontend][🟠P1]` Landing page redesign (Opzione A) — hero full-width, SolarSystem al centro, testo + CTA + stats overlay con gradiente in basso — `HomePage.jsx`
- [ ] [Task 89] `[🖥️backend][🟠P1]` Revisione import NASA — verificare `NasaImageService.php` e `CorpoCelesteObserver.php` per comportamento errato o edge case — `NasaImageService.php`, `CorpoCelesteObserver.php`
- [ ] [Task 88] `[🖥️backend][🟠P1]` Loghi missioni corrotti/mancanti — `MissioneSeeder` referencia 9 logo che non esistono su disco (`public/images/missions/` non esiste). Verificare se servono, crearli o rimuovere i riferimenti — `MissioneSeeder.php`
- [ ] [Task 87] `[🖥️backend][🟠P1]` Immagini Marte corrotte pagina admin — `http://127.0.0.1:8000/admin/corpi-celesti/5` mostra immagini corrotte. Verificare campo `immagine` nel DB e path su disco — `CorpoCelesteController.php`

## Fatto

### 18/07/2026

- [x] [Task 86] `[🖥️backend][🔴P0]` Gallery quality fix — eliminati 74 record galleria, reimportati 90 (18×5) tutti `~orig.jpg` (0 thumb/small/medium). Fix `importForBody()`: rimosso early return che bloccava import galleria per corpi con `immagine_utente=true` — `NasaImageService.php`
- [x] [Task 85] `[🧪test][🔵P2]` Test aggiornato — `test_import_for_body_force_does_not_overwrite_user_image` ora verifica che main non venga sovrascritta ma galleria venga importata — `NasaImageServiceTest.php`
- [x] [Task 84] `[📝docs][🔵P2]` Fix nomi skill in AGENTS.md (`react-best-practices` → `vercel-react-best-practices`, `composition-patterns` → `vercel-composition-patterns`)
- [x] [Task 83] `[📝docs][🔵P2]` Unificare sessioni 17/07 in changelog.md + aggiornare conteggi test
- [x] [Task 82] `[🎨frontend][🟠P1]` Refactoring card dashboard — link cliccabili, 4 colori unici, meta info, table name links — `dashboard-stat.blade.php`, `DashboardController.php`, `dashboard.blade.php`
- [x] [Task 81] `[🧪test][🔵P2]` Dashboard test aggiornati — clickable links, table links, meta info (3 nuovi test) — `DashboardTest.php`
- [x] [Task 80] `[🎨frontend][🟠P1]` Solar system immagini — 9 foto reali NASA/croccate, tutte quadrate, dimensioni ingrandite (~1.8×) — `public/images/solar-system/`
- [x] [Task 79] `[🎨frontend][🟠P1]` Solar system Sole — sostituito con NASA 3D rendering, crop 359×359 — `sole.jpg`
- [x] [Task 78] `[🎨frontend][🟠P1]` Solar system CSS — `object-cover` → `object-contain`, rimosso `bg-black` da pianeti/Sole — `SolarSystem.jsx`
- [x] [Task 77] `[🎨frontend][🟠P1]` SolarSystem fix — rimuovere boxShadow + riscrivere animazione con `requestAnimationFrame` (rotazione continua, DOM diretto). Rimossi .jpg, aggiunti .png, pianeti ~50% più grandi, label unite in un solo Link, Saturno 62→72px — `SolarSystem.jsx`, `public/images/solar-system/`

### 17/07/2026

- [x] [Task 76] `[🖥️backend][🔴P0]` Fix galleria duplicati — riposizionare `removeDuplicates()` dopo `handleBrokenUrls()`, check duplicati in `handleSync()`, migration UNIQUE `(corpo_celeste_id, percorso)`, test aggiornati — `CleanupGalleryDuplicates.php`, `database/migrations/`
- [x] [Task 75] `[🎨frontend][🔴P0]` Fix grafici dashboard — colori concreti hex, `maintainAspectRatio: false` + `h-64`, layout `lg:grid-cols-3`, grafici spostati in cima, guard `typeof Chart` — `dashboard.blade.php`
- [x] [Task 74] `[🖥️backend][🔴P0]` Fix homepage performance — rimosso `galleria` eager-load da index/simili, `Cache::remember` 5min, index composto `[in_evidenza, nome]`, heading "In Evidenza" sempre visibile — `CorpoCelesteController.php`, `HomePage.jsx`, migration
- [x] [Task 73] `[🖥️backend][🔴P0]` Fix proxy API in vite.config.js — aggiunto `server.proxy: { '/api': 'http://localhost:8000' }` — risolve white page + CORB error
- [x] [Task 72] `[🎨frontend][🟠P1]` Mobile nav Escape + click-outside + route-change cleanup — `Navbar.jsx`
- [x] [Task 71] `[🎨frontend][🔵P2]` framer-motion mantenuto (uso legittimo in SolarSystem)
- [x] [Task 70] `[🖥️backend][🟠P1]` memory_limit=512M — rimosso (codice inesistente)
- [x] [Task 69] `[🧪test][🔵P2]` Test accessor nome_display + immagine_url — `CorpoCelesteTest.php` (6 test)
- [x] [Task 68] `[🧪test][🔵P2]` Test setImageFromGallery: non-admin 403, remote URL, flash — `CorpoCelesteActionsTest.php`
- [x] [Task 67] `[🧪test][🔵P2]` Test suggestNome: non-admin, caching, fallback raw Italian — `CorpoCelesteActionsTest.php`
- [x] [Task 66] `[🧪test][🔵P2]` Test ImportNasaImage job: implements, proprietà, uniqueId, handle, failed — `ImportNasaImageTest.php` (9 test)
- [x] [Task 65] `[🧪test][🔵P2]` 28 nuovi test: CorpoCelesteTest (6), ImportNasaImageTest (9), CorpoCelesteActionsTest (13)
- [x] [Task 64] `[✨feature][🔵P2]` Logo Astralis ad alta risoluzione caricati in public/
- [x] [Task 63] `[📝docs][🔵P2]` Installazione graphify + aggiornamento grafo knowledge graph (1647 nodi, 2587 edges, 213 community)
- [x] [Task 62] `[📝docs][🔵P2]` Aggiornamento docs: React 19→18, test count 252/359, task numbering, changelog 17/07
- [x] [Task 61] `[📝docs][🟠P1]` Comandi custom — AGENTS.md: `\commit`, `\push`, `\save` con workflow automatizzato e conferme via `question` tool
- [x] [Task 60] `[📝docs][🟠P1]` Snapshot sessione — `### Sessione corrente` in AGENTS.md, letta da `\start`, sovrascritta da `\save`
- [x] [Task 59] `[📝docs][🟠P1]` Conferme unificate — 7 punti in AGENTS.md riscritti con tool `question` a checkbox

### 16/07/2026

- [x] [Task 58] `[🖥️backend][🟠P1]` orWhere grouping — `Admin/CorpoCelesteController.php`
- [x] [Task 57] `[🖥️backend][🟠P1]` accessor indent — `CorpoCeleste.php`
- [x] [Task 56] `[🎨frontend][🟠P1]` logo oversized — `Navbar.jsx` + `Footer.jsx`
- [x] [Task 55] `[🎨frontend][🔵P2]` focus-visible ring — `SearchBar.jsx`
- [x] [Task 54] `[🎨frontend][🟠P1]` hardcoded hex → CSS vars — `Comparatore.jsx`
- [x] [Task 53] `[🖥️backend][🔵P2]` flash 3 blocks → foreach loop — `flash.blade.php`
- [x] [Task 52] `[🎨frontend][🔵P2]` extract useDebounce hook — `CorpiLista.jsx` + `hooks/useDebounce.js`

### 15/07/2026

- [x] [Task 51] `[🎨frontend][🟠P1]` Sidebar + Partials: config/admin.php, \_sidebar-nav, category-badge, index-header, dashboard-stat, empty-table-row, in-evidenza-badge, flash-in-layout, CSS vars error/success, Route::is()
- [x] [Task 50] `[🖥️backend][🧪test][🔴P0]` Fasi 1-3 — Sicurezza + Bug critici + UX: 15 fix (security, retry, race condition, unique job, color picker, flash messages, navbar mobile, useFetch keep-data, comparatore URL-based, gravita/temperatura locale IT). 359 test (252 PHPUnit + 107 Vitest)

### 14/07/2026

- [x] [Task 49] `[🧪test][🔵P2]` API edge case tests: ApiEdgeCaseTest.php (17 test: percent, underscore, per_page, agenzia/stato filters, empty DB, factory, dashboard, galleria/curiosita includes)
- [x] [Task 48] `[🧪test][🔵P2]` Search & filter tests: SearchAndFilterTest.php (10 test: search per nome/nome_it/titolo/didascalia, stato filter, wildcard escaping)
- [x] [Task 47] `[🧪test][🔵P2]` Frontend tests: NotFound(4), ErrorBoundary(4), TimelineMissioni(8), Navbar(6) — 22 test Vitest
- [x] [Task 46] `[🧪test][🔵P2]` CleanupGalleryDuplicatesTest: 9 test (dedup, dry-run, orphans, check, broken/working remote URLs, different corpi same path)
- [x] [Task 45] `[🧪test][🔵P2]` WordMapServiceTest: 8 test (translate known/unknown/empty, planet names, prepositions, guessEnglishName)
- [x] [Task 44] `[🎨frontend][🟠P1]` Inline styles→Tailwind, accessibility (scope, aria-label, aria-current, role), partials, delete protection
- [x] [Task 43] `[🖥️backend][🎨frontend][🔵P2]` CSS cleanup, config fixes, deps removal, curiosita showRoute, mission badge partial
- [x] [Task 42] `[🖥️backend][🔵P2]` ClearDashboardCache trait, ImageUploadService extraction
- [x] [Task 41] `[🧪test][🟠P1]` Debug generale post-ottimizzazione: LightboxGalleria.jsx fix `}`→`});` (memo close), CorpoDettaglio.test.jsx fix import typo. 260 test (173 PHPUnit + 87 Vitest)

### 11/07/2026

- [x] [Task 40] `[🧪test][🟠P1]` Debug generale post-ottimizzazione: LightboxGalleria.jsx fix `}`→`});` (memo close), CorpoDettaglio.test.jsx fix import typo. 260 test (173 PHPUnit + 87 Vitest)
- [x] [Task 39] `[📝docs][🔵P2]` Frontend Design audit: palette coerenza, 7 inconsistenze colore, SolarSystem firma, tipografia
- [x] [Task 38] `[📝docs][🔵P2]` Writing Guidelines audit: 14 ellipsis, 14 heading case, 10+ passive voice, 16 filler "con successo"
- [x] [Task 37] `[📝docs][🔵P2]` Web Design Guidelines audit: 14 file React, 3 high, 6 medium, 3 low priority
- [x] [Task 36] `[🧪test][🔵P2]` DashboardApiTest complete: 4 test (counts, corpi_in_evidenza, ultimi_corpi, missioni_per_stato)
- [x] [Task 35] `[🧪test][🟠P1]` Copertura test mancante: CorpoCelesteActionsTest(7), GalleriaOrdineTest(6), NasaImportTest(8)
- [x] [Task 34] `[🧪test][🟠P1]` Factory foreign key fix: corpo_celeste_id rimosso, usato ->for()
- [x] [Task 33] `[🧪test][🔵P2]` Frontend fixtures.js centralizzato condiviso tra 6 test file
- [x] [Task 32] `[🧪test][🟠P1]` Uniform Http::fake() pattern in tutti i test
- [x] [Task 31] `[🧪test][🟠P1]` Uniform Http::fake() pattern in tutti i test
- [x] [Task 30] `[🧪test][🟠P1]` AuthorizationTest: 19 test (store/update/delete per 5 entità + 6 guest redirect)
- [x] [Task 29] `[🖥️backend][🟠P1]` AdminTestCase base class: 5/5 CRUD test la estendono
- [x] [Task 28] `[🖥️backend][🟠P1]` suggestNome caching + debounce: Cache::remember(3600)
- [x] [Task 27] `[🖥️backend][🟠P1]` Authorization consistente: DashboardController fixato
- [x] [Task 26] `[🎨frontend][🔵P2]` React.memo: LightboxGalleria + Thumbnail
- [x] [Task 25] `[🎨frontend][🟠P1]` CSS component class: .admin-input, 8 Blade views riscritti
- [x] [Task 24] `[🎨frontend][🟠P1]` Hardcoded hex → CSS variables: 13 variabili, 52 hex sostituiti
- [x] [Task 23] `[🎨frontend][🟠P1]` Partials Blade: back-link, search, flash, stat-card, show-actions, index-actions
- [x] [Task 22] `[🎨frontend][🟠P1]` Form partial unificato: 5 \_form.blade.php, 10 create/edit riscritti
- [x] [Task 21] `[🖥️backend][🟠P1]` Cache dashboard + invalidazione su CRUD
- [x] [Task 20] `[🎨frontend][🟠P1]` framer-motion → CSS transitions + SolarSystem clickable/immagini
- [x] [Task 19] `[🎨frontend][🟠P1]` Inline styles → Tailwind classes: ~68 oggetti in 15 file
- [x] [Task 18] `[🎨frontend][🟠P1]` Rimossi import morti React + dipendenze inutilizzate/malposizionate

### 10/07/2026

- [x] [Task 17] `[🖥️backend][🔴P0]` 10 bug critici fixati
- [x] [Task 16] `[🖥️backend][🟠P1]` Quick wins: per_page, relazioni, .catch, nasa_id, indexes
- [x] [Task 15] `[🖥️backend][🟠P1]` FormRequest validazione store/update CorpoCeleste
- [x] [Task 14] `[🖥️backend][🔴P0]` Rimossa dipendenza Inertia
- [x] [Task 13] `[🖥️backend][🔴P0]` Auth pages: Inertia → Blade puro
- [x] [Task 12] `[🖥️backend][🔴P0]` Authorization Policy/Gates ai controller admin

### 09/07/2026

- [x] [Task 11] `[🖥️backend][🔴P0]` Bugfix auth, NASA import dedup, galleria cleanup
- [x] [Task 10] `[🖥️backend][🟠P1]` Bug critici: route(), nasa_id, categoria_id
- [x] [Task 9] `[🖥️backend][🟠P1]` Remote URLs, nome_it/nome_display, wordMap, auto-suggest admin

### 08/07/2026

- [x] [Task 8] `[🖥️backend][🟠P1]` NASA Import multi-immagine, Service Layer, CLI fetch-nasa
- [x] [Task 7] `[🖥️backend][🟠P1]` Bugfix Intervention Image v4, Force Import All

### 07/07/2026

- [x] [Task 6] `[🖥️backend][🎨frontend][📝docs]` Fix orbite, redirect route, profilo, documentazione

### 04/07/2026

- [x] [Task 5] `[🎨frontend][🔴P0]` React: Dettaglio, Lightbox, Missioni, Comparatore
- [x] [Task 4] `[🎨frontend][🔴P0]` React: Homepage, Sistema solare animato, Lista
- [x] [Task 3] `[🖥️backend][🔴P0]` API REST (10 endpoint)

### 03/07/2026

- [x] [Task 2] `[🖥️backend][🎨frontend][🔴P0]` CRUD Admin (Categorie, Corpi Celesti, Missioni, Curiosità, Galleria)
- [x] [Task 1] `[🖥️backend][💾database][🔴P0]` Database e Modelli (6 migrations, 5 models, seeder)

### 02/07/2026

- [x] [Task 1] `[🖥️backend][🎨frontend][📝docs][🔴P0]` Setup Laravel + Breeze + React + documentazione

## Note

- **Stato**: 6 task aperte. 377 test (267 PHPUnit + 110 Vitest), tutti verdi.
- Tasks spuntati (`[x]`) vengono spostati nella sezione **Fatto**
- Formato per aggiungere un nuovo task:
    ```
    - [ ] [Task n] `[🖥️🎨💾🧪✨📝][🔴🟠🔵🟣⚪]` Descrizione — `file/principale/coinvolto`
    ```
    **Tag (oggetti — ambito)**: `[🖥️backend]` `[🎨frontend]` `[💾database]` `[🧪test]` `[✨feature]` `[📝docs]`
    **Priorità (cerchi — urgenza)**: 🔴P0 bloccante · 🟠P1 utente · 🔵P2 manutenzione · 🟣P3 accessibilità · ⚪P4 futuro
