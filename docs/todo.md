# Todo

*Ultimo aggiornamento: 2026-07-11*

## Da Fare

- [ ] `[🔴P0]` **Task 40 — Debug generale post-ottimizzazione** — Verificare che tutto funzioni dopo le attività di ottimizzazione. Controllare: route, pagine, form, upload, search, paginazione, animation, responsive, admin CRUD, API endpoint

## Fatto

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

- **Stato**: 40 task totali. 39 completate, 1 aperta (debug). 235 test (173 PHPUnit + 62 Vitest).
- Tasks spuntati (`[x]`) vengono spostati nella sezione **Fatto**
- Formato per aggiungere un nuovo task:
  ```
  - [ ] `[🖥️🎨💾🧪✨📝][🔴🟠🔵🟣⚪]` Descrizione — `file/principale/coinvolto`
  ```
  **Tag (oggetti — ambito)**: `[🖥️backend]` `[🎨frontend]` `[💾database]` `[🧪test]` `[✨feature]` `[📝docs]`
  **Priorità (cerchi — urgenza)**: 🔴P0 bloccante · 🟠P1 utente · 🔵P2 manutenzione · 🟣P3 accessibilità · ⚪P4 futuro
