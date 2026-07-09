# Guida all'Esame — Astralis

## 1. Identikit del Progetto

| Cosa | Dettaglio |
|------|-----------|
| **Cos'è** | Catalogo web di corpi celesti (pianeti, stelle, galassie, nebulose, lune, comete, asteroidi) |
| **Backend** | Laravel 13, PHP 8.x |
| **Database** | MySQL (porta 3307) |
| **Frontend guest** | React 19 + Vite (SPA standalone) |
| **Frontend admin** | Blade + Tailwind + Alpine.js (CDN) |
| **Animazioni** | framer-motion |
| **Test** | PHPUnit (130 test) + Vitest (88 test) |
| **Tema** | Dark: sfondo `#0A0A1A`, card `#111128`, primario `#22D3EE` |

**Architettura chiave**: dual-rendering. Gli utenti non autenticati vedono una React SPA che comunica via API JSON. Gli admin vedono pagine Blade renderizzate lato server. Le due "facce" condividono lo stesso database ma hanno percorsi di esecuzione completamente separati.

---

## 2. Database e Modelli

### Schema Entità-Relazioni

```
CATEGORIA ──1:N── CORPO_CELESTE ──1:N── GALLERIA_CORPO
                      │                  (immagini multiple)
                      │
                      ├──1:N── CURIOSITA
                      │
                      └──N:N── MISSIONE
                               (pivot: tipo_esplorazione, anno_arrivo)
```

### Tabella: `categorie`

| Colonna | Tipo | Note |
|---------|------|------|
| id | bigint, PK | auto-increment |
| nome | varchar(255) | usato per slug |
| slug | varchar(255), UNIQUE | generato automaticamente da spatie/laravel-sluggable |
| icona | varchar(255) | nullable |
| descrizione | text | nullable |
| colore | varchar(20) | esadecimale (#22D3EE) |

**Relazioni**: `HasMany` → CorpoCeleste

### Tabella: `corpi_celesti`

| Colonna | Tipo | Note |
|---------|------|------|
| id | bigint, PK | |
| nome | varchar(255) | nome inglese (es. "Earth") |
| nome_it | varchar(255) | nome italiano (es. "Terra"), nullable |
| slug | varchar(255), UNIQUE | da sluggable |
| categoria_id | bigint, FK → categorie | ON DELETE CASCADE |
| immagine | varchar(255) | URL remoto o path locale |
| immagine_utente | boolean, default false | TRUE = l'admin ha impostato manualmente (NASA Import non sovrascrive) |
| nasa_id | varchar(50) | ID NASA Image API, per dedup |
| descrizione | text | |
| tipo | varchar(50), INDEX | "Pianeta roccioso", "Gigante gassoso", ecc. |
| massa_kg | varchar(50) | stored as string (numeri enormi) |
| distanza_km | varchar(50) | stored as string |
| diametro_km | varchar(50) | stored as string |
| gravita | decimal(10,4) | m/s² |
| temperatura | decimal(10,2) | Kelvin |
| periodo_orbitale | decimal(20,6) | giorni |
| scopritore | varchar(100) | nullable |
| anno_scoperta | integer | nullable |
| in_evidenza | boolean, default false, INDEX | per homepage "In Evidenza" |

**Cast**: `gravita` → decimal, `temperatura` → decimal, `periodo_orbitale` → decimal, `in_evidenza` → boolean, `immagine_utente` → boolean

**Accessors**:
- `getNomeDisplayAttribute()` → `$this->nome_it ?? $this->nome` (fallback italiano)
- `getImmagineUrlAttribute()` → Storage URL o URL diretto se esterno

**Relazioni**:
- `BelongsTo` → Categoria
- `HasMany` → GalleriaCorpo (ordinato per `ordine`)
- `HasMany` → Curiosita (ordinato per `created_at` desc)
- `BelongsToMany` → Missione (via pivot `corpo_celeste_missione`)

### Tabella: `galleria_corpi`

| Colonna | Tipo | Note |
|---------|------|------|
| id | bigint, PK | |
| corpo_celeste_id | bigint, FK → corpi_celesti | CASCADE |
| percorso | varchar(255) | URL remoto o path locale |
| didascalia | varchar(255) | da NASA (title) |
| crediti | varchar(255) | da NASA (photographer) |
| ordine | integer, default 0, INDEX | per ordinamento inline |

**Accessors**: `getPercorsoUrlAttribute()` → Storage URL o URL diretto

### Tabella: `missioni`

| Colonna | Tipo | Note |
|---------|------|------|
| id | bigint, PK | |
| nome | varchar(255) | |
| slug | varchar(255), UNIQUE | |
| logo | varchar(255) | path locale (upload admin) |
| agenzia | varchar(100) | NASA, ESA, SpaceX... |
| data_lancio | date | |
| durata_giorni | integer | |
| stato | varchar(50), default "Completata" | Completata / In corso / Pianificata |
| descrizione | text | |
| sito_web | varchar(255) | |

**Relazioni**: `BelongsToMany` → CorpoCeleste (via pivot)

### Tabella: `curiosita`

| Colonna | Tipo | Note |
|---------|------|------|
| id | bigint, PK | |
| corpo_celeste_id | bigint, FK → corpi_celesti | CASCADE |
| titolo | varchar(255) | |
| descrizione | text | NOT NULL |
| fonte | varchar(255) | nullable (URL) |

### Tabella Pivot: `corpo_celeste_missione`

| Colonna | Tipo | Note |
|---------|------|------|
| corpo_celeste_id | FK | UNIQUE composta |
| missione_id | FK | UNIQUE composta |
| tipo_esplorazione | varchar(50) | sorvolo, orbiter, atterraggio |
| anno_arrivo | year(4) | |

**Perché una tabella pivot con dati extra?** Perché la relazione N:N non è semplice: una missione può visitare più corpi e un corpo può essere visitato da più missioni. La pivot conserva metadati specifici della relazione (anno_arrivo, tipo_esplorazione) che non appartengono né a Missione né a CorpoCeleste.

### Tabella: `users` (estesa)

Colonne Laravel standard + `is_admin` (boolean, default false). L'admin demo (`admin@astralis.it` / `password`) ha `is_admin = true`. I nuovi utenti registrati hanno `is_admin = false`.

---

## 3. Routing — La Mappa delle URL

### Tripartizione dei file route

Laravel carica tre file di route, ciascuno con un middleware stack diverso:

```
routes/
  web.php      ← session, cookie, CSRF (per Blade admin)
  api.php      ← api, rate limiting (per React SPA guest)
  auth.php     ← session, guest, auth (per Breeze)
```

### `routes/web.php` — Admin e Catch-all

Due macro-blocchi:

1. **Route pubbliche** (`/`, `/dashboard` → redirect `/admin`, `/profile`)
2. **Route admin** (prefisso `/admin`): 6 CRUD resource + NASA Import + rotte custom

**Route resource** per ogni entità:

```
Route::resource('/admin/categorie', CategoriaController::class)
Route::resource('/admin/corpi-celesti', CorpoCelesteController::class)
Route::resource('/admin/curiosita', CuriositaController::class)
Route::resource('/admin/galleria', GalleriaController::class)
Route::resource('/admin/missioni', MissioneController::class)
```

**La Catch-all SPA** (ultima riga):
```php
Route::get('/{any}', fn () => view('guest'))->where('any', '.*');
```
Questa route cattura TUTTE le URL non gestite sopra e le passa alla React SPA. È l'ultima nel file perché Laravel le prova in ordine: se nessuna route specifica matcha, arriva qui.

**Perché una catch-all e non Inertia?** Inertia è stato rimosso (Fase 12.2). La SPA è completamente indipendente, montata su `guest.blade.php` con `<div id="guest-root">`. Comunica col backend solo via API, non ha accesso diretto a route/session lato server.

### `routes/api.php` — 10 Endpoint JSON Pubblici

Nessuna autenticazione. Usano Route Model Binding con slug.

| Metodo | URI | Filtri |
|--------|-----|--------|
| GET | `/api/corpi-celesti` | categoria, tipo, search, in_evidenza, per_page (max 100) |
| GET | `/api/corpi-celesti/{slug}` | eager loading relazioni |
| GET | `/api/corpi-celesti/{id}/simili` | stessa categoria, max 4 |
| GET | `/api/categorie` | withCount corpi |
| GET | `/api/categorie/{slug}` | con corpi celesti |
| GET | `/api/missioni` | agenzia, stato |
| GET | `/api/missioni/{slug}` | con corpi |
| GET | `/api/curiosita` | con corpo celeste |
| GET | `/api/galleria` | con corpo celeste, ordinato |
| GET | `/api/dashboard/stats` | conteggi totali |

### `routes/auth.php` — Breeze Standard

Tutte le rotte di autenticazione: login, register, password reset, email verification, logout.

---

## 4. Admin Blade — CRUD e Dashboard

### Pattern Comune (stesso per tutte e 5 le entità)

Ogni controller admin segue la struttura standard di Laravel Resource Controller:

1. **index()** — lista paginata (20 per pagina) con barra di ricerca
2. **create()** — mostra form di creazione
3. **store(Request)** — valida e salva, redirect a index con messaggio success
4. **show($id)** — dettaglio singolo
5. **edit($id)** — mostra form di modifica precompilato
6. **update(Request, $id)** — valida e aggiorna, redirect a index
7. **destroy($id)** — elimina (con protezioni), redirect a index

### Differenze tra entità

| Entità | Particolarità |
|--------|---------------|
| **Categoria** | Delete bloccata se `$categoria->corpiCelesti()->exists()` (messaggio errore + redirect) |
| **CorpoCeleste** | Immagine tramite URL (non upload). Pulsante "Cerca su NASA" che POST a `suggestNome()`. `UpdateCorpoCelesteRequest` imposta `immagine_utente=true` se immagine fornita |
| **Missione** | Upload logo con Intervention Image `scaleDown(300x300)`. Badge stato colorato. Delete bloccata se ha corpi associati |
| **Curiosità** | Parametro route `{curiositum}` (singolare latino — attenzione all'esame!). Route completa con show |
| **Galleria** | Upload immagini `scaleDown(1200x1200)`. Ordinamento inline con pulsanti su/giù via POST a `/ordine`. Placeholder "Immagine non disponibile" su errori di caricamento |

### Dashboard

`DashboardController::index()` esegue 6 query:
- Conteggi totali (corpi, categorie, missioni, curiosità)
- Ultimi 5 corpi creati
- Corpi per categoria (per grafico donut)
- Corpi per tipo (per grafico barre)
- Missioni per stato (per grafico barre)

La vista `dashboard.blade.php` contiene 3 canvas Chart.js (CDN) caricati via `@push('scripts')`. Tema dark configurato con `Chart.defaults.color`.

### Master Layout

`resources/views/admin/layouts/app.blade.php`:
- Sidebar con link a tutte le entità + NASA Import + Dashboard
- Alpine.js caricato da CDN unpkg
- `[x-cloak]` style per prevenire FOUC (Flash of Unstyled Content)
- Palette admin via classi Tailwind `admin-*`

---

## 5. API REST

### API Resources

Le 5 classi `app/Http/Resources/` trasformano i modelli Eloquent in JSON. Ogni resource espone solo i campi necessari al frontend e gestisce eager loading.

**Pattern**: `CorpoCelesteResource` espone `nome_display` (accessor `nome_it ?? nome`) così il frontend React vede sempre il nome italiano se disponibile.

### Filtri in `Api\CorpoCelesteController`

```php
// Esempio di filtro condizionale con when()
$query->when($request->categoria, fn($q, $v) => $q->whereHas('categoria', fn($q) => $q->where('slug', $v)))
     ->when($request->tipo, fn($q, $v) => $q->where('tipo', $v))
     ->when($request->search, fn($q, $v) => $q->where(function($q) use ($v) {
         $q->where('nome', 'like', "%{$v}%")
           ->orWhere('descrizione', 'like', "%{$v}%");
     }))
     ->when($request->in_evidenza, fn($q) => $q->where('in_evidenza', true))
     ->paginate(min($request->per_page ?? 12, 100));
```

Nota: `per_page` è limitato a 100 per prevenire abuso (Fase 12.4).

### Eager Loading

Tutte le show caricano le relazioni per evitare N+1 queries:
```php
CorpoCeleste::with(['categoria', 'galleria', 'curiosita', 'missioni'])
    ->where('slug', $slug)
    ->firstOrFail();
```

---

## 6. React SPA Guest

### Entry Point

`resources/js/guest/main.jsx` monta `<App />` su `<div id="guest-root">` (definito in `guest.blade.php`).

```jsx
// main.jsx
import App from './App';

createRoot(document.getElementById('guest-root')).render(<App />);
```

### Router (App.jsx)

```jsx
<BrowserRouter>
    <Navbar />
    <ErrorBoundary>
        <Routes>
            <Route path="/" element={<HomePage />} />
            <Route path="/corpi-celesti" element={<CorpiLista />} />
            <Route path="/corpi-celesti/:slug" element={<CorpoDettaglio />} />
            <Route path="/confronta" element={<Comparatore />} />
            <Route path="*" element={<NotFound />} />
        </Routes>
    </ErrorBoundary>
    <Footer />
</BrowserRouter>
```

### Flusso dati

```
Pagine → apiClient.js (axios) → API Laravel → Database
                             ↕
                       JSON response
                             ↕
                  Pagina aggiorna stato (useState/useEffect)
```

`apiClient.js` esporta 6 funzioni:
- `fetchCorpiCelesti(params)` — GET `/api/corpi-celesti`
- `fetchCategorie()` — GET `/api/categorie`
- `fetchCorpoCeleste(slug)` — GET `/api/corpi-celesti/{slug}`
- `fetchSimili(id)` — GET `/api/corpi-celesti/{id}/simili`
- `fetchMissioni(params)` — GET `/api/missioni`
- `fetchDashboardStats()` — GET `/api/dashboard/stats`

### Pagine React

| Pagina | Funzionalità |
|--------|--------------|
| **HomePage** | Hero + SolarSystem animato + 6 corpi in evidenza + stats + CTA |
| **CorpiLista** | Griglia filtrata (categoria, tipo, search), paginazione "Carica altri" |
| **CorpoDettaglio** | Metriche scientifiche, LightboxGalleria, TimelineMissioni, curiosità, simili |
| **Comparatore** | Due dropdown, tabella confronto 7 campi, pre-fill via URL params |
| **NotFound** | 404 con icona Telescope, link home |

**Nota**: ogni pagina imposta `document.title` via `useEffect` per SEO (vedi sezione 11).

### Componenti

| Componente | Ruolo |
|------------|-------|
| **Navbar** | Logo + link navegazione con active state |
| **Footer** | Branding + tagline |
| **SolarSystem** | Sole + 8 pianeti orbitanti (seno/coseno via framer-motion) |
| **CorpoCard** | Card con gradiente categoria, fallback immagine, metadati |
| **CategoriaBadge** | Badge colorato (8 colori, uno per categoria) |
| **SearchBar** | Input ricerca con debounce |
| **LightboxGalleria** | Griglia thumbnail + lightbox fullscreen |
| **TimelineMissioni** | Scrolling orizzontale con badge stato |
| **ErrorBoundary** | Catch errori rendering, fallback UI |

### Error Boundary

Class component React che avvolge `<Routes>`:
```jsx
class ErrorBoundary extends React.Component {
    state = { hasError: false };
    static getDerivedStateFromError() { return { hasError: true }; }
    componentDidCatch(error, info) { console.error(error, info); }
    render() {
        if (this.state.hasError) {
            return <FallbackUI />; // tema dark + AlertTriangle + link home
        }
        return this.props.children;
    }
}
```

---

## 7. NASA Integration

### Architettura

```
Admin clicca "Importa da NASA"
         │
         ▼
NasaImportController@import($corpoCeleste)
         │
         ▼
NasaImageService::importForBody($corpo, $galleryCount=5, $force=false, $updateDescription=false)
         │
         ▼
1. searchNasa($query) — cerca su NASA Image API
2. pickImageUrl($item) — sceglie URL migliore
3. Salva URL remoto in corpoCeleste.immagine
4. Crea N record in galleria_corpi con URL remoti
```

### `NasaImageService` — Metodi pubblici

| Metodo | Cosa fa |
|--------|---------|
| `searchNasa(query, extraFallbacks)` | Chiama NASA API con timeout 30s, retry 2. Prova query originale → senza apostrofi → extra fallback. Restituisce `['success', 'items', 'used_query']` |
| `extractMetadata(item)` | Estrae `nasa_id`, `title`, `photographer`, `description`, `keywords` dal JSON NASA |
| `pickImageUrl(item)` | Sceglie URL: `alternate` (~medium.jpg) → `preview` (~thumb.jpg) → `canonical` (~orig.jpg come ultima spiaggia). Salta link video (`render=video`) |
| `importForBody(corpo, galleryCount, force, updateDescription)` | Import completo. Salta se immagine già presente (salvo force=true). Non sovrascrive mai `immagine_utente=true`. Deduplica galleria (stesso percorso + corpo). Restituisce report |
| `importAll(galleryCount, force, updateDescription)` | Itera tutti i corpi. `set_time_limit(300)`. Restituisce report aggregato |

### Fallback Query per Apostrofi

```php
// Esempio: "Earth's Moon" → prova "Earth Moon", poi "Moon"
$cleaned = str_replace(["'s", "'", "`", "’"], "", $query);
if ($cleaned !== $query) {
    // prova query senza apostrofi
}
```

### WordMapService

Traduce nomi italiani in inglese parola per parola per cercare su NASA API:

```php
"Nebulosa della Carena" → parses ["Nebulosa", "della", "Carena"]
                         → traduce ["Nebulosa" => "Nebula", "Carena" => "Carina"]
                         → query finale: "Carina Nebula"
```

Ha ~70+ entry e un metodo `guessEnglishName()` che cerca match nei titoli NASA.

### CorpoCelesteObserver

`CorpoCelesteObserver::created()` chiama automaticamente `importForBody()` quando un nuovo CorpoCeleste viene creato. **Skip in ambiente testing**:
```php
if (app()->environment('testing')) { return; }
```

### CLI Commands

| Comando | Opzioni |
|---------|---------|
| `php artisan astralis:fetch-nasa` | `--force`, `--gallery=N` (default 5), `--update-description` |
| `php artisan astralis:gallery --fix` | `--check`, `--clean`, `--sync`, `--fix`, `--dry-run` |

---

## 8. Autenticazione e Autorizzazione

### Breeze su Blade (non Inertia)

Dopo la rimozione di Inertia (Fase 12.2), le pagine auth sono state convertite in Blade puro con tema scuro. I controller auth sono stati riscritti per usare `view()` e `redirect()` invece di `Inertia::render()`.

**Login/Logout**: Inertia è stato sostituito con `Inertia::location()` per forzare full page reload durante il login/logout (evita conflitti con la SPA).

### Policy (5 entità)

Tutte le Policy seguono lo stesso pattern:

```php
class CategoriaPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->is_admin) return true;   // admin bypassa tutto
        return null;                          // non-admin → controlla metodo specifico
    }

    public function viewAny(User $user): bool { return true; }  // lettura OK per tutti
    public function view(User $user, Categoria $categoria): bool { return true; }
    public function create(User $user): bool { return false; }  // scrittura NO
    public function update(User $user, Categoria $categoria): bool { return false; }
    public function delete(User $user, Categoria $categoria): bool { return false; }
}
```

**Perché `before()` con `?bool`?** Perché se restituisce `true` bypassa tutti i metodi (admin può tutto). Se restituisce `null` Laravel continua col metodo specifico (non-admin va al controllo individuale). Se restituisse `false` bloccherebbe TUTTO, anche `viewAny`.

### Gate `admin`

Definito in `AuthServiceProvider`:
```php
Gate::define('admin', fn (User $user) => $user->is_admin);
```

Usato da `NasaImportController` (che non ha una Policy dedicata):
```php
Gate::authorize('admin');
```

### Flusso di autorizzazione

1. Utente logga → Breeze crea sessione
2. Visita `/admin/categorie` → middleware `auth` + `verified`
3. `CategoriaController@index` chiama `$this->authorize('viewAny', Categoria::class)`
4. Laravel cerca `CategoriaPolicy@viewAny` → restituisce `true`
5. Admin vede la pagina
6. Se utente non-admin tenta `POST /admin/categorie` → `CategoriaPolicy@create` restituisce `false` → 403

**Domanda d'esame**: "Un utente non-admin può vedere le categorie?" Sì, `viewAny` e `view` restituiscono `true` per tutti gli autenticati. Solo create/update/delete sono riservate agli admin.

---

## 9. Image Handling

### Due modalità

| Entità | Metodo | Libreria |
|--------|--------|----------|
| CorpoCeleste | URL remoto (nessun upload) | — |
| Missione | Upload file → `scaleDown(300x300)` | Intervention Image v4 |
| Galleria | Upload file → `scaleDown(1200x1200)` | Intervention Image v4 |

### Intervention Image v4 — SENZA Facade

**Criticale per l'esame!** Intervention Image v4 ha rimosso la facade `Image`. Si usa così:

```php
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

$manager = new ImageManager(new Driver());
$image = $manager->read($file->getPathname());  // o decodePath(), decodeBinary()
$image->scaleDown(width: 800, height: 800);      // NON resize() — scaleDown() mantiene aspect ratio
$image->save($path);
```

**Perché `scaleDown()` e non `resize()`?** `scaleDown()` ridimensiona solo se l'immagine è più grande delle dimensioni specificate, preservando l'aspect ratio. `resize()` forza le dimensioni e distorce.

---

## 10. Testing

### PHPUnit — 130 test, 335 assertion

```
tests/
├── Unit/
│   ├── ExampleTest.php
│   └── NasaImageServiceTest.php          (26 test — service NASA)
├── Feature/
│   ├── ExampleTest.php
│   ├── ProfileTest.php
│   ├── Admin/
│   │   ├── CategoriaCrudTest.php         (14 test)
│   │   ├── CorpoCelesteCrudTest.php      (13 test)
│   │   ├── CuriositaCrudTest.php         (10 test)
│   │   ├── GalleriaCrudTest.php          (9 test)
│   │   └── MissioneCrudTest.php          (13 test)
│   ├── Api/
│   │   ├── CategoriaApiTest.php
│   │   ├── CorpoCelesteApiTest.php
│   │   ├── CuriositaApiTest.php
│   │   ├── DashboardApiTest.php
│   │   ├── GalleriaApiTest.php
│   │   └── MissioneApiTest.php
│   └── Auth/                             (6 file — Breeze standard)
```

### Pattern essenziali per i test

**RefreshDatabase**: ogni test parte con DB SQLite in memoria pulito.

**Http::fake()**: mocka NASA API. Obbligatorio in ogni test che crea CorpoCeleste (altrimenti l'observer chiama API vera).

```php
protected function setUp(): void
{
    parent::setUp();
    Http::fake();  // tutte le chiamate HTTP → 200 con body vuoto
}
```

**Observer skip in testing**:
```php
// In CorpoCelesteObserver.php
if (app()->environment('testing')) {
    return;  // non chiamare NASA durante i test
}
```

### Vitest — 88 test

```
resources/js/guest/test/
├── setup.js                     (mock IntersectionObserver)
├── apiClient.test.js            (12 test)
├── CategoriaBadge.test.jsx      (5 test)
├── Comparatore.test.jsx         (10 test)
├── CorpiLista.test.jsx          (12 test)
├── CorpoCard.test.jsx           (10 test)
├── CorpoDettaglio.test.jsx      (16 test)
├── HomePage.test.jsx            (11 test)
├── LightboxGalleria.test.jsx    (8 test)
└── SolarSystem.test.jsx         (4 test)
```

Configurazione in `vitest.config.js`: environment `jsdom`, `globals: true`, setup files.

---

## 11. SEO e Robustezza

### SEO Meta Tags

Ogni pagina React imposta il titolo della pagina via `useEffect`:

```jsx
useEffect(() => {
    document.title = "Astralis — Catalogo di Corpi Celesti";  // HomePage
    document.title = "Corpi Celesti — Astralis";               // CorpiLista
    document.title = `${nome} — Astralis`;                     // CorpoDettaglio (dinamico)
    document.title = "Confronta Pianeti — Astralis";           // Comparatore
    document.title = "Pagina non trovata — Astralis";          // NotFound
}, []);
```

Per CorpoDettaglio, il titolo ha un fallback iniziale ("Caricamento... — Astralis") e si aggiorna quando i dati arrivano dall'API.

### Error Boundary

Wrapper globale in `App.jsx` che cattura errori di rendering React. Se un componente crasha, l'utente vede un fallback UI con:
- Icona AlertTriangle (lucide-react)
- "Qualcosa è andato storto"
- Bottone "Torna alla Home"

### Search/Filtri Admin

Tutte le index admin hanno filtri `?search=` (e filtri specifici per entità) usando il pattern Laravel `when()`:
```php
$categorie->when($request->search, fn($q, $v) => $q->where('nome', 'like', "%{$v}%"));
```

`withQueryString()` preserva i parametri durante la paginazione.

---

## 12. Domande Possibili all'Esame

### 1. Perché React SPA e non Inertia?

Inertia è stato installato inizialmente con Breeze, ma è stato rimosso (Fase 12.2) perché non necessario. La SPA React standalone (che comunica via API) è più pulita: separazione netta tra frontend guest e backend admin, minori dipendenze, e si avvicina di più a uno scenario reale (React + API Laravel).

**Risposta**: Inertia è stato rimosso perché il frontend guest è una SPA React standalone che comunica via API REST JSON. Inertia sarebbe stato un livello intermedio inutile: aggiungeva complessità (middleware, dipendenze npm/composer, JSX pages) senza benefici, dato che le pagine guest non hanno bisogno di accesso diretto a session/flash lato server.

### 2. Come funziona la catch-all `/{any}`?

L'ultima route in `web.php` cattura tutte le URL non gestite dalle route precedenti. Laravel le prova in ordine di definizione: prima le route admin e auth, poi la catch-all. Quando matcha, rende `guest.blade.php` che monta la React SPA. Il routing lato client (react-router-dom) gestisce poi 404 e route valide.

**Perché non va in conflitto con le route admin?** Perché le route admin sono definite PRIMA della catch-all. Quando visiti `/admin/categorie`, Laravel matcha la route resource PRIMA di arrivare a `/{any}`.

### 3. Differenza tra Policy e Gate?

| Policy | Gate |
|--------|------|
| Associata a un modello (es. CategoriaPolicy) | Singola autorizzazione (es. 'admin') |
| Più metodi (viewAny, view, create, update, delete) | Unica closure |
| Registrata in AuthServiceProvider | Definita in AuthServiceProvider |
| Usata con `$this->authorize()` nei controller | Usata con `Gate::authorize()` |

**Esempio**: Policy per CRUD entità, Gate per controllare se un utente è admin (usato dal NASA Import che non ha un modello specifico).

### 4. Perché `{curiositum}` come parametro route?

"Curiosita" in latino è neutro plurale della seconda declinazione. Il singolare è "curiositum". Laravel Resource Route richiede un parametro singolare. Quindi: `Route::resource('/admin/curiosita', CuriositaController::class)` genera automaticamente `{curiositum}`.

### 5. Cosa succede se cancello una categoria con corpi associati?

Il `destroy()` controlla: `if ($categoria->corpiCelesti()->exists())` → redirect con messaggio errore "Impossibile eliminare: ci sono X corpi celesti associati". Il record NON viene eliminato. Per eliminare, l'admin deve prima riassegnare o eliminare i corpi celesti associati.

### 6. Come si prevengono duplicati nell'import NASA?

`NasaImageService::importForBody()` controlla: `GalleriaCorpo::where('percorso', $url)->where('corpo_celeste_id', $corpo->id)->exists()`. Se esiste già, skippa. Inoltre `immagine_utente=true` impedisce la sovrascrittura dell'immagine principale anche con `--force`.

### 7. Problema Windows con SSL?

Windows non ha i certificati CA root configurati come Linux/macOS. `Http::withoutVerifying()` bypassa la verifica SSL. È usato solo in ambiente `local`/`testing`:

```php
$request = Http::timeout(30)->retry(2);
if (app()->environment('local', 'testing')) {
    $request = $request->withoutVerifying();
}
```

### 8. Come si passa da una pagina admin alla SPA guest?

Il link "Torna al sito" nella sidebar admin punta a `route('home')` che è `/`. La catch-all route renderizza `guest.blade.php` che monta la React SPA. Funziona perché è un URL diverso e il browser fa un full page reload.

### 9. Perché `varchar` per massa/distanza/diametro?

I valori astronomici sono enormi (es. massa del Sole = 1.989 × 10³⁰ kg). Usare `decimal` o `bigint` causerebbe overflow o problemi di precisione. `varchar` permette di salvare stringhe formattate ("1.989 × 10³⁰") che vengono visualizzate così come sono.

### 10. Come funziona l'ordinamento inline della galleria?

`POST /admin/galleria/{id}/ordine` con parametro `direzione` (`su`/`giù`). Il controller scambia `ordine` con il record adiacente:

```php
$adiacente = GalleriaCorpo::where('corpo_celeste_id', $item->corpo_celeste_id)
    ->where('ordine', $direzione === 'su' ? '<' : '>', $item->ordine)
    ->orderBy('ordine', $direzione === 'su' ? 'desc' : 'asc')
    ->first();
// scambia i valori di ordine
```

### 11. React SPA fa SSR? No.

La SPA è renderizzata interamente lato client. Il server invia un HTML vuoto con `<div id="guest-root">`, poi React monta e fa le chiamate API. Non c'è Server-Side Rendering. I meta tag SEO sono limitati al `document.title`.

### 12. Cos'è `nome_display`?

Un accessor Eloquent sul modello `CorpoCeleste`:
```php
public function getNomeDisplayAttribute(): string
{
    return $this->nome_it ?? $this->nome;
}
```
Esposto nelle API via `CorpoCelesteResource`. Il frontend React usa `nome_display` invece di `nome` per mostrare nomi italiani quando disponibili.

---

## 13. Comandi che devo ricordare

```bash
# Test
php artisan test                          # Suite completa backend (130 test)
php artisan test tests/Unit/...           # Solo unit test
php artisan test tests/Feature/Api/       # Solo API
php artisan test tests/Feature/Admin/     # Solo admin CRUD
npm test                                  # Vitest frontend (88 test)

# Build
npx vite build                            # Build produzione frontend

# NASA Import
php artisan astralis:fetch-nasa           # Import immagini NASA per tutti
php artisan astralis:fetch-nasa --force   # Sovrascrivi esistenti
php artisan astralis:fetch-nasa --gallery=5  # 5 immagini galleria per corpo

# Manutenzione galleria
php artisan astralis:gallery --check      # Solo report
php artisan astralis:gallery --fix        # Ripara immagini mancanti
php artisan astralis:gallery --dry-run    # Simula senza modificare

# DB
php artisan migrate                       # Applica migrazioni
php artisan migrate:fresh --seed          # Reset + seed

# Utility
php artisan storage:link                  # Crea symlink storage
php artisan make:test NomeTest --unit     # Nuovo unit test
php artisan make:model Nome -mf           # Nuovo modello con migration + factory

# Graph (knowledge graph del progetto)
npx graphify update .                     # Ricostruisce grafo (dopo modifiche)

# Serve
php artisan serve                         # Backend (porta 8000)
npm run dev                               # Frontend Vite (porta 5173)
```

---

## 14. Timeline del Progetto (per domande sul processo)

| Fase | Cosa |
|------|------|
| **Fase 0** | Setup Laravel + Breeze + React |
| **Fase 1** | Database, modelli, relazioni, seeders |
| **Fase 2** | CRUD Admin Blade per tutte le entità |
| **Fase 3** | API REST (10 endpoint) |
| **Fase 4-5** | React SPA guest (homepage, lista, dettaglio, comparatore, sistema solare) |
| **Fase 6** | Bugfix orbite, NASA Import backoffice |
| **Fase 7** | Intervention Image v4 migration, Force Import All |
| **Fase 8** | NasaImageService, CLI fetch-nasa, multi-immagine |
| **Fase 9** | URL remoti, nome_it, WordMapService, auto-suggest |
| **Fase 10** | Tema scuro auth, Register link, paginazione |
| **Fase 11** | Inertia→Blade transizione, dedup NASA, galleria cleanup |
| **Fase 12** | Authorization (Policy + Gates), rimozione Inertia, FormRequest |
| **Wave 1-4** | Refactoring P2: WordMap, aria-label, CSS hover, Tailwind classi |
| **Fase 13** | Testing completo (130 test PHPUnit + 88 Vitest) |
| **Fase 14** | 10 bug critici fixati, dashboard Chart.js, dipendenze pulite |
| **Fase 15** | Admin CRUD test (4 file), paginazione categorie, show curiosità, search/filter admin, SEO meta tags, Error Boundary |

---

## 15. Debugging — Problemi già incontrati (e risolti)

| Problema | Causa | Fix |
|----------|-------|-----|
| `cURL error 60` su Windows | Certificati SSL mancanti | `Http::withoutVerifying()` solo in local/testing |
| `Call to undefined method read()` | Intervention Image v3→v4 API change | `decodePath()` invece di `read()`, `scaleDown()` invece di `resize()` |
| `bootstrap/cache/` fail su Git Bash | Windows permessi | `cmd //c 'rmdir /s /q bootstrap\cache' && cmd //c 'mkdir bootstrap\cache'` |
| Inertia routing verso pagine Blade | `<Link>` Inertia intercetta click nativi | `<a href>` per navigazione fuori SPA |
| N+1 query su Missione show | Missing eager loading | Aggiunto `->with('corpiCelesti.categoria')` |
| NaN km su CorpoCard | `formatDistance()` su valori null/undefined | Aggiunto `isNaN` guard |
| NASA ricerca fallisce per "Halley's Comet" | Apostrofo nella query | Fallback automatico: prova senza apostrofi, poi "comet" |
| `@endif` mancanti in Blade | Errori di copia/incolla durante refactoring | Aggiunti `@endif` mancanti in 3 file |
