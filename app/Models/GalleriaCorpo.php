<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleriaCorpo extends Model
{
    protected $table = 'galleria_corpi';

    protected $fillable = [
        'corpo_celeste_id',
        'percorso',
        'didascalia',
        'crediti',
        'ordine',
    ];

    public function corpoCeleste(): BelongsTo
    {
        return $this->belongsTo(CorpoCeleste::class);
    }
}
