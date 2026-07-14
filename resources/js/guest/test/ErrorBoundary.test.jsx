import { render, screen } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom';
import ErrorBoundary from '../components/ErrorBoundary';

function ProblemChild() {
    throw new Error('Test error');
}

function renderWithBoundary(ui) {
    return render(
        <MemoryRouter>
            <ErrorBoundary>
                {ui}
            </ErrorBoundary>
        </MemoryRouter>
    );
}

describe('ErrorBoundary', () => {
    it('renders children when no error', () => {
        renderWithBoundary(<div>OK content</div>);
        expect(screen.getByText('OK content')).toBeInTheDocument();
    });

    it('renders error UI when child throws', () => {
        const spy = vi.spyOn(console, 'error').mockImplementation(() => {});
        renderWithBoundary(<ProblemChild />);
        expect(screen.getByText('Qualcosa è andato storto')).toBeInTheDocument();
        spy.mockRestore();
    });

    it('renders retry button', () => {
        const spy = vi.spyOn(console, 'error').mockImplementation(() => {});
        renderWithBoundary(<ProblemChild />);
        expect(screen.getByRole('button', { name: /riprova/i })).toBeInTheDocument();
        spy.mockRestore();
    });

    it('renders home link', () => {
        const spy = vi.spyOn(console, 'error').mockImplementation(() => {});
        renderWithBoundary(<ProblemChild />);
        expect(screen.getByRole('link', { name: /torna alla home/i })).toHaveAttribute('href', '/');
        spy.mockRestore();
    });
});
