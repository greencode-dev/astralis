# Astralis — Documentazione di Progetto

## Panoramica

Astralis è un catalogo web di corpi celesti (pianeti, stelle, galassie, nebulose, lune, comete, asteroidi) che permette di esplorare l'universo attraverso una interfaccia moderna e immersiva. Il progetto include un backoffice amministrativo per la gestione dei contenuti e un frontend pubblico per i visitatori.

## Tech Stack

| Livello    | Tecnologia                 |
| ---------- | -------------------------- |
| Backend    | Laravel 13, PHP 8.x        |
| Auth       | Laravel Breeze             |
| Database   | MySQL                      |
| Frontend   | React 19, Vite             |
| CSS        | Tailwind CSS               |
| Animazioni | framer-motion              |
| Icone      | Lucide React               |
| Lightbox   | yet-another-react-lightbox |
| Upload     | Intervention Image         |
| Slug       | spatie/laravel-sluggable   |
| PDF        | barryvdh/laravel-dompdf    |
| Modal      | Alpine.js (CDN)            |

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
├── .ai/                 ← Skill AI (snapshot contestuale per assistente)
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

| Entità            | Campi principali                                                                                                                                                          | CRUD | Relazioni                                                |
| ----------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---- | -------------------------------------------------------- |
| **Categoria**     | nome, slug, icona, descrizione, colore                                                                                                                                    | ✅   | 1-N con CorpoCeleste                                     |
| **CorpoCeleste**  | nome, slug, categoria_id, immagine, descrizione, tipo, massa_kg, distanza_km, diametro_km, gravita, temperatura, periodo_orbitale, scopritore, anno_scoperta, in_evidenza | ✅   | N-1 Categoria, 1-N Galleria, 1-N Curiosità, N-N Missioni |
| **GalleriaCorpo** | corpo_celeste_id, percorso, didascalia, crediti, ordine                                                                                                                   | ✅   | N-1 CorpoCeleste                                         |
| **Missione**      | nome, slug, logo, agenzia, data_lancio, durata_giorni, stato, descrizione, sito_web                                                                                       | ✅   | N-N CorpiCelesti                                         |
| **Curiosità**     | corpo_celeste_id, titolo, descrizione, fonte                                                                                                                              | ✅   | N-1 CorpoCeleste                                         |

## API REST (Endpoint)

```
GET    /api/corpi-celesti              — Lista (filtri: categoria, tipo, search, in_evidenza, per_page)
GET    /api/corpi-celesti/{slug}       — Dettaglio con relazioni
GET    /api/categorie                  — Lista categorie con conteggio
GET    /api/categorie/{slug}           — Singola categoria con corpi celesti
GET    /api/missioni                   — Lista missioni (filtri: agenzia, stato)
GET    /api/missioni/{slug}            — Dettaglio missione
GET    /api/corpi-celesti/{id}/simili  — Suggerimenti (stessa categoria, max 4)
GET    /api/curiosita                  — Lista curiosità
GET    /api/galleria                   — Lista galleria (ordinata)
GET    /api/dashboard/stats            — Stats per homepage
```

## Wow Factor

1. **Sistema solare animato** (Homepage React) — pianeti che orbitano intorno al Sole con framer-motion, orbite matematiche con seno/coseno
2. **Lightbox gallery** — immagini NASA a schermo intero con swipe mobile
3. **Comparatore pianeti** — confronto affiancato di 2 corpi celesti (massa, diametro, temperatura, gravità)
4. **Timeline missioni** — linea del tempo orizzontale delle missioni spaziali con badge stato
5. **Badge categoria** — colori diversi per ogni tipo di corpo celeste
6. **NASA Import** — import immagini da NASA API direttamente dal backoffice

## Palette Colori

| Ruolo              | Nome            | Codice    |
| ------------------ | --------------- | --------- |
| Sfondo pagina      | Vuoto Siderale  | `#0A0A1A` |
| Card/Pannelli      | Abisso Profondo | `#111128` |
| Hover/Sfondi sec.  | Crepuscolo      | `#1A1A3E` |
| Separatori         | Corteccia       | `#242450` |
| Testo principale   | Stella Polare   | `#F0F0FA` |
| Testo secondario   | Fumo            | `#B8B8D0` |
| Testo disabilitato | Polvere         | `#7A7A9A` |
| CTA/Primario       | Ciano Aurorale  | `#22D3EE` |
| Highlight          | Nebulosa        | `#A855F7` |
| Accento/Urgenza    | Arancio Solare  | `#F97316` |
| Badge evidenza     | Oro Stellare    | `#FACC15` |

### Badge Categoria

| Categoria    | Colore                     |
| ------------ | -------------------------- |
| Pianeta      | `#22D3EE` (Ciano)          |
| Stella       | `#F97316` (Arancione)      |
| Luna         | `#94A3B8` (Grigio ardesia) |
| Galassia     | `#A855F7` (Viola)          |
| Nebulosa     | `#F472B6` (Rosa)           |
| Asteroide    | `#78716C` (Marrone)        |
| Cometa       | `#22C55E` (Verde)          |
| Pianeta Nano | `#6B7280` (Grigio)         |

### Frontend Guest (React SPA)

Il frontend guest è una React SPA standalone (senza Inertia) che comunica con il backend tramite API REST. Montata su `guest.blade.php`.

**Struttura app React:**

```
resources/js/guest/
├── main.jsx                    ← Entry point Vite
├── apiClient.js                ← Helper axios per chiamate API
├── App.jsx                     ← Router + layout wrapper (4 route)
├── components/
│   ├── Navbar.jsx              ← Navigazione guest (logo + links)
│   ├── Footer.jsx              ← Footer tema spazio
│   ├── SolarSystem.jsx         ← Sistema solare animato (framer-motion, orbite matematiche)
│   ├── CorpoCard.jsx           ← Card con fallback gradiente+icona
│   ├── CategoriaBadge.jsx      ← Badge colorato per categoria
│   ├── SearchBar.jsx           ← Barra ricerca
│   ├── LightboxGalleria.jsx    ← Lightbox immagini (yet-another-react-lightbox)
│   └── TimelineMissioni.jsx    ← Timeline orizzontale missioni
└── pages/
    ├── HomePage.jsx            ← Hero + sistema solare + in evidenza
    ├── CorpiLista.jsx          ← Griglia + filtri + paginazione
    ├── CorpoDettaglio.jsx      ← Dettaglio con metriche, galleria, curiosità, missioni, simili
    └── Comparatore.jsx         ← Confronto pianeti affiancato
```

**Route pubbliche:**

```
/                  → HomePage
/corpi-celesti     → CorpiLista (con filtri)
/corpi-celesti/:slug → CorpoDettaglio (metriche, galleria lightbox, curiosità, missioni, simili)
/confronta         → Comparatore (confronto pianeti, parametri ?primo=slug&secondo=slug)
```

**API utilizzate:**

- `GET /api/corpi-celesti?in_evidenza=1` — Corpi in evidenza (Homepage)
- `GET /api/corpi-celesti?categoria=...&tipo=...&search=...&page=N` — Lista filtrata
- `GET /api/categorie` — Lista categorie (filtri)
- `GET /api/corpi-celesti/{slug}` — Dettaglio con relazioni (galleria, curiosità, missioni)
- `GET /api/corpi-celesti/{id}/simili` — Corpi della stessa categoria
- `GET /api/corpi-celesti?categoria=pianeta&per_page=100` — Lista pianeti per comparatore

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
├── curiosita/                  ← CRUD Curiosità ✅
│   ├── index.blade.php         ← Lista con tabella titolo, corpo, descrizione, fonte
│   ├── create.blade.php        ← Form creazione (select corpo, titolo, descrizione, fonte)
│   └── edit.blade.php          ← Form modifica
├── galleria/                   ← CRUD Galleria ✅
│   ├── index.blade.php         ← Griglia con card thumbnail
│   ├── create.blade.php        ← Form upload immagine + dati
│   └── edit.blade.php          ← Form modifica con preview
└── nasa-import/                ← NASA Import ✅
    └── index.blade.php         ← Tabella corpi + bottoni import
```

### API REST

Le API sono pubbliche (nessuna autenticazione richiesta). Utilizzano Eloquent API Resources per la trasformazione dei dati e supportano eager loading delle relazioni.

**Controller API:** `app/Http/Controllers/Api/` — 6 controller per 10 endpoint.

**API Resources:** `app/Http/Resources/` — 5 classi: CorpoCelesteResource, CategoriaResource, MissioneResource, CuriositaResource, GalleriaCorpoResource.

Filtri disponibili:

- `GET /api/corpi-celesti?categoria=stella&tipo=...&search=...&in_evidenza=1&per_page=12`
- `GET /api/missioni?agenzia=NASA&stato=completata`
- `GET /api/corpi-celesti/{corpoCeleste}/simili` — 4 risultati random dalla stessa categoria

**Controller admin:** `app/Http/Controllers/Admin/` — risorsa per ogni entità.

**CRUD Categorie** — 7 route resource (`GET|POST /admin/categorie`, `GET|PUT /admin/categorie/{id}`, `DELETE /admin/categorie/{id}`). Protezione cancellazione: se la categoria ha corpi celesti associati, viene mostrato errore. Form con color picker + palette rapida 10 colori predefiniti.

**CRUD Corpi Celesti** — 7 route resource (`/admin/corpi-celesti`). Upload immagini con Intervention Image (resize 800px, storage `public/corpi-celesti/`). Form con 13 campi, select categoria, checkbox evidenza. Vista show completa con 8 card metriche scientifiche + sezioni galleria, curiosità, missioni.

**CRUD Missioni** — 7 route resource (`/admin/missioni`). Upload logo con Intervention Image (resize 300px, supporto SVG). Stato con badge colorato (Completata/In corso/Pianificata). Vista show con tabella corpi celesti esplorati (dati pivot: tipo esplorazione, anno arrivo).

**CRUD Curiosità** — 6 route resource (`/admin/curiosita`, senza show). Parametro route `{curiositum}` (singolare latino di "curiosita"). Form con select corpo celeste, titolo, textarea descrizione, fonte opzionale. Vista index con tabella titolo, corpo celeste (linkabile), descrizione troncata, fonte.

**CRUD Galleria** — 6 route resource (`/admin/galleria`, senza show). Parametro route `{galleriaCorpo}`. Upload immagini con Intervention Image (resize 1200px, storage `public/galleria/`). Vista index a griglia con card thumbnail, didascalia, corpo celeste linkabile, crediti, ordine di visualizzazione.

**NASA Import** — Pagina backoffice (`/admin/nasa-import`) con tabella di tutti i corpi celesti e badge "Presente"/"Assente" per indicare se hanno un'immagine. Bottone "Importa da NASA" (ciano) per cercare e scaricare l'immagine del corpo celeste da NASA Image API. Bottone "Forza import" (arancione) per sovrascrivere l'immagine esistente. Bottone "Force Import All" (arancione) per importare/sovrascrivere le immagini di tutti i corpi celesti in una volta, con modale di conferma Alpine.js. Utilizza `Illuminate\Support\Facades\Http` per la chiamata API (con `->withoutVerifying()` per Windows) e `Intervention Image` per il salvataggio. Mappa nomi italiano→inglese (Cerere→Ceres, Terra→Earth, ecc.) per la ricerca su NASA API.

**Profilo utente** — Pagina profilo Breeze (`/user/profile`) restilizzata con tema scuro (sfondo `#0A0A1A`, card `#111128`). 3 sezioni: informazioni nome/email, cambio password, elimina account. Shared components (TextInput, InputLabel, PrimaryButton, SecondaryButton, Modal) adattati al tema scuro.

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
