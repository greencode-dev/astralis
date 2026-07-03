<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CuriositaResource;
use App\Models\Curiosita;

class CuriositaController extends Controller
{
    public function index()
    {
        $curiosita = Curiosita::with('corpoCeleste')->orderBy('created_at', 'desc')->get();

        return CuriositaResource::collection($curiosita);
    }
}
