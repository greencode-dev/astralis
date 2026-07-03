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
