# Preparazione Esame — Astralis

> Riferimento completo per l'esame finale. Script apertura, traccia vs realizzato, Q&A, definizioni, live coding.

---

## 1. Script di Apertura (5 min)

Ordine consigliato per dimostrare il progetto:

1. **Login** → `admin@astralis.it` / `password` → tema dark Breeze
2. **Dashboard** → grafici Chart.js (donut categorie, barre tipi, barre missioni)
3. **Corpi Celesti** → lista con filtri, ricerca, paginazione → apri "Terra" → metriche, galleria lightbox, curiosità, timeline missioni, corpi simili
4. **Categorie** → badge colorati, conteggio corpi associati
5. **Missioni** → timeline orizzontale, badge stato (Completata/In corso/Pianificata)
6. **NASA Import** → bottone "Importa da NASA" → immagini reali
7. **Guest React** → `localhost:5173` → sistema solare animato → griglia corpi → dettaglio con lightbox → comparatore

---

## 2. Traccia → Realizzato

### Parte 1 — Backoffice Laravel

| # | Requisito traccia | Realizzato | Dettagli |
|---|---|---|---|
| 1 | Backoffice con autenticazione Breeze | ✅ | Breeze Blade puro (Inertia rimosso). Route protette da middleware `auth`. Login, register, profilo, reset password — tema dark `#0A0A1A` |
| 2 | CRUD entità principale | ✅ | CorpoCeleste: 7 metodi controller, form 6 sezioni, 18 campi |
| 3 | Relazioni 1-N o N-N | ✅ | 5 entità, 3 tipi: BelongsTo/HasMany (1-N), BelongsToMany (N-N con pivot `corpo_celeste_missione`) |
| 4 | CRUD entità secondarie | ✅ | Categoria, Missione, Curiosità, Galleria — CRUD completo ciascuna |
| 5 | Upload media | ✅ | Missioni (logo 300px), Galleria (1200px) con ImageUploadService + Intervention Image v4 `scaleDown()` |
| 6 | Template Blade | ✅ | Layout master `app.blade.php` con sidebar navigazione, Alpine.js CDN |

### Parte 2 — Guest React

| # | Requisito traccia | Realizzato | Dettagli |
|---|---|---|---|
| 7 | SPA React guest | ✅ | React 18 standalone, Vite, 5 pagine (Home, Lista, Dettaglio, Comparatore, 404) |
| 8 | Lista elementi | ✅ | `CorpiLista.jsx`: griglia card, filtri (categoria, tipo, ricerca), paginazione "Carica altri" |
| 9 | Dettaglio elemento | ✅ | `CorpoDettaglio.jsx`: metriche, galleria lightbox, curiosità, timeline missioni, simili |
| 10 | Info correlate | ✅ | Badge categoria, lightbox immagini NASA, timeline missioni, corpi simili |
| 11 | API REST | ✅ | 10 endpoint JSON pubblici in `routes/api.php`. API Resources, eager loading, filtri query |
| 12 | Test Postman | ✅ | Endpoint pubblici, JSON response, filtri via query params |

### Extra Wow Factor

| Extra | Descrizione | Dove |
|---|---|---|
| **NASA API Integration** | Import automatico immagini reali, fallback apostrofi, auto-import su created via Observer→Job | Fase 8-9 |
| **Sistema Solare Animato** | 8 pianeti orbitanti con `requestAnimationFrame`, velocità differenziate | Fase 6 |
| **Lightbox Galleria** | Schermo intero con swipe mobile, slideshow | Fase 5 |
| **Comparatore Pianeti** | Confronto 2 corpi su 7 metriche, pre-fill via URL params | Fase 5 |
| **Timeline Missioni** | Scrolling orizzontale con badge stato colorato | Fase 5 |
| **Dashboard Chart.js** | 3 grafici donut/barre con tema dark | Fase 14 |
| **CLI Commands** | `astralis:fetch-nasa` e `astralis:gallery` per manutenzione | Fase 8-11 |
| **Error Boundary** | Fallback UI globale per crash React | Fase 15 |
| **SEO** | `document.title` dinamico su 5 pagine React | Fase 15 |
| **380 Test** | 270 PHPUnit + 110 Vitest, Http::fake(), observer skip | Fase 13+ |
| **WordMapService** | Traduzione italiano → inglese per ricerca NASA (~70 termini) | Fase 9 |
| **Responsive** | Navbar mobile, SolarSystem responsive scaling, griglia adattiva | Ongoing |

---

## 3. Postman — Esempi Pratici

Tutti gli endpoint sono **pubblici** (nessuna autenticazione). Puntare a `http://localhost:8000`.

### Esempio 1 — Homepage (stats + in evidenza)

**Step 1: Statistiche generali**

```
GET http://localhost:8000/api/dashboard/stats
```

Response 200:

```json
{
    "totale_corpi_celesti": 18,
    "totale_categorie": 8,
    "totale_missioni": 10,
    "corpi_in_evidenza": 9,
    "ultimi_corpi": [...],
    "missioni_per_stato": {
        "total": 10,
        "completate": 4,
        "in_corso": 4,
        "pianificate": 2
    }
}
```

**Step 2: Corpi in evidenza**

```
GET http://localhost:8000/api/corpi-celesti?in_evidenza=1&per_page=6
```

### Esempio 2 — Dettaglio Terra

```
GET http://localhost:8000/api/corpi-celesti/terra
```

Response 200 (estratto):

```json
{
    "data": {
        "id": 3,
        "nome": "Terra",
        "slug": "terra",
        "categoria": {
            "id": 1,
            "nome": "Pianeta",
            "slug": "pianeta",
            "colore": "#22D3EE"
        },
        "immagine_url": "https://images-assets.nasa.gov/image/PIA18033/PIA18033~medium.jpg",
        "tipo": "Pianeta roccioso",
        "massa_kg": "5.972e24",
        "diametro_km": "12756",
        "gravita": "9.81",
        "temperatura": "15",
        "galleria": [...],
        "curiosita": [...],
        "missioni": [
            {
                "nome": "Apollo 11",
                "pivot": {
                    "tipo_esplorazione": "missione con equipaggio",
                    "anno_arrivo": 1969
                }
            }
        ]
    }
}
```

**Nota**: `nome` contiene il nome italiano. `nome_en` (opzionale) contiene l'inglese.

### Esempio 3 — Filtri multipli

```
GET http://localhost:8000/api/missioni?agenzia=NASA&stato=in corso
```

### Esempio 4 — Corpi simili

```
GET http://localhost:8000/api/corpi-celesti/terra/simili
```

Restituisce max 4 corpi della stessa categoria.

### Come testare su Postman

1. Avvia il backend: `php artisan serve` (porta 8000)
2. Crea una request GET in Postman
3. Inserisci l'URL: `http://localhost:8000/api/corpi-celesti`
4. Nessun token o autenticazione necessaria
5. Parametri query opzionali: `?categoria=pianeta&search=terra&in_evidenza=1&per_page=5`

---

## 4. Stack Tecnologico

| Livello | Tecnologia | Versione | Perché |
|---|---|---|---|
| **Backend** | Laravel | 13.8 | Richiesto dalla traccia. Eloquent ORM, migrazioni, artisan CLI |
| **Database** | MySQL | 8.x | Richiesto. Porta 3307 |
| **Auth** | Laravel Breeze | — | Richiesto. Configurato con Blade (non Inertia) |
| **Frontend guest** | React | 18.2 | Richiesto. SPA standalone con Vite |
| **Frontend admin** | Blade + Alpine.js | — | Richiesto per admin. Alpine.js CDN per modali |
| **CSS** | Tailwind CSS | 4.3 | Utility-first, tema dark custom |
| **Animazioni** | framer-motion | 12.4 | SolarSystem (requestAnimationFrame) |
| **Icone** | lucide-react | 1.23 | Icone categoria, navigazione, azioni |
| **Lightbox** | yet-another-react-lightbox | — | Galleria immagini a schermo intero |
| **Immagini** | Intervention Image | 4 | Upload con scaleDown via ImageUploadService |
| **Slug** | spatie/laravel-sluggable | — | Slug automatici su 3 modelli |
| **Grafici** | Chart.js (CDN) | 4.4 | Dashboard admin (donut, barre) |
| **API esterne** | NASA Image API | — | Import immagini reali, auto-suggest |
| **Test PHP** | PHPUnit | 12.5 | 270 test, 613 assertion |
| **Test JS** | Vitest + Testing Library | 4.1 | 110 test, environment jsdom |

---

## 5. Architettura & Mappa File

### Backend (Laravel)

| File | Dove |
|---|---|
| Route admin | `routes/web.php` → gruppo `admin` |
| Route API | `routes/api.php` → 10 endpoint |
| Route auth | `routes/auth.php` → Breeze |
| Controllers admin | `app/Http/Controllers/Admin/` (8 file) |
| Controllers API | `app/Http/Controllers/Api/` (6 file) |
| Models | `app/Models/` (6 file: 5 entità + User) |
| Migrations | `database/migrations/` (21 file) |
| Services | `app/Services/` (NasaImageService, WordMapService, ImageUploadService) |
| Policies | `app/Policies/` (5 file) |
| Gate admin | `app/Providers/AuthServiceProvider.php` |
| Observer | `app/Observers/CorpoCelesteObserver.php` |
| Job | `app/Jobs/ImportNasaImage.php` |
| FormRequest | `app/Http/Requests/` (13 file) |
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

## 6. Q&A — Risposte alle Domande (20+)

### Architettura

**Q: Dove sono le API?**
→ `routes/api.php`. 10 endpoint GET. Controller in `app/Http/Controllers/Api/`. API Resources per JSON controllato.

**Q: Dove sono le CRUD?**
→ `app/Http/Controllers/Admin/`. Ogni controller ha 7 metodi: index, create, store, show, edit, update, destroy. Route resource in `routes/web.php`.

**Q: Come funziona il routing?**
→ Due mondi: admin (`/admin/*`) gestito da Laravel + Blade; guest (`/*`) gestito da React SPA. Il catch-all `/{any}` in `web.php` passa tutto a `guest.blade.php`.

**Q: Qual è la differenza tra admin e guest?**
→ Admin: Blade + Alpine.js, autenticazione Breeze, CRUD. Guest: React SPA standalone, API REST, animazioni. Comunicano solo via API.

**Q: Perché avete separato frontend guest e backoffice admin?**
→ Per responsabilità e competenze diverse. Il guest è una SPA standalone che non richiede autenticazione e beneficia di transizioni fluide. Il backoffice è un CRUD classico dove Blade + Alpine.js è più semplice e performante. Inertia era stato installato inizialmente ma rimosso perché creava un livello intermedio inutile.

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
→ `spatie/laravel-sluggable`. Trait `Sluggable` nel modello + metodo `getSlugOptions()`. Genera slug dal nome italiano (`nome`). 3 modelli: Categoria, CorpoCeleste, Missione.

**Q: Cos'è il problema N+1?**
→ Quando in un loop accedi a una relazione senza eager loading. Esempio: 10 missioni × 1 corpo = 11 query. Soluzione: `with(['categoria', 'galleria'])` → 2 query.

**Q: Come fai il seeding?**
→ `database/seeders/`. Seeder con dati reali: 8 categorie, 18 corpi celesti, 10 missioni, 16 immagini galleria, 18 curiosità, 17 relazioni pivot. `php artisan migrate:fresh --seed`.

### Backend

**Q: Cos'è un FormRequest?**
→ Classe dedicata alla validazione, separata dal controller. 13 FormRequest nel progetto (Store/Update per ogni entità + SuggestNome, AggiornaOrdine, ProfileUpdate). Regole in `rules()`.

**Q: Cos'è un Observer?**
→ Pattern che ascolta eventi Eloquent (created, updated, deleted). `CorpoCelesteObserver::created()` dispatcha il job `ImportNasaImage` quando un corpo viene creato. Disabilitato in testing con `app()->environment('testing')`.

**Q: Cos'è un Service Layer?**
→ Classe che gestisce logica di business, separata dal controller. 3 service: `NasaImageService` (ricerca/import/dedup NASA), `WordMapService` (traduzione IT→EN), `ImageUploadService` (upload + resize con Intervention Image v4). Riusabili da controller, CLI, o observer.

**Q: Come funziona l'upload?**
→ `ImageUploadService` centralizza la logica. Intervention Image v4: `new ImageManager(new Driver())->decodePath($path)`. `scaleDown(1200, 1200)` preserva aspect ratio. Salvato su `storage/app/public/` con `Storage::disk('public')`. `php artisan storage:link` per il symlink.

**Q: CORS come lo gestisci?**
→ Laravel 13 gestisce automaticamente (middleware `HandleCors`). In dev, Vite proxy inoltra `/api` a `localhost:8000`. Nessun `config/cors.php` necessario.

**Q: Cos'è un API Resource?**
→ Trasforma un modello Eloquent in JSON controllato. `CorpoCelesteResource` espone `nome` (italiano) ma non campi interni come `immagine_utente`. `php artisan make:resource`.

**Q: Come funziona il routing lato client con React?**
→ `react-router-dom` definisce 5 route: `/`, `/corpi-celesti`, `/corpi-celesti/:slug`, `/confronta`, `/*` (404). Laravel cattura tutto con `Route::get('/{any}', fn() => view('guest'))->where('any', '.*')` e passa il controllo a React.

### Frontend

**Q: Come comunica React con Laravel?**
→ `apiClient.js` (axios) invia richieste a `/api/*`. Vite proxy inoltra a `localhost:8000`. API REST restituiscono JSON. Nessun Inertia (rimosso).

**Q: Cos'è un Error Boundary?**
→ Class component React che cattura errori nei figli. Mostra fallback UI se un componente crasha. In `App.jsx` avvolge `<Routes>`.

**Q: Cos'è React.memo()?**
→ Ottimizzazione: il componente non re-renderizza se le props non cambiano. Usato su `LightboxGalleria` e `Thumbnail`.

**Q: Come gestisci il fetch dei dati?**
→ Custom hook `useFetch` con `useReducer` + `AbortController`. Gestisce loading, error, e cleanup. `apiClient.js` ha retry logic (2 tentativi).

**Q: Come avete implementato il Sistema Solare animato?**
→ Soluzione finale con `requestAnimationFrame` + direct DOM manipulation. Un angolo cresce infinitamente per ogni pianeta, convertito in coordinate x/y con funzioni seno/coseno. Ogni pianeta ha velocità e raggio differenziati. Hover rallenta i pianeti al 33%. Zero re-render React durante animazione.

**Q: Perché avete salvato URL remoti NASA invece di file locali?**
→ Le immagini NASA in risoluzione originale possono essere enormi. Salvando l'URL remoto `~medium.jpg`: (1) risparmio storage, (2) no download enormi, (3) browser carica da NASA CDN. Il comando `astralis:gallery --fix` sostituisce URL non raggiungibili con placeholder.

**Q: Che cos'è il WordMapService e a cosa serve?**
→ Servizio di traduzione italiano → inglese parola per parola, con ~70 termini astronomici. Quando un admin inserisce un nome italiano, il WordMapService traduce la query prima di cercare su NASA API. Cache con TTL di 1 ora.

### Testing

**Q: Come testi le API?**
→ PHPUnit + Http::fake(). Ogni test crea dati con factory, chiama l'endpoint, verifica status e JSON response. `Http::fake()` blocca chiamate HTTP reali.

**Q: Perché Http::fake() è essenziale?**
→ L'Observer dispatcha il job NASA ogni volta che un CorpoCeleste viene creato. Senza `Http::fake()`, i test farebbero chiamate reali.

**Q: Come testi React?**
→ Vitest + Testing Library. 110 test: componenti, integrazione API, error handling. `jsdom` environment.

**Q: Quali sono i pattern obbligatorio per i test?**
→ `Http::fake()` in `setUp()`, `RefreshDatabase` per DB pulito, `factory()->create()` invece di inserimenti manuali, Observer disabilitato in testing.

---

## 7. Definizioni PHP (10+)

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

## 8. Definizioni Laravel (15+)

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
Classe che gestisce logica di business complessa. Separata dal controller (HTTP) e dal modello (DB). Riusabile da controller, CLI, observer. Esempio: `NasaImageService`, `WordMapService`, `ImageUploadService`.

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
Trasforma un modello in JSON. `CorpoCelesteResource` seleziona campi da esporre. Espone `nome` (italiano) per il frontend guest. Protegge dati interni. `php artisan make:resource`.

---

## 9. Definizioni React (12+)

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
Dati passati da padre a figlio. `<Card title="Terra" />` → il figlio riceve `{ title: "Terra" }`. Read-only.

### Virtual DOM
Copia leggera del DOM reale. React calcola la differenza (diffing) e aggiorna solo le parti cambiate del DOM reale. Più performante che manipolare il DOM direttamente.

### Custom Hook
Funzione che inizia con `use` e usa altri hook. `useFetch(url)` usa `useState` + `useEffect` + `AbortController`. Riutilizzabile tra componenti.

### Error Boundary
Class component con `componentDidCatch()`. Cattura errori nei figli. Non cattura errori in event handlers o codice async. In Astralis: in `App.jsx` avvolge `<Routes>`.

### React.memo()
`React.memo(Component)` → il componente non re-renderizza se le props non cambiano. Ottimizzazione per componenti costosi. Differenza: `useMemo()` memoizza un valore, `useCallback()` memoizza una funzione.

### AbortController
Cancella fetch in corso. `const controller = new AbortController()` → `fetch(url, { signal: controller.signal })` → `controller.abort()` nel cleanup di `useEffect`. Evita memory leak.

### requestAnimationFrame
API del browser per animazioni fluenti. `callback` viene chiamato prima del repaint del browser. In Astralis: orbite del sistema solare. Più performante di `setInterval` perché si sincronizza con il refresh rate del display.

---

## 10. CORS & Sicurezza

### CORS (Cross-Origin Resource Sharing)
Il browser blocca richieste da un dominio a un altro. In Astralis: React (`localhost:5173`) chiama Laravel (`localhost:8000`).

**Soluzione**: Vite proxy in `vite.config.js`:
```js
server: {
    proxy: { '/api': 'http://localhost:8000' }
}
```
In produzione: Laravel 13 gestisce automaticamente con middleware `HandleCors`.

### CSRF (Cross-Site Request Forgery)
Laravel genera un token CSRF per ogni sessione. Le form Blade lo incluono con `@csrf`. Le API REST non lo usano (stateless).

### Throttle
Rate limiting: `throttle:120,1` = max 120 richieste/minuto sulle route admin. `throttle:60,1` sulle API. `throttle:30,1` su suggestNome.

### Auth
Laravel Breeze gestisce sessioni. Middleware `auth` protegge le route. `verified` richiede email verificata.

### Authorization
Policy + Gate. Admin bypassa tutto con `before()` returning `true`. Non-admin: `create/update/delete` restituiscono `false`.

---

## 11. Errori Comuni da NON Fare

| Errore | Perché è sbagliato | Cosa fare invece |
|---|---|---|
| `Image::read()` in Intervention v4 | La facade è stata rimossa in v4 | `new ImageManager(new Driver())->decodePath($path)` |
| `resize()` invece di `scaleDown()` | `resize()` forza le dimensioni e distorce | `scaleDown(width, height)` preserva aspect ratio |
| Dimenticare `Http::fake()` nei test | L'observer dispatcha job NASA → test falliti | `Http::fake()` in setUp() |
| Dimenticare eager loading nelle show | **N+1 problem**: N query extra | `::with(['relazione'])->firstOrFail()` |
| Usare `->get()` invece di `->paginate()` | Carica tutto in memoria | `->paginate(20)` con `->withQueryString()` |
| `@if` senza `@endif` in Blade | Errore 500 silenzioso | Controllare chiusura if/foreach |
| Dimenticare `->constrained()` FK | FK non reale | `$table->foreignId('x_id')->constrained()` |
| Mantenere Inertia quando non serve | Dipendenze inutili, conflitti routing | Rimuovere se SPA standalone |
| `$fillable` senza tutti i campi | Mass assignment exception | Aggiungere TUTTI i campi modificabili |

---

## 12. Live Coding — 3 Esercizi con Soluzione

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
 filtrati = array_filter($prodotti, fn($p) => $p['prezzo'] > 10);

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

## 13. Comandi Rapidi

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

## 14. Credenziali

| Ruolo | Email | Password |
|---|---|---|
| **Admin** | admin@astralis.it | password |
| **Utente normale** | (registrazione libera su /register) | — |

---

_Generato il 21/07/2026 — Astralis v13.18_
