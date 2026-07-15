import { useEffect, useRef, useState } from 'react';

export function useInView(options = {}) {
    const ref = useRef(null);
    const [isVisible, setIsVisible] = useState(false);
    const optionsRef = useRef(options);
    optionsRef.current = options;

    useEffect(() => {
        const el = ref.current;
        if (!el) return;

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    setIsVisible(true);
                    observer.unobserve(el);
                }
            },
            { threshold: 0.1, ...optionsRef.current }
        );

        observer.observe(el);
        return () => observer.disconnect();
    }, []);

    return [ref, isVisible];
}
