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

### Fase 0 — Setup del Progetto (02/07)

**Cosa abbiamo fatto**: Installazione Laravel 13 con Breeze stack React. Configurazione ambiente: MySQL su porta 3307, database `astralis`. Generazione APP_KEY. Setup Vite per React + Tailwind.

📌 `composer create-project laravel/laravel astralis` poi `composer require laravel/breeze --dev` poi `php artisan breeze:install react`.

---

### Fase 1 — Database, Modelli e Relazioni (03/07)

🎯 **La traccia richiedeva**: almeno 2 entità con una relazione (1-N o N-N) e struttura dati ben organizzata prima di iniziare a scrivere codice.

✅ **Noi abbiamo realizzato**: 5 entità del dominio (Categoria, CorpoCeleste, Missione, Curiosita, GalleriaCorpo) + una tabella pivot (corpo_celeste_missione). Tre tipi di relazione:

| Relazione | Esempio | Cos'è |
|-----------|---------|-------|
| **BelongsTo / HasMany** (1-N) | Categoria → CorpoCeleste, CorpoCeleste → Galleria, CorpoCeleste → Curiosità | Una categoria contiene molti corpi. Un corpo ha molte immagini. La FK (`categoria_id`) sta su `corpi_celesti` |
| **BelongsToMany** (N-N) | CorpoCeleste ↔ Missione | Un corpo visitato da più missioni, una missione visita più corpi. Richiede tabella pivot con dati extra (tipo_esplorazione, anno_arrivo) |

**Perché entità separate e non un unico grande JSON?** Perché normalizziamo: ogni entità ha il suo CRUD, le sue policy, la sua factory. La pivot ci permette di conservare metadati sulla relazione (es. l'Apollo 11 ha visitato la Luna con tipo "atterraggio" nel 1969).

Seeder con dati reali: 8 categorie, 18 corpi celesti (da Mercurio a Plutone), 10 missioni spaziali (Apollo 11, Voyager, JWST...), 16 immagini galleria, 18 curiosità, 17 relazioni pivot. Utente admin: `admin@astralis.it` / `password`.

📌 **Comando per creare un modello con migration e factory**: `php artisan make:model Nome -mf`. Per creare una migration per una tabella esistente: `php artisan make:migration add_campo_to_tabella_table --table=tabella`.

📌 **Differenza relazioni**:
- **BelongsTo**: la FK è sulla tabella di QUESTO modello (es. `CorpoCeleste` ha `categoria_id`)
- **HasMany**: la FK è sull'ALTRO modello (es. `Categoria` ha tanti `CorpoCeleste`, ma la FK è su `corpi_celesti.categoria_id`)
- **BelongsToMany**: nessuna delle due ha la FK — serve una terza tabella pivot

📌 **Slug automatici**: `spatie/laravel-sluggable` genera slug dal `nome` al salvataggio. Basta aggiungere il trait e un metodo `getSlugOptions()` nel modello. Tre modelli lo usano: Categoria, CorpoCeleste, Missione.

---

### Fase 2 — CRUD Admin Blade (03/07)

🎯 **La traccia richiedeva**: backoffice in Laravel con Blade (template engine), CRUD completo per tutte le entità, upload di file (immagini/loghi), interfaccia amministrativa completa.

✅ **Noi abbiamo realizzato**: layout master (`resources/views/admin/layouts/app.blade.php`) con sidebar navigazione, tema scuro (`#0A0A1A` sfondo, `#111128` card, `#22D3EE` primario). Dashboard con statistiche (conteggio entità, ultimi 5 corpi, grafici Chart.js). CRUD completo per 5 entità: ogni controller ha 7 metodi (index, create, store, show, edit, update, destroy).

**Protezioni implementate**:
- Categoria: se ha corpi celesti associati → blocco cancellazione con messaggio
- Missione: se ha corpi associati → blocco cancellazione (stesso pattern)
- Upload file: Missioni (logo 300px), Galleria (immagini 1200x1200) con Intervention Image v4

📌 **`Route::resource('/admin/categorie', CategoriaController::class)`** genera 7 route in una riga. `php artisan make:controller NomeController --resource` crea il controller con tutti i 7 metodi pronti.

📌 **`php artisan storage:link`** crea il symlink da `public/storage` a `storage/app/public` — necessario per servire file uploadati.

---

### Fase 3 — API REST (03/07)

🎯 **La traccia richiedeva**: la SPA React deve comunicare col backend tramite chiamate AJAX ad API REST. Bisogna creare endpoint JSON per recuperare i dati.

✅ **Noi abbiamo realizzato**: 10 endpoint pubblici in `routes/api.php` (file separato da `web.php`). API Resources per trasformare i modelli in JSON controllato. Filtri su quasi tutti gli endpoint: `?categoria=`, `?tipo=`, `?search=`, `?in_evidenza=`, `?per_page=` (max 100), `?agenzia=`, `?stato=`.

**Endpoint**:
```
GET /api/corpi-celesti        ← lista filtrata/paginata con categoria, tipo, search, in_evidenza
GET /api/corpi-celesti/{slug}  ← dettaglio con tutte le relazioni
GET /api/corpi-celesti/{id}/simili ← stessa categoria, max 4
GET /api/categorie            ← tutte con conteggio corpi
GET /api/categorie/{slug}     ← singola con corpi
GET /api/missioni             ← filtrate per agenzia/stato
GET /api/missioni/{slug}      ← dettaglio con corpi
GET /api/curiosita            ← tutte con corpo associato
GET /api/galleria             ← tutte ordinate
GET /api/dashboard/stats      ← conteggi per homepage
```

📌 **`php artisan make:resource NomeResource`** crea una classe che trasforma il modello in JSON. Es. `CorpoCelesteResource` espone `nome_display` (accessor che restituisce `nome_it ?? nome`).

📌 **Route model binding con slug**: `Route::get('/api/corpi-celesti/{corpoCeleste:slug}')` — Laravel cerca per colonna `slug` invece che per `id`.

📌 **Filtri condizionali**: `$query->when($request->search, fn($q, $v) => $q->where('nome', 'like', "%{$v}%"))` — se il parametro non c'è, la closure non viene eseguita. Evita if/else.

📌 **Eager loading**: `CorpoCeleste::with(['categoria', 'galleria', 'curiosita', 'missioni'])->firstOrFail()` — carica tutte le relazioni in 1 query + 4 query invece di 1 + 4N (N+1 problem).

---

### Fase 4-5 — React SPA Guest (04/07)

🎯 **La traccia richiedeva**: un'app React per visitatori non autenticati che mostri la lista degli elementi, i dettagli di un singolo elemento, e le informazioni collegate (categorie, relazioni).

✅ **Noi abbiamo realizzato**: SPA React 19 standalone con Vite. Entry point separato (`resources/js/guest/main.jsx`), routing lato client con react-router-dom. Cinque pagine:

| Pagina | Route | Cosa mostra |
|--------|-------|-------------|
| **HomePage** | `/` | Hero, sistema solare animato, 6 corpi in evidenza, stats |
| **CorpiLista** | `/corpi-celesti` | Griglia filtrata (categoria, tipo, search), paginazione "Carica altri" |
| **CorpoDettaglio** | `/corpi-celesti/:slug` | Metriche scientifiche, galleria, curiosità, missioni, simili |
| **Comparatore** | `/confronta` | Due dropdown, tabella confronto 7 campi |
| **NotFound** | `/*` | 404 con icona Telescope + link home |

**Componenti riutilizzabili**: Navbar, Footer, SolarSystem (framer-motion), CorpoCard (gradiente + fallback icona), CategoriaBadge (8 colori), SearchBar, LightboxGalleria, TimelineMissioni, ErrorBoundary.

**Flusso dati**: Pagina → `apiClient.js` (axios) → API Laravel → JSON response → stato React (useState/useEffect).

📌 **Catch-all Laravel + React**: l'ultima riga di `web.php` è `Route::get('/{any}', fn() => view('guest'))->where('any', '.*')`. Cattura tutte le URL non gestite e passa il controllo a React. È fondamentale che sia DOPO le route admin, così non ruba richieste a `/admin/categorie`.

📌 **Due entry Vite**: Guardando `vite.config.js`, ci sono due input: `resources/js/guest/main.jsx` (React) + `resources/css/app.css` (Tailwind). Anche se l'admin è Blade, condivide lo stesso CSS.

📌 **Perché react-router-dom e non Laravel routes?** La SPA è standalone. Tutte le route guest (`/`, `/corpi-celesti`, ecc.) sono gestite lato client. Laravel sa solo "se non è admin o auth, manda tutto a guest.blade.php".

---

### Fase 6 — Sistema Solare Animato e NASA Import (04/07)

🎯 **La traccia non lo richiedeva**. È un **extra Wow Factor**.

✅ **Sistema solare**: tre tentativi per le orbite. Primo: `transformOrigin` CSS (etichette ruotavano coi pianeti). Secondo: contro-rotazione (parziale). Terzo: orbite matematiche con `useMotionValue` + `useTransform` di framer-motion — coordinate x/y calcolate con seno/coseno, testo sempre dritto, velocità differenziate per pianeta.

✅ **NASA Import backoffice**: tabella nel pannello admin che elenca tutti i corpi celesti con badge "Presente"/"Assente". Bottone "Importa da NASA" per singolo corpo, "Force Import All" per tutti (con modale Alpine.js di conferma).

📌 **framer-motion**: `useMotionValue` crea un valore animato che React traccia. `useTransform` lo trasforma (es. da angolo a coordinate x,y). Il sistema solare usa `animate` per incrementare l'angolo nel tempo.

---

### Fase 7 — Migration Intervention Image v3 → v4 (04/07)

🎯 **La traccia richiedeva**: upload di immagini/loghi nel backoffice.

✅ **Noi abbiamo realizzato**: upload per Missioni (logo 300px) e Galleria (immagini 1200x1200). Durante lo sviluppo, la libreria Intervention Image è passata dalla versione 3 alla 4 con API completamente diversa.

📌 **ERRORE COMUNE DA NON FARE**: in v4 NON esiste `Image::read()`. Si usa:
```php
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
$manager = new ImageManager(new Driver());
$image = $manager->read($file->getPathname());
$image->scaleDown(width: 800, height: 800);  // NON resize() — scaleDown mantiene aspect ratio
$image->save($path);
```

📌 **`scaleDown()` vs `resize()`**: `scaleDown()` ridimensiona SOLO se l'immagine è più grande delle dimensioni specificate e preserva l'aspect ratio. `resize()` forza le dimensioni e distorce.

📌 **SSL su Windows**: `Http::withoutVerifying()` serve solo in local/testing perché Windows non ha i certificati CA root configurati come Linux/macOS.

---

### Fase 8 — NasaImageService e CLI (04/07)

🎯 **La traccia non lo richiedeva**. È un **extra Wow Factor** — integrazione con API esterna reale.

✅ Struttura a **service layer**: `app/Services/NasaImageService.php` contiene tutta la logica. Separata dal controller (che gestisce solo la request/response HTTP). Separata dal comando Artisan (che gestisce solo l'input/output CLI).

**Metodi principali**:
- `searchNasa(query, extraFallbacks)` → chiama `images-api.nasa.gov`, timeout 30s, retry 2. Fallback automatico per apostrofi (`Earth's Moon` → `Earth Moon` → `Moon`)
- `extractMetadata(item)` → estrae `nasa_id`, `title`, `photographer`, `description`, `keywords`
- `pickImageUrl(item)` → sceglie URL: `alternate` (~medium.jpg) → `preview` (~thumb.jpg) → `canonical` (~orig.jpg, ultima spiaggia)
- `importForBody(corpo, galleryCount, force, updateDescription)` → import completo per un corpo (1 main + N galleria). Deduplica. Salva URL remoti non file locali
- `importAll(galleryCount, force, updateDescription)` → itera tutti i corpi. `set_time_limit(300)` per processi lunghi

📌 **`php artisan make:command NomeCommand`** crea un comando Artisan. Il comando `astralis:fetch-nasa` usa `$this->option('force')`, `$this->option('gallery')`, `$this->option('update-description')`.

📌 **Perché un service layer?** Il controller (NasaImportController) gestisce HTTP request/response. Il service (NasaImageService) gestisce logica di business. Se dovessimo importare da un cron job o da un webhook, basterebbe chiamare il service — zero duplicazione di codice.

---

### Fase 9 — URL Remoti, nome_it e WordMap (04/07)

🎯 **La traccia non lo richiedeva**. Extra — miglioramento della qualità dei dati.

✅ Invece di scaricare immagini NASA, salviamo URL remoti `~medium.jpg` (risparmio storage, evitiamo download di file enormi). Aggiunto campo `nome_it` su `corpi_celesti` per nomi italiani (accessor `nome_display` che fa `nome_it ?? nome`). WordMapService con ~70 termini per tradurre italiano→inglese parola per parola e cercare su NASA.

📌 **Accessor Eloquent**: `public function getNomeDisplayAttribute(): string { return $this->nome_it ?? $this->nome; }`. Si usa come `$corpo->nome_display`. Esposto nelle API via Resource.

📌 **WordMap**: array associativo `'Nebulosa' => 'Nebula', 'Stella' => 'Star', 'Nana' => 'Dwarf'`... Permette all'admin di scrivere "Buco Nero" e tradurlo in "Black Hole" per la ricerca NASA.

---

### Fase 10 — UI Auth e Paginazione (06/07)

🎯 **La traccia richiedeva**: autenticazione Breeze. Non specificava lo stile delle pagine auth.

✅ Tema scuro applicato anche alle pagine di login, register, password reset (stessa palette `#0A0A1A` del backoffice). Aggiunto link "Register" nella login page (Breeze di default non lo mostra). Paginazione (`->paginate(20)`) su tutte le index admin.

📌 **`->paginate(20)`** + `->withQueryString()` nei controller + `$categorie->links()` nella vista = paginazione funzionante con link alle pagine successive.

---

### Fase 11 — Inertia → Blade Puro (07/07)

🎯 **La traccia richiedeva**: backoffice in Blade e autenticazione Breeze. Di default Breeze installa Inertia, ma noi abbiamo scelto di rimuoverlo.

✅ **Perché abbiamo rimosso Inertia**: la SPA guest è React standalone che comunica via API. Inertia sarebbe stato un livello intermedio inutile — aggiungeva middleware, dipendenze npm/composer, JSX pages, e poteva interferire col routing lato client. Il backoffice è Blade puro, l'auth è Blade puro, la SPA è React pura. Ogni tecnologia fa il suo lavoro senza sovrapposizioni.

Riscritti 9 controller auth (da `Inertia::render()` a `view()`). Create 11 viste Blade per auth e profilo con tema scuro. Eliminati 13 componenti JSX Inertia.

📌 **Login/logout**: `Inertia::location()` forza un full page reload invece di una transizione SPA — evita conflitti col routing React.

📌 **Deduplicazione NASA import**: `GalleriaCorpo::where('percorso', $url)->where('corpo_celeste_id', $id)->exists()` — prima di creare una nuova voce galleria, controlla che non esista già.

📌 **`php artisan astralis:gallery --fix`**: comando che verifica tutte le immagini in galleria, sostituisce URL non raggiungibili con placeholder NASA, pulisce record orfani. Opzioni: `--check` (solo report), `--clean` (elimina ko), `--sync` (sostituisce da NASA), `--fix` (sync+clean), `--dry-run`.

---

### Fase 12 — Authorization, Policy e FormRequest (07/07)

🎯 **La traccia richiedeva**: backoffice protetto da autenticazione. Implicitamente, anche autorizzazione: non tutti gli utenti devono poter creare/modificare/eliminare.

✅ Abbiamo implementato un sistema completo di autorizzazione:

**Colonna `is_admin`**: boolean su tabella `users`, default false. Admin demo ha `true`.

**5 Policy** (una per entità): tutte con lo stesso pattern:
```php
public function before(User $user): ?bool
{
    if ($user->is_admin) return true;  // admin bypassa TUTTO
    return null;  // non-admin → controlla metodo specifico
}
public function viewAny(): bool { return true; }   // lettura OK
public function view(): bool { return true; }
public function create(): bool { return false; }   // scrittura NO
public function update(): bool { return false; }
public function delete(): bool { return false; }
```

**Gate `admin`**: definito in `AuthServiceProvider` — `Gate::define('admin', fn(User $user) => $user->is_admin)`. Usato da NasaImportController (che non ha una Policy).

**2 FormRequest**: `StoreCorpoCelesteRequest` e `UpdateCorpoCelesteRequest` per validazione fuori dal controller (~40 righe risparmiate).

📌 **`before()` con `?bool`**: se restituisce `true` → bypassa tutto (admin). Se restituisce `null` → Laravel controlla il metodo specifico (non-admin). Se restituisce `false` → blocca TUTTO, anche viewAny. Questo pattern è comodissimo: un unico `before()` gestisce tutti i casi.

📌 **Policy vs Gate**: 
- Policy = gruppo di permessi su un modello (Categoria, CorpoCeleste...)
- Gate = singola azione (es. "admin"). Si usa con `Gate::authorize('admin')`

📌 **`php artisan make:policy NomePolicy --model=Nome`**: genera i metodi base. `php artisan make:request StoreNomeRequest`: genera FormRequest con rules().

📌 **Rimozione Inertia (composer + npm)**: `composer remove inertiajs/inertia-laravel tightenco/ziggy` e `npm uninstall @inertiajs/react`. Poi `composer dump-autoload` per rigenerare autoloader.

---

### Wave 1-4 — Refactoring P2/P3 (08/07)

🎯 **La traccia non richiedeva refactoring mirato**. Extra — miglioramento qualità codice.

- **Wave 1**: WordMapService estratto dal controller (riusabile), simili ordinati per nome (prima erano random)
- **Wave 2**: Accessibilità — `aria-label` su tutti i pulsanti admin, `role="img"` su immagini con fallback
- **Wave 3**: ~270 righe di `onMouseEnter`/`onMouseLeave` convertiti in CSS `:hover` (più performante, manutenzione più facile)
- **Wave 4**: Stili inline `style="color: #..."` convertiti in classi Tailwind palette admin

---

### Fase 13 — Testing Completo (08/07)

🎯 **La traccia non richiedeva esplicitamente test. Ma un progetto professionale ne ha.**

✅ **218 test totali**:
- **130 PHPUnit** (335 assertion): 26 test unitari NasaImageService + 8 file test API + 5 file test Admin CRUD + 6 file auth Breeze
- **88 Vitest**: 27 test componenti React + 61 test integrazione API
- **HasFactory** su tutti i 5 modelli del dominio
- **Observer disabilitato in testing** (`app()->environment('testing')`)
- **`Http::fake()`** in tutti i test che creano CorpoCeleste

📌 **Pattern obbligatorio per i test**:
```php
protected function setUp(): void
{
    parent::setUp();
    Http::fake();  // SENZA QUESTO → chiamate HTTP reali → test falliscono
}
```

📌 **Perché `Http::fake()` è essenziale**: `CorpoCelesteObserver::created()` chiama NASA API ogni volta che un CorpoCeleste viene creato. Nei test, le factory creano corpi. Senza `Http::fake()`, i test farebbero chiamate HTTP reali e fallirebbero o sarebbero lentissimi.

📌 **`php artisan make:test NomeTest --unit`** crea un test in `tests/Unit/`. Senza `--unit` va in `tests/Feature/`. Usiamo `RefreshDatabase` trait per DB pulito in ogni test.

---

### Fase 14 — Bugfix, Dashboard e Pulizia Dipendenze (09/07)

🎯 **La traccia non richiedeva una dashboard con grafici. Extra Wow Factor.**

✅ **10 bug critici fixati**:
- Blade: `@endif` mancanti in 3 file (categorie, galleria, curiosità)
- React: NaN km in CorpoCard (aggiunto `isNaN` guard)
- React: route catch-all `path="*"` mancante (404 non funzionava)
- Backend: ownership check in setImageFromGallery (controllo che l'immagine appartenga al corpo)
- Backend: N+1 query in Missione show (mancava eager loading)
- DB: migration missioni con `stato` lowercase → cambiato in uppercase
- SSL: `withoutVerifying()` condizionale (solo in local/testing)
- React: import duplicato Orbit da lucide-react

✅ **Dashboard Chart.js**: 3 grafici interattivi con tema dark:
- Donut: corpi per categoria (es. quanti pianeti, quante stelle)
- Barre verticali: corpi per tipo (es. gigante gassoso, pianeta roccioso)
- Barre orizzontali: missioni per stato (Completata, In corso, Pianificata)

✅ **Pulizia dipendenze**: rimosse 4 librerie mai usate (laravel/sanctum, barryvdh/laravel-dompdf, @tailwindcss/vite, @headlessui/react). React spostato in `dependencies` (era in `devDependencies`). Plugin React spostato in `devDependencies`.

📌 **N+1 query**: quando mostri una lista di 10 missioni e per ognuna carichi i corpi associati con `$missione->corpiCelesti`, se non fai eager loading (`->with('corpiCelesti')`) fai 1 query per la lista + 10 query per i corpi = 11 query totali. Con eager loading: 1 + 1 = 2 query.

---

### Fase 15 — CRUD Test Admin e SEO (09/07)

🎯 **La traccia non richiedeva test specifici per admin. Extra — copertura completa.**

✅ **4 nuovi file di test CRUD admin**: CategoriaCrudTest (14 test), MissioneCrudTest (13 test), CuriositaCrudTest (10 test), GalleriaCrudTest (9 test) = 46 test aggiunti. Totale: 130 PHPUnit.

✅ **Categoria pagination**: `->paginate(20)` + `->withQueryString()` nella index.

✅ **Curiosita show**: nuovo metodo `show()` nel controller + nuova vista `resources/views/admin/curiosita/show.blade.php`.

✅ **Search/filter admin**: barre di ricerca su Categoria, Missione (anche agenzia/stato), Curiosità, Galleria usando `->when($request->search, ...)`.

✅ **SEO**: `document.title` via `useEffect` in tutte le 5 pagine React (HomePage, CorpiLista, CorpoDettaglio, Comparatore, NotFound).

✅ **Error Boundary**: class component React che avvolge `<Routes>` in App.jsx. Se un componente crasha, mostra fallback UI con tema dark + icona AlertTriangle + "Qualcosa è andato storto" + link home.

📌 **document.title in React per SEO** — non c'è SSR, ma almeno il titolo della scheda browser è descrittivo. Ogni pagina lo imposta via useEffect  con dipendenza appropriata (es. CorpoDettaglio si aggiorna quando arriva il nome dall'API).

---

## 3. Checklist Requisiti → Realizzato

| # | Requisito | Realizzato in | Stato |
|---|-----------|---------------|-------|
| 1 | Backoffice Laravel con Blade | **Fase 2** — 20 viste Blade, layout master, sidebar, tema dark | ✅ |
| 2 | Autenticazione Breeze | **Fase 11** — Breeze su Blade puro (Inertia rimosso), tema scuro | ✅ |
| 3 | CRUD entità principale | **Fase 2** — CorpoCeleste: index con paginazione+ricerca, create, store, show, edit, update, destroy | ✅ |
| 4 | Relazioni 1-N o N-N | **Fase 1** — 3 tipi: BelongsTo/HasMany (1-N), BelongsToMany (N-N con pivot) | ✅ |
| 5 | CRUD entità secondarie | **Fase 2** — Categoria, Missione, Curiosità, Galleria — CRUD completo ciascuno | ✅ |
| 6 | Upload media | **Fase 7** — Missioni (logo 300px), Galleria (1200x1200) con Intervention Image v4 | ✅ |
| 7 | SPA React guest | **Fase 4-5** — React 19 standalone, 5 pagine, 9 componenti, react-router-dom | ✅ |
| 8 | Lista elementi guest | **Fase 4-5** — CorpiLista.jsx: griglia, filtri (categoria/tipo/search), paginazione | ✅ |
| 9 | Dettaglio elemento guest | **Fase 4-5** — CorpoDettaglio.jsx: metriche, galleria, curiosità, missioni, simili | ✅ |
| 10 | Info correlate | **Fase 4-5** — Badge categoria, lightbox, timeline missioni, simili, curiosità | ✅ |
| 11 | API REST | **Fase 3** — 10 endpoint JSON, filtri, eager loading, API Resources, slug binding | ✅ |
| 12 | Test API via Postman | **Fase 3** — Endpoint pubblici, response JSON, filtri via query params | ✅ |

### Wow Factor — Oltre la Traccia

| Extra | Descrizione | Dove |
|-------|-------------|------|
| 🚀 **NASA API Integration** | Import automatico immagini reali, fallback apostrofi, auto-import su created | Fase 8-9 |
| 🪐 **Sistema Solare Animato** | 8 pianeti orbitanti con velocità differenziate, framer-motion | Fase 6 |
| 🖼️ **Lightbox Galleria** | Schermo intero con swipe mobile, slideshow | Fase 5 |
| ⚖️ **Comparatore Pianeti** | Confronto 2 corpi su 7 metriche, pre-fill via URL params | Fase 5 |
| 📅 **Timeline Missioni** | Scrolling orizzontale con badge stato colorato | Fase 5 |
| 📊 **Dashboard Chart.js** | 3 grafici donut/barre con tema dark | Fase 14 |
| 🛠️ **CLI Commands** | `astralis:fetch-nasa` e `astralis:gallery` per manutenzione | Fase 8-11 |
| 🛡️ **Error Boundary** | Fallback UI globale per crash React | Fase 15 |
| 🔍 **SEO Meta Tags** | `document.title` dinamico su 5 pagine | Fase 15 |
| 🧪 **218 Test Totali** | 130 PHPUnit + 88 Vitest, Http::fake(), observer skip | Fase 13-15 |

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

## 8. 📌 Schede Riassuntive

### Scheda 1 — Relazioni Eloquent

| Tipo | Cos'è | La FK sta su... | Esempio dal progetto | Comando |
|------|-------|-----------------|---------------------|---------|
| **BelongsTo** (1) | Il modello "figlio" appartiene al "padre" | Questo modello | `CorpoCeleste` → `categoria_id` | `$this->belongsTo(Categoria::class)` |
| **HasMany** (N) | Il modello "padre" ha molti "figli" | L'altro modello | `Categoria` → `corpiCelesti()` | `$this->hasMany(CorpoCeleste::class)` |
| **BelongsToMany** (N-N) | Molti-a-molti, serve tabella pivot | Nessuno (terza tabella) | `CorpoCeleste` ↔ `Missione` via `corpo_celeste_missione` | `$this->belongsToMany(Missione::class)->withPivot(['tipo_esplorazione'])` |

**Regola pratica**: se la risposta a "chi ha la chiave esterna?" è "questo modello" → `BelongsTo`. Se è "l'altro modello" → `HasMany`. Se non c'è una chiave esterna in nessuno dei due → `BelongsToMany` (pivot).

### Scheda 2 — Pattern Ricorrenti

| Pattern | Dove si usa | Codice |
|---------|------------|--------|
| **Route resource** | web.php — 6 CRUD admin | `Route::resource('/admin/categorie', CategoriaController::class)` genera 7 route |
| **Filtri condizionali** | Controller Admin e Api | `$query->when($request->search, fn($q, $v) => $q->where('nome', 'like', "%{$v}%"))` |
| **Eager loading** | show() di ogni controller | `CorpoCeleste::with(['categoria','galleria','curiosita','missioni'])->firstOrFail()` |
| **Authorize** | CRUD admin | `$this->authorize('create', Categoria::class)` |
| **Paginazione** | Index admin | `$categorie = Categoria::paginate(20)->withQueryString()` + `{{ $categorie->links() }}` nella vista |
| **withQueryString** | Index admin | Preserva i parametri `?search=` durante la paginazione |
| **Http::fake()** | Test PHPUnit | `Http::fake(['images-api.nasa.gov/*' => Http::response([...])])` |
| **withoutVerifying** | NasaImageService | `if (app()->environment('local', 'testing')) { $request->withoutVerifying(); }` |
| **app()->environment('testing')** | Observer | `if (app()->environment('testing')) { return; }` — skip NASA in test |
| **Route model binding con slug** | api.php | `Route::get('/.../{corpoCeleste:slug}')` — cerca per slug, non per id |
| **scaleDown()** | Upload immagini | `$image->scaleDown(width: 1200, height: 1200)` — ridimensiona solo se più grande |
| **$fillable** | Modelli | `protected $fillable = ['nome', 'slug', 'categoria_id', ...]` — campi assegnabili in massa |
| **Accessor** | Modelli | `public function getNomeDisplayAttribute(): string { return $this->nome_it ?? $this->nome; }` |

### Scheda 3 — Errori Comuni da NON Fare

| Errore | Perché è sbagliato | Cosa fare invece |
|--------|--------------------|------------------|
| `Image::read()` in Intervention v4 | La facade è stata rimossa in v4. Cause: `Call to undefined method read()` | `new ImageManager(new Driver())->read($path)` o `->decodePath()` |
| `resize()` invece di `scaleDown()` | `resize()` forza le dimensioni e distorce l'immagine | `scaleDown(width, height)` preserva aspect ratio e scala solo se necessario |
| Dimenticare `Http::fake()` nei test | L'observer chiama NASA API reale → test lenti o falliti | `Http::fake()` in setUp() di ogni test che crea CorpoCeleste |
| Dimenticare eager loading nelle show | **N+1 problem**: se una vista chiama `$missione->corpiCelesti` in un loop, fai N query extra | `Missione::with('corpiCelesti.categoria')->findOrFail($id)` |
| Usare `->get()` invece di `->paginate()` | Su migliaia di record, carica tutto in memoria | `->paginate(20)` con `->withQueryString()` e `{{ $records->links() }}` nella vista |
| `@if` senza `@endif` in Blade | Sintassi Blade incompleta → errore 500 silenzioso | Controllare sempre che ogni `@if`/`@foreach` abbia la sua chiusura |
| Dimenticare `->constrained()` nelle migration FK | La colonna viene creata senza FK reale | `$table->foreignId('categoria_id')->constrained()->cascadeOnDelete()` |
| Mantenere Inertia quando non serve | Dipendenze inutili, complessità, possibili conflitti di routing | Se la SPA è standalone (comunica via API), Inertia non serve — rimuovilo |
| `$fillable` senza `nasa_id` | Mass assignment exception quando crei/aggiorni CorpoCeleste | Aggiungere TUTTI i campi che ricevono dati da request/API in `$fillable` |

---

*Documento generato il 09/07/2026 — Astralis v13.18*
