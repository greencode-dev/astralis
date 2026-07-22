<?php
// Model: percorso (URL remoto NASA o file locale), didascalia, crediti, ordine. BelongsTo(CorpoCeleste)

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GalleriaCorpo extends Model
{
    // Traits: HasFactory
    use HasFactory;
    // Table: galleria_corpi
    protected $table = 'galleria_corpi';

    // Fillable: corpo_celeste_id, percorso (URL/file), didascalia, crediti, ordine
    protected $fillable = [
        'corpo_celeste_id',
        'percorso',
        'didascalia',
        'crediti',
        'ordine',
    ];

    // Relazione: BelongsTo CorpoCeleste
    public function corpoCeleste(): BelongsTo
    {
        return $this->belongsTo(CorpoCeleste::class);
    }

    // Accessor: percorso_url — URL remoto o Storage::url('galleria/...')
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
