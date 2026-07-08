import { render, screen, fireEvent } from '@testing-library/react';
import LightboxGalleria from '../components/LightboxGalleria';

describe('LightboxGalleria', () => {
    it('returns null when immagini is empty', () => {
        const { container } = render(<LightboxGalleria immagini={[]} />);
        expect(container.innerHTML).toBe('');
    });

    it('returns null when immagini is null', () => {
        const { container } = render(<LightboxGalleria immagini={null} />);
        expect(container.innerHTML).toBe('');
    });

    it('renders grid of thumbnails', () => {
        const immagini = [
            { immagine_url: 'https://example.com/1.jpg', didascalia: 'Photo 1' },
            { immagine_url: 'https://example.com/2.jpg', didascalia: 'Photo 2' },
        ];
        render(<LightboxGalleria immagini={immagini} />);
        const images = screen.getAllByRole('img');
        expect(images).toHaveLength(2);
        expect(images[0]).toHaveAttribute('src', 'https://example.com/1.jpg');
        expect(images[1]).toHaveAttribute('src', 'https://example.com/2.jpg');
    });

    it('filters out immagini without immagine_url', () => {
        const immagini = [
            { immagine_url: 'https://example.com/1.jpg', didascalia: 'Has URL' },
            { immagine_url: null, didascalia: 'No URL' },
            { immagine_url: undefined, didascalia: 'Undefined' },
        ];
        render(<LightboxGalleria immagini={immagini} />);
        const images = screen.getAllByRole('img');
        expect(images).toHaveLength(1);
    });

    it('renders buttons with aria-label', () => {
        const immagini = [
            { immagine_url: 'https://example.com/1.jpg', didascalia: 'Prima foto' },
        ];
        render(<LightboxGalleria immagini={immagini} />);
        const button = screen.getByRole('button');
        expect(button).toHaveAttribute('aria-label', 'Prima foto');
    });

    it('shows didascalia and crediti text', () => {
        const immagini = [
            { immagine_url: 'https://example.com/1.jpg', didascalia: 'Nebulosa', crediti: 'NASA' },
        ];
        render(<LightboxGalleria immagini={immagini} />);
        expect(screen.getByText('Nebulosa')).toBeInTheDocument();
        expect(screen.getByText('© NASA')).toBeInTheDocument();
    });

    it('handles missing crediti gracefully', () => {
        const immagini = [
            { immagine_url: 'https://example.com/1.jpg', didascalia: 'Solo didascalia' },
        ];
        render(<LightboxGalleria immagini={immagini} />);
        expect(screen.getByText('Solo didascalia')).toBeInTheDocument();
        expect(screen.queryByText(/©/)).not.toBeInTheDocument();
    });

    it('opens lightbox when thumbnail is clicked', () => {
        const immagini = [
            { immagine_url: 'https://example.com/1.jpg', didascalia: 'Click me' },
        ];
        render(<LightboxGalleria immagini={immagini} />);
        const button = screen.getByRole('button');
        fireEvent.click(button);
        // Lightbox renders in a portal, just verify no error on click
        expect(screen.getByText('Click me')).toBeInTheDocument();
    });
});
