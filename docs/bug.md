# Bug Tracker

## Aperti
_Nessun bug aperto al momento_

## Risolti

### [01] bootstrap/cache non scrivibile — 02/07/2026
- **Descrizione**: Dopo `composer create-project`, la cartella `bootstrap/cache` risultava non scrivibile
- **Causa**: Creata da Git Bash con permessi Windows incompatibili con PHP
- **Soluzione**: Eliminata con `rmdir /s /q bootstrap\cache` e ricreata con `mkdir bootstrap\cache` (cmd nativo Windows)
- **Fixato in**: Fase 0.1
