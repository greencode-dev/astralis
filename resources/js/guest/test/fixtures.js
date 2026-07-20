// resources/js/guest/test/fixtures.js
// Shared test fixtures — import from here to avoid duplication across test files.

// ── Dashboard stats (used by apiClient.test.js, HomePage.test.jsx) ──────

export const mockStats = {
    totale_corpi_celesti: 150,
    totale_categorie: 8,
    totale_missioni: 25,
};

// ── Base corpo objects ──────────────────────────────────────────────────

export const terra = {
    id: 1,
    nome: 'Terra',
    slug: 'terra',
    descrizione: 'Il terzo pianeta del sistema solare.',
    immagine_url: 'https://example.com/earth.jpg',
    tipo: 'roccioso',
    massa_kg: '5.972e24',
    diametro_km: '12742',
    distanza_km: '150000000',
    gravita: '9.81',
    temperatura: '15',
    periodo_orbitale: '365.25',
    scopritore: null,
    anno_scoperta: null,
    in_evidenza: true,
    categoria: { nome: 'Pianeta' },
};

export const marte = {
    id: 2,
    nome: 'Marte',
    slug: 'marte',
    descrizione: 'Il pianeta rosso.',
    immagine_url: null,
    tipo: 'roccioso',
    massa_kg: '6.39e23',
    diametro_km: '6779',
    distanza_km: '228000000',
    gravita: '3.72',
    temperatura: '-65',
    periodo_orbitale: '687',
    scopritore: null,
    anno_scoperta: null,
    in_evidenza: false,
    categoria: { nome: 'Pianeta' },
};

export const venere = {
    id: 3,
    nome: 'Venere',
    slug: 'venere',
    descrizione: 'Il pianeta più caldo.',
    immagine_url: null,
    tipo: 'roccioso',
    massa_kg: '4.867e24',
    diametro_km: '12104',
    distanza_km: '108000000',
    gravita: '8.87',
    temperatura: '462',
    periodo_orbitale: '225',
    scopritore: null,
    anno_scoperta: null,
    in_evidenza: false,
    categoria: { nome: 'Pianeta' },
};

export const mercurio = {
    id: 4,
    nome: 'Mercurio',
    slug: 'mercurio',
    descrizione: 'Il pianeta più piccolo.',
    immagine_url: null,
    tipo: 'roccioso',
    massa_kg: '3.285e23',
    diametro_km: '4879',
    distanza_km: '57900000',
    gravita: '3.7',
    temperatura: '167',
    periodo_orbitale: '88',
    scopritore: null,
    anno_scoperta: null,
    in_evidenza: false,
    categoria: { nome: 'Pianeta' },
};

// ── Minimal corpo for CorpoCard (flat, no wrapper) ─────────────────────

export const baseCorpo = {
    slug: 'terra',
    nome: 'Terra',
    descrizione: 'Il nostro pianeta.',
    immagine_url: null,
    in_evidenza: false,
    tipo: 'roccioso',
    distanza_km: null,
    categoria: { nome: 'Pianeta' },
};

// ── Pianeti array (used by Comparatore) ─────────────────────────────────

export const pianeti = [mercurio, venere, terra, marte];

// ── API response wrappers ───────────────────────────────────────────────

export function makeCorpiResponse(corpi, meta = {}) {
    return {
        data: corpi,
        meta: { total: corpi.length, last_page: 1, ...meta },
    };
}

export function makeCorpoDetail(overrides = {}) {
    return { data: { ...terra, ...overrides } };
}

export function makeSimiliResponse(simili = [marte, venere]) {
    return { data: simili };
}

// ── CorpoDettaglio full mock (with relations) ──────────────────────────

export const mockCorpoDettaglio = {
    data: {
        ...terra,
        galleria: [
            { id: 1, immagine_url: 'https://example.com/gallery1.jpg', didascalia: 'Terra vista dallo spazio', crediti: 'NASA' },
        ],
        curiosita: [
            { id: 1, titolo: 'Fatto interessante', descrizione: "La Terra è l'unico pianeta conosciuto con vita.", fonte: 'Wikipedia' },
        ],
        missioni: [
            { id: 1, nome: 'Apollo 11', slug: 'apollo-11', agenzia: 'NASA', data_lancio: '1969-07-16', durata_giorni: 8, stato: 'completata', descrizione: 'Primo sbarco sulla Luna.', pivot: { tipo_partecipazione: 'destinazione' } },
        ],
    },
};

// ── Categorie (used by CorpiLista) ──────────────────────────────────────

export const mockCategorie = {
    data: [
        { id: 1, nome: 'Pianeta', slug: 'pianeti', corpi_count: 8 },
        { id: 2, nome: 'Stella', slug: 'stelle', corpi_count: 5 },
    ],
};
