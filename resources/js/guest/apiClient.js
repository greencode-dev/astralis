import axios from 'axios';

const apiClient = axios.create({
    baseURL: '/api',
    headers: {
        'Accept': 'application/json',
    },
});

export function fetchCorpiCelesti(params = {}) {
    return apiClient.get('/corpi-celesti', { params }).then(res => res.data);
}

export function fetchCategorie() {
    return apiClient.get('/categorie').then(res => res.data);
}

export function fetchCorpoCeleste(slug) {
    return apiClient.get(`/corpi-celesti/${slug}`).then(res => res.data);
}

export function fetchSimili(id) {
    return apiClient.get(`/corpi-celesti/${id}/simili`).then(res => res.data);
}

export function fetchMissioni(params = {}) {
    return apiClient.get('/missioni', { params }).then(res => res.data);
}

export function fetchDashboardStats() {
    return apiClient.get('/dashboard/stats').then(res => res.data);
}