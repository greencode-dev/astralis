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
- **Guest frontend**: React 18, Vite, react-router-dom, lucide-react, yet-another-react-lightbox
- **Admin frontend**: Blade, Alpine.js (npm, bundled via Vite)
- **CSS**: Tailwind CSS
- **Upload**: Laravel Storage nativo (`disk('public')`) per copertine. Intervention Image v4 solo per import NASA (`scaleDown()`, NO facade)
- **SSL**: `Http::withoutVerifying()` solo in local/testing (Windows)
- **Slug**: spatie/laravel-sluggable

## Dual rendering (critical)

- **Guest pages**: React SPA standalone (`resources/js/guest/`). Entry: `main.jsx`. Routes: `/`, `/corpi-celesti`, `/corpi-celesti/:slug`, `/confronta`, `/*` (404)
- **Admin pages**: Blade puro (`resources/views/admin/`). Master layout: `layouts/app.blade.php`
- **API**: `routes/api.php` — 10 endpoint JSON pubblici
- **Authorization**: Policy + Gates in `app/Policies/` e `app/Providers/AuthServiceProvider.php`

## Entità chiave

1. **Categoria** — nome, slug, icona, descrizione, colore
2. **CorpoCeleste** — nome (italiano, primary), nome_en (inglese), slug, categoria_id, immagine, immagine_utente (boolean), descrizione, tipo, massa_kg, distanza_km, diametro_km, gravita, temperatura, periodo_orbitale, scopritore, anno_scoperta, in_evidenza, nasa_id
3. **Missione** — nome, slug, logo, agenzia, data_lancio, durata_giorni, stato, descrizione, sito_web
4. **Curiosità** — corpo_celeste_id, titolo, descrizione, fonte
5. **GalleriaCorpo** — corpo_celeste_id, percorso (URL remoto o filename locale), didascalia, crediti, ordine

## File map

| Percorso                                                     | Ruolo                                                                                |
| ------------------------------------------------------------ | ------------------------------------------------------------------------------------ |
| `routes/web.php`                                             | Route admin + auth + catch-all SPA (`/{any}` → `guest.blade.php`)                    |
| `routes/api.php`                                             | 10 endpoint JSON pubblici                                                            |
| `routes/auth.php`                                            | Route Breeze (login, register, etc.)                                                 |
| `app/Services/NasaImageService.php`                          | Import NASA con dedup, preserva immagine utente, timeout 30s, retry 2, testing guard |
| `app/Observers/CorpoCelesteObserver.php`                     | Auto-import NASA su created (skip in testing via`app()->environment('testing')`)     |
| `app/Services/WordMapService.php`                            | Traduzione italiano→inglese per NASA suggest admin                                   |
| `app/Console/Commands/CleanupGalleryDuplicates.php`          | Comando`astralis:gallery` (--check/--clean/--sync/--fix/--dry-run)                   |
| `app/Policies/`                                              | Policy autorizzazione (5 Policy, una per entità)                                     |
| `app/Providers/AuthServiceProvider.php`                      | Registrazione Policy + Gate`admin`                                                   |
| `app/Http/Controllers/Admin/ExamController.php`              | Dashboard esame: stats, architettura, endpoint, tech stack                          |
| `resources/views/admin/exam/index.blade.php`                 | Vista dashboard exam (quick reference)                                               |
| `docs/preparazione-esame.md`                                          | Preparazione esame: traccia, Q&A, definizioni PHP/Laravel/React, live coding  |
| `start-exam.bat`                                             | Script avvio unificato (migrate:fresh + artisan serve + npm run dev)                 |
| `docs/astralis.postman_collection.json`                      | Postman collection per demo API                                                      |
| `app/Http/Controllers/Admin/`                                | Controller CRUD admin (Blade)                                                        |
| `app/Http/Controllers/Api/`                                  | Controller API (JSON)                                                                |
| `app/Http/Controllers/Auth/`                                 | Controller auth Breeze (Blade)                                                       |
| `resources/views/admin/layouts/app.blade.php`                | Master layout admin (sidebar + Alpine.js + x-cloak)                                |
| `resources/views/admin/partials/_sidebar-nav.blade.php`      | Sidebar nav rendering (reads config/admin.php)                                       |
| `resources/views/admin/partials/category-badge.blade.php`    | Reusable category badge                                                              |
| `resources/views/admin/partials/index-header.blade.php`      | Index page header with create button                                                 |
| `resources/views/admin/partials/dashboard-stat.blade.php`    | Dashboard stat card                                                                  |
| `resources/views/admin/partials/empty-table-row.blade.php`   | Empty table state                                                                    |
| `resources/views/admin/partials/in-evidenza-badge.blade.php` | Featured badge                                                                       |
| `config/admin.php`                                           | Nav items, mission stati, color presets                                              |
| `resources/js/guest/hooks/useDebounce.js`                    | Shared debounce hook                                                                 |
| `resources/js/guest/pages/NotFound.jsx`                      | 404 page (catch-all route)                                                           |
| `resources/js/guest/`                                        | React SPA guest                                                                      |
| `resources/js/admin.js`                                      | Admin Alpine.js entry point (npm, bundled via Vite)                                  |
| `resources/js/admin-charts.js`                               | Admin Chart.js entry point (npm, bundled via Vite)                                  |
| `vite.config.js`                                             | Config Vite: React plugin, Alpine.js, proxy API`/api` → `http://localhost:8000`     |

## Testing

- **Factories**: Tutti i 5 modelli hanno `HasFactory` trait. Le factory sono in `database/factories/`. `CorpoCelesteFactory` crea automaticamente una `Categoria` associata.
- **Observer in test**: `CorpoCelesteObserver::created()` auto-importa da NASA quando un `CorpoCeleste` viene creato. In test si disabilita automaticamente (`app()->environment('testing')`).
- **Http::fake()**: Tutti i test che creano `CorpoCeleste` via factory includono `Http::fake()` in setUp per prevenire chiamate HTTP reali.
- **Run**: `php artisan test` — 271 test PHPUnit, 615 assertion. `npm test` — 110 test Vitest. Totale: 381 test.

## File Header Comments

Ogni file principale del progetto deve avere un **commento esplicativo sintetico** in cima (riga 1-2). Il commento descrive in italiano cosa fa il file e quali pattern contiene.

### Regole

1. **Tutti i 27 file** elencati in `config/admin.php` → `file_headers` devono avere il commento
2. Quando modifichi un file e il commento diventa obsoleto → aggiorna **sia il file che `config/admin.php`**
3. Il **pre-commit hook** verifica automaticamente che i commenti siano aggiornati prima di ogni commit
4. Check manuale: `php artisan astralis:check-headers`

### File protetti

| File | Formato commento |
|------|------------------|
| `routes/api.php` | `// API REST pubbliche — [descrizione]` |
| `routes/web.php` | `// Route admin (Blade+auth) + catch-all SPA React. [dettagli]` |
| `Admin/CorpoCelesteController.php` | `// CRUD CorpoCeleste: [metodi]` |
| `CorpoCeleste.php` | `// Model: [campi], [relazioni]. [note]` |
| `NasaImageService.php` | `// Service Layer: [funzionalità]. [metodi]. [note]` |
| `CorpoCelesteObserver.php` | `// Observer: [azione]. [note testing]` |
| `ImportNasaImage.php` | `// Job queue: [descrizione]. [pattern]. [dispatch]` |
| `CorpoCelestePolicy.php` | `// Policy: [logica before()]. [note admin/non-admin]` |
| `AuthServiceProvider.php` | `// Registra [N] Policy + Gate [nome]. [scopo]` |
| `Api/CorpoCelesteController.php` | `// Controller API: [N] endpoint [metodi]. [pattern]` |
| `main.jsx` | `// Entry point React SPA: [descrizione]. [scopo]` |
| `App.jsx` | `// Routing React: [N] route ([elenco]). [dettagli]` |
| `apiClient.js` | `// Client API: [libreria]. [config]. [note proxy]` |
| `useFetch.js` | `// Custom hook: [pattern]. [funzionalità]. [note]` |
| `Categoria.php` | `// Model: [campi]. [relazioni]. [note]` |
| `Missione.php` | `// Model: [campi]. [relazioni]. [note]` |
| `Curiosita.php` | `// Model: [campi]. [relazioni]. [note]` |
| `GalleriaCorpo.php` | `// Model: [campi]. [relazioni]. [note]` |
| `DashboardController.php` | `// Dashboard: [stat card]. [grafici]. [cache]` |
| `NasaImportController.php` | `// NASA Import: [metodi]. [dispatch]` |
| `WordMapService.php` | `// Service Layer: [traduzione]. [termini]. [cache]` |
| `ImageUploadService.php` | `// Service Layer: [upload]. [resize]. [disk]` |
| `CategoriaPolicy.php` | `// Policy: [logica]. [esempio relazione]` |
| `SolarSystem.jsx` | `// Componente: [animazione]. [pattern]. [interazioni]` |
| `CorpoCard.jsx` | `// Componente: [contenuto]. [ottimizzazione]` |
| `CorpoDettaglio.jsx` | `// Pagina: [sezioni]. [funzionalità]` |
| `Comparatore.jsx` | `// Pagina: [metriche]. [state]. [interazione]` |

### Aggiornare un commento

1. Modifica il commento nel file sorgente
2. Aggiorna la stessa stringa in `config/admin.php` → `file_headers`
3. Il pre-commit hook verificherà la corrispondenza al prossimo commit

## Bugs noti / Pattern da evitare

- **Nessuna dipendenza CDN rimanente** — Alpine.js e Chart.js bundled via Vite. Solo fonts (fonts.bunny.net) restano esterne.
- **bootstrap/cache**: su Windows, se creata da Git Bash, va ricreata con `cmd //c 'rmdir /s /q bootstrap\cache' && cmd //c 'mkdir bootstrap\cache'`
- **`[x-cloak]`**: style in `resources/css/app.css` per prevenire FOUC con Alpine.js
- **Dual slash in cmd**: da Git Bash usare `cmd //c` (doppio slash), non `cmd /c`
- **Vite proxy API**: `vite.config.js` ha `server.proxy: { '/api': 'http://localhost:8000' }` — senza proxy, le chiamate API da `http://localhost:5175/` falliscono con CORB/white page. Il proxy inoltra le richieste `/api` al backend Laravel

## Admin palette

- Sfondo: `#0A0A1A`, Card: `#111128`, Testo: `#F0F0FA`
- Primario: `#22D3EE`, Secondario: `#A855F7`, Accento: `#F97316`
- Badge OK: `#22C55E`, KO: `#9CA3AF`, attenzione: `#FACC15`

## Workflow

### Fase 0 — Avvio sessione (`\start`)

Quando l'utente scrive `\start`, eseguire automaticamente questo flusso (solo lettura):

1. **Caricare le skill Astralis**: `astralis-laravel`, `astralis-react-spa`, `astralis-blade-admin`, `astralis-testing`.
2. **Caricare le skill globali**: `frontend-design`, `vercel-react-best-practices`, `vercel-composition-patterns`, `web-design-guidelines`, `writing-guidelines`.
3. **Stato repo**: `git fetch origin` → `git status` → `git log --oneline -5` → `git log HEAD..origin/{branch} --oneline` → `git stash list` → `git diff --stat`.
4. **Task aperte**: leggere `docs/todo.md` → sezione "Da Fare", raggruppare per priorità.
5. **Attività recenti**: leggere `docs/changelog.md` → prime 2-3 entry.
6. **Snapshot progetto**: leggere `AGENTS.md` → sezione "Stato avanzamento" (test count, fasi completate).
7. **Knowledge graph**: eseguire `graphify explain "Astralis"` per una visione d'insieme dell'architettura (se il grafo esiste).
8. **Ultima sessione**: leggere `### Sessione corrente` in AGENTS.md. Se presente, includere nel report: dove eravamo rimasti, task in corso, prossime azioni suggerite.

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
- 🔴 [Critic]: [lista]
- 🟡 [High]: [lista]
- 🔵 [Medium]: [lista]
- 🟢 [Low]: [lista]

**Grafo**: [riepilogo architettura da graphify]

**Ultima sessione** (se snapshot presente):
- Ultimo commit: `abc1234` — messaggio
- Task in corso: [lista]
- Prossime azioni: [suggerimento]

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

Per ogni azione irreversibile (commit, push, modifica file critici), usare il tool `question` con opzioni `["Si, procedi", "No, sospendi"]` per ottenere conferma esplicita prima di procedere. Mai eseguire senza conferma.

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

1. **Numerazione**: `[Task N]` progressiva (1-N, mai riutilizzare numeri assegnati).
2. **Una sola intestazione per giorno** — mai dividere in sessioni.
3. **Ordine item**: task number decrescente (Task N → Task 1), poi priorità decrescente (`[🔴]` → `[🟡]` → `[🔵]` → `[🟢]`) a parità di numero.
4. **Formato**: `- [ ] [Task N] \`[Priorità][Topic]\` Descrizione — \`file/principale\``
5. **Priorità**: `[🔴]` Critic · `[🟡]` High · `[🔵]` Medium · `[🟢]` Low.
6. **Topic**: `[🖥️]` Backend · `[🎨]` Frontend · `[💾]` Database · `[🧪]` Test · `[✨]` Feature · `[📝]` Docs.
7. Aggiornare `*Ultimo aggiornamento:*` con la data odierna.
8. Aggiornare la sezione `## Note` con conteggio corretto di task aperte e test.
9. Spostare i task completati (`[x]`) da **Da Fare** a **Fatto**, sotto la data corrente, in ordine decrescente (più recente prima). Aggiungere `---` come separatore tra blocchi di date diverse.
10. Non creare duplicati. Non riutilizzare numeri di task eliminati. Verificare che non ci siano vuoti numerici (es. Task 5 → Task 7 senza Task 6). Il numero della prossima task da creare è `max(tutti i numeri esistenti) + 1`.

#### docs/changelog.md

1. **Una sola intestazione per giorno**: `## GG/MM/AAAA`.
2. Formato entry: ``- `[Priorità][Topic]` Descrizione — `file/coinvolto` ``.
3. Tag: `[🖥️]` Backend · `[🎨]` Frontend · `[💾]` Database · `[🧪]` Test · `[✨]` Feature · `[📝]` Docs.
4. Priorità: `[🔴]` Critic · `[🟡]` High · `[🔵]` Medium · `[🟢]` Low · `[🟣]` P3 (Accessibilità) · `[⚪]` P4 (Futuro).
5. Ordine: cronologico inverso (più recente prima).
6. Separatore `---` tra ogni blocco data.
7. Includere: bug fix, feature, refactor, breaking changes, test count.
8. Non includere: commit minori, typo fix.
9. Chiudere ogni entry con: `**Test**: N totali (X PHPUnit + Y Vitest), tutti verdi.`.
10. Aggiornare test count solo nell'ultima entry della giornata.
11. Legenda in fondo al file + link rapido in cima.

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
5. **Conferma**: usare il tool `question` — header: "Conferma commit", opzioni: `["Si, procedi", "No, sospendi"]` — prima di eseguire `git commit`.
6. Se ci sono anche modifiche non collegate, chiedere se committare tutto insieme o selezionare con `git add -p`.

### Fase 6 — Push

Prima di eseguire `git push`:

1. **Verifica sincronizzazione**: `git fetch origin` + `git log HEAD..origin/{branch} --oneline`.
    - Se ci sono commit remote non pullati → eseguire Fase 2 prima del push.
    - Se il branch non esiste sul remote → primo push, usare `question` tool per conferma.
2. **Verifica commit recenti**: `git log --oneline -5`.
    - Se ci sono commit con messaggi simili o che fixano lo stesso file → segnalare e proporre squash (`git rebase -i`) o lasciare così.
3. **Conferma**: usare il tool `question` — header: "Conferma push", opzioni: `["Si, procedi", "No, sospendi"]` — prima di `git push`.

### Comando \commit

Flusso commit automatizzato quando l'utente scrive `\commit`:

1. Eseguire `git status --short` e mostrare all'utente l'elenco dei file modificati.
2. Se tra i file ci sono potenziali secrets (`.env`, credenziali, chiavi, `.env.example` con valori reali), **fermare tutto** e avvisare l'utente.
3. Eseguire `git diff --stat` per mostrare un riepilogo delle modifiche.
4. Proporre un messaggio di commit seguendo il formato Fase 5: `tipo: descrizione concisa` (`fix:`, `feat:`, `docs:`, `refactor:`, `test:`, ecc.). Basare il prefisso sul contenuto effettivo delle modifiche.
5. **Conferma**: usare il tool `question` — header: "Conferma commit", opzioni: `["Si, procedi", "No, sospendi"]` — prima di eseguire `git add . && git commit`.
6. Se ci sono modifiche non collegate, chiedere se committare tutto insieme o selezionare con `git add -p`.
7. Dopo il commit, mostrare `git log --oneline -1` per verificare.

### Comando \push

Flusso push automatizzato quando l'utente scrive `\push`:

1. `git fetch origin` per verificare lo stato remoto.
2. `git log HEAD..origin/{branch} --oneline` — se ci sono commit remote non pullati, informare l'utente e chiedere se eseguire pull prima del push.
3. `git log --oneline -5` — se ci sono commit con messaggi simili o che fixano lo stesso file, segnalare e proporre squash (`git rebase -i`) o lasciare così.
4. Verificare il branch corrente e il tracking remoto.
5. **Conferma**: usare il tool `question` — header: "Conferma push", opzioni: `["Si, procedi", "No, sospendi"]` — prima di `git push`.
6. Dopo il push, mostrare `git log --oneline -1` per verificare.

### Comando \save

Flusso di chiusura sessione quando l'utente scrive `\save`:

1. **Stato**: `git status --short` + `git diff --stat` + `git log --oneline -1`.
2. **Aggiornare documentazione** seguendo le regole Fase 3: todo.md, changelog.md, testing.md, bug.md, documentazione.md, README.md, AGENTS.md (test count, file map, bugs noti).
3. **Snapshot sessione**: aggiornare `### Sessione corrente` in AGENTS.md (sovrascrivere la precedente).
4. **Report chiusura**: generare un riepilogo della sessione (modifiche, task completate, test finali, prossime azioni).
5. **Grafo**: `graphify update .`.
6. **Commit**: comporre il messaggio seguendo il formato Fase 5. Usare il tool `question` — header: "Conferma commit", opzioni: `["Si, procedi", "No, sospendi"]` — prima di `git add . && git commit`.
7. **Push** (opzionale): dopo il commit, usare il tool `question` — header: "Eseguire push ora?", opzioni: `["Si, push ora", "No, lascia per dopo"]` — per decidere se eseguire `git push` immediatamente o posticipare.

### Comando \todo

Flusso di gestione task quando l'utente scrive `\todo`:

**Fase A — Check iniziale**

1. Leggere `docs/todo.md`.
2. Verificare la data di `*Ultimo aggiornamento:*`.
3. Contare le task aperte (`[ ]`) e raggrupparle per priorità.
4. Generare report:

```
📋 Todo check — DD/MM/YYYY

**Aggiornamento**: GG/MM/AAAA
**Task aperte**: N totali
🔴 Critic: X | 🟡 High: Y | 🔵 Medium: Z | 🔵 Low: W

**Lista task**:
- [Task N] `[P][T]` Descrizione
- ...
```

5. **Questions**: "Cosa vuoi fare?" — opzioni: `["A) Lavora sulle task", "B) Rivedi le task"]`.

---

**Opzione A — Lavora sulle task**

1. **Questions**: "Modalità esecuzione?" — opzioni: `["Automatica (commit silente, prosegue tutto)", "Manuale (dopo ogni task: commit + prossima?)"]`.
2. **Multi-select**: elencare "Tutte le task" come prima opzione, poi ogni task singola.
3. **Check plan mode**: se in plan mode, avvisare e chiedere di scrivere "vai" per procedere.
4. **Esecuzione per ogni task selezionata**:
    a. Generare report dettagliato: priorità, pro/contro, suggerimenti, alternative.
    b. **Questions**: "Procedi con questa task?" — opzioni: `["Si, procedi", "No, salta"]`.
    c. Se si → marcare come `in_progress`, eseguire il lavoro.
    d. Se no → passare alla prossima.
    e. Dopo completamento:
        - **Commit**: in modalità automatica, commit silente con messaggio specifico per task (`feat/fix/refactor: descrizione`). In modalità manuale, **Questions**: "Eseguire commit?" — opzioni: `["Si, committa", "No, prosegui"]`.
        - Spostare la task da **Da Fare** a **Fatto** con data corrente.
        - Mini-report: task completata + task rimanenti + suggerimento prossima.
    f. **Se task fallisce** (errore test, conflitto, ecc.):
        - Skip della task (+ eventuali task dipendenti).
        - Continuare con la successiva.
        - Registrare il motivo del fallimento per il report finale.
5. **Report finale**:

```
📊 Report esecuzione — DD/MM/YYYY

**Avviate**: N | Completate: ✅ X | Fallite: ❌ Y | Saltate: ⏭️ Z

### ✅ Completate
- [Task N] Descrizione

### ❌ Fallite
- [Task N] Descrizione — Motivo: ...

### ⏭️ Saltate (dipendenza da task fallita)
- [Task N] Descrizione — Dipende da: [Task M]
```

---

**Opzione B — Rivedi le task**

1. **Multi-select**: `["Rivalutare task esistenti", "Aggiungere nuova task", "Modifica/Elimina task"]`.

**Rivalutare**:
1. **Multi-select**: elencare tutte le task aperte.
2. Per ogni task selezionata, **multi-select**: `["Cambia priorità", "Cambia descrizione", "Cambia file"]`.
3. Per ogni campo selezionato, **questions** con opzioni attuali + nuove.
4. Report prima/dopo + **Questions**: "Confermi le modifiche?".

**Aggiungere**:
1. **Questions**: "Descrivi la nuova task".
2. Io suggerisco priorità e topic basandomi sulla descrizione.
3. **Questions**: "Confermi?" — opzioni: `["Si, aggiungi", "No, annulla"]`.
4. Se si → aggiungo al todo con numerazione progressiva.

**Modifica/Elimina**:
1. **Questions**: "Indica il numero della task".
2. **Questions**: "Modifica o elimina?" — opzioni: `["Modifica", "Elimina"]`.
3. Se modifica → **Questions**: cosa cambiare (descrizione, priorità, file).
4. Se elimina → **doppia conferma esplicita**:
    - Prima: "Sei sicuro di voler eliminare la task N?"
    - Seconda: "Conferma eliminazione definitiva della task N".
5. Eseguo solo dopo entrambe le conferme.

---

### Comando \check

Report rapido senza domande quando l'utente scrive `\check`:

1. Eseguire la **Fase A — Check iniziale** di `\todo`.
2. Mostrare report con data aggiornamento, conteggio per priorità e lista task.
3. Fine (zero domande successive).

### Comando \audit

Flusso di audit completo quando l'utente scrive `\audit`:

**Fase A — Design Review** (skill: `frontend-design`)

1. Scansionare tutti i file React guest (`resources/js/guest/**/*.jsx`).
2. Scansionare tutti i file Blade admin (`resources/views/admin/**/*.blade.php`).
3. Per ogni file, verificare: palette, tipografia, layout, firma visiva, motion.
4. Output: elenco finding con `file:riga`, priorità (high/medium/low), raccomandazione.

**Fase B — Web Guidelines Audit** (skill: `web-design-guidelines`)

1. Fetch delle linee guida fresche da:
   `https://raw.githubusercontent.com/vercel-labs/web-interface-guidelines/main/command.md`
2. Scansionare tutti i file React (`resources/js/guest/**/*.jsx`).
3. Verificare: accessibilità (aria, role, keyboard), responsive, reduced motion, performance.
4. Output: elenco finding categorizzati per priorità.

**Fase C — Writing Review** (skill: `writing-guidelines`)

1. Fetch delle linee guida fresche da:
   `https://raw.githubusercontent.com/vercel-labs/writing-guidelines/main/command.md`
2. Scansionare tutti i file Markdown (`docs/**/*.md`, `README.md`, `AGENTS.md`).
3. Verificare: ellipsis, heading case, passive voice, filler words, mixed language.
4. Output: elenco finding con `file:riga` + tipo di problema.

**Fase D — Report**

1. Raggruppare tutti i finding per priorità (🔴 high → 🟡 medium → 🔵 low).
2. Generare report con formato:

```
🔍 Audit completo — DD/MM/YYYY

**File analizzati**: N React + M Blade + P Markdown = T totali
**Finding totali**: X (🔴 Y high, 🟡 Z medium, 🔵 W low)

### 🔴 High (da fixare)
- [lista per file]

### 🟡 Medium (da considerare)
- [lista per file]

### 🔵 Low (nice to have)
- [lista per file]

**Suggerimento**: trasformare i finding high in task nel todo.md?
```

3. Chiedere all'utente se vuole che i finding high vengano convertiti in task nel `docs/todo.md`.
4. Se sì, aggiungere le task con formato `[Task N]` `[🟡][🎨/📝]` Descrizione — `file`.

## Skill installate

Skill globali sempre disponibili in `~/.config/opencode/skills/`:

| Skill                         | Attivazione                              |
| ----------------------------- | ---------------------------------------- |
| `frontend-design`             | Design UI/UX, componenti React, layout   |
| `vercel-react-best-practices` | Ottimizzazione React/Next.js (70 regole) |
| `vercel-composition-patterns` | Pattern composizione React               |
| `webapp-testing`              | Testing Playwright                       |
| `web-design-guidelines`       | Review UI/accessibilità                  |
| `writing-guidelines`          | Review scrittura documentazione          |
| `claude-api`                  | Documentazione API Claude/SDK            |
| `mcp-builder`                 | Creazione MCP server                     |
| `theme-factory`               | Tema colori/font per artefatti           |
| `web-artifacts-builder`       | Artefatti React+Tailwind+shadcn          |
| `skill-creator`               | Creazione/modifica skill                 |
| `brand-guidelines`            | Brand Identity Anthropic                 |

Skill custom Astralis in `.opencode/skills/`:

| Skill                  | Scopo                                                        |
| ---------------------- | ------------------------------------------------------------ |
| `astralis-laravel`     | Pattern backend Laravel (Observer, Policy, Service, Command) |
| `astralis-react-spa`   | Pattern frontend React SPA (routing, API, animazioni)        |
| `astralis-blade-admin` | Pattern admin Blade (Alpine.js, CRUD, palette)               |
| `astralis-testing`     | Pattern test (PHPUnit + Vitest, factory, Http::fake)         |

## Cross-PC sync

Quando pulli la repo su un'altra macchina (o dopo tanto tempo), segui la guida in [`docs/documentazione.md#guida-al-rientro-clone-su-altro-pc`](docs/documentazione.md#guida-al-rientro-clone-su-altro-pc).

Procedura rapida:

1. `composer install` — aggiorna dipendenze PHP
2. `npm install` — aggiorna dipendenze JS
3. `php artisan migrate` — applica nuove migrazioni
4. `php artisan storage:link` — ricrea il symlink storage
5. `php artisan astralis:gallery --fix` — ripara immagini galleria se necessario
6. `python -m graphify update .` — ricostruisce il grafo locale (graphify è il pacchetto Python, non l'npm)
7. Verifica `git status` — working tree deve essere pulito dopo grafo

Per il setup completo delle skill OpenCode: [`docs/documentazione.md#setup-opencode-skills`](docs/documentazione.md#setup-opencode-skills).

## Stato avanzamento piano ottimizzazione

### Sessione corrente

> _Ultimo aggiornamento:_ 22/07/2026 — 23:30

| Campo               | Valore                                                                                                 |
| ------------------- | ------------------------------------------------------------------------------------------------------ |
| **Branch**          | `master`                                                                                               |
| **Test**            | 271 PHPUnit + 110 Vitest = 381 totali, tutti verdi                                                    |
| **Task completate** | 138 task totali completate (audit frontend 129-138 chiuso)                                             |
| **Task aperte**     | 0 — piano ottimizzazione completato                                                                    |
| **Prossime azioni** | Piano completato. Possibili miglioramenti futuri: SBDB/Horizons API, bottone "Cerca info NASA"         |

### Piano rinomina campi + galleria inline (Task 103-115)

**Obiettivo**: Rinominare `nome_it`→`nome` (italiano, primary), `nome`→`nome_en` (inglese). Auto-traduzione IT→EN, galleria inline nel form, upload copertina Laravel nativo.

| Fase | Descrizione                                                                 | Task   | Stato |
| ---- | --------------------------------------------------------------------------- | ------ | ----- |
| **1** | Migrazione DB: rename colonne + swap dati + rigenera slug italiano           | 103    | ✅    |
| **2** | Model: fillable, rimuovi accessor nome_display, estendi immagine_url         | 104    | ✅    |
| **3** | Factory + Seeder: swap nomi, immagini default pianeti, slug                  | 105    | ✅    |
| **4** | Service: WordMapService auto-popola, NasaImageService usa nome_en            | 106-107| ✅    |
| **5** | Validation: Store, Update, SuggestNomeRequest                                | 108    | ✅    |
| **6** | Controller: admin CRUD, API, translate route, upload copertina, galleryAdd  | 109    | ✅    |
| **7** | Resource: API response solo nome (italiano)                                  | 110    | ✅    |
| **8** | Route: nuove endpoint translate, gallery (gallery-add aggiunto)              | 111    | ✅    |
| **9** | Blade: _form ristrutturato (6 sezioni), show, dashboard                     | 112    | ✅    |
| **10**| JS: auto-translate debounce, galleria inline, copertina preview             | 113    | ✅    |
| **11**| React SPA: aggiorna fixture, rimuovi nome_display, usa solo nome            | 114    | ✅    |
| **12**| Test: PHP + JS aggiornati per nuovi campi                                    | 115    | ✅    |

**Decisioni chiave**:
- Upload file: Laravel nativo (senza Intervention Image)
- `nome_en`: nullable (tradotto auto, non bloccante)
- Slug: rigenerati in italiano
- Accessor `nome_display`: rimosso
- React API: solo `nome` (italiano)
- WordMapService: auto-popola da MyMemory fallback
- Galleria: URL remoti NASA, nessun download locale
- Immagini default: PNG da `public/images/solar-system/`
- Bottone "Cerca info NASA": future task
- SBDB/Horizons API: future task

### ✅ Completato — Piano ottimizzazione (Task 1-39)

Tutte le task del piano sono completate. 377 test (267 PHPUnit + 110 Vitest).

| Task   | Descrizione                                                          | Stato |
| ------ | -------------------------------------------------------------------- | ----- |
| **1**  | Setup Laravel + Breeze + React + documentazione                      | ✅    |
| **2**  | Database e Modelli (6 migrations, 5 models, seeder)                  | ✅    |
| **3**  | CRUD Admin (Categorie, Corpi Celesti, Missioni, Curiosità, Galleria) | ✅    |
| **4**  | API REST (10 endpoint)                                               | ✅    |
| **5**  | React: Homepage, Sistema solare animato, Lista                       | ✅    |
| **6**  | React: Dettaglio, Lightbox, Missioni, Comparatore                    | ✅    |
| **7**  | Bugfix Intervention Image v4, Force Import All                       | ✅    |
| **8**  | NASA Import multi-immagine, Service Layer, CLI fetch-nasa            | ✅    |
| **9**  | Remote URLs, nome_it/nome_display, wordMap, auto-suggest admin       | ✅    |
| **10** | Bug critici: route(), nasa_id, categoria_id                          | ✅    |
| **11** | Bugfix auth, NASA import dedup, galleria cleanup                     | ✅    |
| **12** | Authorization Policy/Gates ai controller admin                       | ✅    |
| **13** | Auth pages: Inertia → Blade puro                                     | ✅    |
| **14** | Rimossa dipendenza Inertia                                           | ✅    |
| **15** | FormRequest validazione store/update CorpoCeleste                    | ✅    |
| **16** | Quick wins: per_page, relazioni, .catch, nasa_id, indexes            | ✅    |
| **17** | 10 bug critici fixati                                                | ✅    |
| **18** | Rimossi import morti React + dipendenze inutilizzate                 | ✅    |
| **19** | Inline styles → Tailwind classes (~68 oggetti in 15 file)            | ✅    |
| **20** | framer-motion → CSS transitions + SolarSystem clickable/immagini     | ✅    |
| **21** | Cache dashboard + invalidazione su CRUD                              | ✅    |
| **22** | Form partial unificato: 5 \_form.blade.php, 10 create/edit           | ✅    |
| **23** | Partials Blade: back-link, search, flash, stat-card, actions         | ✅    |
| **24** | Hardcoded hex → CSS variables: 13 variabili, 52 hex sostituiti       | ✅    |
| **25** | CSS component class: .admin-input, 8 Blade views                     | ✅    |
| **26** | React.memo: LightboxGalleria + Thumbnail                             | ✅    |
| **27** | Authorization consistente: DashboardController fixato                | ✅    |
| **28** | suggestNome caching + debounce: Cache::remember(3600)                | ✅    |
| **29** | AdminTestCase base class: 5/5 CRUD test                              | ✅    |
| **30** | AuthorizationTest: 19 test                                           | ✅    |
| **31** | Uniform Http::fake() pattern                                         | ✅    |
| **32** | Frontend fixtures.js centralizzato                                   | ✅    |
| **33** | Factory foreign key fix: ->for() pattern                             | ✅    |
| **34** | Copertura test mancante: 21 nuovi test                               | ✅    |
| **35** | DashboardApiTest complete: 4 test                                    | ✅    |
| **36** | Web Design Guidelines audit                                          | ✅    |
| **37** | Writing Guidelines audit                                             | ✅    |
| **38** | Frontend Design audit                                                | ✅    |
| **39** | (audit completati)                                                   | ✅    |

### ✅ Completato — Sicurezza e UX (Fasi 1-3)

377 test (267 PHPUnit + 110 Vitest), tutti verdi.

| Fase                  | Descrizione                                                                               | Fix                     | Stato |
| --------------------- | ----------------------------------------------------------------------------------------- | ----------------------- | ----- |
| **1 — Security**      | is_admin fillable, colore regex, didascalia max, throttle, FK restrict                    | C1, C2, C5, H1, H2, H3  | ✅    |
| **2 — Critical bugs** | apiClient retry, simili race condition, job unique, color picker, conferma import         | C3, C4, H4, H13, H15    | ✅    |
| **3 — UX & quality**  | useFetch keep-data, Comparatore URL, Navbar mobile, gravita IT locale, flash auto-dismiss | H7, H8, H9, H11, M1, M2 | ✅    |

### ✅ Completato — Quick wins (16/07/2026)

267 PHPUnit + 110 Vitest, tutti verdi.

| Fix     | File                                                     | Stato |
| ------- | -------------------------------------------------------- | ----- |
| **B1**  | `Admin/CorpoCelesteController.php` — orWhere grouping    | ✅    |
| **B3**  | `CorpoCeleste.php` — accessor indent                     | ✅    |
| **F8**  | `Navbar.jsx` + `Footer.jsx` — logo oversized             | ✅    |
| **F7**  | `SearchBar.jsx` — focus-visible ring                     | ✅    |
| **F3**  | `Comparatore.jsx` — hardcoded hex → CSS vars             | ✅    |
| **B10** | `flash.blade.php` — 3 blocks → foreach loop              | ✅    |
| **F4**  | `CorpiLista.jsx` + `hooks/useDebounce.js` — extract hook | ✅    |

### ✅ Completato — Bug residui (17/07/2026)

Tutti i bug residui risolti. 377 test (267 PHPUnit + 110 Vitest), tutti verdi.

- [x] `[🟡][🎨]` Mobile nav Escape + click-outside — `Navbar.jsx`
- [x] `[🔵][🧪]` Test accessor nome_display + immagine_url — `tests/Unit/CorpoCelesteTest.php` (6 test)
- [x] `[🔵][🧪]` Test setImageFromGallery: non-admin 403, remote URL, flash — `CorpoCelesteActionsTest.php`
- [x] `[🔵][🧪]` Test suggestNome: non-admin, caching, fallback raw Italian — `CorpoCelesteActionsTest.php`
- [x] `[🔵][🧪]` Test ImportNasaImage job: implements, proprietà, uniqueId, handle, failed — `tests/Unit/ImportNasaImageTest.php` (9 test)
- [x] `[🟡][🖥️]` memory_limit=512M — rimosso (codice inesistente)
- [x] `[🔵][🎨]` framer-motion mantenuto (uso legittimo in SolarSystem)
