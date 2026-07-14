const mockGet = vi.hoisted(() => vi.fn());

vi.mock('axios', () => ({
    default: {
        create: vi.fn(() => ({
            get: mockGet,
            interceptors: {
                response: { use: vi.fn() },
            },
        })),
    },
}));

import axios from 'axios';
import { mockStats } from './fixtures';
import {
    fetchCorpiCelesti,
    fetchCategorie,
    fetchCorpoCeleste,
    fetchSimili,
    fetchDashboardStats,
} from '../apiClient';

describe('apiClient', () => {
    beforeEach(() => {
        mockGet.mockReset();
    });

    afterEach(() => {
        vi.clearAllMocks();
    });

    describe('fetchCorpiCelesti', () => {
        it('calls GET /corpi-celesti with params', async () => {
            const mockData = { data: [{ id: 1, nome: 'Terra' }], meta: { total: 1 } };
            mockGet.mockResolvedValue({ data: mockData });

            const result = await fetchCorpiCelesti({ categoria: 'pianeti', per_page: 12 });

            expect(mockGet).toHaveBeenCalledWith('/corpi-celesti', { params: { categoria: 'pianeti', per_page: 12 }, signal: undefined });
            expect(result).toEqual(mockData);
        });

        it('calls with default empty params', async () => {
            mockGet.mockResolvedValue({ data: { data: [] } });

            await fetchCorpiCelesti();

            expect(mockGet).toHaveBeenCalledWith('/corpi-celesti', { params: {}, signal: undefined });
        });

        it('unwraps res.data correctly on success', async () => {
            const response = { data: { data: [{ id: 1, nome: 'Marte' }], meta: { last_page: 1, total: 1 } } };
            mockGet.mockResolvedValue(response);

            const result = await fetchCorpiCelesti();

            expect(result).toEqual(response.data);
        });
    });

    describe('fetchCategorie', () => {
        it('calls GET /categorie and unwraps data', async () => {
            const categorie = { data: [{ id: 1, nome: 'Pianeta', slug: 'pianeti' }] };
            mockGet.mockResolvedValue({ data: categorie });

            const result = await fetchCategorie();

            expect(mockGet).toHaveBeenCalledWith('/categorie', { signal: undefined });
            expect(result).toEqual(categorie);
        });
    });

    describe('fetchCorpoCeleste', () => {
        it('calls GET /corpi-celesti/{slug}', async () => {
            const corpo = { data: { id: 1, nome: 'Terra', slug: 'terra' } };
            mockGet.mockResolvedValue({ data: corpo });

            const result = await fetchCorpoCeleste('terra');

            expect(mockGet).toHaveBeenCalledWith('/corpi-celesti/terra', { signal: undefined });
            expect(result).toEqual(corpo);
        });

        it('handles different slugs correctly', async () => {
            mockGet.mockResolvedValue({ data: { data: { id: 2, slug: 'giove' } } });

            await fetchCorpoCeleste('giove');

            expect(mockGet).toHaveBeenCalledWith('/corpi-celesti/giove', { signal: undefined });
        });
    });

    describe('fetchSimili', () => {
        it('calls GET /corpi-celesti/{id}/simili', async () => {
            const simili = { data: [{ id: 2, nome: 'Marte' }] };
            mockGet.mockResolvedValue({ data: simili });

            const result = await fetchSimili(1);

            expect(mockGet).toHaveBeenCalledWith('/corpi-celesti/1/simili', { signal: undefined });
            expect(result).toEqual(simili);
        });

        it('uses numeric id in URL', async () => {
            mockGet.mockResolvedValue({ data: { data: [] } });

            await fetchSimili(42);

            expect(mockGet).toHaveBeenCalledWith('/corpi-celesti/42/simili', { signal: undefined });
        });
    });

    describe('fetchDashboardStats', () => {
        it('calls GET /dashboard/stats', async () => {
            mockGet.mockResolvedValue({ data: mockStats });

            const result = await fetchDashboardStats();

            expect(mockGet).toHaveBeenCalledWith('/dashboard/stats', { signal: undefined });
            expect(result).toEqual(mockStats);
        });
    });
});
