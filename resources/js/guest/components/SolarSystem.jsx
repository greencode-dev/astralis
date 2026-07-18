import { motion, useMotionValue, useTransform, animate } from 'framer-motion';
import { useEffect, useMemo, useRef, useState } from 'react';
import { Link } from 'react-router-dom';

const planets = [
    { name: 'Mercurio', slug: 'mercurio', size: 20, orbit: 65, color: '#94A3B8', speed: 1.2, img: '/images/solar-system/mercurio.jpg' },
    { name: 'Venere', slug: 'venere', size: 26, orbit: 88, color: '#F97316', speed: 1.5, img: '/images/solar-system/venere.jpg' },
    { name: 'Terra', slug: 'terra', size: 30, orbit: 115, color: '#22D3EE', speed: 1.8, img: '/images/solar-system/terra.jpg' },
    { name: 'Marte', slug: 'marte', size: 24, orbit: 142, color: '#EF4444', speed: 2.5, img: '/images/solar-system/marte.jpg' },
    { name: 'Giove', slug: 'giove', size: 48, orbit: 185, color: '#FACC15', speed: 3, img: '/images/solar-system/giove.jpg' },
    { name: 'Saturno', slug: 'saturno', size: 42, orbit: 220, color: '#D4A373', speed: 3.5, img: '/images/solar-system/saturno.jpg' },
    { name: 'Urano', slug: 'urano', size: 34, orbit: 250, color: '#67E8F9', speed: 4, img: '/images/solar-system/urano.jpg' },
    { name: 'Nettuno', slug: 'nettuno', size: 34, orbit: 280, color: '#3B82F6', speed: 5, img: '/images/solar-system/nettuno.jpg' },
];

function Planet({ planet, hovered }) {
    const angle = useMotionValue(0);
    const angleRef = useRef(0);
    const [imgError, setImgError] = useState(false);

    useEffect(() => {
        const unsubscribe = angle.on('change', v => { angleRef.current = v; });
        return unsubscribe;
    }, [angle]);

    useEffect(() => {
        const controls = animate(angle, 360, {
            duration: planet.speed * 4 * (hovered ? 3 : 1),
            repeat: Infinity,
            ease: 'linear',
            from: angleRef.current % 360,
        });
        return controls.stop;
    }, [hovered]);

    const rad = useTransform(angle, a => (a * Math.PI) / 180);
    const x = useTransform(rad, r => Math.sin(r) * planet.orbit);
    const y = useTransform(rad, r => -Math.cos(r) * planet.orbit);

    return (
        <motion.div
            className="absolute"
            style={{
                x,
                y,
                left: -planet.size / 2,
                top: -planet.size / 2,
            }}
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
                                boxShadow: `0 0 15px ${planet.color}40`,
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
                                boxShadow: `0 0 15px ${planet.color}40`,
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
        </motion.div>
    );
}

export default function SolarSystem() {
    const [hovered, setHovered] = useState(false);
    const stars = useMemo(() => Array.from({ length: 50 }, (_, i) => ({
        id: i,
        width: Math.random() * 3 + 1,
        height: Math.random() * 3 + 1,
        left: `${Math.random() * 100}%`,
        top: `${Math.random() * 100}%`,
        duration: Math.random() * 3 + 2,
    })), []);

    return (
        <div
            className="relative flex items-center justify-center min-h-[620px]"
            role="img"
            aria-label="Sistema solare interattivo — clicca un corpo celeste per vederne il dettaglio"
            onMouseEnter={() => setHovered(true)}
            onMouseLeave={() => setHovered(false)}
        >
            <div className="absolute inset-0 overflow-hidden" aria-hidden="true">
                {stars.map(star => (
                    <div
                        key={star.id}
                        className="absolute rounded-full bg-admin-text animate-twinkle"
                        style={{
                            width: star.width,
                            height: star.height,
                            left: star.left,
                            top: star.top,
                            '--twinkle-duration': `${star.duration}s`,
                        }}
                    />
                ))}
            </div>

            <Link to="/corpi-celesti/sole" className="absolute z-10 planet-hover" aria-label="Sole">
                <img
                    src="/images/solar-system/sole.jpg"
                    alt="Sole"
                    className="rounded-full object-contain animate-pulse-sun"
                    style={{
                        width: 90,
                        height: 90,
                        boxShadow: '0 0 60px rgba(249, 115, 22, 0.6), 0 0 120px rgba(249, 115, 22, 0.3)',
                    }}
                />
                <div className="text-center mt-2 text-sm font-semibold text-admin-accent">
                    Sole
                </div>
            </Link>

            <div className="absolute z-[5]">
                {planets.map(planet => (
                    <div
                        key={planet.name}
                        className="absolute rounded-full border border-admin-primary/15"
                        style={{
                            width: planet.orbit * 2,
                            height: planet.orbit * 2,
                            left: -planet.orbit,
                            top: -planet.orbit,
                        }}
                    />
                ))}

                {planets.map(planet => (
                    <Planet key={planet.name} planet={planet} hovered={hovered} />
                ))}
            </div>
        </div>
    );
}
