# Changelog

## Fase 0 — Setup

### 0.1 — 02/07/2026 — `6df5099` — feat: setup iniziale Laravel + Breeze + React + documentazione
- Creazione progetto Laravel v13.18.0
- Installazione Breeze con React stack
- Configurazione .env (MySQL :3307, DB: astralis)
- Generazione APP_KEY

## Fase 1 — Database e Modelli

### 1.0 — 03/07/2026 — `0a57208` — feat: database e modelli con seeders
- Installati pacchetti: spatie/laravel-sluggable, intervention/image, barryvdh/laravel-dompdf
- Creazione database MySQL `astralis`
- 6 migrations: categorie, corpi_celesti, galleria_corpi, missioni, curiosita, corpo_celeste_missione
- 5 Eloquent Models con relazioni e sluggable
- 7 seeders con dati reali (8 categorie, 18 corpi celesti, 10 missioni, 16 galleria, 18 curiosità, 17 relazioni pivot)
- Utente admin: admin@astralis.it / password

## Fase 2 — Backoffice Blade CRUD

### 2.1 — 03/07/2026 — `070da55` — feat: admin backoffice layout, sidebar navigation e dashboard
- Admin layout Blade con sidebar navigazione (tema scuro palette `#0A0A1A`, `#111128`, `#22D3EE`)
- Dashboard admin con statistiche (conteggio entità) e tabella ultimi corpi celesti
- Route `/admin` protette da auth Breeze
- Estensione tailwind.config.js con colori admin
- Fix: aggiunto `resources/js/bootstrap.js` mancante per Vite build

### 2.2 — 03/07/2026 — `758be4c` — feat: CRUD categorie backoffice
- CRUD completo Categorie (index, create, store, show, edit, update, destroy)
- Protezione eliminazione: se ci sono corpi celesti associati, bloccata con messaggio errore
- Color picker con palette rapida 10 colori nei form create/edit
- Vista show con conteggio corpi associati
- Fix: aggiunto `resources/js/bootstrap.js` mancante (bloccava build Vite)

### 2.3 — 03/07/2026 — `18a6b20` — feat: CRUD corpi celesti backoffice
- CRUD completo Corpi Celesti (index, create, store, show, edit, update, destroy)

### 2.4 — 03/07/2026 — `6d86177` — feat: CRUD missioni backoffice
- CRUD completo Missioni (index, create, store, show, edit, update, destroy)
- Upload logo con Intervention Image (resize 300px, max 1MB, supporto SVG)
- Badge stato colorato: Completata (verde), In corso (ciano), Pianificata (giallo)
- Vista show con dettagli missione + tabella corpi celesti esplorati
- Storage dedicato `storage/app/public/missioni/`

### 2.5 — 03/07/2026 — `2f8a67e` — feat: CRUD curiosità backoffice
- CRUD completo Curiosità (index, create, store, edit, update, destroy — senza show)
- Route resource con parametro `{curiositum}` (singolare latino di "curiosita")
- Vista index con tabella titolo, corpo celeste (link), descrizione, fonte
- Vista create con select corpo celeste, titolo, textarea descrizione, fonte opzionale

### 2.6 — 03/07/2026 — `99615bb` — feat: CRUD galleria backoffice
- CRUD completo Galleria (index, create, store, edit, update, destroy — senza show)
- Upload immagini con Intervention Image (resize 1200px, storage `public/galleria/`)
- Vista index a griglia con card thumbnail, didascalia, corpo celeste, crediti, ordine
- Route resource con parametro `{galleriaCorpo}`
- **Fase 2 completata** (tutti e 6 i CRUD)

## Fase 3 — API REST

### 3.0 — 03/07/2026 — feat: API REST (10 endpoint JSON)
- 5 API Resource classes: CorpoCelesteResource, CategoriaResource, MissioneResource, CuriositaResource, GalleriaCorpoResource
- 6 API Controllers: CorpoCeleste, Categoria, Missione, Curiosita, Galleria, Dashboard
- 10 endpoint JSON in `routes/api.php`
- Filtri su GET `/api/corpi-celesti`: categoria (slug), tipo, search, in_evidenza, per_page
- Filtri su GET `/api/missioni`: agenzia, stato
- Route model binding con slug su show endpoints
- Bootstrap app.php configurato per caricare api.php

## Fase 4 — React Guest Frontend

### 4.0 — 04/07/2026 — feat: React SPA guest (homepage + lista corpi celesti)
- Architettura: React standalone (separato da Inertia), comunicazione via API REST
- Entry point Vite separato `resources/js/guest/main.jsx`
- Layout guest con navbar + footer tema spazio (palette `#0A0A1A`)
- Homepage animata: hero + sistema solare (framer-motion) + corpi in evidenza
- Pagina lista corpi celesti con griglia, filtri (categoria, tipo, ricerca), paginazione
- Dipendenze: framer-motion, react-router-dom, lucide-react, axios
- Route `/` guest sostituisce Welcome Inertia

## Fase 5 — React Guest Dettaglio, Lightbox, Missioni, Comparatore

### 5.0 — 04/07/2026 — `0e18a60` — feat: dettaglio corpo celeste, lightbox, timeline missioni, comparatore pianeti
- Installato yet-another-react-lightbox per lightbox galleria immagini
- Creata pagina `CorpoDettaglio.jsx`: hero immagine, metriche scientifiche, scoperta, curiosità
- Creato componente `LightboxGalleria.jsx`: lightbox con slideshow immagini
- Creato componente `TimelineMissioni.jsx`: timeline orizzontale missioni con indicatori
- Creata pagina `Comparatore.jsx`: selezione due pianeti, tabella confronto metriche
- Route aggiunte: `/corpi-celesti/:slug` → dettaglio, `/confronta` → comparatore
- Link a comparatore dalla sidebar dettaglio (solo per categoria Pianeta)
- Corpi simili nella sezione finale del dettaglio

## Fase 6 — Fix sistema solare, NASA Import, Profilo, Documentazione

### 6.0 — 04/07/2026 — `45e01ad` — docs: Fase 6 completata
- Documentazione finale aggiornata

### 6.1 — 04/07/2026 — `fde7aaf` — fix: orbita pianeti - transformOrigin centrato sul Sole
- Primo tentativo: centrare rotazione pianeti sul Sole via CSS transformOrigin
- Risultato: orbite circolari ma etichette e dettagli ruotano con i pianeti

### 6.2 — 04/07/2026 — `a6e612a` — fix: etichette pianeti solidali e contro-rotanti nell orbita
- Secondo tentativo: contro-rotazione delle etichette per mantenerle dritte
- Parziale: etichette leggibili ma posizionamento non preciso

### 6.3 — 04/07/2026 — `4e354ea` — fix: orbita pianeti con useMotionValue/useTransform
- Riscrittura completa: orbite matematiche con seno/coseno invece di rotate CSS
- `useMotionValue` + `useTransform` per calcolare coordinate x/y in tempo reale
- Testo delle etichette sempre dritto (nessuna contro-rotazione necessaria)

### 6.4 — 04/07/2026 — `196dd15` — fix: orbite e pianeti allineati al Sole
- Wrapper coordinate comune per allineare perfettamente orbite e pianeti al centro del Sole
- Sistema solare completamente funzionante: 8 pianeti orbitano con etichette leggibili

### 6.5 — 04/07/2026 — `aed8789` — feat: NASA Import da API nel backoffice
- `NasaImportController.php` — index (tabella corpi con badge Presenza/Assente) + import (cerca su NASA API, scarica, salva)
- Vista `resources/views/admin/nasa-import/index.blade.php` — tabella con bottoni "Importa da NASA" (ciano) e "Forza import" (arancione)
- Route GET `admin/nasa-import` e POST `admin/nasa-import/{corpoCeleste}`
- Voce sidebar "NASA Import" con icona refresh
- `config/services.php` — array `nasa.key` da `.env`

### 6.6 — 04/07/2026 — `c82001d` — fix: /dashboard reindirizza a /admin, Torna al sito alla home guest
- Route `/dashboard` (Inertia) → redirect a `/admin`
- Link "Torna al sito" nella sidebar admin → `route('home')` (guest SPA)

### 6.7 — 04/07/2026 — `5ade134` — feat: link Profilo nella sidebar admin
- Aggiunto link "Profilo" nella sidebar admin sotto "Torna al sito"
- Icona User per il link profilo

### 6.8 — 04/07/2026 — `aa1ff42` — feat: pagine profilo adattate al tema scuro
- `Profile/Edit.jsx` — nuovo layout dark (sfondo `#0A0A1A`, card `#111128`), link "Torna all'admin"
- 3 partials aggiornati: label italiane (Nome, Password Attuale, Elimina Account...)
- Shared components restilizzati: TextInput (dark), InputLabel (`#B8B8D0`), PrimaryButton (cyan), SecondaryButton (dark), Modal (dark)

## Fase 7 — Bugfix Intervention Image v4, NASA Import Force All, Documentazione

### 7.0 — 04/07/2026 — fix: Profile navigation — Link Inertia → a tag per href esterno
- `resources/js/Pages/Profile/Edit.jsx`: sostituito `<Link href="/admin">` con `<a href="/admin">` per evitare che Inertia intercetti la navigazione verso pagine Blade

### 7.1 — 04/07/2026 — fix: NASA Import — mappatura nomi italiano→inglese
- `NasaImportController.php`: aggiunto array `$nameMap` (Cerere→Ceres, Terra→Earth, ecc.) per cercare nomi inglesi su NASA API

### 7.2 — 04/07/2026 — fix: SSL cURL error 60 su Windows
- `NasaImportController.php`: aggiunto `->withoutVerifying()` a tutte e 3 le chiamate HTTP verso NASA API

### 7.3 — 04/07/2026 — fix: Intervention Image v3→v4 API migration
- `CorpoCelesteController.php`: `read($file->getRealPath())` → `decodePath($file->getRealPath())`, `resize(closure)` → `scaleDown(width: 800, height: 800)`
- `MissioneController.php`: stesso fix, `scaleDown(width: 300, height: 300)`
- `GalleriaController.php`: stesso fix, `scaleDown(width: 1200, height: 1200)`
- `NasaImportController.php`: `Image::read()` → `ImageManager(new Driver())->decodeBinary()`

### 7.4 — 04/07/2026 — feat: Force Import All con Alpine.js modal
- `NasaImportController.php`: estratto metodo privato `importSingle()`, refactor `import()` per riutilizzo, aggiunto metodo `importAll()` che processa tutti i corpi celesti
- `routes/web.php`: aggiunta route POST `nasa-import/import-all`
- `resources/views/admin/nasa-import/index.blade.php`: bottone "Force Import All" (#F97316), modale conferma Alpine.js (`x-data`, `x-show`, `x-cloak`, `@click.away`), blocco `session('warning')` per risultati misti
- `resources/views/admin/layouts/app.blade.php`: aggiunto Alpine.js CDN + style `[x-cloak]`

## Fase 8 — NASA Import multi-immagine, Service Layer, CLI Command

### 8.0 — 04/07/2026 — feat: NASA Import multi-immagine in galleria + CLI fetch-nasa + metadati
- `database/migrations/...add_nasa_id_to_corpi_celesti_table.php`: nuova colonna `nasa_id` su `corpi_celesti`
- `app/Services/NasaImageService.php` — **NUOVO**: service centralizzato con metodi:
  - `searchNasa(string $query): array` — ricerca su NASA Image API
  - `getBestImageUrl(array $item): ?string` — URL preferito: canonical (~orig) > alternate > preview
  - `extractMetadata(array $item): array` — estrae nasa_id, title, photographer, description
  - `downloadAndProcess(string $url, string $filename, string $storageDir, int $width, int $height): ?string` — download, process, salva
  - `importForBody(CorpoCeleste, int $galleryCount = 5, bool $force = false, bool $updateDescription = false): array` — import completo per un corpo (1 main + N galleria)
  - `importAll(...): array` — import per tutti i corpi
- `app/Console/Commands/FetchNasaCommand.php` — **NUOVO**: `php artisan astralis:fetch-nasa` con opzioni `--force`, `--gallery=N`, `--update-description`
- `app/Http/Controllers/Admin/NasaImportController.php` — refactor: delega logica a `NasaImageService`, importSingle ora importa anche 3 immagini in galleria
- `docs/progetto.md` → `docs/documentazione.md`: rinominato, aggiornata sezione NASA Import e guida installazione
- `README.md`: aggiunto comando `astralis:fetch-nasa` nell'installazione

### 8.1 — 04/07/2026 — fix: memory limit per immagini NASA grandi + fallback URL per item
- `NasaImageService.php`: `downloadAndProcess()` ora imposta `memory_limit = 512M` durante il processing, ripristina il valore originale al termine
- `importForBody()`: per ogni item tenta canonical (~orig) → alternate (~small senza conversione) → preview (~thumb senza conversione) prima di passare all'item successivo
- Rimosso metodo `getBestImageUrl()` (dead code, convertiva ~small/~thumb in ~orig nei fallback)

## Fase 9 — Remote URLs, nome_it, WordMap, Apostrophe Fallback

### 9.0 — 04/07/2026 — feat: remote NASA URLs, nome_it, wordMap espansa, apostrophe fallback, auto-suggest
- **CorpoCeleste Model**: aggiunto campo `nome_it` (nome italiano) + accessor `getNomeDisplayAttribute()` che restituisce `nome_it ?? nome`
- **CorpoCelesteResource**: aggiunto `nome_display` nell'output JSON API
- **GalleriaCorpoResource**: aggiunto `nome_display` del corpo celeste associato
- **NasaImageService**: riscritto `searchNasa()` con fallback automatico per apostrofi (es. `Halley's Comet` → `Halleys Comet` + extra fallback "comet"). Rimosso `downloadAndProcess()`. `importForBody()` ora salva URL remoti (~medium.jpg) invece di scaricare localmente. Priorità URL: `alternate` (medium) → `preview` (thumb) → `canonical` (orig fallback)
- **CorpoCelesteController**: aggiunto metodo `suggestNome()` per auto-suggest admin (POST `/admin/corpi-celesti/suggest-nome`). Espansa `$wordMap` da 14 a ~50 termini (pianeti, lune, termini astronomici)
- **Blade views corpi-celesti**: create/edit ora con input URL invece di file upload; index/show usano URL remoti; show ha pulsante "Cerca su NASA"
- **Blade views galleria**: edit/index mostrano URL remoti
- **Blade views missioni**: edit/index con URL remoti
- **Guest components**: CorpoCard, LightboxGalleria, CorpoDettaglio usano `nome_display` con fallback a `nome`
- **Migration**: aggiunta colonna `nome_it` a `corpi_celesti` (2026_07_04_164500)
- **Test**: 25/25 PHPUnit passati (61 assertions)
- **Vite build**: 3173 moduli, zero errori
- **Documentazione**: changelog, todo, bug, documentazione, session.log, SKILL.md aggiornati

## Fase 9.1 — Bug critici (route, fillable, seeder)

### 9.1 — 05/07/2026 — `3034aba` — fix: bug critici — route() senza virgolette, nasa_id in fillable, categoria_id dinamico nel seeder
- Fix: route() senza virgolette in CorpoCelesteController
- Fix: `nasa_id` aggiunto a `$fillable` in CorpoCeleste model
- Fix: `categoria_id` dinamico nel seeder (non hard-coded)

## Fase 10 — UI/UX tema scuro, sistema solare, paginazione

### 10.0 — 06/07/2026 — `2d736af` `be1ee9b` `14ed82f` — feat: tema scuro auth pages, link Register, ridotta velocità orbite
- GuestLayout, Login, Register: tema scuro (`#0A0A1A`, `#111128`)
- "Register" link su Login page per nuovi utenti
- Velocità orbitali differenziate: pianeti lontani ruotano più lentamente
- Paginazione admin (`->paginate(20)`) su corpi-celesti, galleria, missioni, curiosità

## Fase 11 — Bugfix Inertia→Blade, NASA dedup, galleria cleanup

### 11.0 — 07/07/2026 — `65ed6d4` — fix: Inertia→Blade transizione, NASA import dedup, galleria cleanup e ordinamento
- Login/logout: `Inertia::location()` per full page reload, logout redirect a `/login`
- Tutti gli auth controller POST → `Inertia::location()` (6 controllers)
- NASA import: deduplicazione galleria (stesso `percorso` + `corpo_celeste_id`)
- NASA import: preserva `immagine_utente` (non sovrascrive se flag true)
- Colonna `immagine_utente` (boolean) su `corpi_celesti`
- Comando `astralis:gallery` con `--check`/`--clean`/`--sync`/`--fix`/`--dry-run`
- Galleria: inline ordering (pulsanti su/giù), onerror placeholder, "Imposta come principale"
- `uploadImmagine()` con try/catch, `destroy()` skip file locali per URL remoti
- Galleria cleanup: sostituite 16 immagini seed mancanti con URL NASA

## Fase 12 — Authorization (Policy + Gates)

### 12.0 — 07/07/2026 — feat: authorization admin con Policy e Gates
- Migration `2026_07_07_114500_add_is_admin_to_users_table`: colonna `is_admin` (boolean) su `users`
- `app/Providers/AuthServiceProvider.php`: registrate 5 Policy + Gate `admin` (`fn($user) => $user->is_admin`)
- Policy create: `CategoriaPolicy`, `CorpoCelestePolicy`, `MissionePolicy`, `CuriositaPolicy`, `GalleriaCorpoPolicy`
- Pattern Policy: `viewAny`/`view` → true (tutti gli autenticati), `create`/`update`/`delete` → false, `before` hook lascia passare admin
- `User.php`: `is_admin` in fillable + cast boolean
- `UserFactory.php`: default `is_admin => false`
- `DatabaseSeeder.php`: admin creato con `is_admin => true`
- `$this->authorize()` aggiunto a tutti i metodi CRUD di: CategoriaController, CorpoCelesteController, MissioneController, CuriositaController, GalleriaController
- `Gate::authorize('admin')` aggiunto a NasaImportController (index, import, importAll)
- Fix: CategoriaController.php — riparata doppia dichiarazione di classe (residuo sessione precedente)

### 12.5 — 08/07/2026 — docs: sostituito sistema priorità Alta/Media/Bassa con P0-P4 + emoji nel todo
- Nuovo sistema: 🔴P0 bloccante → 🟠P1 utente → 🔵P2 manutenzione → 🟣P3 accessibilità → ⚪P4 futuro
- Emoji per separare forma e colore: cerchi 🔴🟠🔵🟣⚪ per priorità, oggetti 🖥️🎨🧪✨ per categoria
- Sezioni P0/P1 vuote con messaggio verde 🟢 a riprova del lavoro fatto
- Tutti i task riclassificati e ordinati per priorità

### 12.4 — 08/07/2026 — feat: quick wins — per_page, ordinamento relazioni, .catch, nasa_id, indexes
- Max `per_page` (100) in Api\CorpoCelesteController — previene abuso
- Ordinamento default: `galleria()` per `ordine`, `curiosita()` per `created_at desc`
- Sostituiti 3 `.catch(() => {})` silenziosi con `console.error` in React
- Esposto `nasa_id` in CorpoCelesteResource
- Migration: index su `tipo`, `in_evidenza`, `galleria_corpi.ordine`
- Spostato task rate limiting in Bassa priorità
- 25/25 test pass, 61 assertions

### 12.3 — 08/07/2026 — feat: FormRequest per validazione store/update CorpoCeleste
- Creati `StoreCorpoCelesteRequest` e `UpdateCorpoCelesteRequest` in `app/Http/Requests/`
- Estratta validazione inline da `CorpoCelesteController` nei FormRequest
- `UpdateCorpoCelesteRequest` estende `StoreCorpoCelesteRequest` (differenza: unique su nome ignora record corrente)
- `in_evidenza` convertito a boolean in `passedValidation()`
- 25/25 test pass, 61 assertions

### 12.2 — 08/07/2026 — `f62f945` — feat: rimossa dipendenza Inertia (Fase 12.2)
- Rimosso `app/Http/Middleware/HandleInertiaRequests.php`
- Rimossi tutti i componenti JSX Inertia (13 Components, 2 Layouts, 2 Pages, app.jsx)
- Rimossa root view `resources/views/app.blade.php`
- Rimosse dipendenze composer: `inertiajs/inertia-laravel`, `tightenco/ziggy`
- Rimossa dipendenza npm: `@inertiajs/react`
- Adeguati: Controller.php, bootstrap/app.php, providers.php, routes/web.php, vite.config.js
- Adeguate viste: admin/layouts/app.blade.php, profile/edit.blade.php
- Fix: autoloader PSR-4 corrotto (laravel/pail mancante) rigenerato con `composer dump-autoload`
- Fix: permessi bootstrap/cache/ ripristinati
- 25/25 test pass, 61 assertions

### 12.2 — 08/07/2026 — `0931d17` — feat: rimossa dipendenza Inertia
- Rimosso HandleInertiaRequests middleware
- Cancellati 13 componenti JSX Inertia, Layouts, Pages
- Rimosse dipendenze composer (inertia-laravel, ziggy) e npm (@inertiajs/*)
- routes/web.php aggiornato (catch-all SPA invece di Inertia fallback)
- vite.config.js, bootstrap/app.php, providers.php aggiornati
- resources/views/admin/layouts/app.blade.php adattato per non-Inertia
- Guest pages React standalone (main.jsx, non app.jsx)

### 12.3 — 08/07/2026 — `b17c0d9` — feat: FormRequest per validazione CorpoCeleste
- Creati `StoreCorpoCelesteRequest` e `UpdateCorpoCelesteRequest` in `app/Http/Requests/`
- Validazione inline del controller ridotta da ~40 righe a 2 righe (DI)
- `in_evidenza` convertito a boolean in `passedValidation()`

### 12.4 — 08/07/2026 — `1869bc8` — feat: quick wins (per_page, ordinamento, .catch, nasa_id, indexes)
- Max `per_page=100` in API controller
- Ordinamento default per `galleria()` (ordine) e `curiosita()` (created_at desc)
- 3 `.catch(() => {})` silenziosi → `console.error`
- `nasa_id` esposto in `CorpoCelesteResource`
- Migration per indici su `tipo`, `in_evidenza`, `galleria_corpi.ordine`

### 12.5 — 08/07/2026 — docs: sistema priorità P0-P4 con emoji
- Nuovo formato `[🎨frontend][🔵P2]` nel todo.md
- Sezioni P0/P1 vuote con messaggio verde 🟢

### Wave 1 — 08/07/2026 — feat: backend P2 (WordMapService, simili ordinati)
- Sostituito `inRandomOrder()` con `orderBy('nome')->limit(4)` in `Api/CorpoCelesteController@simili`
- Creato `app/Services/WordMapService.php` con metodi `translate()` e `guessEnglishName()`
- Estratto `$wordMap` inline dal controller admin al servizio dedicato
- Rimossa duplicazione `'Anello' => 'Ring'` nel wordMap
- Rimossa private method `guessEnglishName()` dal controller

### Wave 4 — 08/07/2026 — feat: frontend P2 stili inline → Tailwind classi admin
- Convertiti stili inline color/bg/border in classi Tailwind in 21 file Blade admin
- Usata palette `admin.*` da tailwind.config.js (admin.bg, admin.card, admin.text, admin.primary, admin.secondary, admin.accent)
- Rimosse centinaia di `style=""` con classi Tailwind equivalenti
- Mantenuti inline solo: input onfocus/onblur (52 occorrenze) e colori dinamici PHP (34 occorrenze)

### Wave 3 — 08/07/2026 — feat: frontend P2 onMouseEnter/onMouseLeave → CSS :hover
- React: convertiti tutti gli inline onMouseEnter/onMouseLeave in hover: Tailwind (5 file JSX)
- Blade: convertiti tutti gli inline onmouseover/onmouseout in hover: Tailwind (19 file Blade)
- Rimossi ~270 righe di inline JavaScript event handlers, sostituiti con CSS :hover
- Pattern comuni: hover:bg-[rgba(...)], hover:text-[#...], hover:scale-105, hover:-translate-y-0.5

### Wave 2 — 08/07/2026 — feat: frontend P3 accessibilità (aria-label, role="img")
- React: aggiunto `aria-label` a pulsante reset selezioni (Comparatore)
- React: aggiunto `aria-label` a pulsanti galleria thumbnail (LightboxGalleria)
- React: aggiunto `role="img"` + `aria-label` a fallback gradient icon (CorpoCard, CorpoDettaglio)
- React: aggiunto `role="img"` + `aria-label` a fallback mission logo (TimelineMissioni)
- Blade: aggiunto `aria-label` a tutti i pulsanti/link azione tabelle admin (5 CRUD index)
- Blade: aggiunto `aria-label` a 10 color swatch categoria (create + edit)
- Blade: aggiunto `role="img"` + `aria-label` a fallback avatar/logo (corpi, missioni, nasa-import)
- Blade: fix onerror galleria — `role="img"` nel fallback "Immagine non disponibile"
- Tutti gli SVG decorativi icon-only hanno `aria-hidden="true"`

### 13.1 — 08/07/2026 — feat: Vitest per componenti React — 27 test (CategoriaBadge, CorpoCard, Lightbox, SolarSystem)
- Installati `vitest`, `jsdom`, `@testing-library/react`, `@testing-library/jest-dom`, `@testing-library/user-event`
- Configurazione `vitest.config.js` con environment jsdom + React plugin
- Fix: `LightboxGalleria.jsx` — aggiunto null guard `(immagini || [])` per prevenire crash su props null
- 27 test Vitest per 4 componenti React: CategoriaBadge (5), CorpoCard (10), LightboxGalleria (8), SolarSystem (4)
- `docs/testing.md` aggiornato con sezione Vitest e comandi npm test

### 13.0 — 08/07/2026 — feat: HasFactory su 5 modelli, 26 test NasaImageService, observer testing guard, 84 test verdi
- Aggiunto trait `HasFactory` ai 5 modelli (Categoria, CorpoCeleste, Curiosita, GalleriaCorpo, Missione) — le factory esistevano già
- Fix: `CorpoCelesteObserver::created()` skip in ambiente testing (`app()->environment('testing')`) — prima faceva chiamate HTTP reali
- Fix: `NasaImageService::searchNasa()` — riordinato `str_replace` in query stripping (`'s` prima di `'`) per correggere fallback possessivo inglese
- Fix: `NasaImageService::importForBody()` — with `immagine_utente=true` e `force=true`, ora skip completo (non crea voci galleria)
- Fix: `Missione.php` — imports su riga singola riparati (a capo mancante)
- 26 test unitari NasaImageServiceTest (searchNasa, extractMetadata, pickImageUrl, importForBody, importAll) — 63 assertion
- 9 file feature test fixati con `Http::fake()` e response structure corrette
- **84/84 test pass, 220 assertion**

### 12.1 — 07/07/2026 — feat: auth pages da Inertia a Blade puro
- Create 11 viste Blade per auth e profilo con tema scuro
- `app/View/Components/GuestLayout.php` e `AppLayout.php` per compatibilità x-*
- Rimossi `Inertia::render()` e `Inertia::location()` da 9 controller auth
- Sostituiti con `view()` e `redirect()->intended()`/`redirect()`
- Eliminati file JSX Inertia non più utilizzati (`Pages/Auth/`, `Pages/Profile/`)
- Test aggiornati (redirect `/dashboard` → `/admin`, logout `/` → `/login`)
- 25/25 test pass, 61 assertions

### 13.2 — 09/07/2026 — feat: Vitest integrazione API — 61 test (apiClient + 4 guest pages)
- `resources/js/guest/test/setup.js`: mock globale IntersectionObserver (richiesto da framer-motion `whileInView`)
- `apiClient.test.js` — 12 test per 6 funzioni di apiClient (fetchCorpiCelesti, fetchCategorie, fetchCorpoCeleste, fetchSimili, fetchMissioni, fetchDashboardStats)
- `HomePage.test.jsx` — 11 test di integrazione (hero, loading, corpi in evidenza, stats, error)
- `CorpiLista.test.jsx` — 12 test di integrazione (filtri, paginazione, ricerca, reset, error)
- `CorpoDettaglio.test.jsx` — 16 test di integrazione (metriche, galleria, curiosità, missioni, simili, errore 404)
- `Comparatore.test.jsx` — 10 test di integrazione (dropdown, pre-fill URL, tabella confronto, esclusione)

### 13.3 — 09/07/2026 — feat: Dashboard admin con grafici Chart.js

## Fase 14 — 10 Bug critici fixati

### 14.0 — 09/07/2026 — fix: 10 bug critici (Blade @endif, React null guard, 404 route, N+1, senza SSL, import duplicato)
- `curiosita/index.blade.php`: aggiunti 2 `@endif` mancanti — tabella e paginazione non erano più intrappolate nei condizionali
- `categorie/index.blade.php` e `galleria/index.blade.php`: chiuso `@if (session('success'))` prima di annidare `@if (session('error'))`, rimosso blocco errore duplicato
- `CorpoCard.jsx`: aggiunto `isNaN` guard in `formatDistance()` per prevenire "NaN km"
- `App.jsx` + nuova `NotFound.jsx`: aggiunta route catch-all `path="*"` per URL sconosciuti
- `CorpoCelesteController.php::setImageFromGallery`: aggiunto ownership check (`abort(404)` se `$galleriaCorpo->corpo_celeste_id !== $corpoCeleste->id`)
- `MissioneController.php::show`: eager loading `corpiCelesti.categoria` (N+1 fix)
- Migration `create_missioni_table`: default `stato` da `'completata'` a `'Completata'`
- `NasaImageService.php`: `withoutVerifying()` ora solo in ambiente `local`/`testing`
- `CorpoDettaglio.jsx`: unificato import duplicato `Orbit` da lucide-react (rimosso da linea 4, usato `OrbitIcon` da linea 10)
- `app/Http/Controllers/Admin/DashboardController.php`: aggiunte 3 query — corpi per categoria (withCount, filtrata count>0), corpi per tipo (groupBy), missioni per stato (3 count)
- `resources/views/admin/dashboard.blade.php`: 3 canvas Chart.js — donut corpi/categoria, barre verticali corpi/tipo, barre orizzontali missioni/stato
- Chart.js v4.4.7 caricato da CDN via `@push('scripts')` (stesso pattern Alpine.js)
- Tema dark: `Chart.defaults.color` e `borderColor` configurati per palette admin
- Accessibilità: `role="img"` + `aria-label` su ogni canvas

### 14.1 — 09/07/2026 — chore: rimossi import morti React e dipendenze inutilizzate/malposizionate
- `LightboxGalleria.jsx`: rimosso import morto `Image` da lucide-react
- `Comparatore.jsx`: rimossi import morti `Weight, Thermometer, Gauge, MapPin` da lucide-react
- `laravel/sanctum`: `composer remove` (mai usato, API pubbliche)
- `barryvdh/laravel-dompdf`: `composer remove` (mai usato, nessuna generazione PDF)
- `@tailwindcss/vite`: `npm uninstall` (incompatibile con Tailwind v3)
- `@headlessui/react`: `npm uninstall` (mai importato)
- `react`/`react-dom`: spostati da `devDependencies` a `dependencies`
- `@vitejs/plugin-react`: spostato da `dependencies` a `devDependencies`

## Fase 15 — P2/P3 manutenzione e accessibilità

### 15.0 — 09/07/2026 — feat: Categoria index pagination, Curiosita show view
- `CategoriaController::index()`: `->get()` → `->paginate(20)` + `withQueryString()`  
- Vista categorie/index: aggiunto `$categorie->links()` con paginazione Tailwind
- `CuriositaController::show()`: nuovo metodo + vista `curiosita/show.blade.php`
- Route curiosita: `except(['show'])` → `except()` (rimuove except)
- `resources/views/admin/curiosita/show.blade.php`: **NUOVA** — dettaglio curiosità con layout admin

### 15.1 — 09/07/2026 — feat: search/filter admin per Categoria, Missione, Curiosità, Galleria
- `CategoriaController::index()`: filtro `->when($request->search, fn($q, $v) => $q->where('nome','like',"%{$v}%"))`
- `MissioneController::index()`: filtri `search` (nome), `agenzia`, `stato`
- `CuriositaController::index()`: filtro `search` (titolo)
- `GalleriaController::index()`: filtro `search` (didascalia)
- Ogni vista index: barra di ricerca con stesso pattern di corpi-celesti + `withQueryString()` + bottone "Cancella filtro"

### 15.2 — 09/07/2026 — feat: SEO meta tags React (5 pagine guest)
- `HomePage.jsx`: `document.title = "Astralis — Catalogo di Corpi Celesti"`
- `CorpiLista.jsx`: `document.title = "Corpi Celesti — Astralis"`
- `CorpoDettaglio.jsx`: `document.title = "{nome} — Astralis"` (con fallback iniziale)
- `Comparatore.jsx`: `document.title = "Confronta Pianeti — Astralis"`
- `NotFound.jsx`: `document.title = "Pagina non trovata — Astralis"`
- Tutti via `useEffect` con dipendenza appropriata

### 15.3 — 09/07/2026 — feat: Error Boundary globale React
- `resources/js/guest/components/ErrorBoundary.jsx`: **NUOVO** — class component React con `componentDidCatch`
- UI fallback: tema dark, icona AlertTriangle, messaggio "Qualcosa è andato storto", link home
- `App.jsx`: wrapper `<ErrorBoundary>` intorno a `<Routes>`

### 15.4 — 09/07/2026 — feat: Admin CRUD test (4 file)
- `tests/Feature/Admin/CategoriaCrudTest.php`: **NUOVO** — 13 test (index, create, store, validazione, unique, show, edit, update, delete, protezione cancellazione con corpi associati, 403 per non-admin)
- `tests/Feature/Admin/MissioneCrudTest.php`: **NUOVO** — 12 test (CRUD completo + filtri search/agenzia/stato + 403)
- `tests/Feature/Admin/CuriositaCrudTest.php`: **NUOVO** — 11 test (CRUD completo + show + 403)
- `tests/Feature/Admin/GalleriaCrudTest.php`: **NUOVO** — 11 test (CRUD completo + 403)
- Totale: 130 test PHPUnit, 335 assertion

## Fase 1 — Critico React Frontend (P0)

### 1.0 — 10/07/2026 — `f5ed6ab` — feat: React P0 — AbortController, useFetch, ErrorBoundary, image guards, axios interceptors
- **AbortController** in HomePage, CorpiLista, CorpoDettaglio, Comparatore — impedisce `setState()` su componenti smontati
- **Custom hook `useFetch`** con useReducer in `hooks/useFetch.js` — centralizza loading/error/data/abort
- **ErrorBoundary globale** in App.jsx con pulsante retry — wrappa Navbar+Footer+Routes
- **Guard immagini rotte** — CorpoCard, CorpoDettaglio, LightboxGalleria, TimelineMissioni: onError con fallback gradiente+icona
- **Axios interceptors + retry** in apiClient.js — timeout 15s, 3 tentativi, gestione errori centralizzata

## Fase 2 — Critico Backend Laravel (P0)

### 2.0 — 10/07/2026 — `f5ed6ab` — feat: Laravel P0 — Job queue, chunk(50), rate limiting, caching NASA
- **Observer → Job Queue**: `CorpoCelesteObserver::created()` ora dispatcha `ImportNasaImage` job invece di chiamata HTTP sincrona
- **`app/Jobs/ImportNasaImage.php`**: **NUOVO** — job dispatchato alla queue `import-nasa`, 2 retry, 30s timeout
- **`NasaImportController::importAll()`**: sostituito `set_time_limit(300)` con dispatch massivo via Job Queue
- **`NasaImageService::importAll()`**: `CorpoCeleste::all()` → `CorpoCeleste::chunk(50)` — riduce memoria da migliaia a decine di modelli
- **Rate limiting API**: `throttle:60,1` su tutti e 10 gli endpoint in `routes/api.php`
- **Caching `searchNasa()`**: `Cache::remember(86400)` per risultati NASA API
- **Update routes/api.php**: raggruppate 10 route sotto middleware `throttle:60,1` + `throttle:100,1` per dashboard
