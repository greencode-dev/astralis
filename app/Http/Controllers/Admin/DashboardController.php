<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\Curiosita;
use App\Models\Missione;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'corpi_celesti' => CorpoCeleste::count(),
            'categorie' => Categoria::count(),
            'missioni' => Missione::count(),
            'curiosita' => Curiosita::count(),
        ];

        $ultimiCorpi = CorpoCeleste::with('categoria')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'ultimiCorpi'));
    }
}
