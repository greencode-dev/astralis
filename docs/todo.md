# Todo

## Completate

- [x] Fase 0: Setup iniziale Laravel + Breeze + React + documentazione
- [x] Fase 1: Database e Modelli (6 migrations, 5 models, seeder con dati reali)
- [x] Fase 2.1: Admin layout e navigazione (sidebar, master layout, dashboard)
- [x] Fase 2.2: CRUD Categorie
- [x] Fase 2.3: CRUD Corpi Celesti
- [x] Fase 2.4: CRUD Missioni
- [x] Fase 2.5: CRUD Curiosità
- [x] Fase 2.6: CRUD Galleria
- [x] Fase 3: API REST (10 endpoint)
- [x] Fase 4: React — Homepage + Sistema solare animato + Lista
- [x] Fase 5: React — Dettaglio, Lightbox, Missioni, Comparatore
- [x] Fase 6: Fix orbite sistema solare, NASA Import, redirect route, profilo, documentazione
- [x] Fase 7: Bugfix Intervention Image v4, Force Import All con Alpine.js, documentazione
- [x] Fase 8: NASA Import multi-immagine in galleria, Service Layer, CLI `astralis:fetch-nasa`, metadati NASA
- [x] Fase 9: Remote URLs (nessun download), nome_it/nome_display, wordMap espansa, apostrophe fallback, auto-suggest admin, documentazione

## In corso

_Nessuna attività in corso._

## Backlog

### Fase 10 — UI/UX
- [ ] Adattare pagine login e register allo stile scuro dell'app (GuestLayout, auth pages)
- [ ] Controllare e uniformare tutte le pagine dell'app allo stile del tema scuro
- [ ] Spostare gli stili inline in file CSS/Tailwind classi per alleggerire e ottimizzare
- [ ] Sostituire `onMouseEnter`/`onMouseLeave` hover con CSS `:hover`
- [ ] Aggiungere error handling utente nel frontend (sostituire `.catch(() => {})`)
- [ ] Aggiungere `aria-label` a pulsanti paginazione, nav, SVG
- [ ] Aggiungere `role="img"`/`aria-label` a icone fallback immagini
- [ ] Dark/light mode toggle
- [ ] Tema notte con stelle cadenti CSS

### Fase 10 — Sistema Solare
- [ ] Ridurre la velocità di rotazione dei pianeti
- [ ] Sistemare velocità orbitali: pianeti più lontani devono ruotare più lentamente di quelli vicini
- [ ] Valutare fattibilità trasformazione orbita 2D → 3D (react-three-fiber / prospettiva CSS)

### Fase 10 — Bugs Critici
- [ ] **CRITICO**: `edit.blade.php:224` — `route()` senza virgolette, errore PHP fatale
- [ ] `nasa_id` mancante da `$fillable` in CorpoCeleste — import NASA non salva l'ID
- [ ] `categoria_id` hardcoded (1-8) nel seeder — fragile all'ordine dei seed

### Fase 10 — Backend / API
- [ ] Aggiungere FormRequest per validazione in store/update CorpoCeleste
- [ ] Aggiungere paginazione (`->paginate()`) in admin index corpi-celesti
- [ ] Aggiungere rate limiting (`throttle`) su API pubbliche
- [ ] Aggiungere rate limiting su route NASA import
- [ ] Aggiungere massimo a `per_page` (es. max 100)
- [ ] Aggiungere cast decimal/float a campi scientifici (massa_kg, distanza_km, ecc.)
- [ ] Aggiungere ordinamento default a relazioni `galleria()` e `curiosita()`
- [ ] Rimuovere `inRandomOrder()` in `simili()` — alternativa performante
- [ ] Aggiungere authorization (Policy/Gates) ai controller admin
- [ ] Estrarre `$wordMap` in servizio dedicato
- [ ] Esporre `nasa_id` in CorpoCelesteResource

### Fase 10 — Database
- [ ] Aggiungere missing indexes: `tipo`, `in_evidenza`, `nome` (FULLTEXT) su corpi_celesti
- [ ] Aggiungere index su `galleria_corpi.ordine`

### Fase 10 — Testing
- [ ] Test backend: test unitari per NasaImageService (search, fallback, metadata)
- [ ] Test backend: test HTTP per API endpoints (list, filter, dettaglio, simili)
- [ ] Test backend: test CRUD admin CorpoCeleste (store, update, validation)
- [ ] Test frontend: test componenti React con Vitest (SolarSystem, CorpoCard, Lightbox)
- [ ] Test frontend: test integrazione API (apiClient, pagine guest)
- [ ] Test E2E: flusso login → admin → CRUD corpo celeste → NASA import

### Future
- [ ] Sistema di rating per corpi celesti
- [ ] Dashboard admin con grafici (Chart.js/Recharts)
- [ ] Multi-lingua (IT/EN)
- [ ] Notifiche email per nuove missioni
