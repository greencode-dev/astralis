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

### ✅ Completato — Piano ottimizzazione (Task 0-10.3)

Tutte le task del piano sono completate. 235 test (173 PHPUnit + 62 Vitest).

| Task | Categoria | Stato |
|------|-----------|-------|
| **0** | Setup | ✅ |
| **1-2** | Database + CRUD Admin | ✅ |
| **3-4** | React + API REST | ✅ |
| **5-6** | React (Dettaglio, Lightbox, Comparatore) + fix | ✅ |
| **7-8** | Bugfix + NASA Import | ✅ |
| **9-10** | Auth Inertia→Blade + bug critici | ✅ |
| **11-12** | Authorization + Quick wins | ✅ |
| **14** | Bug critici + import cleanup | ✅ |
| **3.2** | Inline styles → Tailwind classes | ✅ |
| **3.4** | framer-motion → CSS transitions | ✅ |
| **4.1** | Cache dashboard + invalidazione | ✅ |
| **5.1-5.4** | Admin Blade: partials, forms, CSS vars | ✅ |
| **6.1** | React.memo | ✅ |
| **7.2-7.3** | Authorization + suggestNome caching | ✅ |
| **9.1-9.7** | Test: AdminTestCase, auth, fixtures, factories, copertura | ✅ |
| **10.1-10.3** | UI/UX review: Web Design, Writing, Frontend Design | ✅ |

### 🔜 Prossimo step

**Debug generale post-ottimizzazione** — Verificare che tutto funzioni dopo le attività di ottimizzazione. Controllare: route, pagine, form, upload, search, paginazione, animation, responsive, admin CRUD, API endpoint.
