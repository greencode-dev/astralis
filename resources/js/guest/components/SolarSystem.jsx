import { useEffect, useMemo, useRef, useState } from "react";
import { Link } from "react-router-dom";

const CONTENT_SIZE = 900;

const ORBIT_MIN = 130;
const ORBIT_MAX = 500;
const ORBIT_STEP = (ORBIT_MAX - ORBIT_MIN) / 7;

const SOLAR_CENTER = { x: 450, y: 450 };

const planets = [
    {
        name: "Mercurio",
        slug: "mercurio",
        size: 25,
        orbit: ORBIT_MIN,
        color: "#94A3B8",
        speed: 1.2,
        img: "/images/solar-system/mercurio.png",
    },
    {
        name: "Venere",
        slug: "venere",
        size: 40,
        orbit: ORBIT_MIN + ORBIT_STEP,
        color: "#F97316",
        speed: 1.5,
        img: "/images/solar-system/venere.png",
    },
    {
        name: "Terra",
        slug: "terra",
        size: 45,
        orbit: ORBIT_MIN + ORBIT_STEP * 2,
        color: "#22D3EE",
        speed: 1.8,
        img: "/images/solar-system/terra.png",
    },
    {
        name: "Marte",
        slug: "marte",
        size: 35,
        orbit: ORBIT_MIN + ORBIT_STEP * 3,
        color: "#EF4444",
        speed: 2.5,
        img: "/images/solar-system/marte.png",
    },
    {
        name: "Giove",
        slug: "giove",
        size: 90,
        orbit: ORBIT_MIN + ORBIT_STEP * 4,
        color: "#FACC15",
        speed: 3,
        img: "/images/solar-system/giove.png",
    },
    {
        name: "Saturno",
        slug: "saturno",
        size: 85,
        orbit: ORBIT_MIN + ORBIT_STEP * 5,
        color: "#D4A373",
        speed: 3.5,
        img: "/images/solar-system/saturno.png",
    },
    {
        name: "Urano",
        slug: "urano",
        size: 55,
        orbit: ORBIT_MIN + ORBIT_STEP * 6,
        color: "#67E8F9",
        speed: 4,
        img: "/images/solar-system/urano.png",
    },
    {
        name: "Nettuno",
        slug: "nettuno",
        size: 55,
        orbit: ORBIT_MAX,
        color: "#3B82F6",
        speed: 5,
        img: "/images/solar-system/nettuno.png",
    },
];

function Planet({ planet, hovered }) {
    const divRef = useRef(null);
    const angleRef = useRef(Math.random() * 360);
    const lastTimeRef = useRef(null);
    const [imgError, setImgError] = useState(false);

    useEffect(() => {
        let rafId;
        const degreesPerSec = 360 / (planet.speed * 4);

        const tick = (time) => {
            if (lastTimeRef.current === null) lastTimeRef.current = time;
            const dt = (time - lastTimeRef.current) / 1000;
            lastTimeRef.current = time;

            const multiplier = hovered ? 0.11 : 0.33;
            angleRef.current =
                (angleRef.current + degreesPerSec * multiplier * dt) % 360;

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
            className="absolute group"
            style={{ left: -planet.size / 2, top: -planet.size / 2 }}
        >
            <Link
                to={`/corpi-celesti/${planet.slug}`}
                className="block planet-hover text-center"
                aria-label={planet.name}
            >
                {!imgError ? (
                    <img
                        src={planet.img}
                        alt={planet.name}
                        className="rounded-full object-contain"
                        style={{
                            width: planet.size,
                            height: planet.size,
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
                        }}
                    />
                )}
                <span
                    className="block mt-1 text-xs text-admin-muted opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none"
                    style={{
                        width: 50,
                        marginLeft: "auto",
                        marginRight: "auto",
                    }}
                >
                    {planet.name}
                </span>
            </Link>
        </div>
    );
}

export default function SolarSystem({ showStars = true }) {
    const containerRef = useRef(null);
    const [scale, setScale] = useState(1);
    const [hovered, setHovered] = useState(false);
    const stars = useMemo(
        () =>
            Array.from({ length: 50 }, (_, i) => ({
                id: i,
                width: Math.random() * 3 + 1,
                height: Math.random() * 3 + 1,
                left: `${Math.random() * 100}%`,
                top: `${Math.random() * 100}%`,
                duration: Math.random() * 3 + 2,
            })),
        [],
    );

    useEffect(() => {
        const el = containerRef.current;
        if (!el) return;
        const ro = new ResizeObserver((entries) => {
            const w = entries[0].contentRect.width;
            setScale(Math.min(1, w / CONTENT_SIZE));
        });
        ro.observe(el);
        return () => ro.disconnect();
    }, []);

    return (
        <div
            ref={containerRef}
            className="relative w-full max-w-[600px] ml-auto mr-0"
            style={{
                aspectRatio: "900 / 950",
                height: "auto",
                minHeight: "280px",
                maxHeight: "600px",
            }}
            role="img"
            aria-label="Sistema solare interattivo — clicca un corpo celeste per vederne il dettaglio"
            onMouseEnter={() => setHovered(true)}
            onMouseLeave={() => setHovered(false)}
        >
            {showStars && (
                <div
                    className="absolute inset-0 overflow-hidden"
                    aria-hidden="true"
                >
                    {stars.map((star) => (
                        <div
                            key={star.id}
                            className="absolute rounded-full bg-admin-text animate-twinkle"
                            style={{
                                width: star.width,
                                height: star.height,
                                left: star.left,
                                top: star.top,
                                "--twinkle-duration": `${star.duration}s`,
                            }}
                        />
                    ))}
                </div>
            )}

            <div
                className="absolute"
                style={{
                    width: CONTENT_SIZE,
                    height: CONTENT_SIZE,
                    left: "50%",
                    top: "50%",
                    transform: `translate(calc(-50% - 200px), -50%) scale(${scale})`,
                    transformOrigin: "center",
                }}
            >
                <Link
                    to="/corpi-celesti/sole"
                    className="absolute z-10 planet-hover group"
                    aria-label="Sole"
                    style={{
                        left: SOLAR_CENTER.x,
                        top: SOLAR_CENTER.y,
                        transform: "translate(-50%, -50%)",
                    }}
                >
                    <div className="animate-pulse-sun flex items-center justify-center">
                        <img
                            src="/images/solar-system/sole.png"
                            alt="Sole"
                            className="rounded-full object-contain"
                            style={{
                                width: 150,
                                height: 150,
                            }}
                        />
                    </div>
                    <div className="absolute left-1/2 -translate-x-1/2 top-full mt-1 text-center text-sm font-semibold text-admin-accent opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                        Sole
                    </div>
                </Link>

                <div className="absolute inset-0 z-[5] pointer-events-none">
                    <div
                        className="absolute pointer-events-auto"
                        style={{ left: SOLAR_CENTER.x, top: SOLAR_CENTER.y }}
                    >
                        {planets.map((planet) => (
                            <div
                                key={planet.name}
                                className="absolute rounded-full border border-admin-primary/25"
                                style={{
                                    width: planet.orbit * 2,
                                    height: planet.orbit * 2,
                                    left: -planet.orbit,
                                    top: -planet.orbit,
                                }}
                            />
                        ))}

                        {planets.map((planet) => (
                            <Planet
                                key={planet.name}
                                planet={planet}
                                hovered={hovered}
                            />
                        ))}
                    </div>
                </div>
            </div>
        </div>
    );
}
