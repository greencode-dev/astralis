<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleriaCorpoResource;
use App\Models\GalleriaCorpo;
use Illuminate\Http\Request;

class GalleriaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = max(1, min($request->integer('per_page', 20), 100));
        $galleria = GalleriaCorpo::with('corpoCeleste')
            ->orderBy('ordine')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return GalleriaCorpoResource::collection($galleria);
    }
}
