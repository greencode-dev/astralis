# Todo

*Ultimo aggiornamento: 2026-07-11*

## Post-commit 2026-07-11 — Task 3.4 completato

## Fatto

- [x] **Task 3.4 — framer-motion→CSS + SolarSystem**: Rimossi motion.div da 4 file guest (HomePage, CorpiLista, CorpoDettaglio, Comparatore), CSS keyframes fadeUp/slideLeft/slideRight/fadeScale, useInView hook per scroll animations, stelle twinkle + sun pulse CSS, pianeti cliccabili con Link, immagini realistiche NASA con fallback colore
- [x] **Task 4.1 — Cache invalidazione**: Cache::forget('admin.dashboard') + Cache::forget('api.dashboard.stats') in store/update/destroy di tutti e 5 i controller CRUD

- [x] **Fase 1 — React P0 critico**: AbortController + useFetch hook + ErrorBoundary globale + guard immagini rotte + axios interceptors retry
- [x] **Fase 2 — Laravel P0 critico**: Job queue ImportNasaImage + chunk(50) + rate limiting API (throttle:60,1) + caching searchNasa()

- [x] **P2 Admin CRUD test** — 4 nuovi file: CategoriaCrudTest (14), MissioneCrudTest (13), CuriositaCrudTest (10), GalleriaCrudTest (9) — 130 test totali
- [x] **P2 Categoria pagination** — `->paginate(20)` + `->withQueryString()` + `$categorie->links()`
- [x] **P2 Curiosita show** — Nuovo metodo `show()` + vista `show.blade.php` + route rimossa da `except`
- [x] **P2 Search/filter admin** — Search bar su Categoria, Missione (anche agenzia/stato), Curiosità, Galleria
- [x] **P3 SEO meta tags React** — `document.title` in 5 pagine guest (HomePage, CorpiLista, CorpoDettaglio, Comparatore, NotFound)
- [x] **P3 Error Boundary globale** — Class component `<ErrorBoundary>` + fallback UI dark in App.jsx
- [x] **Test P2** — NasaImageService unit test (26 test, 63 assertion) + bugfix query stripping, immagine_utente force skip
- [x] **Test P2** — API endpoint tests (8 file, 84 total test) — Http::fake, observer testing guard, response structure fixes
- [x] **Test P2** — Admin CRUD tests — fixed observer interference, all green
- [x] **Test P2** — React component tests (Vitest, 4 file, 27 test, CategoriaBadge, CorpoCard, Lightbox, SolarSystem)
- [x] **P4 Dashboard** — Admin dashboard con 3 grafici Chart.js (corpi/categoria, corpi/tipo, missioni/stato)
- [x] **Test P2** — API integration tests (Vitest, 5 file, 61 test, apiClient + 4 guest pages)
- [x] **Fase 14** — 10 bug critici fixati: 3 Blade @endif mancanti/annidati, formatDistance NaN guard, 404 route React, ownership check setImageFromGallery, N+1 MissioneController, migration stato lowercase, withoutVerifying condizionale, Orbit import duplicato
- [x] **Fase 14.1** — Rimossi import morti React (Image, Weight, Thermometer, Gauge, MapPin), dipendenze inutilizzate (laravel/sanctum, barryvdh/laravel-dompdf, @tailwindcss/vite, @headlessui/react), malposizionate (react/react-dom in devDependencies, @vitejs/plugin-react in dependencies)
- [x] **HasFactory** — Aggiunto trait a tutti i 5 modelli + factories esistenti
- [x] **Wave 4** — Frontend P2: stili inline → Tailwind classi admin
- [x] **Wave 3** — Frontend P2: onMouseEnter/onMouseLeave → CSS :hover
- [x] **Wave 2** — Frontend P3: aria-label, role="img" su pulsanti e fallback immagini
- [x] **Wave 1** — Backend P2: WordMapService, simili ordinati
- [x] **Fase 12.4** — Quick wins: max per_page, ordinamento relazioni, .catch, nasa_id in resource, indexes
- [x] **Fase 12.3** — FormRequest per validazione store/update CorpoCeleste
- [x] **Fase 12.2** — Rimossa dipendenza Inertia (middleware, JSX, composer/npm)
- [x] **Fase 12.1** — Auth pages: Inertia→Blade puro (GuestLayout/AppLayout components)
- [x] **Fase 12** — Authorization (Policy/Gates) ai controller admin
- [x] **Fase 11** — Bugfix login Inertia→Blade, auth controller transizioni, NASA import dedup, galleria cleanup e ordinamento
- [x] **Fase 10** — Bug critici: route() senza virgolette, nasa_id in fillable, categoria_id dinamico seeder
- [x] **Fase 9** — Remote URLs, nome_it/nome_display, wordMap espansa, auto-suggest admin
- [x] **Fase 8** — NASA Import multi-immagine, Service Layer, CLI fetch-nasa
- [x] **Fase 7** — Bugfix Intervention Image v4, Force Import All Alpine.js
- [x] **Fase 6** — Fix orbite, redirect route, profilo, documentazione
- [x] **Fase 5** — React: Dettaglio, Lightbox, Missioni, Comparatore
- [x] **Fase 4** — React: Homepage, Sistema solare animato, Lista
- [x] **Fase 3** — API REST (10 endpoint)
- [x] **Fase 2** — CRUD Admin (Categorie, Corpi Celesti, Missioni, Curiosità, Galleria)
- [x] **Fase 1** — Database e Modelli (6 migrations, 5 models, seeder)
- [x] **Fase 0** — Setup Laravel + Breeze + React + documentazione
- [x] UI/UX: tema scuro auth pages, link Register, paginazione admin, badge in_evidenza

## Da Fare (Piano di Ottimizzazione)

### Fase 3 — Alto React Frontend (P1)
- [x] 3.2 Inline styles → Tailwind classes (~5-6 convertibili su 15) ✅ verificato
- [x] 3.4 framer-motion → CSS transitions + SolarSystem clickable/immagini (~4h) ✅
- [x] 3.6 onFocus/onBlur → CSS :focus-within ✅
- _3.1 React.lazy, 3.5 Dedup categoryIcons: già fatti_ ✅

### Fase 4 — Alto Backend Laravel (P1)
- [x] 4.1 Cache dashboard + invalidazione su create/update/delete ✅
- _4.2-4.6: già fatti_ ✅

### Fase 5 — Alto Admin Blade (P1)
- [x] 5.1 CSS component class .admin-input per form — 8 auth/profile Blade views riscritti, 17 onfocus/onblur rimossi, admin-input-danger variante, buttons admin-btn-*, hex→Tailwind utilities ✅
- [x] 5.2 Hardcoded hex → CSS variables — :root block in app.css con 13 variabili, 52 hex values sostituiti in 10 file Blade, onmouseover/onmouseout rimossi da verify-email ✅
- [x] 5.3 Estrarre partials Blade (actions, stat-cards) — back-link wired 14 file, search wired 5 file, flash enhanced + wired nasa-import, stat-card creato (11 include), show-actions creato (4 include), index-actions creato (5 include), missioni button styles fix ✅
- [x] 5.4 Form partial unificato per create/edit — 5 _form.blade.php (curiosita, categorie, missioni, galleria, corpi-celesti), 10 create/edit riscritti, ~860 righe eliminate ✅
- _5.5 @section fix: già fatto_ ✅

### Fase 6 — Medio React Frontend (P2)
- [ ] 6.1 React.memo (LightboxGalleria)
- [ ] 6.4 SolarSystem stabilità (stelle non saltano al mount)
- _6.2 Debounce, 6.3 useMemo Lightbox: già fatti_ ✅

### Fase 7 — Medio Backend Laravel (P2)
- [ ] 7.2 DashboardController → $this->authorize() consistente
- [ ] 7.3 suggestNome: invertire ordine chiamate (inglese prima), debounce frontend
- _7.1, 7.4, 7.5: già fatti_ ✅

### Fase 8 — Medio Admin Blade (P2)
- [ ] 8.1 Estrarre HTML NASA suggest duplicato in create/edit
- [ ] 8.3 CDN fallback locale Alpine.js + Chart.js
- _8.2, 8.4: già fatti_ ✅

### Fase 9 — Test (P1-P3)
- [ ] 9.1 AdminTestCase refactoring (5 CRUD test → estendono classe base)
- [ ] 9.2 Data provider authorization tests
- [ ] 9.3 Uniformare Http::fake() pattern
- [ ] 9.4 Frontend fixtures.js centralizzato
- [ ] 9.5 Factory foreign key fix (->for())
- [ ] 9.6 Copertura test mancante (7 route admin + 2 comandi + 3 API)
- [ ] 9.7 DashboardApiTest assertions complete

### Fase 10 — UI/UX & Writing Review (P4)
- [ ] 10.1 Web Design Guidelines review
- [ ] 10.2 Writing Guidelines review
- [ ] 10.3 Frontend Design review

---

## Note

- **Stato**: Fase 1-2 (P0) + Task 3.2/3.4 (P1 React) completati. Prossime: Task 3.6, poi Fase 4-5. 190 test (103 PHPUnit + 87 Vitest).
- Tasks spuntati (`[x]`) vengono spostati nella sezione **Fatto**
- Formato per aggiungere un nuovo task:
  ```
  - [ ] `[🖥️🎨💾🧪✨📝][🔴🟠🔵🟣⚪Px]` Descrizione — `file/principale/coinvolto`
  ```
  **Tag (oggetti — ambito)**: `[🖥️backend]` `[🎨frontend]` `[💾database]` `[🧪test]` `[✨feature]` `[📝docs]`
  **Priorità (cerchi — urgenza)**: 🔴P0 bloccante · 🟠P1 utente · 🔵P2 manutenzione · 🟣P3 accessibilità · ⚪P4 futuro
