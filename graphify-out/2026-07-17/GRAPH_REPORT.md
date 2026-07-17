# Graph Report - astralis  (2026-07-17)

## Corpus Check
- 292 files · ~97,635 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 1647 nodes · 2587 edges · 212 communities (151 shown, 61 thin omitted)
- Extraction: 89% EXTRACTED · 11% INFERRED · 0% AMBIGUOUS · INFERRED: 286 edges (avg confidence: 0.8)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `0366f2bc`
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
- Missione
- NasaImageServiceTest
- DangerButton.jsx
- InputError.jsx
- User
- CorpoCeleste
- NavLink.jsx
- Dashboard.jsx
- Welcome.jsx
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
- 0102e8bc3944f025b8dec238ff035f52.php
- 🪐 Astralis — Catalogo di Corpi Celesti
- Da Fare
- RefreshDatabase
- 158a58073f7c339cee02d82d7f1f6a13.php
- 1b91c30f6655ad6258212beb875408ce.php
- 1cca292344e066f15fdb501df69ab831.php
- 1feba0814ee0d999cc60b850dce00bf0.php
- 2681c8cd96b6e7598bf59e82d1640806.php
- 2f0b2672335a9102d30315f3470c9de0.php
- User.php
- CorpoCelesteCrudTest
- Fase 6 — Fix sistema solare, NASA Import, Profilo, Documentazione
- Fase 2 — Backoffice Blade CRUD
- .suggestNome
- Fase 7 — Bugfix Intervention Image v4, NASA Import Force All, Documentazione
- apiClient.js
- GalleriaApiTest.php
- Comparatore.jsx
- Fase 8 — NASA Import multi-immagine, Service Layer, CLI Command
- HomePage.jsx
- App.jsx
- PasswordResetLinkController.php
- ProfileController.php
- auth.php
- ✨ Funzionalità
- Fase 15 — P2/P3 manutenzione e accessibilità
- Quick Reference
- Astralis Blade Admin Patterns
- Backend Test Patterns
- Fase 14 — 10 Bug critici fixati
- show.blade.php
- Test — Astralis
- Quick Reference
- PasswordConfirmationTest
- Astralis React SPA Patterns
- Frontend Design
- Core Concepts
- API di supporto
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
- GalleriaCorpoPolicy
- MissionePolicy
- DashboardController.php
- CategoriaApiTest
- CorpoCeleste.php
- PasswordConfirmationTest
- .missioni
- Fase 4 — React Guest Frontend
- admin.partials.color-picker-html
- Task 40 — Debug generale post-ottimizzazione
- Fase 1 — Critico React Frontend (P0)
- DashboardTest
- Stato avanzamento piano ottimizzazione
- DashboardController.php
- CorpoCelesteActionsTest
- AuthenticationTest
- Sicurezza e UX — Fasi 1-3 (15/07/2026)
- MissionePolicy
- EmailVerificationTest
- PasswordResetTest
- .corpiCelesti
- Piano Ottimizzazione — P1

## God Nodes (most connected - your core abstractions)
1. `CorpoCeleste` - 160 edges
2. `User` - 84 edges
3. `Categoria` - 70 edges
4. `GalleriaCorpo` - 64 edges
5. `Controller` - 49 edges
6. `Missione` - 49 edges
7. `TestCase` - 44 edges
8. `Changelog` - 34 edges
9. `Curiosita` - 31 edges
10. `NasaImageServiceTest` - 31 edges

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

## Communities (212 total, 61 thin omitted)

### Community 0 - "User"
Cohesion: 0.14
Nodes (13): 🔒 Autenticazione e Accesso, 💡 Consigli, Descrizione, 💡 Esempi di Struttura, 📦 Gestione Entità (CRUD), 💻 Note Tecniche, 🎯 Obiettivo, Parte 1: Backoffice in Laravel (+5 more)

### Community 1 - "db1cb51494627765ac48414e99948e15.php"
Cohesion: 0.13
Nodes (15): axios, framer-motion, lucide-react, dependencies, axios, framer-motion, lucide-react, react (+7 more)

### Community 2 - "CorpoDettaglio.jsx"
Cohesion: 0.16
Nodes (3): MissioneController, StoreMissioneRequest, UpdateMissioneRequest

### Community 3 - "CorpoCeleste"
Cohesion: 0.08
Nodes (4): Missione, DeleteProtectionTest, MissioneCrudTest, MissioneApiTest

### Community 4 - "Missione"
Cohesion: 0.06
Nodes (34): 1. Il Progetto in Breve, 2. Fasi di Sviluppo, 3. Checklist Requisiti → Realizzato, 4. Guide Pratiche, 5. Il Nostro Stack Tecnologico, 6. Comandi Rapidi, 7. Credenziali, 8. 📌 Schede Riassuntive (+26 more)

### Community 5 - "Changelog"
Cohesion: 0.07
Nodes (30): 0.1 — 02/07/2026 — `6df5099` — feat: setup iniziale Laravel + Breeze + React + documentazione, 10.0 — 06/07/2026 — `2d736af` `be1ee9b` `14ed82f` — feat: tema scuro auth pages, link Register, ridotta velocità orbite, 11.0 — 07/07/2026 — `65ed6d4` — fix: Inertia→Blade transizione, NASA import dedup, galleria cleanup e ordinamento, 14/07/2026 — fix: 2 bug Vitest (LightboxGalleria memo close + CorpoDettaglio import typo), 1.0 — 03/07/2026 — `0a57208` — feat: database e modelli con seeders, 1.0 — 10/07/2026 — `f5ed6ab` — feat: React P0 — AbortController, useFetch, ErrorBoundary, image guards, axios interceptors, 2.0 — 10/07/2026 — `f5ed6ab` — feat: Laravel P0 — Job queue, chunk(50), rate limiting, caching NASA, 3.0 — 03/07/2026 — feat: API REST (10 endpoint JSON) (+22 more)

### Community 6 - "JsonResource"
Cohesion: 0.10
Nodes (13): CategoriaController, CorpoCelesteController, CuriositaController, GalleriaController, MissioneController, CategoriaResource, CorpoCelesteResource, CuriositaResource (+5 more)

### Community 8 - "devDependencies"
Cohesion: 0.12
Nodes (17): autoprefixer, concurrently, jsdom, devDependencies, autoprefixer, concurrently, jsdom, postcss (+9 more)

### Community 11 - "GalleriaCorpo"
Cohesion: 0.08
Nodes (7): AggiornaOrdineRequest, StoreCategoriaRequest, StoreCuriositaRequest, StoreGalleriaCorpoRequest, SuggestNomeRequest, UpdateGalleriaCorpoRequest, Illuminate\Foundation\Http\FormRequest

### Community 12 - "Astralis — Documentazione di Progetto"
Cohesion: 0.07
Nodes (27): API REST, API REST (Endpoint), Architettura, Astralis — Documentazione di Progetto, Avvio rapido (quando il progetto è già configurato), Backoffice Admin, Badge Categoria, Bug residui — fix (17/07/2026) (+19 more)

### Community 13 - "Risolti"
Cohesion: 0.08
Nodes (24): [01] bootstrap/cache non scrivibile — 02/07/2026 (ricorrente su Windows), [02] bootstrap.js mancante — 03/07/2026, [03] GalleriaCorpoSeeder percorso con prefisso — 03/07/2026, [04] Vite config missing CSS input — 03/07/2026, [05] CorpoCeleste show view URL galleria sbagliato — 03/07/2026, [06] Sluggable config mancante — 03/07/2026, [07] Profile: Link Inertia intercetta navigazione Blade — 04/07/2026, [08] NASA Import: nomi italiani danno 0 risultati — 04/07/2026 (+16 more)

### Community 14 - "Parte 1: Backoffice in Laravel"
Cohesion: 0.20
Nodes (8): CategoriaSeeder, CorpoCelesteMissioneSeeder, CorpoCelesteSeeder, CuriositaSeeder, DatabaseSeeder, GalleriaCorpoSeeder, MissioneSeeder, Illuminate\Database\Seeder

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
Cohesion: 0.15
Nodes (7): Bug Tracker, Collegamenti rapidi, Documentazione Astralis, Indice, Da Fare, Note, Todo

### Community 21 - "Edit.jsx"
Cohesion: 0.10
Nodes (9): CategoriaController, CuriositaController, GalleriaController, UpdateCategoriaRequest, UpdateCuriositaRequest, AppLayout, GuestLayout, Illuminate\View\Component (+1 more)

### Community 23 - "config"
Cohesion: 0.29
Nodes (7): pestphp/pest-plugin, php-http/discovery, config, allow-plugins, optimize-autoloader, preferred-install, sort-packages

### Community 24 - "compilerOptions"
Cohesion: 0.22
Nodes (8): compilerOptions, baseUrl, paths, exclude, ziggy-js, node_modules, public, ./vendor/tightenco/ziggy

### Community 25 - "CorpoCeleste.php"
Cohesion: 0.15
Nodes (13): 02/07/2026, 03/07/2026, 04/07/2026, 07/07/2026, 08/07/2026, 09/07/2026, 10/07/2026, 11/07/2026 (+5 more)

### Community 26 - "UserFactory"
Cohesion: 0.13
Nodes (7): CategoriaFactory, CorpoCelesteFactory, CuriositaFactory, GalleriaCorpoFactory, MissioneFactory, UserFactory, Illuminate\Database\Eloquent\Factories\Factory

### Community 28 - "psr-4"
Cohesion: 0.40
Nodes (5): autoload, psr-4, App\\, Database\\Factories\\, Database\\Seeders\\

### Community 29 - "autoload-dev"
Cohesion: 0.22
Nodes (8): private, $schema, scripts, build, dev, test, test:watch, type

### Community 30 - "extra"
Cohesion: 0.67
Nodes (3): extra, laravel, dont-discover

### Community 46 - "DangerButton.jsx"
Cohesion: 0.11
Nodes (19): 12.0 — 07/07/2026 — feat: authorization admin con Policy e Gates, 12.1 — 07/07/2026 — feat: auth pages da Inertia a Blade puro, 12.2 — 08/07/2026 — `0931d17` — feat: rimossa dipendenza Inertia, 12.2 — 08/07/2026 — `f62f945` — feat: rimossa dipendenza Inertia (Fase 12.2), 12.3 — 08/07/2026 — `b17c0d9` — feat: FormRequest per validazione CorpoCeleste, 12.3 — 08/07/2026 — feat: FormRequest per validazione store/update CorpoCeleste, 12.4 — 08/07/2026 — `1869bc8` — feat: quick wins (per_page, ordinamento, .catch, nasa_id, indexes), 12.4 — 08/07/2026 — feat: quick wins — per_page, ordinamento relazioni, .catch, nasa_id, indexes (+11 more)

### Community 47 - "InputError.jsx"
Cohesion: 0.50
Nodes (3): profile.partials.delete-user-form, profile.partials.update-password-form, profile.partials.update-profile-information-form

### Community 50 - "NavLink.jsx"
Cohesion: 0.29
Nodes (4): AppServiceProvider, Illuminate\Support\ServiceProvider, vite, vite

### Community 61 - "Dashboard.jsx"
Cohesion: 0.25
Nodes (8): post-root-package-install, setup, composer install, npm install --ignore-scripts, npm run build, @php artisan key:generate, @php artisan migrate --force, @php -r \"file_exists('.env') || copy('.env.example', '.env');\

### Community 62 - "Welcome.jsx"
Cohesion: 0.40
Nodes (5): ✅ Completato — Bug residui (17/07/2026), ✅ Completato — Piano ottimizzazione (Task 1-39), ✅ Completato — Quick wins (16/07/2026), ✅ Completato — Sicurezza e UX (Fasi 1-3), Stato avanzamento piano ottimizzazione

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

### Community 106 - "158a58073f7c339cee02d82d7f1f6a13.php"
Cohesion: 0.67
Nodes (3): 8.0 — 04/07/2026 — feat: NASA Import multi-immagine in galleria + CLI fetch-nasa + metadati, 8.1 — 04/07/2026 — fix: memory limit per immagini NASA grandi + fallback URL per item, Fase 8 — NASA Import multi-immagine, Service Layer, CLI Command

### Community 162 - "CorpoCelesteCrudTest"
Cohesion: 0.09
Nodes (4): CorpoCeleste, CorpoCelesteApiTest, CorpoCelesteTest, ImportNasaImageTest

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
Cohesion: 0.05
Nodes (43): apiClient, fetchCategorie(), fetchCorpiCelesti(), fetchCorpoCeleste(), fetchDashboardStats(), fetchSimili(), Thumbnail, planets (+35 more)

### Community 170 - "GalleriaApiTest.php"
Cohesion: 0.09
Nodes (14): NasaImportController, ConfirmablePasswordController, EmailVerificationNotificationController, EmailVerificationPromptController, NewPasswordController, PasswordController, PasswordResetLinkController, RegisteredUserController (+6 more)

### Community 171 - "Comparatore.jsx"
Cohesion: 0.11
Nodes (17): Admin Controllers, API Routes (`routes/api.php`), Artisan Commands, `astralis:gallery` (`CleanupGalleryDuplicates.php`), Astralis Laravel Backend Patterns, Authorization, Bootstrap Cache (Windows), CorpoCelesteObserver (`app/Observers/CorpoCelesteObserver.php`) (+9 more)

### Community 179 - "App.jsx"
Cohesion: 0.10
Nodes (12): App(), Comparatore, CorpiLista, CorpoDettaglio, HomePage, NotFound, ErrorBoundary, Footer() (+4 more)

### Community 182 - "PasswordResetLinkController.php"
Cohesion: 0.13
Nodes (5): User, CorpoCelestePolicy, GalleriaCorpoPolicy, Illuminate\Foundation\Auth\User, Illuminate\Notifications\Notifiable

### Community 183 - "ProfileController.php"
Cohesion: 0.15
Nodes (12): Admin palette, Bugs noti / Pattern da evitare, Cross-PC sync, Documentazione workflow, Dual rendering (critical), Entità chiave, File map, graphify (+4 more)

### Community 184 - "auth.php"
Cohesion: 0.15
Nodes (12): Anthropic Brand Styling, Brand Guidelines, Color Application, Colors, Features, Font Management, Overview, Shape and Accent Colors (+4 more)

### Community 191 - "✨ Funzionalità"
Cohesion: 0.06
Nodes (33): API di supporto, `AuthorizationTest.php` (19 test), Backend (PHPUnit) — 252 test, 587 assertion, `CategoriaCrudTest.php` (14 test), `CleanupGalleryDuplicatesTest.php` (9 test), Componenti (4 file, 27 test), Configurazione, `CorpoCelesteActionsTest.php` (13 test) (+25 more)

### Community 193 - "Fase 15 — P2/P3 manutenzione e accessibilità"
Cohesion: 0.33
Nodes (6): 15.0 — 09/07/2026 — feat: Categoria index pagination, Curiosita show view, 15.1 — 09/07/2026 — feat: search/filter admin per Categoria, Missione, Curiosità, Galleria, 15.2 — 09/07/2026 — feat: SEO meta tags React (5 pagine guest), 15.3 — 09/07/2026 — feat: Error Boundary globale React, 15.4 — 09/07/2026 — feat: Admin CRUD test (4 file), Fase 15 — P2/P3 manutenzione e accessibilità

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

### Community 243 - "GalleriaCorpoPolicy"
Cohesion: 0.40
Nodes (5): Ottimizzazione P1, Task 5.1 — 11/07/2026 — admin-input class per auth/profile views, Task 5.2 — 11/07/2026 — Hardcoded hex → CSS variables, Task 5.3 — 11/07/2026 — Partials extraction completa, Task 5.4 — 11/07/2026 — Form partial unificato create/edit

### Community 246 - "CategoriaApiTest"
Cohesion: 0.50
Nodes (4): Ottimizzazione — UI/UX Review (Fase 10), Task 10.1 — 11/07/2026 — Web Design Guidelines review, Task 10.2 — 11/07/2026 — Writing Guidelines review, Task 10.3 — 11/07/2026 — Frontend Design review

### Community 248 - "CorpoCeleste.php"
Cohesion: 0.67
Nodes (3): 14.0 — 09/07/2026 — fix: 10 bug critici (Blade @endif, React null guard, 404 route, N+1, senza SSL, import duplicato), 14.1 — 09/07/2026 — chore: rimossi import morti React e dipendenze inutilizzate/malposizionate, Fase 14 — 10 Bug critici fixati

### Community 249 - "PasswordConfirmationTest"
Cohesion: 0.15
Nodes (3): CorpoCelesteController, StoreCorpoCelesteRequest, UpdateCorpoCelesteRequest

### Community 250 - ".missioni"
Cohesion: 0.10
Nodes (3): Categoria, CategoriaCrudTest, ApiEdgeCaseTest

### Community 251 - "Fase 4 — React Guest Frontend"
Cohesion: 0.67
Nodes (3): Ottimizzazione — Test Refactoring (Fase 9), Tasks 9.1 + 9.3 + 9.7 — 11/07/2026 — AdminTestCase refactoring + Http::fake uniform + DashboardApiTest, Tasks 9.6 — 11/07/2026 — Copertura test mancante

### Community 253 - "Task 40 — Debug generale post-ottimizzazione"
Cohesion: 0.08
Nodes (13): JsonResponse, ImportNasaImage, CorpoCelesteObserver, WordMapService, Illuminate\Bus\Queueable, Illuminate\Contracts\Events\ShouldDispatchAfterCommit, Illuminate\Contracts\Queue\ShouldBeUnique, Illuminate\Contracts\Queue\ShouldQueue (+5 more)

### Community 254 - "Fase 1 — Critico React Frontend (P0)"
Cohesion: 0.28
Nodes (4): FetchNasaCommand, NasaImageService, Command, Illuminate\Console\Command

### Community 275 - "Stato avanzamento piano ottimizzazione"
Cohesion: 0.16
Nodes (3): DashboardController, ProfileController, ProfileUpdateRequest

### Community 280 - "Sicurezza e UX — Fasi 1-3 (15/07/2026)"
Cohesion: 0.50
Nodes (4): Fase 1 — Security fixes, Fase 2 — Critical bug fixes, Fase 3 — UX & quality improvements, Sicurezza e UX — Fasi 1-3 (15/07/2026)

### Community 281 - "MissionePolicy"
Cohesion: 0.16
Nodes (4): ImageUploadService, Illuminate\Http\UploadedFile, Intervention\Image\ImageManager, ImageUploadServiceTest

## Knowledge Gaps
- **513 isolated node(s):** `$schema`, `name`, `type`, `description`, `laravel` (+508 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **61 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `CorpoCeleste` connect `CorpoCelesteCrudTest` to `CorpoCeleste`, `JsonResource`, `LoginRequest`, `🪐 Astralis — Catalogo di Corpi Celesti`, `DashboardTest`, `Stato avanzamento piano ottimizzazione`, `DashboardController.php`, `Edit.jsx`, `CorpoCelesteActionsTest`, `MissionePolicy`, `.corpiCelesti`, `GalleriaApiTest.php`, `Missione`, `Fase 8 — NASA Import multi-immagine, Service Layer, CLI Command`, `NasaImageServiceTest`, `User`, `CorpoCeleste`, `NavLink.jsx`, `PasswordResetLinkController.php`, `cache.php`, `TextInput.jsx`, `Test — Astralis`, `0079552f2330bfb933d02f675d7fae1e.php`, `RefreshDatabase`, `CorpoCelestePolicy`, `DashboardController.php`, `PasswordConfirmationTest`, `.missioni`, `Task 40 — Debug generale post-ottimizzazione`, `Fase 1 — Critico React Frontend (P0)`?**
  _High betweenness centrality (0.060) - this node is a cross-community bridge._
- **Why does `Changelog` connect `Changelog` to `Fase 15 — P2/P3 manutenzione e accessibilità`, `Sicurezza e UX — Fasi 1-3 (15/07/2026)`, `Fase 6 — Fix sistema solare, NASA Import, Profilo, Documentazione`, `Fase 2 — Backoffice Blade CRUD`, `Fase 7 — Bugfix Intervention Image v4, NASA Import Force All, Documentazione`, `158a58073f7c339cee02d82d7f1f6a13.php`, `1b91c30f6655ad6258212beb875408ce.php`, `1cca292344e066f15fdb501df69ab831.php`, `DangerButton.jsx`, `Piano Ottimizzazione — P1`, `GalleriaCorpoPolicy`, `index.md`, `CategoriaApiTest`, `CorpoCeleste.php`, `Fase 4 — React Guest Frontend`?**
  _High betweenness centrality (0.022) - this node is a cross-community bridge._
- **Why does `User` connect `PasswordResetLinkController.php` to `User.php`, `PasswordResetTest`, `RefreshDatabase`, `GalleriaApiTest.php`, `Fase 8 — NASA Import multi-immagine, Service Layer, CLI Command`, `User`, `DashboardTest`, `MissionePolicy`, `Test — Astralis`, `CorpoCelesteActionsTest`, `AuthenticationTest`, `PasswordConfirmationTest`, `API di supporto`, `AuthenticationTest`, `EmailVerificationTest`?**
  _High betweenness centrality (0.019) - this node is a cross-community bridge._
- **Are the 101 inferred relationships involving `CorpoCeleste` (e.g. with `.create()` and `.edit()`) actually correct?**
  _`CorpoCeleste` has 101 INFERRED edges - model-reasoned connections that need verification._
- **Are the 41 inferred relationships involving `User` (e.g. with `.store()` and `.run()`) actually correct?**
  _`User` has 41 INFERRED edges - model-reasoned connections that need verification._
- **Are the 42 inferred relationships involving `Categoria` (e.g. with `.create()` and `.edit()`) actually correct?**
  _`Categoria` has 42 INFERRED edges - model-reasoned connections that need verification._
- **Are the 39 inferred relationships involving `GalleriaCorpo` (e.g. with `.index()` and `.importForBody()`) actually correct?**
  _`GalleriaCorpo` has 39 INFERRED edges - model-reasoned connections that need verification._