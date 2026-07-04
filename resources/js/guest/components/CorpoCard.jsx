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
            className="block rounded-xl overflow-hidden transition-all duration-300"
            style={{ backgroundColor: '#111128', border: '1px solid rgba(34, 211, 238, 0.1)' }}
            onMouseEnter={e => {
                e.currentTarget.style.borderColor = 'rgba(34, 211, 238, 0.4)';
                e.currentTarget.style.transform = 'translateY(-2px)';
                e.currentTarget.style.boxShadow = '0 8px 30px rgba(34, 211, 238, 0.1)';
            }}
            onMouseLeave={e => {
                e.currentTarget.style.borderColor = 'rgba(34, 211, 238, 0.1)';
                e.currentTarget.style.transform = 'translateY(0)';
                e.currentTarget.style.boxShadow = 'none';
            }}
        >
            {hasImage ? (
                <div className="aspect-[16/9] overflow-hidden">
                    <img loading="lazy"
                        src={corpo.immagine_url}
                        alt={corpo.nome_display || corpo.nome}
                        className="w-full h-full object-cover transition-transform duration-300"
                        onMouseEnter={e => e.currentTarget.style.transform = 'scale(1.05)'}
                        onMouseLeave={e => e.currentTarget.style.transform = 'scale(1)'}
                    />
                </div>
            ) : (
                <div
                    className="aspect-[16/9] flex items-center justify-center transition-transform duration-300"
                    style={{ background: gradient }}
                    onMouseEnter={e => e.currentTarget.style.transform = 'scale(1.02)'}
                    onMouseLeave={e => e.currentTarget.style.transform = 'scale(1)'}
                >
                    <FallbackIcon size={56} style={{ color: 'rgba(255,255,255,0.6)' }} />
                </div>
            )}

            <div className="p-4">
                <div className="flex items-start justify-between gap-2 mb-2">
                    <h3 className="text-lg font-semibold" style={{ color: '#F0F0FA' }}>
                        {corpo.nome_display || corpo.nome}
                    </h3>
                    {corpo.in_evidenza && (
                        <span className="text-xs font-bold px-2 py-0.5 rounded" style={{ backgroundColor: 'rgba(250, 204, 21, 0.15)', color: '#FACC15' }}>
                            ★ In evidenza
                        </span>
                    )}
                </div>

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