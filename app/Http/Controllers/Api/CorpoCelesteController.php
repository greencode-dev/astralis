<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CorpoCelesteResource;
use App\Models\CorpoCeleste;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CorpoCelesteController extends Controller
{
    public function index(Request $request)
    {
        $query = CorpoCeleste::with(['categoria']);

        if ($request->filled('categoria')) {
            $query->whereHas('categoria', function ($q) use ($request) {
                $q->where('slug', $request->categoria);
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('search')) {
            $search = static::escapeLike($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('nome_it', 'like', "%{$search}%")
                  ->orWhere('descrizione', 'like', "%{$search}%");
            });
        }

        if ($request->boolean('in_evidenza')) {
            $query->where('in_evidenza', true);
        }

        $page = $request->integer('page', 1);
        $perPage = max(1, min($request->integer('per_page', 12), 100));
        $cacheKey = 'api.corpi-celesti.' . md5(serialize($request->query()));

        $cachedIds = Cache::remember($cacheKey, 300, function () use ($query) {
            return $query->orderBy('nome')->pluck('id')->toArray();
        });

        $allCorpi = CorpoCeleste::with('categoria')
            ->whereIn('id', $cachedIds)
            ->orderBy('nome')
            ->get();

        $paginated = new LengthAwarePaginator(
            $allCorpi->forPage($page, $perPage),
            $allCorpi->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return CorpoCelesteResource::collection($paginated);
    }

    public function show(CorpoCeleste $corpoCeleste)
    {
        $corpoCeleste->load(['categoria', 'galleria', 'curiosita', 'missioni']);

        return new CorpoCelesteResource($corpoCeleste);
    }

    public function simili(CorpoCeleste $corpoCeleste)
    {
        $simili = CorpoCeleste::with(['categoria'])
            ->where('categoria_id', $corpoCeleste->categoria_id)
            ->where('id', '!=', $corpoCeleste->id)
            ->orderBy('nome')
            ->limit(4)
            ->get();

        return CorpoCelesteResource::collection($simili);
    }
}
