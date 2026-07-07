# Todo

## Completate

- [x] Fase 11: Bugfix — Login Inertia→Blade redirect, Auth controller transizioni, NASA import deduplicazione, galleria cleanup, ordinamento inline
- [x] Fase 10: Bug critici — route() senza virgolette, nasa_id in fillable, categoria_id dinamico nel seeder
- [x] Fase 9: Remote URLs, nome_it/nome_display, wordMap espansa, auto-suggest admin
- [x] Fase 8: NASA Import multi-immagine in galleria, Service Layer, CLI fetch-nasa
- [x] Fase 7: Bugfix Intervention Image v4, Force Import All con Alpine.js
- [x] Fase 6: Fix orbite, redirect route, profilo, documentazione
- [x] Fase 5: React — Dettaglio, Lightbox, Missioni, Comparatore
- [x] Fase 4: React — Homepage + Sistema solare animato + Lista
- [x] Fase 3: API REST (10 endpoint)
- [x] Fase 2: CRUD Admin (Categorie, Corpi Celesti, Missioni, Curiosità, Galleria)
- [x] Fase 1: Database e Modelli (6 migrations, 5 models, seeder)
- [x] Fase 0: Setup iniziale Laravel + Breeze + React + documentazione

## In corso

_Nessuna attività in corso._

## Future

### Priorità Alta

**UI/UX**
- [x] Adattare pagine login e register allo stile scuro dell'app (GuestLayout, auth pages)
- [x] Controllare e uniformare tutte le pagine dell'app allo stile del tema scuro
- [x] Aggiungere link "Register" su Login page per chi non ha account

**Sistema Solare**
- [x] Ridurre la velocità di rotazione dei pianeti
- [x] Sistemare velocità orbitali: pianeti più lontani devono ruotare più lentamente di quelli vicini

**Backend**
- [x] Aggiungere paginazione (`->paginate(20)`) in admin index (corpi-celesti, galleria, missioni, curiosità)
- [ ] Aggiungere rate limiting (`throttle`) su API pubbliche
- [ ] Aggiungere authorization (Policy/Gates) ai controller admin

### Priorità Media

**UI/UX**
- [ ] Spostare gli stili inline in file CSS/Tailwind classi per alleggerire e ottimizzare
- [ ] Sostituire `onMouseEnter`/`onMouseLeave` hover con CSS `:hover`
- [ ] Aggiungere error handling utente nel frontend (sostituire `.catch(() => {})`)
- [ ] Aggiungere `aria-label` a pulsanti paginazione, nav, SVG
- [ ] Aggiungere `role="img"`/`aria-label` a icone fallback immagini

**Backend / API**
- [ ] Aggiungere FormRequest per validazione in store/update CorpoCeleste
- [ ] Aggiungere cast decimal/float a campi scientifici (massa_kg, distanza_km, ecc.)
- [ ] Aggiungere ordinamento default a relazioni `galleria()` e `curiosita()`
- [ ] Rimuovere `inRandomOrder()` in `simili()` — alternativa performante
- [ ] Aggiungere rate limiting su route NASA import
- [ ] Aggiungere massimo a `per_page` (es. max 100)
- [ ] Esporre `nasa_id` in CorpoCelesteResource

**Database**
- [ ] Aggiungere missing indexes: `tipo`, `in_evidenza`, `nome` (FULLTEXT) su corpi_celesti
- [ ] Aggiungere index su `galleria_corpi.ordine`

**Testing**
- [ ] Test backend: test unitari per NasaImageService (search, fallback, metadata)
- [ ] Test backend: test HTTP per API endpoints (list, filter, dettaglio, simili)
- [ ] Test backend: test CRUD admin CorpoCeleste (store, update, validation)

### Priorità Bassa

**Sistema Solare**
- [ ] Valutare fattibilità trasformazione orbita 2D → 3D (react-three-fiber / prospettiva CSS)

**Backend / API**
- [ ] Estrarre `$wordMap` in servizio dedicato

**Testing**
- [ ] Test frontend: test componenti React con Vitest (SolarSystem, CorpoCard, Lightbox)
- [ ] Test frontend: test integrazione API (apiClient, pagine guest)
- [ ] Test E2E: flusso login → admin → CRUD corpo celeste → NASA import

**Future Features**
- [ ] Sistema di rating per corpi celesti
- [ ] Dashboard admin con grafici (Chart.js/Recharts)
- [ ] Multi-lingua (IT/EN)
- [ ] Dark/light mode toggle
- [ ] Tema notte con stelle cadenti CSS
- [ ] Notifiche email per nuove missioni
