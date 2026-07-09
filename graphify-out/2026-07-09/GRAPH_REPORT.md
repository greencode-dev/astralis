# Graph Report - astralis  (2026-07-09)

## Corpus Check
- 255 files · ~77,076 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 1025 nodes · 1539 edges · 193 communities (184 shown, 9 thin omitted)
- Extraction: 93% EXTRACTED · 7% INFERRED · 0% AMBIGUOUS · INFERRED: 106 edges (avg confidence: 0.8)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `6929f0eb`
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
- [[_COMMUNITY_HomePage.jsx|HomePage.jsx]]
- [[_COMMUNITY_Controller|Controller]]
- [[_COMMUNITY_CorpiLista.jsx|CorpiLista.jsx]]
- [[_COMMUNITY_App.jsx|App.jsx]]
- [[_COMMUNITY_ConfirmablePasswordController.php|ConfirmablePasswordController.php]]
- [[_COMMUNITY_NewPasswordController.php|NewPasswordController.php]]
- [[_COMMUNITY_PasswordResetLinkController.php|PasswordResetLinkController.php]]
- [[_COMMUNITY_RegisteredUserController.php|RegisteredUserController.php]]
- [[_COMMUNITY_.suggestNome|.suggestNome]]
- [[_COMMUNITY_auth.php|auth.php]]
- [[_COMMUNITY_EmailVerificationPromptController.php|EmailVerificationPromptController.php]]
- [[_COMMUNITY_AuthenticationTest|AuthenticationTest]]
- [[_COMMUNITY_PasswordResetTest|PasswordResetTest]]
- [[_COMMUNITY_PasswordController.php|PasswordController.php]]
- [[_COMMUNITY_AuthServiceProvider.php|AuthServiceProvider.php]]
- [[_COMMUNITY_✨ Funzionalità|✨ Funzionalità]]
- [[_COMMUNITY_Fase 9.1 — Bug critici (route, fillable, seeder)|Fase 9.1 — Bug critici (route, fillable, seeder)]]

## God Nodes (most connected - your core abstractions)
1. `CorpoCeleste` - 85 edges
2. `User` - 66 edges
3. `Controller` - 48 edges
4. `Categoria` - 38 edges
5. `TestCase` - 36 edges
6. `GalleriaCorpo` - 31 edges
7. `NasaImageServiceTest` - 31 edges
8. `Missione` - 29 edges
9. `NasaImageService` - 21 edges
10. `Risolti` - 21 edges

## Surprising Connections (you probably didn't know these)
- `CorpoCelesteCrudTest` --references--> `Categoria`  [EXTRACTED]
  tests/Feature/Admin/CorpoCelesteCrudTest.php → app/Models/Categoria.php
- `CorpoCelesteApiTest` --references--> `Categoria`  [EXTRACTED]
  tests/Feature/Api/CorpoCelesteApiTest.php → app/Models/Categoria.php
- `CorpoCelesteCrudTest` --references--> `User`  [EXTRACTED]
  tests/Feature/Admin/CorpoCelesteCrudTest.php → app/Models/User.php
- `NasaImageServiceTest` --references--> `NasaImageService`  [EXTRACTED]
  tests/Unit/NasaImageServiceTest.php → app/Services/NasaImageService.php
- `CleanupGalleryDuplicates` --references--> `NasaImageService`  [EXTRACTED]
  app/Console/Commands/CleanupGalleryDuplicates.php → app/Services/NasaImageService.php

## Import Cycles
- None detected.

## Communities (193 total, 9 thin omitted)

### Community 0 - "User"
Cohesion: 0.29
Nodes (7): 🔒 Autenticazione e Accesso, 💡 Esempi di Struttura, 📦 Gestione Entità (CRUD), 💻 Note Tecniche, Parte 1: Backoffice in Laravel, ⚙️ Requisiti Minimi, 🖼️ Upload Media

### Community 2 - "CorpoDettaglio.jsx"
Cohesion: 0.19
Nodes (7): LightboxGalleria(), formatDate(), statoColors, TimelineMissioni(), categoryGradients, categoryIcons, metriche

### Community 3 - "CorpoCeleste"
Cohesion: 0.11
Nodes (9): FetchNasaCommand, NasaImportController, RedirectResponse, View, CorpoCelesteObserver, AppServiceProvider, NasaImageService, Command (+1 more)

### Community 4 - "Missione"
Cohesion: 0.10
Nodes (8): BelongsTo, BaseTestCase, CategoriaApiTest, CuriositaApiTest, DashboardApiTest, ExampleTest, TestCase, ExampleTest

### Community 5 - "Changelog"
Cohesion: 0.10
Nodes (20): 0.1 — 02/07/2026 — `6df5099` — feat: setup iniziale Laravel + Breeze + React + documentazione, 10.0 — 06/07/2026 — `2d736af` `be1ee9b` `14ed82f` — feat: tema scuro auth pages, link Register, ridotta velocità orbite, 11.0 — 07/07/2026 — `65ed6d4` — fix: Inertia→Blade transizione, NASA import dedup, galleria cleanup e ordinamento, 1.0 — 03/07/2026 — `0a57208` — feat: database e modelli con seeders, 3.0 — 03/07/2026 — feat: API REST (10 endpoint JSON), 4.0 — 04/07/2026 — feat: React SPA guest (homepage + lista corpi celesti), 5.0 — 04/07/2026 — `0e18a60` — feat: dettaglio corpo celeste, lightbox, timeline missioni, comparatore pianeti, 8.0 — 04/07/2026 — feat: NASA Import multi-immagine in galleria + CLI fetch-nasa + metadati (+12 more)

### Community 6 - "JsonResource"
Cohesion: 0.09
Nodes (15): CorpoCelesteController, Request, CuriositaController, GalleriaController, CategoriaResource, Request, CorpoCelesteResource, Request (+7 more)

### Community 7 - "LoginRequest"
Cohesion: 0.23
Nodes (6): RedirectResponse, Request, View, ProfileController, ProfileUpdateRequest, FormRequest

### Community 8 - "devDependencies"
Cohesion: 0.06
Nodes (32): dependencies, axios, framer-motion, lucide-react, react-router-dom, @vitejs/plugin-react, yet-another-react-lightbox, devDependencies (+24 more)

### Community 10 - "Curiosita"
Cohesion: 0.23
Nodes (5): AuthenticatedSessionController, RedirectResponse, Request, View, LoginRequest

### Community 11 - "GalleriaCorpo"
Cohesion: 0.11
Nodes (8): CleanupGalleryDuplicates, GalleriaController, RedirectResponse, Request, View, GalleriaCorpo, BelongsTo, GalleriaCorpoPolicy

### Community 12 - "Astralis — Documentazione di Progetto"
Cohesion: 0.12
Nodes (16): API REST, API REST (Endpoint), Architettura, Astralis — Documentazione di Progetto, Backoffice Admin, Badge Categoria, Credenziali Admin (demo), Dettaglio Entità (+8 more)

### Community 13 - "Risolti"
Cohesion: 0.10
Nodes (21): [01] bootstrap/cache non scrivibile — 02/07/2026 (ricorrente su Windows), [02] bootstrap.js mancante — 03/07/2026, [03] GalleriaCorpoSeeder percorso con prefisso — 03/07/2026, [04] Vite config missing CSS input — 03/07/2026, [05] CorpoCeleste show view URL galleria sbagliato — 03/07/2026, [06] Sluggable config mancante — 03/07/2026, [07] Profile: Link Inertia intercetta navigazione Blade — 04/07/2026, [08] NASA Import: nomi italiani danno 0 risultati — 04/07/2026 (+13 more)

### Community 14 - "Parte 1: Backoffice in Laravel"
Cohesion: 0.29
Nodes (6): 💡 Consigli, Descrizione, 🎯 Obiettivo, Parte 2: Sito guest in React, Parte 3: Live Coding, Progetto Finale

### Community 15 - "🪐 Astralis — Catalogo di Corpi Celesti"
Cohesion: 0.19
Nodes (9): CuriositaController, RedirectResponse, Request, View, DashboardController, View, Curiosita, BelongsTo (+1 more)

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
Nodes (10): CategoriaController, RedirectResponse, Request, View, CategoriaController, DashboardController, JsonResponse, Categoria (+2 more)

### Community 23 - "config"
Cohesion: 0.29
Nodes (7): pestphp/pest-plugin, php-http/discovery, config, allow-plugins, optimize-autoloader, preferred-install, sort-packages

### Community 24 - "compilerOptions"
Cohesion: 0.29
Nodes (6): compilerOptions, baseUrl, paths, exclude, @/*, ziggy-js

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
Cohesion: 0.06
Nodes (19): MissioneController, RedirectResponse, Request, View, MissioneController, Request, Missione, BelongsToMany (+11 more)

### Community 46 - "DangerButton.jsx"
Cohesion: 0.11
Nodes (19): 12.0 — 07/07/2026 — feat: authorization admin con Policy e Gates, 12.1 — 07/07/2026 — feat: auth pages da Inertia a Blade puro, 12.2 — 08/07/2026 — `0931d17` — feat: rimossa dipendenza Inertia, 12.2 — 08/07/2026 — `f62f945` — feat: rimossa dipendenza Inertia (Fase 12.2), 12.3 — 08/07/2026 — `b17c0d9` — feat: FormRequest per validazione CorpoCeleste, 12.3 — 08/07/2026 — feat: FormRequest per validazione store/update CorpoCeleste, 12.4 — 08/07/2026 — `1869bc8` — feat: quick wins (per_page, ordinamento, .catch, nasa_id, indexes), 12.4 — 08/07/2026 — feat: quick wins — per_page, ordinamento relazioni, .catch, nasa_id, indexes (+11 more)

### Community 47 - "InputError.jsx"
Cohesion: 0.50
Nodes (3): profile.partials.delete-user-form, profile.partials.update-password-form, profile.partials.update-profile-information-form

### Community 48 - "User"
Cohesion: 0.11
Nodes (6): User, CategoriaPolicy, CorpoCelestePolicy, CuriositaPolicy, Authenticatable, ProfileTest

### Community 49 - "CorpoCeleste"
Cohesion: 0.13
Nodes (5): CorpoCeleste, BelongsToMany, HasMany, SlugOptions, CorpoCelesteApiTest

### Community 50 - "NavLink.jsx"
Cohesion: 0.16
Nodes (6): CorpoCelesteController, RedirectResponse, Request, View, StoreCorpoCelesteRequest, UpdateCorpoCelesteRequest

### Community 101 - "🪐 Astralis — Catalogo di Corpi Celesti"
Cohesion: 0.20
Nodes (10): 🚀 Accesso, 🏗️ Architettura, 🪐 Astralis — Catalogo di Corpi Celesti, 📚 Documentazione, 🗄️ Entità e Relazioni, 🛠️ Installazione, 📄 Licenza, 🎨 Palette Colori (+2 more)

### Community 102 - "Da Fare"
Cohesion: 0.20
Nodes (9): Da Fare, Fatto, Note, 🔴 P0 — Bloccante, 🟠 P1 — Utente, 🔵 P2 — Manutenzione (refactoring, test, performance), 🟣 P3 — Accessibilità, ⚪ P4 — Futuro (nice-to-have) (+1 more)

### Community 103 - "RefreshDatabase"
Cohesion: 0.18
Nodes (4): RefreshDatabase, MissioneApiTest, PasswordUpdateTest, RegistrationTest

### Community 161 - "User.php"
Cohesion: 0.17
Nodes (3): Notifiable, EmailVerificationTest, PasswordConfirmationTest

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
Cohesion: 0.24
Nodes (9): apiClient, fetchCorpoCeleste(), fetchDashboardStats(), fetchMissioni(), fetchSimili(), CorpoDettaglio(), mockGet, mockCorpo (+1 more)

### Community 170 - "GalleriaApiTest.php"
Cohesion: 0.10
Nodes (19): API di supporto, Backend (PHPUnit) — 84 test, 220 assertion, Componenti (4 file, 27 test), Configurazione, `CorpoCelesteObserver`, Esecuzione, Feature Admin — `tests/Feature/Admin/CorpoCelesteCrudTest.php` (12 test), Feature API — `tests/Feature/Api/` (8 file) (+11 more)

### Community 171 - "Comparatore.jsx"
Cohesion: 0.21
Nodes (5): fetchCorpiCelesti(), campi, Comparatore(), mockLista, pianeti

### Community 172 - "Fase 8 — NASA Import multi-immagine, Service Layer, CLI Command"
Cohesion: 0.25
Nodes (6): CategoriaBadge(), categoryColors, categoryGradients, categoryIcons, CorpoCard(), formatDistance()

### Community 176 - "HomePage.jsx"
Cohesion: 0.24
Nodes (4): planets, SolarSystem(), HomePage(), mockStats

### Community 177 - "Controller"
Cohesion: 0.36
Nodes (6): RedirectResponse, VerifyEmailController, Controller, AuthorizesRequests, EmailVerificationRequest, ValidatesRequests

### Community 178 - "CorpiLista.jsx"
Cohesion: 0.33
Nodes (5): fetchCategorie(), SearchBar(), CorpiLista(), mockCategorie, mockCorpi

### Community 179 - "App.jsx"
Cohesion: 0.36
Nodes (4): App(), Footer(), Navbar(), navLinks

### Community 180 - "ConfirmablePasswordController.php"
Cohesion: 0.43
Nodes (4): ConfirmablePasswordController, RedirectResponse, Request, View

### Community 181 - "NewPasswordController.php"
Cohesion: 0.48
Nodes (4): NewPasswordController, RedirectResponse, Request, View

### Community 182 - "PasswordResetLinkController.php"
Cohesion: 0.43
Nodes (4): PasswordResetLinkController, RedirectResponse, Request, View

### Community 183 - "RegisteredUserController.php"
Cohesion: 0.43
Nodes (4): RedirectResponse, Request, View, RegisteredUserController

### Community 185 - "auth.php"
Cohesion: 0.47
Nodes (3): EmailVerificationNotificationController, RedirectResponse, Request

### Community 186 - "EmailVerificationPromptController.php"
Cohesion: 0.53
Nodes (4): EmailVerificationPromptController, RedirectResponse, Request, View

### Community 189 - "PasswordController.php"
Cohesion: 0.60
Nodes (3): PasswordController, RedirectResponse, Request

### Community 191 - "✨ Funzionalità"
Cohesion: 0.50
Nodes (4): 🛰️ API REST, 👨‍💼 Backoffice (Laravel + Blade), 🌟 Frontend (React + Vite), ✨ Funzionalità

## Knowledge Gaps
- **221 isolated node(s):** `$schema`, `name`, `type`, `description`, `keywords` (+216 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **9 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Controller` connect `Controller` to `CorpoCeleste`, `JsonResource`, `LoginRequest`, `Curiosita`, `GalleriaCorpo`, `Missione`, `🪐 Astralis — Catalogo di Corpi Celesti`, `NavLink.jsx`, `ConfirmablePasswordController.php`, `Edit.jsx`, `NewPasswordController.php`, `PasswordResetLinkController.php`, `auth.php`, `EmailVerificationPromptController.php`, `PasswordController.php`, `RegisteredUserController.php`?**
  _High betweenness centrality (0.072) - this node is a cross-community bridge._
- **Why does `CorpoCeleste` connect `CorpoCeleste` to `CorpoCelesteCrudTest`, `CorpoCeleste`, `Missione`, `JsonResource`, `GalleriaCorpo`, `Missione`, `NasaImageServiceTest`, `🪐 Astralis — Catalogo di Corpi Celesti`, `User`, `NavLink.jsx`, `Edit.jsx`, `.suggestNome`, `CorpoCeleste.php`?**
  _High betweenness centrality (0.071) - this node is a cross-community bridge._
- **Why does `User` connect `User` to `User.php`, `CorpoCelesteCrudTest`, `Missione`, `RefreshDatabase`, `GalleriaCorpo`, `Missione`, `RegisteredUserController.php`, `CorpoCeleste.php`, `AuthenticationTest`, `PasswordResetTest`, `AuthServiceProvider.php`?**
  _High betweenness centrality (0.029) - this node is a cross-community bridge._
- **Are the 47 inferred relationships involving `CorpoCeleste` (e.g. with `.create()` and `.edit()`) actually correct?**
  _`CorpoCeleste` has 47 INFERRED edges - model-reasoned connections that need verification._
- **Are the 21 inferred relationships involving `User` (e.g. with `.store()` and `.run()`) actually correct?**
  _`User` has 21 INFERRED edges - model-reasoned connections that need verification._
- **Are the 10 inferred relationships involving `Categoria` (e.g. with `.create()` and `.edit()`) actually correct?**
  _`Categoria` has 10 INFERRED edges - model-reasoned connections that need verification._
- **What connects `$schema`, `name`, `type` to the rest of the system?**
  _221 weakly-connected nodes found - possible documentation gaps or missing edges._