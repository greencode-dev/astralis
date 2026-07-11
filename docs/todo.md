# Todo

*Ultimo aggiornamento: 2026-07-11*

## Piano Ottimizzazione — Completato

Tutte le task (1-10) del piano di ottimizzazione sono state completate. Il progetto ha 173 test PHPUnit + 62 Vitest (235 totali, tutti green). 16 commit locali ahead di origin/master.

## Da Fare

- [ ] `[🔴P0]` **Debug generale post-ottimizzazione** — Verificare che tutto funzioni correttamente dopo le attività di ottimizzazione svolte. Controllare: route, pagine, form, upload, search, paginazione, animation, responsive, admin CRUD, API endpoint

## Fatto

- [x] **Task 10.3 — Frontend Design review** — palette coerenza, 7 inconsistenze colore, SolarSystem firma, tipografia, manca prefers-reduced-motion
- [x] **Task 10.2 — Writing Guidelines review** — 14 ellipsis, 14 heading case, 10+ passive voice, 16 filler "con successo"
- [x] **Task 10.1 — Web Design Guidelines review** — audit 14 file React: 3 high, 6 medium, 3 low priority
- [x] **Task 9.7 — DashboardApiTest complete** — 4 test: counts + corpi_in_evidenza + ultimi_corpi + missioni_per_stato
- [x] **Task 9.6 — Copertura test mancante** — CorpoCelesteActionsTest(7), GalleriaOrdineTest(6), NasaImportTest(8)
- [x] **Task 9.5 — Factory foreign key fix** — corpo_celeste_id rimosso da GalleriaCorpoFactory, CuriositaFactory, usato ->for()
- [x] **Task 9.4 — Frontend fixtures.js centralizzato** — condiviso tra 6 test file
- [x] **Task 9.3 — Uniform Http::fake() pattern** — GalleriaApiTest rimosso unsetEventDispatcher, MissioneApiTest aggiunto Http::fake()
- [x] **Task 9.2 — AuthorizationTest** — 19 test: store/update/delete per 5 entità + 6 guest redirect
- [x] **Task 9.1 — AdminTestCase base class** — 5/5 CRUD test estendono AdminTestCase
- [x] **Task 8.3 — CDN fallback Alpine.js + Chart.js** — già in place
- [x] **Task 8.1 — NASA suggest partial** — già esiste e funzionante
- [x] **Task 7.3 — suggestNome caching + debounce** — Cache::remember(3600) + ordine invertito
- [x] **Task 7.2 — Authorization consistente** — DashboardController fixato ($this->authorize())
- [x] **Task 6.4 — SolarSystem stabilità** — già fixato con useMemo
- [x] **Task 6.1 — React.memo** — LightboxGalleria + Thumbnail
- [x] **Task 5.4 — Form partial unificato** — 5 _form.blade.php, 10 create/edit riscritti, ~860 righe eliminate
- [x] **Task 5.3 — Estrarre partials Blade** — back-link, search, flash, stat-card, show-actions, index-actions
- [x] **Task 5.2 — Hardcoded hex → CSS variables** — :root block con 13 variabili, 52 hex values sostituiti
- [x] **Task 5.1 — CSS component class** — .admin-input per form, 8 Blade views riscritti, 17 onfocus/onblur rimossi
- [x] **Task 4.1 — Cache dashboard + invalidazione** — Cache::forget su store/update/destroy
- [x] **Task 3.4 — framer-motion → CSS** — fade/slide/pulse/twinkle + SolarSystem clickable/immagini realistiche
- [x] **Task 3.2 — Inline styles → Tailwind classes** — ~68 oggetti style in 15 file
- [x] **Task 14.1** — Rimossi import morti React, dipendenze inutilizzate, malposizionate
- [x] **Task 14** — 10 bug critici fixati
- [x] **Task 12.4** — Quick wins: max per_page, ordinamento relazioni, .catch, nasa_id in resource, indexes
- [x] **Task 12.3** — FormRequest per validazione store/update CorpoCeleste
- [x] **Task 12.2** — Rimossa dipendenza Inertia
- [x] **Task 12.1** — Auth pages: Inertia→Blade puro
- [x] **Task 12** — Authorization (Policy/Gates) ai controller admin
- [x] **Task 11** — Bugfix login Inertia→Blade, auth controller transizioni, NASA import dedup, galleria cleanup
- [x] **Task 10** — Bug critici: route(), nasa_id in fillable, categoria_id dinamico seeder
- [x] **Task 9** — Remote URLs, nome_it/nome_display, wordMap espansa, auto-suggest admin
- [x] **Task 8** — NASA Import multi-immagine, Service Layer, CLI fetch-nasa
- [x] **Task 7** — Bugfix Intervention Image v4, Force Import All Alpine.js
- [x] **Task 6** — Fix orbite, redirect route, profilo, documentazione
- [x] **Task 5** — React: Dettaglio, Lightbox, Missioni, Comparatore
- [x] **Task 4** — React: Homepage, Sistema solare animato, Lista
- [x] **Task 3** — API REST (10 endpoint)
- [x] **Task 2** — CRUD Admin (Categorie, Corpi Celesti, Missioni, Curiosità, Galleria)
- [x] **Task 1** — Database e Modelli (6 migrations, 5 models, seeder)
- [x] **Task 0** — Setup Laravel + Breeze + React + documentazione

## Note

- **Stato**: Piano ottimizzazione completato (Task 0-10.3). 235 test totali (173 PHPUnit + 62 Vitest). Prossimo step: debug generale post-ottimizzazione.
- Tasks spuntati (`[x]`) vengono spostati nella sezione **Fatto**
- Formato per aggiungere un nuovo task:
  ```
  - [ ] `[🖥️🎨💾🧪✨📝][🔴🟠🔵🟣⚪]` Descrizione — `file/principale/coinvolto`
  ```
  **Tag (oggetti — ambito)**: `[🖥️backend]` `[🎨frontend]` `[💾database]` `[🧪test]` `[✨feature]` `[📝docs]`
  **Priorità (cerchi — urgenza)**: 🔴P0 bloccante · 🟠P1 utente · 🔵P2 manutenzione · 🟣P3 accessibilità · ⚪P4 futuro
