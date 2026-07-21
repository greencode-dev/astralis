# Graph Report - astralis  (2026-07-21)

## Corpus Check
- 298 files · ~336,436 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 1660 nodes · 2650 edges · 208 communities (144 shown, 64 thin omitted)
- Extraction: 88% EXTRACTED · 12% INFERRED · 0% AMBIGUOUS · INFERRED: 311 edges (avg confidence: 0.8)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `4d3064f9`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

## Community Hubs (Navigation)
- User
- db1cb51494627765ac48414e99948e15.php
- CorpoDettaglio.jsx
- CorpoCeleste
- Missione
- Changelog
- JsonResource
- LoginRequest
- devDependencies
- Curiosita
- GalleriaCorpo
- Astralis — Documentazione di Progetto
- Risolti
- Parte 1: Backoffice in Laravel
- 🪐 Astralis — Catalogo di Corpi Celesti
- require
- composer.json
- scripts
- require-dev
- index.md
- Edit.jsx
- config
- compilerOptions
- CorpoCeleste.php
- UserFactory
- Dropdown.jsx
- psr-4
- autoload-dev
- extra
- DeleteProtectionTest
- NasaImageServiceTest
- DangerButton.jsx
- InputError.jsx
- User
- CorpoCeleste
- .index
- Dashboard.jsx
- EmailVerificationTest
- cache.php
- TextInput.jsx
- create.blade.php
- edit.blade.php
- index.blade.php
- show.blade.php
- create.blade.php
- edit.blade.php
- index.blade.php
- show.blade.php
- create.blade.php
- edit.blade.php
- index.blade.php
- dashboard.blade.php
- create.blade.php
- edit.blade.php
- index.blade.php
- app.blade.php
- create.blade.php
- edit.blade.php
- index.blade.php
- show.blade.php
- index.blade.php
- app.blade.php
- 0079552f2330bfb933d02f675d7fae1e.php
- PasswordConfirmationTest
- 🪐 Astralis — Catalogo di Corpi Celesti
- Da Fare
- RefreshDatabase
- 158a58073f7c339cee02d82d7f1f6a13.php
- 1b91c30f6655ad6258212beb875408ce.php
- extra
- DashboardController.php
- CorpoCelesteController
- package.json
- SearchAndFilterTest
- AppServiceProvider.php
- NasaImageService
- CleanupGalleryDuplicates.php
- 2026_07_20_171723_rename_nome_columns_in_corpi_celesti_table.php
- MissioneApiTest
- concurrently
- laravel-vite-plugin
- @tailwindcss/forms
- @tailwindcss/postcss
- User.php
- CorpoCelesteCrudTest
- .suggestNome
- apiClient.js
- Comparatore.jsx
- Fase 8 — NASA Import multi-immagine, Service Layer, CLI Command
- HomePage.jsx
- App.jsx
- PasswordResetLinkController.php
- ProfileController.php
- auth.php
- ✨ Funzionalità
- Quick Reference
- Astralis Blade Admin Patterns
- Backend Test Patterns
- Fase 14 — 10 Bug critici fixati
- show.blade.php
- Test — Astralis
- Quick Reference
- Astralis React SPA Patterns
- Frontend Design
- Core Concepts
- AuthenticationTest
- Deploy to Vercel
- Vercel CLI with Tokens
- Web Interface Guidelines
- Writing Guidelines
- SKILL.md
- React Native Skills
- Vercel Optimize
- SKILL.md
- SKILL.md
- SKILL.md
- SKILL.md
- SKILL.md
- SKILL.md
- SKILL.md
- SKILL.md
- SKILL.md
- SKILL.md
- SKILL.md
- SKILL.md
- SKILL.md
- CorpoCelestePolicy
- MissionePolicy
- DashboardController.php
- .missioni
- admin.partials.color-picker-html
- Task 40 — Debug generale post-ottimizzazione
- Fase 1 — Critico React Frontend (P0)
- DashboardTest
- CorpoCelesteActionsTest
- AuthenticationTest
- .corpiCelesti

## God Nodes (most connected - your core abstractions)
1. `CorpoCeleste` - 173 edges
2. `User` - 84 edges
3. `GalleriaCorpo` - 79 edges
4. `Categoria` - 71 edges
5. `Missione` - 50 edges
6. `Controller` - 49 edges
7. `TestCase` - 44 edges
8. `NasaImageServiceTest` - 34 edges
9. `Curiosita` - 31 edges
10. `Risolti` - 31 edges

## Surprising Connections (you probably didn't know these)
- `CorpoCelesteCrudTest` --references--> `Categoria`  [EXTRACTED]
  tests/Feature/Admin/CorpoCelesteCrudTest.php → app/Models/Categoria.php
- `CorpoCelesteApiTest` --references--> `Categoria`  [EXTRACTED]
  tests/Feature/Api/CorpoCelesteApiTest.php → app/Models/Categoria.php
- `CorpoCelesteActionsTest` --references--> `CorpoCeleste`  [EXTRACTED]
  tests/Feature/Admin/CorpoCelesteActionsTest.php → app/Models/CorpoCeleste.php
- `CuriositaCrudTest` --references--> `CorpoCeleste`  [EXTRACTED]
  tests/Feature/Admin/CuriositaCrudTest.php → app/Models/CorpoCeleste.php
- `GalleriaCrudTest` --references--> `CorpoCeleste`  [EXTRACTED]
  tests/Feature/Admin/GalleriaCrudTest.php → app/Models/CorpoCeleste.php

## Import Cycles
- None detected.

## Communities (208 total, 64 thin omitted)

### Community 0 - "User"
Cohesion: 0.14
Nodes (13): 🔒 Autenticazione e Accesso, 💡 Consigli, Descrizione, 💡 Esempi di Struttura, 📦 Gestione Entità (CRUD), 💻 Note Tecniche, 🎯 Obiettivo, Parte 1: Backoffice in Laravel (+5 more)

### Community 1 - "db1cb51494627765ac48414e99948e15.php"
Cohesion: 0.16
Nodes (3): CategoriaController, StoreCategoriaRequest, UpdateCategoriaRequest

### Community 2 - "CorpoDettaglio.jsx"
Cohesion: 0.12
Nodes (15): API REST, Autenticazione e Accesso, Come testare su Postman, CRUD Entità Principale, Dettaglio Singolo Elemento, Esempi Postman, Esempio 1 — Homepage (stats + in evidenza), Esempio 2 — Dettaglio Terra (+7 more)

### Community 3 - "CorpoCeleste"
Cohesion: 0.13
Nodes (3): Missione, DeleteProtectionTest, MissioneCrudTest

### Community 4 - "Missione"
Cohesion: 0.06
Nodes (35): 1. Il Progetto in Breve, 2. Fasi di Sviluppo, 3. Checklist Requisiti → Realizzato, 4. Guide Pratiche, 5. Il Nostro Stack Tecnologico, 6. Comandi Rapidi, 7. Credenziali, 8. 📌 Schede Riassuntive (+27 more)

### Community 5 - "Changelog"
Cohesion: 0.10
Nodes (20): 02/07/2026, 03/07/2026, 04/07/2026, 05/07/2026, 06/07/2026, 07/07/2026, 08/07/2026, 09/07/2026 (+12 more)

### Community 6 - "JsonResource"
Cohesion: 0.12
Nodes (12): CorpoCelesteController, CuriositaController, GalleriaController, MissioneController, NewPasswordController, CategoriaResource, CorpoCelesteResource, CuriositaResource (+4 more)

### Community 8 - "devDependencies"
Cohesion: 0.12
Nodes (17): jsdom, devDependencies, jsdom, playwright, postcss, tailwindcss, @testing-library/jest-dom, @testing-library/react (+9 more)

### Community 10 - "Curiosita"
Cohesion: 0.08
Nodes (15): NasaImportController, AuthenticatedSessionController, ConfirmablePasswordController, EmailVerificationNotificationController, EmailVerificationPromptController, PasswordController, PasswordResetLinkController, RegisteredUserController (+7 more)

### Community 11 - "GalleriaCorpo"
Cohesion: 0.07
Nodes (10): AggiornaOrdineRequest, LoginRequest, ProfileUpdateRequest, StoreCorpoCelesteRequest, StoreCuriositaRequest, StoreGalleriaCorpoRequest, StoreMissioneRequest, SuggestNomeRequest (+2 more)

### Community 12 - "Astralis — Documentazione di Progetto"
Cohesion: 0.07
Nodes (27): API REST, API REST (Endpoint), Architettura, Astralis — Documentazione di Progetto, Avvio rapido (quando il progetto è già configurato), Backoffice Admin, Badge Categoria, Bug residui — fix (17/07/2026) (+19 more)

### Community 13 - "Risolti"
Cohesion: 0.06
Nodes (31): [01] bootstrap/cache non scrivibile — 02/07/2026 (ricorrente su Windows), [02] bootstrap.js mancante — 03/07/2026, [03] GalleriaCorpoSeeder percorso con prefisso — 03/07/2026, [04] Vite config missing CSS input — 03/07/2026, [05] CorpoCeleste show view URL galleria sbagliato — 03/07/2026, [06] Sluggable config mancante — 03/07/2026, [07] Profile: Link Inertia intercetta navigazione Blade — 04/07/2026, [08] NASA Import: nomi italiani danno 0 risultati — 04/07/2026 (+23 more)

### Community 14 - "Parte 1: Backoffice in Laravel"
Cohesion: 0.13
Nodes (8): CategoriaSeeder, CorpoCelesteMissioneSeeder, CorpoCelesteSeeder, CuriositaSeeder, DatabaseSeeder, GalleriaCorpoSeeder, MissioneSeeder, Illuminate\Database\Seeder

### Community 15 - "🪐 Astralis — Catalogo di Corpi Celesti"
Cohesion: 0.12
Nodes (4): CuriositaController, UpdateCuriositaRequest, Curiosita, CuriositaCrudTest

### Community 16 - "require"
Cohesion: 0.29
Nodes (7): require, intervention/image, laravel/breeze, laravel/framework, laravel/tinker, php, spatie/laravel-sluggable

### Community 17 - "composer.json"
Cohesion: 0.14
Nodes (13): autoload-dev, psr-4, description, keywords, license, minimum-stability, name, prefer-stable (+5 more)

### Community 18 - "scripts"
Cohesion: 0.14
Nodes (14): scripts, dev, post-autoload-dump, post-update-cmd, pre-package-uninstall, test, Composer\\Config::disableProcessTimeout, Illuminate\\Foundation\\ComposerScripts::postAutoloadDump (+6 more)

### Community 19 - "require-dev"
Cohesion: 0.29
Nodes (7): require-dev, fakerphp/faker, laravel/pail, laravel/pint, mockery/mockery, nunomaduro/collision, phpunit/phpunit

### Community 20 - "index.md"
Cohesion: 0.14
Nodes (8): Bug Tracker, Collegamenti rapidi, Documentazione Astralis, Indice, Da Fare, In lavorazione, Note, Todo

### Community 21 - "Edit.jsx"
Cohesion: 0.16
Nodes (6): MissioneController, AppLayout, GuestLayout, Illuminate\View\Component, Illuminate\View\View, static

### Community 23 - "config"
Cohesion: 0.29
Nodes (7): pestphp/pest-plugin, php-http/discovery, config, allow-plugins, optimize-autoloader, preferred-install, sort-packages

### Community 24 - "compilerOptions"
Cohesion: 0.13
Nodes (15): axios, framer-motion, lucide-react, dependencies, axios, framer-motion, lucide-react, react (+7 more)

### Community 25 - "CorpoCeleste.php"
Cohesion: 0.12
Nodes (16): 02/07/2026, 03/07/2026, 04/07/2026, 07/07/2026, 08/07/2026, 09/07/2026, 10/07/2026, 11/07/2026 (+8 more)

### Community 26 - "UserFactory"
Cohesion: 0.13
Nodes (7): CategoriaFactory, CorpoCelesteFactory, CuriositaFactory, GalleriaCorpoFactory, MissioneFactory, UserFactory, Illuminate\Database\Eloquent\Factories\Factory

### Community 27 - "Dropdown.jsx"
Cohesion: 0.12
Nodes (5): UpdateMissioneRequest, ImageUploadService, Illuminate\Http\UploadedFile, Intervention\Image\ImageManager, ImageUploadServiceTest

### Community 28 - "psr-4"
Cohesion: 0.40
Nodes (5): autoload, psr-4, App\\, Database\\Factories\\, Database\\Seeders\\

### Community 47 - "InputError.jsx"
Cohesion: 0.50
Nodes (3): profile.partials.delete-user-form, profile.partials.update-password-form, profile.partials.update-profile-information-form

### Community 61 - "Dashboard.jsx"
Cohesion: 0.25
Nodes (8): post-root-package-install, setup, composer install, npm install --ignore-scripts, npm run build, @php artisan key:generate, @php artisan migrate --force, @php -r \"file_exists('.env') || copy('.env.example', '.env');\

### Community 76 - "create.blade.php"
Cohesion: 0.50
Nodes (3): admin.categorie._form, admin.partials.back-link, admin.partials.color-picker-js

### Community 77 - "edit.blade.php"
Cohesion: 0.50
Nodes (3): admin.categorie._form, admin.partials.back-link, admin.partials.color-picker-js

### Community 78 - "index.blade.php"
Cohesion: 0.40
Nodes (4): admin.partials.empty-table-row, admin.partials.index-actions, admin.partials.index-header, admin.partials.search

### Community 79 - "show.blade.php"
Cohesion: 0.50
Nodes (3): admin.partials.back-link, admin.partials.category-badge, admin.partials.show-actions

### Community 80 - "create.blade.php"
Cohesion: 0.50
Nodes (3): admin.corpi-celesti._form, admin.partials.back-link, admin.partials.nasa-suggest-js

### Community 81 - "edit.blade.php"
Cohesion: 0.50
Nodes (3): admin.corpi-celesti._form, admin.partials.back-link, admin.partials.nasa-suggest-js

### Community 82 - "index.blade.php"
Cohesion: 0.29
Nodes (6): admin.partials.category-badge, admin.partials.empty-table-row, admin.partials.in-evidenza-badge, admin.partials.index-actions, admin.partials.index-header, admin.partials.search

### Community 83 - "show.blade.php"
Cohesion: 0.29
Nodes (6): admin.partials.back-link, admin.partials.category-badge, admin.partials.in-evidenza-badge, admin.partials.mission-stato-badge, admin.partials.show-actions, admin.partials.stat-card

### Community 86 - "index.blade.php"
Cohesion: 0.40
Nodes (4): admin.partials.empty-table-row, admin.partials.index-actions, admin.partials.index-header, admin.partials.search

### Community 90 - "index.blade.php"
Cohesion: 0.50
Nodes (3): admin.partials.index-actions, admin.partials.index-header, admin.partials.search

### Community 94 - "index.blade.php"
Cohesion: 0.33
Nodes (5): admin.partials.empty-table-row, admin.partials.index-actions, admin.partials.index-header, admin.partials.mission-stato-badge, admin.partials.search

### Community 95 - "show.blade.php"
Cohesion: 0.33
Nodes (5): admin.partials.back-link, admin.partials.category-badge, admin.partials.mission-stato-badge, admin.partials.show-actions, admin.partials.stat-card

### Community 97 - "app.blade.php"
Cohesion: 0.50
Nodes (4): post-create-project-cmd, @php artisan key:generate --ansi, @php artisan migrate --graceful --ansi, @php -r \"file_exists('database/database.sqlite') || touch('database/database.sqlite');\

### Community 101 - "🪐 Astralis — Catalogo di Corpi Celesti"
Cohesion: 0.14
Nodes (14): 🚀 Accesso, 🛰️ API REST, 🏗️ Architettura, 🪐 Astralis — Catalogo di Corpi Celesti, 👨‍💼 Backoffice (Laravel + Blade), 📚 Documentazione, 🗄️ Entità e Relazioni, 🌟 Frontend (React + Vite) (+6 more)

### Community 102 - "Da Fare"
Cohesion: 0.11
Nodes (18): ALGORITHMIC PHILOSOPHY CREATION, CRAFTSMANSHIP REQUIREMENTS, CRITICAL: WHAT'S FIXED VS VARIABLE, DEDUCING THE CONCEPTUAL SEED, ESSENTIAL PRINCIPLES, HOW TO GENERATE AN ALGORITHMIC PHILOSOPHY, INTERACTIVE ARTIFACT CREATION, OUTPUT FORMAT (+10 more)

### Community 103 - "RefreshDatabase"
Cohesion: 0.21
Nodes (7): SlugOptions, SlugOptions, SlugOptions, Illuminate\Database\Eloquent\Factories\HasFactory, Illuminate\Database\Eloquent\Model, Spatie\Sluggable\HasSlug, Spatie\Sluggable\SlugOptions

### Community 108 - "extra"
Cohesion: 0.67
Nodes (3): extra, laravel, dont-discover

### Community 114 - "package.json"
Cohesion: 0.22
Nodes (8): private, $schema, scripts, build, dev, test, test:watch, type

### Community 116 - "AppServiceProvider.php"
Cohesion: 0.29
Nodes (4): AppServiceProvider, Illuminate\Support\ServiceProvider, vite, vite

### Community 118 - "CleanupGalleryDuplicates.php"
Cohesion: 0.60
Nodes (3): FetchNasaCommand, Command, Illuminate\Console\Command

### Community 119 - "2026_07_20_171723_rename_nome_columns_in_corpi_celesti_table.php"
Cohesion: 0.70
Nodes (4): down(), makeSlug(), regenerateSlugs(), up()

### Community 162 - "CorpoCelesteCrudTest"
Cohesion: 0.07
Nodes (5): JsonResponse, CorpoCeleste, CorpoCelesteApiTest, CorpoCelesteTest, ImportNasaImageTest

### Community 169 - "apiClient.js"
Cohesion: 0.05
Nodes (44): apiClient, fetchCategorie(), fetchCorpiCelesti(), fetchCorpoCeleste(), fetchDashboardStats(), fetchSimili(), Thumbnail, planets (+36 more)

### Community 171 - "Comparatore.jsx"
Cohesion: 0.11
Nodes (17): Admin Controllers, API Routes (`routes/api.php`), Artisan Commands, `astralis:gallery` (`CleanupGalleryDuplicates.php`), Astralis Laravel Backend Patterns, Authorization, Bootstrap Cache (Windows), CorpoCelesteObserver (`app/Observers/CorpoCelesteObserver.php`) (+9 more)

### Community 179 - "App.jsx"
Cohesion: 0.10
Nodes (12): App(), Comparatore, CorpiLista, CorpoDettaglio, HomePage, NotFound, ErrorBoundary, Footer() (+4 more)

### Community 182 - "PasswordResetLinkController.php"
Cohesion: 0.14
Nodes (5): User, CorpoCelestePolicy, GalleriaCorpoPolicy, Illuminate\Foundation\Auth\User, Illuminate\Notifications\Notifiable

### Community 183 - "ProfileController.php"
Cohesion: 0.05
Nodes (38): Admin palette, Bugs noti / Pattern da evitare, Comando \audit, Comando \check, Comando \commit, Comando \push, Comando \save, Comando \todo (+30 more)

### Community 184 - "auth.php"
Cohesion: 0.15
Nodes (12): Anthropic Brand Styling, Brand Guidelines, Color Application, Colors, Features, Font Management, Overview, Shape and Accent Colors (+4 more)

### Community 191 - "✨ Funzionalità"
Cohesion: 0.06
Nodes (33): API di supporto, `AuthorizationTest.php` (19 test), Backend (PHPUnit) — 264 test, 601 assertion, `CategoriaCrudTest.php` (14 test), `CleanupGalleryDuplicatesTest.php` (9 test), Componenti (4 file, 27 test), Configurazione, `CorpoCelesteActionsTest.php` (13 test) (+25 more)

### Community 195 - "Quick Reference"
Cohesion: 0.17
Nodes (11): 1. Eliminating Waterfalls (CRITICAL), 2. Bundle Size Optimization (CRITICAL), 3. Server-Side Performance (HIGH), 4. Client-Side Data Fetching (MEDIUM-HIGH), 5. Re-render Optimization (MEDIUM), 6-8. Additional Categories, How to Use, Quick Reference (+3 more)

### Community 197 - "Astralis Blade Admin Patterns"
Cohesion: 0.18
Nodes (10): Admin Palette, Alpine.js Setup, Astralis Blade Admin Patterns, CRUD Pattern, Form Admin, Master Layout (`layouts/app.blade.php`), Sidebar Pattern, Tabelle Admin (+2 more)

### Community 198 - "Backend Test Patterns"
Cohesion: 0.18
Nodes (10): Astralis Testing Patterns, Backend Test Patterns, Critical: Http::fake() in setUp, Database, Factory Pattern, Frontend Test Patterns (Vitest), NasaImageService Test Guard, Observer Skip in Testing (+2 more)

### Community 213 - "Test — Astralis"
Cohesion: 0.12
Nodes (8): Illuminate\Foundation\Testing\RefreshDatabase, Illuminate\Foundation\Testing\TestCase, CategoriaApiTest, CuriositaApiTest, GalleriaApiTest, PasswordUpdateTest, RegistrationTest, TestCase

### Community 214 - "Quick Reference"
Cohesion: 0.22
Nodes (8): 1. Component Architecture (HIGH), 2. State Management (MEDIUM), 3. Implementation Patterns (MEDIUM), 4. React 19 APIs (MEDIUM), Quick Reference, React Composition Patterns, Rule Categories, When to Apply

### Community 216 - "Astralis React SPA Patterns"
Cohesion: 0.25
Nodes (7): Animazioni (framer-motion), API Calls, Astralis React SPA Patterns, Lightbox (yet-another-react-lightbox), Routes, Struttura Directory, Tech Stack

### Community 217 - "Frontend Design"
Cohesion: 0.29
Nodes (6): Design principles, Frontend Design, Ground it in the subject, More on writing in design, Process: brainstorm, explore, plan, critique, build, critique again, Restraint and self-critique

### Community 218 - "Core Concepts"
Cohesion: 0.29
Nodes (6): Animation Triggers, Core Concepts, Critical Placement Rule, React View Transitions, Transition Types, When to Animate

### Community 221 - "Deploy to Vercel"
Cohesion: 0.40
Nodes (4): Deploy to Vercel, Output, Step 1: Gather Project State, Step 2: Choose a Deploy Method

### Community 222 - "Vercel CLI with Tokens"
Cohesion: 0.40
Nodes (4): Deploying, Step 1: Locate the Vercel Token, Step 2: Locate Project and Team, Vercel CLI with Tokens

### Community 223 - "Web Interface Guidelines"
Cohesion: 0.40
Nodes (4): Guidelines Source, How It Works, Usage, Web Interface Guidelines

### Community 224 - "Writing Guidelines"
Cohesion: 0.40
Nodes (4): Guidelines Source, How It Works, Usage, Writing Guidelines

### Community 225 - "SKILL.md"
Cohesion: 0.50
Nodes (3): How to use this skill, Keywords, When to use this skill

### Community 226 - "React Native Skills"
Cohesion: 0.50
Nodes (3): Categories by Priority, React Native Skills, When to Apply

### Community 245 - "DashboardController.php"
Cohesion: 0.13
Nodes (3): GalleriaController, GalleriaCorpo, CleanupGalleryDuplicatesTest

### Community 253 - "Task 40 — Debug generale post-ottimizzazione"
Cohesion: 0.18
Nodes (10): ImportNasaImage, CorpoCelesteObserver, Illuminate\Bus\Queueable, Illuminate\Contracts\Events\ShouldDispatchAfterCommit, Illuminate\Contracts\Queue\ShouldBeUnique, Illuminate\Contracts\Queue\ShouldQueue, Illuminate\Foundation\Bus\Dispatchable, Illuminate\Queue\InteractsWithQueue (+2 more)

## Knowledge Gaps
- **491 isolated node(s):** `$schema`, `name`, `type`, `description`, `laravel` (+486 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **64 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `CorpoCeleste` connect `CorpoCelesteCrudTest` to `CorpoCeleste`, `JsonResource`, `LoginRequest`, `Curiosita`, `Parte 1: Backoffice in Laravel`, `🪐 Astralis — Catalogo di Corpi Celesti`, `DashboardTest`, `DashboardController.php`, `Edit.jsx`, `CorpoCelesteActionsTest`, `Dropdown.jsx`, `autoload-dev`, `.corpiCelesti`, `Fase 8 — NASA Import multi-immagine, Service Layer, CLI Command`, `NasaImageServiceTest`, `User`, `CorpoCeleste`, `.index`, `PasswordResetLinkController.php`, `cache.php`, `TextInput.jsx`, `Test — Astralis`, `0079552f2330bfb933d02f675d7fae1e.php`, `RefreshDatabase`, `158a58073f7c339cee02d82d7f1f6a13.php`, `DashboardController.php`, `CorpoCelesteController`, `CorpoCelestePolicy`, `SearchAndFilterTest`, `AppServiceProvider.php`, `DashboardController.php`, `NasaImageService`, `Task 40 — Debug generale post-ottimizzazione`?**
  _High betweenness centrality (0.067) - this node is a cross-community bridge._
- **Why does `devDependencies` connect `devDependencies` to `package.json`, `AppServiceProvider.php`, `concurrently`, `laravel-vite-plugin`, `@tailwindcss/forms`, `@tailwindcss/postcss`?**
  _High betweenness centrality (0.031) - this node is a cross-community bridge._
- **Are the 114 inferred relationships involving `CorpoCeleste` (e.g. with `.create()` and `.edit()`) actually correct?**
  _`CorpoCeleste` has 114 INFERRED edges - model-reasoned connections that need verification._
- **Are the 41 inferred relationships involving `User` (e.g. with `.store()` and `.run()`) actually correct?**
  _`User` has 41 INFERRED edges - model-reasoned connections that need verification._
- **Are the 49 inferred relationships involving `GalleriaCorpo` (e.g. with `.index()` and `.importForBody()`) actually correct?**
  _`GalleriaCorpo` has 49 INFERRED edges - model-reasoned connections that need verification._
- **Are the 43 inferred relationships involving `Categoria` (e.g. with `.create()` and `.edit()`) actually correct?**
  _`Categoria` has 43 INFERRED edges - model-reasoned connections that need verification._
- **Are the 28 inferred relationships involving `Missione` (e.g. with `.formatMissionMeta()` and `.index()`) actually correct?**
  _`Missione` has 28 INFERRED edges - model-reasoned connections that need verification._