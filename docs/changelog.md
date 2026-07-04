# Changelog

## Fase 0 — Setup

### 0.1 — 02/07/2026 — `6df5099` — feat: setup iniziale Laravel + Breeze + React + documentazione
- Creazione progetto Laravel v13.18.0
- Installazione Breeze con React stack
- Configurazione .env (MySQL :3307, DB: astralis)
- Generazione APP_KEY

## Fase 1 — Database e Modelli

### 1.0 — 03/07/2026 — `0a57208` — feat: database e modelli con seeders
- Installati pacchetti: spatie/laravel-sluggable, intervention/image, barryvdh/laravel-dompdf
- Creazione database MySQL `astralis`
- 6 migrations: categorie, corpi_celesti, galleria_corpi, missioni, curiosita, corpo_celeste_missione
- 5 Eloquent Models con relazioni e sluggable
- 7 seeders con dati reali (8 categorie, 18 corpi celesti, 10 missioni, 16 galleria, 18 curiosità, 17 relazioni pivot)
- Utente admin: admin@astralis.it / password

## Fase 2 — Backoffice Blade CRUD

### 2.1 — 03/07/2026 — `070da55` — feat: admin backoffice layout, sidebar navigation e dashboard
- Admin layout Blade con sidebar navigazione (tema scuro palette `#0A0A1A`, `#111128`, `#22D3EE`)
- Dashboard admin con statistiche (conteggio entità) e tabella ultimi corpi celesti
- Route `/admin` protette da auth Breeze
- Estensione tailwind.config.js con colori admin
- Fix: aggiunto `resources/js/bootstrap.js` mancante per Vite build

### 2.2 — 03/07/2026 — `758be4c` — feat: CRUD categorie backoffice
- CRUD completo Categorie (index, create, store, show, edit, update, destroy)
- Protezione eliminazione: se ci sono corpi celesti associati, bloccata con messaggio errore
- Color picker con palette rapida 10 colori nei form create/edit
- Vista show con conteggio corpi associati
- Fix: aggiunto `resources/js/bootstrap.js` mancante (bloccava build Vite)

### 2.3 — 03/07/2026 — `18a6b20` — feat: CRUD corpi celesti backoffice
- CRUD completo Corpi Celesti (index, create, store, show, edit, update, destroy)

### 2.4 — 03/07/2026 — `6d86177` — feat: CRUD missioni backoffice
- CRUD completo Missioni (index, create, store, show, edit, update, destroy)
- Upload logo con Intervention Image (resize 300px, max 1MB, supporto SVG)
- Badge stato colorato: Completata (verde), In corso (ciano), Pianificata (giallo)
- Vista show con dettagli missione + tabella corpi celesti esplorati
- Storage dedicato `storage/app/public/missioni/`

### 2.5 — 03/07/2026 — `2f8a67e` — feat: CRUD curiosità backoffice
- CRUD completo Curiosità (index, create, store, edit, update, destroy — senza show)
- Route resource con parametro `{curiositum}` (singolare latino di "curiosita")
- Vista index con tabella titolo, corpo celeste (link), descrizione, fonte
- Vista create con select corpo celeste, titolo, textarea descrizione, fonte opzionale

### 2.6 — 03/07/2026 — `99615bb` — feat: CRUD galleria backoffice
- CRUD completo Galleria (index, create, store, edit, update, destroy — senza show)
- Upload immagini con Intervention Image (resize 1200px, storage `public/galleria/`)
- Vista index a griglia con card thumbnail, didascalia, corpo celeste, crediti, ordine
- Route resource con parametro `{galleriaCorpo}`
- **Fase 2 completata** (tutti e 6 i CRUD)

## Fase 3 — API REST

### 3.0 — 03/07/2026 — feat: API REST (10 endpoint JSON)
- 5 API Resource classes: CorpoCelesteResource, CategoriaResource, MissioneResource, CuriositaResource, GalleriaCorpoResource
- 6 API Controllers: CorpoCeleste, Categoria, Missione, Curiosita, Galleria, Dashboard
- 10 endpoint JSON in `routes/api.php`
- Filtri su GET `/api/corpi-celesti`: categoria (slug), tipo, search, in_evidenza, per_page
- Filtri su GET `/api/missioni`: agenzia, stato
- Route model binding con slug su show endpoints
- Bootstrap app.php configurato per caricare api.php

## Fase 4 — React Guest Frontend

### 4.0 — 04/07/2026 — feat: React SPA guest (homepage + lista corpi celesti)
- Architettura: React standalone (separato da Inertia), comunicazione via API REST
- Entry point Vite separato `resources/js/guest/main.jsx`
- Layout guest con navbar + footer tema spazio (palette `#0A0A1A`)
- Homepage animata: hero + sistema solare (framer-motion) + corpi in evidenza
- Pagina lista corpi celesti con griglia, filtri (categoria, tipo, ricerca), paginazione
- Dipendenze: framer-motion, react-router-dom, lucide-react, axios
- Route `/` guest sostituisce Welcome Inertia
