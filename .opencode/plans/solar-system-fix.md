# Solar System Fix — Piano dettagliato

> Sessione: 18/07/2026 — da riprendere qui

## Stato attuale

- **Branch**: `master`, 377 test (267 PHPUnit + 110 Vitest), tutti verdi
- **Immagini**: 9 immagini reali in `public/images/solar-system/` (tutte quadrate, croppate)
- **SolarSystem.jsx**: usa framer-motion `animate()` per orbite — **rotazione non continua (salta)**
- **boxShadow**: presente su tutti e 9 i corpi — **crea alone semitrasparente visibile**

## Problemi da risolvere

### Bug 1: Alone semitrasparente ("contenitore ovale")
Ogni pianeta/Sole ha un `boxShadow` colorato che crea un alone visibile:
```jsx
// Pianeti (riga 60 attuale)
boxShadow: `0 0 15px ${planet.color}40`  // 25% opacity

// Sole (riga 133 attuale)
boxShadow: '0 0 60px rgba(249, 115, 22, 0.6), 0 0 120px rgba(249, 115, 22, 0.3)'
```
**Fix**: Rimuovere entrambi i `boxShadow`.

### Bug 2: Rotazione non continua (pianeti saltano)
Causa: `from: angleRef.current % 360` con `repeat: Infinity` in framer-motion.
Il loop va da `from` a `to` (es. 150° → 360°), poi **salta indietro** a `from` (150°).
Il pianeta copre solo ~210° dell'orbita, poi torna indietro.

**Fix**: Riscrivere `Planet` con `requestAnimationFrame` + direct DOM manipulation:
- Angolo cresce **infinitamente** (nessun reset)
- Angolo iniziale casuale per ogni pianeta
- Hover rallenta a 0.33× **senza restart**
- Zero re-render React durante animazione (uso diretto `divRef.current.style.transform`)

## Modifiche da applicare

### File: `resources/js/guest/components/SolarSystem.jsx`

#### 1. Rimuovere import framer-motion (riga 1)
```diff
- import { motion, useMotionValue, useTransform, animate } from 'framer-motion';
+ // Nessun import framer-motion necessario
```

#### 2. Riscrivere componente `Planet` (righe 16-88)
Nuova implementazione:
```jsx
function Planet({ planet, hovered }) {
    const divRef = useRef(null);
    const angleRef = useRef(Math.random() * 360); // angolo casuale iniziale
    const lastTimeRef = useRef(null);
    const [imgError, setImgError] = useState(false);

    useEffect(() => {
        let rafId;
        const degreesPerSec = 360 / (planet.speed * 4);

        const tick = (time) => {
            if (lastTimeRef.current === null) lastTimeRef.current = time;
            const dt = (time - lastTimeRef.current) / 1000;
            lastTimeRef.current = time;

            const multiplier = hovered ? 0.33 : 1;
            angleRef.current = (angleRef.current + degreesPerSec * multiplier * dt) % 360;

            const rad = (angleRef.current * Math.PI) / 180;
            const x = Math.sin(rad) * planet.orbit;
            const y = -Math.cos(rad) * planet.orbit;

            if (divRef.current) {
                divRef.current.style.transform = `translate(${x}px, ${y}px)`;
            }

            rafId = requestAnimationFrame(tick);
        };

        rafId = requestAnimationFrame(tick);
        return () => cancelAnimationFrame(rafId);
    }, [hovered, planet.speed, planet.orbit]);

    return (
        <div
            ref={divRef}
            className="absolute"
            style={{ left: -planet.size / 2, top: -planet.size / 2 }}
        >
            <div className="relative">
                <Link to={`/corpi-celesti/${planet.slug}`} className="block planet-hover" aria-label={planet.name}>
                    {!imgError ? (
                        <img
                            src={planet.img}
                            alt={planet.name}
                            className="rounded-full object-contain"
                            style={{
                                width: planet.size,
                                height: planet.size,
                                // NESSUN boxShadow
                            }}
                            onError={() => setImgError(true)}
                            loading="lazy"
                        />
                    ) : (
                        <div
                            className="rounded-full"
                            style={{
                                width: planet.size,
                                height: planet.size,
                                backgroundColor: planet.color,
                                // NESSUN boxShadow
                            }}
                        />
                    )}
                </Link>
                <Link
                    to={`/corpi-celesti/${planet.slug}`}
                    className="absolute left-1/2 -translate-x-1/2 text-xs text-admin-muted hover:text-admin-primary transition-colors text-center pointer-events-auto"
                    style={{ top: planet.size + 4, width: 50 }}
                    aria-label={`Dettaglio ${planet.name}`}
                >
                    {planet.name}
                </Link>
            </div>
        </div>
    );
}
```

#### 3. Rimuovere boxShadow dal Sole (riga 133)
```diff
- boxShadow: '0 0 60px rgba(249, 115, 22, 0.6), 0 0 120px rgba(249, 115, 22, 0.3)',
+ // NESSUN boxShadow
```

#### 4. Mantenere invariato
- Array `planets` (size, orbit, color, speed, img) — righe 5-14
- Anelli orbitali (righe 142-152) — **mantenuti**
- Sole `img` tag e label — righe 125-139
- Stars background — righe 109-123
- Container `min-h-[620px]` — riga 103

### File: `resources/js/guest/test/SolarSystem.test.jsx`

**Nessuna modifica necessaria** — i test verificano:
- Rendering (✅ invariato)
- Nome Sole (✅ invariato)
- 8 nomi pianeti (✅ invariato)
- 8 orbit rings (✅ mantenuti)
- 17 link totali (✅ invariato)
- Link href (✅ invariato)

## Verifica

1. `npx vitest run resources/js/guest/test/SolarSystem.test.jsx` — 7/7 test
2. `npx vite build` — build green
3. Controllare manualmente che:
   - Nessun alone semitrasparente attorno ai pianeti
   - Rotazione continua e fluida (nessun salto)
   - Hover rallenta i pianeti smooth
   - Anelli orbitali visibili
   - Sole visibile senza alone

## Dati tecnici

- **Array planets**: size 20-48, orbit 65-280, speed 1.2-5
- **Container**: `min-h-[620px]`
- **Sole**: 90×90px, `object-contain animate-pulse-sun`
- **Pianeti**: `rounded-full object-contain`
- **Orbit rings**: `border border-admin-primary/15` (15% opacity cyan)
- **Planet-hover CSS**: `transition: transform 0.2s ease; &:hover { transform: scale(1.5); }`
- **Test**: 7 test in `SolarSystem.test.jsx`
