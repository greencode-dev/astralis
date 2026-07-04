# Graph Report - .  (2026-07-04)

## Corpus Check
- cluster-only mode — file stats not available

## Summary
- 620 nodes · 940 edges · 96 communities (94 shown, 2 thin omitted)
- Extraction: 95% EXTRACTED · 5% INFERRED · 0% AMBIGUOUS · INFERRED: 51 edges (avg confidence: 0.8)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `3034abac`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

## Community Hubs (Navigation)
- [[_COMMUNITY_Community 0|Community 0]]
- [[_COMMUNITY_Community 1|Community 1]]
- [[_COMMUNITY_Community 2|Community 2]]
- [[_COMMUNITY_Community 3|Community 3]]
- [[_COMMUNITY_Community 4|Community 4]]
- [[_COMMUNITY_Community 5|Community 5]]
- [[_COMMUNITY_Community 6|Community 6]]
- [[_COMMUNITY_Community 7|Community 7]]
- [[_COMMUNITY_Community 8|Community 8]]
- [[_COMMUNITY_Community 9|Community 9]]
- [[_COMMUNITY_Community 10|Community 10]]
- [[_COMMUNITY_Community 11|Community 11]]
- [[_COMMUNITY_Community 12|Community 12]]
- [[_COMMUNITY_Community 13|Community 13]]
- [[_COMMUNITY_Community 14|Community 14]]
- [[_COMMUNITY_Community 15|Community 15]]
- [[_COMMUNITY_Community 16|Community 16]]
- [[_COMMUNITY_Community 17|Community 17]]
- [[_COMMUNITY_Community 18|Community 18]]
- [[_COMMUNITY_Community 19|Community 19]]
- [[_COMMUNITY_Community 20|Community 20]]
- [[_COMMUNITY_Community 21|Community 21]]
- [[_COMMUNITY_Community 22|Community 22]]
- [[_COMMUNITY_Community 23|Community 23]]
- [[_COMMUNITY_Community 24|Community 24]]

## God Nodes (most connected - your core abstractions)
1. `Controller` - 46 edges
2. `CorpoCeleste` - 38 edges
3. `User` - 26 edges
4. `Categoria` - 20 edges
5. `Missione` - 20 edges
6. `TestCase` - 20 edges
7. `GalleriaCorpo` - 16 edges
8. `Curiosita` - 15 edges
9. `NasaImageService` - 13 edges
10. `CorpoCelesteController` - 11 edges

## Surprising Connections (you probably didn't know these)
- `CategoriaController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/CategoriaController.php → app/Http/Controllers/Controller.php
- `CorpoCelesteController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/CorpoCelesteController.php → app/Http/Controllers/Controller.php
- `CuriositaController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/CuriositaController.php → app/Http/Controllers/Controller.php
- `GalleriaController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/GalleriaController.php → app/Http/Controllers/Controller.php
- `MissioneController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/MissioneController.php → app/Http/Controllers/Controller.php

## Import Cycles
- None detected.

## Communities (96 total, 2 thin omitted)

### Community 0 - "Community 0"
Cohesion: 0.05
Nodes (35): DashboardController, View, Request, CuriositaController, GalleriaController, ConfirmablePasswordController, RedirectResponse, Request (+27 more)

### Community 1 - "Community 1"
Cohesion: 0.07
Nodes (16): User, Authenticatable, BaseTestCase, HasFactory, Notifiable, RefreshDatabase, AuthenticationTest, EmailVerificationTest (+8 more)

### Community 2 - "Community 2"
Cohesion: 0.06
Nodes (31): apiClient, fetchCategorie(), fetchCorpiCelesti(), fetchCorpoCeleste(), fetchDashboardStats(), fetchSimili(), App(), CategoriaBadge() (+23 more)

### Community 3 - "Community 3"
Cohesion: 0.08
Nodes (14): FetchNasaCommand, CorpoCelesteController, JsonResponse, RedirectResponse, Request, View, NasaImportController, RedirectResponse (+6 more)

### Community 4 - "Community 4"
Cohesion: 0.08
Nodes (17): CuriositaController, RedirectResponse, Request, View, BelongsTo, BelongsToMany, SlugOptions, Curiosita (+9 more)

### Community 5 - "Community 5"
Cohesion: 0.12
Nodes (11): AuthenticatedSessionController, RedirectResponse, Request, Response, RedirectResponse, Request, Response, ProfileController (+3 more)

### Community 6 - "Community 6"
Cohesion: 0.07
Nodes (26): dependencies, axios, framer-motion, lucide-react, react-router-dom, @vitejs/plugin-react, yet-another-react-lightbox, devDependencies (+18 more)

### Community 7 - "Community 7"
Cohesion: 0.14
Nodes (11): CategoriaController, RedirectResponse, Request, View, DashboardController, JsonResponse, Categoria, HasMany (+3 more)

### Community 8 - "Community 8"
Cohesion: 0.13
Nodes (12): CategoriaController, CategoriaResource, Request, CorpoCelesteResource, Request, CuriositaResource, Request, GalleriaCorpoResource (+4 more)

### Community 9 - "Community 9"
Cohesion: 0.15
Nodes (9): MissioneController, RedirectResponse, Request, View, MissioneController, Request, Missione, BelongsToMany (+1 more)

### Community 10 - "Community 10"
Cohesion: 0.24
Nodes (6): GalleriaController, RedirectResponse, Request, View, GalleriaCorpo, BelongsTo

### Community 11 - "Community 11"
Cohesion: 0.18
Nodes (11): require, barryvdh/laravel-dompdf, inertiajs/inertia-laravel, intervention/image, laravel/breeze, laravel/framework, laravel/sanctum, laravel/tinker (+3 more)

### Community 12 - "Community 12"
Cohesion: 0.22
Nodes (8): description, keywords, license, minimum-stability, name, prefer-stable, $schema, type

### Community 13 - "Community 13"
Cohesion: 0.22
Nodes (9): scripts, dev, post-autoload-dump, post-create-project-cmd, post-root-package-install, post-update-cmd, pre-package-uninstall, setup (+1 more)

### Community 14 - "Community 14"
Cohesion: 0.25
Nodes (8): require-dev, fakerphp/faker, laravel/pail, laravel/pao, laravel/pint, mockery/mockery, nunomaduro/collision, phpunit/phpunit

### Community 15 - "Community 15"
Cohesion: 0.36
Nodes (3): DeleteUserForm(), UpdatePasswordForm(), UpdateProfileInformation()

### Community 16 - "Community 16"
Cohesion: 0.43
Nodes (3): HandleInertiaRequests, Request, Middleware

### Community 17 - "Community 17"
Cohesion: 0.29
Nodes (7): pestphp/pest-plugin, php-http/discovery, config, allow-plugins, optimize-autoloader, preferred-install, sort-packages

### Community 18 - "Community 18"
Cohesion: 0.29
Nodes (6): compilerOptions, baseUrl, paths, exclude, @/*, ziggy-js

### Community 20 - "Community 20"
Cohesion: 0.47
Nodes (3): UserFactory, Factory, static

### Community 22 - "Community 22"
Cohesion: 0.40
Nodes (5): autoload, psr-4, App\\, Database\\Factories\\, Database\\Seeders\\

### Community 23 - "Community 23"
Cohesion: 0.67
Nodes (3): autoload-dev, psr-4, Tests\\

### Community 24 - "Community 24"
Cohesion: 0.67
Nodes (3): extra, laravel, dont-discover

## Knowledge Gaps
- **82 isolated node(s):** `$schema`, `name`, `type`, `description`, `keywords` (+77 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **2 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Controller` connect `Community 0` to `Community 3`, `Community 4`, `Community 5`, `Community 7`, `Community 8`, `Community 9`, `Community 10`?**
  _High betweenness centrality (0.175) - this node is a cross-community bridge._
- **Why does `CorpoCeleste` connect `Community 3` to `Community 0`, `Community 10`, `Community 4`, `Community 7`?**
  _High betweenness centrality (0.036) - this node is a cross-community bridge._
- **Why does `User` connect `Community 1` to `Community 0`, `Community 4`?**
  _High betweenness centrality (0.035) - this node is a cross-community bridge._
- **Are the 10 inferred relationships involving `CorpoCeleste` (e.g. with `.create()` and `.edit()`) actually correct?**
  _`CorpoCeleste` has 10 INFERRED edges - model-reasoned connections that need verification._
- **Are the 21 inferred relationships involving `User` (e.g. with `.store()` and `.run()`) actually correct?**
  _`User` has 21 INFERRED edges - model-reasoned connections that need verification._
- **Are the 5 inferred relationships involving `Categoria` (e.g. with `.create()` and `.edit()`) actually correct?**
  _`Categoria` has 5 INFERRED edges - model-reasoned connections that need verification._
- **Are the 4 inferred relationships involving `Missione` (e.g. with `.index()` and `.stats()`) actually correct?**
  _`Missione` has 4 INFERRED edges - model-reasoned connections that need verification._