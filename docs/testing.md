# Test — Astralis

Suite di test per backend (PHPUnit) e frontend React (Vitest).

## Esecuzione

### Backend (PHPUnit) — 84 test, 220 assertion

```bash
php artisan test                              # Tutti
php artisan test tests/Unit/...               # Unit
php artisan test tests/Feature/Api/           # API
php artisan test tests/Feature/Admin/...      # Admin CRUD
```

### Frontend React (Vitest) — 88 test

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

### Unit — `tests/Unit/NasaImageServiceTest.php` (26 test, 63 assertion)

Testa `App\Services\NasaImageService` — il service che importa immagini da NASA Image API.

| Gruppo | N. test | Cosa copre |
|---|---|---|
| **searchNasa** | 5 | Successo con response mockata, fallimento con items vuoti, fallback su query stripped (`"Earth's Moon"` → `"Earth Moon"`), fallback extra (parametro `$extraFallbacks`), continuazione su HTTP 500 |
| **extractMetadata** | 3 | Estrazione campi (nasa_id, title, photographer, description, keywords), chiavi mancanti → null, fallback `photographer` → `secondary_creator` |
| **pickImageUrl** | 5 | Priorità alternate → preview → canonical, nessun link → null, link solo video (render=video) → null |
| **importForBody** | 10 | Skip se immagine già presente e `$force=false`, Force overwrite immagine principale, Force non sovrascrive `immagine_utente=true`, Creazione voci galleria (didascalia, crediti, ordine), Deduplicazione galleria (stesso URL skippato), `$updateDescription=true` aggiorna `descrizione`, `$updateDescription=false` non modifica, Ricerca NASA fallisce → `success=false`, Fallback "comet" per comete/Halley, Item senza URL immagine → `errors[]` |
| **importAll** | 2 | Conteggi corretti (success, total, total_main) con tutti riusciti, Conteggi corretti con successi parziali |

#### Pattern usati

- `Http::fake()` con response fissa o callback (`function ($request) { ... }`)
- `Http::fake()` con contatore `$calls` per simulare fallback progressivo
- `CorpoCeleste::factory()->create([...])` per creare record di test
- `$corpo->fresh()` per ricaricare dal DB dopo update
- `GalleriaCorpo::where(...)->get()` per verificare creazione voci galleria

### Feature API — `tests/Feature/Api/` (8 file)

Testano gli endpoint JSON pubblici in `routes/api.php`.

| File | Endpoint testati |
|---|---|
| `CorpoCelesteApiTest.php` | `GET /api/corpi-celesti` — paginazione (default 12, max 100), filtri per categoria (slug), tipo, search (nome/descrizione), in_evidenza. `GET /api/corpi-celesti/{slug}` — dettaglio con relazioni. `GET /api/corpi-celesti/{id}/simili` — max 4, exclude stesso |
| `CategoriaApiTest.php` | `GET /api/categorie` — tutti. `GET /api/categorie/{slug}` — dettaglio. 404 |
| `MissioneApiTest.php` | `GET /api/missioni` — tutti. `GET /api/missioni/{slug}` — dettaglio. 404 |
| `CuriositaApiTest.php` | `GET /api/curiosita` — tutti |
| `GalleriaApiTest.php` | `GET /api/galleria` — tutti |
| `DashboardApiTest.php` | `GET /api/dashboard/stats` — conteggi corpi, categorie, missioni |

### Feature Admin — `tests/Feature/Admin/CorpoCelesteCrudTest.php` (12 test)

Testa il CRUD backoffice Blade con autenticazione e autorizzazione.

| Test | Cosa verifica |
|---|---|
| Guest redirect | Visita index → redirect `/login` |
| Admin index | `GET /admin/corpi-celesti` → 200, vede "Corpi Celesti" |
| Admin create form | `GET /admin/corpi-celesti/create` → 200, vede "Nuovo Corpo Celeste" |
| Admin store | `POST /admin/corpi-celesti` → redirect + session success, record in DB |
| Store validazione | Campi vuoti → session errors (nome, categoria_id) |
| Store unique nome | Nome duplicato → session errors (nome) |
| Admin show | `GET /admin/corpi-celesti/{id}` → 200, vede `nome_display` |
| Admin edit | `GET /admin/corpi-celesti/{id}/edit` → 200, vede "Modifica" |
| Admin update | `PUT /admin/corpi-celesti/{id}` → redirect + session success, nome aggiornato |
| Update stesso nome | `PUT` con nome invariato → nessun errore validazione |
| Admin delete | `DELETE /admin/corpi-celesti/{id}` → redirect + session success, record rimosso |
| Non-admin store | `POST` come utente normale → 403 |
| Non-admin delete | `DELETE` come utente normale → 403 |

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

### React — `resources/js/guest/test/` (9 file, 88 test)

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
| `apiClient.test.js` | Layer API | 12 | 6 funzioni fetch con params, unwrap, slug diversi |
| `HomePage.test.jsx` | HomePage | 11 | hero, loading skeleton, corpi in evidenza, stats dashboard, error API |
| `CorpiLista.test.jsx` | CorpiLista | 12 | filtri categoria/tipo, ricerca, paginazione, reset, error |
| `CorpoDettaglio.test.jsx` | CorpoDettaglio | 16 | metriche, galleria, curiosità, missioni, simili, 404, compare link |
| `Comparatore.test.jsx` | Comparatore | 10 | dropdown, pre-fill URL, tabella confronto, esclusione pianeta |

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
