# Todo

*Ultimo aggiornamento: 2026-07-07*

## Fatto

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

### Alta

- [ ] `[backend]` Rate limiting (`throttle`) su API pubbliche — `routes/api.php`
- [ ] `[backend]` Aggiungere FormRequest per validazione store/update CorpoCeleste — `app/Http/Requests/`
- [ ] `[backend]` Rimuovere dipendenza Inertia (se non più usata) — `composer.json`

### Media

- [ ] `[frontend]` Spostare stili inline in CSS/Tailwind classi — `resources/views/admin/*.blade.php`
- [ ] `[frontend]` Sostituire onMouseEnter/onMouseLeave con CSS `:hover` — tutti i blade e JSX
- [ ] `[frontend]` Error handling utente nel frontend (sostituire `.catch(() => {})`) — `resources/js/**/*.jsx`
- [ ] `[frontend]` Aggiungere `aria-label` a pulsanti paginazione, nav, SVG
- [ ] `[frontend]` Aggiungere `role="img"` / `aria-label` a icone fallback immagini
- [ ] `[backend]` Cast decimal/float a campi scientifici (massa_kg, distanza_km, etc.) — `app/Models/CorpoCeleste.php`
- [ ] `[backend]` Ordinamento default a relazioni `galleria()` e `curiosita()` — `app/Models/CorpoCeleste.php`
- [ ] `[backend]` Rimuovere `inRandomOrder()` in `simili()` — alternativa performante — `app/Models/CorpoCeleste.php`
- [ ] `[backend]` Aggiungere massimo a `per_page` (es. max 100) — `app/Http/Controllers/Api/`
- [ ] `[backend]` Esporre `nasa_id` in CorpoCelesteResource — `app/Http/Resources/CorpoCelesteResource.php`
- [ ] `[database]` Aggiungere missing indexes: `tipo`, `in_evidenza`, `nome` (FULLTEXT) — migration
- [ ] `[database]` Index su `galleria_corpi.ordine` — migration
- [ ] `[test]` Test unitari NasaImageService (search, fallback, metadata) — `tests/Unit/`
- [ ] `[test]` Test HTTP API endpoints (list, filter, dettaglio, simili) — `tests/Feature/Api/`
- [ ] `[test]` Test CRUD admin CorpoCeleste (store, update, validation) — `tests/Feature/Admin/`

### Bassa

- [ ] `[frontend]` Valutare orbita 2D → 3D (react-three-fiber / prospettiva CSS) — `resources/js/guest/components/SolarSystem.jsx`
- [ ] `[backend]` Estrarre `$wordMap` in servizio dedicato — `app/Services/WordMapService.php`
- [ ] `[test]` Test componenti React (SolarSystem, CorpoCard, Lightbox) — Vitest
- [ ] `[test]` Test integrazione API (apiClient, guest pages)
- [ ] `[test]` Test E2E: login → admin → CRUD → NASA import
- [ ] `[feature]` Sistema di rating per corpi celesti
- [ ] `[feature]` Dashboard admin con grafici (Chart.js/Recharts)
- [ ] `[feature]` Multi-lingua (IT/EN)
- [ ] `[feature]` Dark/light mode toggle
- [ ] `[feature]` Notifiche email per nuove missioni

---

## Note

- **Prossimo task consigliato**: il primo della sezione Alta
- Tasks spuntati (`[x]`) vengono spostati nella sezione **Fatto**
- Formato per aggiungere un nuovo task:
  ```
  - [ ] `[tag]` Descrizione — `file/principale/coinvolto`
  ```
  Tag disponibili: `backend`, `frontend`, `database`, `test`, `feature`
