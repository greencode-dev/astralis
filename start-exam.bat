@echo off
title Astralis — Avvio Esame
echo.
echo ========================================
echo   ASTRALIS — Avvio Esame
echo ========================================
echo.

cd /d "%~dp0"

echo [1/3] Database reset...
php artisan migrate:fresh --seed
echo.

echo [2/3] Avvio server Laravel (porta 8000)...
start "Laravel Server" cmd /k "php artisan serve"
timeout /t 2 /nobreak >nul

echo [3/3] Avvio Vite dev server (porta 5175)...
start "Vite Dev" cmd /k "npm run dev"
timeout /t 3 /nobreak >nul

echo.
echo ========================================
echo   TUTTI I SERVER SONO ATTIVI
echo ========================================
echo.
echo   Backend:  http://localhost:8000
echo   Frontend: http://localhost:5175
echo   Admin:    http://localhost:8000/admin
echo   Exam:     http://localhost:8000/admin/exam
echo   Login:    admin@astralis.it / password
echo.
echo   Premi INVIO per aprire il browser...
pause >nul
start http://localhost:8000/admin/exam
