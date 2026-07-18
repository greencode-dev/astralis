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

    it('renders planet names as clickable links', () => {
        renderWithRouter(<SolarSystem />);
        const planets = ['Mercurio', 'Venere', 'Terra', 'Marte', 'Giove', 'Saturno', 'Urano', 'Nettuno'];
        const links = screen.getAllByRole('link');
        planets.forEach(name => {
            const link = links.find(el => el.textContent.trim() === name);
            expect(link).toBeTruthy();
            expect(link.getAttribute('href')).toBe(`/corpi-celesti/${name.toLowerCase()}`);
        });
    });

    it('renders Sun as a clickable link', () => {
        renderWithRouter(<SolarSystem />);
        const sunLink = screen.getAllByRole('link').find(el => el.textContent.trim() === 'Sole');
        expect(sunLink).toBeTruthy();
        expect(sunLink.getAttribute('href')).toBe('/corpi-celesti/sole');
    });

    it('renders 9 links total (8 planets + 1 sun)', () => {
        renderWithRouter(<SolarSystem />);
        const links = screen.getAllByRole('link');
        expect(links).toHaveLength(9);
    });
});
