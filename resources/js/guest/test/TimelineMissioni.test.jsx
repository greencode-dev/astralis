import { render, screen } from '@testing-library/react';
import TimelineMissioni from '../components/TimelineMissioni';

const mockMissioni = [
    {
        id: 1,
        nome: 'Apollo 11',
        stato: 'Completata',
        agenzia: 'NASA',
        data_lancio: '1969-07-16',
        logo_url: 'https://example.com/apollo.png',
    },
    {
        id: 2,
        nome: 'Mars 2020',
        stato: 'In corso',
        agenzia: 'NASA',
        data_lancio: '2020-07-30',
        descrizione: 'Rover Perserverance.',
    },
    {
        id: 3,
        nome: 'Europa Clipper',
        stato: 'Pianificata',
        agenzia: 'NASA',
        pivot: { tipo_esplorazione: 'sorvolo', anno_arrivo: '2030' },
    },
];

describe('TimelineMissioni', () => {
    it('renders nothing when missioni is empty', () => {
        const { container } = render(<TimelineMissioni missioni={[]} />);
        expect(container.firstChild).toBeNull();
    });

    it('renders nothing when missioni is null', () => {
        const { container } = render(<TimelineMissioni missioni={null} />);
        expect(container.firstChild).toBeNull();
    });

    it('renders all mission names', () => {
        render(<TimelineMissioni missioni={mockMissioni} />);
        expect(screen.getByText('Apollo 11')).toBeInTheDocument();
        expect(screen.getByText('Mars 2020')).toBeInTheDocument();
        expect(screen.getByText('Europa Clipper')).toBeInTheDocument();
    });

    it('renders stato badges', () => {
        render(<TimelineMissioni missioni={mockMissioni} />);
        expect(screen.getByText('Completata')).toBeInTheDocument();
        expect(screen.getByText('In corso')).toBeInTheDocument();
        expect(screen.getByText('Pianificata')).toBeInTheDocument();
    });

    it('renders agency when present', () => {
        render(<TimelineMissioni missioni={mockMissioni} />);
        const agencies = screen.getAllByText('NASA');
        expect(agencies.length).toBe(3);
    });

    it('renders pivot data when present', () => {
        render(<TimelineMissioni missioni={mockMissioni} />);
        expect(screen.getByText('sorvolo')).toBeInTheDocument();
        expect(screen.getByText('— 2030')).toBeInTheDocument();
    });

    it('renders logo image when logo_url is present', () => {
        render(<TimelineMissioni missioni={mockMissioni} />);
        const img = screen.getByRole('img', { name: 'Apollo 11' });
        expect(img).toHaveAttribute('src', 'https://example.com/apollo.png');
    });

    it('renders fallback icon when no logo_url', () => {
        render(<TimelineMissioni missioni={mockMissioni} />);
        expect(screen.getByRole('img', { name: 'Logo Mars 2020' })).toBeInTheDocument();
    });
});
