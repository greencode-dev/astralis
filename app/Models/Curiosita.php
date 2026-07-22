<?php
// Model: titolo, descrizione, fonte. BelongsTo(CorpoCeleste). 18 curiosità sulle 5 entità

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Curiosita extends Model
{
    // Traits: HasFactory
    use HasFactory;
    // Table: curiosita
    protected $table = 'curiosita';

    // Fillable: corpo_celeste_id, titolo, descrizione, fonte
    protected $fillable = [
        'corpo_celeste_id',
        'titolo',
        'descrizione',
        'fonte',
    ];

    // Relazione: BelongsTo CorpoCeleste
    public function corpoCeleste(): BelongsTo
    {
        return $this->belongsTo(CorpoCeleste::class);
    }
}
