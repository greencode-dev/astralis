# Todo

*Ultimo aggiornamento: 2026-07-08*

## Fatto

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

- [ ] `[🧪test][🔵P2]` Test unitari NasaImageService (search, fallback, metadata) — `tests/Unit/`
- [ ] `[🧪test][🔵P2]` Test HTTP API endpoints (list, filter, dettaglio, simili) — `tests/Feature/Api/`
- [ ] `[🧪test][🔵P2]` Test CRUD admin CorpoCeleste (store, update, validation) — `tests/Feature/Admin/`
- [ ] `[🧪test][🔵P2]` Test componenti React (SolarSystem, CorpoCard, Lightbox) — Vitest
- [ ] `[🧪test][🔵P2]` Test integrazione API (apiClient, guest pages)
- [ ] `[🧪test][🔵P2]` Test E2E: login → admin → CRUD → NASA import
- [ ] `[🎨frontend][🔵P2]` Sostituire onMouseEnter/onMouseLeave con CSS `:hover` — tutti i blade e JSX
- [ ] `[🎨frontend][🔵P2]` Spostare stili inline in CSS/Tailwind classi — `resources/views/admin/*.blade.php`

### 🟣 P3 — Accessibilità
_Nessun task di accessibilità in sospeso. Wave 2 ha coperto questa fascia._ 🟢

### ⚪ P4 — Futuro (nice-to-have)

- [ ] `[🖥️backend][⚪P4]` Cast decimal/float a campi scientifici (massa_kg, distanza_km, etc.) — `app/Models/CorpoCeleste.php`
- [ ] `[🖥️backend][⚪P4]` Rate limiting (`throttle`) su API pubbliche — `routes/api.php`
- [ ] `[🎨frontend][⚪P4]` Valutare orbita 2D → 3D (react-three-fiber / prospettiva CSS) — `resources/js/guest/components/SolarSystem.jsx`
- [ ] `[✨feature][⚪P4]` Sistema di rating per corpi celesti
- [ ] `[✨feature][⚪P4]` Dashboard admin con grafici (Chart.js/Recharts)
- [ ] `[✨feature][⚪P4]` Multi-lingua (IT/EN)
- [ ] `[✨feature][⚪P4]` Dark/light mode toggle
- [ ] `[✨feature][⚪P4]` Notifiche email per nuove missioni

---

## Note

- **Prossimo task consigliato**: `[🎨frontend][🔵P2]` Sostituire onMouseEnter/onMouseLeave con CSS `:hover` — tutti i blade e JSX
- Tasks spuntati (`[x]`) vengono spostati nella sezione **Fatto**
- Formato per aggiungere un nuovo task:
  ```
  - [ ] `[🖥️🎨💾🧪✨📝][🔴🟠🔵🟣⚪Px]` Descrizione — `file/principale/coinvolto`
  ```
  **Tag (oggetti — ambito)**: `[🖥️backend]` `[🎨frontend]` `[💾database]` `[🧪test]` `[✨feature]` `[📝docs]`
  **Priorità (cerchi — urgenza)**: 🔴P0 bloccante · 🟠P1 utente · 🔵P2 manutenzione · 🟣P3 accessibilità · ⚪P4 futuro
