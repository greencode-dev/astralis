---
name: astralis-laravel
description: Pattern backend Laravel per Astralis — Observer, Policy, Service, Command. Usa questa skill quando lavori su backend Laravel del progetto Astralis, CRUD admin, entità, servizi, comandi artisan, upload immagini o autorizzazione.
---

# Astralis Laravel Backend Patterns

Astralis usa Laravel 13 con PHP 8.x. Le entità sono 5: Categoria, CorpoCeleste, Missione, Curiosità, GalleriaCorpo.

## Service Layer

### NasaImageService (`app/Services/NasaImageService.php`)
- Importa immagini NASA con dedup
- Preserva immagine_utente se true (non sovrascrivere)
- Timeout 30s, retry 2
- Testing guard: skip in ambiente testing

### WordMapService (`app/Services/WordMapService.php`)
- Traduzione italiano→inglese per la suggestion NASA in admin
- Usata dal dropdown di associazione NASA ID

## Observer Pattern

### CorpoCelesteObserver (`app/Observers/CorpoCelesteObserver.php`)
- `created()` → auto-import NASA tramite NasaImageService
- Skip in testing via `app()->environment('testing')`
- Non chiamare manualmente — è automatico su created

## Authorization

### Policies (`app/Policies/`)
- 5 Policy, una per entità
- Registrate in `AuthServiceProvider.php`

### Gates
- Gate `admin` in `AuthServiceProvider.php`
- Check: utente autenticato → admin

## Artisan Commands

### `astralis:gallery` (`CleanupGalleryDuplicates.php`)
- Flags: `--check`, `--clean`, `--sync`, `--fix`, `--dry-run`
- Manutenzione immagini galleria

## Upload Images (Critical)

Intervention Image v4 — **NO facade**. Pattern corretto:

```php
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

$manager = new ImageManager(new Driver());
$image = $manager->read($path);
$image->scaleDown(width: 800);
```

Usare `scaleDown()` invece di `resize()`. Usare `decodePath()` per file path, `decodeBinary()` per binary.

## Sluggable

Usa `spatie/laravel-sluggable`:
```php
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
```

## SSL (Windows local)

`Http::withoutVerifying()` solo in local/testing (Windows certificati self-signed).

## API Routes (`routes/api.php`)

10 endpoint JSON pubblici. Controller in `app/Http/Controllers/Api/`.

## Admin Controllers

CRUD in `app/Http/Controllers/Admin/`. Restituiscono view Blade.

## Bootstrap Cache (Windows)

Se creata da Git Bash va ricreata:
```bash
cmd //c 'rmdir /s /q bootstrap\cache' && cmd //c 'mkdir bootstrap\cache'
```
