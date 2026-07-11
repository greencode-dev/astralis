import { render, screen } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom';
import SolarSystem from '../components/SolarSystem';

function renderWithRouter(ui) {
    return render(<MemoryRouter>{ui}</MemoryRouter>);
}

describe('SolarSystem', () => {
    it('renders without crashing', () => {
        const { container } = renderWithRouter(<SolarSystem />);
        expect(container).toBeInTheDocument();
    });

    it('renders the Sun label', () => {
        renderWithRouter(<SolarSystem />);
        expect(screen.getByText('Sole')).toBeInTheDocument();
    });

    it('renders all 8 planet names', () => {
        renderWithRouter(<SolarSystem />);
        const planets = ['Mercurio', 'Venere', 'Terra', 'Marte', 'Giove', 'Saturno', 'Urano', 'Nettuno'];
        planets.forEach(name => {
            expect(screen.getByText(name)).toBeInTheDocument();
        });
    });

    it('renders 8 orbit rings', () => {
        const { container } = renderWithRouter(<SolarSystem />);
        const orbitRings = container.querySelectorAll('.rounded-full.border');
        const adminBorder = Array.from(orbitRings).filter(el =>
            Array.from(el.classList).some(c => c.startsWith('border-admin-primary'))
        );
        expect(adminBorder).toHaveLength(8);
    });
});
