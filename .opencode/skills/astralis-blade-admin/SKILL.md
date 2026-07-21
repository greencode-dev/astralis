---
name: astralis-blade-admin
description: Pattern admin Blade per Astralis — Alpine.js, CRUD, sidebar, palette, tabelle. Usa questa skill quando lavori su backoffice admin Blade, CRUD, viste admin, sidebar, form o tabelle.
---

# Astralis Blade Admin Patterns

Admin pages in Blade puro (`resources/views/admin/`). Master layout: `layouts/app.blade.php`.

## Tech Stack

- **Blade** (Laravel templating)
- **Alpine.js** via npm, bundled da Vite (`resources/js/admin.js`)
- **Tailwind CSS**
- **Chart.js** via CDN per grafici

## Master Layout (`layouts/app.blade.php`)

### Alpine.js Setup
Alpine.js è installato come dipendenza npm e bundled da Vite.
Entry point: `resources/js/admin.js` → import + `Alpine.start()`.
Caricato nel layout con: `@vite(['resources/css/app.css', 'resources/js/admin.js'])`

### x-cloak
Style in `resources/css/app.css` per prevenire FOUC. Essenziale dato Alpine.js viene inizializzato da Vite.

## Admin Palette

| Ruolo | Colore |
|---|---|
| Sfondo | `#0A0A1A` |
| Card | `#111128` |
| Testo | `#F0F0FA` |
| Primario | `#22D3EE` |
| Secondario | `#A855F7` |
| Accento | `#F97316` |
| Badge OK | `#22C55E` |
| Badge KO | `#9CA3AF` |
| Attenzione | `#FACC15` |

## CRUD Pattern

Controller in `app/Http/Controllers/Admin/`. Ogni CRUD:

1. **Index** — tabella con paginazione, search
2. **Create** — form per nuova entità
3. **Store** — validazione + salvataggio
4. **Edit** — form precompilato
5. **Update** — validazione + aggiornamento
6. **Destroy** — eliminazione con confirmation

## Sidebar Pattern

Sidebar fissa in `layouts/app.blade.php` con Alpine.js per toggle mobile:

```html
<div x-data="{ open: false }">
  <button @click="open = !open">Toggle</button>
  <aside x-show="open" x-cloak>
    <!-- Nav items -->
  </aside>
</div>
```

## Tabelle Admin

Tabelle Tailwind con stripe rows, header fisso, paginazione links.

## Form Admin

Form con:
- Validazione lato server (Laravel Form Request o `validate()`)
- Errori visualizzati con `@error` directive
- CSRF token (`@csrf`)
- Metodo spoofing (`@method('PUT')` per update)
