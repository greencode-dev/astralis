import { motion } from 'framer-motion';

const planets = [
    { name: 'Mercurio', size: 8, orbit: 50, color: '#94A3B8', speed: 4 },
    { name: 'Venere', size: 12, orbit: 70, color: '#F97316', speed: 3.5 },
    { name: 'Terra', size: 14, orbit: 90, color: '#22D3EE', speed: 3 },
    { name: 'Marte', size: 10, orbit: 110, color: '#EF4444', speed: 2.5 },
    { name: 'Giove', size: 22, orbit: 140, color: '#FACC15', speed: 2 },
    { name: 'Saturno', size: 18, orbit: 170, color: '#D4A373', speed: 1.8 },
    { name: 'Urano', size: 14, orbit: 200, color: '#67E8F9', speed: 1.5 },
    { name: 'Nettuno', size: 14, orbit: 230, color: '#3B82F6', speed: 1.2 },
];

export default function SolarSystem() {
    return (
        <div className="relative flex items-center justify-center" style={{ minHeight: '500px' }}>
            {/* Stelle sfondo */}
            <div className="absolute inset-0 overflow-hidden">
                {Array.from({ length: 50 }).map((_, i) => (
                    <motion.div
                        key={i}
                        className="absolute rounded-full"
                        style={{
                            width: Math.random() * 3 + 1,
                            height: Math.random() * 3 + 1,
                            backgroundColor: '#F0F0FA',
                            left: `${Math.random() * 100}%`,
                            top: `${Math.random() * 100}%`,
                            opacity: Math.random() * 0.5 + 0.3,
                        }}
                        animate={{ opacity: [0.3, 0.8, 0.3] }}
                        transition={{
                            duration: Math.random() * 3 + 2,
                            repeat: Infinity,
                            ease: 'easeInOut',
                        }}
                    />
                ))}
            </div>

            {/* Sole */}
            <div className="absolute" style={{ zIndex: 10 }}>
                <motion.div
                    className="rounded-full"
                    style={{
                        width: 60,
                        height: 60,
                        backgroundColor: '#F97316',
                        boxShadow: '0 0 60px rgba(249, 115, 22, 0.6), 0 0 120px rgba(249, 115, 22, 0.3)',
                    }}
                    animate={{ scale: [1, 1.05, 1] }}
                    transition={{ duration: 3, repeat: Infinity, ease: 'easeInOut' }}
                />
                <div className="text-center mt-2 text-sm font-semibold" style={{ color: '#F97316' }}>
                    Sole
                </div>
            </div>

            {/* Orbite e pianeti */}
            {planets.map((planet, index) => (
                <div key={planet.name} className="absolute" style={{ zIndex: 5 }}>
                    {/* Cerchio orbita */}
                    <div
                        className="absolute rounded-full"
                        style={{
                            width: planet.orbit * 2,
                            height: planet.orbit * 2,
                            border: '1px solid rgba(34, 211, 238, 0.08)',
                            left: -planet.orbit,
                            top: -planet.orbit,
                        }}
                    />

                    {/* Pianeta in orbita (con etichetta solidale) */}
                    <motion.div
                        className="absolute"
                        style={{
                            width: planet.size,
                            height: planet.size + 20,
                            left: -planet.size / 2,
                            top: -planet.orbit - planet.size / 2 - 20,
                            transformOrigin: `${planet.size / 2}px ${planet.orbit + planet.size / 2}px`,
                        }}
                        animate={{ rotate: 360 }}
                        transition={{
                            duration: planet.speed * 4,
                            repeat: Infinity,
                            ease: 'linear',
                        }}
                    >
                        {/* Pallino pianeta */}
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
                        {/* Etichetta (contro-rotante per restare leggibile) */}
                        <motion.div
                            className="absolute text-xs"
                            style={{
                                color: '#7A7A9A',
                                left: -12,
                                top: planet.size + 4,
                                width: 24,
                                textAlign: 'center',
                            }}
                            animate={{ rotate: -360 }}
                            transition={{
                                duration: planet.speed * 4,
                                repeat: Infinity,
                                ease: 'linear',
                            }}
                        >
                            {planet.name}
                        </motion.div>
                    </motion.div>
                </div>
            ))}
        </div>
    );
}