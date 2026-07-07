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
- **Auth**: Laravel Breeze (Inertia login/register → Blade admin)
- **Database**: MySQL (port 3307)
- **Guest frontend**: React 19, Vite, framer-motion, react-router-dom, lucide-react, yet-another-react-lightbox
- **Admin frontend**: Blade, Alpine.js (CDN da unpkg — no local fallback)
- **CSS**: Tailwind CSS
- **Upload**: Intervention Image v4 — **NO facade**. Usare `ImageManager(new Driver())->decodePath()`/`->decodeBinary()`, `scaleDown()` invece di `resize()`
- **SSL**: `Http::withoutVerifying()` su tutte le chiamate NASA (Windows)
- **Slug**: spatie/laravel-sluggable
- **PDF**: barryvdh/laravel-dompdf

## Dual rendering (critical)

- **Guest pages**: Inertia React (`resources/js/guest/`). Entry: `main.jsx`. Routes: `/`, `/corpi-celesti`, `/corpi-celesti/:slug`, `/confronta`
- **Admin pages**: Blade puro (`resources/views/admin/`). Master layout: `layouts/app.blade.php`
- **API**: `routes/api.php` — 10 endpoint JSON pubblici
- **Transizione Inertia→Blade**: i controller auth che fanno POST da pagine Inertia e reindirizzano a route Blade devono usare `Inertia::location()` invece di `redirect()->to()`. Questo forza un full page reload lato client, evitando che Inertia intercetti il redirect e tenti di caricare HTML come JSON. Controller interessati: AuthenticatedSessionController, ConfirmablePasswordController, EmailVerificationNotificationController, EmailVerificationPromptController, RegisteredUserController, VerifyEmailController.

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
| `app/Services/NasaImageService.php` | Import NASA con dedup, preserva immagine utente, timeout 30s, retry 2 |
| `app/Console/Commands/CleanupGalleryDuplicates.php` | Comando `astralis:gallery` (--check/--clean/--sync/--fix/--dry-run) |
| `app/Http/Controllers/Admin/` | Controller CRUD admin (Blade) |
| `app/Http/Controllers/Api/` | Controller API (JSON) |
| `app/Http/Controllers/Auth/` | Controller auth Breeze (Inertia) |
| `resources/views/admin/layouts/app.blade.php` | Master layout admin (sidebar + Alpine.js CDN + x-cloak) |
| `resources/js/guest/` | React SPA guest |

## Bugs noti / Pattern da evitare

- **Alpine.js CDN**: dipende da connettività esterna. Nessun fallback locale.
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

## Cross-PC sync

Quando pulli la repo su un'altra macchina (o dopo tanto tempo), esegui in ordine:

1. `composer install` — aggiorna dipendenze PHP
2. `npm install` — aggiorna dipendenze JS
3. `php artisan migrate` — applica nuove migrazioni
4. `php artisan storage:link` — ricrea il symlink storage
5. `php artisan astralis:gallery --fix` — ripara immagini galleria se necessario
6. `npx graphify update .` — ricostruisce il grafo locale
7. Verifica `git status` — working tree deve essere pulito dopo grafo
