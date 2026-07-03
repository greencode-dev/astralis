# Astralis — Documentazione di Progetto

## Panoramica
Astralis è un catalogo web di corpi celesti (pianeti, stelle, galassie, nebulose, lune, comete, asteroidi) che permette di esplorare l'universo attraverso una interfaccia moderna e immersiva. Il progetto include un backoffice amministrativo per la gestione dei contenuti e un frontend pubblico per i visitatori.

## Tech Stack
| Livello | Tecnologia |
|---|---|
| Backend | Laravel 13, PHP 8.x |
| Auth | Laravel Breeze |
| Database | MySQL |
| Frontend | React 19, Vite |
| CSS | Tailwind CSS |
| Animazioni | framer-motion |
| Icone | Lucide React |
| Lightbox | yet-another-react-lightbox |
| Upload | Intervention Image |
| Slug | spatie/laravel-sluggable |
| PDF | barryvdh/laravel-dompdf |

## Architettura
```
astralis/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/       ← Controller CRUD per backoffice (Blade)
│   │   └── Api/         ← Controller API REST (JSON)
│   ├── Models/          ← Eloquent Models (5 entità)
│   └── ...
├── database/
│   └── migrations/      ← 6 file di migrazione
├── resources/
│   ├── views/           ← Blade templates (backoffice admin)
│   └── js/              ← React (components, pages, API)
├── routes/
│   ├── web.php          ← Route admin (protette da Breeze)
│   └── api.php          ← Route API pubbliche (JSON)
├── docs/                ← Documentazione di progetto
└── .ai/                 ← Skill AI (gitignorato)
```

## Entità e Relazioni

### Struttura Database
```
CATEGORIA ──1:N── CORPO_CELESTE ──1:N── GALLERIA_CORPO
                      │                       (immagini multiple)
                      │
                      ├──1:N── CURIOSITA
                      │
                      └──N:N── MISSIONE
                               (pivot: tipo_esplorazione, anno_arrivo)
```

### Dettaglio Entità

| Entità | Campi principali | CRUD | Relazioni |
|---|---|---|---|
| **Categoria** | nome, slug, icona, descrizione, colore | ✅ | 1-N con CorpoCeleste |
| **CorpoCeleste** | nome, slug, categoria_id, immagine, descrizione, tipo, massa_kg, distanza_km, diametro_km, gravita, temperatura, periodo_orbitale, scopritore, anno_scoperta, in_evidenza | ✅ | N-1 Categoria, 1-N Galleria, 1-N Curiosità, N-N Missioni |
| **GalleriaCorpo** | corpo_celeste_id, percorso, didascalia, crediti, ordine | ✅ | N-1 CorpoCeleste |
| **Missione** | nome, slug, logo, agenzia, data_lancio, durata_giorni, stato, descrizione, sito_web | ✅ | N-N CorpiCelesti |
| **Curiosità** | corpo_celeste_id, titolo, descrizione, fonte | ✅ | N-1 CorpoCeleste |

## API REST (Endpoint)
```
GET    /api/corpi-celesti              — Lista (filtri: categoria, tipo, search, in_evidenza)
GET    /api/corpi-celesti/{slug}       — Dettaglio con relazioni
GET    /api/categorie                  — Lista categorie con conteggio
GET    /api/missioni                   — Lista missioni (filtri: agenzia, stato)
GET    /api/missioni/{slug}            — Dettaglio missione
GET    /api/corpi-celesti/{id}/simili  — Suggerimenti (stessa categoria)
GET    /api/dashboard/stats            — Stats per homepage
```

## Wow Factor
1. **Sistema solare animato** (Homepage React) — pianeti che orbitano intorno al Sole con framer-motion
2. **Lightbox gallery** — immagini NASA a schermo intero con swipe mobile
3. **Comparatore pianeti** — confronto affiancato di 2 corpi celesti (massa, diametro, temperatura, gravità)
4. **Timeline missioni** — linea del tempo orizzontale delle missioni spaziali con badge stato
5. **Badge categoria** — colori diversi per ogni tipo di corpo celeste

## Palette Colori
| Ruolo | Nome | Codice |
|---|---|---|
| Sfondo pagina | Vuoto Siderale | `#0A0A1A` |
| Card/Pannelli | Abisso Profondo | `#111128` |
| Hover/Sfondi sec. | Crepuscolo | `#1A1A3E` |
| Separatori | Corteccia | `#242450` |
| Testo principale | Stella Polare | `#F0F0FA` |
| Testo secondario | Fumo | `#B8B8D0` |
| Testo disabilitato | Polvere | `#7A7A9A` |
| CTA/Primario | Ciano Aurorale | `#22D3EE` |
| Highlight | Nebulosa | `#A855F7` |
| Accento/Urgenza | Arancio Solare | `#F97316` |
| Badge evidenza | Oro Stellare | `#FACC15` |

### Badge Categoria
| Categoria | Colore |
|---|---|
| Pianeta | `#22D3EE` (Ciano) |
| Stella | `#F97316` (Arancione) |
| Luna | `#94A3B8` (Grigio ardesia) |
| Galassia | `#A855F7` (Viola) |
| Nebulosa | `#F472B6` (Rosa) |
| Asteroide | `#78716C` (Marrone) |
| Cometa | `#22C55E` (Verde) |
| Pianeta Nano | `#6B7280` (Grigio) |

### Backoffice Admin

L'admin è raggiungibile su `/admin` dopo il login. Utilizza layout Blade con tema scuro e sidebar di navigazione.

**Struttura viste:**
```
resources/views/admin/
├── layouts/
│   └── app.blade.php           ← Master layout con sidebar + topbar
├── dashboard.blade.php         ← Dashboard stats
├── categorie/                  ← CRUD Categorie ✅
│   ├── index.blade.php         ← Lista con tabella
│   ├── create.blade.php        ← Form creazione
│   ├── edit.blade.php          ← Form modifica
│   └── show.blade.php          ← Dettaglio con corpi associati
├── corpi-celesti/              ← CRUD Corpi Celesti ✅
│   ├── index.blade.php         ← Lista con tabella + badge categoria
│   ├── create.blade.php        ← Form 13 campi + upload immagine
│   ├── edit.blade.php          ← Form modifica con immagine preview
│   └── show.blade.php          ← Dettaglio con dati scientifici + galleria + curiosità + missioni
├── missioni/                   ← CRUD Missioni ✅
│   ├── index.blade.php         ← Lista con badge stato + logo
│   ├── create.blade.php        ← Form dati missione + upload logo
│   ├── edit.blade.php          ← Form modifica con logo preview
│   └── show.blade.php          ← Dettaglio con tabella corpi esplorati
├── curiosita/                  ← CRUD Curiosità (da fare)
└── galleria/                   ← CRUD Galleria (da fare)
```

**Controller admin:** `app/Http/Controllers/Admin/` — risorsa per ogni entità.

**CRUD Categorie** — 7 route resource (`GET|POST /admin/categorie`, `GET|PUT /admin/categorie/{id}`, `DELETE /admin/categorie/{id}`). Protezione cancellazione: se la categoria ha corpi celesti associati, viene mostrato errore. Form con color picker + palette rapida 10 colori predefiniti.

**CRUD Corpi Celesti** — 7 route resource (`/admin/corpi-celesti`). Upload immagini con Intervention Image (resize 800px, storage `public/corpi-celesti/`). Form con 13 campi, select categoria, checkbox evidenza. Vista show completa con 8 card metriche scientifiche + sezioni galleria, curiosità, missioni.

**CRUD Missioni** — 7 route resource (`/admin/missioni`). Upload logo con Intervention Image (resize 300px, supporto SVG). Stato con badge colorato (Completata/In corso/Pianificata). Vista show con tabella corpi celesti esplorati (dati pivot: tipo esplorazione, anno arrivo).

## Guida all'installazione
```bash
# Clona la repo
git clone https://github.com/tuo-username/astralis.git
cd astralis

# Installa dipendenze PHP
composer install

# Installa dipendenze Node
npm install

# Configura ambiente
cp .env.example .env
php artisan key:generate

# Crea database MySQL e configura .env
# DB_DATABASE=astralis
# DB_PORT=3307

# Migrazioni e seed
php artisan migrate --seed

# Link storage per upload
php artisan storage:link

# Avvia backend
php artisan serve

# Avvia frontend (in un altro terminale)
npm run dev
```

## Credenziali Admin (demo)
- Email: admin@astralis.it
- Password: password
