import { Link } from 'react-router-dom';
import { Globe, Sun, Moon, Star, Stars, Sparkles, Orbit, Asterisk } from 'lucide-react';
import CategoriaBadge from './CategoriaBadge';

const categoryIcons = {
    'Pianeta': Globe,
    'Stella': Sun,
    'Luna': Moon,
    'Galassia': Stars,
    'Nebulosa': Sparkles,
    'Asteroide': Asterisk,
    'Cometa': Star,
    'Pianeta Nano': Orbit,
};

const categoryGradients = {
    'Pianeta': 'linear-gradient(135deg, #0EA5E9, #06B6D4)',
    'Stella': 'linear-gradient(135deg, #F97316, #FB923C)',
    'Luna': 'linear-gradient(135deg, #64748B, #94A3B8)',
    'Galassia': 'linear-gradient(135deg, #7C3AED, #A855F7)',
    'Nebulosa': 'linear-gradient(135deg, #DB2777, #F472B6)',
    'Asteroide': 'linear-gradient(135deg, #57534E, #78716C)',
    'Cometa': 'linear-gradient(135deg, #16A34A, #22C55E)',
    'Pianeta Nano': 'linear-gradient(135deg, #4B5563, #6B7280)',
};

export default function CorpoCard({ corpo }) {
    const hasImage = corpo.immagine_url;
    const FallbackIcon = categoryIcons[corpo.categoria?.nome] || Orbit;
    const gradient = categoryGradients[corpo.categoria?.nome] || 'linear-gradient(135deg, #4B5563, #6B7280)';

    return (
        <Link
            to={`/corpi-celesti/${corpo.slug}`}
            className="block rounded-xl overflow-hidden transition-all duration-300 hover:border-[rgba(34,211,238,0.4)] hover:-translate-y-0.5 hover:shadow-[0_8px_30px_rgba(34,211,238,0.1)]"
            style={{ backgroundColor: '#111128', border: '1px solid rgba(34, 211, 238, 0.1)' }}
        >
            {hasImage ? (
                <div className="aspect-[16/9] relative">
                    <img loading="lazy"
                        src={corpo.immagine_url}
                        alt={corpo.nome_display || corpo.nome}
                        className="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                    />
                    {corpo.in_evidenza && (
                        <span className="absolute right-3 top-3 z-10 text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap shadow-lg" style={{ backgroundColor: 'rgba(250, 204, 21, 0.9)', color: '#1A1A2E' }}>
                            ★ In evidenza
                        </span>
                    )}
                </div>
            ) : (
                <div
                    className="aspect-[16/9] flex items-center justify-center transition-transform duration-300 relative hover:scale-105"
                    style={{ background: gradient }}
                    role="img"
                    aria-label={corpo.categoria?.nome + ' — ' + (corpo.nome_display || corpo.nome)}
                >
                    <FallbackIcon size={56} style={{ color: 'rgba(255,255,255,0.6)' }} aria-hidden="true" />
                    {corpo.in_evidenza && (
                        <span className="absolute right-3 top-3 z-10 text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap shadow-lg" style={{ backgroundColor: 'rgba(250, 204, 21, 0.9)', color: '#1A1A2E' }}>
                            ★ In evidenza
                        </span>
                    )}
                </div>
            )}

            <div className="p-4">
                <h3 className="text-lg font-semibold mb-2" style={{ color: '#F0F0FA' }}>
                    {corpo.nome_display || corpo.nome}
                </h3>

                <div className="mb-3">
                    <CategoriaBadge categoria={corpo.categoria} />
                </div>

                <p className="text-sm leading-relaxed line-clamp-2" style={{ color: '#B8B8D0' }}>
                    {corpo.descrizione}
                </p>

                <div className="mt-3 flex items-center gap-3 text-xs" style={{ color: '#7A7A9A' }}>
                    {corpo.tipo && (
                        <span>{corpo.tipo}</span>
                    )}
                    {corpo.distanza_km && (
                        <span>{formatDistance(corpo.distanza_km)}</span>
                    )}
                </div>
            </div>
        </Link>
    );
}

function formatDistance(km) {
    const num = parseFloat(km);
    if (num >= 1_000_000_000) return `${(num / 1_000_000_000).toFixed(1)} Mld km`;
    if (num >= 1_000_000) return `${(num / 1_000_000).toFixed(1)} Mln km`;
    if (num >= 1_000) return `${(num / 1_000).toFixed(1)} Mila km`;
    return `${num} km`;
}