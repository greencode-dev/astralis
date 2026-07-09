# Todo

*Ultimo aggiornamento: 2026-07-09*

## Pre-commit 2026-07-09 — 10 bug critici fixati

## Fatto

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

## Da Fare

### 🔴 P0 — Bloccante
_Nessun task bloccante. Il progetto non ha bug critici o blocchi noti._ 🟢

### 🟠 P1 — Utente
_Nessun task utente in sospeso. Fasce 12.3-12.4 hanno coperto questa fascia._ 🟢

### 🔵 P2 — Manutenzione (refactoring, test, performance)

_Tutti i task P2 completati. Admin CRUD test completi (4 file, 47 test), Categoria pagination, Curiosità show, search/filter admin._ 🟢

### 🟣 P3 — Accessibilità / Robustezza

_Tutti i task P3 completati. SEO meta tags React (5 pagine), Error Boundary globale._ 🟢

### ⚪ P4 — Futuro (nice-to-have)

_Nessun task P4 in sospeso. Tutti completati._ 🟢

---

## Note

- **Stato**: Tutti i task completati. Progetto in manutenzione. 130 test PHPUnit + 88 test Vitest.
- Tasks spuntati (`[x]`) vengono spostati nella sezione **Fatto**
- Formato per aggiungere un nuovo task:
  ```
  - [ ] `[🖥️🎨💾🧪✨📝][🔴🟠🔵🟣⚪Px]` Descrizione — `file/principale/coinvolto`
  ```
  **Tag (oggetti — ambito)**: `[🖥️backend]` `[🎨frontend]` `[💾database]` `[🧪test]` `[✨feature]` `[📝docs]`
  **Priorità (cerchi — urgenza)**: 🔴P0 bloccante · 🟠P1 utente · 🔵P2 manutenzione · 🟣P3 accessibilità · ⚪P4 futuro
