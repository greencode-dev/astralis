import { render, screen } from '@testing-library/react';
import SolarSystem from '../components/SolarSystem';

describe('SolarSystem', () => {
    it('renders without crashing', () => {
        const { container } = render(<SolarSystem />);
        expect(container).toBeInTheDocument();
    });

    it('renders the Sun label', () => {
        render(<SolarSystem />);
        expect(screen.getByText('Sole')).toBeInTheDocument();
    });

    it('renders all 8 planet names', () => {
        render(<SolarSystem />);
        const planets = ['Mercurio', 'Venere', 'Terra', 'Marte', 'Giove', 'Saturno', 'Urano', 'Nettuno'];
        planets.forEach(name => {
            expect(screen.getByText(name)).toBeInTheDocument();
        });
    });

    it('renders 8 orbit rings', () => {
        const { container } = render(<SolarSystem />);
        const orbits = container.querySelectorAll('.rounded-full');
        // Orbite hanno bordo visibile + rounded-full, mentre i pianeti no
        const orbitRings = Array.from(orbits).filter(el => el.style.border);
        expect(orbitRings).toHaveLength(8);
    });
});
