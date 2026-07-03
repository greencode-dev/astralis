<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorie = Categoria::withCount('corpiCelesti')->orderBy('nome')->get();

        return CategoriaResource::collection($categorie);
    }

    public function show(Categoria $categoria)
    {
        $categoria->load(['corpiCelesti.galleria', 'corpiCelesti.categoria']);

        return new CategoriaResource($categoria);
    }
}
