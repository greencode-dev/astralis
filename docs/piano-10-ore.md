# Piano di Lavoro - 10 Ore (19/07/2026)

> **Obiettivo**: Completare il progetto, testare, fare review design/writing, aggiornare documentazione, verificare traccia, preparare piano studi esame di domani.

## Stato attuale (verificato)

| Area | Stato | Note |
|------|-------|------|
| Requisiti traccia | 12/12 OK | Tutti i requisiti obbligativi soddisfatti |
| Task aperte | 6 (tutte High) | 87, 88, 89, 90, 91, 92 |
| Test | 377 (267+110) | Tutti verdi |
| Documentazione | Obsoleta | Test count errati in 5+ file, bug.md duplicati |
| Audit | Findings non fixati | 12 Web Design, 54+ Writing, 9 Frontend Design |

---

## BLOCCO 1 - Fix rapidi al codice (ore 0:00 - 1:30)

### 1a. Task 87 - Immagini Marte/Admin (~10 min)

**Root cause**: Il seeder imposta `immagine='marte.jpg'` ma il file non esiste in `storage/app/public/corpi-celesti/`. NASA import salta perche il campo e truthy.

**File**: `database/seeders/CorpoCelesteSeeder.php`

**Fix**: Impostare `'immagine' => null` per tutti i 18 corpi seeded (righe 30, 47, 63, 79, 95, 111, 127, 143, 159, 175, 191, 207, 224, 240, 258, 274, 291, 309).

**Effetto**:
- Le viste Blade admin mostrano il fallback stella (gia implementato in `index.blade.php:28-36`)
- L'observer `created()` dispatcha `ImportNasaImage` che scarica immagini reali NASA
- Se NASA fallisce, il fallback resta

### 1b. Task 91 - SolarSystem orbit fix (~5 min)

**File**: `resources/js/guest/components/SolarSystem.jsx`

**Fix**: Riga 137 - cambia `absolute inset-0` in `absolute left-0 top-0 w-full h-full`

```jsx
// Prima:
<div className="absolute inset-0 z-[5] flex items-center justify-center pointer-events-none">

// Dopo:
<div className="absolute left-0 top-0 w-full h-full z-[5] flex items-center justify-center pointer-events-none">
```

**Effetto**: Le orbite si centrano correttamente rispetto al Sole anche nel layout 2 colonne della HomePage.

### 1c. Task 89 - NASA import cleanup (~20 min)

**File**: `app/Services/NasaImageService.php`

**Fix 1**: Rimuovere blocco dead code (righe 62-80) - codice irraggiungibile duplicato.

**Fix 2**: Fixare messaggio in `importForBody` quando `force + immagine_utente` (riga 246-248).

### 1d. Task 90 - Landing page positioning (~20 min)

**File**: `resources/js/guest/pages/HomePage.jsx`

**Fix**: Riga 147 - Ajustare `translate: "50px 50px"` con positioning piu preciso.

**Opzioni**:
- `translate: "0 80px"` (abbassa di 80px)
- `translate: "-20px 60px"` (sposta a sinistra e abbassa)
- Testing visivo su viewport lg (1024px)

---

## BLOCCO 2 - Asset mancanti (ore 1:30 - 3:00)

### 2a. Task 88 - Loghi missioni (~30 min)

**File**: `database/seeders/MissioneSeeder.php`

**Opzione A (consigliata)**: Azzerare campo `logo` nel seeder - i placeholder SVG funzionano gia nelle viste Blade.

**Opzione B**: Creare directory `storage/app/public/missioni/` e scaricare 8 logo NASA reali.

**Loghi referenziati**: apollo-11.png, voyager.png, hubble.png, mars-pathfinder.png, iss.png, cassini.png, curiosity.png, jwst.png, artemis.png

### 2b. Task 92 - Logo Astralis (~30 min)

**File da aggiornare**:
- `resources/js/guest/components/Navbar.jsx` (riga 33) - usa `/favicon.svg`
- `resources/js/guest/components/Footer.jsx` (riga 7) - usa `/favicon.svg`
- `resources/views/admin/layouts/app.blade.php` (riga 32) - usa `/favicon.svg`
- `resources/views/layouts/guest.blade.php` (riga 17) - usa `/favicon.svg`

**Verificare se esistono**: `public/astralis_logo_completo.png`, `public/astralis_solo_logo.png`, `public/astralis_solo_testo.png` (Task 64).

**Se esistono**: Aggiornare i 4 path sopra. **Se non esistono**: Usare `favicon.svg` come fallback.

---

## BLOCCO 3 - Test e verifica (ore 3:00 - 4:00)

### 3a. Esecuzione test completa (~15 min)

```bash
php artisan test          # 267 test PHPUnit
npx vitest run            # 110 test Vitest
```

Fixare eventuali test falliti dopo le modifiche ai task 87-92.

### 3b. Verifica manuale (~15 min)

- Admin: `/admin/corpi-celesti` - controllare che Marte mostra immagine (o fallback)
- Admin: `/admin/missioni` - controllare che le missioni mostrano placeholder/loghi
- Guest: `/` - verificare landing page, SolarSystem, orbite centrate
- Guest: `/` - verificare che il logo appare in Navbar/Footer
- Guest: `/corpi-celesti` - verificare griglia e filtri
- Guest: `/corpi-celesti/sole` - verificare dettaglio con galleria

---

## BLOCCO 4 - Aggiornamento documentazione (ore 4:00 - 6:00)

### Test count errati (HIGH - impatto diretto sull'esame)

| File | Da | A | Righe |
|------|-----|---|-------|
| `AGENTS.md` | 255+107=362 | 267+110=377 | 80 |
| `testing.md` | 264 test | 267 test, 611 assertion | 7 |
| `testing.md` | 8 file admin | 13 file admin | 118-244 |
| `documentazione.md` | 252+107=359 | 267+110=377 | 340, 417, 437 |
| `README.md` | 252 PHPUnit | 267 PHPUnit | 66 |
| `README.md` | 107 Vitest | 110 Vitest | 69 |
| `presentazione-progetto.md` | 252+107=359 | 267+110=377 | 11, 278, 379 |
| `presentazione-progetto.md` | 130+88=218 | 267+110=377 | 510-511, 523-524 |

### testing.md - File mancanti da documentare

Aggiungere sezioni per: DashboardTest (8), NasaImportTest (8), GalleriaOrdineTest (6), ImageUploadServiceTest (5), DeleteProtectionTest (6), RateLimitingTest (8).

### testing.md - Per-file count errors

| Test File | testing.md dice | Reale | Diff |
|-----------|----------------|-------|------|
| CategoriaCrudTest | 14 | 12 | -2 |
| MissioneCrudTest | 13 | 11 | -2 |
| CuriositaCrudTest | 10 | 9 | -1 |
| GalleriaCrudTest | 9 | 8 | -1 |
| SearchAndFilterTest | 10 | 9 | -1 |
| AuthorizationTest | 19 | 21 | +2 |

### bug.md - Fix duplicati

Rimuovere duplicati: Bug [17], [21], [22] (ognuno appare 2 volte).

### changelog.md - Fix data

Riga 312: "al 17/07/2026" -> "al 19/07/2026"

### Aggiornamento finale

- `todo.md`: Spostare task completate in "Fatto"
- `AGENTS.md`: Aggiornare snapshot sessione + test count
- `changelog.md`: Aggiungere entry per i fix today

---

## BLOCCO 5 - Audit review (ore 6:00 - 7:30)

### HIGH - Fix ora (impatto visibile durante presentazione)

1. **prefers-reduced-motion** (5 min) - `resources/css/app.css`
   ```css
   @media (prefers-reduced-motion: reduce) {
       *, *::before, *::after {
           animation-duration: 0.01ms !important;
           animation-iteration-count: 1 !important;
           transition-duration: 0.01ms !important;
       }
   }
   ```

2. **focus-visible ring** (10 min) - Verificare tutti gli elementi interattivi abbiano `focus-visible:ring-2`

3. **aria-hidden su link** (5 min) - Controllare che nessun `<a>` abbia `aria-hidden="true"`

### MEDIUM - Fix solo se tempo

- 7 color inconsistencies -> documentare nel report
- Writing style (ellipsis, passive voice) -> non critico per l'esame

### LOW - Skip per ora

- Filler words "con successo"
- Heading case consistency
- Mixed Italian/English in docs

---

## BLOCCO 6 - Verifica traccia e preparazione presentazione (ore 7:30 - 8:30)

### 6a. Checklist finale requisiti (~15 min)

1. Backoffice Laravel con Blade - DONE
2. Autenticazione Breeze - DONE
3. CRUD entita principale (CorpoCeleste) - DONE
4. Relazioni 1-N e N-N - DONE
5. CRUD entita secondarie (4) - DONE
6. Upload media (Intervention Image) - DONE
7. SPA React guest - DONE
8. Lista elementi - DONE
9. Dettaglio elemento - DONE
10. Info correlate - DONE
11. API REST (10 endpoint) - DONE
12. **Live Coding PHP puro - DA PREPARARE SEPARATAMENTE**

### 6b. Verifica presentazione (~15 min)

- Rileggere `docs/presentazione-progetto.md`
- Aggiornare tutti i test count a 267+110=377
- Preparare demo flow: admin -> CRUD -> upload -> guest -> SPA -> comparatore

### 6c. Domande likely per l'esame (~30 min)

**Laravel**: Eloquent relationships, Observer, Policy+Gates, Service Layer, FormRequest, API Resources, Queue/Jobs, Migration+Seeder, Cache, Blade partials

**React**: React Router v7, Custom hooks (useFetch, useDebounce, useInView), API client retry+abort, Lightbox, framer-motion, requestAnimationFrame, IntersectionObserver, Error boundaries

**Testing**: PHPUnit (Http::fake, factory, RefreshDatabase), Vitest (render, screen, fireEvent), AdminTestCase, Observer auto-skip

**PHP Live Coding**: Array manipulation, String functions, OOP, Laravel collections/facades

---

## BLOCCO 7 - Piano di studi/ripasso (ore 8:30 - 10:00)

### Ripasso argomenti chiave

Vedi BLOCCO 6c per la lista completa degli argomenti.

**Consiglio**: Leggi il codice sorgente dei file principali del progetto per ripassare i pattern:
- `app/Services/NasaImageService.php` (Service Layer + API call)
- `app/Observers/CorpoCelesteObserver.php` (Observer pattern)
- `app/Policies/CorpoCelestePolicy.php` (Authorization)
- `resources/js/guest/hooks/useFetch.js` (Custom hook)
- `resources/js/guest/components/SolarSystem.jsx` (requestAnimationFrame)
- `tests/Feature/Admin/CorpoCelesteCrudTest.php` (PHPUnit pattern)
- `resources/js/guest/test/CorpoDettaglio.test.jsx` (Vitest pattern)

---

## RIEPILOGO TEMPORALE

| Blocco | Ora | Durata | Output |
|--------|-----|--------|--------|
| 1 - Fix rapidi codice | 0:00-1:30 | 1.5h | Tasks 87,89,90,91 fixati |
| 2 - Asset mancanti | 1:30-3:00 | 1.5h | Tasks 88,92 completati |
| 3 - Test e verifica | 3:00-4:00 | 1h | Test verdi, fix manuale |
| 4 - Documentazione | 4:00-6:00 | 2h | Tutti i doc aggiornati |
| 5 - Audit review | 6:00-7:30 | 1.5h | Fix high-priority |
| 6 - Traccia + presentazione | 7:30-8:30 | 1h | Checklist completa |
| 7 - Piano studi/ripasso | 8:30-10:00 | 1.5h | Ripasso argomenti |
| **Totale** | | **10h** | |

---

## RACCOMANDAZIONI

1. **Non fixare tutti gli audit finding** - solo i 3 High (prefers-reduced-motion, outline, aria-hidden). Il resto e P4 e non impatta l'esame.

2. **Per i logo (Task 88/92)** - se non hai i PNG, usa i placeholder SVG che funzionano gia. Meglio un progetto funzionante con placeholder che uno incompleto.

3. **Live Coding** - prepara esercizi PHP base (array, stringhe, OOP) separatamente. Non e verificabile dal codice del progetto.

4. **Presentazione** - il progetto ha molti "wow factor" (NASA API, SolarSystem animato, comparatore). Evidenziali nella demo.

5. **Se il tempo stringe** - priorita assoluta: BLOCCO 1 (fix codice) + BLOCCO 3 (test) + BLOCCO 6b (verifica presentazione). Il resto e nice-to-have.
