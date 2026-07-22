<?php
// Registra 5 Policy + Gate 'admin' (is_admin). Bootstrap autorizzazione

namespace App\Providers;

use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\Curiosita;
use App\Models\GalleriaCorpo;
use App\Models\Missione;
use App\Models\User;
use App\Policies\CategoriaPolicy;
use App\Policies\CorpoCelestePolicy;
use App\Policies\CuriositaPolicy;
use App\Policies\GalleriaCorpoPolicy;
use App\Policies\MissionePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    // Policies: 5 mapping model → policy (Categoria, CorpoCeleste, Missione, Curiosita, GalleriaCorpo)
    protected $policies = [
        Categoria::class => CategoriaPolicy::class,
        CorpoCeleste::class => CorpoCelestePolicy::class,
        Missione::class => MissionePolicy::class,
        Curiosita::class => CuriositaPolicy::class,
        GalleriaCorpo::class => GalleriaCorpoPolicy::class,
    ];

    public function boot(): void
    {
        // Gate 'admin': restituisce $user->is_admin (boolean)
        Gate::define('admin', fn (User $user) => $user->is_admin);
    }
}
