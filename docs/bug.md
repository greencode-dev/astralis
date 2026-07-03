# Bug Tracker

## Aperti
_Nessun bug aperto al momento_

## Risolti

### [01] bootstrap/cache non scrivibile — 02/07/2026
- **Descrizione**: Dopo `composer create-project`, la cartella `bootstrap/cache` risultava non scrivibile
- **Causa**: Creata da Git Bash con permessi Windows incompatibili con PHP
- **Soluzione**: Eliminata con `rmdir /s /q bootstrap\cache` e ricreata con `mkdir bootstrap\cache` (cmd nativo Windows)
- **Fixato in**: Fase 0.1

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
