# Graph Report - astralis  (2026-07-08)

## Corpus Check
- 227 files · ~64,744 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 857 nodes · 1224 edges · 156 communities
- Extraction: 95% EXTRACTED · 5% INFERRED · 0% AMBIGUOUS · INFERRED: 58 edges (avg confidence: 0.8)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `f6252d77`
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
- [[_COMMUNITY_UserFactory|UserFactory]]
- [[_COMMUNITY_Dropdown.jsx|Dropdown.jsx]]
- [[_COMMUNITY_psr-4|psr-4]]
- [[_COMMUNITY_autoload-dev|autoload-dev]]
- [[_COMMUNITY_extra|extra]]
- [[_COMMUNITY_DangerButton.jsx|DangerButton.jsx]]
- [[_COMMUNITY_InputError.jsx|InputError.jsx]]
- [[_COMMUNITY_NavLink.jsx|NavLink.jsx]]
- [[_COMMUNITY_🪐 Astralis — Catalogo di Corpi Celesti|🪐 Astralis — Catalogo di Corpi Celesti]]
- [[_COMMUNITY_Da Fare|Da Fare]]

## God Nodes (most connected - your core abstractions)
1. `User` - 61 edges
2. `Controller` - 48 edges
3. `CorpoCeleste` - 48 edges
4. `GalleriaCorpo` - 27 edges
5. `Categoria` - 25 edges
6. `Missione` - 25 edges
7. `TestCase` - 20 edges
8. `NasaImageService` - 19 edges
9. `Risolti` - 18 edges
10. `Curiosita` - 17 edges

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

## Communities (156 total, 0 thin omitted)

### Community 0 - "User"
Cohesion: 0.05
Nodes (18): User, CategoriaPolicy, MissionePolicy, Authenticatable, BaseTestCase, HasFactory, Notifiable, RefreshDatabase (+10 more)

### Community 2 - "CorpoDettaglio.jsx"
Cohesion: 0.06
Nodes (31): apiClient, fetchCategorie(), fetchCorpiCelesti(), fetchCorpoCeleste(), fetchDashboardStats(), fetchSimili(), App(), CategoriaBadge() (+23 more)

### Community 3 - "CorpoCeleste"
Cohesion: 0.40
Nodes (5): API REST, Backoffice Admin, Badge Categoria, Frontend Guest (React SPA), Palette Colori

### Community 4 - "Missione"
Cohesion: 0.07
Nodes (17): MissioneController, RedirectResponse, Request, View, MissioneController, Request, Missione, BelongsToMany (+9 more)

### Community 5 - "Changelog"
Cohesion: 0.04
Nodes (45): 0.1 — 02/07/2026 — `6df5099` — feat: setup iniziale Laravel + Breeze + React + documentazione, 10.0 — 06/07/2026 — `2d736af` `be1ee9b` `14ed82f` — feat: tema scuro auth pages, link Register, ridotta velocità orbite, 11.0 — 07/07/2026 — `65ed6d4` — fix: Inertia→Blade transizione, NASA import dedup, galleria cleanup e ordinamento, 1.0 — 03/07/2026 — `0a57208` — feat: database e modelli con seeders, 2.1 — 03/07/2026 — `070da55` — feat: admin backoffice layout, sidebar navigation e dashboard, 2.2 — 03/07/2026 — `758be4c` — feat: CRUD categorie backoffice, 2.3 — 03/07/2026 — `18a6b20` — feat: CRUD corpi celesti backoffice, 2.4 — 03/07/2026 — `6d86177` — feat: CRUD missioni backoffice (+37 more)

### Community 6 - "JsonResource"
Cohesion: 0.11
Nodes (14): CorpoCelesteController, Request, GalleriaController, CategoriaResource, Request, CorpoCelesteResource, Request, CuriositaResource (+6 more)

### Community 7 - "LoginRequest"
Cohesion: 0.09
Nodes (13): AuthenticatedSessionController, RedirectResponse, Request, View, RedirectResponse, Request, View, ProfileController (+5 more)

### Community 8 - "devDependencies"
Cohesion: 0.08
Nodes (25): dependencies, axios, framer-motion, lucide-react, react-router-dom, @vitejs/plugin-react, yet-another-react-lightbox, devDependencies (+17 more)

### Community 10 - "Curiosita"
Cohesion: 0.06
Nodes (32): ConfirmablePasswordController, RedirectResponse, Request, View, EmailVerificationNotificationController, RedirectResponse, Request, EmailVerificationPromptController (+24 more)

### Community 11 - "GalleriaCorpo"
Cohesion: 0.07
Nodes (15): CleanupGalleryDuplicates, FetchNasaCommand, GalleriaController, RedirectResponse, Request, View, NasaImportController, RedirectResponse (+7 more)

### Community 12 - "Astralis — Documentazione di Progetto"
Cohesion: 0.18
Nodes (11): API REST (Endpoint), Architettura, Astralis — Documentazione di Progetto, Credenziali Admin (demo), Dettaglio Entità, Entità e Relazioni, Guida all'installazione, Panoramica (+3 more)

### Community 13 - "Risolti"
Cohesion: 0.11
Nodes (18): [01] bootstrap/cache non scrivibile — 02/07/2026 (ricorrente su Windows), [02] bootstrap.js mancante — 03/07/2026, [03] GalleriaCorpoSeeder percorso con prefisso — 03/07/2026, [04] Vite config missing CSS input — 03/07/2026, [05] CorpoCeleste show view URL galleria sbagliato — 03/07/2026, [06] Sluggable config mancante — 03/07/2026, [07] Profile: Link Inertia intercetta navigazione Blade — 04/07/2026, [08] NASA Import: nomi italiani danno 0 risultati — 04/07/2026 (+10 more)

### Community 14 - "Parte 1: Backoffice in Laravel"
Cohesion: 0.14
Nodes (13): 🔒 Autenticazione e Accesso, 💡 Consigli, Descrizione, 💡 Esempi di Struttura, 📦 Gestione Entità (CRUD), 💻 Note Tecniche, 🎯 Obiettivo, Parte 1: Backoffice in Laravel (+5 more)

### Community 15 - "🪐 Astralis — Catalogo di Corpi Celesti"
Cohesion: 0.15
Nodes (8): CuriositaController, RedirectResponse, Request, View, Curiosita, BelongsTo, CuriositaPolicy, Model

### Community 16 - "require"
Cohesion: 0.22
Nodes (9): require, barryvdh/laravel-dompdf, intervention/image, laravel/breeze, laravel/framework, laravel/sanctum, laravel/tinker, php (+1 more)

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
Cohesion: 0.14
Nodes (11): CategoriaController, RedirectResponse, Request, View, CategoriaController, DashboardController, JsonResponse, Categoria (+3 more)

### Community 23 - "config"
Cohesion: 0.29
Nodes (7): pestphp/pest-plugin, php-http/discovery, config, allow-plugins, optimize-autoloader, preferred-install, sort-packages

### Community 24 - "compilerOptions"
Cohesion: 0.29
Nodes (6): compilerOptions, baseUrl, paths, exclude, @/*, ziggy-js

### Community 26 - "UserFactory"
Cohesion: 0.47
Nodes (3): UserFactory, Factory, static

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

### Community 46 - "DangerButton.jsx"
Cohesion: 0.13
Nodes (15): 12.0 — 07/07/2026 — feat: authorization admin con Policy e Gates, 12.1 — 07/07/2026 — feat: auth pages da Inertia a Blade puro, 12.2 — 08/07/2026 — `0931d17` — feat: rimossa dipendenza Inertia, 12.2 — 08/07/2026 — `f62f945` — feat: rimossa dipendenza Inertia (Fase 12.2), 12.3 — 08/07/2026 — `b17c0d9` — feat: FormRequest per validazione CorpoCeleste, 12.3 — 08/07/2026 — feat: FormRequest per validazione store/update CorpoCeleste, 12.4 — 08/07/2026 — `1869bc8` — feat: quick wins (per_page, ordinamento, .catch, nasa_id, indexes), 12.4 — 08/07/2026 — feat: quick wins — per_page, ordinamento relazioni, .catch, nasa_id, indexes (+7 more)

### Community 47 - "InputError.jsx"
Cohesion: 0.50
Nodes (3): profile.partials.delete-user-form, profile.partials.update-password-form, profile.partials.update-profile-information-form

### Community 50 - "NavLink.jsx"
Cohesion: 0.05
Nodes (18): CorpoCelesteController, JsonResponse, RedirectResponse, Request, View, DashboardController, View, CuriositaController (+10 more)

### Community 101 - "🪐 Astralis — Catalogo di Corpi Celesti"
Cohesion: 0.15
Nodes (13): 🚀 Accesso, 🛰️ API REST, 🏗️ Architettura, 🪐 Astralis — Catalogo di Corpi Celesti, 👨‍💼 Backoffice (Laravel + Blade), 📚 Documentazione, 🗄️ Entità e Relazioni, 🌟 Frontend (React + Vite) (+5 more)

### Community 102 - "Da Fare"
Cohesion: 0.20
Nodes (9): Da Fare, Fatto, Note, 🔴 P0 — Bloccante, 🟠 P1 — Utente, 🔵 P2 — Manutenzione (refactoring, test, performance), 🟣 P3 — Accessibilità, ⚪ P4 — Futuro (nice-to-have) (+1 more)

## Knowledge Gaps
- **186 isolated node(s):** `$schema`, `name`, `type`, `description`, `keywords` (+181 more)
  These have ≤1 connection - possible missing edges or undocumented components.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Controller` connect `Curiosita` to `Missione`, `JsonResource`, `LoginRequest`, `GalleriaCorpo`, `🪐 Astralis — Catalogo di Corpi Celesti`, `NavLink.jsx`, `Edit.jsx`?**
  _High betweenness centrality (0.087) - this node is a cross-community bridge._
- **Why does `User` connect `User` to `Missione`, `Curiosita`, `GalleriaCorpo`, `🪐 Astralis — Catalogo di Corpi Celesti`, `NavLink.jsx`?**
  _High betweenness centrality (0.057) - this node is a cross-community bridge._
- **Why does `CorpoCeleste` connect `NavLink.jsx` to `Missione`, `JsonResource`, `GalleriaCorpo`, `🪐 Astralis — Catalogo di Corpi Celesti`, `Edit.jsx`?**
  _High betweenness centrality (0.043) - this node is a cross-community bridge._
- **Are the 21 inferred relationships involving `User` (e.g. with `.store()` and `.run()`) actually correct?**
  _`User` has 21 INFERRED edges - model-reasoned connections that need verification._
- **Are the 11 inferred relationships involving `CorpoCeleste` (e.g. with `.create()` and `.edit()`) actually correct?**
  _`CorpoCeleste` has 11 INFERRED edges - model-reasoned connections that need verification._
- **Are the 3 inferred relationships involving `GalleriaCorpo` (e.g. with `.index()` and `.importForBody()`) actually correct?**
  _`GalleriaCorpo` has 3 INFERRED edges - model-reasoned connections that need verification._
- **Are the 5 inferred relationships involving `Categoria` (e.g. with `.create()` and `.edit()`) actually correct?**
  _`Categoria` has 5 INFERRED edges - model-reasoned connections that need verification._