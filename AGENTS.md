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
- **Guest frontend**: React 18, Vite, framer-motion, react-router-dom, lucide-react, yet-another-react-lightbox
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
| `resources/views/admin/partials/_sidebar-nav.blade.php` | Sidebar nav rendering (reads config/admin.php) |
| `resources/views/admin/partials/category-badge.blade.php` | Reusable category badge |
| `resources/views/admin/partials/index-header.blade.php` | Index page header with create button |
| `resources/views/admin/partials/dashboard-stat.blade.php` | Dashboard stat card |
| `resources/views/admin/partials/empty-table-row.blade.php` | Empty table state |
| `resources/views/admin/partials/in-evidenza-badge.blade.php` | Featured badge |
| `config/admin.php` | Nav items, mission stati, color presets |
| `resources/js/guest/hooks/useDebounce.js` | Shared debounce hook |
| `resources/js/guest/pages/NotFound.jsx` | 404 page (catch-all route) |
| `resources/js/guest/` | React SPA guest |
| `vite.config.js` | Config Vite: React plugin, proxy API `/api` → `http://localhost:8000` |

## Testing

- **Factories**: Tutti i 5 modelli hanno `HasFactory` trait. Le factory sono in `database/factories/`. `CorpoCelesteFactory` crea automaticamente una `Categoria` associata.
- **Observer in test**: `CorpoCelesteObserver::created()` auto-importa da NASA quando un `CorpoCeleste` viene creato. In test si disabilita automaticamente (`app()->environment('testing')`).
- **Http::fake()**: Tutti i test che creano `CorpoCeleste` via factory includono `Http::fake()` in setUp per prevenire chiamate HTTP reali.
- **Run**: `php artisan test` — 255 test PHPUnit, 591 assertion. `npm test` — 107 test Vitest. Totale: 362 test.

## Bugs noti / Pattern da evitare

- **CDN (Alpine.js + Chart.js)**: dipendono da connettività esterna. Nessun fallback locale.
- **bootstrap/cache**: su Windows, se creata da Git Bash, va ricreata con `cmd //c 'rmdir /s /q bootstrap\cache' && cmd //c 'mkdir bootstrap\cache'`
- **`[x-cloak]`**: style presente nel `<head>` di `app.blade.php` per prevenire FOUC con Alpine.js
- **Dual slash in cmd**: da Git Bash usare `cmd //c` (doppio slash), non `cmd /c`
- **Vite proxy API**: `vite.config.js` ha `server.proxy: { '/api': 'http://localhost:8000' }` — senza proxy, le chiamate API da `http://localhost:5173/` falliscono con CORB/white page. Il proxy inoltra le richieste `/api` al backend Laravel

## Admin palette

- Sfondo: `#0A0A1A`, Card: `#111128`, Testo: `#F0F0FA`
- Primario: `#22D3EE`, Secondario: `#A855F7`, Accento: `#F97316`
- Badge OK: `#22C55E`, KO: `#9CA3AF`, attenzione: `#FACC15`

## Workflow

### Fase 0 — Avvio sessione (`/start`)

Quando l'utente scrive `/start`, eseguire automaticamente questo flusso (solo lettura):

1. **Caricare le skill Astralis**: `astralis-laravel`, `astralis-react-spa`, `astralis-blade-admin`, `astralis-testing`.
2. **Caricare le skill globali**: `frontend-design`, `react-best-practices`, `composition-patterns`, `web-design-guidelines`, `writing-guidelines`.
3. **Stato repo**: `git fetch origin` → `git status` → `git log --oneline -5` → `git log HEAD..origin/{branch} --oneline` → `git stash list` → `git diff --stat`.
4. **Task aperte**: leggere `docs/todo.md` → sezione "Da Fare", raggruppare per priorità.
5. **Attività recenti**: leggere `docs/changelog.md` → prime 2-3 entry.
6. **Snapshot progetto**: leggere `AGENTS.md` → sezione "Stato avanzamento" (test count, fasi completate).
7. **Knowledge graph**: eseguire `graphify explain "Astralis"` per una visione d'insieme dell'architettura (se il grafo esiste).

Generare un report con formato:

```
📊 Sessione ripresa — DD/MM/YYYY

**Repo**: branch `master`, N commit avanti / M commit dietro rispetto a origin
**Stash**: N stash / nessuno
**Modifiche non committate**: [riepilogo da git diff --stat] / nessuna
**Test**: X PHPUnit + Y Vitest = Z totali

**Ultime attività** (changelog):
- [2-3 entry recenti]

**Task aperte** (todo):
- 🔴P0: [lista]
- 🟠P1: [lista]
- 🔵P2: [lista]

**Grafo**: [riepilogo architettura da graphify]

**Suggerimento prossima task**: [task con priorità più alta non ancora iniziata]

💡 **Suggerimenti audit**:
- [front-end modificato di recente] → considera un design review
- [docs aggiornate di recente] → considera una writing review
- [nessuna modifica rilevante] → audit non necessario

**Azioni consigliate**:
- [eventuale pull necessario]
- [eventuale fix test]
- [eventuale sync mancante]
```

Non eseguire pull/push/commit/modifiche senza conferma.

### Fase 1 — Sincronizzazione

Prima di iniziare qualsiasi lavoro:

1. `git fetch origin` per verificare lo stato remoto.
2. Confrontare `HEAD` con `origin/{branch}`:
   - Se il remote è avanti → informare l'utente e chiedere se pullare ora o dopo.
   - Se il locale è avanti → ok, si può lavorare (push dopo).
   - Se divergenti → avvisare l'utente, elencare i commit su entrambi i lati, e chiedere come procedere (rebase, merge, o tenere separato).
3. Verificare stash (`git stash list`) e segnalarli se presenti.
4. Verificare che il working tree sia pulito prima di iniziare.

### Fase 2 — Pull e Merge

Prima di eseguire un pull:

1. Assicurarsi che il working tree sia pulito (niente modifiche non committate).
2. Se ci sono stash, segnalare che potrebbero essere coinvolti dopo il merge.
3. Scegliere la strategia:
   - `git pull --rebase` → default preferito, lineare la storia.
   - `git pull --no-rebase` → merge classico quando serve un merge commit esplicito.
4. Se si verificano conflitti:
   - Elencare i file in conflitto.
   - Per ogni file, mostrare entrambe le versioni e chiedere all'utente come risolvere.
   - Dopo la risoluzione, continuare con `git rebase --continue` o `git merge --continue`.
5. Verificare con i test dopo il merge/rebase (`php artisan test` + `npm test`).

### Fase 3 — Aggiornamento documentazione

Ordine: **codice → docs/ → AGENTS.md → README.md → graphify → commit**

#### docs/todo.md

1. **Una sola intestazione per giorno** — mai dividere in sessioni.
2. **Ordine item**: per priorità (🔴P0 → 🟠P1 → 🔵P2 → 🟣P3 → ⚪P4), poi per categoria (backend → frontend → test → docs → feature).
3. Aggiornare `*Ultimo aggiornamento:*` con la data odierna.
4. Aggiornare la sezione `## Note` con conteggio corretto di task aperte e test.
5. Spostare i task completati (`[x]`) da **Da Fare** a **Fatto**, sotto la data corrente.
6. Non creare duplicati.

#### docs/changelog.md

1. **Una sola intestazione per giorno**.
2. Formato: `### Titolo breve (DD/MM/YYYY)` + bullet list con **bold keyword** + descrizione.
3. Ordine: entry più recenti in cima.
4. Includere: bug fix, feature, refactor, breaking changes, test count.
5. Non includere: commit minori, typo fix.
6. Chiudere ogni entry con: `**Test**: N totali (X PHPUnit + Y Vitest), tutti verdi.`

#### docs/testing.md

1. Aggiornare sempre i conteggi nei titoli sezioni.
2. Nuovi test file → aggiungere sezione documentativa con tabella Gruppo / N. test / Cosa copre.
3. Test rimossi → aggiornare o rimuovere la documentazione.
4. Non duplicare.

#### docs/bug.md

1. Nuovi bug → aggiungere in cima a "Risolti" con numero progressivo `[N]`, data, descrizione, causa, soluzione, file.
2. Numerazione progressiva dall'ultimo bug documentato.
3. Solo bug risolti (bug aperti vanno in `docs/todo.md`).

#### docs/documentazione.md

1. Tech Stack: aggiornare tabella se cambiano versioni.
2. Architettura: aggiornare albero directory se cambia la struttura.
3. Entità: aggiornare tabelle campi se cambia lo schema DB.
4. Setup: aggiornare comandi se cambiano i prerequisiti.
5. Workflow: aggiornare sezione sviluppo se cambiano comandi/procedure.

#### README.md

1. Funzionalità: aggiornare liste se cambiano feature.
2. Tech stack badges: aggiornare se cambiano versioni.
3. Architettura: aggiornare diagramma ASCII se cambia la struttura.
4. Setup: aggiornare comandi di installazione.
5. Mantenere conciso — linkare a `docs/` per dettagli.

#### AGENTS.md

1. Tech stack: aggiornare se cambiano framework/versioni.
2. File map: aggiungere/rimuovere righe se cambiano file importanti.
3. Test count: aggiornare se cambia il numero di test.
4. Bugs noti: aggiungere pattern da evitare.
5. Skill: aggiungere/rimuovere quando cambiano.
6. Non duplicare — aggiornare il valore esistente.

### Fase 4 — Aggiornamento grafo

Dopo aver aggiornato documentazione:

1. Eseguire `graphify update .` (AST-only, nessun costo API).
2. Verificare che completi senza errori.
3. Se il grafo ha variazioni significative, segnalarlo all'utente.
4. I file `graphify-out/` vanno committati insieme alla documentazione.

### Fase 5 — Commit

Prima di eseguire qualsiasi commit:

1. Eseguire `git status --short` e mostrare all'utente l'elenco dei file modificati.
2. Se tra i file ci sono potenziali secrets (`.env`, credenziali, chiavi), **fermare tutto** e avvisare l'utente.
3. Verificare che i file committati siano coerenti con il scope del commit (niente mix di task diversi, salvo esplicita richiesta).
4. Proporre un messaggio di commit con formato: `tipo: descrizione concisa` (`fix:`, `feat:`, `refactor:`, `test:`, `docs:`).
5. **Doppia conferma**: chiedere sempre conferma esplicita all'utente prima di eseguire `git commit`.
6. Se ci sono anche modifiche non collegate, chiedere se committare tutto insieme o selezionare con `git add -p`.

### Fase 6 — Push

Prima di eseguire `git push`:

1. **Verifica sincronizzazione**: `git fetch origin` + `git log HEAD..origin/{branch} --oneline`.
   - Se ci sono commit remote non pullati → eseguire Fase 2 prima del push.
   - Se il branch non esiste sul remote → primo push, ok dopo conferma.
2. **Verifica commit recenti**: `git log --oneline -5`.
   - Se ci sono commit con messaggi simili o che fixano lo stesso file → segnalare e proporre squash (`git rebase -i`) o lasciare così.
3. **Doppia conferma**: chiedere sempre conferma esplicita prima di `git push`.

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

### ✅ Completato — Piano ottimizzazione (Task 1-39)

Tutte le task del piano sono completate. 322 test (215 PHPUnit + 107 Vitest).

| Task | Descrizione | Stato |
|------|-------------|-------|
| **1** | Setup Laravel + Breeze + React + documentazione | ✅ |
| **2** | Database e Modelli (6 migrations, 5 models, seeder) | ✅ |
| **3** | CRUD Admin (Categorie, Corpi Celesti, Missioni, Curiosità, Galleria) | ✅ |
| **4** | API REST (10 endpoint) | ✅ |
| **5** | React: Homepage, Sistema solare animato, Lista | ✅ |
| **6** | React: Dettaglio, Lightbox, Missioni, Comparatore | ✅ |
| **7** | Bugfix Intervention Image v4, Force Import All | ✅ |
| **8** | NASA Import multi-immagine, Service Layer, CLI fetch-nasa | ✅ |
| **9** | Remote URLs, nome_it/nome_display, wordMap, auto-suggest admin | ✅ |
| **10** | Bug critici: route(), nasa_id, categoria_id | ✅ |
| **11** | Bugfix auth, NASA import dedup, galleria cleanup | ✅ |
| **12** | Authorization Policy/Gates ai controller admin | ✅ |
| **13** | Auth pages: Inertia → Blade puro | ✅ |
| **14** | Rimossa dipendenza Inertia | ✅ |
| **15** | FormRequest validazione store/update CorpoCeleste | ✅ |
| **16** | Quick wins: per_page, relazioni, .catch, nasa_id, indexes | ✅ |
| **17** | 10 bug critici fixati | ✅ |
| **18** | Rimossi import morti React + dipendenze inutilizzate | ✅ |
| **19** | Inline styles → Tailwind classes (~68 oggetti in 15 file) | ✅ |
| **20** | framer-motion → CSS transitions + SolarSystem clickable/immagini | ✅ |
| **21** | Cache dashboard + invalidazione su CRUD | ✅ |
| **22** | Form partial unificato: 5 _form.blade.php, 10 create/edit | ✅ |
| **23** | Partials Blade: back-link, search, flash, stat-card, actions | ✅ |
| **24** | Hardcoded hex → CSS variables: 13 variabili, 52 hex sostituiti | ✅ |
| **25** | CSS component class: .admin-input, 8 Blade views | ✅ |
| **26** | React.memo: LightboxGalleria + Thumbnail | ✅ |
| **27** | Authorization consistente: DashboardController fixato | ✅ |
| **28** | suggestNome caching + debounce: Cache::remember(3600) | ✅ |
| **29** | AdminTestCase base class: 5/5 CRUD test | ✅ |
| **30** | AuthorizationTest: 19 test | ✅ |
| **31** | Uniform Http::fake() pattern | ✅ |
| **32** | Frontend fixtures.js centralizzato | ✅ |
| **33** | Factory foreign key fix: ->for() pattern | ✅ |
| **34** | Copertura test mancante: 21 nuovi test | ✅ |
| **35** | DashboardApiTest complete: 4 test | ✅ |
| **36** | Web Design Guidelines audit | ✅ |
| **37** | Writing Guidelines audit | ✅ |
| **38** | Frontend Design audit | ✅ |
| **39** | (audit completati) | ✅ |

### ✅ Completato — Sicurezza e UX (Fasi 1-3)

359 test (252 PHPUnit + 107 Vitest), tutti verdi.

| Fase | Descrizione | Fix | Stato |
|------|-------------|-----|-------|
| **1 — Security** | is_admin fillable, colore regex, didascalia max, throttle, FK restrict | C1, C2, C5, H1, H2, H3 | ✅ |
| **2 — Critical bugs** | apiClient retry, simili race condition, job unique, color picker, conferma import | C3, C4, H4, H13, H15 | ✅ |
| **3 — UX & quality** | useFetch keep-data, Comparatore URL, Navbar mobile, gravita IT locale, flash auto-dismiss | H7, H8, H9, H11, M1, M2 | ✅ |

### ✅ Completato — Quick wins (16/07/2026)

252 PHPUnit + 107 Vitest, tutti verdi.

| Fix | File | Stato |
|-----|------|-------|
| **B1** | `Admin/CorpoCelesteController.php` — orWhere grouping | ✅ |
| **B3** | `CorpoCeleste.php` — accessor indent | ✅ |
| **F8** | `Navbar.jsx` + `Footer.jsx` — logo oversized | ✅ |
| **F7** | `SearchBar.jsx` — focus-visible ring | ✅ |
| **F3** | `Comparatore.jsx` — hardcoded hex → CSS vars | ✅ |
| **B10** | `flash.blade.php` — 3 blocks → foreach loop | ✅ |
| **F4** | `CorpiLista.jsx` + `hooks/useDebounce.js` — extract hook | ✅ |

### ✅ Completato — Bug residui (17/07/2026)

Tutti i bug residui risolti. 359 test (252 PHPUnit + 107 Vitest), tutti verdi.

- [x] `[🎨frontend][🟠P1]` Mobile nav Escape + click-outside — `Navbar.jsx`
- [x] `[🧪test][🔵P2]` Test accessor nome_display + immagine_url — `tests/Unit/CorpoCelesteTest.php` (6 test)
- [x] `[🧪test][🔵P2]` Test setImageFromGallery: non-admin 403, remote URL, flash — `CorpoCelesteActionsTest.php`
- [x] `[🧪test][🔵P2]` Test suggestNome: non-admin, caching, fallback raw Italian — `CorpoCelesteActionsTest.php`
- [x] `[🧪test][🔵P2]` Test ImportNasaImage job: implements, proprietà, uniqueId, handle, failed — `tests/Unit/ImportNasaImageTest.php` (9 test)
- [x] `[🖥️backend][🟠P1]` memory_limit=512M — rimosso (codice inesistente)
- [x] `[🎨frontend][🔵P2]` framer-motion mantenuto (uso legittimo in SolarSystem)
