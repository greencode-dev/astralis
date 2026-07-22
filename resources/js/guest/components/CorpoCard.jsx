// Componente: card corpo celeste con immagine, nome, categoria, tipo. Memoizzato con React.memo
import { useState, memo } from 'react';
import { Link } from 'react-router-dom';
import { Orbit } from 'lucide-react';
import { categoryIcons, categoryGradients } from '../constants';
import { formatDistance } from '../utils';
import CategoriaBadge from './CategoriaBadge';
import LazyImage from './LazyImage';

// memo: previene re-render se props non cambiano
export default memo(function CorpoCard({ corpo, fetchPriority }) {
  // State: imgError per fallback, FallbackIcon da constants, gradient da constants
  const [imgError, setImgError] = useState(false);
    const showImage = !!corpo.immagine_url && !imgError;
    const FallbackIcon = categoryIcons[corpo.categoria?.nome] || Orbit;
    const gradient = categoryGradients[corpo.categoria?.nome] || 'linear-gradient(135deg, var(--color-admin-bg), var(--color-admin-neutral))';

    return (
        // Link: card cliccabile, hover effetto ombra + translate
        <Link
            to={`/corpi-celesti/${corpo.slug}`}
            className="block rounded-xl overflow-hidden transition-all duration-300 hover:border-admin-primary/40 hover:-translate-y-0.5 hover:shadow-[0_8px_30px_var(--color-admin-shadow-primary)] bg-admin-card border border-admin-primary/10"
        >
            {showImage ? (
                // Con immagine: aspect 16/9, LazyImage + badge in_evidenza
                <div className="aspect-[16/9] relative">
                    <LazyImage
                        src={corpo.immagine_url}
                        alt={corpo.nome}
                        fetchPriority={fetchPriority}
                        width={16}
                        height={9}
                        className="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                        onError={() => setImgError(true)}
                    />
                    {corpo.in_evidenza && (
                        <span className="absolute right-3 top-3 z-10 text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap shadow-lg bg-admin-warning/90 text-admin-text-on-warning">
                            ★ In evidenza
                        </span>
                    )}
                </div>
            ) : (
                // Senza immagine: gradiente categoria + icona fallback + badge
                <div
                    className="aspect-[16/9] flex items-center justify-center transition-transform duration-300 relative hover:scale-105"
                    style={{ background: gradient }}
                    role="img"
                    aria-label={corpo.categoria?.nome + ' — ' + (corpo.nome)}
                >
                    <FallbackIcon size={56} className="text-white/60" aria-hidden="true" />
                    {corpo.in_evidenza && (
                        <span className="absolute right-3 top-3 z-10 text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap shadow-lg bg-admin-warning/90 text-admin-text-on-warning">
                            ★ In evidenza
                        </span>
                    )}
                </div>
            )}

            {/* Testo: nome, CategoriaBadge, descrizione troncata (line-clamp-2), tipo + distanza */}
            <div className="p-4">
                <h3 className="text-lg font-semibold mb-2 text-admin-text">
                    {corpo.nome}
                </h3>

                <div className="mb-3">
                    <CategoriaBadge categoria={corpo.categoria} />
                </div>

                <p className="text-sm leading-relaxed line-clamp-2 text-admin-dim">
                    {corpo.descrizione}
                </p>

                <div className="mt-3 flex items-center gap-3 text-xs text-admin-muted">
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
});
