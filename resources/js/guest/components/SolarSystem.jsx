import { motion, useMotionValue, useTransform, animate } from 'framer-motion';
import { useEffect, useMemo } from 'react';

const planets = [
    { name: 'Mercurio', size: 8, orbit: 50, color: '#94A3B8', speed: 1.2 },
    { name: 'Venere', size: 12, orbit: 70, color: '#F97316', speed: 1.5 },
    { name: 'Terra', size: 14, orbit: 90, color: '#22D3EE', speed: 1.8 },
    { name: 'Marte', size: 10, orbit: 110, color: '#EF4444', speed: 2.5 },
    { name: 'Giove', size: 22, orbit: 140, color: '#FACC15', speed: 3 },
    { name: 'Saturno', size: 18, orbit: 170, color: '#D4A373', speed: 3.5 },
    { name: 'Urano', size: 14, orbit: 200, color: '#67E8F9', speed: 4 },
    { name: 'Nettuno', size: 14, orbit: 230, color: '#3B82F6', speed: 5 },
];

function Planet({ planet }) {
    const angle = useMotionValue(0);

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
            <motion.div
                className="rounded-full"
                style={{
                    width: planet.size,
                    height: planet.size,
                    backgroundColor: planet.color,
                    boxShadow: `0 0 15px ${planet.color}40`,
                }}
                whileHover={{ scale: 1.5 }}
            />
            <div
                className="absolute text-xs text-admin-muted left-1/2 -translate-x-1/2 text-center"
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
        opacity: Math.random() * 0.5 + 0.3,
        duration: Math.random() * 3 + 2,
    })), []);

    return (
        <div className="relative flex items-center justify-center min-h-[500px]" aria-hidden="true">
            <div className="absolute inset-0 overflow-hidden">
                {stars.map(star => (
                    <motion.div
                        key={star.id}
                        className="absolute rounded-full"
                        style={{
                            width: star.width,
                            height: star.height,
                            backgroundColor: '#F0F0FA',
                            left: star.left,
                            top: star.top,
                            opacity: star.opacity,
                        }}
                        animate={{ opacity: [0.3, 0.8, 0.3] }}
                        transition={{
                            duration: star.duration,
                            repeat: Infinity,
                            ease: 'easeInOut',
                        }}
                    />
                ))}
            </div>

            <div className="absolute z-10">
                <motion.div
                    className="rounded-full bg-admin-accent"
                    style={{
                        width: 60,
                        height: 60,
                        boxShadow: '0 0 60px rgba(249, 115, 22, 0.6), 0 0 120px rgba(249, 115, 22, 0.3)',
                    }}
                    animate={{ scale: [1, 1.05, 1] }}
                    transition={{ duration: 3, repeat: Infinity, ease: 'easeInOut' }}
                />
                <div className="text-center mt-2 text-sm font-semibold text-admin-accent">
                    Sole
                </div>
            </div>

            <div className="absolute z-5">
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
