# Bug Tracker

## Aperti

### [11] NASA Import: memory limit per immagini ~orig troppo grandi — 04/07/2026 — FIXED
- **Descrizione**: L'import di `~orig.jpg` da NASA per alcuni corpi (es. Cometa di Halley) supera il memory limit di PHP (128MB) causando errore `Allowed memory size exhausted`
- **Causa**: Le immagini originali NASA possono essere molto grandi (>50MB) e GD tenta di decompressarle interamente in memoria
- **Soluzione**: Aggiunto `ini_set('memory_limit', '512M')` in `downloadAndProcess()` nel Service. Fallback URL per-item: canonical (~orig) → alternate (~small, usato come‑è) → preview (~thumb, usato come‑è). Rimosso `preg_replace` verso ~orig nei fallback.

### [08] x_cloak visibile durante caricamento Alpine.js — 04/07/2026
- **Descrizione**: Se Alpine.js CDN tarda a caricare, il contenuto con `x-cloak` potrebbe essere visibile brevemente (FOUC)
- **Causa**: Style `[x-cloak] { display: none !important; }` è inline nel `<head>` e dovrebbe risolvere, ma se il CDN fallisce completamente il contenuto rimane nascosto
- **Soluzione**: Già applicata con style inline. Se il problema persiste, valutare fallback: rimuovere `x-cloak` e usare `x-init` per mostrare il modale solo dopo che Alpine è caricato.

## Risolti

### [01] bootstrap/cache non scrivibile — 02/07/2026 (ricorrente su Windows)
- **Descrizione**: `php artisan serve` fallisce con `"The bootstrap/cache directory must be present and writable"`
- **Causa**: Directory creata da **Git Bash**, che imposta permessi POSIX incompatibili con PHP su Windows
- **Soluzione**:

  **Metodo 1 — cmd nativo (da Git Bash)**:
  ```bash
  cmd //c 'rmdir /s /q bootstrap\cache'
  cmd //c 'mkdir bootstrap\cache'
  ```

  **Metodo 2 — File Explorer**:
  1. Cancella manualmente la cartella `bootstrap/cache`
  2. Ricreala: tasto destro → Nuovo → Cartella

- **Fixato in**: Fase 0.1 e Fase 4.0

> **Nota**: Questo problema si ripresenta in **qualsiasi progetto Laravel su Windows** quando una directory viene creata da Git Bash. Il fix è sempre lo stesso: ricreare la cartella con cmd nativo o Explorer.
>
> **Attenzione alla doppia barra**: Nei comandi cmd da Git Bash, usare sempre `cmd //c` (doppio slash) per passare opzioni a cmd. Usando `cmd /c` singolo, Git Bash interpreta `/c` come percorso Unix e il comando fallisce o crea file indesiderati (es. una cartella `bootstrapcache` invece di `bootstrap\cache`).

### [02] bootstrap.js mancante — 03/07/2026
- **Descrizione**: `npm run build` falliva con `[UNRESOLVED_IMPORT] Module not found: ./bootstrap in resources/js/app.jsx`
- **Causa**: Il progetto Breeze con React stack non aveva generato il file `resources/js/bootstrap.js`
- **Soluzione**: Creato manualmente `resources/js/bootstrap.js` con import axios
- **Fixato in**: Fase 2.1

### [03] GalleriaCorpoSeeder percorso con prefisso — 03/07/2026
- **Descrizione**: I 16 record di GalleriaCorpoSeeder salvavano il campo `percorso` con prefisso `galleria/`, causando URL doppi (`/storage/galleria/galleria/foto.jpg`)
- **Causa**: Inconsistenza tra seeder (prefisso incluso) e controller (che già prepende la directory in Storage::url)
- **Soluzione**: Rimosso prefisso `galleria/` da tutti i 16 record in GalleriaCorpoSeeder
- **Fixato in**: Fase 3.0 (commit 24e24dc)

### [04] Vite config missing CSS input — 03/07/2026
- **Descrizione**: `@vite(['resources/css/app.css'])` non trovava il CSS in produzione
- **Causa**: `vite.config.js` aveva solo `resources/js/app.jsx` come input
- **Soluzione**: Aggiunto `resources/css/app.css` all'array input
- **Fixato in**: Fase 3.0 (commit 24e24dc)

### [05] CorpoCeleste show view URL galleria sbagliato — 03/07/2026
- **Descrizione**: La vista show di CorpoCeleste mostrava URL galleria senza prefisso `galleria/`
- **Causa**: Storage::url richiamato senza il prefisso della directory
- **Soluzione**: Aggiunto `'galleria/'` in Storage::url alla riga 117
- **Fixato in**: Fase 3.0 (commit 24e24dc)

### [06] Sluggable config mancante — 03/07/2026
- **Descrizione**: spatie/laravel-sluggable v4 generava errore per mancanza di config pubblicato
- **Causa**: Il pacchetto v4 non supporta vendor:publish per il config
- **Soluzione**: Copiato manualmente `config/sluggable.php` da vendor
- **Fixato in**: Fase 3.0 (commit 24e24dc)

### [07] Profile: Link Inertia intercetta navigazione Blade — 04/07/2026
- **Descrizione**: Cliccando "Torna all'admin" dalla pagina profilo, Inertia intercepta il link `/admin` invece di lasciarlo gestire dal backend Blade
- **Causa**: Componente React `<Link href="/admin">` di Inertia — Inertia gestisce solo le proprie route; `/admin` è una route Blade, non Inertia
- **Soluzione**: Sostituito `<Link href="/admin">` con `<a href="/admin">` in `Profile/Edit.jsx`
- **Fixato in**: Fase 7.0

### [08] NASA Import: nomi italiani danno 0 risultati — 04/07/2026
- **Descrizione**: Cercando "Cerere" su NASA API si ottengono 0 risultati; "Ceres" (inglese) funziona
- **Causa**: NASA Image API accetta solo nomi in inglese; il DB salva i nomi in italiano
- **Soluzione**: Aggiunto array `$nameMap` nel controller per mappare nomi italiano→inglese
- **Fixato in**: Fase 7.1

### [09] NASA Import: cURL error 60 su Windows — 04/07/2026
- **Descrizione**: `Http::get()` verso NASA API fallisce su Windows con errore SSL "certificate verify failed"
- **Causa**: Configurazione certificati CA incompleta su ambiente Windows locale
- **Soluzione**: Aggiunto `->withoutVerifying()` a tutte le chiamate HTTP verso NASA API
- **Fixato in**: Fase 7.2

### [10] Intervention Image v3 facade deprecata in v4 — 04/07/2026
- **Descrizione**: 4 controller usano `Intervention\Image\Laravel\Facades\Image` che non esiste più in v4
- **Causa**: Il progetto usa `intervention/image: 4.1.5` che ha API completamente diversa da v3; `Image::read()` è stato rinominato in `decodeBinary()`/`decodePath()`, `resize(closure)` non esiste più, va usato `scaleDown()`
- **Soluzione**: Sostituita facade con `ImageManager(new Driver())`, metodi `decodeBinary()`/`decodePath()` per leggere, `scaleDown(width: N, height: N)` per ridimensionamento
- **Fixato in**: Fase 7.3
