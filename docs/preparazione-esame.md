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
7. **Guest React** → `localhost:5175` → sistema solare animato → griglia corpi → dettaglio con lightbox → comparatore

---

## 2. Traccia → Realizzato

### Parte 1 — Backoffice Laravel

| #   | Requisito traccia                    | Realizzato | Dettagli                                                                                                                                |
| --- | ------------------------------------ | ---------- | --------------------------------------------------------------------------------------------------------------------------------------- |
| 1   | Backoffice con autenticazione Breeze | ✅         | Breeze Blade puro (Inertia rimosso). Route protette da middleware`auth`. Login, register, profilo, reset password — tema dark `#0A0A1A` |
| 2   | CRUD entità principale               | ✅         | CorpoCeleste: 7 metodi controller, form 6 sezioni, 18 campi                                                                             |
| 3   | Relazioni 1-N o N-N                  | ✅         | 5 entità, 3 tipi: BelongsTo/HasMany (1-N), BelongsToMany (N-N con pivot`corpo_celeste_missione`)                                        |
| 4   | CRUD entità secondarie               | ✅         | Categoria, Missione, Curiosità, Galleria — CRUD completo ciascuna                                                                       |
| 5   | Upload media                         | ✅         | Missioni (logo 300px), Galleria (1200px) con ImageUploadService + Intervention Image v4`scaleDown()`                                    |
| 6   | Template Blade                       | ✅         | Layout master`app.blade.php` con sidebar navigazione, Alpine.js (npm)                                                                   |

### Parte 2 — Guest React

| #   | Requisito traccia  | Realizzato | Dettagli                                                                                      |
| --- | ------------------ | ---------- | --------------------------------------------------------------------------------------------- |
| 7   | SPA React guest    | ✅         | React 18 standalone, Vite, 5 pagine (Home, Lista, Dettaglio, Comparatore, 404)                |
| 8   | Lista elementi     | ✅         | `CorpiLista.jsx`: griglia card, filtri (categoria, tipo, ricerca), paginazione "Carica altri" |
| 9   | Dettaglio elemento | ✅         | `CorpoDettaglio.jsx`: metriche, galleria lightbox, curiosità, timeline missioni, simili       |
| 10  | Info correlate     | ✅         | Badge categoria, lightbox immagini NASA, timeline missioni, corpi simili                      |
| 11  | API REST           | ✅         | 10 endpoint JSON pubblici in`routes/api.php`. API Resources, eager loading, filtri query      |
| 12  | Test Postman       | ✅         | Endpoint pubblici, JSON response, filtri via query params                                     |

### Extra Wow Factor

| Extra                      | Descrizione                                                                                   | Dove      |
| -------------------------- | --------------------------------------------------------------------------------------------- | --------- |
| **NASA API Integration**   | Import automatico immagini reali, fallback apostrofi, auto-import su created via Observer→Job | Fase 8-9  |
| **Sistema Solare Animato** | 8 pianeti orbitanti con`requestAnimationFrame`, velocità differenziate                        | Fase 6    |
| **Lightbox Galleria**      | Schermo intero con swipe mobile, slideshow                                                    | Fase 5    |
| **Comparatore Pianeti**    | Confronto 2 corpi su 7 metriche, pre-fill via URL params                                      | Fase 5    |
| **Timeline Missioni**      | Scrolling orizzontale con badge stato colorato                                                | Fase 5    |
| **Dashboard Chart.js**     | 3 grafici donut/barre con tema dark                                                           | Fase 14   |
| **CLI Commands**           | `astralis:fetch-nasa` e `astralis:gallery` per manutenzione                                   | Fase 8-11 |
| **Error Boundary**         | Fallback UI globale per crash React                                                           | Fase 15   |
| **SEO**                    | `document.title` dinamico su 5 pagine React                                                   | Fase 15   |
| **380 Test**               | 270 PHPUnit + 110 Vitest, Http::fake(), observer skip                                         | Fase 13+  |
| **WordMapService**         | Traduzione italiano → inglese per ricerca NASA (~70 termini)                                  | Fase 9    |
| **Responsive**             | Navbar mobile, SolarSystem responsive scaling, griglia adattiva                               | Ongoing   |

---

## 3. Postman — Esempi Pratici

Tutti gli endpoint sono **pubblici** (nessuna autenticazione). Puntare a `http://localhost:8000`.

### Come testare su Postman

1. Avvia il backend: `php artisan serve` (porta 8000)
2. Crea una request GET in Postman
3. Inserisci l'URL: `http://localhost:8000/api/corpi-celesti`
4. Nessun token o autenticazione necessaria
5. Parametri query opzionali: `?categoria=pianeta&search=terra&in_evidenza=1&per_page=5`

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

---

## 4. Stack Tecnologico

| Livello            | Tecnologia                 | Versione | Perché                                                            |
| ------------------ | -------------------------- | -------- | ----------------------------------------------------------------- |
| **Backend**        | Laravel                    | 13.8     | Richiesto dalla traccia. Eloquent ORM, migrazioni, artisan CLI    |
| **Database**       | MySQL                      | 8.x      | Richiesto. Porta 3307                                             |
| **Auth**           | Laravel Breeze             | —        | Richiesto. Configurato con Blade (non Inertia)                    |
| **Frontend guest** | React                      | 18.2     | Richiesto. SPA standalone con Vite                                |
| **Frontend admin** | Blade + Alpine.js          | 3.15     | Richiesto per admin. Alpine.js bundled via Vite per interattività |
| **CSS**            | Tailwind CSS               | 4.3      | Utility-first, tema dark custom                                   |
| **Icone**          | lucide-react               | 1.23     | Icone categoria, navigazione, azioni                              |
| **Lightbox**       | yet-another-react-lightbox | —        | Galleria immagini a schermo intero                                |
| **Immagini**       | Intervention Image         | 4        | Upload con scaleDown via ImageUploadService                       |
| **Slug**           | spatie/laravel-sluggable   | —        | Slug automatici su 3 modelli                                      |
| **Grafici**        | Chart.js                   | 4.4      | Dashboard admin (donut, barre), bundled via Vite                  |
| **API esterne**    | NASA Image API             | —        | Import immagini reali, auto-suggest                               |
| **Test PHP**       | PHPUnit                    | 12.5     | 270 test, 613 assertion                                           |
| **Test JS**        | Vitest + Testing Library   | 4.1      | 110 test, environment jsdom                                       |

---

## 5. Architettura & Mappa File

### Backend (Laravel)

| File              | Dove                                                                   |
| ----------------- | ---------------------------------------------------------------------- |
| Route admin       | `routes/web.php` → gruppo `admin`                                      |
| Route API         | `routes/api.php` → 10 endpoint                                         |
| Route auth        | `routes/auth.php` → Breeze                                             |
| Controllers admin | `app/Http/Controllers/Admin/` (8 file)                                 |
| Controllers API   | `app/Http/Controllers/Api/` (6 file)                                   |
| Models            | `app/Models/` (6 file: 5 entità + User)                                |
| Migrations        | `database/migrations/` (21 file)                                       |
| Services          | `app/Services/` (NasaImageService, WordMapService, ImageUploadService) |
| Policies          | `app/Policies/` (5 file)                                               |
| Gate admin        | `app/Providers/AuthServiceProvider.php`                                |
| Observer          | `app/Observers/CorpoCelesteObserver.php`                               |
| Job               | `app/Jobs/ImportNasaImage.php`                                         |
| FormRequest       | `app/Http/Requests/` (13 file)                                         |
| Config admin      | `config/admin.php`                                                     |
| Layout admin      | `resources/views/admin/layouts/app.blade.php`                          |
| Sidebar           | `resources/views/admin/partials/_sidebar-nav.blade.php`                |
| CSS entry         | `resources/css/app.css` — Tailwind entry + `[x-cloak]`                 |

### Frontend (React)

| File         | Dove                                                  |
| ------------ | ----------------------------------------------------- |
| Entry point  | `resources/js/guest/main.jsx`                         |
| Routing      | `resources/js/guest/App.jsx`                          |
| Pages        | `resources/js/guest/pages/` (5 pagine)                |
| Components   | `resources/js/guest/components/`                      |
| API client   | `resources/js/guest/apiClient.js`                     |
| Custom hooks | `resources/js/guest/hooks/` (useFetch, useDebounce)   |
| Admin JS     | `resources/js/admin.js` — Alpine.js entry (npm)       |
| Admin charts | `resources/js/admin-charts.js` — Chart.js entry (npm) |
| Vite config  | `vite.config.js` (proxy `/api` → `localhost:8000`)    |

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

**Q: Cos'è un Model e come lo crei?**
→ Rappresenta una tabella del DB. Ogni Model ha `$fillable` (campi modificabili), `$casts` (tipi), relazioni come metodi. `php artisan make:model CorpoCeleste -m` crea modello + migration. In Astralis: 5 Model (Categoria, CorpoCeleste, Missione, Curiosità, GalleriaCorpo) in `app/Models/`.

**Q: Cos'è un Controller e dove lo trovi?**
→ Classe che gestisce la logica HTTP: riceve la richiesta, chiama service/model, restituisce risposta. 7 metodi standard: index, create, store, show, edit, update, destroy. In Astralis: Admin controllers in `app/Http/Controllers/Admin/` (8 file), API controllers in `app/Http/Controllers/Api/` (6 file). `php artisan make:controller`.

**Q: Che cos'è Blade?**
→ Template engine di Laravel. `{{ $var }}` stampa escaped. `@if`, `@foreach`, `@extends`, `@section`, `@include`. Componenti con `<x-nome />`. In Astralis: layout admin in `resources/views/admin/layouts/app.blade.php`, guest SPA shell in `resources/views/guest.blade.php`.

**Q: Quali middleware usi?**
→ `auth` (login obbligatorio), `verified` (email verificata), `throttle:120,1` (rate limit), `throttle:30,1` su suggestNome. Definiti in `bootstrap/app.php`. Il middleware `HandleCors` gestisce le richieste cross-origin.

**Q: Che differenza c'è tra route web e API?**
→ Dual rendering. `web.php` restituisce **HTML** (Blade admin + catch-all React SPA). `api.php` restituisce **JSON** (API consumate dal React SPA). Il frontend chiama `/api/corpi-celesti` dal browser, il Vite proxy (`vite.config.js`) inoltra a `localhost:8000`, il controller API restituisce JSON. Routing separato: web per server-side rendering, api per client-side.

**Q: Spiega `routes/web.php` — cosa contiene?**
→ 58 righe, 4 sezioni:

1. **Home** — `GET /` → carica la vista `guest` (React SPA shell)
2. **Profilo** — 3 route protette da `auth`: edit, update, destroy del profilo utente
3. **Blocco admin** — raggruppato con `prefix('admin')` + middleware `auth`, `verified`, `throttle:120,1`:
    - `GET /admin` → dashboard
    - 5 `Route::resource` per le CRUD (categorie, corpi-celesti, missioni, curiosità, galleria)
    - Route custom: `suggest-nome` (auto-traduzione), `gallery-add`, `set-image`, `ordine` galleria
    - Route NASA import: `import-all` + import singola
4. **Catch-all** — `GET /{any}` → qualsiasi URL non matching torna a `guest.blade.php`. Va dopo tutte le route specifiche altrimenti cattura tutto
5. `require __DIR__.'/auth.php'` → include le route Breeze

`Route::resource` genera 7 route CRUD in automatico. `parameters(['corpi-celesti' => 'corpoCeleste'])` rinomina il parametro URL per il Route Model Binding.

**Q: Spiega `routes/api.php` — cosa contiene?**
→ 26 righe. 10 endpoint JSON pubblici (nessuna auth), tutti dentro `throttle:60,1`:

| Endpoint                               | Cosa fa                                 |
| -------------------------------------- | --------------------------------------- |
| `GET /api/corpi-celesti`               | Lista (con filtri query)                |
| `GET /api/corpi-celesti/{slug}`        | Dettaglio (Route Model Binding su slug) |
| `GET /api/corpi-celesti/{slug}/simili` | Corpi simili                            |
| `GET /api/categorie`                   | Lista categorie                         |
| `GET /api/categorie/{slug}`            | Dettaglio categoria                     |
| `GET /api/missioni`                    | Lista missioni                          |
| `GET /api/missioni/{slug}`             | Dettaglio missione                      |
| `GET /api/curiosita`                   | Lista curiosità                         |
| `GET /api/galleria`                    | Lista galleria                          |
| `GET /api/dashboard/stats`             | Statistiche dashboard admin             |

Route Model Binding con `{corpoCeleste:slug}` usa lo slug invece dell'ID. Il prefisso `/api` è automatico in Laravel. Le risposte passano da `ApiResource` (trasforma il modello in JSON controllato). Throttle più aggressivo delle web (`60,1` vs `120,1`).

**Q: Cos'è un Job e come lo usi?**
→ Classe che esegue un task in background (queue). In Astralis: `ImportNasaImage` importa immagini da NASA API. Dispatchato da `CorpoCelesteObserver::created()`. `ShouldBeUnique` evita duplicati. `failed()` gestisce errori. `php artisan make:job`.

**Q: Come gestisci la cache?**
→ `Cache::remember('key', ttl, callback)` memorizza il risultato per N secondi. In Astralis: dashboard cache (600s), suggestNome cache (3600s). Invalidata nei controller con `Cache::flush()` o `Cache::forget()`. La Facade `Cache` accede al CacheManager dal container.

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

## 7. Definizioni PHP (19)

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

### Include e Require

```php
include 'config.php';       // Inclui il file. Se fallisce → warning, continua
require 'config.php';       // Inclui il file. Se fallisce → fatal error, stop
include_once 'config.php';  // Come include, ma solo 1 volta (evita doppie dichiarazioni)
require_once 'config.php';  // Come require, ma solo 1 volta
```

**Differenza include vs require**: `include` è permissivo (continua anche se il file manca), `require` è obbligatorio (script si ferma). **Differenza_once**: garantisce che il file venga caricato una sola volta. In Laravel non li usi direttamente — Composer gestisce l'autoloading con `require_once` nel file `vendor/autoload.php`.

### Closure e Arrow Function

```php
// Closure classica
$callback = function ($value) {
    return $value * 2;
};

// Arrow function (PHP 7.4+) — più concisa, cattura variabili dallo scope automaticamente
$moltiplica = fn($value) => $value * 2;

// In Laravel: route, callback, higher-order
Route::get('/test', fn() => view('test'));
$corpi->filter(fn($c) => $c->in_evidenza);
```

Closure = funzione anonima. Arrow function (`fn()`) è la versione concisa: una sola riga, return implicito, cattura automatica dello scope.

### Enum

```php
// PHP 8.1+
enum StatoMissione: string {
    case Completata = 'Completata';
    case InCorso = 'In corso';
    case Pianificata = 'Pianificata';
}

// Uso: $missione->stato === StatoMissione::Completata
```

Enum = enumerazione di valori costanti. In PHP 8.1+ sono classi con vincolo sui valori. In Laravel: per status, tipi, stati. Più sicuro di stringhe/libere.

### Null Safe Operator (`?->`)

```php
$nome = $corpo->categoria?->nome;        // Se categoria è null → null (non errore)
$icona = $corpo->categoria?->icona ?? '—'; // Con fallback
```

Operatore di navigazione sicura. Se l'oggetto a sinistra è `null`, restituisce `null` invece di lanciare errore. Introdotto in PHP 8.0. Utile dove la relazione potrebbe essere null.

### ::class

```php
Categoria::class          // Restituisce la stringa completa: 'App\Models\Categoria'
Route::resource('categorie', CategoriaController::class);
```

`::class` è una costante magica che restituisce il nome fully-qualified della classe. Utile per route, policy, e dove Laravel richiede una stringa che identifichi univocamente una classe.

### Ereditarietà

```php
class CorpoCeleste extends Model { ... }
class CorpoCelesteController extends Controller { ... }
```

Una classe figlia eredita tutti i metodi e proprietà pubbliche/protette del padre. `extends` = eredita. `override` = sovrascrive un metodo del padre. PHP supporta ereditarietà singola (una sola classe padre) + trait multipli.

### Facade

```php
Cache::remember('corpi', 3600, fn() => CorpoCeleste::all());
Gate::authorize('admin');
```

Una Facade è un "proiesore statico" che accede a un servizio dal container di Laravel. Dietro `Cache::` c'è un'istanza reale di `CacheManager`. Facade = sintassi compatta + testabilità (si possono mockare nei test con `Cache::shouldReceive()`).

### String Functions

```php
strlen('hello')           // 5 — lunghezza stringa
strtoupper('hello')       // 'HELLO' — maiuscolo
strtolower('HELLO')       // 'hello' — minuscolo
str_replace('a', 'x', 'banana')  // 'bxnxnx' — sostituzione
substr('hello', 0, 3)    // 'hel' — sottostringa
strpos('hello world', 'world')   // 6 — posizione (false se non trovato)
trim('  hello  ')         // 'hello' — rimuove spazi
str_contains('hello world', 'world')  // true (PHP 8+)
str_starts_with('hello', 'he')        // true (PHP 8+)
```

Funzioni base per manipolare stringhe. Non sono metodi di una classe — sono funzioni globali. In Laravel: usate ovunque (validation, slug, formattazione).

### Array Functions

```php
count($array)             // Numero elementi
array_push($arr, 'x')    // Aggiunge in fondo
array_pop($arr)           // Rimuove dall'ultimo
array_merge($a, $b)       // Unisce due array
array_key_exists('key', $arr)  // Verifica chiave
in_array('value', $arr)   // Verifica valore
array_map(fn($x) => $x * 2, $arr)  // Applica funzione a ogni elemento
array_filter($arr, fn($x) => $x > 5)  // Filtra per condizione
array_column($arr, 'nome')  // Estrae una colonna
compact('var1', 'var2')   // Crea array da variabili
```

Funzioni globali per manipolare array. In Laravel: usate in controller, seeder, test. Le Collection Eloquent estendono queste funzionalità con metodi fluenti.

### Null Coalescing (`??`)

```php
$nome = $input['nome'] ?? 'Anonimo';    // Se $input['nome'] non esiste o è null → 'Anonimo'
$valore = $x ?? $y ?? $z ?? 'default';  // Primo valore non-null
$risultato = $request->input('campo', 'default');  // Laravel usa ?? internamente
```

Operatore introdotto in PHP 7. Simile al ternario `?:` ma più sicuro: restituisce il valore a destra solo se il sinistro è `null` o non esiste. Differenza con `isset()`: `??` controlla solo `null`, non `false` o `0`.

### Type Casting

```php
$valore = (int) '123';        // 123 — intero
$valore = (string) 123;       // '123' — stringa
$valore = (float) '3.14';     // 3.14 — float
$valore = (bool) 0;           // false — booleano
$valore = (array) $oggetto;   // Array dall'oggetto

// In Model Eloquent: $casts
protected $casts = [
    'in_evidenza' => 'boolean',
    'temperatura' => 'integer',
    'data_lancio' => 'date',
];
```

Conversione esplicita di tipo con parentesi. In PHP: `(int)`, `(string)`, `(bool)`, `(float)`, `(array)`, `(object)`. In Laravel: `$casts` del Model fa la conversione automatica dal database.

### Date & Carbon

```php
use Carbon\Carbon;

$oggi = Carbon::now();                    // Data e ora attuale
$ieri = Carbon::yesterday();
$domani = Carbon::tomorrow();

$now->addDays(5);                         // +5 giorni
$now->subHours(3);                        // -3 ore
$now->diffInDays($altra_data);            // Differenza in giorni
$now->format('d/m/Y H:i');               // Formattazione

Carbon::parse('2024-01-15')->isPast();    // true
Carbon::parse('2025-12-25')->isFuture();  // true
```

Carbon è il package di manipolazione date di Laravel. Estende DateTime di PHP. In Astralis: usato nelle date delle missioni (`data_lancio`), nei timestamp delle migration. Le migration usano `now()` che restituisce un'istanza Carbon.

---

## 8. Definizioni Laravel (26)

### Model

Classe che rappresenta una tabella del database. Ogni riga = un'istanza. `$fillable` = campi modificabili in massa. `$casts` = conversione tipi. Relazioni definite come metodi (belongsTo, hasMany, belongsToMany). `php artisan make:model CorpoCeleste -m` crea modello + migration. In Astralis: 5 Model in `app/Models/`.

### Eloquent ORM

L'ORM di Laravel. Ogni tabella ha un Model. Relazioni definite come metodi. Query builder con catene di metodi.

### Migration

File PHP che definisce/modify tabelle. `php artisan make:migration`. `up()` applica, `down()` annulla. Versionata con timestamp.

### Seeder

File che popola il database. `DatabaseSeeder.php` chiama i seeder specifici. `php artisan db:seed`.

### Factory

Classe che genera dati fake per test. `CorpoCeleste::factory()->create()`. Definita in `database/factories/`.

```bash
php artisan make:factory CorpoCelesteFactory
```

### Observer

Classe che ascolta eventi Eloquent: `created`, `updated`, `deleted`, `saving`, ecc. Registrato in `EventServiceProvider` o `boot()` del provider. Pattern: logica business separata dal controller.

```bash
php artisan make:observer CorpoCelesteObserver --model=CorpoCeleste
```

### Service Layer

Classe che gestisce logica di business complessa. Separata dal controller (HTTP) e dal modello (DB). Riusabile da controller, CLI, observer. Esempio: `NasaImageService`, `WordMapService`, `ImageUploadService`.

### Policy

Gruppo di permessi per un modello. Metodi: `viewAny`, `view`, `create`, `update`, `delete`. `before()` per logica generale (es. admin bypassa tutto).

```bash
php artisan make:policy CorpoCelestePolicy --model=CorpoCeleste
```

### Gate

Singola azione di autorizzazione. Definito in `AuthServiceProvider`. `Gate::define('admin', fn(User $user) => $user->is_admin)`. Usato con `Gate::authorize('admin')`.

### FormRequest

Classe dedicata alla validazione. `rules()` restituisce array di regole. `messages()` per messaggi custom. Il controller la inietta come parametro.

```bash
php artisan make:request StoreCorpoCelesteRequest
```

### Validation Rules

Regole di validazione per i campi. Si usano nei FormRequest (`rules()`) o direttamente nel controller (`$request->validate([...])`). Combinabili con `|`.

```php
'nome' => 'required|string|max:255',
'colore' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
'immagine_file' => 'nullable|image|max:2048',
'email' => 'required|email|unique:users,email',
'categoria_id' => 'required|exists:categorie,id',
```

Regole principali: `required`, `string`, `integer`, `max`, `min`, `email`, `unique`, `exists`, `nullable`, `image`, `regex`, `in`, `boolean`.

### Middleware

Livello intermedio che filtra richieste. `auth` = verifica login. `verified` = email verificata. `throttle:120,1` = max 120 richieste/minuto. Definito in `bootstrap/app.php`.

### Controller

Classe che gestisce la logica HTTP. Riceve la richiesta, interagisce con model/service, restituisce risposta (HTML o JSON). 7 metodi standard: index (lista), create (form), store (salva), show (dettaglio), edit (form modifica), update (aggiorna), destroy (elimina). `php artisan make:controller CorpoCelesteController -r`.

### Resource Controller

Controller con 7 metodi standard. `Route::resource('categorie', CategoriaController::class)` genera tutte le route CRUD.

### Artisan Commands

CLI di Laravel. `php artisan` + comando. Genera boilerplate, esegue task, gestisce il progetto. Comandi principali:

```bash
php artisan make:model CorpoCeleste -m    # Model + Migration
php artisan make:controller -r           # Resource Controller
php artisan make:request StoreXRequest   # FormRequest
php artisan make:policy XPolicy --model  # Policy
php artisan make:observer XObserver      # Observer
php artisan make:job XJob               # Job
php artisan make:factory XFactory       # Factory
php artisan migrate                     # Esegue migration
php artisan migrate:fresh --seed        # Reset DB + seed
php artisan serve                       # Avvia server locale
php artisan test                        # Esegue test PHPUnit
```

### Storage

Filesystem astratto. `Storage::disk('public')->put($path, $content)`. `storage/app/public/` per file accessibili web. `php artisan storage:link` per symlink.

### Cache

Memorizzazione risultati costosi. `Cache::remember('key', 3600, fn() => $data)`. TTL in secondi. Redis, Memcached, o file.

### Collection

Array potenziato di Laravel. `collect($array)` crea una collection. Metodi: `filter()`, `map()`, `pluck()`, `sum()`, `avg()`, `first()`, `sortBy()`, `groupBy()`, `toArray()`. Catena di metodi fluente.

```php
$nomi = collect($corpi)
    ->filter(fn($c) => $c->in_evidenza)
    ->pluck('nome')
    ->toArray();

$somma = collect($prodotti)->sum('prezzo');
$media = collect($prodotti)->avg('prezzo');
```

L'API Rest di Laravel restituisce sempre Collection. Eloquent `->get()` restituisce `Collection`.

### Blade

Template engine di Laravel. `{{ $variabile }}` stampa escaped. `@if`, `@foreach`, `@extends`, `@section`, `@include`. Componenti con `<x-nome />`.

### @include (Partial)

Inserisce il contenuto di un altro file Blade. Passa variabili con il secondo parametro array. Eredita tutte le variabili dal padre. Utile per pezzi di layout riutilizzati: header, sidebar, form, badge, azioni.

```php
@include('admin.partials.back-link', ['route' => 'admin.corpi-celesti.index'])
@include('admin.partials.stat-card', ['label' => 'Tipo', 'value' => $corpo->tipo ?? '—'])
```

In Astralis: 82 `@include` nell'admin — back-link, search, stat-card, category-badge, index-actions, empty-table-row, dashboard-stat, \_form.

### Componente Blade (`<x-...>`)

Componente riutilizzabile con props definite. Differenza da `@include`: ha scope isolato, props dichiarate con `@props`, riuso come tag HTML.

```php
<x-guest-layout>        <!-- Layout auth Breeze -->
<x-app-layout>          <!-- Layout admin con sidebar -->
```

In Astralis: usato solo nelle pagine auth Breeze e profilo. L'admin usa `@include` per i partiali.

### Differenza: Partial vs Componente

|           | Partial (`@include`)               | Componente (`<x-...>`)           |
| --------- | ---------------------------------- | -------------------------------- |
| Sintassi  | `@include('path')`                 | `<x-nome />`                     |
| Variabili | Esplicite nell'array               | `@props` dichiarati              |
| Scope     | Eredita tutto dal padre            | Isolato                          |
| Riuso     | Layout pezzi (form, badge, azioni) | UI atoms (layout, input, button) |

### Route Model Binding

Laravel risolve automaticamente il modello dalla route. `{corpoCeleste:slug}` usa lo slug invece dell'ID. `{corpoCeleste}` usa l'ID di default. Il controller riceve l'istanza del modello, non l'ID.

```php
// Route: Route::get('/corpi-celesti/{corpoCeleste:slug}', ...)
// Controller: public function show(CorpoCeleste $corpoCeleste)
// URL: /corpi-celesti/terra → risolve automaticamente il modello
```

Se non trova il modello → 404 automatico. `findOrFail()` è implicito.

### API Route

Route che restituisce JSON invece di HTML. Definita in `routes/api.php`, automaticamente prefissata con `/api`. Pubbliche (nessuna auth) o prottte con middleware. Controller dedicato in `app/Http/Controllers/Api/`. API Resource per trasformare il modello in JSON controllato.

### Job

Classe che esegue un task in background (queue). Utile per operazioni lunghe (import, email, processing). `ShouldBeUnique` evita duplicati. Dispatch: `ImportNasaImage::dispatch($url)`. Gestione errori con `failed()`. In Astralis: `ImportNasaImage` importa immagini NASA. `php artisan make:job`.

### Route Groups

Raggruppamento di route con prefisso, middleware o namespace condivisi. Riduce ripetizioni.

```php
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('categorie', CategoriaController::class);
});
```

`prefix('admin')` aggiunge `/admin` a tutte le route nel gruppo. `middleware('auth')` applica il middleware a tutte. In Astralis: route admin raggruppate in `routes/web.php`.

### Service Provider

Classe che registra servizi nel container di Laravel. Il punto di bootstrap dell'applicazione. `register()` registra i servizi, `boot()` esegue logica dopo che tutti i provider sono registrati.

```php
// app/Providers/AppServiceProvider.php
public function boot()
{
    // Logica che gira dopo tutti i provider
}
```

In Laravel 11+: `bootstrap/providers.php` elenca i provider. Il provider è dove registri binding custom, event listener, view composer, policy. In Astralis: `AuthServiceProvider` registra policy e gate.

### Eloquent Scopes

Metodi del Model che incapsulano query ricorrenti. Prefisso `scope` + nome camelCase. Accessibili come metodi del modello.

```php
// Nel Model CorpoCeleste
public function scopeInEvidenza($query)
{
    return $query->where('in_evidenza', true);
}

public function scopeByCategoria($query, $categoriaId)
{
    return $query->where('categoria_id', $categoriaId);
}

// Uso
CorpoCeleste::inEvidenza()->get();
CorpoCeleste::byCategoria(1)->orderBy('nome')->get();
```

Scopes rendono le query leggibili e riusabili. In Astralis: `scopeInEvidenza` per la homepage, `scopeByCategoria` per il catalogo filtrato.

### Autenticazione Breeze

**Cos'è**: Laravel Breeze è il package ufficiale di autenticazione. Fornisce login, register, profilo, reset password, verifica email — tutto pronto.

**Installazione**:

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
```

**Route generate** (`routes/auth.php`):

| Route                     | Metodo   | Cosa fa                  |
| ------------------------- | -------- | ------------------------ |
| `/login`                  | GET/POST | Form + login             |
| `/register`               | GET/POST | Form + registrazione     |
| `/logout`                 | POST     | Logout                   |
| `/forgot-password`        | GET/POST | Reset password via email |
| `/reset-password/{token}` | GET/POST | Form reset con token     |
| `/email/verify`           | GET      | Verifica email           |
| `/profile`                | GET/PUT  | Modifica profilo         |

**Middleware**:

- `auth` → verifica login, redirect a `/login` se non loggato
- `guest` → solo utenti non loggati (es. pagina login)
- `verified` → richiede email verificata

**Astralis**: Breeze Blade puro (non Inertia, rimosso). Route admin protette da middleware `auth`. Tema dark `#0A0A1A`. Admin demo: `admin@astralis.it` / `password`.

### CRUD — Resource Controller

**Cos'è**: Resource Controller è un controller con **7 metodi standard** che gestisce tutte le operazioni CRUD su un'entità.

**I 7 metodi**:

| #   | Metodo         | HTTP      | Cosa fa                   |
| --- | -------------- | --------- | ------------------------- |
| 1   | `index()`      | GET       | Lista tutti gli elementi  |
| 2   | `create()`     | GET       | Mostra form di creazione  |
| 3   | `store()`      | POST      | Salva il nuovo elemento   |
| 4   | `show($id)`    | GET       | Mostra dettaglio elemento |
| 5   | `edit($id)`    | GET       | Mostra form di modifica   |
| 6   | `update($id)`  | PUT/PATCH | Aggiorna l'elemento       |
| 7   | `destroy($id)` | DELETE    | Elimina l'elemento        |

**Comandi**:

```bash
# Crea Resource Controller
php artisan make:controller Admin/CategoriaController --resource

# Route resource (genera tutte le route CRUD)
Route::resource('categorie', CategoriaController::class);
```

**Route generate** (12 totali):

| Nome route          | HTTP      | URI                    | Metodo  |
| ------------------- | --------- | ---------------------- | ------- |
| `categorie.index`   | GET       | `/categorie`           | index   |
| `categorie.create`  | GET       | `/categorie/create`    | create  |
| `categorie.store`   | POST      | `/categorie`           | store   |
| `categorie.show`    | GET       | `/categorie/{id}`      | show    |
| `categorie.edit`    | GET       | `/categorie/{id}/edit` | edit    |
| `categorie.update`  | PUT/PATCH | `/categorie/{id}`      | update  |
| `categorie.destroy` | DELETE    | `/categorie/{id}`      | destroy |

**Esempio ridotto** (senza create/edit, come in Astralis):

```bash
Route::resource('categorie', CategoriaController::class)->except(['create', 'edit']);
```

**Astralis**: 8 controller admin, 13 FormRequest (Store/Update per ogni entità). Autorizzazione con Policy `before()` — admin bypassa tutto. Form con Alpine.js per interattività.

### Upload Media

**Cos'è**: Meccanica per caricare file (immagini, copertine, logo) dal form al server.

**Installazione**:

```bash
composer require intervention/image
```

**Configurazione storage**:

```bash
php artisan storage:link  # Crea symlink: public/storage → storage/app/public
```

**Nel controller**:

```php
// Salva il file nel disco 'public' nella cartella 'corpi'
$path = $request->file('immagine')->store('corpi', 'public');
// Risultato: "corpi/abc123.jpg"
// Percorso fisico: storage/app/public/corpi/abc123.jpg
// URL web: /storage/corpi/abc123.jpg
```

**Resize con Intervention Image v4**:

```php
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

$manager = new ImageManager(new Driver());
$image = $manager->decodePath($request->file('immagine'));
$image->scaleDown(1200, 1200);  // Preserva aspect ratio
$image->save(storage_path('app/public/' . $path));
```

> ⚠️ **Attenzione**: In Intervention Image v4, `Image::read()` è stato rinominato in `decodePath()`/`decodeBinary()`. La facade è stata rimossa.

**ImageUploadService (Astralis)**:
Service Layer che centralizza upload + resize + validazione. Riusabile da controller admin, observer, CLI.

```php
// Nel controller
$this->uploadService->upload($request->file('immagine'), 'corpi');
```

**Astralis — tipi di upload**:

| Entità        | Cartella    | Dimensione | Strumento              |
| ------------- | ----------- | ---------- | ---------------------- |
| Missioni      | `missioni/` | Logo 300px | ImageUploadService     |
| Galleria      | `galleria/` | 1200px     | ImageUploadService     |
| CorpiCelesti  | `corpi/`    | Copertina  | ImageUploadService     |
| Galleria NASA | —           | URL remoto | Niente download locale |

### Relazioni Eloquent

Le relazioni definiscono come i modelli Eloquent si collegano tra loro nel database. Laravel le dichiara come metodi nel modello e le risolve automaticamente nelle query.

**Tabella riassuntiva**:

| Tipo               | Direzione | Metodo Eloquent    | Tabella pivot | Esempio generico                |
| ------------------ | --------- | ------------------ | ------------- | ------------------------------- |
| **HasOne**         | 1 → 1     | `hasOne()`         | No            | User → Profile                  |
| **BelongsTo**      | N → 1     | `belongsTo()`      | No            | Post → User                     |
| **HasMany**        | 1 → N     | `hasMany()`        | No            | User → Post                     |
| **BelongsToMany**  | N → N     | `belongsToMany()`  | **Sì**        | Post ↔ Tag                      |
| **HasManyThrough** | 1 → N → N | `hasManyThrough()` | No            | Country → Posts (through Users) |

#### Cos'è una Foreign Key (FK)

Una **Foreign Key** è una colonna che collega una tabella a un'altra. "Ricorda" l'ID di un'altra tabella.

**Analogia**: un'etichetta sullo scrigno che dice "questo scrigno appartiene alla categoria X".

```php
// Nella migration della tabella figlia (corpi_celesti)
$table->foreignId('categoria_id')->constrained('categorie')->cascadeOnDelete();
```

| Pezzo                        | Cosa fa                                                             |
| ---------------------------- | ------------------------------------------------------------------- |
| `foreignId('categoria_id')`  | Crea la colonna`categoria_id` (unsigned big integer)                |
| `->constrained('categorie')` | Vincola: il valore DEVE esistere nella tabella`categorie`           |
| `->cascadeOnDelete()`        | Se elimini la categoria → elimina anche tutti i corpi celesti figli |

**Senza FK**: puoi inserire `categoria_id = 999` anche se la categoria 999 non esiste → dati orfani.
**Con FK**: il database blocca l'inserimento se la categoria 999 non esiste → integrità referenziale.

---

#### HasOne (1 → 1)

Una riga collegata esiste per ogni riga del modello. Esempio: ogni User ha un Profile.

```php
// Nel modello User
public function profile(): HasOne
{
    return $this->hasOne(Profile::class);
}
// $user->profile → singolo oggetto Profile
```

Non usato in Astralis: nessuna relazione 1→1 necessaria tra le entità.

---

#### BelongsTo (N → 1)

Ogni riga del modello appartiene a una riga di un altro modello. È il lato **"figlio"** della relazione 1-N.

```php
// Nel modello CorpoCeleste
public function categoria(): BelongsTo
{
    return $this->belongsTo(Categoria::class);
}
// $corpo->categoria → singola Categoria
```

Usato in Astralis per: CorpoCeleste→Categoria, GalleriaCorpo→CorpoCeleste, Curiosità→CorpoCeleste.

---

#### HasMany (1 → N)

Una riga del modello è collegata a più righe di un altro modello. È il lato **"padre"** della relazione 1-N.

```php
// Nel modello Categoria
public function corpiCelesti(): HasMany
{
    return $this->hasMany(CorpoCeleste::class);
}
// $categoria->corpiCelesti → Collection di CorpoCeleste
```

Usato in Astralis per: Categoria→CorpiCeleste, CorpoCeleste→Galleria, CorpoCeleste→Curiosità.

**Regola**: se `CorpoCeleste` ha `belongsTo(Categoria)`, allora `Categoria` ha `hasMany(CorpoCeleste)`. Sono le **due facce della stessa medaglia**.

---

#### BelongsToMany (N → N)

Molti modelli sono collegati a molti altri. Richiede una **tabella pivot** (tabella intermedia) che memorizza le foreign key di entrambi. La pivot può avere colonne aggiuntive.

```php
// Nel modello CorpoCeleste
public function missioni(): BelongsToMany
{
    return $this->belongsToMany(Missione::class, 'corpo_celeste_missione')
        ->withPivot('tipo_esplorazione', 'anno_arrivo');
}
// $corpo->missioni → Collection di Missione
// $corpo->missioni->first()->pivot->tipo_esplorazione
```

**Tabella pivot** `corpo_celeste_missione`:

| colonna             | tipo                              | Note                 |
| ------------------- | --------------------------------- | -------------------- |
| `id`                | bigIncrements                     | PK auto-incrementale |
| `corpo_celeste_id`  | FK → corpi_celesti                | cascadeOnDelete      |
| `missione_id`       | FK → missioni                     | cascadeOnDelete      |
| `tipo_esplorazione` | string(50), nullable              | dati aggiuntivi      |
| `anno_arrivo`       | year, nullable                    | dati aggiuntivi      |
| `unique`            | `[corpo_celeste_id, missione_id]` | no duplicati         |

**Cos'è `->withPivot()`?** Le colonne aggiuntive della pivot NON vengono caricate di default. `withPivot('colonna')` le include nella relazione.

Usato in Astralis per: CorpoCeleste↔Missione. Scelta giustificata: un corpo celeste può essere oggetto di più missioni (es. Voyager ha visitato più pianeti), e una missione può esplorare più corpi.

---

#### HasManyThrough (1 → N → N)

Una relazione indiretta: il modello A è collegato a molteplici modello C attraverso il modello B (che ha relazione 1-N con C).

```php
// Nel modello Country
public function posts(): HasManyThrough
{
    return $this->hasManyThrough(Post::class, User::class);
}
// $country->posts → Collection di Post (attraverso User)
```

Non usato in Astralis: le relazioni sono sufficientemente dirette senza bisogno di attraversamento.

---

#### Come creare una relazione — Comandi Artisan

##### Workflow relazione 1-N (es. Categoria → CorpoCeleste)

```bash
# 1. Crea il modello PADRE + migration
php artisan make:model Categoria -m

# 2. Crea il modello FIGLIO + migration
php artisan make:model CorpoCeleste -m
```

Nella **migration del figlio** (corpi_celesti), aggiungi la FK:

```php
$table->foreignId('categoria_id')
      ->constrained('categorie')
      ->cascadeOnDelete();
```

Nei **modelli**, definisci entrambe le facce:

```php
// PADRE (Categoria) — lato "ha molti"
public function corpiCelesti(): HasMany
{
    return $this->hasMany(CorpoCeleste::class);
}

// FIGLIO (CorpoCeleste) — lato "appartiene a"
public function categoria(): BelongsTo
{
    return $this->belongsTo(Categoria::class);
}
```

##### Workflow relazione N-N (es. CorpoCeleste ↔ Missione)

```bash
# 1. Crea i due modelli
php artisan make:model CorpoCeleste -m
php artisan make:model Missione -m

# 2. Crea la migration PIVOT (tabella intermedia)
php artisan make:migration create_corpo_celeste_missione_table
```

Nella **migration pivot**:

```php
Schema::create('corpo_celeste_missione', function (Blueprint $table) {
    $table->id();
    $table->foreignId('corpo_celeste_id')->constrained('corpi_celesti')->cascadeOnDelete();
    $table->foreignId('missione_id')->constrained('missioni')->cascadeOnDelete();
    $table->string('tipo_esplorazione', 50)->nullable();  // dati aggiuntivi
    $table->year('anno_arrivo')->nullable();                // dati aggiuntivi
    $table->unique(['corpo_celeste_id', 'missione_id']);   // no duplicati
    $table->timestamps();
});
```

Nei **modelli** (entrambi):

```php
// CorpoCeleste
public function missioni(): BelongsToMany
{
    return $this->belongsToMany(Missione::class, 'corpo_celeste_missione')
        ->withPivot('tipo_esplorazione', 'anno_arrivo');
}

// Missione
public function corpiCelesti(): BelongsToMany
{
    return $this->belongsToMany(CorpoCeleste::class, 'corpo_celeste_missione')
        ->withPivot('tipo_esplorazione', 'anno_arrivo');
}
```

**Nota**: il nome della tabella pivot segue la convenzione: `nomeplurale_modello1_nomeplurale_modello2` in ordine alfabetico (`corpo_celeste_missione`, non `missione_corpo_celeste`).

---

#### Come usare le relazioni nelle query

```php
// Eager loading (evita problema N+1)
$corpi = CorpoCeleste::with('categoria')->get();  // 2 query, non 1+N

// Accesso diretto
$nomeCategoria = $corpo->categoria->nome;  // "Pianeta"

// Filtraggio per relazione
$corpi = CorpoCeleste::whereHas('categoria', fn($q) => $q->where('nome', 'Pianeta'))->get();

// Conteggio relazioni
$categorie = Categoria::withCount('corpiCelesti')->get();
// Ogni categoria avrà: $categoria->corpi_celesti_count

// Eager loading multipli
$corpo = CorpoCeleste::with(['categoria', 'galleria', 'curiosita', 'missioni'])->first();
```

**Problema N+1**: quando in un loop accedi a una relazione senza eager loading.

```php
// ❌ SBAGLIATO: 10 corpi × 1 categoria = 11 query
$corpi = CorpoCeleste::all();
foreach ($corpi as $corpo) {
    echo $corpo->categoria->nome;  // Query separata ogni volta!
}

// ✅ CORRETTO: 2 query totali
$corpi = CorpoCeleste::with('categoria')->get();
foreach ($corpi as $corpo) {
    echo $corpo->categoria->nome;  // Già caricato, zero query extra
}
```

---

#### Perché queste relazioni — riferimento alla traccia

La traccia richiede:

> "Deve esserci almeno una seconda entità collegata alla prima con relazione 1-N o N-N." (progetto-finale.md:30)

> "Più relazioni implementate, più completo sarà il vostro gestionale!" (progetto-finale.md:43)

| Requisito traccia         | Realizzato in Astralis                                                                 |
| ------------------------- | -------------------------------------------------------------------------------------- |
| "almeno una 1-N"          | 3 relazioni 1-N: Categoria→CorpiCeleste, CorpoCeleste→Galleria, CorpoCeleste→Curiosità |
| "o N-N"                   | 1 relazione N-N: CorpoCeleste↔Missione (con pivot`corpo_celeste_missione`)             |
| "CRUD per seconda entità" | 4 CRUD secondari: Categoria, Missione, Curiosità, Galleria — tutte con CRUD completo   |

---

#### Domande esame tipiche

**Q: Cos'è una Foreign Key?**
→ È una colonna che collega una tabella a un'altra. Esempio: `categoria_id` nella tabella `corpi_celesti` punta all'ID della tabella `categorie`. Il database verifica che il valore esista. Senza FK puoi inserire ID inesistenti.

**Q: Qual è la differenza tra HasMany e BelongsTo?**
→ Sono le due facce della stessa relazione 1-N. `HasMany` è sul lato padre ( Categoria → ha molti corpi). `BelongsTo` è sul lato figlio (CorpoCeleste → appartiene a una categoria). Ogni relazione 1-N richiede entrambi.

**Q: Cos'è una tabella pivot?**
→ Tabella intermedia che risolve una relazione N-N. Contiene solo le FK dei due modelli + eventuali colonne aggiuntive. Esempio: `corpo_celeste_missione` collega CorpoCeleste e Missione con `tipo_esplorazione` e `anno_arrivo`.

**Q: Quando usare cascadeOnDelete?**
→ Quando elimina il padre deve eliminare anche i figli. In Astralis: `categoria_id->constrained()->cascadeOnDelete()` → elimino "Pianeta" → elimino anche tutti i corpi celesti di quella categoria. Utile per pulizia automatica.

**Q: Cos'è il problema N+1 e come lo risolvi?**
→ Quando in un loop accedi a una relazione senza eager loading: N query extra. Soluzione: `CorpoCeleste::with('categoria')` carica tutto in anticipo con 2 query invece di 1+N.

**Q: Perché N-N per missioni e non 1-N?**
→ Perché una missione spaziale può esplorare più corpi celesti (Voyager 1 ha visitato Giove, Saturno, Urano, Nettuno) E un corpo celeste può essere stato esplorato da più missioni (Marte: Curiosity, Perseverance, InSight...). La tabella pivot memorizza anche dati extra: `tipo_esplorazione` e `anno_arrivo`.

### Eager Loading

Carica le relazioni in anticipo per evitare N+1 query. `CorpoCeleste::with(['categoria', 'galleria'])` fa 2 query invece di 1 + N.

### API Resource

Trasforma un modello in JSON. `CorpoCelesteResource` seleziona campi da esporre. Espone `nome` (italiano) per il frontend guest. Protegge dati interni. `php artisan make:resource`.

### API e REST — Definizioni e Implementazione

#### Cos'è un'API

**API** = Application Programming Interface. È un contratto che definisce come due software comunicano tra loro.

**Analogia**: un cameriere in ristorante.

- Il **cliente** (React frontend) fa un ordine: "Voglio la lista dei pianeti"
- Il **cameriere** (API) porta la richiesta alla cucina (Laravel backend)
- La **cucina** prepara il piatto (query al database)
- Il cameriere **restituisce** il piatto (risposta JSON)

```javascript
// React (cliente) chiama l'API
const response = await fetch("/api/corpi-celesti");
const data = await response.json(); // JSON con 18 corpi celesti
```

```php
// Laravel (cucina) restituisce i dati
public function index(): JsonResponse
{
    return CorpoCelesteResource::collection(CorpoCeleste::all());
}
```

In Astralis: l'API è il **ponte** tra il React guest (SPA standalone) e il database MySQL.

---

#### API vs Route — Qual è la differenza?

|                      | **Route web** (Blade)                | **API** (JSON)                   |
| -------------------- | ------------------------------------ | -------------------------------- |
| **Cosa restituisce** | HTML (pagina intera)                 | JSON (solo dati)                 |
| **Chi la usa**       | Browser umano                        | JavaScript (React, fetch, axios) |
| **Autenticazione**   | Session + cookie (Breeze)            | API pubbliche (o token)          |
| **Dove in Laravel**  | `routes/web.php`                     | `routes/api.php`                 |
| **Template**         | Blade (`@extends`, `@section`)       | Nessuno (JSON puro)              |
| **Esempio Astralis** | `/admin/corpi-celesti` → vista Blade | `/api/corpi-celesti` → JSON      |

```php
// Route web → restituisce HTML (Blade)
Route::get('/admin/corpi-celesti', [CorpoCelesteController::class, 'index'])
    ->name('admin.corpi-celesti.index');

// Route API → restituisce JSON
Route::get('/corpi-celesti', [CorpoCelesteController::class, 'index']);
```

**Regola pratica**: se il consumatore è un browser umano → route web. Se il consumatore è del codice JavaScript → API.

---

#### Cos'è lo standard REST?

**REST** = REpresentational State Transfer. Non è un protocollo, è un **stile architetturale** per progettare API web. Definito da Roy Fielding nel 2000.

**6 vincoli** (in parole semplici):

| #   | Vincolo                        | Cosa significa                                | In Astralis                                   |
| --- | ------------------------------ | --------------------------------------------- | --------------------------------------------- |
| 1   | **Client-Server**              | Frontend e backend sono separati              | React (client) ↔ Laravel (server)             |
| 2   | **Stateless**                  | Ogni richiesta è indipendente                 | API senza sessione; ogni GET è autoconsistent |
| 3   | **Cacheable**                  | Le risposte possono essere cachate            | Cache su stats (1h) e corpi-celesti (5min)    |
| 4   | **Layered System**             | Il client non sa cosa c'è tra lui e il server | Vite proxy inoltra`/api` a `localhost:8000`   |
| 5   | **Uniform Interface**          | URL = risorse, HTTP methods = azioni          | `/api/corpi-celesti` è sempre una risorsa     |
| 6   | **Code on Demand** (opzionale) | Il server può inviare codice eseguibile       | Non usato in Astralis                         |

**In pratica**: REST dice che le URL devono rappresentare **risorse** (nomi, non verbi) e gli HTTP methods devono rappresentare **azioni**.

```
✅ REST: GET /api/corpi-celesti          (leggi tutte le risorse)
✅ REST: GET /api/corpi-celesti/terra    (leggi una risorsa specifica)
❌ Non REST: GET /api/getCorpiCelesti    (URL contiene un verbo)
❌ Non REST: POST /api/deleteCorpo/5     (DELETE non dovrebbe essere POST)
```

---

#### Metodi HTTP

| Metodo        | Cosa fa              | Astralis                    | Status codes                                |
| ------------- | -------------------- | --------------------------- | ------------------------------------------- |
| **GET**       | Legge una risorsa    | ✅ 10 endpoint API pubblici | 200 (ok), 404 (non trovato)                 |
| **POST**      | Crea una risorsa     | ✅ Solo admin (autenticato) | 201 (creato), 422 (validazione fallita)     |
| **PUT/PATCH** | Aggiorna una risorsa | ✅ Solo admin (autenticato) | 200 (aggiornato), 422 (validazione fallita) |
| **DELETE**    | Elimina una risorsa  | ✅ Solo admin (autenticato) | 204 (eliminato), 404 (non trovato)          |

**Status codes più importanti**:

| Code                         | Significato                | Quando in Astralis                               |
| ---------------------------- | -------------------------- | ------------------------------------------------ |
| **200** OK                   | Richiesta riuscita         | Tutte le GET che restituiscono dati              |
| **201** Created              | Risorsa creata             | `store()` admin — crea un corpo celeste          |
| **204** No Content           | Eliminata con successo     | `destroy()` admin — elimina una curiosità        |
| **404** Not Found            | Risorsa inesistente        | Slug non trovato (Route Model Binding)           |
| **422** Unprocessable Entity | Dati di validazione errati | FormRequest fallita (campi obbligatori mancanti) |
| **429** Too Many Requests    | Throttle exceeded          | >60 req/min API, >120 req/min admin              |
| **500** Server Error         | Errore interno             | Bug, cache rotta, DB down                        |

---

#### Cosa sono gli API Resource?

Un **API Resource** è una classe che trasforma un modello Eloquent in JSON controllato. Decide **quali campi** esporre e **quali nascondere**.

**Perché serve**: il modello Eloquent ha tutti i campi (inclusi dati interni). L'API Resource seleziona solo ciò che il frontend ha bisogno.

```php
// Senza Resource → esponi TUTTO (inclusi dati interni)
return response()->json(CorpoCeleste::find(1));

// Con Resource → controlli cosa esporre
return new CorpoCelesteResource(CorpoCeleste::find(1));
```

**Esempio concreto**: `CorpoCelesteResource` espone `nome` (italiano) ma **nasconde** `immagine_utente` (boolean, interno al sistema).

##### Creare un API Resource

```bash
php artisan make:resource CorpoCelesteResource
```

Crea il file `app/Http/Resources/CorpoCelesteResource.php`:

```php
class CorpoCelesteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,           // Esposto: il frontend lo usa
            'slug' => $this->slug,
            'categoria' => new CategoriaResource($this->whenLoaded('categoria')),
            'immagine_url' => $this->immagine_url,
            // 'immagine_utente' => ...      // NON esposto: è un dato interno
        ];
    }
}
```

**Nel controller**:

```php
public function show(CorpoCeleste $corpoCeleste): CorpoCelesteResource
{
    $corpoCeleste->load(['categoria', 'galleria', 'curiosita', 'missioni']);
    return new CorpoCelesteResource($corpoCeleste);
}
```

**5 API Resource in Astralis**:

| Resource                | Modello       | Note                                                    |
| ----------------------- | ------------- | ------------------------------------------------------- |
| `CorpoCelesteResource`  | CorpoCeleste  | Adaptive: cambia output in base a`?detail=true`         |
| `CategoriaResource`     | Categoria     | Include`corpi_count` quando caricato                    |
| `MissioneResource`      | Missione      | Smart URL: risolve remote vs locale + conditional pivot |
| `CuriositaResource`     | Curiosita     | Include corpo celeste padre                             |
| `GalleriaCorpoResource` | GalleriaCorpo | Accessor`percorso_url` per URL remote/locali            |

---

#### Come Astralis implementa REST

**10 endpoint API**, tutti GET, tutti pubblici:

| #   | Route                              | Metodo | Cosa restituisce            | Filtri                                                        |
| --- | ---------------------------------- | ------ | --------------------------- | ------------------------------------------------------------- |
| 1   | `/api/corpi-celesti`               | GET    | Lista corpi (paginata)      | `?categoria`, `?tipo`, `?search`, `?in_evidenza`, `?per_page` |
| 2   | `/api/corpi-celesti/{slug}`        | GET    | Dettaglio corpo             | Eager load: categoria, galleria, curiosità, missioni          |
| 3   | `/api/corpi-celesti/{slug}/simili` | GET    | Max 4 corpi simili          | Stessa categoria, esclude quello corrente                     |
| 4   | `/api/categorie`                   | GET    | Tutte le categorie          | Nessun filtro                                                 |
| 5   | `/api/categorie/{slug}`            | GET    | Dettaglio categoria + corpi | Eager load: corpiCelesti con galleria                         |
| 6   | `/api/missioni`                    | GET    | Lista missioni (paginata)   | `?agenzia`, `?stato`                                          |
| 7   | `/api/missioni/{slug}`             | GET    | Dettaglio missione + corpi  | Eager load: corpiCelesti con categoria e galleria             |
| 8   | `/api/curiosita`                   | GET    | Lista curiosità (paginata)  | Nessun filtro                                                 |
| 9   | `/api/galleria`                    | GET    | Lista galleria (paginata)   | Ordinamento per`ordine` + `created_at`                        |
| 10  | `/api/dashboard/stats`             | GET    | Statistiche generali        | Cache 1 ora, raw SQL aggregation                              |

**Pattern avanzati implementati**:

| Pattern                        | Come funziona                                                | Perché                                               |
| ------------------------------ | ------------------------------------------------------------ | ---------------------------------------------------- |
| **Route Model Binding (slug)** | `{corpoCeleste:slug}` invece di `{id}`                       | URL leggibili, SEO-friendly                          |
| **Adaptive Resource**          | `CorpoCelesteResource` cambia output (list vs detail)        | Stessa route, meno dati in lista, tutto in dettaglio |
| **Cache ID-based**             | Cachea solo gli ID (`pluck('id')`), re-query con `whereIn()` | Evita serializzazione rotta di Collection            |
| **Throttle**                   | `throttle:60,1` su API, `throttle:120,1` su admin            | Protezione da abuso                                  |
| **Eager Loading**              | `with(['categoria', 'galleria'])`                            | Previene problema N+1                                |
| **per_page bounds**            | `max(1, min($request->integer('per_page', 12), 100))`        | Default 12 (corpi) o 20 (altri), max 100             |

---

#### REST puro vs Astralis — dove si discosta e perché

| REST puro                           | Astralis                                           | Perché la deviazione                           |
| ----------------------------------- | -------------------------------------------------- | ---------------------------------------------- |
| CRUD con GET/POST/PUT/DELETE su API | Solo GET pubbliche, POST/PUT/DELETE in admin Blade | Il guest non deve creare/modificare/eliminare  |
| Auth su tutte le API                | API completamente pubbliche                        | Il visitatore deve poter esplorare senza login |
| OAuth/JWT per auth API              | Session + Breeze solo per admin                    | Breeze è sufficiente per un progetto esame     |
| Cache su tutte le GET               | Cache solo su 2 endpoint (stats + corpi)           | Gli altri endpoint hanno poco traffico         |
| HATEOAS (link ipertestuali)         | No                                                 | Complessità non necessaria per l'esame         |
| Versioning (`/api/v1/`)             | No                                                 | Un solo versione, non serve                    |

**Nota per l'esame**: queste deviazioni sono **scelte progettuali deliberate**, non errori. Spiegarle dimostra comprensione dello standard REST e capacità di adattarlo al contesto reale.

---

#### Domande esame tipiche

**Q: Cos'è un'API?**
→ Application Programming Interface. È un contratto che definisce come due software comunicano. In Astralis: React (client) chiama Laravel (server) tramite endpoint JSON.

**Q: Qual è la differenza tra route web e API?**
→ Route web restituisce HTML (pagine Blade) per browser umani. API restituisce JSON per codice JavaScript. Route web: `routes/web.php`. API: `routes/api.php`.

**Q: Cos'è REST?**
→ REpresentational State Transfer. Stile architetturale con 6 vincoli: client-server, stateless, cacheable, layered system, uniform interface, code on demand. In pratica: URL = risorse, methods = azioni, JSON = formato.

**Q: Perché solo GET nelle API pubbliche?**
→ Il guest non deve creare, modificare o eliminare dati. Le operazioni CRUD sono solo nell'admin autenticato. Le API pubbliche servono solo a leggere i dati per il frontend React.

**Q: Come gestisci la paginazione?**
→ `LengthAwarePaginator` manuale (corpi-celesti) o `->paginate()` (altri). Default 12-20, max 100. Parametri: `?page=N&per_page=N`.

**Q: Perché lo slug invece dell'ID nelle URL?**
→ URL leggibili e SEO-friendly: `/api/corpi-celesti/terra` invece di `/api/corpi-celesti/3`. Laravel risolve automaticamente con Route Model Binding: `{corpoCeleste:slug}`.

---

## 9. Definizioni React (15)

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

### Key prop

Prop speciale nelle liste. `key={item.id}` identifica univocamente ogni elemento. Aiuta React a capire quali elementi sono stati aggiunti/rimossi/riordinati. Senza key, React rirenderizza tutta la lista.

```jsx
{
    corpi.map((corpo) => <CorpoCard key={corpo.id} corpo={corpo} />);
}
```

Usa sempre ID univoci come key, mai l'indice dell'array (`key={index}` → problemi con riordinamento).

### Virtual DOM

Copia leggera del DOM reale. React calcola la differenza (diffing) e aggiorna solo le parti cambiate del DOM reale. Più performante che manipolare il DOM direttamente.

### Custom Hook

Funzione che inizia con `use` e usa altri hook. `useFetch(url)` usa `useState` + `useEffect` + `AbortController`. Riutilizzabile tra componenti.

### Error Boundary

Class component con `componentDidCatch()`. Cattura errori nei figli. Non cattura errori in event handlers o codice async. In Astralis: in `App.jsx` avvolge `<Routes>`.

### React.memo()

`React.memo(Component)` → il componente non re-renderizza se le props non cambiano. Ottimizzazione per componenti costosi. Differenza: `useMemo()` memoizza un valore, `useCallback()` memoizza una funzione.

### Conditional rendering

Mostrare/nascondere elementi in base a condizioni. 3 pattern principali:

```jsx
// 1. && (and) — mostra se vero
{
    isLoaded && <CorpoCard />;
}

// 2. Ternario — mostra A o B
{
    error ? <Error message={error} /> : <CorpoCard />;
}

// 3. Early return — ritorna nulla se condizione non soddisfatta
if (!corpo) return null;
return <CorpoCard corpo={corpo} />;
```

In React non puoi usare `if/else` direttamente nel JSX (solo espressioni). Il ternario e `&&` sono i pattern più comuni.

### AbortController

Cancella fetch in corso. `const controller = new AbortController()` → `fetch(url, { signal: controller.signal })` → `controller.abort()` nel cleanup di `useEffect`. Evita memory leak.

### requestAnimationFrame

API del browser per animazioni fluenti. `callback` viene chiamato prima del repaint del browser. In Astralis: orbite del sistema solare. Più performante di `setInterval` perché si sincronizza con il refresh rate del display.

### useRef

Hook che crea un riferimento mutabile. Utile per: accedere a un elemento DOM, persistere valori tra render senza triggerare re-render, salvare timer/interval.

```jsx
const inputRef = useRef(null);
const prevValue = useRef("");

// Accesso DOM
<input ref={inputRef} />;
inputRef.current.focus();

// Persistenza senza re-render
useEffect(() => {
    prevValue.current = newValue;
}, [newValue]);
```

`useRef` restituisce `{ current:值 }`. A differenza di `useState`, modificare `.current` **non** causa re-render. In Astralis: usato in `useDebounce` per salvare timer/timeout senza re-render.

---

## 10. CORS & Sicurezza

### CORS (Cross-Origin Resource Sharing)

Il browser blocca richieste da un dominio a un altro. In Astralis: React (`localhost:5175`) chiama Laravel (`localhost:8000`).

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

| Errore                                  | Perché è sbagliato                           | Cosa fare invece                                    |
| --------------------------------------- | -------------------------------------------- | --------------------------------------------------- |
| `Image::read()` in Intervention v4      | La facade è stata rimossa in v4              | `new ImageManager(new Driver())->decodePath($path)` |
| `resize()` invece di `scaleDown()`      | `resize()` forza le dimensioni e distorce    | `scaleDown(width, height)` preserva aspect ratio    |
| Dimenticare`Http::fake()` nei test      | L'observer dispatcha job NASA → test falliti | `Http::fake()` in setUp()                           |
| Dimenticare eager loading nelle show    | **N+1 problem**: N query extra               | `::with(['relazione'])->firstOrFail()`              |
| Usare`->get()` invece di `->paginate()` | Carica tutto in memoria                      | `->paginate(20)` con `->withQueryString()`          |
| `@if` senza `@endif` in Blade           | Errore 500 silenzioso                        | Controllare chiusura if/foreach                     |
| Dimenticare`->constrained()` FK         | FK non reale                                 | `$table->foreignId('x_id')->constrained()`          |
| Mantenere Inertia quando non serve      | Dipendenze inutili, conflitti routing        | Rimuovere se SPA standalone                         |
| `$fillable` senza tutti i campi         | Mass assignment exception                    | Aggiungere TUTTI i campi modificabili               |

---

## 12. Live Coding — 4 Esercizi con Soluzione

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

### Esercizio 4: Somma + Filter + Map (combinato)

**Traccia**: L'esaminatore ti fornisce un array di oggetti. Devi:

1. Calcolare la somma totale di un campo numerico
2. Filtrare gli elementi che superano una soglia
3. Creare un nuovo array con solo i campi richiesti

**Dati dell'esaminatore**:

```php
$prodotti = [
    ['nome' => 'Penna', 'prezzo' => 5, 'categoria' => 'cancelleria'],
    ['nome' => 'Quaderno', 'prezzo' => 12, 'categoria' => 'cancelleria'],
    ['nome' => 'Matita', 'prezzo' => 3, 'categoria' => 'cancelleria'],
    ['nome' => 'Libro', 'prezzo' => 25, 'categoria' => 'libri'],
    ['nome' => 'Zaino', 'prezzo' => 40, 'categoria' => 'accessori'],
    ['nome' => 'Astuccio', 'prezzo' => 8, 'categoria' => 'accessori'],
];
```

**Step 1 — Somma totale**:

```php
$sommaTotale = collect($prodotti)->sum('prezzo'); // 93
```

**Step 2 — Filtra per prezzo > 10**:

```php
$filtrati = collect($prodotti)
    ->filter(fn($p) => $p['prezzo'] > 10)
    ->values()
    ->toArray();
```

**Step 3 — Mappa: solo nomi dei filtrati**:

```php
$nomi = array_map(fn($p) => $p['nome'], $filtrati);
// ['Quaderno', 'Libro', 'Zaino']
```

**Step 4 — Somma solo dei filtrati**:

```php
$sommaFiltrati = collect($filtrati)->sum('prezzo'); // 77
```

**Soluzione PHP base** (senza collect):

```php
$sommaTotale = 0;
$filtrati = [];
foreach ($prodotti as $p) {
    $sommaTotale += $p['prezzo'];
    if ($p['prezzo'] > 10) {
        $filtrati[] = $p;
    }
}
$nomi = array_map(fn($p) => $p['nome'], $filtrati);
```

**Variante esame**: "Calcola la media dei prezzi, poi restituisci solo gli articoli sopra la media."

```php
$media = collect($prodotti)->avg('prezzo'); // 15.5
$sopraMedia = collect($prodotti)
    ->filter(fn($p) => $p['prezzo'] > $media)
    ->values()
    ->toArray();
// [{nome: 'Libro', prezzo: 25}, {nome: 'Zaino', prezzo: 40}]
```

---

## 13. Comandi Rapidi

```bash
# Avvio
php artisan serve              # Backend → localhost:8000
npm run dev                    # Frontend → localhost:5175

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

| Ruolo              | Email                               | Password |
| ------------------ | ----------------------------------- | -------- |
| **Admin**          | admin@astralis.it                   | password |
| **Utente normale** | (registrazione libera su /register) | —        |

---

_Generato il 21/07/2026 — Astralis v13.18_
