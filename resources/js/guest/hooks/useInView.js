import { useEffect, useRef, useState, useCallback } from 'react';

export function useInView(options = {}) {
    const [isVisible, setIsVisible] = useState(false);
    const optionsRef = useRef(options);
    optionsRef.current = options;
    const observerRef = useRef(null);

    const ref = useCallback((node) => {
        if (observerRef.current) {
            observerRef.current.disconnect();
            observerRef.current = null;
        }

        if (!node) return;

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    setIsVisible(true);
                    observer.unobserve(node);
                }
            },
            { threshold: 0.1, ...optionsRef.current }
        );

        observer.observe(node);
        observerRef.current = observer;
    }, []);

    useEffect(() => {
        return () => {
            if (observerRef.current) {
                observerRef.current.disconnect();
            }
        };
    }, []);

    return [ref, isVisible];
}
