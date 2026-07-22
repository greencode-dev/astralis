<?php
// Model: nome, slug, logo, agenzia, data_lancio, stato. BelongsToMany(CorpoCeleste) con pivot. 10 missioni reali

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Missione extends Model
{
    // Traits: HasFactory + HasSlug
    use HasFactory, HasSlug;

    // Table: missioni
    protected $table = 'missioni';

    // Fillable: nome, slug, logo, agenzia, data_lancio, durata, stato, descrizione, sito_web
    protected $fillable = [
        'nome',
        'slug',
        'logo',
        'agenzia',
        'data_lancio',
        'durata_giorni',
        'stato',
        'descrizione',
        'sito_web',
    ];

    // Casts: data_lancio → Carbon, durata_giorni → integer
    protected function casts(): array
    {
        return [
            'data_lancio' => 'date',
            'durata_giorni' => 'integer',
        ];
    }

    // Slug: genera da 'nome'
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nome')
            ->saveSlugsTo('slug');
    }

    // Relazione: BelongsToMany CorpoCeleste via pivot, con pivot fields + timestamps
    public function corpiCelesti(): BelongsToMany
    {
        return $this->belongsToMany(CorpoCeleste::class, 'corpo_celeste_missione')
            ->withPivot('tipo_esplorazione', 'anno_arrivo')
            ->withTimestamps();
    }
}
