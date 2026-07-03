# Changelog

## Fase 0 — Setup

### 0.1 — 02/07/2026 — `6df5099`
- Creazione progetto Laravel v13.18.0
- Installazione Breeze con React stack
- Configurazione .env (MySQL :3307, DB: astralis)
- Generazione APP_KEY

## Fase 1 — Database e Modelli

### 1.0 — 03/07/2026 — `0a57208`
- Installati pacchetti: spatie/laravel-sluggable, intervention/image, barryvdh/laravel-dompdf
- Creazione database MySQL `astralis`
- 6 migrations: categorie, corpi_celesti, galleria_corpi, missioni, curiosita, corpo_celeste_missione
- 5 Eloquent Models con relazioni e sluggable
- 7 seeders con dati reali (8 categorie, 18 corpi celesti, 10 missioni, 16 galleria, 18 curiosità, 17 relazioni pivot)
- Utente admin: admin@astralis.it / password

## Fase 2 — Backoffice Blade CRUD

### 2.1 — 03/07/2026 — `070da55`
- Admin layout Blade con sidebar navigazione (tema scuro palette `#0A0A1A`, `#111128`, `#22D3EE`)
- Dashboard admin con statistiche (conteggio entità) e tabella ultimi corpi celesti
- Route `/admin` protette da auth Breeze
- Estensione tailwind.config.js con colori admin
- Fix: aggiunto `resources/js/bootstrap.js` mancante per Vite build

### 2.2 — 03/07/2026 — `758be4c`
- CRUD completo Categorie (index, create, store, show, edit, update, destroy)
- Protezione eliminazione: se ci sono corpi celesti associati, bloccata con messaggio errore
- Color picker con palette rapida 10 colori nei form create/edit
- Vista show con conteggio corpi associati
- Fix: aggiunto `resources/js/bootstrap.js` mancante (bloccava build Vite)

### 2.3 — 03/07/2026 — `18a6b20`
- CRUD completo Corpi Celesti (index, create, store, show, edit, update, destroy)
- Upload immagini con Intervention Image (resize 800px, max 2MB)
- Form con 13 campi: nome, categoria (select), tipo, immagine (file), massa, distanza, diametro, gravità, temperatura, periodo orbitale, scopritore, anno, descrizione, in evidenza
- Vista show dettagliata con 8 card dati scientifici + galleria + curiosità + missioni
- Storage dedicato `storage/app/public/corpi-celesti/`
- Route resource con parametro custom `corpoCeleste`

