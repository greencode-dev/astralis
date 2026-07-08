<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Missione extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'missioni';

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

    protected function casts(): array
    {
        return [
            'data_lancio' => 'date',
            'durata_giorni' => 'integer',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nome')
            ->saveSlugsTo('slug');
    }

    public function corpiCelesti(): BelongsToMany
    {
        return $this->belongsToMany(CorpoCeleste::class, 'corpo_celeste_missione')
            ->withPivot('tipo_esplorazione', 'anno_arrivo')
            ->withTimestamps();
    }
}
