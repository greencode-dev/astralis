---
name: astralis-react-spa
description: Pattern frontend React SPA per Astralis — routing, API fetch, animazioni, galleria. Usa questa skill quando lavori su pagine guest React, componenti, route, chiamate API, animazioni o galleria immagini.
---

# Astralis React SPA Patterns

Guest frontend è una React SPA standalone in `resources/js/guest/`. Entry point: `main.jsx`.

## Tech Stack

- React 19
- Vite
- framer-motion (animazioni)
- react-router-dom v7 (routing)
- lucide-react (icone)
- yet-another-react-lightbox (galleria immagini)

## Routes

| Path | Component | Descrizione |
|---|---|---|
| `/` | HomePage | Landing page con esplorazione |
| `/corpi-celesti` | CorpiCelestiPage | Catalogo con filtri |
| `/corpi-celesti/:slug` | CorpoCelesteDetail | Dettaglio singolo corpo |
| `/confronta` | ConfrontaPage | Comparazione |
| `/*` | NotFound | 404 custom |

## API Calls

10 endpoint JSON pubblici in `routes/api.php`. Chiamate con `fetch` standard o axios.

```jsx
const BASE_URL = '/api';

async function fetchCorpiCelesti(filters) {
  const params = new URLSearchParams(filters);
  const res = await fetch(`${BASE_URL}/corpi-celesti?${params}`);
  return res.json();
}
```

## Animazioni (framer-motion)

Pattern comune per animazioni di entrata:

```jsx
import { motion } from 'framer-motion';

<motion.div
  initial={{ opacity: 0, y: 20 }}
  animate={{ opacity: 1, y: 0 }}
  transition={{ duration: 0.5 }}
>
  {children}
</motion.div>
```

Per staggered children usare `staggerChildren` con `variants`.

## Lightbox (yet-another-react-lightbox)

```jsx
import Lightbox from 'yet-another-react-lightbox';
import 'yet-another-react-lightbox/styles.css';

const [open, setOpen] = useState(false);
const [index, setIndex] = useState(0);

<Lightbox
  open={open}
  close={() => setOpen(false)}
  index={index}
  slides={images.map(src => ({ src }))}
/>
```

## Struttura Directory

```
resources/js/guest/
├── main.jsx          # Entry point, router setup
├── components/       # Componenti riutilizzabili
├── pages/            # Route pages
├── hooks/            # Custom hooks
└── styles/           # CSS modules / global styles
```
