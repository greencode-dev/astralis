<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CorpoCelesteResource;
use App\Models\CorpoCeleste;
use Illuminate\Http\Request;

class CorpoCelesteController extends Controller
{
    public function index(Request $request)
    {
        $query = CorpoCeleste::with(['categoria', 'galleria']);

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
                  ->orWhere('descrizione', 'like', "%{$search}%");
            });
        }

        if ($request->boolean('in_evidenza')) {
            $query->where('in_evidenza', true);
        }

        $perPage = max(1, min($request->integer('per_page', 12), 100));
        $corpiCelesti = $query->orderBy('nome')->paginate($perPage);

        return CorpoCelesteResource::collection($corpiCelesti);
    }

    public function show(CorpoCeleste $corpoCeleste)
    {
        $corpoCeleste->load(['categoria', 'galleria', 'curiosita', 'missioni']);

        return new CorpoCelesteResource($corpoCeleste);
    }

    public function simili(CorpoCeleste $corpoCeleste)
    {
        $simili = CorpoCeleste::with(['categoria', 'galleria'])
            ->where('categoria_id', $corpoCeleste->categoria_id)
            ->where('id', '!=', $corpoCeleste->id)
            ->orderBy('nome')
            ->limit(4)
            ->get();

        return CorpoCelesteResource::collection($simili);
    }
}
