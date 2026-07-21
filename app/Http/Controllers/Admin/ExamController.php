<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\Curiosita;
use App\Models\GalleriaCorpo;
use App\Models\Missione;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ExamController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', CorpoCeleste::class);

        $stats = [
            'corpi_celesti' => CorpoCeleste::count(),
            'categorie' => Categoria::count(),
            'missioni' => Missione::count(),
            'curiosita' => Curiosita::count(),
            'galleria' => GalleriaCorpo::count(),
            'pivot_missioni' => DB::table('corpo_celeste_missione')->count(),
        ];

        $endpoints = [
            ['method' => 'GET', 'path' => '/api/corpi-celesti', 'desc' => 'Lista filtrata con paginazione'],
            ['method' => 'GET', 'path' => '/api/corpi-celesti/{slug}', 'desc' => 'Dettaglio con relazioni eager-loaded'],
            ['method' => 'GET', 'path' => '/api/corpi-celesti/{slug}/simili', 'desc' => 'Corpi simili (stessa categoria)'],
            ['method' => 'GET', 'path' => '/api/categorie', 'desc' => 'Tutte le categorie con conteggio'],
            ['method' => 'GET', 'path' => '/api/categorie/{slug}', 'desc' => 'Singola categoria con corpi'],
            ['method' => 'GET', 'path' => '/api/missioni', 'desc' => 'Lista missioni filtrata'],
            ['method' => 'GET', 'path' => '/api/missioni/{slug}', 'desc' => 'Dettaglio missione con corpi'],
            ['method' => 'GET', 'path' => '/api/curiosita', 'desc' => 'Lista curiosità'],
            ['method' => 'GET', 'path' => '/api/galleria', 'desc' => 'Galleria ordinata'],
            ['method' => 'GET', 'path' => '/api/dashboard/stats', 'desc' => 'Statistiche homepage'],
        ];

        return view('admin.exam.index', compact('stats', 'endpoints'));
    }
}
