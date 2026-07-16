<?php

return [

    'nav_items' => [
        [
            'route' => 'admin.dashboard',
            'label' => 'Dashboard',
            'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        ],
        [
            'route' => 'admin.corpi-celesti.index',
            'label' => 'Corpi Celesti',
            'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        ],
        [
            'route' => 'admin.categorie.index',
            'label' => 'Categorie',
            'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
        ],
        [
            'route' => 'admin.missioni.index',
            'label' => 'Missioni',
            'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        [
            'route' => 'admin.curiosita.index',
            'label' => 'Curiosità',
            'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        [
            'route' => 'admin.galleria.index',
            'label' => 'Galleria',
            'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
        ],
        [
            'route' => 'admin.nasa-import.index',
            'label' => 'NASA Import',
            'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
        ],
    ],

    'mission_stati' => [
        'Completata' => ['bg' => 'rgba(34,197,94,0.15)', 'text' => 'var(--admin-success)'],
        'In corso' => ['bg' => 'rgba(34,211,238,0.15)', 'text' => 'var(--admin-primary)'],
        'Pianificata' => ['bg' => 'rgba(250,204,21,0.15)', 'text' => 'var(--admin-warning)'],
    ],

    'mission_stato_default' => ['bg' => 'rgba(107,114,128,0.15)', 'text' => 'var(--admin-neutral)'],

    'color_presets' => ['#22D3EE', '#A855F7', '#F97316', '#FACC15', '#22C55E', '#EF4444', '#F472B6', '#94A3B8', '#78716C', '#6B7280'],

];
