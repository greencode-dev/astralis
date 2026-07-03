<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleriaCorpoResource;
use App\Models\GalleriaCorpo;

class GalleriaController extends Controller
{
    public function index()
    {
        $galleria = GalleriaCorpo::with('corpoCeleste')
            ->orderBy('ordine')
            ->orderBy('created_at', 'desc')
            ->get();

        return GalleriaCorpoResource::collection($galleria);
    }
}
