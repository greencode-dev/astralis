# Test — Astralis

Suite di test per backend (PHPUnit) e frontend React (Vitest).

## Esecuzione

### Backend (PHPUnit) — 270 test, 613 assertion

```bash
php artisan test                              # Tutti
php artisan test tests/Unit/...               # Unit
php artisan test tests/Feature/Api/           # API
php artisan test tests/Feature/Admin/...      # Admin CRUD
```

### Frontend React (Vitest) — 110 test

```bash
npm test                                       # Tutti (vitest run)
npm run test:watch                             # Modalità watch
npx vitest run resources/js/guest/test/CorpoCard.test.jsx   # Singolo file
```

## Configurazione

### PHPUnit

- **Database**: SQLite `:memory:` — ogni test parte con DB pulito (`RefreshDatabase`)
- **Ambiente**: `APP_ENV=testing` — disabilita `CorpoCelesteObserver` (non chiama NASA)
- **HTTP**: `Http::fake()` mocka tutte le chiamate verso `images-api.nasa.gov/*` — nessuna connettività esterna
- **Cache/Session**: array in memoria
- **Factory**: tutti i 5 modelli hanno `HasFactory`; `CorpoCelesteFactory` crea automaticamente una `Categoria` associata

### Vitest

- **Config**: `vitest.config.js` — environment `jsdom`, `globals: true`
- **Setup**: `resources/js/guest/test/setup.js` — import `@testing-library/jest-dom`
- **Dipendenza network**: nessuna — i componenti vengono montati in DOM simulato (jsdom)

## Struttura

### Unit — `tests/Unit/` (5 file, 58 test)

#### `NasaImageServiceTest.php` (26 test, 63 assertion)

Testa `App\Services\NasaImageService` — il service che importa immagini da NASA Image API.

| Gruppo | N. test | Cosa copre |
|---|---|---|
| **searchNasa** | 5 | Successo con response mockata, fallimento con items vuoti, fallback su query stripped (`"Earth's Moon"` → `"Earth Moon"`), fallback extra (parametro `$extraFallbacks`), continuazione su HTTP 500 |
| **extractMetadata** | 3 | Estrazione campi (nasa_id, title, photographer, description, keywords), chiavi mancanti → null, fallback `photographer` → `secondary_creator` |
| **pickImageUrl** | 5 | Priorità alternate → preview → canonical, nessun link → null, link solo video (render=video) → null |
| **importForBody** | 10 | Skip se immagine già presente e `$force=false`, Force overwrite immagine principale, Force non sovrascrive `immagine_utente=true`, Creazione voci galleria (didascalia, crediti, ordine), Deduplicazione galleria (stesso URL skippato), `$updateDescription=true` aggiorna `descrizione`, `$updateDescription=false` non modifica, Ricerca NASA fallisce → `success=false`, Fallback "comet" per comete/Halley, Item senza URL immagine → `errors[]` |
| **importAll** | 2 | Conteggi corretti (success, total, total_main) con tutti riusciti, Conteggi corretti con successi parziali |

#### `WordMapServiceTest.php` (8 test)

Testa `App\Services\WordMapService` — traduzione italiano→inglese per NASA suggest.

| Gruppo | N. test | Cosa copre |
|---|---|---|
| **translate** | 6 | Parola nota, più parole, preposizioni rimosse, parola sconosciuta, stringa vuota, nomi pianeti |
| **guessEnglishName** | 2 | Match per titolo NASA, fallback al primo risultato |

#### `CleanupGalleryDuplicatesTest.php` (9 test)

Testa `astralis:gallery` artisan command — deduplicazione, orphans, remote URLs.

| Gruppo | N. test | Cosa copre |
|---|---|---|
| **dedup** | 2 | Rimuove duplicati tenendo il primo, dry-run preserva duplicati |
| **orphans** | 3 | No duplicati → warning, clean orphans, check + dry-run preserva orphans |
| **remote** | 2 | URL rotto → OK, URL valido → OK |
| **edge cases** | 2 | Diversi corpi stesso path non dedupati

#### `CorpoCelesteTest.php` (6 test)

Testa accessors del model `CorpoCeleste`.

| Gruppo | N. test | Cosa copre |
|---|---|---|
| **nome_display** | 3 | Restituisce `nome` (italiano) se presente, fallback a `nome_en`, null safety |
| **immagine_url** | 3 | URL remoto, fallback placeholder, null safety |

#### `ImportNasaImageTest.php` (9 test)

Testa il job `ImportNasaImage` per la coda di importazione NASA.

| Gruppo | N. test | Cosa copre |
|---|---|---|
| **job properties** | 5 | Implements ShouldQueue, ShouldBeUnique, tries=3, timeout=60, uniqueId |
| **defaults** | 2 | Valori default proprietà (galleryCount=5, force=false, updateDescription=false) |
| **testing guard** | 1 | handle() è no-op in ambiente testing |
| **failed logging** | 1 | failed() logga errore via Log::error

#### Pattern usati

- `Http::fake()` con response fissa o callback (`function ($request) { ... }`)
- `Http::fake()` con contatore `$calls` per simulare fallback progressivo
- `CorpoCeleste::factory()->create([...])` per creare record di test
- `$corpo->fresh()` per ricaricare dal DB dopo update
- `GalleriaCorpo::where(...)->get()` per verificare creazione voci galleria

### Feature API — `tests/Feature/Api/` (9 file)

Testano gli endpoint JSON pubblici in `routes/api.php`.

| File | Test | Endpoint testati |
|---|---|---|
| `CorpoCelesteApiTest.php` | 10 | `GET /api/corpi-celesti` — paginazione (default 12, max 100), filtri per categoria (slug), tipo, search (nome/descrizione), in_evidenza. `GET /api/corpi-celesti/{slug}` — dettaglio con relazioni. `GET /api/corpi-celesti/{id}/simili` — max 4, exclude stesso |
| `CategoriaApiTest.php` | 4 | `GET /api/categorie` — tutti. `GET /api/categorie/{slug}` — dettaglio. 404 |
| `MissioneApiTest.php` | 4 | `GET /api/missioni` — tutti. `GET /api/missioni/{slug}` — dettaglio. 404 |
| `CuriositaApiTest.php` | 2 | `GET /api/curiosita` — tutti |
| `GalleriaApiTest.php` | 2 | `GET /api/galleria` — tutti |
| `DashboardApiTest.php` | 4 | `GET /api/dashboard/stats` — conteggi corpi, categorie, missioni |
| `ApiEdgeCaseTest.php` | 17 | Percent/underscore escaping, per_page zero → 1, agenzia+stato filters, empty DB, factory, dashboard empty, galleria/curiosita includes |

### Feature Admin — 13 file

#### `CorpoCelesteCrudTest.php` (13 test)

| Test | Cosa verifica |
|---|---|
| Guest redirect | Visita index → redirect `/login` |
| Admin index | `GET /admin/corpi-celesti` → 200 |
| Admin create form | `GET /admin/corpi-celesti/create` → 200 |
| Admin store | `POST /admin/corpi-celesti` → redirect + record in DB |
| Store validazione | Campi vuoti → session errors |
| Store unique nome | Nome duplicato → session errors |
| Admin show | `GET /admin/corpi-celesti/{id}` → 200 |
| Admin edit | `GET /admin/corpi-celesti/{id}/edit` → 200 |
| Admin update | `PUT /admin/corpi-celesti/{id}` → redirect, nome aggiornato |
| Update stesso nome | `PUT` con nome invariato → ok |
| Admin delete | `DELETE /admin/corpi-celesti/{id}` → redirect, record rimosso |
| Non-admin store | 403 |
| Non-admin delete | 403 |

#### `CategoriaCrudTest.php` (14 test)

| Test | Cosa verifica |
|---|---|
| Guest redirect | `GET /admin/categorie` → `/login` |
| Admin index | 200 |
| Admin create | 200 |
| Admin store | `POST` → redirect + record in DB |
| Store validazione | Nome vuoto → errors |
| Store unique nome | Nome duplicato → errors |
| Admin show | 200 |
| Admin edit | 200 |
| Admin update | `PUT` → redirect, nome aggiornato |
| Update stesso nome | `PUT` nome invariato → ok |
| Delete con corpi | `DELETE` con corpi associati → error + record preserved |
| Admin delete | `DELETE` senza corpi → redirect, record rimosso |
| Non-admin store | 403 |
| Non-admin delete | 403 |

#### `MissioneCrudTest.php` (13 test)

| Test | Cosa verifica |
|---|---|
| Guest redirect | `GET /admin/missioni` → `/login` |
| Admin index | 200 |
| Admin create | 200 |
| Admin store | `POST` → redirect + record in DB |
| Store validazione | Nome vuoto → errors |
| Store unique nome | Nome duplicato → errors |
| Admin show | 200 |
| Admin edit | 200 |
| Admin update | `PUT` → redirect, nome aggiornato |
| Update stesso nome | `PUT` nome invariato → ok |
| Admin delete | `DELETE` → redirect, record rimosso |
| Non-admin store | 403 |
| Non-admin delete | 403 |

#### `CuriositaCrudTest.php` (10 test)

| Test | Cosa verifica |
|---|---|
| Guest redirect | `GET /admin/curiosita` → `/login` |
| Admin index | 200 |
| Admin create | 200 |
| Admin store | `POST` → redirect + record in DB |
| Store validazione | Campi vuoti → errors |
| Admin show | `GET /admin/curiosita/{id}` → 200, vede titolo |
| Admin edit | 200 |
| Admin update | `PUT` → redirect, titolo aggiornato |
| Admin delete | `DELETE` → redirect, record rimosso |
| Non-admin store | 403 |

#### `GalleriaCrudTest.php` (9 test)

| Test | Cosa verifica |
|---|---|
| Guest redirect | `GET /admin/galleria` → `/login` |
| Admin index | 200 |
| Admin create | 200 |
| Admin store | `POST` + UploadedFile → redirect + record in DB |
| Store validazione | Campi vuoti → errors |
| Admin edit | 200 |
| Admin update | `PUT` → redirect, didascalia aggiornata |
| Admin delete | `DELETE` → redirect, record rimosso |
| Non-admin store | 403 |

#### `DashboardTest.php`

Testa la dashboard admin: accesso admin, stats corretti, grafici renderizzati.

#### `DeleteProtectionTest.php`

Testa la protezione eliminazione: Categoria con corpi associati → errore, Missione con corpi associati → errore.

#### `GalleriaOrdineTest.php`

Testa l'ordinamento galleria: sposta su/giù, primo/ultimo elemento, ordine corretto.

#### `ImageUploadServiceTest.php`

Testa `ImageUploadService`: upload con resize, file non immagine → eccezione, file troppo grande.

#### `NasaImportTest.php`

Testa `NasaImportController`: import singolo, importAll, force import, redirect non-admin.

#### `RateLimitingTest.php`

Testa rate limiting: throttle sugli endpoint API e admin.

#### `SearchAndFilterTest.php` (10 test)

| Test | Cosa verifica |
|---|---|
| Corpi search by nome | `GET ?search=Sat` → only "Saturno" |
| Corpi search by nome | `GET ?search=Terr` → only "Terra" |
| Categorie search | `GET ?search=Pian` → only "Pianeta" |
| Missioni search | `GET ?search=Apollo` → only "Apollo 11" |
| Missioni filter stato | `GET ?stato=Completata` → only "Done" |
| Curiosita search | `GET ?search=Terra` → only "Fatto sulla Terra" |
| Galleria search | `GET ?search=Luna` → only "Vista dalla Luna" |
| Wildcard % escaped | `GET ?search=100%` → doesn't match all |
| Wildcard _ escaped | `GET ?search=Test_Thing` → doesn't match all |

#### `CorpoCelesteActionsTest.php` (13 test)

Testa azioni speciali CorpoCeleste: suggestNome e setImageFromGallery.

| Test | Cosa verifica |
|---|---|
| suggestNome validazione | Campi vuoti → 422 |
| suggestNome success | NASA API restituisce risultati → 200 con nome |
| suggestNome failure | NASA API vuota → fallback |
| suggestNome guest redirect | Non autenticato → redirect login |
| suggestNome non-admin | Utente non-admin → 200 (accesso consentito) |
| suggestNome caching | Seconda chiamata usa cache |
| suggestNome raw Italian | Input non tradotto → ricerca diretta |
| setImage success | Imposta immagine da galleria → redirect + flash |
| setImage ownership | Immagine di altro corpo → 404 |
| setImage remote URL | URL remoto NASA → flash message |
| setImage non-admin | 403 |
| setImage flash | Messaggio flash corretto |

#### `AuthorizationTest.php` (19 test)

Testa authorization admin con Policy e Gates per 5 entità.

| Gruppo | N. test | Cosa copre |
|---|---|---|
| **store/update/delete** | 15 | 3 operazioni × 5 entità — non-admin riceve 403 |
| **guest redirect** | 4 | Guest su route admin → redirect `/login` |

## API di supporto

### `Http::fake()`

Mocka le chiamate HTTP in uscita. Due modalità:

**Response fissa** (stessa response per ogni chiamata):
```php
Http::fake([
    'images-api.nasa.gov/*' => Http::response(['collection' => ['items' => [...]]]),
]);
```

**Callback** (response dinamica per chiamata):
```php
$calls = 0;
Http::fake(function ($request) use (&$calls) {
    $calls++;
    if ($calls === 1) {
        return Http::response(['collection' => ['items' => []]]);
    }
    return Http::response(['collection' => ['items' => [['data' => [...]]]]]);
});
```

### `CorpoCelesteObserver`

L'observer `CorpoCelesteObserver::created()` chiama automaticamente `NasaImageService::importForBody()` quando un `CorpoCeleste` viene creato. In ambiente testing (`APP_ENV=testing`) questa chiamata viene saltata grazie a:

```php
if (app()->environment('testing')) {
    return;
}
```

Questo previene chiamate HTTP reali durante la creazione di factory nei test.

### React — `resources/js/guest/test/` (13 file, 110 test)

#### Componenti (4 file, 27 test)

| File | Componente | Test | Cosa copre |
|---|---|---|---|
| `CategoriaBadge.test.jsx` | CategoriaBadge | 5 | null safety, renders nome, colore per categoria nota, fallback sconosciuto |
| `CorpoCard.test.jsx` | CorpoCard | 10 | nome/descrizione, image vs gradient fallback, in_evidenza badge, categoria badge, link dettaglio, tipo, formatDistance, nome fallback |
| `LightboxGalleria.test.jsx` | LightboxGalleria | 8 | null/empty, grid thumbnails, filtra senza URL, aria-label, didascalia/crediti, click apre lightbox |
| `SolarSystem.test.jsx` | SolarSystem | 4 | render senza crash, label Sole, 8 pianeti, 8 orbite |

#### Integrazione API (5 file, 61 test)

| File | Pagina | Test | Cosa copre |
|---|---|---|---|
| `apiClient.test.js` | Layer API | 8 | 6 funzioni fetch con params, unwrap, slug diversi |
| `HomePage.test.jsx` | HomePage | 11 | hero, loading skeleton, corpi in evidenza, stats dashboard, error API |
| `CorpiLista.test.jsx` | CorpiLista | 12 | filtri categoria/tipo, ricerca, paginazione, reset, error |
| `CorpoDettaglio.test.jsx` | CorpoDettaglio | 16 | metriche, galleria, curiosità, missioni, simili, 404, compare link |
| `Comparatore.test.jsx` | Comparatore | 10 | dropdown, pre-fill URL, tabella confronto, esclusione pianeta |

#### Error handling + UI (4 file, 22 test)

| File | Componente | Test | Cosa copre |
|---|---|---|---|
| `NotFound.test.jsx` | NotFound | 4 | rendering, title, home link, icon |
| `ErrorBoundary.test.jsx` | ErrorBoundary | 4 | catches error, shows fallback, hides children, home link |
| `TimelineMissioni.test.jsx` | TimelineMissioni | 8 | empty, renders missions, dates, status icons, links |
| `Navbar.test.jsx` | Navbar | 6 | renders links, active state, mobile toggle, aria |

## Scrivere nuovi test

```bash
# Creare un nuovo test
php artisan make:test NomeTest --unit     # tests/Unit/NomeTest.php
php artisan make:test NomeTest             # tests/Feature/NomeTest.php
```

Convenzioni:
- Test estendono `Tests\TestCase`
- Usano `RefreshDatabase` per DB pulito
- Usano `Http::fake()` se interagiscono con NASA
- Usano `factory()->create()` invece di inserimenti manuali
- Nomi in snake_case: `test_describe_comportamento_atteso(): void`
