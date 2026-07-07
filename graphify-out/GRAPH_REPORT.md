# Graph Report - astralis  (2026-07-07)

## Corpus Check
- 222 files · ~65,444 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 786 nodes · 1051 edges · 154 communities (153 shown, 1 thin omitted)
- Extraction: 95% EXTRACTED · 5% INFERRED · 0% AMBIGUOUS · INFERRED: 52 edges (avg confidence: 0.8)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `741e32db`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

## Community Hubs (Navigation)
- [[_COMMUNITY_User|User]]
- [[_COMMUNITY_Controller|Controller]]
- [[_COMMUNITY_CorpoDettaglio.jsx|CorpoDettaglio.jsx]]
- [[_COMMUNITY_CorpoCeleste|CorpoCeleste]]
- [[_COMMUNITY_Missione|Missione]]
- [[_COMMUNITY_Changelog|Changelog]]
- [[_COMMUNITY_JsonResource|JsonResource]]
- [[_COMMUNITY_LoginRequest|LoginRequest]]
- [[_COMMUNITY_devDependencies|devDependencies]]
- [[_COMMUNITY_Categoria|Categoria]]
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
- [[_COMMUNITY_Future|Future]]
- [[_COMMUNITY_Edit.jsx|Edit.jsx]]
- [[_COMMUNITY_HandleInertiaRequests|HandleInertiaRequests]]
- [[_COMMUNITY_config|config]]
- [[_COMMUNITY_compilerOptions|compilerOptions]]
- [[_COMMUNITY_UserFactory|UserFactory]]
- [[_COMMUNITY_Dropdown.jsx|Dropdown.jsx]]
- [[_COMMUNITY_psr-4|psr-4]]
- [[_COMMUNITY_autoload-dev|autoload-dev]]
- [[_COMMUNITY_extra|extra]]

## God Nodes (most connected - your core abstractions)
1. `Controller` - 46 edges
2. `CorpoCeleste` - 41 edges
3. `User` - 26 edges
4. `Categoria` - 20 edges
5. `Missione` - 20 edges
6. `TestCase` - 20 edges
7. `GalleriaCorpo` - 16 edges
8. `NasaImageService` - 16 edges
9. `Curiosita` - 15 edges
10. `Risolti` - 13 edges

## Surprising Connections (you probably didn't know these)
- `CategoriaController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/CategoriaController.php → app/Http/Controllers/Controller.php
- `CorpoCelesteController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/CorpoCelesteController.php → app/Http/Controllers/Controller.php
- `CuriositaController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/CuriositaController.php → app/Http/Controllers/Controller.php
- `DashboardController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/DashboardController.php → app/Http/Controllers/Controller.php
- `GalleriaController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/GalleriaController.php → app/Http/Controllers/Controller.php

## Import Cycles
- None detected.

## Communities (154 total, 1 thin omitted)

### Community 0 - "User"
Cohesion: 0.07
Nodes (16): User, Authenticatable, BaseTestCase, HasFactory, Notifiable, RefreshDatabase, AuthenticationTest, EmailVerificationTest (+8 more)

### Community 1 - "Controller"
Cohesion: 0.06
Nodes (31): CategoriaController, ConfirmablePasswordController, RedirectResponse, Request, Response, EmailVerificationNotificationController, RedirectResponse, Request (+23 more)

### Community 2 - "CorpoDettaglio.jsx"
Cohesion: 0.06
Nodes (31): apiClient, fetchCategorie(), fetchCorpiCelesti(), fetchCorpoCeleste(), fetchDashboardStats(), fetchSimili(), App(), CategoriaBadge() (+23 more)

### Community 3 - "CorpoCeleste"
Cohesion: 0.07
Nodes (18): FetchNasaCommand, CorpoCelesteController, JsonResponse, RedirectResponse, Request, View, NasaImportController, RedirectResponse (+10 more)

### Community 4 - "Missione"
Cohesion: 0.13
Nodes (10): MissioneController, RedirectResponse, Request, View, MissioneController, Request, Missione, BelongsToMany (+2 more)

### Community 5 - "Changelog"
Cohesion: 0.05
Nodes (39): 0.1 — 02/07/2026 — `6df5099` — feat: setup iniziale Laravel + Breeze + React + documentazione, 1.0 — 03/07/2026 — `0a57208` — feat: database e modelli con seeders, 2.1 — 03/07/2026 — `070da55` — feat: admin backoffice layout, sidebar navigation e dashboard, 2.2 — 03/07/2026 — `758be4c` — feat: CRUD categorie backoffice, 2.3 — 03/07/2026 — `18a6b20` — feat: CRUD corpi celesti backoffice, 2.4 — 03/07/2026 — `6d86177` — feat: CRUD missioni backoffice, 2.5 — 03/07/2026 — `2f8a67e` — feat: CRUD curiosità backoffice, 2.6 — 03/07/2026 — `99615bb` — feat: CRUD galleria backoffice (+31 more)

### Community 6 - "JsonResource"
Cohesion: 0.12
Nodes (13): CuriositaController, GalleriaController, CategoriaResource, Request, CorpoCelesteResource, Request, CuriositaResource, Request (+5 more)

### Community 7 - "LoginRequest"
Cohesion: 0.12
Nodes (11): AuthenticatedSessionController, RedirectResponse, Request, Response, RedirectResponse, Request, Response, ProfileController (+3 more)

### Community 8 - "devDependencies"
Cohesion: 0.07
Nodes (26): dependencies, axios, framer-motion, lucide-react, react-router-dom, @vitejs/plugin-react, yet-another-react-lightbox, devDependencies (+18 more)

### Community 9 - "Categoria"
Cohesion: 0.14
Nodes (10): CategoriaController, RedirectResponse, Request, View, DashboardController, JsonResponse, Categoria, HasMany (+2 more)

### Community 10 - "Curiosita"
Cohesion: 0.07
Nodes (19): CuriositaController, RedirectResponse, Request, View, DashboardController, View, BelongsTo, BelongsToMany (+11 more)

### Community 11 - "GalleriaCorpo"
Cohesion: 0.24
Nodes (6): GalleriaController, RedirectResponse, Request, View, GalleriaCorpo, BelongsTo

### Community 12 - "Astralis — Documentazione di Progetto"
Cohesion: 0.12
Nodes (16): API REST, API REST (Endpoint), Architettura, Astralis — Documentazione di Progetto, Backoffice Admin, Badge Categoria, Credenziali Admin (demo), Dettaglio Entità (+8 more)

### Community 13 - "Risolti"
Cohesion: 0.12
Nodes (15): [01] bootstrap/cache non scrivibile — 02/07/2026 (ricorrente su Windows), [02] bootstrap.js mancante — 03/07/2026, [03] GalleriaCorpoSeeder percorso con prefisso — 03/07/2026, [04] Vite config missing CSS input — 03/07/2026, [05] CorpoCeleste show view URL galleria sbagliato — 03/07/2026, [06] Sluggable config mancante — 03/07/2026, [07] Profile: Link Inertia intercetta navigazione Blade — 04/07/2026, [08] NASA Import: nomi italiani danno 0 risultati — 04/07/2026 (+7 more)

### Community 14 - "Parte 1: Backoffice in Laravel"
Cohesion: 0.14
Nodes (13): 🔒 Autenticazione e Accesso, 💡 Consigli, Descrizione, 💡 Esempi di Struttura, 📦 Gestione Entità (CRUD), 💻 Note Tecniche, 🎯 Obiettivo, Parte 1: Backoffice in Laravel (+5 more)

### Community 15 - "🪐 Astralis — Catalogo di Corpi Celesti"
Cohesion: 0.14
Nodes (13): 🚀 Accesso, 🛰️ API REST, 🏗️ Architettura, 🪐 Astralis — Catalogo di Corpi Celesti, 👨‍💼 Backoffice (Laravel + Blade), 📚 Documentazione, 🗄️ Entità e Relazioni, 🌟 Frontend (React + Vite) (+5 more)

### Community 16 - "require"
Cohesion: 0.18
Nodes (11): require, barryvdh/laravel-dompdf, inertiajs/inertia-laravel, intervention/image, laravel/breeze, laravel/framework, laravel/sanctum, laravel/tinker (+3 more)

### Community 17 - "composer.json"
Cohesion: 0.22
Nodes (8): description, keywords, license, minimum-stability, name, prefer-stable, $schema, type

### Community 18 - "scripts"
Cohesion: 0.22
Nodes (9): scripts, dev, post-autoload-dump, post-create-project-cmd, post-root-package-install, post-update-cmd, pre-package-uninstall, setup (+1 more)

### Community 19 - "require-dev"
Cohesion: 0.25
Nodes (8): require-dev, fakerphp/faker, laravel/pail, laravel/pao, laravel/pint, mockery/mockery, nunomaduro/collision, phpunit/phpunit

### Community 20 - "Future"
Cohesion: 0.25
Nodes (7): Completate, Future, In corso, Priorità Alta, Priorità Bassa, Priorità Media, Todo

### Community 21 - "Edit.jsx"
Cohesion: 0.36
Nodes (3): DeleteUserForm(), UpdatePasswordForm(), UpdateProfileInformation()

### Community 22 - "HandleInertiaRequests"
Cohesion: 0.43
Nodes (3): HandleInertiaRequests, Request, Middleware

### Community 23 - "config"
Cohesion: 0.29
Nodes (7): pestphp/pest-plugin, php-http/discovery, config, allow-plugins, optimize-autoloader, preferred-install, sort-packages

### Community 24 - "compilerOptions"
Cohesion: 0.29
Nodes (6): compilerOptions, baseUrl, paths, exclude, @/*, ziggy-js

### Community 26 - "UserFactory"
Cohesion: 0.47
Nodes (3): UserFactory, Factory, static

### Community 28 - "psr-4"
Cohesion: 0.40
Nodes (5): autoload, psr-4, App\\, Database\\Factories\\, Database\\Seeders\\

### Community 29 - "autoload-dev"
Cohesion: 0.67
Nodes (3): autoload-dev, psr-4, Tests\\

### Community 30 - "extra"
Cohesion: 0.67
Nodes (3): extra, laravel, dont-discover

## Knowledge Gaps
- **162 isolated node(s):** `$schema`, `name`, `type`, `description`, `keywords` (+157 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **1 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Controller` connect `Controller` to `CorpoCeleste`, `Missione`, `JsonResource`, `LoginRequest`, `Categoria`, `Curiosita`, `GalleriaCorpo`?**
  _High betweenness centrality (0.115) - this node is a cross-community bridge._
- **Why does `CorpoCeleste` connect `CorpoCeleste` to `Categoria`, `Curiosita`, `GalleriaCorpo`?**
  _High betweenness centrality (0.027) - this node is a cross-community bridge._
- **Why does `User` connect `User` to `Controller`, `Curiosita`?**
  _High betweenness centrality (0.022) - this node is a cross-community bridge._
- **Are the 11 inferred relationships involving `CorpoCeleste` (e.g. with `.create()` and `.edit()`) actually correct?**
  _`CorpoCeleste` has 11 INFERRED edges - model-reasoned connections that need verification._
- **Are the 21 inferred relationships involving `User` (e.g. with `.store()` and `.run()`) actually correct?**
  _`User` has 21 INFERRED edges - model-reasoned connections that need verification._
- **Are the 5 inferred relationships involving `Categoria` (e.g. with `.create()` and `.edit()`) actually correct?**
  _`Categoria` has 5 INFERRED edges - model-reasoned connections that need verification._
- **Are the 4 inferred relationships involving `Missione` (e.g. with `.index()` and `.stats()`) actually correct?**
  _`Missione` has 4 INFERRED edges - model-reasoned connections that need verification._