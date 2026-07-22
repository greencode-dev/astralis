// Entry point React SPA: ReactDOM.createRoot + BrowserRouter. Avvia il guest frontend standalone
import '@vitejs/plugin-react/preamble';
import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';

// ReactDOM.createRoot: monta React in #guest-root, StrictMode per debug
ReactDOM.createRoot(document.getElementById('guest-root')).render(
    <React.StrictMode>
        <App />
    </React.StrictMode>
);