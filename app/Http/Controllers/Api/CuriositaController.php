<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CuriositaResource;
use App\Models\Curiosita;
use Illuminate\Http\Request;

class CuriositaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = max(1, min($request->integer('per_page', 20), 100));
        $curiosita = Curiosita::with('corpoCeleste')->orderBy('created_at', 'desc')->paginate($perPage);

        return CuriositaResource::collection($curiosita);
    }
}
