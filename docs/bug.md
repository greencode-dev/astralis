# Bug Tracker

## Risolti

### [25] useInView: elementi condizionali invisibili (opacity: 0) — 12/07/2026
- **Descrizione**: Le card "In Evidenza" sulla homepage e la griglia nella pagina Corpi Celesti non venivano mai visualizzate. Gli skeleton sparivano ma le card restavano invisibili (`opacity: 0`)
- **Causa**: `useInView` usava `useRef` + `useEffect([])`. Su elementi renderizzati condizionalmente (dopo il loading), `ref.current` era `null` al mount → l'IntersectionObserver non veniva mai creato → `isVisible` restava `false`
- **Soluzione**: Sostituito con callback ref pattern (`useState` come ref). Il callback viene richiamato al mount dell'elemento, garantendo la creazione dell'observer anche su elementi condizionali
- **File**: `resources/js/guest/hooks/useInView.js`

### [26] WordMapService: frasi non tradotte + Orione mancante — 12/07/2026
- **Descrizione**: `WordMapService::translate()` non traduceva frasi multi-parola ("Via Lattea", "Nebulosa di Orione"). "Orione" non aveva mapping inglese
- **Causa**: Il metodo splittava per spazio e mappava solo singole parole. Le chiavi frasi (es. `"Via Lattea"`) non venivano mai matchate. Manca il mapping `'Orione' => 'Orion'`
- **Soluzione**: Prima della mappatura singole parole, il metodo ora cerca e sostituisce frasi (chiavi con spazi) ordinate per lunghezza decrescente. Aggiunto `'Orione' => 'Orion'`
- **File**: `app/Services/WordMapService.php`

### [27] NasaImageService: nomi italiani danno 0 risultati (regressione) — 12/07/2026
- **Descrizione**: Il comando `astralis:fetch-nasa` falliva per 9 corpi su 18 (Mercurio, Giove, Urano, Nettuno, Titano, Via Lattea, Nebulosa di Orione, Cerere, Plutone). L'import salvava ancora nomi file locali inesistenti
- **Causa**: `importForBody()` usava `$corpo->nome` (italiano) direttamente come query NASA. Il bug #08 era stato fixato nel controller con un `$nameMap` hardcoded, ma il Service non usava il WordMapService
- **Soluzione**: Inject di `WordMapService` in `NasaImageService`. Prima della ricerca, il nome viene tradotto e aggiunto come fallback. Ricerca prima in italiano, poi in inglese. Risultato: 18/18 corpi con immagini NASA remote
- **File**: `app/Services/NasaImageService.php`

### [21] LightboxGalleria.jsx sintassi corrotta — 12/07/2026
- **Descrizione**: Componente non si montava — parentesi mancante alla riga 58 + callback `onOpen` malformata
- **Causa**: File corrotto probabilmente durante un merge o edit precedente
- **Soluzione**: Riscritto completamente il componente
- **Fixato in**: Fase ripristino 12/07/2026

### [22] CorpoDettaglio.test.jsx import errato — 12/07/2026
- **Descrizione**: Test Vitest falliva — importava `mockCorpoDettaglioDettaglio` (doppio "Dettaglio")
- **Causa**: Typo nell'import (probabile rename errato)
- **Soluzione**: Corretto import da `mockCorpoDettaglioDettaglio` a `mockCorpoDettaglio`
- **Fixato in**: Fase ripristino 12/07/2026

### [23] GalleriaCorpo didascalia/crediti VARCHAR(255) — 12/07/2026
- **Descrizione**: L'observer auto-import NASA creava record con `didascalia` >255 chars, causando errori SQL
- **Causa**: Titoli NASA possono essere lunghi >255 caratteri
- **Soluzione**: Migrazione `2026_07_12_000000_change_galleria_didascalia_crediti_to_text.php` — `didascalia` e `crediti` da VARCHAR(255) a TEXT
- **Fixato in**: Fase ripristino 12/07/2026

### [24] bootstrap/cache non scrivibile da Git Bash — 12/07/2026
- **Descrizione**: `php artisan serve` fallisce dopo clone su nuovo PC
- **Causa**: Directory creata da Git Bash con permessi POSIX incompatibili
- **Soluzione**: `cmd //c 'rmdir /s /q bootstrap\cache' && cmd //c 'mkdir bootstrap\cache'`
- **Fixato in**: Fase ripristino 12/07/2026

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

### [11] NASA Import: memory limit per immagini ~orig troppo grandi — 04/07/2026
- **Descrizione**: L'import di `~orig.jpg` da NASA per alcuni corpi (es. Cometa di Halley) supera il memory limit di PHP (128MB) causando errore `Allowed memory size exhausted`
- **Causa**: Le immagini originali NASA possono essere molto grandi (>50MB) e GD tenta di decompressarle interamente in memoria
- **Soluzione**: Aggiunto `ini_set('memory_limit', '512M')` in `downloadAndProcess()` nel Service. Fallback URL per-item: canonical (~orig) → alternate (~small, usato come‑è) → preview (~thumb, usato come‑è). Rimosso `preg_replace` verso ~orig nei fallback.
- **Fixato in**: Fase 8.1

### [12] NASA API: apostrofo causa 0 risultati — 04/07/2026
- **Descrizione**: La query `Halley's Comet` su NASA Image API restituisce 0 risultati
- **Causa**: NASA API non gestisce apostrofi nelle query di ricerca. `Halley's` (con apostrofo) non matcha `Halleys` (senza) nei database NASA
- **Soluzione**: `NasaImageService::searchNasa()` ora prova automaticamente query senza apostrofi (`str_replace(["'", "`", "’", "'s ", "'s"], "", $query)`) e aggiunge fallback extra "comet" per nomi contenenti "comet"/"halley". Le immagini vengono inoltre salvate come URL remoti invece di essere scaricate, eliminando il memory limit problem.
- **Fixato in**: Fase 9.0

### [13] Login: Inertia intercepta redirect verso pagine Blade — 07/07/2026
- **Descrizione**: Dopo il login, i link della navbar admin non funzionano fino a refresh manuale
- **Causa**: Transizione Inertia (React login) → Blade (admin dashboard). Inertia intercetta il redirect 302 e prova a caricare la risposta come JSON, ma Blade restituisce HTML
- **Soluzione**: Sostituito `redirect()->intended()` con `Inertia::location()` in AuthenticatedSessionController::store(). Stesso fix per altri 5 auth controller POST
- **Fixato in**: Fase 11.0

### [14] NASA Force Import: duplicati in galleria — 07/07/2026
- **Descrizione**: Eseguendo Force Import più volte, le stesse immagini NASA venivano aggiunte più volte alla galleria
- **Causa**: Nessun controllo duplicati in NasaImageService::importForBody() — creava sempre nuovi GalleriaCorpo
- **Soluzione**: Aggiunto check `GalleriaCorpo::where('corpo_celeste_id', $id)->where('percorso', $url)->exists()` prima di creare
- **Fixato in**: Fase 11.0

### [15] NASA Force Import: sovrascrive immagine principale personalizzata — 07/07/2026
- **Descrizione**: Il Force Import sostituiva l'immagine principale anche se l'utente l'aveva cambiata manualmente dalla galleria
- **Causa**: Nessuna distinzione tra immagini impostate dall'utente e immagini importate da NASA
- **Soluzione**: Aggiunta colonna `immagine_utente` (boolean, default false). CorpoCelesteController::setImageFromGallery() e update() la impostano a true. NasaImageService::importForBody() non sovrascrive se true, anche con force=true
- **Fixato in**: Fase 11.0

### [16] Galleria: immagini corrotte (file locali mancanti) — 07/07/2026
- **Descrizione**: Galleria mostrava placeholder rotti per immagini seed che puntavano a file inesistenti su disco (plutone-1.jpg, etc.)
- **Causa**: I seed di GalleriaCorpo (IDs 1-16) salvavano riferimenti a file locali mai creati su `storage/app/public/galleria/`
- **Soluzione**: Creato comando `php artisan astralis:gallery --fix` che verifica ogni record (HEAD per URL remoti, Storage::exists() per locali) e sostituisce quelli ko con immagini NASA. Aggiunto onerror placeholder nelle view
- **Fixato in**: Fase 11.0

### [17] Logout reindirizza a homepage invece di login — 07/07/2026
- **Descrizione**: Dopo il logout, l'utente veniva reindirizzato a `/` (guest SPA) invece che a `/login`
- **Causa**: AuthenticatedSessionController::destroy() usava `return redirect('/')`
- **Soluzione**: Sostituito con `return redirect('/login')`
- **Fixato in**: Fase 11.0

### [18] Query stripping NASA: apostrofo rimosso prima di 's — 08/07/2026
- **Descrizione**: `NasaImageService::searchNasa()` produceva `"Earths Moon"` invece di `"Earth Moon"` come fallback per `"Earth's Moon"`. L'apostrofo veniva rimosso singolarmente prima della sequenza `'s`, quindi `'s` non matchava più.
- **Causa**: `str_replace(["'", ... , "'s "], ...)` — l'apostrofo singolo era prima di `'s` nell'array. PHP processa in ordine, quindi `'` veniva rimosso per primo, `'s` non trovava più match.
- **Soluzione**: Riordinato array: `str_replace(["'s", "'", "`", "’"], ...)` — ora `'s` viene matchato prima come unità.
- **Sintomi**: Ricaduta su qualsiasi nome inglese con possessivo (`Earth's Moon`, `Halley's Comet`)
- **Fixato in**: Fase 13.0

### [19] NASA Force Import: crea voci galleria anche con immagine utente — 08/07/2026
- **Descrizione**: Usando `--force` su un corpo con `immagine_utente=true`, l'immagine principale era preservata (corretto) ma venivano comunque create voci in galleria
- **Causa**: La guard `if (!$force && $corpo->immagine)` skip solo se force=false. La protezione `immagine_utente` era implementata solo per l'immagine principale (`$canOverwriteMain`), non per il flusso generale
- **Soluzione**: Modificata la guard in: `if ($corpo->immagine && (!$force || $corpo->immagine_utente))` — se l'immagine è utente, skip sempre, anche con force
- **Fixato in**: Fase 13.0

### [20] CorpoCelesteObserver chiama NASA API durante i test — 08/07/2026
- **Descrizione**: Creando un `CorpoCeleste::factory()->create()` in un test PHPUnit, l'observer `CorpoCelesteObserver::created()` effettuava chiamate HTTP reali verso images-api.nasa.gov
- **Causa**: L'observer non aveva alcun check sull'ambiente. I test feature API che non impostavano `Http::fake()` dipendevano dalla connettività esterna
- **Soluzione**: Aggiunto `if (app()->environment('testing')) return;` in `CorpoCelesteObserver::created()`. Aggiunto `Http::fake()` nei setUp dei test feature come safety net
- **Sintomi**: Test fallivano in assenza di connessione Internet; rallentamento suite test (~30s per timeout); galleria popolata da dati NASA reali durante i test
- **Fixato in**: Fase 13.0

### [17] Logout reindirizza a homepage invece di login — 07/07/2026
- **Descrizione**: Dopo il logout, l'utente veniva reindirizzato a `/` (guest SPA) invece che a `/login`
- **Causa**: AuthenticatedSessionController::destroy() usava `return redirect('/')`
- **Soluzione**: Sostituito con `return redirect('/login')`
- **Fixato in**: Fase 11.0

### [21] LightboxGalleria: parentesi mancante memo() — 14/07/2026
- **Descrizione**: 2 file di test Vitest fallivano con parse error `Expected ')' but found EOF` in LightboxGalleria.jsx:70
- **Causa**: Chiusura `memo()` mancante — il file terminava con `}` invece di `});`
- **Soluzione**: Sostituito `}` con `});` alla riga 70 di `LightboxGalleria.jsx`
- **Sintomi**: LightboxGalleria.test.jsx (8 test) e CorpoDettaglio.test.jsx (16 test) non compilavano
- **Fixato in**: Task 40

### [22] CorpoDettaglio.test: import typo mockCorpoDettaglioDettaglio — 14/07/2026
- **Descrizione**: 14 test in CorpoDettaglio.test.jsx fallivano con `ReferenceError: mockCorpoDettaglio is not defined`
- **Causa**: Import da fixtures.js usava `mockCorpoDettaglioDettaglio` (doppio "Dettaglio") ma il test referenziava `mockCorpoDettaglio`
- **Soluzione**: Corretto import in `mockCorpoDettaglio`
- **Sintomi**: 14/17 test in CorpoDettaglio.test.jsx fallivano
- **Fixato in**: Task 40
