import { motion, useMotionValue, useTransform, animate } from 'framer-motion';
import { useEffect, useMemo, useState } from 'react';
import { Link } from 'react-router-dom';

const planets = [
    { name: 'Mercurio', slug: 'mercurio', size: 8, orbit: 50, color: '#94A3B8', speed: 1.2, img: 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4a/Mercury_in_true_color.jpg/220px-Mercury_in_true_color.jpg' },
    { name: 'Venere', slug: 'venere', size: 12, orbit: 70, color: '#F97316', speed: 1.5, img: 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/08/Venus_from_Mariner_10.jpg/220px-Venus_from_Mariner_10.jpg' },
    { name: 'Terra', slug: 'terra', size: 14, orbit: 90, color: '#22D3EE', speed: 1.8, img: 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cb/The_Blue_Marble_%28remastered%29.jpg/220px-The_Blue_Marble_%28remastered%29.jpg' },
    { name: 'Marte', slug: 'marte', size: 10, orbit: 110, color: '#EF4444', speed: 2.5, img: 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/02/OSIRIS_Mars_true_color.jpg/220px-OSIRIS_Mars_true_color.jpg' },
    { name: 'Giove', slug: 'giove', size: 22, orbit: 140, color: '#FACC15', speed: 3, img: 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Jupiter_New_Horizons.jpg/220px-Jupiter_New_Horizons.jpg' },
    { name: 'Saturno', slug: 'saturno', size: 18, orbit: 170, color: '#D4A373', speed: 3.5, img: 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c7/Saturn_during_Equinox.jpg/220px-Saturn_during_Equinox.jpg' },
    { name: 'Urano', slug: 'urano', size: 14, orbit: 200, color: '#67E8F9', speed: 4, img: 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c9/Uranus_as_seen_by_NASA%27s_Voyager_2_%28remastered%29.png/220px-Uranus_as_seen_by_NASA%27s_Voyager_2_%28remastered%29.png' },
    { name: 'Nettuno', slug: 'nettuno', size: 14, orbit: 230, color: '#3B82F6', speed: 5, img: 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b9/Neptune_Voyager2_color_calibrated.png/220px-Neptune_Voyager2_color_calibrated.png' },
];

function Planet({ planet }) {
    const angle = useMotionValue(0);
    const [imgError, setImgError] = useState(false);

    useEffect(() => {
        const controls = animate(angle, 360, {
            duration: planet.speed * 4,
            repeat: Infinity,
            ease: 'linear',
        });
        return controls.stop;
    }, []);

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
            <Link to={`/corpi-celesti/${planet.slug}`} className="block planet-hover" aria-label={planet.name}>
                {!imgError ? (
                    <img
                        src={planet.img}
                        alt={planet.name}
                        className="rounded-full object-cover"
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
            <div
                className="absolute text-xs text-admin-muted left-1/2 -translate-x-1/2 text-center pointer-events-none"
                style={{
                    top: planet.size + 4,
                    width: 50,
                }}
            >
                {planet.name}
            </div>
        </motion.div>
    );
}

export default function SolarSystem() {
    const stars = useMemo(() => Array.from({ length: 50 }, (_, i) => ({
        id: i,
        width: Math.random() * 3 + 1,
        height: Math.random() * 3 + 1,
        left: `${Math.random() * 100}%`,
        top: `${Math.random() * 100}%`,
        duration: Math.random() * 3 + 2,
    })), []);

    return (
        <div className="relative flex items-center justify-center min-h-[500px]" role="img" aria-label="Sistema solare interattivo — clicca un pianeta per vederne il dettaglio">
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
                            '--tw-duration': `${star.duration}s`,
                        }}
                    />
                ))}
            </div>

            <div className="absolute z-10">
                <div
                    className="rounded-full bg-admin-accent animate-pulse-sun"
                    style={{
                        width: 60,
                        height: 60,
                        boxShadow: '0 0 60px rgba(249, 115, 22, 0.6), 0 0 120px rgba(249, 115, 22, 0.3)',
                    }}
                />
                <div className="text-center mt-2 text-sm font-semibold text-admin-accent">
                    Sole
                </div>
            </div>

            <div className="absolute z-[5]">
                {planets.map(planet => (
                    <div
                        key={planet.name}
                        className="absolute rounded-full border border-admin-primary/8"
                        style={{
                            width: planet.orbit * 2,
                            height: planet.orbit * 2,
                            left: -planet.orbit,
                            top: -planet.orbit,
                        }}
                    />
                ))}

                {planets.map(planet => (
                    <Planet key={planet.name} planet={planet} />
                ))}
            </div>
        </div>
    );
}
