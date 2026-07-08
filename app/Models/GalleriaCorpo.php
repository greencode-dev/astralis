<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GalleriaCorpo extends Model
{
    use HasFactory;
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

    public function getPercorsoUrlAttribute(): ?string
    {
        if (!$this->percorso) {
            return null;
        }
        return str_starts_with($this->percorso, 'http')
            ? $this->percorso
            : Storage::url('galleria/' . $this->percorso);
    }
}
