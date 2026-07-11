## graphify

This project has a knowledge graph at graphify-out/ with god nodes, community structure, and cross-file relationships.

When the user types `/graphify`, use the installed graphify skill or instructions before doing anything else.

Rules:
- For codebase questions, first run `graphify query "<question>"` when graphify-out/graph.json exists. Use `graphify path "<A>" "<B>"` for relationships and `graphify explain "<concept>"` for focused concepts. These return a scoped subgraph, usually much smaller than GRAPH_REPORT.md or raw grep output.
- Dirty graphify-out/ files are expected after hooks or incremental updates; dirty graph files are not a reason to skip graphify. Only skip graphify if the task is about stale or incorrect graph output, or the user explicitly says not to use it.
- If graphify-out/wiki/index.md exists, use it for broad navigation instead of raw source browsing.
- Read graphify-out/GRAPH_REPORT.md only for broad architecture review or when query/path/explain do not surface enough context.
- After modifying code, run `graphify update .` to keep the graph current (AST-only, no API cost).

## Project identity

Astralis is a web catalog of celestial bodies (planets, stars, galaxies, nebulae, moons, comets, asteroids) with a guest React SPA and an admin Blade backoffice. Built for a full-stack final exam project.

## Tech stack & gotchas

- **Backend**: Laravel 13, PHP 8.x
- **Auth**: Laravel Breeze (Blade puro login/register → Blade admin)
- **Database**: MySQL (port 3307)
- **Guest frontend**: React 19, Vite, framer-motion, react-router-dom, lucide-react, yet-another-react-lightbox
- **Admin frontend**: Blade, Alpine.js (CDN da unpkg — no local fallback)
- **CSS**: Tailwind CSS
- **Upload**: Intervention Image v4 — **NO facade**. Usare `ImageManager(new Driver())->decodePath()`/`->decodeBinary()`, `scaleDown()` invece di `resize()`
- **SSL**: `Http::withoutVerifying()` solo in local/testing (Windows)
- **Slug**: spatie/laravel-sluggable

## Dual rendering (critical)

- **Guest pages**: React SPA standalone (`resources/js/guest/`). Entry: `main.jsx`. Routes: `/`, `/corpi-celesti`, `/corpi-celesti/:slug`, `/confronta`, `/*` (404)
- **Admin pages**: Blade puro (`resources/views/admin/`). Master layout: `layouts/app.blade.php`
- **API**: `routes/api.php` — 10 endpoint JSON pubblici
- **Authorization**: Policy + Gates in `app/Policies/` e `app/Providers/AuthServiceProvider.php`

## Entità chiave

1. **Categoria** — nome, slug, icona, descrizione, colore
2. **CorpoCeleste** — nome, nome_it, slug, categoria_id, immagine, immagine_utente (boolean), descrizione, tipo, massa_kg, distanza_km, diametro_km, gravita, temperatura, periodo_orbitale, scopritore, anno_scoperta, in_evidenza, nasa_id
3. **Missione** — nome, slug, logo, agenzia, data_lancio, durata_giorni, stato, descrizione, sito_web
4. **Curiosità** — corpo_celeste_id, titolo, descrizione, fonte
5. **GalleriaCorpo** — corpo_celeste_id, percorso (URL remoto o filename locale), didascalia, crediti, ordine

## File map

| Percorso | Ruolo |
|---|---|
| `routes/web.php` | Route admin + auth + catch-all SPA (`/{any}` → `guest.blade.php`) |
| `routes/api.php` | 10 endpoint JSON pubblici |
| `routes/auth.php` | Route Breeze (login, register, etc.) |
| `app/Services/NasaImageService.php` | Import NASA con dedup, preserva immagine utente, timeout 30s, retry 2, testing guard |
| `app/Observers/CorpoCelesteObserver.php` | Auto-import NASA su created (skip in testing via `app()->environment('testing')`) |
| `app/Services/WordMapService.php` | Traduzione italiano→inglese per NASA suggest admin |
| `app/Console/Commands/CleanupGalleryDuplicates.php` | Comando `astralis:gallery` (--check/--clean/--sync/--fix/--dry-run) |
| `app/Policies/` | Policy autorizzazione (5 Policy, una per entità) |
| `app/Providers/AuthServiceProvider.php` | Registrazione Policy + Gate `admin` |
| `app/Http/Controllers/Admin/` | Controller CRUD admin (Blade) |
| `app/Http/Controllers/Api/` | Controller API (JSON) |
| `app/Http/Controllers/Auth/` | Controller auth Breeze (Blade) |
| `resources/views/admin/layouts/app.blade.php` | Master layout admin (sidebar + Alpine.js CDN + x-cloak) |
| `resources/js/guest/pages/NotFound.jsx` | 404 page (catch-all route) |
| `resources/js/guest/` | React SPA guest |

## Testing

- **Factories**: Tutti i 5 modelli hanno `HasFactory` trait. Le factory sono in `database/factories/`. `CorpoCelesteFactory` crea automaticamente una `Categoria` associata.
- **Observer in test**: `CorpoCelesteObserver::created()` auto-importa da NASA quando un `CorpoCeleste` viene creato. In test si disabilita automaticamente (`app()->environment('testing')`).
- **Http::fake()**: Tutti i test che creano `CorpoCeleste` via factory includono `Http::fake()` in setUp per prevenire chiamate HTTP reali.
- **Run**: `php artisan test` — 173 test PHPUnit, 439 assertion. `npm test` — 87 test Vitest. Totale: 260 test.

## Bugs noti / Pattern da evitare

- **CDN (Alpine.js + Chart.js)**: dipendono da connettività esterna. Nessun fallback locale.
- **bootstrap/cache**: su Windows, se creata da Git Bash, va ricreata con `cmd //c 'rmdir /s /q bootstrap\cache' && cmd //c 'mkdir bootstrap\cache'`
- **`[x-cloak]`**: style presente nel `<head>` di `app.blade.php` per prevenire FOUC con Alpine.js
- **Dual slash in cmd**: da Git Bash usare `cmd //c` (doppio slash), non `cmd /c`

## Admin palette

- Sfondo: `#0A0A1A`, Card: `#111128`, Testo: `#F0F0FA`
- Primario: `#22D3EE`, Secondario: `#A855F7`, Accento: `#F97316`
- Badge OK: `#22C55E`, KO: `#9CA3AF`, attenzione: `#FACC15`

## Documentazione workflow

Prima di eseguire `graphify update .`, assicurati che:
1. Tutti i file in `docs/` siano aggiornati alle modifiche appena fatte
2. `AGENTS.md` sia aggiornato (se lo snapshot del progetto è cambiato)
3. `README.md` sia aggiornato (nuove funzionalità, comandi, requisiti)
4. Poi aggiorna il grafo con `graphify update .`
5. Infine commit

Ordine: **codice → docs/ → AGENTS.md → README.md → graphify → commit**

## Skill installate

Skill globali sempre disponibili in `~/.config/opencode/skills/`:

| Skill | Attivazione |
|---|---|
| `frontend-design` | Design UI/UX, componenti React, layout |
| `react-best-practices` | Ottimizzazione React/Next.js (70 regole) |
| `composition-patterns` | Pattern composizione React |
| `webapp-testing` | Testing Playwright |
| `web-design-guidelines` | Review UI/accessibilità |
| `writing-guidelines` | Review scrittura documentazione |
| `claude-api` | Documentazione API Claude/SDK |
| `mcp-builder` | Creazione MCP server |
| `theme-factory` | Tema colori/font per artefatti |
| `web-artifacts-builder` | Artefatti React+Tailwind+shadcn |
| `skill-creator` | Creazione/modifica skill |
| `brand-guidelines` | Brand Identity Anthropic |

Skill custom Astralis in `.opencode/skills/`:

| Skill | Scopo |
|---|---|
| `astralis-laravel` | Pattern backend Laravel (Observer, Policy, Service, Command) |
| `astralis-react-spa` | Pattern frontend React SPA (routing, API, animazioni) |
| `astralis-blade-admin` | Pattern admin Blade (Alpine.js, CRUD, palette) |
| `astralis-testing` | Pattern test (PHPUnit + Vitest, factory, Http::fake) |

## Cross-PC sync

Quando pulli la repo su un'altra macchina (o dopo tanto tempo), segui la guida in [`docs/documentazione.md#guida-al-rientro-clone-su-altro-pc`](docs/documentazione.md#guida-al-rientro-clone-su-altro-pc).

Procedura rapida:

1. `composer install` — aggiorna dipendenze PHP
2. `npm install` — aggiorna dipendenze JS
3. `php artisan migrate` — applica nuove migrazioni
4. `php artisan storage:link` — ricrea il symlink storage
5. `php artisan astralis:gallery --fix` — ripara immagini galleria se necessario
6. `npx graphify update .` — ricostruisce il grafo locale
7. Verifica `git status` — working tree deve essere pulito dopo grafo

Per il setup completo delle skill OpenCode: [`docs/documentazione.md#setup-opencode-skills`](docs/documentazione.md#setup-opencode-skills).

## Stato avanzamento piano ottimizzazione

### ✅ Completato

| Fase | Task | Commit |
|------|------|--------|
| **1** | AbortController, useFetch hook, ErrorBoundary, image guards, axios interceptors | `f5ed6ab` |
| **2** | Job queue (ImportNasaImage), chunk(50), rate limiting API, caching searchNasa | `f5ed6ab` |
| **3.2** | Inline styles → Tailwind classes (verificato completo) | `fce2f36` |
| **3.4** | framer-motion→CSS + SolarSystem clickable/immagini realistiche | `TBD` |

### 🔄 Da fare

- **Fase 3** (React P1): Tutta completata (3.1, 3.2, 3.4, 3.5, 3.6) ✅
- **Fase 4** (Laravel P1): Tutta completata (4.1-4.6) ✅
- **Fase 5** (Admin Blade P1): Tutta completata (5.1-5.5) ✅
- **Fase 6** (React P2): Tutta completata (6.1-6.4) ✅
- **Fase 7** (Laravel P2): Tutta completata (7.1-7.5) ✅
- **Fase 8** (Admin Blade P2): Tutta completata (8.1-8.4) ✅
- **Fase 9** (Test P1-P3): Tutto da fare (20.5h)
- **Fase 10** (UI/UX P4): Tutto da fare (~4h)

| # | Task | Beneficio |
|---|------|-----------|
| 3.1 | **React.lazy + Suspense** — tutte le 5 page in lazy loading | Bundle iniziale ridotto ~40%, TTI migliorato |
| 3.2 | **Inline styles → Tailwind classes** — ~68 oggetti style in 15 file ✅ | CSS compilato a build time, deduplicabile, più performante di style runtime |
| 3.3 | **CSS variables per palette admin** — #22D3EE, #111128 ripetuti ~70x | Cambiare palette in un punto solo, manutenibilità |
| 3.4 | **framer-motion → CSS transitions** — fade/slide/pulse/twinkle + SolarSystem clickable/immagini ✅ | Animazioni su compositor GPU, framer-motion solo per orbite |
| 3.5 | **Deduplicazione codice** — categoryIcons/gradients in constants.js, helpers in utils.js | Bug fix in un file non rischia di lasciare l'altro non aggiornato |
| 3.6 | **Direct DOM → React state** — onFocus/onBlur in SearchBar, Comparatore | React gestisce DOM virtuale, rendering deterministico |

### Fase 4 — Alto Backend Laravel (P1)

| # | Task | Beneficio |
|---|------|-----------|
| 4.1 | **Caching DashboardController** — Admin + API, Cache::remember(3600) | Da 10+ query a 1 per richiesta, caricamento admin più veloce |
| 4.2 | **Paginazione API endpoint mancanti** — Galleria, Curiosità, Missioni | Payload JSON ridotto, scala con dataset crescenti |
| 4.3 | **GROUP BY ottimizzato missioni stato** — 3 COUNT → una query GROUP BY | Da 3 round trip a 1 |
| 4.4 | **per_page lower bound** — max(1, min(...)) | Per_page=0 causava errore SQL con paginate(0) |
| 4.5 | **Route binding consistente** — simili usa ID, show usa slug | API predicibile, developer non confuso |
| 4.6 | **exists() statt count() > 0** — Categoria/Missione destroy | Fino a 10x più veloce su tabelle grandi |

### Fase 5 — Alto Admin Blade (P1)

| # | Task | Beneficio |
|---|------|-----------|
| 5.1 | **CSS component class per input** — classe .admin-input in app.css | Elimina ~140 attributi style + onfocus/onblur inline, -15% peso HTML |
| 5.2 | **Hardcoded hex → CSS variables** — 50+ valori hex sparsi | Cambio colore in un punto, tema unificato garantito |
| 5.3 | **Estrarre partials Blade** — flash, search, actions, stat-cards, back-link | ~680 linee risparmiate, modifiche consistenti |
| 5.4 | **Form partial per create/edit** — unificare coppie create/edit per entità | Modifica applicata in entrambi, niente dimenticanze |
| 5.5 | **Fix bug strutturale edit.blade.php** — @section('content') mai chiuso | Aggiornamento Laravel non romperà la pagina |

### Fase 6 — Medio React Frontend (P2)

| # | Task | Beneficio |
|---|------|-----------|
| 6.1 | **React.memo su componenti in lista** — CorpoCard, SearchBar, CategoriaBadge, TimelineMissioni | Salta re-render se props non cambiate |
| 6.2 | **Debounce search input** — 300ms prima di API call | Da ~10 chiamate a 1 per ricerca |
| 6.3 | **useMemo per slides Lightbox** — .filter().map() ricalcolato ad ogni render | Skip calcolo se immagini invariato |
| 6.4 | **SolarSystem stabilità** — Math.random() su ogni render | Stelle non "saltano" a ogni re-render |
| 6.5 | **Accessibilità React** — aria-current, role="alert", aria-hidden, aria-label | Allineamento WCAG per screen reader |
| 6.6 | **Lightbox prev/next buttons** — buttonNext: () => null riabilitato | Navigazione completa senza chiudere/riaprire |
| 6.7 | **Fetch waterfall parallelo** — corpo + simili in Promise.all | Risparmia un round trip (200-800ms) |

### Fase 7 — Medio Backend Laravel (P2)

| # | Task | Beneficio |
|---|------|-----------|
| 7.1 | **FormRequest per tutti gli admin controller** — 5/7 usano validate() inline | Validazione centralizzata, create/edit coerenti |
| 7.2 | **Authorization consistente** — Gate::authorize('admin') → $this->authorize() | Pattern uniforme in tutti i controller |
| 7.3 | **suggestNome caching + debounce** — 2 chiamate NASA HTTP sincrone | Risultati già visti non richiamano NASA |
| 7.4 | **curl → Http facade** — CleanupGalleryDuplicates | Testabile con Http::fake(), coerente col progetto |
| 7.5 | **exists() per delete checks** — count() > 0 in tutti i controller | Più veloce, semanticamente corretto |

### Fase 8 — Medio Admin Blade (P2)

| # | Task | Beneficio |
|---|------|-----------|
| 8.1 | **Estrarre JS NASA suggest e color picker** — JS copiato in create+edit | Bug fix in un file non lascia l'altro obsoleto |
| 8.2 | **Delete confirm con nome entità** — 5 confirm generiche | Admin vede cosa cancella, riduce errori umani |
| 8.3 | **CDN fallback Alpine.js + Chart.js** — locale fallback script | Admin funziona anche offline/senza CDN |
| 8.4 | **Sidebar mobile responsive + table overflow-x-auto** | Admin utilizzabile da tablet/smartphone |
| 8.5 | **Paginazione Tailwind custom** — vendor/pagination personalizzato | Paginazione coerente con palette dark admin |
| 8.6 | **Modal accessibilità** — role="dialog", aria-modal, Escape key | Screen reader identificano il dialog, usabile da tastiera |

### Fase 9 — Test (P1-P3)

| # | Task | Beneficio |
|---|------|-----------|
| 9.1 | ✅ **AdminTestCase base class** — 5/5 CRUD test estendono AdminTestCase, -15 righe boilerplate | Zero dimenticanze setup |
| 9.3 | ✅ **Uniform Http::fake()** — GalleriaApiTest: rimosso unsetEventDispatcher, MissioneApiTest: aggiunto Http::fake() | Pattern uniforme in tutti i test |
| 9.7 | ✅ **DashboardApiTest complete** — 4 test: counts + corpi_in_evidenza + ultimi_corpi + missioni_per_stato | 173 test, 439 assertion |
| 9.2 | ✅ **Data provider authorization tests** — 19 test: store/update/delete per 5 entità + 6 guest redirect | 173 test, 439 assertion |
| 9.4 | ✅ **Frontend test fixtures condivise** — fixtures.js centralizzato | Struttura API cambia = 1 file da aggiornare |
| 9.5 | ✅ **Factory foreign key fix** — corpo_celeste_id rimosso da GalleriaCorpoFactory, CuriositaFactory, usato ->for() | Test scrivono .for($corpo) invece di ricordarsi il campo |
| 9.6 | ✅ **Copertura test mancante** — 3 nuovi file: CorpoCelesteActionsTest(7), GalleriaOrdineTest(6), NasaImportTest(8) | 173 test, 439 assertion |

### Fase 10 — UI/UX & Writing Review (P4)

| # | Task | Beneficio |
|---|------|-----------|
| 10.1 | ✅ **Web Design Guidelines review** — audit 14 file React: 3 high, 6 medium, 3 low priority | Allineamento WCAG standards internazionali |
| 10.2 | **Writing Guidelines review** — labels, errori, empty state, flash messages | Coerenza tono, chiarezza, active voice in italiano |
| 10.3 | **Frontend Design review** — palette, tipografia, layout signature, coerenza guest/admin | Identità visiva intenzionale, niente template default |

### Comando per nuova sessione

Apri nuova sessione e dì: **"riprendi il piano da Fase X"** (X = numero fase) — l'agente carica AGENTS.md + skill automaticamente.
