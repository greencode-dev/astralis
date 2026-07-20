# Traccia vs Realizzato — Confronto Rapido

> Documento di sintesi: ogni requisito della traccia confrontato con ciò che è stato effettivamente costruito.

---

## Parte 1 — Backoffice in Laravel

### Autenticazione e Accesso

| Requisito traccia | Realizzato | Dettagli |
|---|---|---|
| Pannello protetto da autenticazione (Laravel Breeze) | ✅ | Breeze con Blade puro (Inertia rimosso). Route admin protette da middleware `auth`. Login, register, profilo, reset password — tutte con tema dark `#0A0A1A` |
| Accesso solo utenti autenticati | ✅ | Gate `admin` definito in `AuthServiceProvider`. 5 Policy (una per entità) con `before()` che bypassa tutto per `$user->is_admin` |

**Come è stato fatto**: Breeze installato con stack React, poi rimosso Inertia — il frontend guest è SPA standalone, l'admin è Blade puro. Le pagine auth usano il layout `guest.blade.php` con `x-guest-layout`.

---

### CRUD Entità Principale

| Requisito traccia | Realizzato | Dettagli |
|---|---|---|
| CRUD completo (C, R, U, D) | ✅ | 7 metodi per controller: index, create, store, show, edit, update, destroy |
| Almeno 2 entità con relazione 1-N o N-N | ✅ | 5 entità, 3 tipi di relazione |

**Entità implementate**:

| Entità | CRUD | Relazione | Campi chiave |
|---|---|---|---|
| **Categoria** | ✅ | 1-N → CorpoCeleste | nome, slug, icona, descrizione, colore |
| **CorpoCeleste** | ✅ | N-1 Categoria, 1-N Galleria, 1-N Curiosità, N-N Missioni | nome, nome_it, slug, immagine, descrizione, tipo, massa, diametro, gravità, temperatura, periodo orbitale, scopritore, anno scoperta, in evidenza, nasa_id |
| **Missione** | ✅ | N-N → CorpiCelesti (pivot: tipo_esplorazione, anno_arrivo) | nome, slug, logo, agenzia, data_lancio, durata_giorni, stato, descrizione, sito_web |
| **Curiosità** | ✅ | N-1 → CorpoCeleste | corpo_celeste_id, titolo, descrizione, fonte |
| **GalleriaCorpo** | ✅ | N-1 → CorpoCeleste | corpo_celeste_id, percorso, didascalia, crediti, ordine |

**Come è stato fatto**: Ogni entità ha Model + Migration + Factory + Policy + Controller + 4 viste Blade (index, create, edit, show). La relazione N-N usa la tabella pivot `corpo_celeste_missione` con dati extra (`tipo_esplorazione`, `anno_arrivo`).

---

### Upload Media

| Requisito traccia | Realizzato | Dettagli |
|---|---|---|
| Meccanica di upload file | ✅ | Intervention Image v4 con `scaleDown()` (preserva aspect ratio) |

**Upload implementati**:
- **Missioni**: logo ridimensionato a 300px, salvato in `storage/app/public/missioni/`
- **Galleria**: immagini ridimensionate a 1200px, salvate in `storage/app/public/galleria/`
- **Corpi Celesti**: URL remoto NASA (nessun upload locale — campo testo)

**Come è stato fatto**: `ImageUploadService` centralizza logica upload. `NasaImageService` gestisce import da NASA API salvando URL remoti (no download locale). In admin, `setImageFromGallery` permette di impostare un'immagine dalla galleria come immagine principale.

---

## Parte 2 — Sito Guest in React

### Lista Elementi

| Requisito traccia | Realizzato | Dettagli |
|---|---|---|
| Visualizzare la lista degli elementi | ✅ | `CorpiLista.jsx` — griglia card con filtri (categoria, tipo, ricerca testuale) e paginazione "Carica altri" |

**Come è stato fatto**: SPA React 18 standalone con Vite. Route `/corpi-celesti` gestita da react-router-dom. Dati fetchati via `apiClient.js` → `GET /api/corpi-celesti?categoria=...&tipo=...&search=...&page=N`. Paginazione client-side con infinite scroll.

---

### Dettaglio Singolo Elemento

| Requisito traccia | Realizzato | Dettagli |
|---|---|---|
| Vedere i dettagli di un singolo elemento | ✅ | `CorpoDettaglio.jsx` — metriche scientifiche, galleria lightbox, curiosità, missioni, simili |

**Come è stato fatto**: Route `/corpi-celesti/:slug` con route model binding slug. `GET /api/corpi-celesti/{slug}` restituisce il corpo con tutte le relazioni eager-loaded (galleria, curiosità, missioni, categoria). 8 card metriche scientifiche (massa, diametro, gravità, temperatura, etc).

---

### Informazioni Collegate

| Requisito traccia | Realizzato | Dettagli |
|---|---|---|
| Mostrare le informazioni collegate (categorie, relazioni) | ✅ | Badge categoria colorati, galleria lightbox, timeline missioni, sezione curiosità, corpi simili |

**Come è stato fatto**: Ogni corpo mostra: `CategoriaBadge` con colore unico per tipo, `LightboxGalleria` con immagini NASA a schermo intero, `TimelineMissioni` orizzontale con badge stato, elenco curiosità con fonte, sezione "Corpi Simili" (stessa categoria, max 4).

---

### API REST

| Requisito traccia | Realizzato | Dettagli |
|---|---|---|
| Creare endpoint API per recuperare i dati | ✅ | 10 endpoint JSON pubblici |

**Endpoint implementati**:

| Metodo | Endpoint | Uso |
|---|---|---|
| `GET` | `/api/corpi-celesti` | Lista filtrata (categoria, tipo, search, in_evidenza, per_page) |
| `GET` | `/api/corpi-celesti/{slug}` | Dettaglio con relazioni |
| `GET` | `/api/corpi-celesti/{slug}/simili` | Corpi simili (stessa categoria) |
| `GET` | `/api/categorie` | Lista categorie con conteggio |
| `GET` | `/api/categorie/{slug}` | Singola categoria con corpi |
| `GET` | `/api/missioni` | Lista missioni (filtri: agenzia, stato) |
| `GET` | `/api/missioni/{slug}` | Dettaglio missione |
| `GET` | `/api/curiosita` | Lista curiosità |
| `GET` | `/api/galleria` | Lista galleria ordinata |
| `GET` | `/api/dashboard/stats` | Statistiche generali |

**Come è stato fatto**: `routes/api.php` definisce le route. 6 controller API in `app/Http/Controllers/Api/`. 5 API Resources trasformano i modelli in JSON controllato (espongono solo i campi necessari al frontend). Eager loading su ogni endpoint per evitare N+1 query.

---

## Esempi Postman

### Esempio 1 — Homepage (stats + in evidenza)

**Step 1: Statistiche generali**

```
GET http://localhost:8000/api/dashboard/stats
```

Response 200:

```json
{
    "totale_corpi_celesti": 18,
    "totale_categorie": 8,
    "totale_missioni": 10,
    "corpi_in_evidenza": 6,
    "ultimi_corpi": [
        {
            "id": 18,
            "nome": "Plutone",
            "slug": "plutone",
            "categoria": "Pianeta Nano",
            "tipo": "Pianeta nano"
        },
        {
            "id": 17,
            "nome": "Nettuno",
            "slug": "nettuno",
            "categoria": "Pianeta",
            "tipo": "Gigante gassoso"
        }
    ],
    "missioni_per_stato": {
        "total": 10,
        "completate": 6,
        "in_corso": 2,
        "pianificate": 2
    }
}
```

**Step 2: Corpi in evidenza (hero griglia)**

```
GET http://localhost:8000/api/corpi-celesti?in_evidenza=1&per_page=6
```

Response 200 (estratto):

```json
{
    "data": [
        {
            "id": 1,
            "nome": "Terra",
            "nome_display": "Terra",
            "slug": "terra",
            "categoria": {
                "id": 1,
                "nome": "Pianeta",
                "slug": "pianeta",
                "colore": "#22D3EE"
            },
            "immagine_url": "https://images-assets.nasa.gov/image/PIA18033/PIA18033~medium.jpg",
            "descrizione": "La Terra è il terzo pianeta dal Sole...",
            "tipo": "Pianeta roccioso",
            "distanza_km": "149598023",
            "in_evidenza": true
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 1,
        "per_page": 6,
        "total": 6
    }
}
```

---

### Esempio 2 — Dettaglio Terra

```
GET http://localhost:8000/api/corpi-celesti/terra
```

Response 200 (estratto):

```json
{
    "data": {
        "id": 3,
        "nome": "Earth",
        "nome_display": "Terra",
        "slug": "terra",
        "categoria": {
            "id": 1,
            "nome": "Pianeta",
            "slug": "pianeta",
            "colore": "#22D3EE"
        },
        "immagine_url": "https://images-assets.nasa.gov/image/PIA18033/PIA18033~medium.jpg",
        "descrizione": "La Terra è il terzo pianeta dal Sole e l'unico conosciuto ad harbor forma di vita...",
        "tipo": "Pianeta roccioso",
        "distanza_km": "149598023",
        "in_evidenza": true,
        "massa_kg": "5.972 × 10²⁴",
        "diametro_km": "12.742",
        "gravita": "9.81",
        "temperatura": "15",
        "periodo_orbitale": "365.25",
        "scopritore": null,
        "anno_scoperta": null,
        "nasa_id": "PIA18033",
        "galleria": [
            {
                "id": 12,
                "percorso": "https://images-assets.nasa.gov/image/PIA18033/PIA18033~medium.jpg",
                "didascalia": "La Terra vista dallo spazio",
                "crediti": "NASA",
                "ordine": 1
            }
        ],
        "curiosita": [
            {
                "id": 5,
                "titolo": "L'acqua copre il 71%",
                "descrizione": "Oltre il 71% della superficie terrestre è coperto dall'acqua...",
                "fonte": "NASA"
            }
        ],
        "missioni": [
            {
                "id": 1,
                "nome": "Apollo 11",
                "slug": "apollo-11",
                "agenzia": "NASA",
                "stato": "Completata",
                "pivot": {
                    "tipo_esplorazione": "Atterraggio",
                    "anno_arrivo": 1969
                }
            }
        ]
    }
}
```

**Nota**: il campo `nome` contiene il nome inglese ("Earth"), `nome_display` contiene l'italiano ("Terra"). Il frontend usa sempre `nome_display`.

---

### Come testare su Postman

1. Avvia il backend: `php artisan serve` (porta 8000)
2. Crea una request GET in Postman
3. Inserisci l'URL: `http://localhost:8000/api/corpi-celesti`
4. Nessun token o autenticazione necessaria — le API sono pubbliche
5. Parametri query opzionali: `?categoria=pianeta&search=terra&in_evidenza=1&per_page=5`

---

## Extra — Oltre la Traccia

| Extra | Descrizione | Valore aggiunto |
|---|---|---|
| **NASA API Integration** | Import automatico immagini reali da `images-api.nasa.gov` con dedup, fallback apostrofi, auto-import su created | Dati reali, non fittizi |
| **Sistema Solare Animato** | 8 pianeti orbitanti con `requestAnimationFrame`, velocità differenziate, hover rallenta, immagini reali NASA | Wow factor visivo |
| **Comparatore Pianeti** | Confronto affiancato di 2 corpi su 7 metriche, pre-fill via URL params | Funzionalità interattiva |
| **Timeline Missioni** | Scrolling orizzontale con badge stato colorato (Completata/In corso/Pianificata) | Navigazione visiva |
| **Dashboard Chart.js** | 3 grafici interattivi donut/barre con tema dark | Analisi dati admin |
| **CLI Commands** | `astralis:fetch-nasa` e `astralis:gallery` per manutenzione | Automazione |
| **Error Boundary** | Fallback UI globale per crash React con icona AlertTriangle | Robustezza |
| **SEO** | `document.title` dinamico su 5 pagine React | Discoverabilità |
| **377 Test** | 267 PHPUnit + 110 Vitest, Http::fake(), observer skip | Qualità codice |
| **WordMapService** | Traduzione italiano → inglese per ricerca NASA (~70 termini) | UX admin |
| **Responsive** | Navbar mobile, SolarSystem responsive scaling, griglia adattiva | Accessibilità |

---

_Generato il 20/07/2026 — Astralis_
