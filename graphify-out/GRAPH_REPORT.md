# Graph Report - astralis  (2026-07-10)

## Corpus Check
- 302 files · ~89,876 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 1236 nodes · 1845 edges · 209 communities (191 shown, 18 thin omitted)
- Extraction: 93% EXTRACTED · 7% INFERRED · 0% AMBIGUOUS · INFERRED: 136 edges (avg confidence: 0.8)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `f5ed6ab0`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

## Community Hubs (Navigation)
- [[_COMMUNITY_User|User]]
- [[_COMMUNITY_CorpoDettaglio.jsx|CorpoDettaglio.jsx]]
- [[_COMMUNITY_CorpoCeleste|CorpoCeleste]]
- [[_COMMUNITY_Missione|Missione]]
- [[_COMMUNITY_Changelog|Changelog]]
- [[_COMMUNITY_JsonResource|JsonResource]]
- [[_COMMUNITY_LoginRequest|LoginRequest]]
- [[_COMMUNITY_devDependencies|devDependencies]]
- [[_COMMUNITY_Curiosita|Curiosita]]
- [[_COMMUNITY_GalleriaCorpo|GalleriaCorpo]]
- [[_COMMUNITY_Astralis — Documentazione di Progetto|Astralis — Documentazione di Progetto]]
- [[_COMMUNITY_Risolti|Risolti]]
- [[_COMMUNITY_Parte 1 Backoffice in Laravel|Parte 1: Backoffice in Laravel]]
- [[_COMMUNITY_🪐 Astralis — Catalogo di Corpi Celesti|🪐 Astralis — Catalogo di Corpi Celesti]]
- [[_COMMUNITY_require|require]]
- [[_COMMUNITY_composer.json|composer.json]]
- [[_COMMUNITY_scripts|scripts]]
- [[_COMMUNITY_require-dev|require-dev]]
- [[_COMMUNITY_index|index.md]]
- [[_COMMUNITY_Edit.jsx|Edit.jsx]]
- [[_COMMUNITY_config|config]]
- [[_COMMUNITY_compilerOptions|compilerOptions]]
- [[_COMMUNITY_CorpoCeleste.php|CorpoCeleste.php]]
- [[_COMMUNITY_UserFactory|UserFactory]]
- [[_COMMUNITY_Dropdown.jsx|Dropdown.jsx]]
- [[_COMMUNITY_psr-4|psr-4]]
- [[_COMMUNITY_autoload-dev|autoload-dev]]
- [[_COMMUNITY_extra|extra]]
- [[_COMMUNITY_Missione|Missione]]
- [[_COMMUNITY_NasaImageServiceTest|NasaImageServiceTest]]
- [[_COMMUNITY_DangerButton.jsx|DangerButton.jsx]]
- [[_COMMUNITY_InputError.jsx|InputError.jsx]]
- [[_COMMUNITY_User|User]]
- [[_COMMUNITY_CorpoCeleste|CorpoCeleste]]
- [[_COMMUNITY_NavLink.jsx|NavLink.jsx]]
- [[_COMMUNITY_cache.php|cache.php]]
- [[_COMMUNITY_create.blade.php|create.blade.php]]
- [[_COMMUNITY_edit.blade.php|edit.blade.php]]
- [[_COMMUNITY_index.blade.php|index.blade.php]]
- [[_COMMUNITY_create.blade.php|create.blade.php]]
- [[_COMMUNITY_edit.blade.php|edit.blade.php]]
- [[_COMMUNITY_index.blade.php|index.blade.php]]
- [[_COMMUNITY_index.blade.php|index.blade.php]]
- [[_COMMUNITY_index.blade.php|index.blade.php]]
- [[_COMMUNITY_index.blade.php|index.blade.php]]
- [[_COMMUNITY_🪐 Astralis — Catalogo di Corpi Celesti|🪐 Astralis — Catalogo di Corpi Celesti]]
- [[_COMMUNITY_Da Fare|Da Fare]]
- [[_COMMUNITY_RefreshDatabase|RefreshDatabase]]
- [[_COMMUNITY_User.php|User.php]]
- [[_COMMUNITY_CorpoCelesteCrudTest|CorpoCelesteCrudTest]]
- [[_COMMUNITY_Fase 6 — Fix sistema solare, NASA Import, Profilo, Documentazione|Fase 6 — Fix sistema solare, NASA Import, Profilo, Documentazione]]
- [[_COMMUNITY_Fase 2 — Backoffice Blade CRUD|Fase 2 — Backoffice Blade CRUD]]
- [[_COMMUNITY_.suggestNome|.suggestNome]]
- [[_COMMUNITY_Fase 7 — Bugfix Intervention Image v4, NASA Import Force All, Documentazione|Fase 7 — Bugfix Intervention Image v4, NASA Import Force All, Documentazione]]
- [[_COMMUNITY_apiClient.js|apiClient.js]]
- [[_COMMUNITY_GalleriaApiTest.php|GalleriaApiTest.php]]
- [[_COMMUNITY_Comparatore.jsx|Comparatore.jsx]]
- [[_COMMUNITY_Fase 8 — NASA Import multi-immagine, Service Layer, CLI Command|Fase 8 — NASA Import multi-immagine, Service Layer, CLI Command]]
- [[_COMMUNITY_App.jsx|App.jsx]]
- [[_COMMUNITY_PasswordResetLinkController.php|PasswordResetLinkController.php]]
- [[_COMMUNITY_ProfileController.php|ProfileController.php]]
- [[_COMMUNITY_auth.php|auth.php]]
- [[_COMMUNITY_✨ Funzionalità|✨ Funzionalità]]
- [[_COMMUNITY_Fase 15 — P2P3 manutenzione e accessibilità|Fase 15 — P2/P3 manutenzione e accessibilità]]
- [[_COMMUNITY_Fase 14 — 10 Bug critici fixati|Fase 14 — 10 Bug critici fixati]]

## God Nodes (most connected - your core abstractions)
1. `CorpoCeleste` - 95 edges
2. `User` - 87 edges
3. `Controller` - 48 edges
4. `Categoria` - 47 edges
5. `TestCase` - 46 edges
6. `Missione` - 37 edges
7. `GalleriaCorpo` - 35 edges
8. `NasaImageServiceTest` - 31 edges
9. `Curiosita` - 25 edges
10. `Risolti` - 21 edges

## Surprising Connections (you probably didn't know these)
- `CorpoCelesteCrudTest` --references--> `Categoria`  [EXTRACTED]
  tests/Feature/Admin/CorpoCelesteCrudTest.php → app/Models/Categoria.php
- `CorpoCelesteApiTest` --references--> `Categoria`  [EXTRACTED]
  tests/Feature/Api/CorpoCelesteApiTest.php → app/Models/Categoria.php
- `CuriositaCrudTest` --references--> `CorpoCeleste`  [EXTRACTED]
  tests/Feature/Admin/CuriositaCrudTest.php → app/Models/CorpoCeleste.php
- `GalleriaCrudTest` --references--> `CorpoCeleste`  [EXTRACTED]
  tests/Feature/Admin/GalleriaCrudTest.php → app/Models/CorpoCeleste.php
- `AdminTestCase` --references--> `User`  [EXTRACTED]
  tests/Feature/Admin/AdminTestCase.php → app/Models/User.php

## Import Cycles
- None detected.

## Communities (209 total, 18 thin omitted)

### Community 0 - "User"
Cohesion: 0.14
Nodes (13): 🔒 Autenticazione e Accesso, 💡 Consigli, Descrizione, 💡 Esempi di Struttura, 📦 Gestione Entità (CRUD), 💻 Note Tecniche, 🎯 Obiettivo, Parte 1: Backoffice in Laravel (+5 more)

### Community 2 - "CorpoDettaglio.jsx"
Cohesion: 0.23
Nodes (9): NasaImportController, RedirectResponse, View, ImportNasaImage, Dispatchable, InteractsWithQueue, Queueable, SerializesModels (+1 more)

### Community 3 - "CorpoCeleste"
Cohesion: 0.09
Nodes (9): MissioneController, RedirectResponse, Request, View, StoreMissioneRequest, UpdateMissioneRequest, Missione, SlugOptions (+1 more)

### Community 4 - "Missione"
Cohesion: 0.06
Nodes (34): 1. Il Progetto in Breve, 2. Fasi di Sviluppo, 3. Checklist Requisiti → Realizzato, 4. Guide Pratiche, 5. Il Nostro Stack Tecnologico, 6. Comandi Rapidi, 7. Credenziali, 8. 📌 Schede Riassuntive (+26 more)

### Community 5 - "Changelog"
Cohesion: 0.08
Nodes (24): 0.1 — 02/07/2026 — `6df5099` — feat: setup iniziale Laravel + Breeze + React + documentazione, 10.0 — 06/07/2026 — `2d736af` `be1ee9b` `14ed82f` — feat: tema scuro auth pages, link Register, ridotta velocità orbite, 1.0 — 03/07/2026 — `0a57208` — feat: database e modelli con seeders, 1.0 — 10/07/2026 — `f5ed6ab` — feat: React P0 — AbortController, useFetch, ErrorBoundary, image guards, axios interceptors, 2.0 — 10/07/2026 — `f5ed6ab` — feat: Laravel P0 — Job queue, chunk(50), rate limiting, caching NASA, 3.0 — 03/07/2026 — feat: API REST (10 endpoint JSON), 4.0 — 04/07/2026 — feat: React SPA guest (homepage + lista corpi celesti), 5.0 — 04/07/2026 — `0e18a60` — feat: dettaglio corpo celeste, lightbox, timeline missioni, comparatore pianeti (+16 more)

### Community 6 - "JsonResource"
Cohesion: 0.07
Nodes (21): CorpoCelesteController, Request, CuriositaController, Request, DashboardController, JsonResponse, GalleriaController, Request (+13 more)

### Community 7 - "LoginRequest"
Cohesion: 0.20
Nodes (4): CorpoCelesteObserver, AppServiceProvider, AuthServiceProvider, ServiceProvider

### Community 8 - "devDependencies"
Cohesion: 0.06
Nodes (30): dependencies, axios, framer-motion, lucide-react, react, react-dom, react-router-dom, yet-another-react-lightbox (+22 more)

### Community 10 - "Curiosita"
Cohesion: 0.05
Nodes (37): AuthenticatedSessionController, RedirectResponse, Request, View, ConfirmablePasswordController, RedirectResponse, Request, View (+29 more)

### Community 11 - "GalleriaCorpo"
Cohesion: 0.08
Nodes (11): CleanupGalleryDuplicates, FetchNasaCommand, GalleriaController, RedirectResponse, Request, View, GalleriaCorpo, BelongsTo (+3 more)

### Community 12 - "Astralis — Documentazione di Progetto"
Cohesion: 0.18
Nodes (11): API REST (Endpoint), Architettura, Astralis — Documentazione di Progetto, Credenziali Admin (demo), Dettaglio Entità, Entità e Relazioni, Guida all'installazione, Panoramica (+3 more)

### Community 13 - "Risolti"
Cohesion: 0.10
Nodes (21): [01] bootstrap/cache non scrivibile — 02/07/2026 (ricorrente su Windows), [02] bootstrap.js mancante — 03/07/2026, [03] GalleriaCorpoSeeder percorso con prefisso — 03/07/2026, [04] Vite config missing CSS input — 03/07/2026, [05] CorpoCeleste show view URL galleria sbagliato — 03/07/2026, [06] Sluggable config mancante — 03/07/2026, [07] Profile: Link Inertia intercetta navigazione Blade — 04/07/2026, [08] NASA Import: nomi italiani danno 0 risultati — 04/07/2026 (+13 more)

### Community 14 - "Parte 1: Backoffice in Laravel"
Cohesion: 0.12
Nodes (8): CategoriaSeeder, CorpoCelesteMissioneSeeder, CorpoCelesteSeeder, CuriositaSeeder, DatabaseSeeder, GalleriaCorpoSeeder, MissioneSeeder, Seeder

### Community 15 - "🪐 Astralis — Catalogo di Corpi Celesti"
Cohesion: 0.09
Nodes (10): CuriositaController, RedirectResponse, Request, View, DashboardController, View, StoreCuriositaRequest, UpdateCuriositaRequest (+2 more)

### Community 16 - "require"
Cohesion: 0.29
Nodes (7): require, intervention/image, laravel/breeze, laravel/framework, laravel/tinker, php, spatie/laravel-sluggable

### Community 17 - "composer.json"
Cohesion: 0.22
Nodes (8): description, keywords, license, minimum-stability, name, prefer-stable, $schema, type

### Community 18 - "scripts"
Cohesion: 0.22
Nodes (9): scripts, dev, post-autoload-dump, post-create-project-cmd, post-root-package-install, post-update-cmd, pre-package-uninstall, setup (+1 more)

### Community 19 - "require-dev"
Cohesion: 0.25
Nodes (8): require-dev, fakerphp/faker, laravel/pail, laravel/pao, laravel/pint, mockery/mockery, nunomaduro/collision, phpunit/phpunit

### Community 20 - "index.md"
Cohesion: 0.22
Nodes (4): Bug Tracker, Collegamenti rapidi, Documentazione Astralis, Indice

### Community 21 - "Edit.jsx"
Cohesion: 0.08
Nodes (11): CategoriaController, RedirectResponse, Request, View, CategoriaController, StoreCategoriaRequest, UpdateCategoriaRequest, Categoria (+3 more)

### Community 23 - "config"
Cohesion: 0.29
Nodes (7): pestphp/pest-plugin, php-http/discovery, config, allow-plugins, optimize-autoloader, preferred-install, sort-packages

### Community 24 - "compilerOptions"
Cohesion: 0.29
Nodes (6): compilerOptions, baseUrl, paths, exclude, @/*, ziggy-js

### Community 25 - "CorpoCeleste.php"
Cohesion: 0.22
Nodes (9): Da Fare (Piano di Ottimizzazione), Fase 10 — UI/UX & Writing Review (P4), Fase 3 — Alto React Frontend (P1), Fase 4 — Alto Backend Laravel (P1), Fase 5 — Alto Admin Blade (P1), Fase 6 — Medio React Frontend (P2), Fase 7 — Medio Backend Laravel (P2), Fase 8 — Medio Admin Blade (P2) (+1 more)

### Community 26 - "UserFactory"
Cohesion: 0.13
Nodes (8): CategoriaFactory, CorpoCelesteFactory, CuriositaFactory, GalleriaCorpoFactory, MissioneFactory, UserFactory, Factory, static

### Community 27 - "Dropdown.jsx"
Cohesion: 0.33
Nodes (5): AppLayout, View, GuestLayout, View, Component

### Community 28 - "psr-4"
Cohesion: 0.40
Nodes (5): autoload, psr-4, App\\, Database\\Factories\\, Database\\Seeders\\

### Community 29 - "autoload-dev"
Cohesion: 0.67
Nodes (3): autoload-dev, psr-4, Tests\\

### Community 30 - "extra"
Cohesion: 0.67
Nodes (3): extra, laravel, dont-discover

### Community 44 - "Missione"
Cohesion: 0.08
Nodes (11): BaseTestCase, RefreshDatabase, AdminTestCase, CategoriaApiTest, GalleriaApiTest, MissioneApiTest, PasswordUpdateTest, RegistrationTest (+3 more)

### Community 46 - "DangerButton.jsx"
Cohesion: 0.11
Nodes (19): 12.0 — 07/07/2026 — feat: authorization admin con Policy e Gates, 12.1 — 07/07/2026 — feat: auth pages da Inertia a Blade puro, 12.2 — 08/07/2026 — `0931d17` — feat: rimossa dipendenza Inertia, 12.2 — 08/07/2026 — `f62f945` — feat: rimossa dipendenza Inertia (Fase 12.2), 12.3 — 08/07/2026 — `b17c0d9` — feat: FormRequest per validazione CorpoCeleste, 12.3 — 08/07/2026 — feat: FormRequest per validazione store/update CorpoCeleste, 12.4 — 08/07/2026 — `1869bc8` — feat: quick wins (per_page, ordinamento, .catch, nasa_id, indexes), 12.4 — 08/07/2026 — feat: quick wins — per_page, ordinamento relazioni, .catch, nasa_id, indexes (+11 more)

### Community 47 - "InputError.jsx"
Cohesion: 0.50
Nodes (3): profile.partials.delete-user-form, profile.partials.update-password-form, profile.partials.update-profile-information-form

### Community 48 - "User"
Cohesion: 0.07
Nodes (8): User, CategoriaPolicy, CorpoCelestePolicy, CuriositaPolicy, GalleriaCorpoPolicy, MissionePolicy, Authenticatable, ProfileTest

### Community 49 - "CorpoCeleste"
Cohesion: 0.12
Nodes (3): CorpoCeleste, BelongsTo, CorpoCelesteApiTest

### Community 50 - "NavLink.jsx"
Cohesion: 0.06
Nodes (18): CorpoCelesteController, JsonResponse, RedirectResponse, Request, View, RedirectResponse, Request, View (+10 more)

### Community 101 - "🪐 Astralis — Catalogo di Corpi Celesti"
Cohesion: 0.14
Nodes (14): 🚀 Accesso, 🛰️ API REST, 🏗️ Architettura, 🪐 Astralis — Catalogo di Corpi Celesti, 👨‍💼 Backoffice (Laravel + Blade), 📚 Documentazione, 🗄️ Entità e Relazioni, 🌟 Frontend (React + Vite) (+6 more)

### Community 102 - "Da Fare"
Cohesion: 0.40
Nodes (4): Fatto, Note, Post-commit 2026-07-10 — Fase 1 (React P0) + Fase 2 (Laravel P0) completate, Todo

### Community 103 - "RefreshDatabase"
Cohesion: 0.10
Nodes (7): BelongsTo, BelongsToMany, HasFactory, HasSlug, Model, CuriositaApiTest, DashboardApiTest

### Community 161 - "User.php"
Cohesion: 0.14
Nodes (3): Notifiable, AuthenticationTest, PasswordConfirmationTest

### Community 163 - "Fase 6 — Fix sistema solare, NASA Import, Profilo, Documentazione"
Cohesion: 0.20
Nodes (10): 6.0 — 04/07/2026 — `45e01ad` — docs: Fase 6 completata, 6.1 — 04/07/2026 — `fde7aaf` — fix: orbita pianeti - transformOrigin centrato sul Sole, 6.2 — 04/07/2026 — `a6e612a` — fix: etichette pianeti solidali e contro-rotanti nell orbita, 6.3 — 04/07/2026 — `4e354ea` — fix: orbita pianeti con useMotionValue/useTransform, 6.4 — 04/07/2026 — `196dd15` — fix: orbite e pianeti allineati al Sole, 6.5 — 04/07/2026 — `aed8789` — feat: NASA Import da API nel backoffice, 6.6 — 04/07/2026 — `c82001d` — fix: /dashboard reindirizza a /admin, Torna al sito alla home guest, 6.7 — 04/07/2026 — `5ade134` — feat: link Profilo nella sidebar admin (+2 more)

### Community 164 - "Fase 2 — Backoffice Blade CRUD"
Cohesion: 0.29
Nodes (7): 2.1 — 03/07/2026 — `070da55` — feat: admin backoffice layout, sidebar navigation e dashboard, 2.2 — 03/07/2026 — `758be4c` — feat: CRUD categorie backoffice, 2.3 — 03/07/2026 — `18a6b20` — feat: CRUD corpi celesti backoffice, 2.4 — 03/07/2026 — `6d86177` — feat: CRUD missioni backoffice, 2.5 — 03/07/2026 — `2f8a67e` — feat: CRUD curiosità backoffice, 2.6 — 03/07/2026 — `99615bb` — feat: CRUD galleria backoffice, Fase 2 — Backoffice Blade CRUD

### Community 167 - "Fase 7 — Bugfix Intervention Image v4, NASA Import Force All, Documentazione"
Cohesion: 0.33
Nodes (6): 7.0 — 04/07/2026 — fix: Profile navigation — Link Inertia → a tag per href esterno, 7.1 — 04/07/2026 — fix: NASA Import — mappatura nomi italiano→inglese, 7.2 — 04/07/2026 — fix: SSL cURL error 60 su Windows, 7.3 — 04/07/2026 — fix: Intervention Image v3→v4 API migration, 7.4 — 04/07/2026 — feat: Force Import All con Alpine.js modal, Fase 7 — Bugfix Intervention Image v4, NASA Import Force All, Documentazione

### Community 169 - "apiClient.js"
Cohesion: 0.06
Nodes (37): apiClient, fetchCategorie(), fetchCorpiCelesti(), fetchCorpoCeleste(), fetchDashboardStats(), fetchMissioni(), fetchSimili(), LightboxGalleria() (+29 more)

### Community 179 - "App.jsx"
Cohesion: 0.12
Nodes (10): App(), Comparatore, CorpiLista, CorpoDettaglio, HomePage, NotFound, ErrorBoundary, Footer() (+2 more)

### Community 183 - "ProfileController.php"
Cohesion: 0.40
Nodes (5): API REST, Backoffice Admin, Badge Categoria, Frontend Guest (React SPA), Palette Colori

### Community 191 - "✨ Funzionalità"
Cohesion: 0.08
Nodes (24): API di supporto, Backend (PHPUnit) — 130 test, 335 assertion, `CategoriaCrudTest.php` (14 test), Componenti (4 file, 27 test), Configurazione, `CorpoCelesteCrudTest.php` (13 test), `CorpoCelesteObserver`, `CuriositaCrudTest.php` (10 test) (+16 more)

### Community 193 - "Fase 15 — P2/P3 manutenzione e accessibilità"
Cohesion: 0.33
Nodes (6): 15.0 — 09/07/2026 — feat: Categoria index pagination, Curiosita show view, 15.1 — 09/07/2026 — feat: search/filter admin per Categoria, Missione, Curiosità, Galleria, 15.2 — 09/07/2026 — feat: SEO meta tags React (5 pagine guest), 15.3 — 09/07/2026 — feat: Error Boundary globale React, 15.4 — 09/07/2026 — feat: Admin CRUD test (4 file), Fase 15 — P2/P3 manutenzione e accessibilità

### Community 199 - "Fase 14 — 10 Bug critici fixati"
Cohesion: 0.67
Nodes (3): 14.0 — 09/07/2026 — fix: 10 bug critici (Blade @endif, React null guard, 404 route, N+1, senza SSL, import duplicato), 14.1 — 09/07/2026 — chore: rimossi import morti React e dipendenze inutilizzate/malposizionate, Fase 14 — 10 Bug critici fixati

## Knowledge Gaps
- **277 isolated node(s):** `$schema`, `name`, `type`, `description`, `keywords` (+272 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **18 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Controller` connect `Curiosita` to `CorpoDettaglio.jsx`, `CorpoCeleste`, `JsonResource`, `GalleriaCorpo`, `🪐 Astralis — Catalogo di Corpi Celesti`, `NavLink.jsx`, `Edit.jsx`?**
  _High betweenness centrality (0.066) - this node is a cross-community bridge._
- **Why does `CorpoCeleste` connect `CorpoCeleste` to `cache.php`, `CorpoDettaglio.jsx`, `CorpoCelesteCrudTest`, `JsonResource`, `RefreshDatabase`, `LoginRequest`, `GalleriaApiTest.php`, `GalleriaCorpo`, `Comparatore.jsx`, `Missione`, `Parte 1: Backoffice in Laravel`, `🪐 Astralis — Catalogo di Corpi Celesti`, `User`, `NasaImageServiceTest`, `NavLink.jsx`?**
  _High betweenness centrality (0.054) - this node is a cross-community bridge._
- **Why does `User` connect `User` to `User.php`, `CorpoCelesteCrudTest`, `CorpoCeleste`, `RefreshDatabase`, `Curiosita`, `GalleriaCorpo`, `Missione`, `Parte 1: Backoffice in Laravel`, `🪐 Astralis — Catalogo di Corpi Celesti`, `Edit.jsx`, `PasswordResetLinkController.php`, `auth.php`?**
  _High betweenness centrality (0.036) - this node is a cross-community bridge._
- **Are the 47 inferred relationships involving `CorpoCeleste` (e.g. with `.create()` and `.edit()`) actually correct?**
  _`CorpoCeleste` has 47 INFERRED edges - model-reasoned connections that need verification._
- **Are the 21 inferred relationships involving `User` (e.g. with `.store()` and `.run()`) actually correct?**
  _`User` has 21 INFERRED edges - model-reasoned connections that need verification._
- **Are the 19 inferred relationships involving `Categoria` (e.g. with `.create()` and `.edit()`) actually correct?**
  _`Categoria` has 19 INFERRED edges - model-reasoned connections that need verification._
- **What connects `$schema`, `name`, `type` to the rest of the system?**
  _277 weakly-connected nodes found - possible documentation gaps or missing edges._