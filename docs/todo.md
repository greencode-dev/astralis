# Todo

*Ultimo aggiornamento: 2026-07-14*

## Da Fare

## Fatto

- [x] **Task 70** — API edge case tests: ApiEdgeCaseTest.php (17 test: percent, underscore, per_page, agenzia/stato filters, empty DB, factory, dashboard, galleria/curiosita includes)
- [x] **Task 69** — Search & filter tests: SearchAndFilterTest.php (10 test: search per nome/nome_it/titolo/didascalia, stato filter, wildcard escaping)
- [x] **Task 67** — Frontend tests: NotFound(4), ErrorBoundary(4), TimelineMissioni(8), Navbar(6) — 22 test Vitest
- [x] **Task 66** — CleanupGalleryDuplicatesTest: 9 test (dedup, dry-run, orphans, check, broken/working remote URLs, different corpi same path)
- [x] **Task 65** — WordMapServiceTest: 8 test (translate known/unknown/empty, planet names, prepositions, guessEnglishName)
- [x] **Task 60-64** — Inline styles→Tailwind, accessibility (scope, aria-label, aria-current, role), partials, delete protection
- [x] **Task 55-59** — CSS cleanup, config fixes, deps removal, curiosita showRoute, mission badge partial
- [x] **Task 52-53** — ClearDashboardCache trait, ImageUploadService extraction
- [x] **Task 40** — Debug generale post-ottimizzazione: LightboxGalleria.jsx fix `}`→`});` (memo close), CorpoDettaglio.test.jsx fix import typo. 260 test (173 PHPUnit + 87 Vitest)
- [x] **Task 39** — Frontend Design audit: palette coerenza, 7 inconsistenze colore, SolarSystem firma, tipografia
- [x] **Task 38** — Writing Guidelines audit: 14 ellipsis, 14 heading case, 10+ passive voice, 16 filler "con successo"
- [x] **Task 37** — Web Design Guidelines audit: 14 file React, 3 high, 6 medium, 3 low priority
- [x] **Task 36** — DashboardApiTest complete: 4 test (counts, corpi_in_evidenza, ultimi_corpi, missioni_per_stato)
- [x] **Task 35** — Copertura test mancante: CorpoCelesteActionsTest(7), GalleriaOrdineTest(6), NasaImportTest(8)
- [x] **Task 34** — Factory foreign key fix: corpo_celeste_id rimosso, usato ->for()
- [x] **Task 33** — Frontend fixtures.js centralizzato condiviso tra 6 test file
- [x] **Task 32** — Uniform Http::fake() pattern in tutti i test
- [x] **Task 31** — AuthorizationTest: 19 test (store/update/delete per 5 entità + 6 guest redirect)
- [x] **Task 30** — AdminTestCase base class: 5/5 CRUD test la estendono
- [x] **Task 29** — suggestNome caching + debounce: Cache::remember(3600)
- [x] **Task 28** — Authorization consistente: DashboardController fixato
- [x] **Task 27** — React.memo: LightboxGalleria + Thumbnail
- [x] **Task 26** — CSS component class: .admin-input, 8 Blade views riscritti
- [x] **Task 25** — Hardcoded hex → CSS variables: 13 variabili, 52 hex sostituiti
- [x] **Task 24** — Partials Blade: back-link, search, flash, stat-card, show-actions, index-actions
- [x] **Task 23** — Form partial unificato: 5 _form.blade.php, 10 create/edit riscritti
- [x] **Task 22** — Cache dashboard + invalidazione su CRUD
- [x] **Task 21** — framer-motion → CSS transitions + SolarSystem clickable/immagini
- [x] **Task 20** — Inline styles → Tailwind classes: ~68 oggetti in 15 file
- [x] **Task 19** — Rimossi import morti React + dipendenze inutilizzate/malposizionate
- [x] **Task 18** — 10 bug critici fixati
- [x] **Task 17** — Quick wins: per_page, relazioni, .catch, nasa_id, indexes
- [x] **Task 16** — FormRequest validazione store/update CorpoCeleste
- [x] **Task 15** — Rimossa dipendenza Inertia
- [x] **Task 14** — Auth pages: Inertia → Blade puro
- [x] **Task 13** — Authorization Policy/Gates ai controller admin
- [x] **Task 12** — Bugfix auth, NASA import dedup, galleria cleanup
- [x] **Task 11** — Bug critici: route(), nasa_id, categoria_id
- [x] **Task 10** — Remote URLs, nome_it/nome_display, wordMap, auto-suggest admin
- [x] **Task 9** — NASA Import multi-immagine, Service Layer, CLI fetch-nasa
- [x] **Task 8** — Bugfix Intervention Image v4, Force Import All
- [x] **Task 7** — Fix orbite, redirect route, profilo, documentazione
- [x] **Task 6** — React: Dettaglio, Lightbox, Missioni, Comparatore
- [x] **Task 5** — React: Homepage, Sistema solare animato, Lista
- [x] **Task 4** — API REST (10 endpoint)
- [x] **Task 3** — CRUD Admin (Categorie, Corpi Celesti, Missioni, Curiosità, Galleria)
- [x] **Task 2** — Database e Modelli (6 migrations, 5 models, seeder)
- [x] **Task 1** — Setup Laravel + Breeze + React + documentazione

## Note

- **Stato**: 70 task totali, tutte completate. 322 test (215 PHPUnit + 107 Vitest), 522+ assertion.
- Tasks spuntati (`[x]`) vengono spostati nella sezione **Fatto**
- Formato per aggiungere un nuovo task:
  ```
  - [ ] `[🖥️🎨💾🧪✨📝][🔴🟠🔵🟣⚪]` Descrizione — `file/principale/coinvolto`
  ```
  **Tag (oggetti — ambito)**: `[🖥️backend]` `[🎨frontend]` `[💾database]` `[🧪test]` `[✨feature]` `[📝docs]`
  **Priorità (cerchi — urgenza)**: 🔴P0 bloccante · 🟠P1 utente · 🔵P2 manutenzione · 🟣P3 accessibilità · ⚪P4 futuro
