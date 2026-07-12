import { useState, useRef, useEffect, memo } from 'react';

export default memo(function LazyImage({ src, alt, className, fetchPriority, onError, ...props }) {
    const [loaded, setLoaded] = useState(false);
    const [inView, setInView] = useState(() => typeof IntersectionObserver === 'undefined');
    const imgRef = useRef(null);

    useEffect(() => {
        const node = imgRef.current;
        if (!node || inView) return;

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    setInView(true);
                    observer.unobserve(node);
                }
        },
            { rootMargin: '200px' }
        );

        observer.observe(node);
        return () => observer.disconnect();
    }, [inView]);

    return (
        <img
            ref={imgRef}
            src={inView ? src : undefined}
            alt={alt}
            className={className}
            fetchpriority={fetchPriority}
            loading="lazy"
            onLoad={() => setLoaded(true)}
            onError={onError}
            style={{ opacity: loaded ? 1 : 0, transition: 'opacity 0.3s' }}
            {...props}
        />
    );
});
