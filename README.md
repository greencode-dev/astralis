<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/React-20232A?style=for-the-badge&logo=react&logoColor=61DAFB" alt="React">
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

# 🪐 Astralis — Catalogo di Corpi Celesti

Astralis è un'applicazione web full-stack per esplorare e gestire un catalogo di corpi celesti: pianeti, stelle, galassie, nebulose, lune, comete e asteroidi.

Un progetto sviluppato per l'esame finale del corso **Full-Stack Web Developer**.

## ✨ Funzionalità

### 👨‍💼 Backoffice (Laravel + Blade)

- Autenticazione con Laravel Breeze
- CRUD completo per: Categorie, Corpi Celesti, Missioni Spaziali, Galleria Immagini, Curiosità
- Upload di immagini con Intervention
- Dashboard con statistiche

### 🌟 Frontend (React + Vite)

- Sistema solare animato con orbite dei pianeti
- Lista e dettaglio di ogni corpo celeste con dati scientifici
- Galleria immagini con lightbox a schermo intero
- Timeline delle missioni spaziali
- Comparatore di pianeti (confronta massa, diametro, temperatura, gravità)
- Filtri per categoria, tipo e ricerca testuale
- Badge colorati per ogni categoria

### 🛰️ API REST

- 10+ endpoint JSON per il frontend React
- Filtri, paginazione, eager loading delle relazioni

## 🏗️ Architettura

```
┌─────────────────────────────────────────────────────┐
│                     Frontend React                    │
│         (Vite + Tailwind + framer-motion)            │
└────────────────────┬────────────────────────────────┘
                     │ API JSON
┌────────────────────▼────────────────────────────────┐
│                   Laravel Backend                     │
│     (Breeze Auth + Eloquent + Controllers)           │
└────────────────────┬────────────────────────────────┘
                     │
┌────────────────────▼────────────────────────────────┐
│                    MySQL DB                           │
│    (6 tabelle: categorie, corpi_celesti, galleria,   │
│     missioni, corpo_celeste_missione, curiosita)     │
└─────────────────────────────────────────────────────┘
```

## 🗄️ Entità e Relazioni

| Entità            | Descrizione                  | Relazioni                                                |
| ----------------- | ---------------------------- | -------------------------------------------------------- |
| **Categoria**     | Pianeta, Stella, Galassia... | 1-N con Corpo Celeste                                    |
| **Corpo Celeste** | Dati scientifici del corpo   | N-1 Categoria, N-N Missioni, 1-N Galleria, 1-N Curiosità |
| **Missione**      | Missioni spaziali            | N-N con Corpi Celesti                                    |
| **Galleria**      | Immagini multiple            | N-1 con Corpo Celeste                                    |
| **Curiosità**     | Fatti e scoperte             | N-1 con Corpo Celeste                                    |

## 🎨 Palette Colori

| Ruolo    | Colore    |
| -------- | --------- |
| Sfondo   | `#0A0A1A` |
| Card     | `#111128` |
| Testo    | `#F0F0FA` |
| Primario | `#22D3EE` |

## 🛠️ Installazione

```bash
# Clona il repository
git clone https://github.com/tuo-username/astralis.git
cd astralis

# PHP dependencies
composer install

# JavaScript dependencies
npm install

# Configura ambiente
cp .env.example .env
php artisan key:generate
# Configura .env: DB_DATABASE=astralis, DB_PORT=3307

# Database
php artisan migrate --seed

# Storage per upload
php artisan storage:link

# Avvia (due terminali)
php artisan serve
npm run dev
```

## 🚀 Accesso

- **Frontend**: `http://localhost:8000`
- **Backoffice**: `http://localhost:8000/admin`
- **Credenziali demo**: admin@astralis.it / password

## 📚 Documentazione

La documentazione completa del progetto è disponibile in [`docs/progetto.md`](docs/progetto.md).

## 🔮 Sviluppi Futuri

- Integrazione con NASA API per immagini in tempo reale
- Dark/light mode toggle
- Multi-lingua (IT/EN)
- Dashboard admin con grafici
- Sistema di rating per corpi celesti

## 📄 Licenza

Progetto open-source con licenza MIT.
