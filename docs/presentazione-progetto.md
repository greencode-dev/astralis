# Astralis — Presentazione del Progetto

## 1. Il Progetto in Breve

| Cosa | Dettaglio |
|------|-----------|
| **Cos'è** | Catalogo web di corpi celesti (pianeti, stelle, galassie, nebulose, lune, comete, asteroidi) |
| **Stack** | Laravel 13 + React 19 + Vite + Blade + Tailwind CSS + MySQL |
| **Frontend guest** | React SPA standalone (no Inertia), comunicazione via API REST JSON |
| **Backoffice admin** | Blade puro con Alpine.js, autenticazione Breeze, autorizzazione Policy/Gates |
| **Test** | 130 PHPUnit + 88 Vitest (218 test totali) |
| **API esterne** | NASA Image API — import automatico immagini reali |
| **Repository** | [github.com/tuo-username/astralis](https://github.com/tuo-username/astralis) |

---

## 2. Fasi di Sviluppo

### Fase 0 — Setup (02/07)

Installazione Laravel 13 con Breeze stack React. Configurazione ambiente: MySQL su porta 3307, database `astralis`. Generazione APP_KEY. Setup Vite per React + Tailwind.

### Fase 1 — Database e Modelli (03/07)

Creazione dello schema dati. Sei migrazioni per le 5 entità del dominio + tabella pivot. Installazione spatie/laravel-sluggable per slug automatici. Cinque modelli Eloquent con relazioni (BelongsTo, HasMany, BelongsToMany). Sette seeder con dati reali: 8 categorie (Pianeta, Stella, Galassia...), 18 corpi celesti (da Mercurio a Plutone), 10 missioni spaziali (Apollo 11, Voyager, JWST...), 16 immagini galleria, 18 curiosità, 17 relazioni pivot. Utente admin di default (`admin@astralis.it` / `password`).

### Fase 2 — CRUD Admin Blade (03/07)

Realizzazione del backoffice amministrativo. Layout master con sidebar navigazione, tema scuro (`#0A0A1A`, `#111128`, `#22D3EE`). Dashboard con statistiche (conteggio entità, ultimi corpi inseriti). CRUD completo per tutte e 5 le entità: ogni controller ha index, create, store, show, edit, update, destroy. Protezione cancellazione: categoria con corpi associati non si elimina, missione con corpi non si elimina. Upload immagini per Missioni e Galleria con Intervention Image.

### Fase 3 — API REST (03/07)

Dieci endpoint JSON pubblici in `routes/api.php`. Cinque API Resource class per trasformare i modelli in JSON. Filtri su corpi celesti: categoria (slug), tipo, search (nome/descrizione), in_evidenza, per_page (max 100). Filtri su missioni: agenzia, stato. Route model binding con slug per gli show. Eager loading delle relazioni per evitare N+1.

### Fase 4-5 — React SPA Guest (04/07)

Frontend visitatore come SPA React standalone. Entry point separato (`resources/js/guest/main.jsx`). Routing con react-router-dom: `/` (homepage con sistema solare animato), `/corpi-celesti` (lista filtrata), `/corpi-celesti/:slug` (dettaglio), `/confronta` (comparatore), `/*` (404). Componenti: Navbar, Footer, SolarSystem (framer-motion, orbite matematiche seno/coseno), CorpoCard (gradiente categoria, fallback icona), CategoriaBadge (8 colori), SearchBar, LightboxGalleria (yet-another-react-lightbox), TimelineMissioni (scrolling orizzontale).

### Fase 6 — Bugfix Orbite e NASA Import (04/07)

Tre tentativi per le orbite dei pianeti: prima `transformOrigin` (etichette ruotavano), poi contro-rotazione (parziale), infine orbite matematiche con `useMotionValue` + `useTransform` (seno/coseno, testo sempre dritto). Creazione pannello NASA Import nel backoffice con tabella corpi e bottoni import singolo/massivo. Route `/dashboard` redirect a `/admin`. Link profilo nella sidebar.

### Fase 7 — Intervention Image v4 (04/07)

Migration da Intervention Image v3 a v4: API completamente cambiata. `Image::read()` → `ImageManager(new Driver())->decodePath()`. `resize(closure)` → `scaleDown(width, height)`. Force Import All con modale Alpine.js di conferma. Gestione SSL su Windows con `withoutVerifying()`.

### Fase 8 — NasaImageService e CLI (04/07)

Service layer centralizzato: `NasaImageService`. Metodi: `searchNasa()` (ricerca con fallback apostrofi, timeout 30s, retry 2), `extractMetadata()` (nasa_id, title, photographer, description), `pickImageUrl()` (alternate ~medium → preview ~thumb → canonical ~orig), `importForBody()` (1 immagine principale + N galleria), `importAll()` (itera tutti i corpi). Comando Artisan `php artisan astralis:fetch-nasa` con opzioni `--force`, `--gallery=N`, `--update-description`. Colonna `nasa_id` su corpi_celesti per dedup.

### Fase 9 — URL Remoti e WordMap (04/07)

Immagini NASA salvate come URL remoti (~medium.jpg), non più download locali. Campo `nome_it` su corpi_celesti per nome italiano. Accessor `nome_display` (`nome_it ?? nome`). `WordMapService` con ~70 termini per traduzione italiano→inglese. Auto-suggest admin: pulsante "Cerca su NASA" nei form create/edit che POST a `suggestNome()`.

### Fase 10 — UI Auth e Paginazione (06/07)

Tema scuro su pagine auth (login, register, password reset). Link Register nella Login page. Velocità orbitali differenziate (pianeti lontani più lenti). Paginazione admin (`->paginate(20)`) su tutte le index.

### Fase 11 — Inertia→Blade, Dedup, Galleria Cleanup (07/07)

Rimozione completa di Inertia: 9 controller auth riscritti, 11 viste Blade create, eliminati 13 componenti JSX Inertia. Login/logout con `Inertia::location()` per full page reload. Deduplicazione galleria NASA (stesso URL + stesso corpo → skip). Preservazione `immagine_utente=true` (non sovrascrivere immagini impostate dall'admin). Comando `php artisan astralis:gallery --fix` per manutenzione. Ordinamento inline galleria con pulsanti su/giù.

### Fase 12 — Authorization e FormRequest (07/07)

Colonna `is_admin` su tabella `users`. 5 Policy (CategoriaPolicy, CorpoCelestePolicy, MissionePolicy, CuriositaPolicy, GalleriaCorpoPolicy) con pattern: `before()` concede tutto agli admin, viewAny/view true per tutti, create/update/delete false. Gate `admin` per NASA Import. `StoreCorpoCelesteRequest` e `UpdateCorpoCelesteRequest` per validazione. Rimozione dipendenze Inertia (composer + npm).

### Wave 1-4 — Refactoring P2/P3 (08/07)

Wave 1: WordMapService estratto, simili ordinati per nome. Wave 2: Accessibilità — aria-label su pulsanti, role="img" su fallback immagini. Wave 3: onMouseEnter/onMouseLeave convertiti in CSS :hover (~270 righe rimosse). Wave 4: Stili inline Blade convertiti in classi Tailwind palette admin.

### Fase 13 — Testing Completo (08/07)

HasFactory su tutti i 5 modelli. 26 test unitari NasaImageService (search, extractMetadata, pickImageUrl, importForBody, importAll). Disabilitazione observer in testing. 84 test feature (API + Admin CRUD). Vitest per frontend: 27 test componenti + 61 test integrazione API. Totale: 88 test React.

### Fase 14 — Bugfix e Dashboard (09/07)

10 bug critici fixati: Blade @endif mancanti, NaN guard su CorpoCard, 404 route catch-all in React, ownership check setImageFromGallery, N+1 su Missione show, stato lowercase migration, SSL condizionale, import Orbit duplicato. Dashboard admin con 3 grafici Chart.js (donut corpi/categoria, barre corpi/tipo, barre missioni/stato). Pulizia dipendenze: rimosse laravel/sanctum, barryvdh/laravel-dompdf, @tailwindcss/vite, @headlessui/react. React spostato in dependencies, plugin-react in devDependencies.

### Fase 15 — CRUD Test e SEO (09/07)

4 file di test admin CRUD: CategoriaCrudTest (14), MissioneCrudTest (13), CuriositaCrudTest (10), GalleriaCrudTest (9) — 46 test aggiunti. Totale 130 test PHPUnit. Paginazione categorie. Vista show curiosità. Barre di ricerca/filtro su tutte le index admin. SEO: `document.title` via useEffect su 5 pagine React. Error Boundary globale React (class component con fallback UI). Search/filter admin con `->when()` e `withQueryString()`.

---

## 3. Checklist Requisiti → Realizzato

| # | Requisito dalla Traccia | Come l'abbiamo Realizzato | Stato |
|---|------------------------|---------------------------|-------|
| 1 | Backoffice Laravel con Blade | 20 viste Blade con layout master, sidebar, tema dark | ✅ |
| 2 | Autenticazione Breeze | Breeze installato, pagine auth convertite in Blade puro con tema scuro | ✅ |
| 3 | CRUD entità principale | CorpoCelesteController: index (paginato+ricerca), create, store, show, edit, update, destroy | ✅ |
| 4 | Almeno una relazione 1-N o N-N | 1-N: Categoria→Corpo, Corpo→Galleria, Corpo→Curiosità. N-N: Corpo↔Missioni (con pivot) | ✅ |
| 5 | CRUD entità secondarie | Categoria, Missione, Curiosità, Galleria — tutti con CRUD completo | ✅ |
| 6 | Upload media | Missioni (logo, 300px), Galleria (immagini, 1200x1200) con Intervention Image v4 | ✅ |
| 7 | SPA React guest | React 19 standalone con Vite, 5 pagine, 9 componenti, routing lato client | ✅ |
| 8 | Lista elementi guest | CorpiLista.jsx: griglia con filtri (categoria, tipo, search), paginazione "Carica altri" | ✅ |
| 9 | Dettaglio elemento guest | CorpoDettaglio.jsx: metriche scientifiche, galleria, curiosità, missioni, simili | ✅ |
| 10 | Info correlate nel dettaglio | Categoria (badge), galleria (lightbox), curiosità (lista), missioni (timeline), simili (card) | ✅ |
| 11 | API REST per comunicazione | 10 endpoint JSON con filtri, eager loading, API Resources, route model binding con slug | ✅ |
| 12 | Test API con Postman | Endpoint pubblici (nessun auth), response JSON strutturate, filtrabili via query params | ✅ |

### Cosa abbiamo fatto IN PIÙ (Wow Factor)

| Extra | Descrizione |
|-------|-------------|
| 🚀 **NASA API Integration** | Import immagini reali dalla NASA Image API: cerca, sceglie URL migliore, popola galleria. Fallback apostrofi ("Earth's Moon" → "Earth Moon"). Auto-import su creazione corpo. CLI dedicata |
| 🪐 **Sistema Solare Animato** | 8 pianeti orbitano con velocità differenziate usando framer-motion (seno/coseno). Etichette sempre leggibili |
| 🖼️ **Lightbox Galleria** | Immagini a schermo intero con swipe mobile, slideshow |
| ⚖️ **Comparatore Pianeti** | Confronto affiancato di 2 corpi celesti su 7 metriche (massa, diametro, temperatura, gravità...). Pre-fill via URL params |
| 📅 **Timeline Missioni** | Scrolling orizzontale con badge stato colorato (Completata/In corso/Pianificata) |
| 📊 **Dashboard Chart.js** | 3 grafici interattivi: donut corpi/categoria, barre corpi/tipo, barre missioni/stato. Tema dark |
| 🛠️ **CLI Commands** | `astralis:fetch-nasa` (import massivo), `astralis:gallery` (manutenzione: check, clean, sync, fix, dry-run) |
| 🛡️ **Error Boundary** | Cattura errori di rendering React, fallback UI con tema dark e link home |
| 🔍 **SEO Meta Tags** | `document.title` dinamico su tutte le 5 pagine guest |
| 🧪 **218 Test Totali** | 130 PHPUnit (335 assertion) + 88 Vitest — observer disabilitato in testing, Http::fake(), RefreshDatabase |
| 📖 **Knowledge Graph** | graphify: 1211 nodi, 1783 edges, documentazione collegata |

---

## 4. Guide Pratiche

### Come Testare le API con Postman

Tutti gli endpoint sono **pubblici** (nessun token, nessuna autenticazione). Basta puntare Postman a `http://localhost:8000`.

**Esempio 1 — Lista corpi celesti con filtro**:
```
GET http://localhost:8000/api/corpi-celesti?categoria=pianeta&per_page=5
```
Response: JSON con `data[]`, `meta` (pagination), `links`. Ogni corpo ha `nome_display` (italiano se disponibile).

**Esempio 2 — Dettaglio con slug**:
```
GET http://localhost:8000/api/corpi-celesti/terra
```
Response: JSON con categoria, galleria (url immagine, didascalia, crediti), curiosità, missioni (con pivot: tipo_esplorazione, anno_arrivo).

**Esempio 3 — Filtri multipli**:
```
GET http://localhost:8000/api/missioni?agenzia=NASA&stato=Completata
```

**Esempio 4 — Stats dashboard**:
```
GET http://localhost:8000/api/dashboard/stats
```
Response: conteggio corpi, categorie, missioni; ultimi 5 corpi; missioni per stato.

### Come Creare una Migrazione

```bash
php artisan make:migration add_eta_to_corpi_celesti_table --table=corpi_celesti
```

```php
// database/migrations/xxxx_add_eta_to_corpi_celesti_table.php
public function up(): void
{
    Schema::table('corpi_celesti', function (Blueprint $table) {
        $table->integer('eta_anni')->nullable()->after('anno_scoperta');
    });
}
```

```bash
php artisan migrate
```

### Come Creare una Relazione 1-N

```php
// Su CorpoCeleste.php (il "molti")
public function commenti(): HasMany
{
    return $this->hasMany(Commento::class);
}

// Su Commento.php (il "uno")  
public function corpoCeleste(): BelongsTo
{
    return $this->belongsTo(CorpoCeleste::class);
}
```

### Come Creare una Relazione N-N con Pivot

```bash
php artisan make:migration create_corpo_celeste_tag_table
```

```php
Schema::create('corpo_celeste_tag', function (Blueprint $table) {
    $table->id();
    $table->foreignId('corpo_celeste_id')->constrained()->cascadeOnDelete();
    $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
    $table->string('fonte')->nullable();             // dati extra sulla pivot
    $table->unique(['corpo_celeste_id', 'tag_id']);  // evita duplicati
    $table->timestamps();
});
```

```php
// Su CorpoCeleste.php
public function tags(): BelongsToMany
{
    return $this->belongsToMany(Tag::class)
        ->withPivot(['fonte'])
        ->withTimestamps();
}
```

### Come Creare un Model + Controller + Migrazione in un Comando

```bash
php artisan make:model Commento -mfc
# -m: migration, -f: factory, -c: controller
```

Questo crea: `app/Models/Commento.php`, `database/migrations/...create_commenti_table.php`, `database/factories/CommentoFactory.php`, `app/Http/Controllers/CommentoController.php`.

---

## 5. Il Nostro Stack Tecnologico

| Livello | Tecnologia | Versione | Perché |
|---------|-----------|----------|--------|
| **Backend** | Laravel | 13 | Richiesto dalla traccia. Eloquent ORM, migrazioni, artisan CLI |
| **Database** | MySQL | 8.x | Richiesto. Porta 3307 |
| **Auth** | Laravel Breeze | — | Richiesto. Configurato con Blade (non Inertia) |
| **Frontend guest** | React | 19 | Richiesto. SPA standalone con Vite |
| **Frontend admin** | Blade + Alpine.js | — | Richiesto per admin (Blade). Alpine.js per modali conferma |
| **CSS** | Tailwind CSS | 3.2 | Utility-first, tema dark custom |
| **Animazioni** | framer-motion | 12 | Sistema solare, transizioni pagina |
| **Icone** | lucide-react | 1 | Icone categorìa, navigazione, azioni |
| **Lightbox** | yet-another-react-lightbox | 3 | Galleria immagini a schermo intero |
| **Immagini** | Intervention Image | 4 | Upload con scaleDown (NO facade) |
| **Slug** | spatie/laravel-sluggable | — | Slug automatici su 3 modelli |
| **Grafici** | Chart.js (CDN) | 4.4 | Dashboard admin (donut, barre) |
| **API esterne** | NASA Image API | — | Import immagini reali, auto-suggest |
| **Test PHP** | PHPUnit | — | 130 test, 335 assertion |
| **Test JS** | Vitest + Testing Library | 4 | 88 test, environment jsdom |

---

## 6. Comandi Rapidi

```bash
# Avvio progetto
php artisan serve            # Backend → http://localhost:8000
npm run dev                  # Frontend → http://localhost:5173

# Test
php artisan test             # Backend (130 test, 335 assertion)
npm test                     # Frontend (88 test Vitest)

# Database
php artisan migrate                        # Applica migrazioni
php artisan migrate:fresh --seed           # Reset completo con dati

# NASA Import
php artisan astralis:fetch-nasa            # Import immagini per tutti i corpi
php artisan astralis:fetch-nasa --force    # Sovrascrivi esistenti
php artisan astralis:gallery --fix         # Ripara galleria

# Build
npx vite build                # Build produzione frontend

# Creare nuovo codice
php artisan make:model Nome -mf            # Modello + migration + factory
php artisan make:controller NomeController --resource
php artisan make:policy NomePolicy --model=Nome
php artisan make:request StoreNomeRequest
php artisan make:test NomeTest --unit
```

---

## 7. Credenziali

| Ruolo | Email | Password |
|-------|-------|----------|
| **Admin** | admin@astralis.it | password |
| **Utente normale** | (registrazione libera su /register) | — |

---

*Documento generato il 09/07/2026 — Astralis v13.18*
