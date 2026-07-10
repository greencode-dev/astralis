import { useState } from 'react';
import Lightbox from 'yet-another-react-lightbox';
import 'yet-another-react-lightbox/styles.css';
import { Image } from 'lucide-react';

function Thumbnail({ slide, index, onOpen }) {
    const [error, setError] = useState(false);

    return (
        <button
            onClick={() => onOpen(index)}
            className="relative group rounded-xl overflow-hidden transition-all duration-300 hover:border-[rgba(34,211,238,0.4)] hover:scale-[1.02]"
            style={{ backgroundColor: '#111128', border: '1px solid rgba(34, 211, 238, 0.1)' }}
            aria-label={slide.didascalia || 'Apri immagine nella galleria'}
        >
            <div className="aspect-[4/3] overflow-hidden">
                {!error ? (
                    <img loading="lazy"
                        src={slide.src}
                        alt={slide.alt}
                        className="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                        onError={() => setError(true)}
                    />
                ) : (
                    <div className="w-full h-full flex items-center justify-center" style={{ background: '#111128' }}>
                        <Image size={32} style={{ color: '#7A7A9A' }} aria-hidden="true" />
                    </div>
                )}
            </div>
            <div className="absolute inset-0 flex items-end p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                style={{ background: 'linear-gradient(transparent 50%, rgba(0,0,0,0.8))' }}>
                <div className="text-left">
                    <p className="text-sm font-medium" style={{ color: '#F0F0FA' }}>{slide.didascalia}</p>
                    {slide.crediti && (
                        <p className="text-xs mt-0.5" style={{ color: '#B8B8D0' }}>© {slide.crediti}</p>
                    )}
                </div>
            </div>
        </button>
    );
}

export default function LightboxGalleria({ immagini }) {
    const [open, setOpen] = useState(false);
    const [index, setIndex] = useState(0);

    const slides = (immagini || [])
        .filter(img => img.immagine_url)
        .map(img => ({ src: img.immagine_url, alt: img.didascalia, didascalia: img.didascalia, crediti: img.crediti }));

    if (slides.length === 0) return null;

    return (
        <div>
            <div className="grid grid-cols-2 md:grid-cols-3 gap-4">
                {slides.map((slide, i) => (
                    <Thumbnail key={i} slide={slide} index={i} onOpen={(idx) => { setIndex(idx); setOpen(true); }} />
                ))}
            </div>

            <Lightbox
                open={open}
                close={() => setOpen(false)}
                index={index}
                slides={slides}
                styles={{ container: { backgroundColor: 'rgba(10, 10, 26, 0.95)' } }}
                render={{
                    buttonPrev: () => null,
                    buttonNext: () => null,
                }}
            />
        </div>
    );
}