<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MissioneResource;
use App\Models\Missione;
use Illuminate\Http\Request;

class MissioneController extends Controller
{
    public function index(Request $request)
    {
        $query = Missione::query();

        if ($request->filled('agenzia')) {
            $query->where('agenzia', $request->agenzia);
        }

        if ($request->filled('stato')) {
            $query->where('stato', $request->stato);
        }

        $missioni = $query->with('corpiCelesti')->orderBy('data_lancio', 'desc')->get();

        return MissioneResource::collection($missioni);
    }

    public function show(Missione $missione)
    {
        $missione->load(['corpiCelesti.categoria', 'corpiCelesti.galleria']);

        return new MissioneResource($missione);
    }
}
