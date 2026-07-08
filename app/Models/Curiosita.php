<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Curiosita extends Model
{
    use HasFactory;
    protected $table = 'curiosita';

    protected $fillable = [
        'corpo_celeste_id',
        'titolo',
        'descrizione',
        'fonte',
    ];

    public function corpoCeleste(): BelongsTo
    {
        return $this->belongsTo(CorpoCeleste::class);
    }
}
