# Cheat Sheet Esame Astralis

> Riferimento rapido per l'esame finale. Combinazione di traccia, definizioni, architettura e live coding.

---

## 1. Script di Apertura (5 min)

Ordine consigliato per dimostrare il progetto:

1. **Login** → `admin@astralis.it` / `password` → tema dark Breeze
2. **Dashboard** → grafici Chart.js (donut categorie, barre tipi, barre missioni)
3. **Corpi Celesti** → lista con filtri, ricerca, paginazione → apri "Terra" → 6 metriche, galleria lightbox, curiosità, timeline missioni, corpi simili
4. **Categorie** → badge colorati, conteggio corpi associati
5. **Missioni** → timeline orizzontale, badge stato (Completata/In corso/Pianificata)
6. **NASA Import** → bottone "Importa da NASA" → immagini reali
7. **Guest React** → `localhost:5173` → sistema solare animato → griglia corpi → dettaglio con lightbox → comparatore

---

## 2. Traccia → Come l'ho Implementato

Basato su `docs/progetto-finale.md`.

### Parte 1 — Backoffice Laravel

| # | Requisito traccia | Realizzato |
|---|---|---|
| 1 | Backoffice con autenticazione Breeze | Breeze Blade puro (Inertia rimosso). Route protette da middleware `auth`. Login, register, profilo, reset password — tema dark `#0A0A1A` |
| 2 | CRUD entità principale | CorpoCeleste: 7 metodi controller (index, create, store, show, edit, update, destroy). Form 6 sezioni |
| 3 | Relazioni 1-N o N-N | 5 entità, 3 tipi: BelongsTo/HasMany (1-N), BelongsToMany (N-N con pivot `corpo_celeste_missione`) |
| 4 | CRUD entità secondarie | Categoria, Missione, Curiosità, Galleria — CRUD completo ciascuna |
| 5 | Upload media | Missioni (logo 300px), Galleria (1200px) con Intervention Image v4 `scaleDown()` |
| 6 | Template Blade | Layout master `app.blade.php` con sidebar navigazione, Alpine.js CDN |

### Parte 2 — Guest React

| # | Requisito traccia | Realizzato |
|---|---|---|
| 7 | SPA React guest | React 18 standalone, Vite, 5 pagine (Home, Lista, Dettaglio, Comparatore, 404) |
| 8 | Lista elementi | `CorpiLista.jsx`: griglia card, filtri (categoria, tipo, ricerca), paginazione "Carica altri" |
| 9 | Dettaglio elemento | `CorpoDettaglio.jsx`: 6 metriche, galleria lightbox, curiosità, timeline missioni, simili |
| 10 | Info correlate | Badge categoria, lightbox immagini NASA, timeline missioni, corpi simili |
| 11 | API REST | 10 endpoint JSON pubblici in `routes/api.php`. API Resources, eager loading, filtri query |
| 12 | Test Postman | Endpoint pubblici, JSON response, filtri via query params |

### Extra Wow Factor

- Sistema solare animato (framer-motion, 8 pianeti orbitanti)
- NASA API integration (import automatico immagini reali)
- Comparatore pianeti (7 metriche)
- Dashboard Chart.js (3 grafici)
- CLI commands (`astralis:fetch-nasa`, `astralis:gallery`)
- Error Boundary React
- SEO (`document.title` dinamico)
- 380 test (270 PHPUnit + 110 Vitest)
- WordMapService (IT→EN translation)

---

## 3. Mappa Navigazione

### Backend (Laravel)

| File | Dove |
|---|---|
| Route admin | `routes/web.php` → gruppo `admin` |
| Route API | `routes/api.php` → 10 endpoint |
| Route auth | `routes/auth.php` → Breeze |
| Controllers admin | `app/Http/Controllers/Admin/` (8 file) |
| Controllers API | `app/Http/Controllers/Api/` (6 file) |
| Models | `app/Models/` (5 file) |
| Migrations | `database/migrations/` (8 file) |
| Services | `app/Services/` (NasaImageService, WordMapService) |
| Policies | `app/Policies/` (5 file) |
| Gate admin | `app/Providers/AuthServiceProvider.php` |
| Observer | `app/Observers/CorpoCelesteObserver.php` |
| FormRequest | `app/Http/Requests/` (StoreCorpoCeleste, UpdateCorpoCeleste) |
| Config admin | `config/admin.php` |
| Layout admin | `resources/views/admin/layouts/app.blade.php` |
| Sidebar | `resources/views/admin/partials/_sidebar-nav.blade.php` |

### Frontend (React)

| File | Dove |
|---|---|
| Entry point | `resources/js/guest/main.jsx` |
| Routing | `resources/js/guest/App.jsx` |
| Pages | `resources/js/guest/pages/` (5 pagine) |
| Components | `resources/js/guest/components/` |
| API client | `resources/js/guest/apiClient.js` |
| Custom hooks | `resources/js/guest/hooks/` (useFetch, useDebounce) |
| Vite config | `vite.config.js` (proxy `/api` → `localhost:8000`) |

---

## 4. Risposte alle Domande (20+)

### Architettura

**Q: Dove sono le API?**
→ `routes/api.php`. 10 endpoint GET. Controller in `app/Http/Controllers/Api/`. API Resources per JSON controllato.

**Q: Dove sono le CRUD?**
→ `app/Http/Controllers/Admin/`. Ogni controller ha 7 metodi: index, create, store, show, edit, update, destroy. Route resource in `routes/web.php`.

**Q: Come funziona il routing?**
→ Due mondi: admin (`/admin/*`) gestito da Laravel + Blade; guest (`/*`) gestito da React SPA. Il catch-all `/{any}` in `web.php` passa tutto a `guest.blade.php`.

**Q: Qual è la differenza tra admin e guest?**
→ Admin: Blade + Alpine.js, autenticazione Breeze, CRUD. Guest: React SPA standalone, API REST, animazioni. Comunicano solo via API.

### Auth & Authorization

**Q: Come funziona l'autenticazione?**
→ Laravel Breeze. Route protette da middleware `auth`. Login, register, profilo, reset password — tutto Blade. Admin demo: `admin@astralis.it` / `password`.

**Q: Come funziona l'autorizzazione?**
→ Tre livelli: (1) middleware `auth` sulle route. (2) 5 Policy (una per entità) con metodo `before()` che bypassa tutto per admin. (3) Gate `admin` in `AuthServiceProvider` per controller senza policy.

**Q: Policy vs Gate?**
→ Policy: gruppo di permessi su un modello (es. CategoriaPolicy → viewAny, create, update, delete). Gate: singola azione (es. Gate `admin`). Policy si usa con `$this->authorize('create', Categoria::class)`. Gate con `Gate::authorize('admin')`.

**Q: Come funziona il pattern `before()` nelle Policy?**
→ `before()` restituisce `?bool`. Se `true` → bypassa tutto (admin). Se `null` → controlla il metodo specifico (non-admin). Se `false` → blocca tutto.

### Database

**Q: Quali relazioni hai implementato?**
→ 3 tipi: BelongsTo/HasMany (1-N): Categoria→CorpoCeleste, CorpoCeleste→Galleria, CorpoCeleste→Curiosità. BelongsToMany (N-N): CorpoCeleste↔Missione con pivot `corpo_celeste_missione` (tipo_esplorazione, anno_arrivo).

**Q: Come gestisci gli slug?**
→ `spatie/laravel-sluggable`. Trait `Sluggable` nel modello + metodo `getSlugOptions()`. Genera slug dal nome italiano. 3 modelli: Categoria, CorpoCeleste, Missione.

**Q: Cos'è il problema N+1?**
→ Quando in un loop accedi a una relazione senza eager loading. Esempio: 10 missioni × 1 corpo = 11 query. Soluzione: `with(['categoria', 'galleria'])` → 2 query.

**Q: Come fai il seeding?**
→ `database/seeders/`. Fattorie per ogni modello. Seeder con dati reali: 8 categorie, 18 corpi, 10 missioni, 16 immagini, 18 curiosità. `php artisan migrate:fresh --seed`.

### Backend

**Q: Cos'è un FormRequest?**
→ Classe dedicata alla validazione, separata dal controller. `StoreCorpoCelesteRequest` e `UpdateCorpoCelesteRequest`. Regole in `rules()`. Il controller chiama `$this->validate()` o inietta il FormRequest.

**Q: Cos'è un Observer?**
→ Pattern che ascolta eventi Eloquent (created, updated, deleted). `CorpoCelesteObserver::created()` chiama NASA API automaticamente quando un corpo viene creato. Disabilitato in testing con `app()->environment('testing')`.

**Q: Cos'è un Service Layer?**
→ Classe che gestisce logica di business, separata dal controller. `NasaImageService` gestisce ricerca/import/dedup NASA. `WordMapService` traduce IT→EN. Riusabile da controller, CLI, o observer.

**Q: Come funziona l'upload?**
→ Intervention Image v4: `new ImageManager(new Driver())->read($path)`. `scaleDown(1200, 1200)` preserva aspect ratio. Salvato su `storage/app/public/` con `Storage::disk('public')`. `php artisan storage:link` per il symlink.

**Q: CORS come lo gestisci?**
→ Laravel 13 gestisce automaticamente (middleware `HandleCors`). In dev, Vite proxy inoltra `/api` a `localhost:8000`. Nessun `config/cors.php` necessario.

**Q: Cos'è un API Resource?**
→ Trasforma un modello Eloquent in JSON controllato. Espone solo i campi che il frontend serve. Esempio: `CorpoCelesteResource` espone `nome` ma non `nasa_id`.

### Frontend

**Q: Come comunica React con Laravel?**
→ `apiClient.js` (axios) invia richieste a `/api/*`. Vite proxy inoltra a `localhost:8000`. API REST restituiscono JSON. Nessun Inertia (rimosso).

**Q: Come funziona il routing React?**
→ `react-router-dom` con 5 route: `/`, `/corpi-celesti`, `/corpi-celesti/:slug`, `/confronta`, `/*` (404). Laravel catch-all passa tutto a React.

**Q: Cos'è un Error Boundary?**
→ Class component React che cattura errori nei figli. Mostra fallback UI se un componente crasha. In `App.jsx` avvolge `<Routes>`.

**Q: Cos'è React.lazy + Suspense?**
→ Code splitting: il componente viene caricato solo quando serve. `const HomePage = lazy(() => import('./pages/HomePage'))`. `Suspense` mostra un fallback durante il caricamento.

**Q: Come gestisci il fetch dei dati?**
→ Custom hook `useFetch` con `useReducer` + `AbortController`. Gestisce loading, error, e cleanup. `apiClient.js` ha retry logic (2 tentativi).

**Q: Cos'è memo()?**
→ Ottimizzazione: il componente non viene re-renderizzato se le props non cambiano. Usato su `LightboxGalleria` e `Thumbnail` per evitare re-render costosi.

### Testing

**Q: Come testi le API?**
→ PHPUnit + Http::fake(). Ogni test crea dati con factory, chiama l'endpoint, verifica status e JSON response. `Http::fake()` blocca chiamate HTTP reali.

**Q: Perché Http::fake() è essenziale?**
→ L'Observer chiama NASA API ogni volta che un CorpoCeleste viene creato. Senza `Http::fake()`, i test farebbero chiamate reali.

**Q: Come testi React?**
→ Vitest + Testing Library. 110 test: componenti, integrazione API, error handling. `jsdom` environment.

---

## 5. Definizioni PHP (10+)

### Classe e Oggetto
```php
class CorpoCeleste extends Model { ... }  // Classe = blueprint
$corpo = CorpoCeleste::find(1);          // Oggetto = istanza
```
La classe definisce cosa un oggetto può fare. L'oggetto è l'istanza concreta.

### Namespace e Use
```php
namespace App\Models;           // Organizza il codice in cartelle
use Illuminate\Database\Eloquent\Model;  // Importa una classe
```
Namespace = indirizzo della classe. Use = importazione per usarla senza scrivere il percorso completo.

### Trait
```php
trait HasFactory {
    public static function factory() { ... }
}
class CorpoCeleste extends Model {
    use HasFactory;  // Aggiunge metodi del trait al modello
}
```
Trait = codice riutilizzabile che si "include" in una classe. Simile all'ereditarietà ma multipla.

### Type Hints e Return Types
```php
public function categoria(): BelongsTo { ... }   // Return type
public function before(User $user): ?bool { ... } // Param + return
```
Type hints = indica il tipo di parametro. Return type = indica il tipo di valore restituito. `?bool` = null o bool.

### Array Associativo
```php
$stats = [
    'corpi' => CorpoCeleste::count(),  // Chiave => Valore
    'categorie' => Categoria::count(),
];
echo $stats['corpi']; // 18
```
Array con chiavi stringa invece di indici numerici.

### Public, Private, Protected
```php
public $name;      // Accessibile ovunque
protected $email;  // Accessibile nella classe e nelle figlie
private $secret;   // Accessibile solo nella classe
```

### Static Method
```php
CorpoCeleste::count();  // Metodo statico: si chiama sulla classe, non sull'oggetto
```

### Eloquent ORM
```php
CorpoCeleste::with('categoria')->where('tipo', 'Pianeta')->get();
```
ORM = Object-Relational Mapping. Mappa tabelle del DB a classi PHP. Eloquent è l'ORM di Laravel.

### Migration
```php
Schema::create('corpi_celesti', function (Blueprint $table) {
    $table->id();
    $table->string('nome');
    $table->foreignId('categoria_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});
```
Migration = file che definisce la struttura del database. Versionata, eseguibile, reversibile.

### Seeder e Factory
```php
// Factory: genera dati fake
CorpoCeleste::factory()->count(10)->create();

// Seeder: popola il DB con dati reali o fake
php artisan db:seed
```

---

## 6. Definizioni Laravel (15+)

### Eloquent ORM
L'ORM di Laravel. Ogni tabella ha un Model. Relazioni definite come metodi. Query builder con catene di metodi.

### Migration
File PHP che definisce/modify tabelle. `php artisan make:migration`. `up()` applica, `down()` annulla. Versionata con timestamp.

### Observer
Classe che ascolta eventi Eloquent: `created`, `updated`, `deleted`, `saving`, ecc. Registrato in `EventServiceProvider` o `boot()` del provider. Pattern: logica business separata dal controller.

### Policy
Gruppo di permessi per un modello. Metodi: `viewAny`, `view`, `create`, `update`, `delete`. `before()` per logica generale (es. admin bypassa tutto).

### Gate
Singola azione di autorizzazione. Definito in `AuthServiceProvider`. `Gate::define('admin', fn(User $user) => $user->is_admin)`. Usato con `Gate::authorize('admin')`.

### FormRequest
Classe dedicata alla validazione. `rules()` restituisce array di regole. `messages()` per messaggi custom. Il controller la inietta come parametro.

### Middleware
Livello intermedio che filtra richieste. `auth` = verifica login. `verified` = email verificata. `throttle:120,1` = max 120 richieste/minuto. Definito in `bootstrap/app.php`.

### Service Layer
Classe che gestisce logica di business complessa. Separata dal controller (HTTP) e dal modello (DB). Riusabile da controller, CLI, observer. Esempio: `NasaImageService`.

### Resource Controller
Controller con 7 metodi standard. `Route::resource('categorie', CategoriaController::class)` genera tutte le route CRUD.

### Seeder
File che popola il database. `DatabaseSeeder.php` chiama i seeder specifici. `php artisan db:seed`.

### Factory
Classe che genera dati fake per test. `CorpoCeleste::factory()->create()`. Definita in `database/factories/`.

### Storage
Filesystem astratto. `Storage::disk('public')->put($path, $content)`. `storage/app/public/` per file accessibili web. `php artisan storage:link` per symlink.

### Cache
Memorizzazione risultati costosi. `Cache::remember('key', 3600, fn() => $data)`. TTL in secondi. Redis, Memcached, o file.

### Blade
Template engine di Laravel. `{{ $variabile }}` stampa escaped. `@if`, `@foreach`, `@extends`, `@section`, `@include`. Componenti con `<x-nome />`.

### Route Model Binding
Laravel cerca automaticamente il modello dalla route. `Route::get('/api/corpi-celesti/{corpoCeleste:slug}')` cerca per `slug` invece di `id`.

### Eager Loading
Carica le relazioni in anticipo per evitare N+1 query. `CorpoCeleste::with(['categoria', 'galleria'])` fa 2 query invece di 1 + N.

### API Resource
Trasforma un modello in JSON. `CorpoSelesteResource` seleziona campi da esporre. Protegge dati interni. `php artisan make:resource`.

---

## 7. Definizioni React (12+)

### Componente
Unità base di React. Function component: `function Card({ title }) { return <h1>{title}</h1> }`. Ogni componente è un pezzo di UI riutilizzabile.

### JSX
Syntax extension che compila in `React.createElement()`. Permette di scrivere HTML-like nel JavaScript. `const el = <h1>Ciao</h1>` → `React.createElement('h1', null, 'Ciao')`.

### Hook
Funzioni che aggiungono state/ifecycle ai componenti. Regole: (1) solo nel top level, (2) mai dentro if/cicli, (3) solo in componenti React.

### useState
Hook per state locale. `const [count, setCount] = useState(0)`. Ogni `setState` triggera re-render.

### useEffect
Hook per side effects. `useEffect(() => { fetchData(); return () => controller.abort(); }, [deps])`. Dipendenze: quando cambiano, riesegue. Return: cleanup.

### Props
Dati passati da padre a figlio. ` <Card title="Terra" />` → il figlio riceve `{ title: "Terra" }`. Read-only.

### Virtual DOM
Copia leggera del DOM reale. React calcola la differenza (diffing) e aggiorna solo le parti cambiate del DOM reale. Più performante che manipolare il DOM direttamente.

### Custom Hook
Funzione che inizia con `use` e usa altri hook. `useFetch(url)` usa `useState` + `useEffect` + `AbortController`. Riutilizzabile tra componenti.

### Error Boundary
Class component con `componentDidCatch()`. Cattura errori nei figli. Non cattura errori in event handlers o codice async. In Astralis: in `App.jsx` avvolge `<Routes>`.

### React.lazy + Suspense
Code splitting. `const Home = lazy(() => import('./pages/HomePage'))`. Il file JS viene caricato solo quando serve. `Suspense` mostra fallback durante il caricamento.

### memo()
`React.memo(Component)` → il componente non re-renderizza se le props non cambiano. Ottimizzazione per componenti costosi. Differenza: `useMemo()` memoizza un valore, `useCallback()` memoizza una funzione.

### AbortController
Cancella fetch in corso. `const controller = new AbortController()` → `fetch(url, { signal: controller.signal })` → `controller.abort()` nel cleanup di `useEffect`. Evita memory leak.

---

## 8. CORS e Sicurezza

### CORS (Cross-Origin Resource Sharing)
Il browser blocca richieste da un dominio a un altro. In Astralis: React (`localhost:5173`) chiama Laravel (`localhost:8000`).

**Soluzione**: Vite proxy in `vite.config.js`:
```js
server: {
    proxy: { '/api': 'http://localhost:8000' }
}
```
In produzione: Laravel 13 gestisce automaticamente con middleware `HandleCors`. Nessun `config/cors.php` necessario.

### CSRF (Cross-Site Request Forgery)
Laravel genera un token CSRF per ogni sessione. Le form Blade lo incluono con `@csrf`. Le API REST non lo usano (stateless).

### Throttle
Rate limiting: `throttle:120,1` = max 120 richieste/minuto. Middleware sulle route admin. Previene abusi.

### Auth
Laravel Breeze gestisce sessioni. Middleware `auth` protegge le route. `verified` richiede email verificata.

### Authorization
Policy + Gate. Admin bypassa tutto con `before()` returning `true`. Non-admin: `create/update/delete` restituiscono `false`.

---

## 9. Live Coding — 3 Esercizi con Soluzione

### Esercizio 1: Route + Controller + View

**Traccia**: Crea una route `/test` che mostra una pagina con un messaggio.

**Soluzione**:

```php
// routes/web.php (aggiungere prima del catch-all)
Route::get('/test', function () {
    return view('test');
})->name('test');
```

```php
// resources/views/test.blade.php
@extends('admin.layouts.app')
@section('title', 'Test')
@section('content')
    <h1>Ciao dal progetto Astralis!</h1>
    <p>Questo è un endpoint di test.</p>
@endsection
```

**Variante controller**:
```php
// app/Http/Controllers/TestController.php
<?php
namespace App\Http\Controllers;

use Illuminate\View\View;

class TestController extends Controller
{
    public function __invoke(): View
    {
        $data = ['nome' => 'Astralis', 'versione' => '13'];
        return view('test', compact('data'));
    }
}
```

```php
// routes/web.php
use App\Http\Controllers\TestController;
Route::get('/test', TestController::class)->name('test');
```

---

### Esercizio 2: Array filter/map

**Traccia**: Data un array di oggetti, filtra quelli con prezzo > 10 e mappa in array di nomi.

**Soluzione**:

```php
$prodotti = [
    ['nome' => 'Penna', 'prezzo' => 5],
    ['nome' => 'Quaderno', 'prezzo' => 12],
    ['nome' => 'Matita', 'prezzo' => 3],
    ['nome' => 'Libro', 'prezzo' => 25],
];

// Filter → solo prezzo > 10
$filtrati = array_filter($prodotti, fn($p) => $p['prezzo'] > 10);

// Map → solo nomi
$nomi = array_map(fn($p) => $p['nome'], $filtrati);

// Risultato: ['Quaderno', 'Libro']
```

**Variante con collect (Laravel)**:
```php
$nomi = collect($prodotti)
    ->filter(fn($p) => $p['prezzo'] > 10)
    ->pluck('nome')
    ->toArray();
```

---

### Esercizio 3: Somma array di oggetti

**Traccia**: Calcola la somma totale di un array di oggetti con campo `valore`.

**Soluzione**:

```php
$transazioni = [
    ['descrizione' => 'Acquisto', 'valore' => 100],
    ['descrizione' => 'Vendita', 'valore' => 250],
    ['descrizione' => 'Spesa', 'valore' => -50],
];

// PHP base
$somma = 0;
foreach ($transazioni as $t) {
    $somma += $t['valore'];
}
// Risultato: 300

// Con array_sum + array_column
$somma = array_sum(array_column($transazioni, 'valore'));

// Con collect (Laravel)
$somma = collect($transazioni)->sum('valore');
```

---

## 10. Comandi Rapidi

```bash
# Avvio
php artisan serve              # Backend → localhost:8000
npm run dev                    # Frontend → localhost:5173

# Database
php artisan migrate:fresh --seed   # Reset completo

# Test
php artisan test               # 270 PHPUnit
npm test                       # 110 Vitest

# NASA
php artisan astralis:fetch-nasa    # Import immagini
php artisan astralis:gallery --fix # Ripara galleria

# Credenziali
# admin@astralis.it / password
```

---

_Generato il 21/07/2026 — Astralis v13_
