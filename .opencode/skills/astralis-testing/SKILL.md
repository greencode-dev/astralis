---
name: astralis-testing
description: Pattern test per Astralis — PHPUnit + Vitest, factory, Http::fake, observer skip. Usa questa skill quando scrivi o esegui test per backend Laravel o frontend React del progetto Astralis.
---

# Astralis Testing Patterns

- **Backend**: PHPUnit — 271 test, 615 assertion
- **Frontend**: Vitest — 110 test
- Esecuzione: `php artisan test`

## Backend Test Patterns

### Factory Pattern

Tutti i 5 modelli hanno `HasFactory`. Factory in `database/factories/`.

```php
// Categoria viene creata automaticamente da CorpoCelesteFactory
CorpoCeleste::factory()->create();

// Specificare categoria esistente
$categoria = Categoria::factory()->create();
CorpoCeleste::factory()->for($categoria)->create();
```

### Critical: Http::fake() in setUp

Tutti i test che creano `CorpoCeleste` via factory **devono** includere `Http::fake()` in setUp per prevenire chiamate HTTP reali al NASA API:

```php
protected function setUp(): void
{
    parent::setUp();
    Http::fake();
}
```

Questo perché `CorpoCelesteObserver::created()` triggera `NasaImageService` che fa chiamate HTTP.

### Observer Skip in Testing

`CorpoCelesteObserver::created()` si disabilita automaticamente in ambiente testing:
```php
// In app()->environment('testing') → skip
if (app()->environment('testing')) {
    return;
}
```

Non serve mockare l'observer manualmente — lo skip è automatico.

### NasaImageService Test Guard

```php
// Testing guard nel servizio
if (app()->environment('testing')) {
    return;
}
```

### Testing Commands

```php
$this->artisan('astralis:gallery', ['--check' => true])
    ->assertExitCode(0);
```

## Frontend Test Patterns (Vitest)

Test in `resources/js/guest/` con Vitest. Esecuzione:
```bash
npx vitest run
```

Pattern comune:
```jsx
import { render, screen } from '@testing-library/react';
import { describe, it, expect } from 'vitest';

describe('ComponentName', () => {
  it('renders correctly', () => {
    render(<Component />);
    expect(screen.getByText('expected text')).toBeInTheDocument();
  });
});
```

## Database

MySQL su porta 3307. Migrazioni in `database/migrations/`.

### Refresh in Test

```php
use RefreshDatabase; // o DatabaseTransactions
```
